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
        Schema::create('provinsis', function (Blueprint $table) {
            $table->integer('id_provinsi')->primary();
            $table->string('nama_provinsi');
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
        Schema::dropIfExists('provinsis');
    }
};
