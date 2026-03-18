<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use App\Models\Anggota;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LDAP\Result;
use Yajra\DataTables\Facades\DataTables;
// use App\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Carbon\Carbon;


class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $data = [
        //     'id_provinsi' => null,
        //     'id_kota' => null,
        //     'id_kecamatan' => null,
        //     'id_kelurahan' => null,
        //     'id_kelompok' => null
        // ];
        // if (isset($request->id)) {
        //     $kelompok = DB::table(Kelompok::$view)->where('id', $request->id)->first();
        //     $data = [
        //         'id_provinsi' => $kelompok->id_provinsi,
        //         'id_kota' => $kelompok->id_kota,
        //         'id_kecamatan' => $kelompok->id_kecamatan,
        //         'id_kelurahan' => $kelompok->id_kelurahan,
        //         'id_kelompok' => $kelompok->id
        //     ];
        // }
        if ($request->ajax()) {
            $query = DB::table(Anggota::$view)->select('*');
            return DataTables::of($query)
                ->filter(function ($query) use ($request) {
                    if ($request->filled('id_kelompok')) {
                        $query->where('id_kelompok', $request->id_kelompok);
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
                    return '<div class="btn-group">
                        <div class="btn btn-sm btn-success" id="btnEdit" onclick="editData(' . $row->id . ')"><i class="fa fa-edit"></i></div>
                        <div class="btn btn-sm btn-danger" id="btnDelete" onclick="deleteData(' . $row->id . ')"><i class="fa fa-times-circle"></i></div>
                    </div>';
                })
                ->rawColumns(['action_button'])
                ->make(true);
        }
        return view('anggotas.index');
    }

    public function index2(string $id)
    {
        $kelompok = DB::table(Kelompok::$view)->where('id', $id)->first();
        $data = [
            'id_provinsi' => $kelompok->id_provinsi,
            'id_kota' => $kelompok->id_kota,
            'id_kecamatan' => $kelompok->id_kecamatan,
            'id_kelurahan' => $kelompok->id_kelurahan,
            'id_kelompok' => $kelompok->id
        ];
        return view('anggotas.index', $data);
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
            $data = Anggota::find($id);
            $save = $data->update([
                'id_kelompok' => $request->id_kelompok,
                'nik' => $request->nik,
                'nama_anggota' => $request->nama_lengkap,
                'id_jabatan' => $request->id_jabatan,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'id_kelurahan' => $request->id_kelurahan,
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
        } else {
            $save = Anggota::create([
                'id_kelompok' => $request->id_kelompok,
                'nik' => $request->nik,
                'nama_anggota' => $request->nama_lengkap,
                'id_jabatan' => $request->id_jabatan,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'id_kelurahan' => $request->id_kelurahan,
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
        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = DB::table(Anggota::$view)->where('id', $id)->first();
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
        $data = Anggota::find($id);
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

    public function list(string $idKelompok)
    {
        $result = DB::table(Anggota::$view)->where(['id_kelompok' => $idKelompok])->get();
        return $result;
    }

    function previewDataExcel(Request $request)
    {
        $file = $request->file('file');
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        $filePath = $file->getPathname();
        try {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $sheetData = $worksheet->toArray(null, true, true, true);
            ob_start();
            $data['sheetData'] = $sheetData;
            echo view('anggotas.preview', $data);
            $content = ob_get_clean();
            return ['status' => true, 'html' => response($content)];
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            return ['status' => false, 'message' => 'Error reading spreadsheet file' . $e->getMessage()];
        }
    }

    function uploadDataExcel(Request $request)
    {
        $idUser = Auth::id();
        $file = $request->file('file');
        $id_kelompok = $request->id_kelompok;
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
        $filePath = $file->getPathname();
        try {
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $sheetData = $worksheet->toArray(null, true, true, true);
            $kelompok = DB::table(Kelompok::$view)->where('id', $id_kelompok)->first();
            $data_save = [];
            foreach (array_slice($sheetData, 1) as $sd) {
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
                $row_data = [
                    'nik' => $sd['C'],
                    'nama_anggota' => $sd['B'],
                    'id_jabatan' => $id_jabatan,
                    'no_hp' => $sd['E'],
                    'alamat' => $sd['F'],
                    'id_kelompok' => $id_kelompok,
                    'id_kelurahan' => $kelompok->id_kelurahan,
                    'crt_id_user' => $idUser,
                    'created_at' => Carbon::now()
                ];
                $data_save[] = $row_data;
            }
            $saveAll = Anggota::insert($data_save);
            if ($saveAll) {
                return ['status' => true];
            } else {
                return ['status' => false];
            }
            // return ['status' => true, 'html' => response($content)];
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            return ['status' => false, 'message' => 'Error reading spreadsheet file' . $e->getMessage()];
        }
    }
}
