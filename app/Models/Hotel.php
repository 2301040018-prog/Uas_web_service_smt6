<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = ['name', 'address', 'phone', 'description'];

    // Relasi ke Kamar (Satu hotel memiliki banyak kamar)
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
