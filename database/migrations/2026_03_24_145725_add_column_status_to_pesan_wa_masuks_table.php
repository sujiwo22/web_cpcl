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
        Schema::table('pesan_wa_masuks', function (Blueprint $table) {
            $table->char('status',1)->default('N')->comment('N=Belum Dibaca,Y=Sudah Dibaca')->after('pesan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesan_wa_masuks', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
