<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    public $timestamps = false;

    protected $fillable = [
        'name', 'icon',
    ];

    // A category has many places (e.g. all Restaurants, all Hotels)
    public function places()
    {
        return $this->hasMany(Place::class);
    }
}