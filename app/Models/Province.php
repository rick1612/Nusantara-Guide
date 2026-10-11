<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';

    public $timestamps = false;

    protected $fillable = [
        'name', 'slug', 'description', 'image_url',
    ];

    // ── RELATIONSHIPS ──────────────────────────────────────

    // A province has many regions (e.g. Jawa Timur → Kota Malang, Kota Batu)
    public function regions()
    {
        return $this->hasMany(Region::class);
    }
}
