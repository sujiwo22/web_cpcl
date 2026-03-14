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
        Schema::create('program_alokasis', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->char('program_kementrian', 1)->default('Y')->comment('Y=Yes (Program Kementrian), N=No (Bukan Program Kementrian)');
            $table->integer('id_kementrian')->nullable()->default(null);
            $table->integer('id_dirjen')->nullable()->default(null);
            $table->integer('id_program');
            $table->string('pic', 200);
            $table->string('contact_person', 20);
            $table->double('kuota', 15, 2)->nullable()->default(0.00);
            $table->string('satuan');
            $table->char('status', 1)->default('A')->comment('A=Aktif,N=Non Aktif');
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
        Schema::dropIfExists('program_alokasis');
    }
};
