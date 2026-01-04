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
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID Pelaku
            $table->string('action'); // Contoh: "HAPUS DEVICE"
            $table->string('description'); // Contoh: "Menghapus device bernama Turbin 1"
            $table->ipAddress('ip_address')->nullable(); // Opsional: Catat IP pelaku
            $table->timestamps(); // Mencatat waktu kejadian
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
