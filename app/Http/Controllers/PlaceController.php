<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PlaceController extends Controller
{
    /**
     * Main home page — featured places across all of Indonesia.
     */
    public function index(Request $request)
    {
        $categories = DB::table('categories')->get();
        $provinces  = Province::withCount('regions')->take(6)->get();

        $featuredPlaces = Place::with(['region.province', 'category'])
            ->where('is_verified', 1)
            ->withCount('favorites')
            ->orderByDesc('favorites_count')
            ->take(6)
            ->get();

        $latestItineraries = \App\Models\ItineraryPost::with(['user', 'region'])
            ->where('status', 'published')
            ->withCount('likes')
            ->latest()
            ->take(3)
            ->get();

        $events = DB::table('events')
            ->where('end_date', '>=', now())
            ->orderBy('start_date')
            ->limit(3)
            ->get();

        $favorites = Auth::check() ? Auth::user()->favorites : collect();

        return view('index', compact(
            'categories', 'provinces', 'featuredPlaces',
            'latestItineraries', 'events', 'favorites'
        ));
    }

    /**
     * Browse ALL places with advanced filtering.
     */
    public function browse(Request $request)
    {
        $query = Place::with(['region.province', 'category'])
            ->withAvg('reviews', 'rating')
            ->withCount('favorites');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('region')) {
            $query->where('region_id', $request->region);
        }
        if ($request->filled('province')) {
            $query->whereHas('region', fn($q) => $q->where('province_id', $request->province));
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('description', 'like', '%'.$request->search.'%')
                  ->orWhere('address', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->filled('price_max')) {
            $query->where('price_start', '<=', $request->price_max);
        }

        $sort = $request->get('sort', 'popular');
        match ($sort) {
            'rating'  => $query->orderByDesc('reviews_avg_rating'),
            'newest'  => $query->orderByDesc('created_at'),
            'price'   => $query->orderBy('price_start'),
            default   => $query->orderByDesc('favorites_count'),
        };

        $places     = $query->paginate(12)->withQueryString();
        $categories = DB::table('categories')->get();
        $provinces  = Province::orderBy('name')->get();
        $regions    = Region::with('province')->orderBy('name')->get();
        $favorites  = Auth::check() ? Auth::user()->favorites->pluck('id') : collect();

        return view('places.browse', compact(
            'places', 'categories', 'provinces', 'regions', 'favorites'
        ));
    }

    /**
     * Single place detail page.
     */
    public function show($id)
    {
        $place = Place::with([
            'reviews.user',
            'facilities',
            'operatingHours',
            'events',
            'region.province',
            'category',
            'rooms',
        ])->findOrFail($id);

        $avgRating = $place->reviews->avg('rating');

        $ratingBreakdown = $place->reviews
            ->groupBy('rating')
            ->map->count();

        $userReview = Auth::check()
            ? $place->reviews->firstWhere('user_id', Auth::id())
            : null;

        $nearby = Place::where('region_id', $place->region_id)
            ->where('id', '!=', $place->id)
            ->where('category_id', $place->category_id)
            ->take(3)
            ->get();

        // Check if user has an active booking at this hotel
        $userBooking = null;
        if (Auth::check() && $place->category_id == 3) {
            $userBooking = \App\Models\Booking::where('user_id', Auth::id())
                ->where('place_id', $place->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->latest()
                ->first();
        }

        return view('details', compact(
            'place', 'avgRating', 'ratingBreakdown',
            'userReview', 'nearby', 'userBooking'
        ));
    }
}