<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Region;
use App\Models\Place;
use Illuminate\Http\Request;

class BudgetCalculatorController extends Controller
{
    // Cost ranges per person per day (in IDR) by travel style
    const COSTS = [
        'backpacker' => [
            'hotel'      => ['min' => 100000,  'max' => 300000,  'label' => 'Hostel / Guesthouse'],
            'food'       => ['min' => 50000,   'max' => 100000,  'label' => 'Warung & street food'],
            'activity'   => ['min' => 30000,   'max' => 100000,  'label' => 'Tempat wisata umum'],
            'transport'  => ['min' => 50000,   'max' => 150000,  'label' => 'Angkutan umum / ojek'],
        ],
        'budget' => [
            'hotel'      => ['min' => 300000,  'max' => 600000,  'label' => 'Hotel bintang 2-3'],
            'food'       => ['min' => 100000,  'max' => 200000,  'label' => 'Restoran lokal'],
            'activity'   => ['min' => 75000,   'max' => 200000,  'label' => 'Wisata dengan guide'],
            'transport'  => ['min' => 100000,  'max' => 300000,  'label' => 'Taksi online / rental motor'],
        ],
        'mid-range' => [
            'hotel'      => ['min' => 600000,  'max' => 1500000, 'label' => 'Hotel bintang 3-4'],
            'food'       => ['min' => 200000,  'max' => 400000,  'label' => 'Restoran pilihan'],
            'activity'   => ['min' => 150000,  'max' => 400000,  'label' => 'Tour paket & wisata premium'],
            'transport'  => ['min' => 200000,  'max' => 500000,  'label' => 'Rental mobil / taksi'],
        ],
        'luxury' => [
            'hotel'      => ['min' => 2000000, 'max' => 10000000,'label' => 'Hotel bintang 5 / resort'],
            'food'       => ['min' => 500000,  'max' => 1500000, 'label' => 'Fine dining & rooftop'],
            'activity'   => ['min' => 500000,  'max' => 2000000, 'label' => 'Private tour & experience'],
            'transport'  => ['min' => 500000,  'max' => 2000000, 'label' => 'Private car / charter'],
        ],
    ];

    // Flight cost estimates by destination province (from Jakarta)
    const FLIGHT_COSTS = [
        'bali'              => ['min' => 600000,  'max' => 2500000],
        'dki-jakarta'       => ['min' => 0,       'max' => 0],
        'yogyakarta'        => ['min' => 400000,  'max' => 1500000],
        'jawa-barat'        => ['min' => 200000,  'max' => 800000],
        'jawa-tengah'       => ['min' => 350000,  'max' => 1200000],
        'jawa-timur'        => ['min' => 450000,  'max' => 1500000],
        'sulawesi-selatan'  => ['min' => 700000,  'max' => 2500000],
        'sumatera-barat'    => ['min' => 600000,  'max' => 2000000],
        'kalimantan-timur'  => ['min' => 800000,  'max' => 3000000],
        'nusa-tenggara-timur'=> ['min' => 1000000,'max' => 3500000],
    ];

    // Train cost estimates (Jawa only)
    const TRAIN_COSTS = [
        'yogyakarta'  => ['min' => 80000,  'max' => 350000,  'available' => true],
        'jawa-barat'  => ['min' => 50000,  'max' => 200000,  'available' => true],
        'jawa-tengah' => ['min' => 80000,  'max' => 350000,  'available' => true],
        'jawa-timur'  => ['min' => 150000, 'max' => 450000,  'available' => true],
    ];

    public function index()
    {
        $provinces = Province::orderBy('name')->get();
        return view('budget-calculator.index', compact('provinces'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'province_slug' => 'required|string',
            'days'          => 'required|integer|min:1|max:30',
            'people'        => 'required|integer|min:1|max:20',
            'style'         => 'required|in:backpacker,budget,mid-range,luxury',
            'include_flight'=> 'nullable|boolean',
            'include_train' => 'nullable|boolean',
        ]);

        $slug    = $request->province_slug;
        $days    = (int) $request->days;
        $people  = (int) $request->people;
        $style   = $request->style;
        $costs   = self::COSTS[$style];

        $province = Province::where('slug', $slug)->firstOrFail();

        // Per person per day costs
        $hotelMin    = $costs['hotel']['min']    * $days;
        $hotelMax    = $costs['hotel']['max']    * $days;
        $foodMin     = $costs['food']['min']     * $days;
        $foodMax     = $costs['food']['max']     * $days;
        $activityMin = $costs['activity']['min'] * $days;
        $activityMax = $costs['activity']['max'] * $days;
        $transportMin= $costs['transport']['min']* $days;
        $transportMax= $costs['transport']['max']* $days;

        // Flight (per person, round trip x2)
        $flightMin = $flightMax = 0;
        $flightData = self::FLIGHT_COSTS[$slug] ?? ['min' => 500000, 'max' => 2000000];
        if ($request->boolean('include_flight') && $flightData['min'] > 0) {
            $flightMin = $flightData['min'] * 2;
            $flightMax = $flightData['max'] * 2;
        }

        // Train (per person, round trip x2)
        $trainMin = $trainMax = 0;
        $trainData = self::TRAIN_COSTS[$slug] ?? null;
        $trainAvailable = $trainData && $trainData['available'];
        if ($request->boolean('include_train') && $trainAvailable) {
            $trainMin = $trainData['min'] * 2;
            $trainMax = $trainData['max'] * 2;
        }

        // Total per person
        $totalMinPP = $hotelMin + $foodMin + $activityMin + $transportMin + $flightMin + $trainMin;
        $totalMaxPP = $hotelMax + $foodMax + $activityMax + $transportMax + $flightMax + $trainMax;

        // Total for all people
        $grandMin = $totalMinPP * $people;
        $grandMax = $totalMaxPP * $people;

        // Get real hotels from DB for this province
        $hotels = Place::whereHas('region', fn($q) => $q->where('province_id', $province->id))
            ->where('category_id', 3)
            ->with('rooms')
            ->take(3)->get();

        // Get top places for this province
        $places = Place::whereHas('region', fn($q) => $q->where('province_id', $province->id))
            ->where('category_id', '!=', 3)
            ->orderByDesc('id')
            ->take(6)->get();

        $breakdown = [
            'hotel'     => ['min' => $hotelMin,     'max' => $hotelMax,     'label' => $costs['hotel']['label'],     'icon' => '🏨'],
            'food'      => ['min' => $foodMin,       'max' => $foodMax,      'label' => $costs['food']['label'],      'icon' => '🍽️'],
            'activity'  => ['min' => $activityMin,   'max' => $activityMax,  'label' => $costs['activity']['label'],  'icon' => '🎯'],
            'transport' => ['min' => $transportMin,  'max' => $transportMax, 'label' => $costs['transport']['label'], 'icon' => '🚗'],
            'flight'    => ['min' => $flightMin,     'max' => $flightMax,    'label' => 'Tiket pesawat PP',           'icon' => '✈️'],
            'train'     => ['min' => $trainMin,      'max' => $trainMax,     'label' => 'Tiket kereta PP',            'icon' => '🚆'],
        ];

        return view('budget-calculator.result', compact(
            'province', 'days', 'people', 'style',
            'breakdown', 'grandMin', 'grandMax', 'totalMinPP', 'totalMaxPP',
            'hotels', 'places', 'trainAvailable', 'slug'
        ));
    }
}