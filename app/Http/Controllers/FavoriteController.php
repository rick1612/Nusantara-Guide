<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle($id)
    {
        $user = Auth::user();
        $place = Place::findOrFail($id);
        $user->favorites()->toggle($place->id);

        return back();
    }

}