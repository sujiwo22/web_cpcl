<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW anggota_posisi_kelompok_view AS
                SELECT A.*,
                A2.nik,A2.nama_anggota,A2.id_jabatan,A4.nama_jabatan,A2.no_hp,A2.alamat,
                A3.nama_kelompok,
                B.`name` crt_user_name,C.`name` upd_user_name,D.`name` del_user_name 
                FROM anggota_posisi_kelompoks A
                JOIN anggotas A2 ON A.id_anggota=A2.id
                JOIN kelompoks A3 ON A.id_kelompok=A3.id
                JOIN jabatans A4 ON A2.id_jabatan=A4.id
                JOIN users B ON A.crt_id_user=B.id
                LEFT JOIN users C on A.upd_id_user=C.id
                LEFT JOIN users D on A.del_id_user=D.id 
                WHERE a.deleted_at IS NULL;
            ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW anggota_posisi_kelompok_view");
    }
};
