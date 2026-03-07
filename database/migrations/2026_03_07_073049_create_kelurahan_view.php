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
            CREATE VIEW kelurahan_view 
            AS
            SELECT a.*,b.nama_kecamatan,b.id_kota, c.nama_kota,c.id_provinsi,d.nama_provinsi, e.name crt_user_name,f.name upd_user_name FROM kelurahans a
            JOIN kecamatans b ON a.id_kecamatan=b.id_kecamatan 
            JOIN kotas c on b.id_kota=c.id_kota
            JOIN provinsis d on c.id_provinsi=d.id_provinsi
            LEFT JOIN users e on a.crt_id_user=e.id
            LEFT JOIN users f on a.upd_id_user=f.id WHERE a.deleted_at IS NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW kelurahan_view");
    }
};
