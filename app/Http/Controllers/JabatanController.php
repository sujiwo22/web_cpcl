<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use LDAP\Result;
use Yajra\DataTables\Facades\DataTables;

class JabatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $query = DB::table('provinsi_view')->select('*');

            $query = Jabatan::query()->select('*');
            return DataTables::of($query)
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
            $save = Jabatan::where('id', $id)->update([
                'nama_jabatan' => $request->nama_jabatan,
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
            $validasi = $this->validasiNamaJabatan($request->nama_jabatan);
            if (! $validasi['status']) {
                $response = [
                    'status' => false,
                    'message' => $validasi['message'],
                ];
            } else {
                $save = Jabatan::create([
                    'nama_jabatan' => $request->nama_jabatan,
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

    public function validasiNamaJabatan($nama_jabatan)
    {
        if ($nama_jabatan == null || $nama_jabatan == '') {
            $response = [
                'status' => false,
                'message' => 'Nama Jabatan wajib diisi.',
            ];
        } else {
            $data = Jabatan::where('nama_jabatan', $nama_jabatan)->get();

            if (count($data) > 0) {
                $response = [
                    'status' => false,
                    'message' => 'Nama Jabatan sudah disimpan. Silahkan gunakan ID yang lain.',
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
        $result = Jabatan::find($id);
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
        $user_level = Jabatan::find($id);
        $save = $user_level->delete();
        if ($save) {
            $idUser = Auth::id();
            $user_level->update([
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

    public function list()
    {
        $result = Jabatan::withoutTrashed()->get();
        return $result;
    }
}
