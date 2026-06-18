<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('rooms', function (Blueprint $table) {
        $table->id();
        // Relasi ke tabel hotels, jika hotel dihapus maka kamar otomatis terhapus (cascade)
        $table->foreignId('hotel_id')->constrained('hotels')->onDelete('cascade');
        $table->string('room_number');
        $table->string('type'); // Contoh: Deluxe, Standard, Suite
        $table->decimal('price_per_night', 10, 2);
        $table->boolean('is_available')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
