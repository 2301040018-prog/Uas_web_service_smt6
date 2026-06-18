<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    // Mengizinkan kolom-kolom ini diisi secara massal
    protected $fillable = [
        'hotel_id', 
        'room_number', 
        'type', 
        'price_per_night', 
        'is_available'
    ];

    // Relasi balik ke Hotel (Satu kamar dimiliki oleh satu hotel)
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}