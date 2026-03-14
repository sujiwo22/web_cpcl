<?php

namespace App\Http\Controllers;

use App\Models\ProgramAlokasi;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProgramAlokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table(ProgramAlokasi::$view)->select('*');
            return DataTables::of($query)
                ->filter(function ($query) use ($request) {
                    if ($request->filled('tahun')) {
                        $query->where('tahun', $request->tahun);
                    }
                    if ($request->filled('program_kementrian')) {
                        $query->where('program_kementrian', $request->program_kementrian);
                    }
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
        $data['tahun_mulai'] = date('Y') - 2;
        $data['tahun_selesai'] = date('Y') + 5;
        return view('program_alokasis.index', $data);
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
            'tahun' => $request->tahun,
            'program_kementrian' => $request->program_kementrian,
            'id_kementrian' => $request->id_kementrian,
            'id_dirjen' => $request->id_dirjen,
            'id_program' => $request->id_program,
            'id_pic' => $request->id_pic,
            'pic' => $request->pic,
            'contact_person' => $request->contact_person,
            'kuota' => $request->kuota,
            'satuan' => $request->satuan
        ];
        if ($act == 'edit') {
            $data_processed['upd_id_user'] = $idUser;
            $save = ProgramAlokasi::where('id', $id)->update($data_processed);
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
            $save = ProgramAlokasi::create($data_processed);
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
        $result = DB::table(ProgramAlokasi::$view)->where(['id' => $id])->first();
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
        $data = ProgramAlokasi::find($id);
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
