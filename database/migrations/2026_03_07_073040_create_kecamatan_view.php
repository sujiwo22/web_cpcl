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
            CREATE VIEW kecamatan_view 
            AS
            SELECT a.*,b.nama_kota,b.id_provinsi,c.nama_provinsi, d.name crt_user_name,e.name upd_user_name FROM kecamatans a 
            JOIN kotas b on a.id_kota=b.id_kota
            JOIN provinsis c on b.id_provinsi=c.id_provinsi
            LEFT JOIN users d on a.crt_id_user=d.id
            LEFT JOIN users e on a.upd_id_user=e.id WHERE a.deleted_at IS NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         DB::statement("DROP VIEW kecamatan_view");
    }
};
