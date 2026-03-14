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
            CREATE VIEW anggota_view 
            AS
            SELECT a.*,a0.nama_jabatan,a1.nama_kelompok, a2.nama_kelurahan,b.id_kecamatan, b.nama_kecamatan,b.id_kota, c.nama_kota,c.id_provinsi,d.nama_provinsi, e.name crt_user_name,f.name upd_user_name,
            CONCAT(a.alamat,', Kel/Desa: ',a2.nama_kelurahan,', Kec: ',b.nama_kecamatan,', Kab/Kota: ',c.nama_kota,', Prov: ',d.nama_provinsi) alamat_lengkap_anggota  
            FROM anggotas a 
            JOIN jabatans a0 ON a.id_jabatan=a0.id
            JOIN kelompoks a1 ON a.id_kelompok=a1.id
            JOIN kelurahans a2 ON a1.id_kelurahan=a2.id_kelurahan
            JOIN kecamatans b ON a2.id_kecamatan=b.id_kecamatan 
            JOIN kotas c on b.id_kota=c.id_kota
            JOIN provinsis d on c.id_provinsi=d.id_provinsi
            LEFT JOIN users e on a.crt_id_user=e.id
            LEFT JOIN users f on a.upd_id_user=f.id WHERE a.deleted_at IS NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       DB::statement("DROP VIEW anggota_view");
    }
};
