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
        Schema::create('kegiatan_timeline_processes', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kegiatan');
            $table->string('nama_kegiatan');
            $table->integer('tahun_start');
            $table->integer('bulan_start');
            $table->integer('tahun_end');
            $table->integer('bulan_end');
            $table->integer('crt_id_user');
            $table->integer('upd_id_user')->nullable()->default(null);
            $table->integer('del_id_user')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_timeline_processes');
    }
};
