<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            // Role disesuaikan dengan aktor Admin & Penanggungjawab di proposal [cite: 453, 483]
            $table->enum('role', ['admin', 'penanggungjawab'])->default('penanggungjawab');
            $table->string('foto')->nullable();
            $table->string('phone')->nullable(); // Mengikuti $fillable di Model User kamu
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};