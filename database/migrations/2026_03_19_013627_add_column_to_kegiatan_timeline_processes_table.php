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
        Schema::table('kegiatan_timeline_processes', function (Blueprint $table) {
            $table->integer('tahun')->nullable()->default(null)->after('id');
            $table->integer('order_data')->nullable()->default(null)->after('tahun');
            $table->integer('tambahan_bulan')->nullable()->default(null)->after('bulan_end');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kegiatan_timeline_processes', function (Blueprint $table) {
            $table->dropColumn('tahun');
            $table->dropColumn('order_data');
            $table->dropColumn('tambahan_bulan');
        });
    }
};
