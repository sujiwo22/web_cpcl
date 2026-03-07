<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KecamatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table(Kecamatan::$view)->select('*');
            return DataTables::of($query)
                ->filter(function ($query) use ($request) {
                    if ($request->filled('id_provinsi')) {
                        $query->where('id_provinsi', $request->id_provinsi);
                    }
                    if ($request->filled('id_kota')) {
                        $query->where('id_kota', $request->id_kota);
                    }
                }, true)
                ->addIndexColumn()
                ->addColumn('action_button', function ($row) {
                    return '<div class="btn-group center">
                        <div class="btn btn-sm btn-success" id="btnEdit" onclick="editData(' . $row->id_kecamatan . ')"><i class="fa fa-edit"></i></div>
                        <div class="btn btn-sm btn-danger" id="btnDelete" onclick="deleteData(' . $row->id_kecamatan . ')"><i class="fa fa-times-circle"></i></div>
                    </div>';
                })
                ->rawColumns(['action_button'])
                ->make(true);
        }

        return view('kecamatans.index');
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
        $id = $request->id_kecamatan;
        $act = $request->act;
        if ($act == 'edit') {
            $save = Kecamatan::where('id_kecamatan', $id)->update([
                'id_kota' => $request->id_kota,
                'nama_kecamatan' => $request->nama_kecamatan,
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
            $validasi = $this->validasiID($request->id_kecamatan);
            if (! $validasi['status']) {
                $response = [
                    'status' => false,
                    'message' => $validasi['message'],
                ];
            } else {
                $save = Kecamatan::create([
                    'id_kota' => $request->id_kota,
                    'id_kecamatan' => $request->id_kecamatan,
                    'nama_kecamatan' => $request->nama_kecamatan,
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
                'message' => 'ID Kecamatan wajib diisi.',
            ];
        } else {
            $data = Kecamatan::where('id_kecamatan', $id)->get();

            if (count($data) > 0) {
                $response = [
                    'status' => false,
                    'message' => 'ID Kecamatan sudah digunakan. Silahkan gunakan ID yang lain.',
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
        $result = DB::table(Kecamatan::$view)->where(['id_kecamatan'=>$id])->first();
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
        $save = Kecamatan::where(['id_kecamatan'=>$id])->update([
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

    public function list(string $id_kota)
    {
        $result = Kecamatan::where(['id_kota'=>$id_kota])->get();
        return $result;
    }
}
