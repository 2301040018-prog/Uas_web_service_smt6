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
    Schema::create('activity_logs', function (Blueprint $table) {
        $table->id();
        // Menggunakan nullable karena saat testing login/register, user_id belum ada
        $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
        $table->string('activity'); // Contoh: "Login User", "Create New Hotel"
        $table->string('method');   // GET, POST, PUT, DELETE
        $table->string('url');      // Endpoint yang diakses, ex: /api/v1/hotels
        $table->string('ip_address')->nullable();
        $table->text('user_agent')->nullable(); // Info browser/Postman yang dipakai
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
