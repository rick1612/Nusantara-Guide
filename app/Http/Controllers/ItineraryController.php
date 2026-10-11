<?php

namespace App\Http\Controllers;

use App\Models\ItineraryPost;
use App\Models\ItineraryDay;
use App\Models\ItineraryStop;
use App\Models\ItineraryCopy;
use App\Models\ItineraryComment;
use App\Models\Region;
use App\Models\Place;
use App\Models\Tag;
use App\Models\FlightBooking;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ItineraryController extends Controller
{
    // ── INDEX ──────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = ItineraryPost::with(['user','region.province','tags'])
            ->where('status','published')
            ->withCount(['likes','comments','copies']);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title','like',"%{$request->search}%")
                  ->orWhere('summary','like',"%{$request->search}%");
            });
        }
        if ($request->style)  $query->where('travel_style', $request->style);
        if ($request->days)   $query->where('duration_days', $request->days);

        $sort = $request->sort ?? 'latest';
        match($sort) {
            'popular'  => $query->orderByDesc('likes_count'),
            'most_copied' => $query->orderByDesc('copies_count'),
            default    => $query->latest(),
        };

        $itineraries = $query->paginate(12)->withQueryString();
        $regions = Region::with('province')->orderBy('name')->get();
        $tags    = Tag::orderBy('name')->get();
        return view('itineraries.index', compact('itineraries', 'regions', 'tags'));
    }

    // ── CREATE FORM ────────────────────────────────────────────
    public function create()
    {
        $regions = Region::with('province')->orderBy('name')->get();
        $tags    = Tag::orderBy('name')->get();
        $places  = Place::select('id','name','address','price_start','category_id')->orderBy('name')->get();

        // Grab user's flight bookings for linking
        $flightBookingsJson = [];
        $hotelBookingsJson  = [];
        $placesJson = $places->map(fn($p) => ['id'=>$p->id,'label'=>$p->name]);

        if (Auth::check()) {
            $fb = FlightBooking::where('user_id', Auth::id())
                ->whereIn('status',['confirmed','pending'])
                ->with('flight')
                ->get();
            $flightBookingsJson = $fb->map(fn($b) => [
                'id'             => $b->id,
                'airline'        => optional($b->flight)->airline ?? '',
                'flight_number'  => optional($b->flight)->flight_number ?? '',
                'route'          => (optional($b->flight)->origin_airport_id ?? '') . ' → ' .
                                   (optional($b->flight)->destination_airport_id ?? ''),
                'departure_time' => optional($b->flight)->departure_time
                                   ? \Carbon\Carbon::parse($b->flight->departure_time)->format('H:i')
                                   : '',
                'arrival_time'   => optional($b->flight)->arrival_time
                                   ? \Carbon\Carbon::parse($b->flight->arrival_time)->format('H:i')
                                   : '',
                'price'          => (float) ($b->total_price ?? 0),
                'passengers'     => $b->passengers ?? 1,
                'seat_class'     => $b->seat_class ?? 'economy',
                'label'          => (optional($b->flight)->airline ?? '') . ' ' .
                                   (optional($b->flight)->flight_number ?? '') . ' — ' .
                                   (optional($b->flight)->origin_airport_id ?? '') . '→' .
                                   (optional($b->flight)->destination_airport_id ?? '') .
                                   ' (' . $b->travel_date . ')' .
                                   ($b->status === 'pending' ? ' [Menunggu]' : ' ✓'),
            ]);

            $hb = Booking::where('user_id', Auth::id())
                ->whereIn('status',['confirmed','pending'])
                ->with('place','room')
                ->get();
            $hotelBookingsJson = $hb->map(fn($b) => [
                'id'         => $b->id,
                'hotel_name' => optional($b->place)->name ?? '',
                'room_name'  => optional($b->room)->name ?? '',
                'check_in'   => $b->check_in ?? '',
                'check_out'  => $b->check_out ?? '',
                'guests'     => $b->guests ?? 1,
                'price'      => (float) ($b->total_price ?? 0),
                'label'      => (optional($b->place)->name ?? '') . ' — ' .
                               (optional($b->room)->name ?? '') . ' (' .
                               ($b->check_in ?? '') . ' s/d ' . ($b->check_out ?? '') . ')' .
                               ($b->status === 'pending' ? ' [Menunggu]' : ' ✓'),
            ]);
        }

        // Train bookings
        $trainBookingsJson = [];
        if (Auth::check()) {
            $tb = \App\Models\TrainBooking::where('user_id', Auth::id())
                ->whereIn('status',['confirmed','pending'])
                ->with(['train.origin','train.destination'])
                ->get();
            $trainBookingsJson = $tb->map(fn($b) => [
                'id'             => $b->id,
                'train_name'     => optional($b->train)->name ?? '',
                'route'          => (optional(optional($b->train)->origin)->city ?? 
                                    optional(optional($b->train)->originStation)->name ?? 
                                    optional($b->train)->origin_id ?? '') . 
                                   ' → ' .
                                   (optional(optional($b->train)->destination)->city ?? 
                                    optional(optional($b->train)->destinationStation)->name ?? 
                                    optional($b->train)->destination_id ?? ''),
                'departure_time' => optional($b->train)->departure_time
                                   ? \Carbon\Carbon::parse($b->train->departure_time)->format('H:i')
                                   : '',
                'arrival_time'   => optional($b->train)->arrival_time
                                   ? \Carbon\Carbon::parse($b->train->arrival_time)->format('H:i')
                                   : '',
                'seat_class'     => $b->seat_class ?? 'economy',
                'passengers'     => $b->passengers ?? 1,
                'price'          => (float) ($b->total_price ?? 0),
                'label'          => (optional($b->train)->name ?? '') . ' — ' .
                                   (optional(optional($b->train)->origin)->city ?? optional($b->train)->origin_id ?? '') . '→' .
                                   (optional(optional($b->train)->destination)->city ?? optional($b->train)->destination_id ?? '') .
                                   ' (' . $b->travel_date . ')' .
                                   ($b->status === 'pending' ? ' [Menunggu]' : ' ✓'),
            ]);
        }

        return view('itineraries.create', compact(
            'regions','tags','flightBookingsJson','hotelBookingsJson',
            'trainBookingsJson','placesJson'
        ));
    }

    // ── STORE ──────────────────────────────────────────────────
    public function store(Request $request)
    {
        // Parse currency shorthand (3jt, 500rb, etc.) before validation
        $parseCurrency = function($val) {
            if (!$val) return 0;
            $val = strtolower(trim($val));
            if (preg_match('/^([\d.,]+)\s*j(t|uta)?$/', $val, $m)) {
                return (int) round((float) str_replace(',', '.', $m[1]) * 1000000);
            }
            if (preg_match('/^([\d.,]+)\s*r(b|ibu)?$/', $val, $m)) {
                return (int) round((float) str_replace(',', '.', $m[1]) * 1000);
            }
            return (int) preg_replace('/[^0-9]/', '', $val);
        };
        $request->merge([
            'estimated_budget' => $parseCurrency($request->estimated_budget),
            'actual_budget'    => $parseCurrency($request->actual_budget),
        ]);

        $request->validate([
            'title'         => 'required|string|max:255',
            'summary'       => 'required|string|max:500',
            'duration_days' => 'required|integer|min:1|max:30',
            'travel_style'  => 'required|string',
            'status'        => 'in:published,draft',
        ]);

        // Cover image
        $coverPath = null;
        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('itineraries','public');
        }

        // Create post
        $slug = Str::slug($request->title) . '-' . Str::random(5);
        $post = ItineraryPost::create([
            'user_id'          => Auth::id(),
            'region_id'        => $request->region_id ?: null,
            'title'            => $request->title,
            'slug'             => $slug,
            'summary'          => $request->summary,
            'body'             => $request->body,
            'trip_tips'        => $request->trip_tips,
            'travel_style'     => $request->travel_style,
            'duration_days'    => $request->duration_days,
            'estimated_budget' => $request->estimated_budget,
            'actual_budget'    => $request->actual_budget,
            'trip_rating'      => $request->trip_rating,
            'cover_image'      => $coverPath,
            'status'           => $request->status ?? 'published',
            'is_verified'      => false,
        ]);

        // Attach tags
        if ($request->tags) {
            $post->tags()->sync($request->tags);
        }

        // Create days & stops
        if ($request->days) {
            foreach ($request->days as $dayData) {
                $day = ItineraryDay::create([
                            'itinerary_id'      => $post->id,
                    'day_number'        => $dayData['number'] ?? 1,
                    'title'             => $dayData['title'] ?? null,
                    'notes'             => $dayData['notes'] ?? null,
                ]);

                if (!empty($dayData['stops'])) {
                    $order = 1;
                    foreach ($dayData['stops'] as $stopData) {
                        // Parse cost values from smart currency input
                        $stopCost      = (int) preg_replace('/[^0-9]/', '', $stopData['cost'] ?? '0');
                        $transportCost = (int) preg_replace('/[^0-9]/', '', $stopData['transport_cost'] ?? '0');
                        // Skip stops with no meaningful data
                        if (empty($stopData['type']) && empty($stopData['custom_title'])) continue;

                        ItineraryStop::create([
                            'day_id'              => $day->id,
                            'stop_type'           => $stopData['type'] ?? 'custom',
                            'place_id'            => ($stopData['place_id'] ?? null) ?: null,
                            'flight_booking_id'   => ($stopData['flight_booking_id'] ?? null) ?: null,
                            'hotel_booking_id'    => ($stopData['hotel_booking_id'] ?? null) ?: null,
                            'train_booking_id'    => ($stopData['train_booking_id'] ?? null) ?: null,
                            'custom_title'        => $stopData['custom_title'] ?? null,
                            'custom_place_name'   => $stopData['custom_place_name'] ?? null,
                            'custom_description'  => $stopData['custom_description'] ?? null,
                            'tip'                 => $stopData['tip'] ?? null,
                            'cost'                => $stopCost,
                            'time_start'          => ($stopData['time_start'] ?? null) ?: null,
                            'time_end'            => ($stopData['time_end'] ?? null) ?: null,
                            'transport_mode'      => $stopData['transport_mode'] ?? null,
                            'transport_cost'      => $transportCost,
                            'visit_order'         => $order++,
                        ]);
                    }
                }

                // Auto-verify if linked to real bookings
                $hasBooking = collect($dayData['stops'] ?? [])
                    ->filter(fn($s) => !empty($s['flight_booking_id']) || !empty($s['hotel_booking_id']))
                    ->isNotEmpty();
                if ($hasBooking) {
                    $post->update(['is_verified' => true]);
                }
            }
        }

        $msg = $request->status === 'draft'
            ? 'Draft itinerary disimpan.'
            : 'Itinerary berhasil dipublikasikan!';

        return redirect()->route('itinerary.show', $post->slug)
            ->with('success', $msg);
    }

    // ── SHOW ───────────────────────────────────────────────────
    public function show($slug)
    {
        $iti = ItineraryPost::with([
            'user','region.province','tags',
            'days.stops.place','days.stops.flightBooking','days.stops.hotelBooking',
        ])
        ->where('slug',$slug)
        ->where('status','published')
        ->firstOrFail();

        $iti->increment('views');

        $isLiked = Auth::check()
            ? \DB::table('itinerary_likes')
                ->where('itinerary_id',$iti->id)
                ->where('user_id',Auth::id())
                ->exists()
            : false;
        $isSaved = Auth::check()
            ? ItineraryCopy::where('original_itinerary_id',$iti->id)
                ->where('user_id',Auth::id())
                ->exists()
            : false;

        $comments   = ItineraryComment::where('itinerary_id',$iti->id)->latest()->get();
        $likesCount = \DB::table('itinerary_likes')->where('itinerary_id',$iti->id)->count();

        $itinerary = $iti; // alias for the view

        // Calculate total cost from all stops
        $totalCost = $iti->days->flatMap(fn($d) => $d->stops)->sum('cost');

        // Bookable stops (linked to real bookings)
        $bookableStops = $iti->days->flatMap(fn($d) => $d->stops)
            ->filter(fn($s) => $s->flight_booking_id || $s->hotel_booking_id || $s->train_booking_id);

        // isCopied = same as isSaved for now
        $isCopied = $isSaved;

        // Related itineraries (same region)
        $related = ItineraryPost::where('status','published')
            ->where('id','!=',$iti->id)
            ->where('region_id', $iti->region_id)
            ->withCount(['likes','comments'])
            ->take(3)->get();

        return view('itineraries.show', compact(
            'iti','itinerary','isLiked','isSaved','isCopied',
            'comments','likesCount','totalCost','bookableStops','related'
        ));
    }

    // ── MY ITINERARIES ─────────────────────────────────────────
    public function myPosts()
    {
        $itineraries = ItineraryPost::where('user_id', Auth::id())
            ->withCount(['likes','comments','copies'])
            ->latest()->paginate(10);

        $copiedItineraries = ItineraryCopy::where('user_id', Auth::id())
            ->with(['originalItinerary.user','originalItinerary.region.province'])
            ->latest('copied_at')->get();

        return view('itineraries.my', compact('itineraries','copiedItineraries'));
    }

    // ── LIKE ───────────────────────────────────────────────────
    public function like($id)
    {
        $existing = ItineraryLike::where('itinerary_id',$id)
            ->where('user_id',Auth::id())->first();
        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            ItineraryLike::create(['itinerary_id'=>$id,'user_id'=>Auth::id()]);
            $liked = true;
        }
        $count = ItineraryLike::where('itinerary_id',$id)->count();
        return response()->json(['liked'=>$liked,'count'=>$count]);
    }

    // ── COPY / SAVE ────────────────────────────────────────────
    public function copy($id)
    {
        $existing = ItineraryCopy::where('itinerary_id',$id)
            ->where('user_id',Auth::id())->first();
        if ($existing) {
            $existing->delete();
            $saved = false;
        } else {
            ItineraryCopy::create([
                'itinerary_id'      => $id,
                'user_id'           => Auth::id(),
                'copied_at'         => now(),
            ]);
            $saved = true;
        }
        return response()->json(['saved'=>$saved]);
    }

    // ── COMMENT ────────────────────────────────────────────────
    public function comment(Request $request, $id)
    {
        // Parse currency shorthand (3jt, 500rb, etc.) before validation
        $parseCurrency = function($val) {
            if (!$val) return 0;
            $val = strtolower(trim($val));
            if (preg_match('/^([\d.,]+)\s*j(t|uta)?$/', $val, $m)) {
                return (int) round((float) str_replace(',', '.', $m[1]) * 1000000);
            }
            if (preg_match('/^([\d.,]+)\s*r(b|ibu)?$/', $val, $m)) {
                return (int) round((float) str_replace(',', '.', $m[1]) * 1000);
            }
            return (int) preg_replace('/[^0-9]/', '', $val);
        };
        $request->merge([
            'estimated_budget' => $parseCurrency($request->estimated_budget),
            'actual_budget'    => $parseCurrency($request->actual_budget),
        ]);

        $request->validate(['content'=>'required|string|max:1000']);
        ItineraryComment::create([
            'itinerary_id'      => $id,
            'user_id'           => Auth::id(),
            'comment'           => $request->content,
        ]);
        return back()->with('success','Komentar ditambahkan.');
    }

    // ── DESTROY ────────────────────────────────────────────────
    public function destroy($slug)
    {
        $iti = ItineraryPost::where('slug',$slug)
            ->where('user_id',Auth::id())
            ->firstOrFail();
        $iti->delete();
        return redirect()->route('itinerary.my')
            ->with('success','Itinerary berhasil dihapus.');
    }
}