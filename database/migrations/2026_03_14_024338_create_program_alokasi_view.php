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
            CREATE VIEW program_alokasi_view 
            AS
            SELECT a.*, case when program_kementrian='Y' then 'Program Kementrian' ELSE 'Program Non Kementrian' END status_program,
            b.nama_program,
            case when program_kementrian='Y' then c.nama_kementrian ELSE 'Program Non Kementrian' end nama_kementrian,
			case when a.program_kementrian='Y' then d.nama_dirjen ELSE 'Program Non Kementrian' END nama_dirjen,
            e.name crt_user_name,f.name upd_user_name FROM program_alokasis a
            JOIN programs b ON a.id_program=b.id
            LEFT JOIN kementrians c ON a.id_kementrian=c.id
            LEFT JOIN dirjens d ON a.id_dirjen=d.id
            LEFT JOIN users e ON a.crt_id_user=e.id
            LEFT JOIN users f ON a.upd_id_user=f.id
            WHERE a.deleted_at IS NULL
            ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW program_alokasi_view");
    }
};
