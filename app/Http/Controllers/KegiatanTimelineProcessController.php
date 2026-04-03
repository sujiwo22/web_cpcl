<?php

namespace App\Http\Controllers;

use App\Models\KegiatanTimelineProcess;
use App\Models\KegiatanTimeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class KegiatanTimelineProcessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // if ($request->ajax()) {            
        //     $query = DB::table('user_level_views')->select('id','level_name','crt_user_name','created_at');
        //     return DataTables::of($query)
        //         ->filter(function ($query) use ($request) {

        //             // Filter Nama
        //             if ($request->filled('level_name')) {
        //                 $query->where('level_name', 'like', "%{$request->name}%");
        //             }

        //             // Filter Status
        //             if ($request->filled('status')) {
        //                 $query->where('status', $request->status);
        //             }

        //             // Filter Date Range
        //             if ($request->filled('start_date') && $request->filled('end_date')) {
        //                 $query->whereBetween('created_at', [
        //                     $request->start_date,
        //                     $request->end_date,
        //                 ]);
        //             }
        //         }, true)
        //         ->addIndexColumn()
        //         ->addColumn('status_label', function ($row) {
        //             return '<div class="btn-group">
        //                 <div class="btn btn-sm btn-success" id="btnEdit" onclick="editData('.$row->id.')"><i class="fa fa-edit"></i></div>
        //                 <div class="btn btn-sm btn-danger" id="btnDelete" onclick="deleteData('.$row->id.')"><i class="fa fa-times-circle"></i></div>
        //             </div>';
        //         })
        //         ->rawColumns(['status_label'])
        //         ->make(true);
        // }
        $data['tahun_mulai'] = date('Y') - 2;
        $data['tahun_selesai'] = date('Y') + 5;
        $data['bulan_skrg'] = date('m');
        return view('kegiatan_timeline_processes.index', $data);
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
        $kegiatan = KegiatanTimeline::find($request->id_kegiatan);
        $data_save = [
            'id_kegiatan' => $request->id_kegiatan,
            'nama_kegiatan' => $kegiatan->nama_kegiatan,
            'tahun' => $request->tahun_start,
            'tahun_start' => $request->tahun_start,
            'bulan_start' => $request->bulan_start,
            'tahun_end' => $request->tahun_end,
            'bulan_end' => $request->bulan_end
        ];
        if ($act == 'edit') {
            $data = KegiatanTimelineProcess::findOrFail($id);
            $data_save['upd_id_user'] = (int) $idUser;
            $save = $data->update($data_save);
        } else {
            $data_save['crt_id_user'] = (int) $idUser;
            $save = KegiatanTimelineProcess::create($data_save);
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
        $data = KegiatanTimelineProcess::findOrFail($id);
        return $data;
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
        // echo json_encode($request);
        $data = KegiatanTimelineProcess::find($id);
        $tambahan_bulan = $request->bulan_end_new - $data->bulan_end;
        $idUser = Auth::id();
        $data_save = ['tambahan_bulan' => $tambahan_bulan, 'upd_id_user' => $idUser];
        $save = $data->update($data_save);
        if ($save) {
            $response = [
                'status' => true,
            ];
        } else {
            $response = [
                'status' => false,
            ];
        }
        return $response;
    }

    public function update_urutan(Request $request, string $id)
    {
        // echo json_encode($request);
        $posisi = $request->posisi;
        $data = KegiatanTimelineProcess::find($id);
        $order_baru = $posisi == 'up' ? $data->order_data - 1 : $data->order_data + 1;
        if ($posisi == 'down') {
            $data_kecil = KegiatanTimelineProcess::where('order_data', '>', $data->order_data)->where('tahun', $data->tahun)->orderBy('order_data', 'asc')->first();
            $data_kecil_update = KegiatanTimelineProcess::find($data_kecil->id);
            $order_baru_kecil = $data_kecil_update->order_data - 1;
            $data_kecil_update->update(['order_data' => $order_baru_kecil]);
        }

        if ($posisi == 'up') {
            $data_besar = KegiatanTimelineProcess::where('order_data', '<', $data->order_data)->where('tahun', $data->tahun)->orderBy('order_data', 'desc')->first();
            $data_besar_update = KegiatanTimelineProcess::find($data_besar->id);
            $order_baru_besar = $data_besar_update->order_data + 1;
            $data_besar_update->update(['order_data' => $order_baru_besar]);
        }
        $save = $data->update(['order_data' => $order_baru]);

        if ($save) {
            $response = [
                'status' => true,
            ];
        } else {
            $response = [
                'status' => false,
            ];
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = KegiatanTimelineProcess::find($id);
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

    function viewData(Request $request)
    {
        $result = KegiatanTimelineProcess::where('tahun', $request->tahun)->orderBy('order_data', 'asc')->get();
        ob_start();
        $data_result = [];
        foreach ($result as $rs) {
            $row = [];
            $row['id'] = $rs->id;
            $row['tahun'] = $rs->tahun;
            $row['order_data'] = $rs->order_data;
            $row['id_kegiatan'] = $rs->id_kegiatan;
            $row['nama_kegiatan'] = $rs->nama_kegiatan;
            $row['tahun_start'] = $rs->tahun_start;
            $row['bulan_start'] = $rs->bulan_start;
            $row['tahun_end'] = $rs->tahun_end;
            $row['bulan_end'] = $rs->bulan_end;
            $row['tambahan_bulan'] = $rs->tambahan_bulan;
            $bulan_new = $rs->bulan_end + $rs->tambahan_bulan;
            $bulan_add = [];
            for ($i = $rs->bulan_end + 1; $i <= $bulan_new; $i++) {
                $bulan_add[] = $i;
            }
            $row['bulan_new'] = $bulan_new;
            $row['bulan_add'] = $bulan_add;
            $row['crt_id_user'] = $rs->crt_id_user;
            $row['upd_id_user'] = $rs->upd_id_user;
            $row['del_id_user'] = $rs->del_id_user;
            $row['created_at'] = $rs->created_at;
            $row['updated_at'] = $rs->updated_at;
            $row['deleted_at'] = $rs->deleted_at;
            $data_result[] = $row;
        }
        $data['result'] = $data_result;
        $data['type'] = $request->type;
        // return $data_result;
        echo view('kegiatan_timeline_processes.table_timeline', $data);
        $content = ob_get_clean();
        return ['html' => response($content)];
    }
}
