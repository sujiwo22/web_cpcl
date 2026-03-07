<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KotaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('kota_view')->select('*');
            return DataTables::of($query)
                ->filter(function ($query) use ($request) {
                    if ($request->filled('id_provinsi')) {
                        $query->where('id_provinsi', $request->id_provinsi);
                    }
                }, true)
                ->addIndexColumn()
                ->addColumn('action_button', function ($row) {
                    return '<div class="btn-group center">
                        <div class="btn btn-sm btn-success" id="btnEdit" onclick="editData(' . $row->id_kota . ')"><i class="fa fa-edit"></i></div>
                        <div class="btn btn-sm btn-danger" id="btnDelete" onclick="deleteData(' . $row->id_kota . ')"><i class="fa fa-times-circle"></i></div>
                    </div>';
                })
                ->rawColumns(['action_button'])
                ->make(true);
        }

        return view('kotas.index');
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
        $id = $request->id_kota;
        $act = $request->act;
        if ($act == 'edit') {
            $save = Kota::where('id_kota', $id)->update([
                'id_provinsi' => $request->id_provinsi,
                'nama_kota' => $request->nama_kota,
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
            $validasi = $this->validasiID($request->id_kota);
            if (! $validasi['status']) {
                $response = [
                    'status' => false,
                    'message' => $validasi['message'],
                ];
            } else {
                $save = Kota::create([
                    'id_provinsi' => $request->id_provinsi,
                    'id_kota' => $request->id_kota,
                    'nama_kota' => $request->nama_kota,
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
                'message' => 'ID Kota wajib diisi.',
            ];
        } else {
            $data = Kota::where('id_kota', $id)->get();

            if (count($data) > 0) {
                $response = [
                    'status' => false,
                    'message' => 'ID Kota sudah digunakan. Silahkan gunakan ID yang lain.',
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
        $result = Kota::where('id_kota', $id)->first();
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
        $save = Kota::where(['id_kota'=>$id])->update([
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

    public function list(string $id_provinsi)
    {
        $result = Kota::where(['id_provinsi'=>$id_provinsi])->get();
        return $result;
    }
}
