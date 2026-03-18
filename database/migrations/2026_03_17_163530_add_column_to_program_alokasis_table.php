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
        Schema::table('program_alokasis', function (Blueprint $table) {
            $table->char('cpcl_status',2)->default('BL')->after('status')->comment('BL=BELUM LENGKAP,L=LENGKAP');
            $table->timestamp('cpcl_upd_date')->nullable()->default(null)->after('cpcl_status');
            $table->integer('cpcl_upd_id_user')->nullable()->default(null)->after('cpcl_upd_date');
            $table->char('verifikasi_status',1)->default('B')->after('cpcl_upd_id_user')->comment('B=BELUM,S=SUDAH,P=ON PROCESS');
            $table->timestamp('verifikasi_upd_date')->nullable()->default(null)->after('verifikasi_status');
            $table->integer('verifikasi_upd_id_user')->nullable()->default(null)->after('verifikasi_upd_date');            
            $table->char('kontrak_status',1)->default('B')->after('verifikasi_upd_id_user')->comment('B=BELUM,S=SUDAH,P=ON PROCESS');
            $table->timestamp('kontrak_upd_date')->nullable()->default(null)->after('kontrak_status');
            $table->integer('kontrak_upd_id_user')->nullable()->default(null)->after('kontrak_upd_date');
            $table->char('pengiriman_status',1)->default('B')->after('kontrak_upd_id_user')->comment('B=BELUM,S=SUDAH,P=ON PROCESS');
            $table->timestamp('pengiriman_upd_date')->nullable()->default(null)->after('pengiriman_status');
            $table->integer('pengiriman_upd_id_user')->nullable()->default(null)->after('pengiriman_upd_date');            
            $table->char('distribusi_status',1)->default('B')->after('pengiriman_upd_id_user')->comment('B=BELUM,S=SUDAH,P=ON PROCESS');
            $table->timestamp('distribusi_upd_date')->nullable()->default(null)->after('distribusi_status');
            $table->integer('distribusi_upd_id_user')->nullable()->default(null)->after('distribusi_upd_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_alokasis', function (Blueprint $table) {
            //
        });
    }
};
