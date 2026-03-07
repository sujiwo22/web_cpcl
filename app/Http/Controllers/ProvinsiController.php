<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProvinsiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('provinsi_view')->select('*');

            // $query = Provinsi::query()->select('*');
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action_button', function ($row) {
                    return '<div class="btn-group">
                        <div class="btn btn-sm btn-success" id="btnEdit" onclick="editData(' . $row->id_provinsi . ')"><i class="fa fa-edit"></i></div>
                        <div class="btn btn-sm btn-danger" id="btnDelete" onclick="deleteData(' . $row->id_provinsi . ')"><i class="fa fa-times-circle"></i></div>
                    </div>';
                })
                ->rawColumns(['action_button'])
                ->make(true);
        }

        return view('provinsis.index');
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
        $id = $request->id_provinsi;
        $act = $request->act;
        if ($act == 'edit') {
            // $data = Provinsi::where('id_provinsi', $id)->first();
            $save = Provinsi::where('id_provinsi', $id)->update([
                'nama_provinsi' => $request->nama_provinsi,
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
            $validasi = $this->validasiID($request->id_provinsi);
            if (! $validasi['status']) {
                $response = [
                    'status' => false,
                    'message' => $validasi['message'],
                ];
            } else {
                $save = Provinsi::create([
                    'id_provinsi' => $request->id_provinsi,
                    'nama_provinsi' => $request->nama_provinsi,
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
                'message' => 'ID Provinsi wajib diisi.',
            ];
        } else {
            $data = Provinsi::where('id_provinsi', $id)->get();

            if (count($data) > 0) {
                $response = [
                    'status' => false,
                    'message' => 'ID Provinsi sudah digunakan. Silahkan gunakan ID yang lain.',
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
        $result = Provinsi::where('id_provinsi', $id)->first();
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
        $save = Provinsi::where(['id_provinsi'=>$id])->update([
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

    public function list()
    {
        $result = Provinsi::withoutTrashed()->get();

        return $result;
    }
}
