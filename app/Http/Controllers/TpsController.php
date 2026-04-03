<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use App\Models\Tps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;


class TpsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table(Tps::$view)->select('id', 'nama_tps', 'alamat_tps', 'alamat_lengkap_tps', 'nama_kelurahan', 'nama_kecamatan', 'nama_kota', 'nama_provinsi', 'crt_user_name', 'created_at');
            return DataTables::of($query)
                ->filter(function ($query) use ($request) {
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
                        <div class="btn btn-sm btn-success" id="btnEdit" onclick="editData(' . $row->id . ')"><i class="fa fa-edit"></i></div>
                        <div class="btn btn-sm btn-danger" id="btnDelete" onclick="deleteData(' . $row->id . ')"><i class="fa fa-times-circle"></i></div>
                    </div>';
                })
                ->rawColumns(['action_button'])
                ->make(true);
        }

        return view('tps.index');
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
        if ($act == 'edit') {
            $validasi = $this->validasiTPS($request->id_kelurahan, $request->nama_tps, $id);
            if (! $validasi['status']) {
                $response = [
                    'status' => false,
                    'message' => $validasi['message'],
                ];
            } else {
                $save = Tps::where('id', $id)->update([
                    'id_kelurahan' => $request->id_kelurahan,
                    'nama_tps' => $request->nama_tps,
                    'alamat_tps' => $request->alamat_tps,
                    'upd_id_user' => (int) $idUser,
                ]);
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
        } else {
            $validasi = $this->validasiTPS($request->id_kelurahan, $request->nama_tps);
            if (! $validasi['status']) {
                $response = [
                    'status' => false,
                    'message' => $validasi['message'],
                ];
            } else {
                $save = Tps::create([
                    'id_kelurahan' => $request->id_kelurahan,
                    'nama_tps' => $request->nama_tps,
                    'alamat_tps' => $request->alamat_tps,
                    'crt_id_user' => (int) $idUser,
                ]);
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
        }
        return $response;
    }

    function validasiTPS($id_kelurahan, $nama_tps, $id = null)
    {
        if ($id == null || $id == '') {
            $data = Tps::where(['id_kelurahan' => $id_kelurahan, 'nama_tps' => $nama_tps])->get();
        } else {
            $data = Tps::where(['id_kelurahan' => $id_kelurahan, 'nama_tps' => $nama_tps])->where('id', '<>', $id)->get();
        }
        if (count($data) > 0) {
            $response = [
                'status' => false,
                'message' => 'Nama TPS "' . $nama_tps . '" sudah digunakan untuk kelurahan yang sama. Silahkan gunakan nama TPS yang lain.',
            ];
        } else {
            $response = ['status' => true];
        }
        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = DB::table(Tps::$view)->where(['id' => $id])->first();
        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

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
        $users = Tps::find($id);
        $save = $users->delete();
        if ($save) {
            $idUser = Auth::id();
            $users->update([
                'del_id_user' => (int) $idUser,
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

    public function list(Request $request)
    {
        $builder = DB::table(Tps::$view);
        if (isset($request->id_provinsi)) {
            $builder = $builder->where('id_provinsi', $request->id_provinsi);
        }
        if (isset($request->id_kota)) {
            $builder = $builder->where('id_kota', $request->id_kota);
        }
        if (isset($request->id_kecamatan)) {
            $builder = $builder->where('id_kecamatan', $request->id_kecamatan);
        }
        if (isset($request->id_kelurahan)) {
            $builder = $builder->where('id_kelurahan', $request->id_kelurahan);
        }
        $result = $builder->get();
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
                ob_start();
                $data['sheetData'] = $sheetData;
                echo view('tps.preview', $data);
                $content = ob_get_clean();
                return ['status' => true, 'html' => response($content)];
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                return ['status' => false, 'message' => 'Error reading spreadsheet file' . $e->getMessage()];
            }
        }
    }

    function uploadDataExcel(Request $request)
    {
        set_time_limit(0);
        $idUser = Auth::id();
        $file = $request->file('file');
        $id_kelompok = $request->id_kelompok;
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
                $data_save = [];
                $error_kelurahan = false;
                $list_kelurahan = [];
                foreach (array_slice($sheetData, 1) as $sd) {
                    $row_data = [];
                    $kota = validasiKabKota($sd['C']);
                    $kecamatan = $sd['D'];
                    $kelurahan = $sd['E'];
                    $cekKelurahan = DB::table(Kelurahan::$view)->where(['nama_kelurahan' => $kelurahan, 'nama_kecamatan' => $kecamatan, 'nama_kota' => $kota]);
                    if ($cekKelurahan->count() == 0) {
                        $error_kelurahan = true;
                        $list_kelurahan[] = $kelurahan;
                    } else {
                        $result_kelurahan=$cekKelurahan->first();
                        $row_data = [
                            'nama_tps' => $sd['G'],
                            'id_kelurahan' => $result_kelurahan->id_kelurahan,
                            'alamat_tps' => $sd['F'],
                            'jumlah_pemilih' => $sd['H'],
                            'crt_id_user' => $idUser,
                            'created_at' => Carbon::now()
                        ];
                        $data_save[] = $row_data;
                    }
                }
                // if ($error_kelurahan) {
                //     $err_kel=(array_unique($list_kelurahan));
                //     $hasil_kel='';
                //     foreach($err_kel as $key =>$val){
                //         $hasil_kel.='- '.$val.'<br>';
                //     }
                //     return [
                //         'status' => false,
                //         'message' => 'Desa/Kelurahan berikut tidak terdaftar. ' . $hasil_kel . '. Mohon periksa kembali data anda, atau hubungi admin jika ada kesalahan data master. '
                //     ];
                // } else {
                    $saveAll = Tps::insert($data_save);
                    if ($saveAll) {
                        return ['status' => true];
                    } else {
                        return ['status' => false];
                    }
                // }
                // return ['status' => true, 'html' => response($content)];
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                return ['status' => false, 'message' => 'Error reading spreadsheet file' . $e->getMessage()];
            }
        }
    }
}
