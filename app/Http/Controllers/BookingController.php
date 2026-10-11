<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Show the booking form for a specific room.
     * GET /booking/room/{roomId}
     */
    public function create($roomId)
    {
        $room  = Room::with('place')->findOrFail($roomId);
        $place = $room->place;

        // Only hotels can be booked (category_id = 3)
        abort_if($place->category_id != 3, 404);

        return view('bookings.create', compact('room', 'place'));
    }

    /**
     * Store a new booking.
     * POST /booking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id'          => 'required|exists:rooms,id',
            'check_in'         => 'required|date|after_or_equal:today',
            'check_out'        => 'required|date|after:check_in',
            'guests'           => 'required|integer|min:1|max:10',
            'special_requests' => 'nullable|string|max:500',
        ]);

        $room = Room::with('place')->findOrFail($validated['room_id']);

        // Check room is still available for those dates
        if ($room->isBookedBetween($validated['check_in'], $validated['check_out'])) {
            return back()
                ->withInput()
                ->withErrors(['check_in' => 'Maaf, kamar ini sudah dipesan untuk tanggal tersebut. Silakan pilih tanggal lain.']);
        }

        // Calculate total price
        $checkIn   = \Carbon\Carbon::parse($validated['check_in']);
        $checkOut  = \Carbon\Carbon::parse($validated['check_out']);
        $nights    = $checkIn->diffInDays($checkOut);
        $total     = $nights * $room->price_per_night;

        $booking = Booking::create([
            'user_id'          => Auth::id(),
            'room_id'          => $room->id,
            'place_id'         => $room->place_id,
            'check_in'         => $validated['check_in'],
            'check_out'        => $validated['check_out'],
            'guests'           => $validated['guests'],
            'total_price'      => $total,
            'special_requests' => $validated['special_requests'] ?? null,
            'status'           => 'pending',
            'booking_code'     => Booking::generateCode(),
        ]);

        return redirect()->route('bookings.show', $booking->id)
            ->with('success', 'Booking berhasil! Kode booking kamu: ' . $booking->booking_code);
    }

    /**
     * Show a single booking confirmation/detail.
     * GET /booking/{id}
     */
    public function show($id)
    {
        $booking = Booking::with(['room', 'place', 'user'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('bookings.show', compact('booking'));
    }

    /**
     * User's booking history.
     * GET /my-bookings
     */
    public function myBookings()
    {
        $bookings = Booking::with(['room', 'place'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(8);

        $flightBookings = \App\Models\FlightBooking::with(['flight.airline','flight.origin','flight.destination'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $trainBookings = \App\Models\TrainBooking::with(['train.origin','train.destination'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('bookings.my', compact('bookings', 'flightBookings', 'trainBookings'));
    }

    /**
     * Cancel a booking (user can only cancel their own pending bookings).
     * POST /booking/{id}/cancel
     */
    public function cancel($id)
    {
        $booking = Booking::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking ' . $booking->booking_code . ' berhasil dibatalkan.');
    }

    /**
     * Admin: see all bookings and update status.
     * GET /admin/bookings
     */
    public function adminIndex(Request $request)
    {
        // Simple role check - only role_id 1 (Super Admin) or 2 (Place Admin)
        abort_if(Auth::user()->role_id > 2, 403);

        $query = Booking::with(['user', 'room', 'place'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('booking_code', 'like', '%' . $request->search . '%');
        }

        $bookings = $query->paginate(15)->withQueryString();
        return view('bookings.admin', compact('bookings'));
    }

    /**
     * Admin: update booking status.
     * POST /admin/bookings/{id}/status
     */
    public function updateStatus(Request $request, $id)
    {
        abort_if(Auth::user()->role_id > 2, 403);

        $request->validate(['status' => 'required|in:pending,confirmed,cancelled']);

        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Status booking ' . $booking->booking_code . ' berhasil diupdate.');
    }
}