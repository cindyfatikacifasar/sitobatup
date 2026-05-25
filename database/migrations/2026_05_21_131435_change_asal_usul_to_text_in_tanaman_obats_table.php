<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tanaman_obats', function (Blueprint $table) {
            // Mengubah tipe data asal_usul menjadi TEXT agar muat tulisan panjang
            $table->text('asal_usul')->change();
        });
    }

    public function down()
    {
        Schema::table('tanaman_obats', function (Blueprint $table) {
            // Mengembalikan ke varchar jika di-rollback
            $table->string('asal_usul', 255)->change();
        });
    }
};