<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;

class HotelController extends Controller
{
    // 1. TAMPILKAN SEMUA HOTEL (Read All)
    public function index()
    {
        $hotels = Hotel::all();
        return response()->json([
            'success' => true,
            'data'    => $hotels
        ], 200);
    }

    // 2. TAMBAH HOTEL BARU (Create)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'address' => 'required|string',
            'phone'   => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $hotel = Hotel::create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Hotel berhasil ditambahkan',
            'data'    => $hotel
        ], 201);
    }

    // 3. TAMPILKAN SATU HOTEL DETAIL (Menggunakan Route Model Binding)
    public function show(Hotel $hotel)
    {
        return response()->json([
            'success' => true, 
            'data'    => $hotel
        ], 200);
    }

    // 4. UBAH DATA HOTEL (Menggunakan Route Model Binding)
    public function update(Request $request, Hotel $hotel)
    {
        $hotel->update($request->all());
        return response()->json([
            'success' => true,
            'message' => 'Data hotel berhasil diperbarui',
            'data'    => $hotel
        ], 200);
    }

    // 5. HAPUS HOTEL (Alternatif Query Builder statis)
    public function destroy(Hotel $hotel)
    {
        Hotel::destroy($hotel->id); // Menghapus berdasarkan ID langsung lewat Class Utama
        
        return response()->json([
            'success' => true,
            'message' => 'Hotel berhasil dihapus'
        ], 200);
    }
}