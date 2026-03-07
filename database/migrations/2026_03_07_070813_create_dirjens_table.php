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
        Schema::create('dirjens', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kementrian');
            $table->string('nama_dirjen');
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
        Schema::dropIfExists('dirjens');
    }
};
