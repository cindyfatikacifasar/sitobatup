<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('beritas', function (Blueprint $table) {
            // Menambahkan kolom is_published dengan default true (1)
            $table->boolean('is_published')->default(true)->after('isi');
        });
    }

    public function down()
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });
    }
};