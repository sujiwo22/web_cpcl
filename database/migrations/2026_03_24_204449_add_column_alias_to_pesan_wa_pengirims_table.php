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
        Schema::table('pesan_wa_pengirims', function (Blueprint $table) {
            $table->string('alias')->nullable(true)->default(null)->after('no_pengirim');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesan_wa_pengirims', function (Blueprint $table) {
            $table->dropColumn('alias');
        });
    }
};
