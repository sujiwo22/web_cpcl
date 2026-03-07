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
            CREATE VIEW kota_view 
            AS
            SELECT a.*,b.nama_provinsi, c.name crt_user_name,d.name upd_user_name from kotas a 
            JOIN provinsis b on a.id_provinsi=b.id_provinsi
            LEFT JOIN users c on a.crt_id_user=c.id
            LEFT JOIN users d on a.upd_id_user=d.id WHERE a.deleted_at IS NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       DB::statement("DROP VIEW kota_view");
    }
};
