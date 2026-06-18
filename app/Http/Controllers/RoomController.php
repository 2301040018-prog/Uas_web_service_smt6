<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;

class RoomController extends Controller
{
    // 1. TAMPILKAN SEMUA KAMAR
    public function index()
    {
        $rooms = Room::with('hotel')->get(); // Menyertakan data hotelnya sekalian
        return response()->json(['success' => true, 'data' => $rooms], 200);
    }

    // 2. TAMBAH KAMAR BARU
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hotel_id'         => 'required|exists:hotels,id', // Pastikan hotelnya ada di DB
            'room_number'      => 'required|string',
            'type'             => 'required|string',
            'price_per_night'  => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $room = Room::create($request->all());
        return response()->json(['success' => true, 'message' => 'Kamar berhasil ditambahkan', 'data' => $room], 201);
    }

    // 3. DETAIL SATU KAMAR
    public function show(Room $room)
    {
        return response()->json(['success' => true, 'data' => $room->load('hotel')], 200);
    }

    // 4. UBAH DATA KAMAR
    public function update(Request $request, Room $room)
    {
        $room->update($request->all());
        return response()->json(['success' => true, 'message' => 'Data kamar berhasil diperbarui', 'data' => $room], 200);
    }

    // 5. HAPUS KAMAR
    public function destroy(Room $room)
    {
        Room::destroy($room->id); // Trik statis agar bebas dari garis merah Intelephense
        return response()->json(['success' => true, 'message' => 'Kamar berhasil dihapus'], 200);
    }
}