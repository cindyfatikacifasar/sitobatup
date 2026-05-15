<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tanaman_has_kategori')) {
            Schema::create('tanaman_has_kategori', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tanaman_id')->constrained('tanaman_obats')->onDelete('cascade');
                $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('tanaman_has_kategori');
    }
};