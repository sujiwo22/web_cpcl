<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KecamatanSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('kecamatans')->insert([

            // ======================
            // KABUPATEN AGAM (1301)
            // ======================
            ['id_kecamatan' => 130101, 'id_kota' => 1301, 'nama_kecamatan' => 'Lubuk Basung', 'crt_id_user' => 1, 'created_at' => $now],
            ['id_kecamatan' => 130102, 'id_kota' => 1301, 'nama_kecamatan' => 'Tanjung Mutiara', 'crt_id_user' => 1, 'created_at' => $now],
            ['id_kecamatan' => 130103, 'id_kota' => 1301, 'nama_kecamatan' => 'Ampek Nagari', 'crt_id_user' => 1, 'created_at' => $now],
            ['id_kecamatan' => 130104, 'id_kota' => 1301, 'nama_kecamatan' => 'Tanjung Raya', 'crt_id_user' => 1, 'created_at' => $now],
            ['id_kecamatan' => 130105, 'id_kota' => 1301, 'nama_kecamatan' => 'Matur', 'crt_id_user' => 1, 'created_at' => $now],

            // ======================
            // DHARMASRAYA (1302)
            // ======================
            ['id_kecamatan' => 130201, 'id_kota' => 1302, 'nama_kecamatan' => 'Pulau Punjung', 'crt_id_user' => 1, 'created_at' => $now],
            ['id_kecamatan' => 130202, 'id_kota' => 1302, 'nama_kecamatan' => 'Sitiung', 'crt_id_user' => 1, 'created_at' => $now],

            // ======================
            // LIMA PULUH KOTA (1304)
            // ======================
            ['id_kecamatan' => 130401, 'id_kota' => 1304, 'nama_kecamatan' => 'Harau', 'crt_id_user' => 1, 'created_at' => $now],
            ['id_kecamatan' => 130402, 'id_kota' => 1304, 'nama_kecamatan' => 'Pangkalan', 'crt_id_user' => 1, 'created_at' => $now],

            // ======================
            // PADANG PARIAMAN (1305)
            // ======================
            ['id_kecamatan' => 130501, 'id_kota' => 1305, 'nama_kecamatan' => 'Batang Anai', 'crt_id_user' => 1, 'created_at' => $now],
            ['id_kecamatan' => 130502, 'id_kota' => 1305, 'nama_kecamatan' => 'Nan Sabaris', 'crt_id_user' => 1, 'created_at' => $now],

            // ======================
            // PASAMAN (1306)
            // ======================
            ['id_kecamatan' => 130601, 'id_kota' => 1306, 'nama_kecamatan' => 'Lubuk Sikaping', 'crt_id_user' => 1, 'created_at' => $now],
            ['id_kecamatan' => 130602, 'id_kota' => 1306, 'nama_kecamatan' => 'Bonjol', 'crt_id_user' => 1, 'created_at' => $now],

            // ======================
            // PASAMAN BARAT (1307)
            // ======================
            ['id_kecamatan' => 130701, 'id_kota' => 1307, 'nama_kecamatan' => 'Simpang Empat', 'crt_id_user' => 1, 'created_at' => $now],
            ['id_kecamatan' => 130702, 'id_kota' => 1307, 'nama_kecamatan' => 'Kinali', 'crt_id_user' => 1, 'created_at' => $now],

            // ======================
            // PESISIR SELATAN (1308)
            // ======================
            ['id_kecamatan' => 130801, 'id_kota' => 1308, 'nama_kecamatan' => 'IV Jurai', 'crt_id_user' => 1, 'created_at' => $now],
            ['id_kecamatan' => 130802, 'id_kota' => 1308, 'nama_kecamatan' => 'Batang Kapas', 'crt_id_user' => 1, 'created_at' => $now],

            // ======================
            // SIJUNJUNG (1309)
            // ======================
            ['id_kecamatan' => 130901, 'id_kota' => 1309, 'nama_kecamatan' => 'Sijunjung', 'crt_id_user' => 1, 'created_at' => $now],
            ['id_kecamatan' => 130902, 'id_kota' => 1309, 'nama_kecamatan' => 'Kupitan', 'crt_id_user' => 1, 'created_at' => $now],

            // ======================
            // SOLOK (1310)
            // ======================
            ['id_kecamatan' => 131001, 'id_kota' => 1310, 'nama_kecamatan' => 'Gunung Talang', 'crt_id_user' => 1, 'created_at' => $now],
            ['id_kecamatan' => 131002, 'id_kota' => 1310, 'nama_kecamatan' => 'X Koto Singkarak', 'crt_id_user' => 1, 'created_at' => $now],

            // ======================
            // TANAH DATAR (1312)
            // ======================
            ['id_kecamatan' => 131201, 'id_kota' => 1312, 'nama_kecamatan' => 'Lima Kaum', 'crt_id_user' => 1, 'created_at' => $now],
            ['id_kecamatan' => 131202, 'id_kota' => 1312, 'nama_kecamatan' => 'Tanjung Emas', 'crt_id_user' => 1, 'created_at' => $now],

            // ======================
            // KOTA PADANG (1372)
            // ======================
            ['id_kecamatan' => 137201, 'id_kota' => 1372, 'nama_kecamatan' => 'Padang Barat', 'crt_id_user' => 1, 'created_at' => $now],
            ['id_kecamatan' => 137202, 'id_kota' => 1372, 'nama_kecamatan' => 'Padang Timur', 'crt_id_user' => 1, 'created_at' => $now],
            ['id_kecamatan' => 137203, 'id_kota' => 1372, 'nama_kecamatan' => 'Padang Selatan', 'crt_id_user' => 1, 'created_at' => $now],
            ['id_kecamatan' => 137204, 'id_kota' => 1372, 'nama_kecamatan' => 'Kuranji', 'crt_id_user' => 1, 'created_at' => $now],
            ['id_kecamatan' => 137205, 'id_kota' => 1372, 'nama_kecamatan' => 'Koto Tangah', 'crt_id_user' => 1, 'created_at' => $now],

            // ======================
            // KOTA BUKITTINGGI (1371)
            // ======================
            ['id_kecamatan' => 137101, 'id_kota' => 1371, 'nama_kecamatan' => 'Guguk Panjang', 'crt_id_user' => 1, 'created_at' => $now],
            ['id_kecamatan' => 137102, 'id_kota' => 1371, 'nama_kecamatan' => 'Mandiangin Koto Selayan', 'crt_id_user' => 1, 'created_at' => $now],

        ]);
    }
}