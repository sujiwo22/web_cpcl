<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KotaSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('kotas')->insert([
            [
                'id_kota' => 1301,
                'id_provinsi' => 1001,
                'nama_kota' => 'Kabupaten Agam',
                'crt_id_user' => 1,
                'created_at' => $now,
            ],
            [
                'id_kota' => 1302,
                'id_provinsi' => 1001,
                'nama_kota' => 'Kabupaten Dharmasraya',
                'crt_id_user' => 1,
                'created_at' => $now,
            ],
            [
                'id_kota' => 1303,
                'id_provinsi' => 1001,
                'nama_kota' => 'Kabupaten Kepulauan Mentawai',
                'crt_id_user' => 1,
                'created_at' => $now,
            ],
            [
                'id_kota' => 1304,
                'id_provinsi' => 1001,
                'nama_kota' => 'Kabupaten Lima Puluh Kota',
                'crt_id_user' => 1,
                'created_at' => $now,
            ],
            [
                'id_kota' => 1305,
                'id_provinsi' => 1001,
                'nama_kota' => 'Kabupaten Padang Pariaman',
                'crt_id_user' => 1,
                'created_at' => $now,
            ],
            [
                'id_kota' => 1306,
                'id_provinsi' => 1001,
                'nama_kota' => 'Kabupaten Pasaman',
                'crt_id_user' => 1,
                'created_at' => $now,
            ],
            [
                'id_kota' => 1307,
                'id_provinsi' => 1001,
                'nama_kota' => 'Kabupaten Pasaman Barat',
                'crt_id_user' => 1,
                'created_at' => $now,
            ],
            [
                'id_kota' => 1308,
                'id_provinsi' => 1001,
                'nama_kota' => 'Kabupaten Pesisir Selatan',
                'crt_id_user' => 1,
                'created_at' => $now,
            ],
            [
                'id_kota' => 1309,
                'id_provinsi' => 1001,
                'nama_kota' => 'Kabupaten Sijunjung',
                'crt_id_user' => 1,
                'created_at' => $now,
            ],
            [
                'id_kota' => 1310,
                'id_provinsi' => 1001,
                'nama_kota' => 'Kabupaten Solok',
                'crt_id_user' => 1,
                'created_at' => $now,
            ],
            [
                'id_kota' => 1311,
                'id_provinsi' => 1001,
                'nama_kota' => 'Kabupaten Solok Selatan',
                'crt_id_user' => 1,
                'created_at' => $now,
            ],
            [
                'id_kota' => 1312,
                'id_provinsi' => 1001,
                'nama_kota' => 'Kabupaten Tanah Datar',
                'crt_id_user' => 1,
                'created_at' => $now,
            ],
            [
                'id_kota' => 1371,
                'id_provinsi' => 1001,
                'nama_kota' => 'Kota Bukittinggi',
                'crt_id_user' => 1,
                'created_at' => $now,
            ],
            [
                'id_kota' => 1372,
                'id_provinsi' => 1001,
                'nama_kota' => 'Kota Padang',
                'crt_id_user' => 1,
                'created_at' => $now,
            ],
            [
                'id_kota' => 1373,
                'id_provinsi' => 1001,
                'nama_kota' => 'Kota Padang Panjang',
                'crt_id_user' => 1,
                'created_at' => $now,
            ],
            [
                'id_kota' => 1374,
                'id_provinsi' => 1001,
                'nama_kota' => 'Kota Pariaman',
                'crt_id_user' => 1,
                'created_at' => $now,
            ],
            [
                'id_kota' => 1375,
                'id_provinsi' => 1001,
                'nama_kota' => 'Kota Payakumbuh',
                'crt_id_user' => 1,
                'created_at' => $now,
            ],
            [
                'id_kota' => 1376,
                'id_provinsi' => 1001,
                'nama_kota' => 'Kota Sawahlunto',
                'crt_id_user' => 1,
                'created_at' => $now,
            ],
            [
                'id_kota' => 1377,
                'id_provinsi' => 1001,
                'nama_kota' => 'Kota Solok',
                'crt_id_user' => 1,
                'created_at' => $now,
            ],
        ]);
    }
}