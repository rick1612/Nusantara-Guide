<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Booking extends Model
{
    protected $table = 'bookings';
 
    protected $fillable = [
        'user_id', 'room_id', 'place_id',
        'check_in', 'check_out', 'guests',
        'total_price', 'special_requests',
        'status', 'booking_code',
    ];
 
    protected $casts = [
        'check_in'    => 'date',
        'check_out'   => 'date',
        'total_price' => 'decimal:2',
    ];
 
    // ── RELATIONSHIPS ──────────────────────────────────────
 
    public function user()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }
 
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
 
    public function place()
    {
        return $this->belongsTo(Place::class);
    }
 
    // ── ACCESSORS ─────────────────────────────────────────
 
    // Number of nights between check-in and check-out
    public function getNightsAttribute(): int
    {
        return $this->check_in->diffInDays($this->check_out);
    }
 
    // Formatted total price
    public function getTotalLabelAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }
 
    // Status badge color for UI
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'confirmed'  => '#2d6a4f',
            'cancelled'  => '#e76f51',
            default      => '#e9c46a',  // pending = gold
        };
    }
 
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'confirmed'  => '✓ Dikonfirmasi',
            'cancelled'  => '✗ Dibatalkan',
            default      => '⏳ Menunggu Konfirmasi',
        };
    }
 
    // Generate a unique booking code like "NGH-20250001"
    public static function generateCode(): string
    {
        $last = self::latest()->first();
        $num  = $last ? ((int) substr($last->booking_code, -5)) + 1 : 1;
        return 'NGH-' . date('Y') . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
}