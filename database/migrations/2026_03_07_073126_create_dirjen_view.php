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
            CREATE VIEW dirjen_view 
            AS
            SELECT a.*,b.nama_kementrian, e.name crt_user_name,f.name upd_user_name 
            FROM dirjens a
            JOIN kementrians b ON a.id_kementrian=b.id
            LEFT JOIN users e on a.crt_id_user=e.id
            LEFT JOIN users f on a.upd_id_user=f.id WHERE a.deleted_at IS NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW dirjen_view");
    }
};
