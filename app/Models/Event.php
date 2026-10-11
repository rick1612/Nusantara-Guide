<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    public $timestamps = false;

    protected $fillable = [
        'place_id', 'name', 'description', 'start_date', 'end_date', 'price', 'image_url',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date'   => 'datetime',
        'price'      => 'decimal:2',
    ];

    // Each event belongs to one place
    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}