<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainStation extends Model {
    protected $table = 'train_stations';
    public $timestamps = false;
    protected $fillable = ['code','name','city','province_id'];
 
    public function getLabelAttribute(): string {
        return "{$this->name} ({$this->city})";
    }
}