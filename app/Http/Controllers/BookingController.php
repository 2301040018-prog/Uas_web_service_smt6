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
    // 1. [READ ALL] - Melihat Semua Booking (Fungsi untuk Admin)
    public function index()
    {
        $bookings = Booking::query()->with(['user', 'room.hotel'])->get();
        return response()->json(['success' => true, 'data' => $bookings], 200);
    }

    // 2. [CREATE] - Membuat Pesanan Baru
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

        $room = Room::query()->find($request->room_id); 

        if (!$room || !$room->is_available) {
            return response()->json(['message' => 'Maaf, kamar ini sedang tidak tersedia.'], 400);
        }

        // Validasi Overlapping Tanggal
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
            return response()->json(['message' => 'Maaf, kamar sudah dipesan pada rentang tanggal tersebut.'], 400);
        }

        // Hitung Otomatis Total Harga
        $checkInDate  = Carbon::parse($request->check_in);
        $checkOutDate = Carbon::parse($request->check_out);
        $durasiMenginap = $checkInDate->diffInDays($checkOutDate); 
        $totalHarga = $durasiMenginap * $room->price_per_night;

        $booking = Booking::create([
            'user_id'     => auth()->guard('api')->id(),
            'room_id'     => $request->room_id,
            'check_in'    => $request->check_in,
            'check_out'   => $request->check_out,
            'total_price' => $totalHarga,
            'status'      => 'pending'
        ]);

        return response()->json(['success' => true, 'message' => 'Booking berhasil dibuat!', 'data' => $booking], 201);
    }

    // 3. [READ SINGLE] - Detail Satu Transaksi Booking
    public function show($id)
    {
        $booking = Booking::query()->with(['user', 'room.hotel'])->find($id);

        if (!$booking) {
            return response()->json(['message' => 'Data booking tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $booking], 200);
    }

    // 4. [UPDATE] - Mengubah Status Booking (Konfirmasi Pembayaran oleh Admin)
    public function update(Request $request, $id)
    {
        $booking = Booking::query()->find($id);

        if (!$booking) {
            return response()->json(['message' => 'Data booking tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $booking->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Status booking berhasil diperbarui menjadi ' . $request->status,
            'data'    => $booking
        ], 200);
    }

    // 5. [DELETE] - Menghapus Riwayat Transaksi dari Database
    public function destroy($id)
    {
        $booking = Booking::query()->find($id);

        if (!$booking) {
            return response()->json(['message' => 'Data booking tidak ditemukan'], 404);
        }

        Booking::destroy($id);

        return response()->json(['success' => true, 'message' => 'Data riwayat booking berhasil dihapus'], 200);
    }

    // 6. [ADDITIONAL] - Riwayat Khusus User yang Sedang Login
    public function myBookings()
    {
        $userId = auth()->guard('api')->id();
        $bookings = Booking::query()->where('user_id', $userId)->with('room.hotel')->get();

        return response()->json(['success' => true, 'data' => $bookings], 200);
    }
}