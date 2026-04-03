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
        Schema::create('pesan_wa_pengirims', function (Blueprint $table) {
            $table->id();
            $table->string('no_pengirim');
            $table->string('token');
            $table->char('status',1)->default('A')->comment('A=Aktif,N=Non Aktif');
            $table->integer('crt_id_user');
            $table->integer('upd_id_user')->nullable()->default(null);
            $table->integer('del_id_user')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesan_wa_pengirims');
    }
};
