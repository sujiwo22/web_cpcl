<?php

namespace App\Http\Controllers;

use App\Models\Penyuluh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use Yajra\DataTables\Facades\DataTables;

class PenyuluhController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table(Penyuluh::$view)->select('*');
            return DataTables::of($query)
                ->filter(function ($query) use ($request) {
                    // Filter Level
                    if ($request->filled('id_kementrian')) {
                        $query->where('id_kementrian', $request->id_kementrian);
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

        $data['title'] = 'Penyuluh';
        return view('penyuluhs.index', $data);
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
        $data_processed = [
            'id_kementrian' => $request->id_kementrian,
            'nama_penyuluh' => $request->nama_penyuluh,
            'contact_person' => $request->contact_person
        ];

        if ($act == 'edit') {
            $data = Penyuluh::find($id);
            $data_processed['upd_id_user'] = $idUser;
            $save = $data->update($data_processed);
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
            $data_processed['crt_id_user'] = $idUser;
            $save = Penyuluh::create($data_processed);
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
        $result = Penyuluh::findOrFail($id);
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
        $data = Penyuluh::find($id);
        $delete = $data->delete();
        if ($delete) {
            $idUser = Auth::id();
            $data->update([
                'del_id_user' => $idUser
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

    public function list(string|null $id_kementrian)
    {
        if ($id_kementrian == null) {
            $result = Penyuluh::withoutTrashed()->get();
        } else {
            $result = Penyuluh::where(['id_kementrian' => $id_kementrian])->get();
        }
        return $result;
    }
}
