<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class MenuItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table(MenuItem::$view)->select('*');
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('url_show', function ($row) {
                    return url($row->url);
                })
                ->addColumn('parent_menu', function ($row) {
                    $parent_id = $row->parent_id;
                    if (empty($parent_id)) {
                        $url = $row->name;
                    } else {
                        $x = 0;
                        $url = $row->name;
                        while ($x == 0) {
                            $resData = MenuItem::find($parent_id);
                            if ($resData != null) {
                                $url = $resData->name . ' <i class="fa fa-chevron-circle-right"></i> ' . $url;
                            }
                            $x = $resData->parent_id == 0 || $resData->parent_id == null ? 1 : 0;
                            $parent_id = $resData->parent_id == 0 || $resData->parent_id == null ? '' : $resData->parent_id;
                        }
                    }
                    return $url;
                })
                ->addColumn('action_button', function ($row) {
                    return '<div class="btn-group">
                        <div class="btn btn-xs btn-success" id="btnEdit" onclick="editData(' . $row->id . ')"><i class="fa fa-edit"></i></div>
                        <div class="btn btn-xs btn-danger" id="btnDelete" onclick="deleteData(' . $row->id . ')"><i class="fa fa-times-circle"></i></div>
                    </div>';
                })
                ->rawColumns(['action_button', 'parent_menu', 'url_show'])
                ->make(true);
        }

        $cur_url = current_url();
        $detail = MenuItem::where('url', $cur_url)->first();
        $data['title'] = $detail->name;
        return view('menu_items.index', $data);
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
            $data = MenuItem::findOrFail($id);
            $save = $data->update([
                'name' => $request->name,
                'url' => $request->url,
                'parent_id' => $request->parent_id,
                'upd_id_user' => (int) $idUser,
            ]);
        } else {
            $save = MenuItem::create([
                'name' => $request->name,
                'url' => $request->url,
                'parent_id' => $request->parent_id,
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
        $result = MenuItem::findOrFail($id);
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
        $data = MenuItem::find($id);
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

    function list()
    {
        $result = MenuItem::get();
        $final = [];
        foreach ($result as $rs) {
            $parent_id = $rs->parent_id;
            if (empty($parent_id)) {
                $url = $rs->name;
            } else {
                $x = 0;
                $url = $rs->name;
                while ($x == 0) {
                    $resData = MenuItem::find($parent_id);
                    if ($resData != null) {
                        $url = $resData->name . " => " . $url;
                    }
                    $x = $resData!=null && ($resData->parent_id != null || $resData->parent_id!=0) ? 0 : 1;
                    $parent_id = $resData!=null && ($resData->parent_id != null || $resData->parent_id!=0) ? $resData->parent_id:'';
                }
            }
            $row = [];
            $row = [
                'id' => $rs->id,
                'name' => $rs->name,
                'posisi' => $url
            ];
            $final[] = $row;
        }
        return $final;
    }
}
