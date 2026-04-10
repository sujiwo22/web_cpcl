<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use App\Models\Jabatan;
use App\Models\Anggota;
use App\Models\AnggotaPosisiKelompok;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kementrian;
use App\Models\Penyuluh;
use App\Models\Pic;
use App\Models\Program;
use App\Models\ProgramAlokasi;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

class KelompokController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $action = $request->action;
            $query = DB::table(Kelompok::$view)->select('*');
            if ($action == 'search') {
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if ($request->filled('id_kementrian')) {
                            $query->where('id_kementrian', $request->id_kementrian);
                        }
                        if ($request->filled('id_provinsi')) {
                            $query->where('id_provinsi', $request->id_provinsi);
                        }
                        if ($request->filled('id_kota')) {
                            $query->where('id_kota', $request->id_kota);
                        }
                        if ($request->filled('id_kecamatan')) {
                            $query->where('id_kecamatan', $request->id_kecamatan);
                        }
                        if ($request->filled('id_kelurahan')) {
                            $query->where('id_kelurahan', $request->id_kelurahan);
                        }
                    }, true)
                    ->addIndexColumn()
                    ->addColumn('action_button', function ($row) {
                        return '<div class="btn-group center">
                            <div class="btn btn-sm btn-success" id="btnSelect" onclick="selectDataKelompok(' . $row->id . ',`' . $row->nama_kelompok . '`)"><i class="fa fa-check-circle"></i></div>
                        </div>';
                    })
                    ->rawColumns(['action_button'])
                    ->make(true);
            } else {
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if ($request->filled('id_kementrian')) {
                            $query->where('id_kementrian', $request->id_kementrian);
                        }
                        if ($request->filled('id_provinsi')) {
                            $query->where('id_provinsi', $request->id_provinsi);
                        }
                        if ($request->filled('id_kota')) {
                            $query->where('id_kota', $request->id_kota);
                        }
                        if ($request->filled('id_kecamatan')) {
                            $query->where('id_kecamatan', $request->id_kecamatan);
                        }
                        if ($request->filled('id_kelurahan')) {
                            $query->where('id_kelurahan', $request->id_kelurahan);
                        }
                    }, true)
                    ->addIndexColumn()
                    ->addColumn('action_button', function ($row) {
                        return '<div class="btn-group center">
                        <div class="btn btn-sm btn-info" id="btnDetail" onclick="viewDetail(' . $row->id . ',`' . $row->nama_kelompok . '`)"><i class="fa fa-eye"></i></div>
                        <div class="btn btn-sm btn-warning" id="btnAnggota" onclick="viewAnggota(' . $row->id . ',`' . $row->nama_kelompok . '`)"><i class="fa fa-users"></i></div>
                        <div class="btn btn-sm btn-success" id="btnEdit" onclick="editData(' . $row->id . ')"><i class="fa fa-edit"></i></div>
                        <div class="btn btn-sm btn-danger" id="btnDelete" onclick="deleteData(' . $row->id . ')"><i class="fa fa-times-circle"></i></div>
                    </div>';
                    })
                    ->rawColumns(['action_button'])
                    ->make(true);
            }
        }

        $data['tahun_sekarang'] = date('Y');
        $data['tahun_mulai'] = date('Y') - 2;
        $data['tahun_selesai'] = date('Y') + 5;
        return view('kelompoks.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $idUser = Auth::id();
        $id = $request->id;
        $act = $request->act;
        $data_save = [
            'id_kementrian' => $request->id_kementrian,
            'id_kelurahan' => $request->id_kelurahan,
            'nama_kelompok' => $request->nama_kelompok,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'penanggung_jawab' => $request->penanggung_jawab,
        ];
        if ($act == 'edit') {
            $data = Kelompok::find($id);
            $data_save['upd_id_user'] = (int) $idUser;
            $save = $data->update($data_save);
            if ($save) {
                $response = [
                    'status' => true,
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data. Silahkan anda coba kembali.',
                ];
            }
        } else {
            $data_save['crt_id_user'] = (int) $idUser;
            $save = Kelompok::create($data_save);
            if ($save) {
                $response = [
                    'status' => true,
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data. Silahkan anda coba kembali.',
                ];
            }
        }
        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $result = Kelompok::find($id);
        $result = DB::table(Kelompok::$view)->where('id', $id)->first();
        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Kelompok::find($id);
        $delete = $data->delete();
        if ($delete) {
            $idUser = Auth::id();
            $save = $data->update([
                'del_id_user' => (int) $idUser
            ]);
            $response = [
                'status' => true,
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Terjadi kesalahan saat menghapus data. Silahkan anda coba kembali.',
            ];
        }


        return $response;
    }

    public function list(string $id_kelurahan)
    {
        if ($id_kelurahan == null || $id_kelurahan == 'null') {
            $result = Kelompok::all();
        } else {
            $result = Kelompok::where(['id_kelurahan' => $id_kelurahan])->get();
        }
        return $result;
    }

    function previewDataExcel(Request $request)
    {
        $file = $request->file('file');
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        if ($validator->fails()) {
            return [
                'status' => false,
                'message' => $validator->errors()->first('file'),
            ];
        } else {
            $filePath = $file->getPathname();
            try {
                $spreadsheet = IOFactory::load($filePath);
                $worksheet = $spreadsheet->getActiveSheet();
                $sheetData = $worksheet->toArray(null, true, true, true);
                // echo json_encode($sheetData);
                // exit();
                ob_start();
                $data['sheetData'] = $sheetData;
                echo view('kelompoks.preview', $data);
                $content = ob_get_clean();
                return ['status' => true, 'html' => response($content)];
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                return ['status' => false, 'message' => 'Error reading spreadsheet file' . $e->getMessage()];
            }
        }
    }

    function uploadDataExcel(Request $request)
    {
        $idUser = Auth::id();
        $file = $request->file('file');
        // $id_kelompok = $request->id_kelompok;
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        if ($validator->fails()) {
            return [
                'status' => false,
                'message' => $validator->errors()->first('file'),
            ];
        } else {
            $filePath = $file->getPathname();
            try {
                $spreadsheet = IOFactory::load($filePath);
                $worksheet = $spreadsheet->getActiveSheet();
                $sheetData = $worksheet->toArray(null, true, true, true);
                // $kelompok = DB::table(Kelompok::$view)->where('id', $id_kelompok)->first();
                $nama_kelompok = str_replace('"', '', json_encode($sheetData[3]['C']));
                $alamat = str_replace('"', '', json_encode($sheetData[4]['C']));
                $kota = str_replace('"', '', json_encode($sheetData[5]['C']));
                $kecamatan = str_replace('"', '', json_encode($sheetData[6]['C']));
                $kelurahan = str_replace('"', '', json_encode($sheetData[7]['C']));
                $jenis_bantuan = str_replace('"', '', json_encode($sheetData[8]['C']));
                $jumlah_bantuan = str_replace('"', '', json_encode($sheetData[9]['C']));
                $tahun_bantuan = str_replace('"', '', json_encode($sheetData[10]['C']));
                $nama_penyuluh = str_replace('"', '', json_encode($sheetData[11]['C']));
                $no_hp_penyuluh = preg_replace('/[^a-zA-Z0-9]/', '', json_encode($sheetData[12]['C']));
                $penanggung_jawab = str_replace('"', '', json_encode($sheetData[13]['C']));
                $no_hp_penanggung_jawab = preg_replace('/[^a-zA-Z0-9]/', '', json_encode($sheetData[14]['C']));
                $kementrian = str_replace('"', '', json_encode($sheetData[15]['C']));

                $kota = validasiKabKota($kota);
                $error_kota = false;
                $error_kecamatan = false;
                $error_kelurahan = false;
                $error_jenis_bantuan = false;
                $error_penyuluh = false;
                $error_penanggung_jawab = false;
                $error_kementrian = false;

                // Validasi Kementrian
                $cekKementrian = Kementrian::where('nama_kementrian', $kementrian)->orWhere('singkatan', $kementrian);
                if ($cekKementrian->count() == 0) {
                    $error_kementrian = true;
                    $save_kementrian = Kementrian::create([
                        'nama_kementrian' => $kementrian,
                        'singkatan' => $kementrian,
                        'crt_id_user' => (int) $idUser,
                    ]);
                    $id_kementrian = $save_kementrian->id;
                } else {
                    $result_kemenrtrian = $cekKementrian->first();
                    $id_kementrian = $result_kemenrtrian->id;
                }
                // if ($error_kementrian) {
                //     return [
                //         'status' => false,
                //         'message' => 'Nama/Singkatan Kementrian ' . $kementrian . ' tidak terdaftar. Silahkan cek kembali data anda. Terima Kasih...'
                //     ];
                // } else {
                // Validasi Nama Kab/Kota
                $cekKota = Kota::where('nama_kota', $kota);
                if ($cekKota->count() == 0) {
                    $error_kota = true;
                    $id_kota_prev = Kota::max('id_kota');
                    $id_kota = (int)$id_kota_prev + 1;
                    $save_kota = Kota::create([
                        'id_provinsi' => '13',
                        'id_kota' => $id_kota,
                        'nama_kota' => $kota,
                        'crt_id_user' => $idUser
                    ]);
                    // $id_kota = $save_kota->id;
                } else {
                    $result_kota = $cekKota->first();
                    $id_kota = $result_kota->id_kota;
                }
                // if ($error_kota) {
                //     return [
                //         'status' => false,
                //         'message' => 'Nama Kab./Kota ' . $kota . ' tidak terdaftar. Silahkan cek kembali data anda. Terima Kasih...'
                //     ];
                // } else {
                // Validasi Nama Kecamatan
                $cekKecamatan = Kecamatan::where(['nama_kecamatan' => $kecamatan, 'id_kota' => $id_kota]);
                if ($cekKecamatan->count() == 0) {
                    $error_kecamatan = true;
                    $id_kecamatan_prev = Kecamatan::max('id_kecamatan');
                    $id_kecamatan = (int)$id_kecamatan_prev + 1;
                    $save_kecamatan = Kecamatan::create([
                        'id_kecamatan' => $id_kecamatan,
                        'id_kota' => $id_kota,
                        'nama_kecamatan' => $kecamatan,
                        'crt_id_user' => $idUser
                    ]);
                    // $id_kecamatan = $save_kecamatan->id;
                } else {
                    $result_kecamatan = $cekKecamatan->first();
                    $id_kecamatan = $result_kecamatan->id_kecamatan;
                }
                // if ($error_kecamatan) {
                //     return [
                //         'status' => false,
                //         'message' => 'Nama Kecamatan ' . $kecamatan . ' tidak terdaftar. Silahkan cek kembali data anda. Terima Kasih...'
                //     ];
                // } else {
                // Validasi Nama Kelurahan
                $cekKelurahan = DB::table(Kelurahan::$view)->where(['nama_kelurahan' => $kelurahan, 'nama_kecamatan' => $kecamatan, 'nama_kota' => $kota]);
                if ($cekKelurahan->count() == 0) {
                    $error_kelurahan = true;
                    $id_kelurahan_prev = Kelurahan::max('id_kelurahan');
                    $id_kelurahan = (int)$id_kelurahan_prev + 1;
                    $save_kelurahan = Kelurahan::create([
                        'id_kelurahan' => $id_kelurahan,
                        'id_kecamatan' => $id_kecamatan,
                        'nama_kelurahan' => $kelurahan,
                        'crt_id_user' => $idUser
                    ]);
                    // $id_kelurahan = $save_kelurahan->id;
                } else {
                    $result_kelurahan = $cekKelurahan->first();
                    $id_kelurahan = $result_kelurahan->id_kelurahan;
                }
                // if ($error_kelurahan) {
                //     return [
                //         'status' => false,
                //         'message' => 'Nama Kelurahan ' . $kelurahan . ' pada Kecamatan ' . $kecamatan . ' dan Kab/Kota ' . $kota . ' tidak terdaftar. Silahkan cek kembali data anda. Terima Kasih...'
                //     ];
                // } else {
                // Validasi Nama Program/Bantuan
                $cekBantuan = Program::where('nama_program');
                if ($cekBantuan->count() == 0) {
                    $error_jenis_bantuan = true;
                    $save_program = Program::create([
                        'nama_program' => $jenis_bantuan,
                        'crt_id_user' => $idUser
                    ]);
                    $id_program = $save_program->id;
                } else {
                    $result_program = $cekBantuan->first();
                    $id_program = $result_program->id;
                }
                // if ($error_jenis_bantuan) {
                //     return [
                //         'status' => false,
                //         'message' => 'Jenis Bantuan ' . $jenis_bantuan . ' tidak terdaftar. Silahkan cek kembali data anda. Terima Kasih...'
                //     ];
                // } else {
                // Validasi Nama Penyuluh
                $cekPenyuluh = Penyuluh::where('nama_penyuluh', $nama_penyuluh);
                if ($cekPenyuluh->count() == 0) {
                    $error_penyuluh = true;
                    $save_penyuluh = Penyuluh::create([
                        'nama_penyuluh' => $nama_penyuluh,
                        'contact_person' => $no_hp_penyuluh,
                        'crt_id_user' => $idUser
                    ]);
                    $id_penyuluh = $save_penyuluh->id;
                } else {
                    $result_penyuluh = $cekPenyuluh->first();
                    $id_penyuluh = $result_penyuluh->id;
                }

                // Validasi PIC
                $cekPIC = Pic::where('nama_pic', $penanggung_jawab);
                if ($cekPIC->count() == 0) {
                    $error_penanggung_jawab = true;
                    $save_pic = Pic::create([
                        'nama_pic' => $penanggung_jawab,
                        'contact_person' => $no_hp_penanggung_jawab,
                        'crt_id_user' => $idUser
                    ]);
                    $id_pic = $save_pic->id;
                } else {
                    $result_pic = $cekPIC->first();
                    $id_pic = $result_pic->id;
                }

                // Validasi Alokasi Program
                $cekAlokasi = ProgramAlokasi::where([
                    'id_program' => $id_program,
                    'id_kementrian' => $id_kementrian,
                    'tahun' => $tahun_bantuan
                ]);
                if ($cekAlokasi->count() == 0) {
                    $error_alokasi = true;
                    $save_alokasi = ProgramAlokasi::create([
                        'tahun' => $tahun_bantuan,
                        'id_kementrian' => $id_kementrian,
                        'id_program' => $id_program,
                        'crt_id_user' => $idUser
                    ]);
                    $id_program_alokasi = $save_alokasi->id;
                } else {
                    $result_alokasi = $cekAlokasi->first();
                    $id_program_alokasi = $result_alokasi->id;
                }

                // Save Kelompok
                $cekKelompok = Kelompok::where(['nama_kelompok' => $nama_kelompok, 'id_kementrian' => $id_kementrian, 'id_kelurahan' => $id_kelurahan]);
                if ($cekKelompok->count() == 0) {
                    $save_kelompok = Kelompok::create([
                        'id_kementrian' => $id_kementrian,
                        'nama_kelompok' => $nama_kelompok,
                        'alamat' => $alamat,
                        'id_kelurahan' => $id_kelurahan,
                        'no_hp' => $no_hp_penanggung_jawab,
                        'penanggung_jawab' => $penanggung_jawab,
                        'crt_id_user' => $idUser
                    ]);
                    $id_kelompok = $save_kelompok->id;
                } else {
                    $result_kelompok = $cekKelompok->first();
                    $id_kelompok = $result_kelompok->id;
                }

                // Save Proposal
                if ($jenis_bantuan != '' && $jumlah_bantuan != '' && $tahun_bantuan != '') {
                    $cekProposal = Proposal::where(['id_kelompok' => $id_kelompok, 'id_program' => $id_program, 'tahun' => $tahun_bantuan]);
                    if ($cekProposal->count() == 0) {
                        $save_proposal = Proposal::create([
                            'tahun' => $tahun_bantuan,
                            'status_proposal' => 'N',
                            'id_kelompok' => $id_kelompok,
                            'nama_kelompok' => $nama_kelompok,
                            'alamat_kelompok' => $alamat,
                            'id_program_alokasi' => $id_program_alokasi,
                            'id_program' => $id_program,
                            'jenis_bantuan' => $jenis_bantuan,
                            'jumlah_bantuan' => $jumlah_bantuan,
                            'id_pic_penyuluh' => $id_penyuluh,
                            'nama_penyuluh' => $nama_penyuluh,
                            'contact_person_penyuluh' => $no_hp_penyuluh,
                            'id_pic_penanggung_jawab' => $id_pic,
                            'nama_penanggung_jawab' => $penanggung_jawab,
                            'contact_person_penanggung_jawab' => $no_hp_penanggung_jawab,
                            'crt_id_user' => $idUser
                        ]);
                    } else {
                        $result_proposal = $cekProposal->first();
                        $update_proposal = $result_proposal->update([
                            'jumlah_bantuan' => $jumlah_bantuan,
                            'id_pic_penyuluh' => $id_penyuluh,
                            'nama_penyuluh' => $nama_penyuluh,
                            'contact_person_penyuluh' => $no_hp_penyuluh,
                            'id_pic_penanggung_jawab' => $id_pic,
                            'nama_penanggung_jawab' => $penanggung_jawab,
                            'contact_person_penanggung_jawab' => $no_hp_penanggung_jawab,
                            'upd_id_user' => $idUser
                        ]);
                    }
                }

                $data_save = [];
                $error_phone = false;
                $error_save_anggota = false;
                $error_save_anggota_posisi = false;

                foreach (array_slice($sheetData, 16) as $sd) {
                    if (!preg_match('/^(\+62|62|0)8[1-9][0-9]{7,10}$/', $sd['E'])) {
                        $error_phone = true;
                    }
                    $row_data = [];
                    $jabatan = $sd['D'] == '' ? 'Anggota' : $sd['D'];
                    $cekJab = Jabatan::where('nama_jabatan', $jabatan)->first();
                    if ($cekJab->count() == 0) {
                        $saveJabatan = Jabatan::create([
                            'nama_jabatan' => $jabatan,
                            'crt_id_user' => $idUser,
                        ]);
                        $id_jabatan = $saveJabatan->id;
                    } else {
                        $id_jabatan = $cekJab->id;
                    }
                    // Perlu cek apakah anggota sudah terdaftar berdasarkan NIK
                    $error_proses = false;
                    $cekNIK = Anggota::where('nik', $sd['C']);
                    if ($cekNIK->count() == 0) {
                        $row_data = [
                            'nik' => preg_replace('/[^a-zA-Z0-9]/', '', $sd['C']),
                            'nama_anggota' => $sd['B'],
                            'id_jabatan' => $id_jabatan,
                            'no_hp' => preg_replace('/[^a-zA-Z0-9]/', '', $sd['E']),
                            'alamat' => $sd['F'],
                            'id_kelompok' => $id_kelompok,
                            'id_kelurahan' => $id_kelurahan,
                            'crt_id_user' => $idUser,
                            'created_at' => Carbon::now()
                        ];
                        $save_anggota = Anggota::create($row_data);
                        if ($save_anggota) {
                            $id_anggota = $save_anggota->id;
                        } else {
                            $error_save_anggota = true;
                            $error_proses = true;
                        }
                        // $data_save[] = $row_data;
                    } else {
                        $result_anggota = $cekNIK->first();
                        $id_anggota = $result_anggota->id;
                    }

                    if (!$error_proses) {
                        $save_anggota_posisi = [
                            'id_anggota' => $id_anggota,
                            'id_kelompok' => $id_kelompok,
                            'crt_id_user' => $idUser,
                            'created_at' => Carbon::now()
                        ];
                        $saveDataPosisi = AnggotaPosisiKelompok::create($save_anggota_posisi);
                        if (!$saveDataPosisi) {
                            $error_save_anggota_posisi = true;
                        }
                    }

                    // tambahkan array untuk save data ke table anggota kelompok (mapping anggota per kelompok)
                }
                if ($error_phone) {
                    return [
                        'status' => false,
                        'message' => 'Beberapa nomor handphone tidak sesuai format. Format No HP diawali dengan: +628,628 atau 08. Silahkan cek kembali data anda. Terima Kasih...'
                    ];
                } else {
                    if ($error_save_anggota) {
                        return [
                            'status' => false,
                            'message' => 'Error saat create data anggota. Silahkan cek kembali data anda. Terima Kasih...'
                        ];
                    } else {
                        if ($error_save_anggota_posisi) {
                            return [
                                'status' => false,
                                'message' => 'Error saat menyimpan data posisi anggota. Silahkan cek kembali data anda. Terima Kasih...'
                            ];
                        } else {
                            return ['status' => true];
                        }
                    }
                    // $saveAll = Anggota::insert($data_save);
                    // if ($saveAll) {
                    // } else {
                    //     return ['status' => false];
                    // }
                }
                //             }
                //         }
                //     }
                // }
                // }
                // return ['status' => true, 'html' => response($content)];
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                return ['status' => false, 'message' => 'Error reading spreadsheet file' . $e->getMessage()];
            }
        }
    }
}
