<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'check_in',
        'check_out',
        'total_price',
        'status'
    ];

    // Hubungan ke User (Booking ini milik siapa)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Hubungan ke Room (Booking ini memesan kamar apa)
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}