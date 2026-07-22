<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ulasans', function (Blueprint $table) {
            // Kita hapus ->after('isi') agar tidak error lagi
            if (!Schema::hasColumn('ulasans', 'pengirim')) {
                $table->string('pengirim')->default('pengunjung');
            }
            if (!Schema::hasColumn('ulasans', 'is_read')) {
                $table->boolean('is_read')->default(false);
            }
        });
    }

    public function down()
    {
        Schema::table('ulasans', function (Blueprint $table) {
            $table->dropColumn(['pengirim', 'is_read']);
        });
    }
};