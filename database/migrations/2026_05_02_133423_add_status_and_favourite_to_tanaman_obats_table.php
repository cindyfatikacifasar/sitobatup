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
    Schema::table('tanaman_obats', function (Blueprint $table) {
        // Tambahkan kolom yang menyebabkan error di gambar
        $table->enum('status_ketersediaan', ['tersedia', 'tidak_tersedia'])->default('tersedia')->after('khasiat');
        
        // Tambahkan juga kolom is_favourite untuk fitur beranda
        $table->boolean('is_favourite')->default(false)->after('status_ketersediaan');
    });
}

public function down(): void
{
    Schema::table('tanaman_obats', function (Blueprint $table) {
        $table->dropColumn(['status_ketersediaan', 'is_favourite']);
    });
}
    
};
