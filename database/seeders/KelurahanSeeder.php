<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KelurahanSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('kelurahans')->insert([

            // ===============================
            // AGAM - LUBUK BASUNG (130101)
            // ===============================
            ['id_kelurahan'=>13010101,'id_kecamatan'=>130101,'nama_kelurahan'=>'Lubuk Basung','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13010102,'id_kecamatan'=>130101,'nama_kelurahan'=>'Garagahan','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13010103,'id_kecamatan'=>130101,'nama_kelurahan'=>'Manggopoh','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13010104,'id_kecamatan'=>130101,'nama_kelurahan'=>'Kampung Tangah','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // AGAM - TANJUNG MUTIARA (130102)
            // ===============================
            ['id_kelurahan'=>13010201,'id_kecamatan'=>130102,'nama_kelurahan'=>'Tiku Selatan','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13010202,'id_kecamatan'=>130102,'nama_kelurahan'=>'Tiku Utara','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13010203,'id_kecamatan'=>130102,'nama_kelurahan'=>'Tiku V Jorong','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // AGAM - TANJUNG RAYA (130104)
            // ===============================
            ['id_kelurahan'=>13010401,'id_kecamatan'=>130104,'nama_kelurahan'=>'Maninjau','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13010402,'id_kecamatan'=>130104,'nama_kelurahan'=>'Sungai Batang','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PADANG - PADANG BARAT (137201)
            // ===============================
            ['id_kelurahan'=>13720101,'id_kecamatan'=>137201,'nama_kelurahan'=>'Belakang Tangsi','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13720102,'id_kecamatan'=>137201,'nama_kelurahan'=>'Kampung Jao','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13720103,'id_kecamatan'=>137201,'nama_kelurahan'=>'Olo','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13720104,'id_kecamatan'=>137201,'nama_kelurahan'=>'Rimbo Kaluang','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PADANG - PADANG TIMUR (137202)
            // ===============================
            ['id_kelurahan'=>13720201,'id_kecamatan'=>137202,'nama_kelurahan'=>'Andalas','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13720202,'id_kecamatan'=>137202,'nama_kelurahan'=>'Parak Gadang Timur','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PADANG - KOTO TANGAH (137205)
            // ===============================
            ['id_kelurahan'=>13720501,'id_kecamatan'=>137205,'nama_kelurahan'=>'Air Pacah','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13720502,'id_kecamatan'=>137205,'nama_kelurahan'=>'Lubuk Buaya','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13720503,'id_kecamatan'=>137205,'nama_kelurahan'=>'Parupuk Tabing','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13720504,'id_kecamatan'=>137205,'nama_kelurahan'=>'Batipuh Panjang','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // BUKITTINGGI (1371)
            // ===============================
            ['id_kelurahan'=>13710101,'id_kecamatan'=>137101,'nama_kelurahan'=>'Benteng Pasar Atas','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13710102,'id_kecamatan'=>137101,'nama_kelurahan'=>'Kayu Kubu','crt_id_user'=>1,'created_at'=>$now],

                        // ===============================
            // PADANG - PADANG SELATAN (137203)
            // ===============================
            ['id_kelurahan'=>13720301,'id_kecamatan'=>137203,'nama_kelurahan'=>'Air Manis','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13720302,'id_kecamatan'=>137203,'nama_kelurahan'=>'Gates Nan XX','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13720303,'id_kecamatan'=>137203,'nama_kelurahan'=>'Mata Air','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13720304,'id_kecamatan'=>137203,'nama_kelurahan'=>'Seberang Padang','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PADANG - KURANJI (137204)
            // ===============================
            ['id_kelurahan'=>13720401,'id_kecamatan'=>137204,'nama_kelurahan'=>'Kalumbuk','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13720402,'id_kecamatan'=>137204,'nama_kelurahan'=>'Korong Gadang','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13720403,'id_kecamatan'=>137204,'nama_kelurahan'=>'Pasar Ambacang','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13720404,'id_kecamatan'=>137204,'nama_kelurahan'=>'Anduring','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PADANG PARIAMAN - BATANG ANAI (130501)
            // ===============================
            ['id_kelurahan'=>13050101,'id_kecamatan'=>130501,'nama_kelurahan'=>'Ketaping','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13050102,'id_kecamatan'=>130501,'nama_kelurahan'=>'Sungai Buluh','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13050103,'id_kecamatan'=>130501,'nama_kelurahan'=>'Kasang','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PADANG PARIAMAN - NAN SABARIS (130502)
            // ===============================
            ['id_kelurahan'=>13050201,'id_kecamatan'=>130502,'nama_kelurahan'=>'Parit Malintang','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13050202,'id_kecamatan'=>130502,'nama_kelurahan'=>'Padang Bintungan','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PASAMAN - LUBUK SIKAPING (130601)
            // ===============================
            ['id_kelurahan'=>13060101,'id_kecamatan'=>130601,'nama_kelurahan'=>'Aia Manggih','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13060102,'id_kecamatan'=>130601,'nama_kelurahan'=>'Tanjung Baringin','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PASAMAN - BONJOL (130602)
            // ===============================
            ['id_kelurahan'=>13060201,'id_kecamatan'=>130602,'nama_kelurahan'=>'Bonjol','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13060202,'id_kecamatan'=>130602,'nama_kelurahan'=>'Ganggo Mudiak','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PASAMAN BARAT - SIMPANG EMPAT (130701)
            // ===============================
            ['id_kelurahan'=>13070101,'id_kecamatan'=>130701,'nama_kelurahan'=>'Simpang Empat','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13070102,'id_kecamatan'=>130701,'nama_kelurahan'=>'Lingkuang Aua','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PASAMAN BARAT - KINALI (130702)
            // ===============================
            ['id_kelurahan'=>13070201,'id_kecamatan'=>130702,'nama_kelurahan'=>'Kinali','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13070202,'id_kecamatan'=>130702,'nama_kelurahan'=>'Bandarjo','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PESISIR SELATAN - IV JURAI (130801)
            // ===============================
            ['id_kelurahan'=>13080101,'id_kecamatan'=>130801,'nama_kelurahan'=>'Painan','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13080102,'id_kecamatan'=>130801,'nama_kelurahan'=>'Sago','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PESISIR SELATAN - BATANG KAPAS (130802)
            // ===============================
            ['id_kelurahan'=>13080201,'id_kecamatan'=>130802,'nama_kelurahan'=>'Koto Nan Duo','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13080202,'id_kecamatan'=>130802,'nama_kelurahan'=>'IV Koto Hilie','crt_id_user'=>1,'created_at'=>$now],

                        // ===============================
            // PADANG - PADANG SELATAN (137203)
            // ===============================
            ['id_kelurahan'=>13720301,'id_kecamatan'=>137203,'nama_kelurahan'=>'Air Manis','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13720302,'id_kecamatan'=>137203,'nama_kelurahan'=>'Gates Nan XX','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13720303,'id_kecamatan'=>137203,'nama_kelurahan'=>'Mata Air','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13720304,'id_kecamatan'=>137203,'nama_kelurahan'=>'Seberang Padang','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PADANG - KURANJI (137204)
            // ===============================
            ['id_kelurahan'=>13720401,'id_kecamatan'=>137204,'nama_kelurahan'=>'Kalumbuk','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13720402,'id_kecamatan'=>137204,'nama_kelurahan'=>'Korong Gadang','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13720403,'id_kecamatan'=>137204,'nama_kelurahan'=>'Pasar Ambacang','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13720404,'id_kecamatan'=>137204,'nama_kelurahan'=>'Anduring','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PADANG PARIAMAN - BATANG ANAI (130501)
            // ===============================
            ['id_kelurahan'=>13050101,'id_kecamatan'=>130501,'nama_kelurahan'=>'Ketaping','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13050102,'id_kecamatan'=>130501,'nama_kelurahan'=>'Sungai Buluh','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13050103,'id_kecamatan'=>130501,'nama_kelurahan'=>'Kasang','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PADANG PARIAMAN - NAN SABARIS (130502)
            // ===============================
            ['id_kelurahan'=>13050201,'id_kecamatan'=>130502,'nama_kelurahan'=>'Parit Malintang','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13050202,'id_kecamatan'=>130502,'nama_kelurahan'=>'Padang Bintungan','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PASAMAN - LUBUK SIKAPING (130601)
            // ===============================
            ['id_kelurahan'=>13060101,'id_kecamatan'=>130601,'nama_kelurahan'=>'Aia Manggih','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13060102,'id_kecamatan'=>130601,'nama_kelurahan'=>'Tanjung Baringin','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PASAMAN - BONJOL (130602)
            // ===============================
            ['id_kelurahan'=>13060201,'id_kecamatan'=>130602,'nama_kelurahan'=>'Bonjol','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13060202,'id_kecamatan'=>130602,'nama_kelurahan'=>'Ganggo Mudiak','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PASAMAN BARAT - SIMPANG EMPAT (130701)
            // ===============================
            ['id_kelurahan'=>13070101,'id_kecamatan'=>130701,'nama_kelurahan'=>'Simpang Empat','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13070102,'id_kecamatan'=>130701,'nama_kelurahan'=>'Lingkuang Aua','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PASAMAN BARAT - KINALI (130702)
            // ===============================
            ['id_kelurahan'=>13070201,'id_kecamatan'=>130702,'nama_kelurahan'=>'Kinali','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13070202,'id_kecamatan'=>130702,'nama_kelurahan'=>'Bandarjo','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PESISIR SELATAN - IV JURAI (130801)
            // ===============================
            ['id_kelurahan'=>13080101,'id_kecamatan'=>130801,'nama_kelurahan'=>'Painan','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13080102,'id_kecamatan'=>130801,'nama_kelurahan'=>'Sago','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PESISIR SELATAN - BATANG KAPAS (130802)
            // ===============================
            ['id_kelurahan'=>13080201,'id_kecamatan'=>130802,'nama_kelurahan'=>'Koto Nan Duo','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13080202,'id_kecamatan'=>130802,'nama_kelurahan'=>'IV Koto Hilie','crt_id_user'=>1,'created_at'=>$now],

                        // ===============================
            // SOLOK SELATAN - KOTO PARIK GADANG DIATEH (131102)
            // ===============================
            ['id_kelurahan'=>13110201,'id_kecamatan'=>131102,'nama_kelurahan'=>'Pakan Rabaa','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13110202,'id_kecamatan'=>131102,'nama_kelurahan'=>'Pakan Rabaa Tengah','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // SOLOK SELATAN - SANGIR (131103)
            // ===============================
            ['id_kelurahan'=>13110301,'id_kecamatan'=>131103,'nama_kelurahan'=>'Lubuk Gadang','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13110302,'id_kecamatan'=>131103,'nama_kelurahan'=>'Lubuk Gadang Selatan','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // TANAH DATAR - SUNGAI TARAB (131203)
            // ===============================
            ['id_kelurahan'=>13120301,'id_kecamatan'=>131203,'nama_kelurahan'=>'Sungai Tarab','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13120302,'id_kecamatan'=>131203,'nama_kelurahan'=>'Simawang','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // TANAH DATAR - SALIMPAUNG (131204)
            // ===============================
            ['id_kelurahan'=>13120401,'id_kecamatan'=>131204,'nama_kelurahan'=>'Tabek Patah','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13120402,'id_kecamatan'=>131204,'nama_kelurahan'=>'Supayang','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PADANG PANJANG - PADANG PANJANG BARAT (137301)
            // ===============================
            ['id_kelurahan'=>13730101,'id_kecamatan'=>137301,'nama_kelurahan'=>'Pasar Usang','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13730102,'id_kecamatan'=>137301,'nama_kelurahan'=>'Koto Katik','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // PADANG PANJANG - PADANG PANJANG TIMUR (137302)
            // ===============================
            ['id_kelurahan'=>13730201,'id_kecamatan'=>137302,'nama_kelurahan'=>'Ganting','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13730202,'id_kecamatan'=>137302,'nama_kelurahan'=>'Sigando','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // MENTAWAI - SIPORA UTARA (130301)
            // ===============================
            ['id_kelurahan'=>13030101,'id_kecamatan'=>130301,'nama_kelurahan'=>'Tuapeijat','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13030102,'id_kecamatan'=>130301,'nama_kelurahan'=>'Sipora Jaya','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // MENTAWAI - SIPORA SELATAN (130302)
            // ===============================
            ['id_kelurahan'=>13030201,'id_kecamatan'=>130302,'nama_kelurahan'=>'Sioban','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13030202,'id_kecamatan'=>130302,'nama_kelurahan'=>'Matobe','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // AGAM - BANUHAMPU (130106)
            // ===============================
            ['id_kelurahan'=>13010601,'id_kecamatan'=>130106,'nama_kelurahan'=>'Padang Lua','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13010602,'id_kecamatan'=>130106,'nama_kelurahan'=>'Ladang Laweh','crt_id_user'=>1,'created_at'=>$now],

            // ===============================
            // AGAM - CANDUANG (130107)
            // ===============================
            ['id_kelurahan'=>13010701,'id_kecamatan'=>130107,'nama_kelurahan'=>'Canduang Koto Laweh','crt_id_user'=>1,'created_at'=>$now],
            ['id_kelurahan'=>13010702,'id_kecamatan'=>130107,'nama_kelurahan'=>'Lasi','crt_id_user'=>1,'created_at'=>$now],
        ]);
    }
}