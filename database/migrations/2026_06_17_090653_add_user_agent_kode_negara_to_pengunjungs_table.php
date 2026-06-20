<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pengunjungs', function (Blueprint $table) {
            $table->string('user_agent')->nullable()->after('asal_negara');
            $table->string('kode_negara', 5)->nullable()->after('asal_negara');
        });
    }

    public function down()
    {
        Schema::table('pengunjungs', function (Blueprint $table) {
            $table->dropColumn(['user_agent', 'kode_negara']);
        });
    }
};