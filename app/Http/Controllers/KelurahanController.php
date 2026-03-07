<?php

namespace App\Http\Controllers;

use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KelurahanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table(Kelurahan::$view)->select('*');
            return DataTables::of($query)
                ->filter(function ($query) use ($request) {
                    if ($request->filled('id_kecamatan')) {
                        $query->where('id_kecamatan', $request->id_kecamatan);
                    }
                    if ($request->filled('id_kota')) {
                        $query->where('id_kota', $request->id_kota);
                    }
                    if ($request->filled('id_provinsi')) {
                        $query->where('id_provinsi', $request->id_provinsi);
                    }
                }, true)
                ->addIndexColumn()
                ->addColumn('action_button', function ($row) {
                    return '<div class="btn-group center">
                        <div class="btn btn-sm btn-success" id="btnEdit" onclick="editData(' . $row->id_kelurahan . ')"><i class="fa fa-edit"></i></div>
                        <div class="btn btn-sm btn-danger" id="btnDelete" onclick="deleteData(' . $row->id_kelurahan . ')"><i class="fa fa-times-circle"></i></div>
                    </div>';
                })
                ->rawColumns(['action_button'])
                ->make(true);
        }

        return view('kelurahans.index');
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
        $id = $request->id_kelurahan;
        $act = $request->act;
        if ($act == 'edit') {
            $save = Kelurahan::where('id_kelurahan', $id)->update([
                'id_kecamatan' => $request->id_kecamatan,
                'nama_kelurahan' => $request->nama_kelurahan,
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
            $validasi = $this->validasiID($request->id_kelurahan);
            if (! $validasi['status']) {
                $response = [
                    'status' => false,
                    'message' => $validasi['message'],
                ];
            } else {
                $save = Kelurahan::create([
                    'id_kecamatan' => $request->id_kecamatan,
                    'id_kelurahan' => $request->id_kelurahan,
                    'nama_kelurahan' => $request->nama_kelurahan,
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

    public function validasiID($id)
    {
        if ($id == null || $id == '') {
            $response = [
                'status' => false,
                'message' => 'ID Kelurahan wajib diisi.',
            ];
        } else {
            $data = Kelurahan::where('id_kelurahan', $id)->get();

            if (count($data) > 0) {
                $response = [
                    'status' => false,
                    'message' => 'ID Kelurahan sudah digunakan. Silahkan gunakan ID yang lain.',
                ];
            } else {
                $response = ['status' => true];
            }
        }

        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = DB::table(Kelurahan::$view)->where(['id_kelurahan'=>$id])->first();
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
        $idUser = Auth::id();
        $save = Kelurahan::where(['id_kelurahan'=>$id])->update([
                'del_id_user' => (int) $idUser,
                'deleted_at' => now()
            ]);
        if ($save) {
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

    public function list(string $id_kecamatan)
    {
        $result = Kelurahan::where(['id_kecamatan'=>$id_kecamatan])->get();
        return $result;
    }
}
