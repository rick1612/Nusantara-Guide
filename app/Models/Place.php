<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $table = 'places';

    protected $fillable = [
        'name', 'description', 'image_url', 'address', 'phone', 'website',
        'category_id', 'region_id', 'latitude', 'longitude',
        'price_start', 'price_end', 'is_verified',
    ];

    // ── RELATIONSHIPS ──────────────────────────────────────

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'place_id');
    }

    public function facilities()
    {
        return $this->belongsToMany(
            Facility::class, 'place_facilities', 'place_id', 'facility_id'
        );
    }

    public function favorites()
    {
        return $this->belongsToMany(
            Customer::class, 'favorites', 'place_id', 'user_id'
        );
    }

    public function operatingHours()
    {
        return $this->hasMany(OperatingHour::class, 'place_id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class)->where('is_available', 1);
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'place_id')
                    ->where('end_date', '>=', now());
    }
}