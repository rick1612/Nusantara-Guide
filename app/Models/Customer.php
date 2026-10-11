<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $table = 'customer';

    public $timestamps = true;

    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'avatar_url', 'bio',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'password'          => 'hashed',
        'email_verified_at' => 'datetime',
    ];

    // ── RELATIONSHIPS ──────────────────────────────────────

    public function favorites()
    {
        return $this->belongsToMany(
            Place::class, 'favorites', 'user_id', 'place_id'
        );
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function itineraries()
    {
        return $this->hasMany(ItineraryPost::class, 'user_id');
    }

    public function savedItineraries()
    {
        return $this->belongsToMany(
            ItineraryPost::class, 'saved_itineraries', 'user_id', 'itinerary_id'
        );
    }

    public function following()
    {
        return $this->belongsToMany(
            Customer::class, 'follows', 'follower_id', 'following_id'
        );
    }

    public function followers()
    {
        return $this->belongsToMany(
            Customer::class, 'follows', 'following_id', 'follower_id'
        );
    }

    // ── ACCESSORS ─────────────────────────────────────────

    // Gets the first letter of the user's name, used for avatar initials
    public function getInitialsAttribute(): string
    {
        return strtoupper(substr($this->name, 0, 1));
    }
}
