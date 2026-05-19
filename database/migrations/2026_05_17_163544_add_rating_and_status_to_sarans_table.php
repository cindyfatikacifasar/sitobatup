<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('sarans', function (Blueprint $table) {
            // Menambahkan input rating bintang (default 5 jika tidak diisi)
            $table->integer('rating')->default(5)->after('pesan');
            
            // Menambahkan status moderasi (0 = pending/sembunyi, 1 = tampil di web publik)
            $table->boolean('is_displayed')->default(0)->after('is_read');
        });
    }
    
    public function down()
    {
        Schema::table('sarans', function (Blueprint $table) {
            $table->dropColumn(['rating', 'is_displayed']);
        });
    }
};
