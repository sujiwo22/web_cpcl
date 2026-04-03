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
        Schema::table('pesan_was', function (Blueprint $table) {
            $table->integer('id_no_pengirim')->after('id');
            $table->string('no_pengirim')->after('id_no_pengirim');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesan_was', function (Blueprint $table) {
            $table->dropColumn('id_no_pengirim');
            $table->dropColumn('no_pengirim');
        });
    }
};
