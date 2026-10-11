<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Region;
use App\Models\Place;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    /**
     * Show all provinces - the main Explore page.
     */
    public function index()
    {
        $provinces = Province::withCount('regions')->orderBy('name')->get();
        return view('explore.index', compact('provinces'));
    }

    /**
     * Show a single province with its regions and places.
     */
    public function show($slug)
    {
        $province = Province::where('slug', $slug)->firstOrFail();

        $regions = Region::where('province_id', $province->id)
            ->withCount('places')
            ->get();

        $places = Place::whereHas('region', fn($q) => $q->where('province_id', $province->id))
            ->with(['category', 'region'])
            ->withCount('favorites')
            ->orderByDesc('favorites_count')
            ->take(12)
            ->get();

        return view('explore.province', compact('province', 'regions', 'places'));
    }

    /**
     * Show a single region with its places.
     */
    public function region($provinceSlug, $regionSlug)
    {
        $province = Province::where('slug', $provinceSlug)->firstOrFail();

        $region = Region::where('province_id', $province->id)
            ->where(function($q) use ($regionSlug) {
                $q->where('slug', $regionSlug)->orWhere('id', $regionSlug);
            })
            ->firstOrFail();

        $places = Place::where('region_id', $region->id)
            ->with(['category', 'region'])
            ->withAvg('reviews', 'rating')
            ->withCount('favorites')
            ->orderByDesc('favorites_count')
            ->paginate(12);

        $categories = \DB::table('categories')->get();

        return view('explore.region', compact('province', 'region', 'places', 'categories'));
    }
}