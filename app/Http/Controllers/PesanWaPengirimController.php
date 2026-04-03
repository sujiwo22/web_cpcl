<?php

namespace App\Http\Controllers;

use App\Models\pesanWaPengirim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PesanWaPengirimController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table(pesanWaPengirim::$view)->select('*');
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action_button', function ($row) {
                    return '<div class="btn-group center">
                        <div class="btn btn-sm btn-success" id="btnEdit" onclick="editData(' . $row->id . ')"><i class="fa fa-edit"></i></div>
                        <div class="btn btn-sm btn-danger" id="btnDelete" onclick="deleteData(' . $row->id . ')"><i class="fa fa-times-circle"></i></div>
                    </div>';
                })
                ->addColumn('status_section',function($row){
                    $statusShow = $row->status=='A'?'<span class="badge badge-success">Aktif</span>':'<span class="badge badge-danger">Tidak Aktif</span>';
                    return $statusShow;
                })
                ->rawColumns(['action_button','status_section'])
                ->make(true);
        }

        return view('pesan_wa_pengirims.index');
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
            'no_pengirim' => $request->no_pengirim,
            'token' => $request->token,
            'status' => $request->status
        ];

        if ($act == 'edit') {
            $validasi = $this->validasiNoPengirim($request->no_pengirim, $id);
            if (! $validasi['status']) {
                $response = [
                    'status' => false,
                    'message' => $validasi['message'],
                ];
            } else {
                $data_save['upd_id_user'] = $idUser;
                $data = pesanWaPengirim::find($id);
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
            }
        } else {
            $validasi = $this->validasiNoPengirim($request->no_pengirim);
            if (! $validasi['status']) {
                $response = [
                    'status' => false,
                    'message' => $validasi['message'],
                ];
            } else {
                $data_save['crt_id_user'] = $idUser;
                $save = pesanWaPengirim::create($data_save);
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

    public function validasiNoPengirim($no_pengirim, $id = null)
    {
        if ($no_pengirim == null || $no_pengirim == '') {
            $response = [
                'status' => false,
                'message' => 'No. WA Pengirim wajib diisi.',
            ];
        } else {
            $data = pesanWaPengirim::where('no_pengirim', $no_pengirim);
            if ($id != null) {
                $data->where('id', '!=', $id);
            }
            $result_data = $data->first();

            if ($result_data!=null) {
                $response = [
                    'status' => false,
                    'message' => 'No. WA Pengirim sudah digunakan. Silahkan gunakan No yang lain.',
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
        $result = pesanWaPengirim::find($id);
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
        $data = pesanWaPengirim::find($id);
        $save = $data->delete();
        if ($save) {
            $idUser = Auth::id();
            $data->update([
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
}
