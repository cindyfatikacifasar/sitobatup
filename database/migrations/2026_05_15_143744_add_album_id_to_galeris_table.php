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
        Schema::table('galeris', function (Blueprint $table) {
            // Kita tambahkan kolom album_id setelah kolom id
            // nullable() dipakai supaya foto lama yang belum punya album tidak error
            // constrained() otomatis menghubungkan ke tabel 'albums'
            // onDelete('cascade') artinya kalau album dihapus, foto di dalamnya ikut terhapus
            $table->foreignId('album_id')->after('id')->nullable()->constrained()->onDelete('cascade');
        });
    }
    
    public function down(): void
    {
        Schema::table('galeris', function (Blueprint $table) {
            // Ini untuk membatalkan (rollback) jika ada masalah
            $table->dropForeign(['album_id']);
            $table->dropColumn('album_id');
        });
    }
};
