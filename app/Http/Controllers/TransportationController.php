<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Train;
use App\Models\Airport;
use App\Models\TrainStation;
use App\Models\FlightBooking;
use App\Models\TrainBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransportationController extends Controller
{
    // ── SEARCH PAGE ───────────────────────────────────────────

    public function index(Request $request)
    {
        $airports = Airport::orderBy('city')->get();
        $stations = TrainStation::orderBy('city')->get();

        $flights = collect();
        $trains  = collect();
        $searched = false;

        $type = $request->get('type', 'flight');

        if ($request->filled('from') && $request->filled('to') && $request->filled('date')) {
            $searched = true;

            if ($type === 'flight') {
                $flights = Flight::with(['airline', 'origin', 'destination'])
                    ->where('origin_id', $request->from)
                    ->where('destination_id', $request->to)
                    ->where('is_active', 1)
                    ->orderBy('departure_time')
                    ->get()
                    ->filter(function($flight) use ($request) {
                        // Simple day-of-week filter for demo
                        return $flight->days_of_week === 'daily'
                            || str_contains($flight->days_of_week, now()->parse($request->date)->dayOfWeek);
                    });
            } else {
                $trains = Train::with(['origin', 'destination'])
                    ->where('origin_id', $request->from)
                    ->where('destination_id', $request->to)
                    ->where('is_active', 1)
                    ->orderBy('departure_time')
                    ->get();
            }
        }

        return view('transportation.index', compact(
            'airports', 'stations', 'flights', 'trains', 'searched', 'type'
        ));
    }

    // ── FLIGHT BOOKING FORM ───────────────────────────────────

    public function bookFlight($flightId, Request $request)
    {
        $flight = Flight::with(['airline', 'origin', 'destination'])->findOrFail($flightId);
        $date   = $request->get('date', date('Y-m-d'));
        $class  = $request->get('class', 'economy');

        return view('transportation.book_flight', compact('flight', 'date', 'class'));
    }

    public function storeFlight(Request $request)
    {
        $validated = $request->validate([
            'flight_id'           => 'required|exists:flights,id',
            'travel_date'         => 'required|date|after_or_equal:today',
            'seat_class'          => 'required|in:economy,business',
            'passengers'          => 'required|integer|min:1|max:9',
            'passenger_name'      => 'required|string|max:255',
            'passenger_id_number' => 'required|string|max:50',
            'contact_phone'       => 'required|string|max:20',
        ]);

        $flight = Flight::findOrFail($validated['flight_id']);
        $price  = $validated['seat_class'] === 'business'
            ? $flight->price_business
            : $flight->price_economy;

        $total = $price * $validated['passengers'];

        $booking = FlightBooking::create([
            'user_id'             => Auth::id(),
            'flight_id'           => $validated['flight_id'],
            'travel_date'         => $validated['travel_date'],
            'seat_class'          => $validated['seat_class'],
            'passengers'          => $validated['passengers'],
            'total_price'         => $total,
            'passenger_name'      => $validated['passenger_name'],
            'passenger_id_number' => $validated['passenger_id_number'],
            'contact_phone'       => $validated['contact_phone'],
            'status'              => 'pending',
            'booking_code'        => FlightBooking::generateCode(),
        ]);

        return redirect()->route('transportation.flight.confirm', $booking->id)
            ->with('success', 'Tiket berhasil dipesan! Kode: ' . $booking->booking_code);
    }

    public function confirmFlight($id)
    {
        $booking = FlightBooking::with(['flight.airline', 'flight.origin', 'flight.destination'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('transportation.confirm_flight', compact('booking'));
    }

    // ── TRAIN BOOKING FORM ────────────────────────────────────

    public function bookTrain($trainId, Request $request)
    {
        $train = Train::with(['origin', 'destination'])->findOrFail($trainId);
        $date  = $request->get('date', date('Y-m-d'));

        return view('transportation.book_train', compact('train', 'date'));
    }

    public function storeTrain(Request $request)
    {
        $validated = $request->validate([
            'train_id'            => 'required|exists:trains,id',
            'travel_date'         => 'required|date|after_or_equal:today',
            'passengers'          => 'required|integer|min:1|max:9',
            'passenger_name'      => 'required|string|max:255',
            'passenger_id_number' => 'required|string|max:50',
            'contact_phone'       => 'required|string|max:20',
        ]);

        $train = Train::findOrFail($validated['train_id']);
        $total = $train->price * $validated['passengers'];

        $booking = TrainBooking::create([
            'user_id'             => Auth::id(),
            'train_id'            => $validated['train_id'],
            'travel_date'         => $validated['travel_date'],
            'passengers'          => $validated['passengers'],
            'total_price'         => $total,
            'passenger_name'      => $validated['passenger_name'],
            'passenger_id_number' => $validated['passenger_id_number'],
            'contact_phone'       => $validated['contact_phone'],
            'status'              => 'pending',
            'booking_code'        => TrainBooking::generateCode(),
        ]);

        return redirect()->route('transportation.train.confirm', $booking->id)
            ->with('success', 'Tiket kereta berhasil dipesan! Kode: ' . $booking->booking_code);
    }

    public function confirmTrain($id)
    {
        $booking = TrainBooking::with(['train.origin', 'train.destination'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('transportation.confirm_train', compact('booking'));
    }

    // ── MY TRANSPORT BOOKINGS ─────────────────────────────────

    public function myBookings()
    {
        $flightBookings = FlightBooking::with(['flight.airline', 'flight.origin', 'flight.destination'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $trainBookings = TrainBooking::with(['train.origin', 'train.destination'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('transportation.my_bookings', compact('flightBookings', 'trainBookings'));
    }

    // ── CANCEL ────────────────────────────────────────────────

    public function cancelFlight($id)
    {
        $booking = FlightBooking::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);

        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Tiket ' . $booking->booking_code . ' berhasil dibatalkan.');
    }

    public function cancelTrain($id)
    {
        $booking = TrainBooking::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);

        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Tiket ' . $booking->booking_code . ' berhasil dibatalkan.');
    }
}