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
        Schema::table('anggota_posisi_kelompoks', function (Blueprint $table) {
            $table->integer('id_jabatan')->nullable(true)->default(null)->after('id_kelompok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggota_posisi_kelompoks', function (Blueprint $table) {
            $table->dropColumn('id_jabatan');
        });
    }
};
