<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airline extends Model {
    public $timestamps = false;
    protected $fillable = ['code','name','logo_url'];
 
    public function flights() { return $this->hasMany(Flight::class); }
}