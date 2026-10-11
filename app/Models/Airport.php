<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
 
class Airport extends Model {
    public $timestamps = false;
    protected $fillable = ['code','name','city','province_id'];
 
    public function flights() { return $this->hasMany(Flight::class, 'origin_id'); }
    public function province() { return $this->belongsTo(Province::class); }
 
    // e.g. "CGK - Soekarno-Hatta (Jakarta)"
    public function getLabelAttribute(): string {
        return "{$this->code} — {$this->name} ({$this->city})";
    }
}