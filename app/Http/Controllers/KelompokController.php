<?php

namespace App\Http\Controllers;

use App\Models\Kelompok;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KelompokController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table(Kelompok::$view)->select('*');
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
                        <a class="btn btn-sm btn-warning" id="btnAnggota" href="' . route('kelompok_anggota', $row->id) . '"><i class="fa fa-users"></i></a>
                        <div class="btn btn-sm btn-success" id="btnEdit" onclick="editData(' . $row->id . ')"><i class="fa fa-edit"></i></div>
                        <div class="btn btn-sm btn-danger" id="btnDelete" onclick="deleteData(' . $row->id . ')"><i class="fa fa-times-circle"></i></div>
                    </div>';
                })
                ->rawColumns(['action_button'])
                ->make(true);
        }

        return view('kelompoks.index');
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
            $data = Kelompok::find($id);
            $save = $data->update([
                'id_kelurahan' => $request->id_kelurahan,
                'nama_kelompok' => $request->nama_kelompok,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'penanggung_jawab' => $request->penanggung_jawab,
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
            $save = Kelompok::create([
                'id_kelurahan' => $request->id_kelurahan,
                'nama_kelompok' => $request->nama_kelompok,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'penanggung_jawab' => $request->penanggung_jawab,
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
        if ($id_kelurahan != null) {
            $result = Kelompok::where(['id_kelurahan' => $id_kelurahan])->get();
        } else {
            $result = Kelompok::withoutTrashed()->get();
        }
        return $result;
    }
}
