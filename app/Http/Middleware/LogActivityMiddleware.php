<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivityLog; // Pastikan nanti buat model ActivityLog jika belum ada
use Illuminate\Support\Facades\DB;

class LogActivityMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Jalankan request-nya terlebih dahulu agar mendapatkan respon sistem
        $response = $next($request);

        // Ambil info user yang sedang login (jika ada)
        $userId = auth()->guard('api')->check() ? auth()->guard('api')->id() : null;

        // Tentukan nama aktivitas berdasarkan URL atau Method
        $activity = 'Mengakses halaman ' . $request->path();
        if ($request->is('api/auth/login')) $activity = 'Melakukan Login';
        if ($request->is('api/auth/register')) $activity = 'Melakukan Registrasi User';
        if ($request->is('api/auth/logout')) $activity = 'Melakukan Logout';

        // Simpan ke tabel activity_logs menggunakan Query Builder agar cepat
        DB::table('activity_logs')->insert([
            'user_id' => $userId,
            'activity' => $activity,
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return $response;
    }
}