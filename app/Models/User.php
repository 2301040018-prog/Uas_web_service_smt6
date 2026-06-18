<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject; // 1. Tambahkan ini

class User extends Authenticatable implements JWTSubject // 2. Tambahkan implements ini
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // 3. Tambahkan fungsi ini untuk mendapatkan ID JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // 4. Tambahkan fungsi ini jika ingin memasukkan data kustom ke dalam token
    public function getJWTCustomClaims()
    {
        return [];
    }
}