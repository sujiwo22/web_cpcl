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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->char('status_proposal',1)->comment('Y=Yes (With Proposal), N=No (Wthout Proposal)');
            $table->string('file')->nullable()->default(null);
            $table->integer('id_kelompok');
            $table->string('nama_kelompok');
            $table->string('alamat_kelompok');
            $table->integer('id_program_alokasi');
            $table->string('jenis_bantuan');
            $table->double('jumlah_bantuan');
            $table->integer('id_pic_penyuluh');
            $table->integer('nama_penyuluh');
            $table->integer('contact_person_penyuluh');
            $table->integer('id_pic_penanggung_jawab');
            $table->integer('nama_penanggung_jawab');
            $table->integer('contact_person_penanggung_jawab');
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
        Schema::dropIfExists('proposals');
    }
};
