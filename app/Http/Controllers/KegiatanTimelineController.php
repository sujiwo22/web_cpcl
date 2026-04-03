<?php

namespace App\Http\Controllers;

use App\Models\KegiatanTimeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KegiatanTimelineController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {            
            $query = KegiatanTimeline::select('*');
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('action_button', function ($row) {
                    return '<div class="btn-group">
                        <div class="btn btn-sm btn-success" id="btnEdit" onclick="editData('.$row->id.')"><i class="fa fa-edit"></i></div>
                        <div class="btn btn-sm btn-danger" id="btnDelete" onclick="deleteData('.$row->id.')"><i class="fa fa-times-circle"></i></div>
                    </div>';
                })
                ->rawColumns(['action_button'])
                ->make(true);
        }

        return view('kegiatan_timelines.index');
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
            $data = KegiatanTimeline::findOrFail($id);
            $save = $data->update([
                'nama_kegiatan' => $request->nama_kegiatan,
                'upd_id_user' => (int) $idUser,
            ]);
        } else {
            $save = KegiatanTimeline::create([
                'nama_kegiatan' => $request->nama_kegiatan,
                'crt_id_user' => (int) $idUser,
            ]);
        }

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

        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = KegiatanTimeline::findOrFail($id);
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
        $data = KegiatanTimeline::find($id);
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

    public function list() {
        $data = KegiatanTimeline::withoutTrashed()->get();
        return $data;
    }
}
