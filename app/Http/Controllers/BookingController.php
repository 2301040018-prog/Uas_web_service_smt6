<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use Carbon\Carbon;

class BookingController extends Controller
{
    // 1. TAMBAH BOOKING BARU (Proses Transaksi)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_id'   => 'required|exists:rooms,id',
            'check_in'  => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Ditambahkan ::query() agar VS Code mengenali method find()
        $room = Room::query()->find($request->room_id); 

        // Validasi Awal: Cek apakah kamar tersebut sedang dinonaktifkan
        if (!$room || !$room->is_available) {
            return response()->json(['message' => 'Maaf, kamar ini sedang tidak tersedia untuk dipesan.'], 400);
        }

        // Ditambahkan ::query() agar VS Code mengenali rangkaian method where()
        $isBentrok = Booking::query()->where('room_id', $request->room_id)
            ->where('status', '!=', 'cancelled') 
            ->where(function ($query) use ($request) {
                $query->whereBetween('check_in', [$request->check_in, $request->check_out])
                      ->orWhereBetween('check_out', [$request->check_in, $request->check_out])
                      ->orWhere(function ($q) use ($request) {
                          $q->where('check_in', '<=', $request->check_in)
                            ->where('check_out', '>=', $request->check_out);
                      });
            })->exists();

        if ($isBentrok) {
            return response()->json(['message' => 'Maaf, kamar sudah dipesan oleh orang lain pada rentang tanggal tersebut.'], 400);
        }

        // Hitung Otomatis Total Harga Menggunakan Carbon
        $checkInDate  = Carbon::parse($request->check_in);
        $checkOutDate = Carbon::parse($request->check_out);
        $durasiMenginap = $checkInDate->diffInDays($checkOutDate); 

        $totalHarga = $durasiMenginap * $room->price_per_night;

        // Ambil ID User yang sedang login via JWT Token
        $userId = auth()->guard('api')->id(); 

        // Simpan Transaksi Booking
        $booking = Booking::create([
            'user_id'     => $userId,
            'room_id'     => $request->room_id,
            'check_in'    => $request->check_in,
            'check_out'   => $request->check_out,
            'total_price' => $totalHarga,
            'status'      => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dibuat! Menunggu konfirmasi pembayaran.',
            'data'    => $booking
        ], 201);
    }

    // 2. LIHAT RIWAYAT BOOKING USER YANG SEDANG LOGIN
    public function myBookings()
    {
        $userId = auth()->guard('api')->id();
        
        // Ditambahkan ::query() agar VS Code mengenali method where() dan dengan relasinya
        $bookings = Booking::query()->where('user_id', $userId)->with('room.hotel')->get();

        return response()->json(['success' => true, 'data' => $bookings], 200);
    }
}