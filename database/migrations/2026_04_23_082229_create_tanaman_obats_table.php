<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tanaman_obats', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nama_ilmiah');
            $table->string('slug')->unique();
            $table->text('deskripsi');
            $table->text('khasiat');
            $table->string('bagian_digunakan')->nullable();
            $table->string('asal_usul')->nullable();
            $table->string('kolektor')->nullable();
            $table->string('foto')->nullable();
            $table->string('qr_code')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();
        });
    }
};