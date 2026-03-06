<?php

namespace App\Http\Controllers;

use App\Models\UserLevel;
// use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserLevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $query = UserLevel::query()->join('users','user_levels.crt_id_user','=','users.id')
                ->select('user_levels.id', 'user_levels.level_name', 'users.name AS crt_user_name', 'user_levels.created_at');
            
            return DataTables::of($query)
                ->filter(function ($query) use ($request) {

                    // Filter Nama
                    if ($request->filled('level_name')) {
                        $query->where('level_name', 'like', "%{$request->name}%");
                    }

                    // Filter Status
                    if ($request->filled('status')) {
                        $query->where('status', $request->status);
                    }

                    // Filter Date Range
                    if ($request->filled('start_date') && $request->filled('end_date')) {
                        $query->whereBetween('created_at', [
                            $request->start_date,
                            $request->end_date,
                        ]);
                    }
                }, true)
                ->addIndexColumn()
                ->addColumn('status_label', function ($row) {
                    return '<div class="btn-group">
                        <div class="btn btn-sm btn-success" id="btnEdit" onclick="editData('.$row->id.')"><i class="fa fa-edit"></i></div>
                        <div class="btn btn-sm btn-danger" id="btnDelete" onclick="deleteData('.$row->id.')"><i class="fa fa-times-circle"></i></div>
                    </div>';
                })
                ->rawColumns(['status_label'])
                ->make(true);
        }

        return view('user_levels.index');
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
            $userlevels = UserLevel::findOrFail($id);
            $save = $userlevels->update([
                'level_name' => $request->level_name,
                'upd_id_user' => (int) $idUser,
            ]);
        } else {
            $save = UserLevel::create([
                'level_name' => $request->level_name,
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
        $userlevels = UserLevel::findOrFail($id);

        return $userlevels;
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
        // $idUser = Auth::id();
        // $userlevels = UserLevel::findOrFail($id);
        // $save = $userlevels->update([
        //     'level_name' => $request->level_name,
        //     'upd_id_user' => (int) $idUser,
        //     // 'updated_at' => date('Y-m-d H:i:s'),
        // ]);
        // // echo $save;

        // if ($save) {
        //     // return response()->json(['success' => 'User Level created successfully.']);
        //     $response = [
        //         'status' => true,
        //     ];
        // } else {
        //     // return response()->json(['success' => 'Something when error. Please try again.']);
        //     $response = [
        //         'status' => false,
        //         'message' => 'Terjadi kesalahan saat update data. Silahkan anda coba kembali.',
        //     ];
        // }

        // return $response;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user_level = UserLevel::find($id);
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

    public function ajax_list() {}
}
