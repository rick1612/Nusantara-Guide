<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // DISABLE AUTO-TIMESTAMPS
    public $timestamps = false; 

    // ALLOW THESE FIELDS TO BE SAVED (Fixes MassAssignmentException)
    protected $fillable = [
        'place_id', 
        'user_id', 
        'rating', 
        'comment'
    ];

    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }
}
