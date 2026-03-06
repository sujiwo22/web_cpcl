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
            CREATE OR REPLACE VIEW user_views AS
                SELECT A.*,A2.level_name, B.`name` crt_user_name,C.`name` upd_user_name,D.`name` del_user_name FROM users A
                JOIN user_levels A2 ON A.id_user_level=A2.id
                JOIN users B ON A.crt_id_user=B.id
                LEFT JOIN users C on A.upd_id_user=C.id
                LEFT JOIN users D on A.del_id_user=D.id;
            ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS user_views;');
    }
};
