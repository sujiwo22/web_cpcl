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
            CREATE VIEW kelompok_view 
            AS
            SELECT a.*,d2.total_anggota,a2.nama_kelurahan,b.id_kecamatan,b.nama_kecamatan,b.id_kota, c.nama_kota,c.id_provinsi,d.nama_provinsi, e.name crt_user_name,f.name upd_user_name 
            FROM kelompoks a
            JOIN kelurahans a2 ON a.id_kelurahan=a2.id_kelurahan
            JOIN kecamatans b ON a2.id_kecamatan=b.id_kecamatan 
            JOIN kotas c on b.id_kota=c.id_kota
            JOIN provinsis d on c.id_provinsi=d.id_provinsi
            LEFT JOIN (SELECT id_kelompok,COUNT(*) total_anggota FROM anggotas WHERE deleted_at IS NULL GROUP BY id_kelompok) d2 ON a.id=d2.id_kelompok
            LEFT JOIN users e on a.crt_id_user=e.id
            LEFT JOIN users f on a.upd_id_user=f.id WHERE a.deleted_at IS NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW kelompok_view");
    }
};
