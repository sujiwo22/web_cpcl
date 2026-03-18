<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('user_views')->where(['deleted_at' => null])->select('*');

            return DataTables::of($query)
                ->filter(function ($query) use ($request) {
                    // Filter Level
                    if ($request->filled('id_user_level')) {
                        $query->where('id_user_level', $request->id_user_level);
                    }
                }, true)
                ->addIndexColumn()
                ->addColumn('status_user', function ($row) {
                    return $row->lock_status == 'N' ? '<span class="float-center badge bg-primary">Active</span>' : '<span class="float-center badge bg-warning">Locked</span>';
                })
                ->addColumn('action_button', function ($row) {
                    $btnLock = '';
                    if ($row->lock_status == 'N') {
                        $btnLock = '<div class="btn btn-sm btn-warning" id="btnDelete" onclick="lockAccount('.$row->id.')"><i class="fa fa-lock"></i></div>';
                    } else {
                        $btnLock = '<div class="btn btn-sm btn-default" id="btnDelete" onclick="unlockAccount('.$row->id.')"><i class="fa fa-unlock"></i></div>';
                    }

                    return '<div class="btn-group">
                        <div class="btn btn-sm btn-success" id="btnEdit" onclick="editData('.$row->id.')"><i class="fa fa-edit"></i></div>
                        <div class="btn btn-sm btn-danger" id="btnDelete" onclick="deleteData('.$row->id.')"><i class="fa fa-times-circle"></i></div>'.$btnLock.'</div>';
                })
                ->rawColumns(['status_user', 'action_button'])
                ->make(true);
        }

        return view('users.index');
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
        $password = $request->password;
        $password2 = $request->password2;
        $save = false;
        $email_val = $this->validasiEmail($request->email, $id);
        if (! $email_val['status']) {
            $response = [
                'status' => false,
                'message' => $email_val['message'],
            ];
        } else {
            if ($act == 'edit') {
                $users = User::findOrFail($id);
                if ($password == '') {
                    $save = $users->update([
                        'id_user_level' => $request->id_user_level,
                        'name' => $request->name,
                        'email' => $request->email,
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
                    $validasi = $this->validasiPassword($password, $password2);
                    if (! $validasi['status']) {
                        $response = [
                            'status' => false,
                            'message' => $validasi['message'],
                        ];
                    } else {
                        $save = $users->update([
                            'id_user_level' => $request->id_user_level,
                            'name' => $request->name,
                            'email' => $request->email,
                            'password' => bcrypt($password),
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
                    }
                }
                // }
            } else {
                $validasi = $this->validasiPassword($password, $password2);
                if (! $validasi['status']) {
                    $response = [
                        'status' => false,
                        'message' => $validasi['message'],
                    ];
                } else {
                    $save = User::create([
                        'id_user_level' => $request->id_user_level,
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => bcrypt($password),
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
        }

        return $response;
    }

    public function validasiPassword($password, $password2)
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        if (! $uppercase || ! $lowercase || ! $number || ! $specialChars || strlen($password) < 8) {
            $response = [
                'status' => false,
                'message' => 'Pasword setidaknya harus 8 karakter dan harus memiliki huruf besar, huruf kecil, angka, dan spesial karakter.',
            ];
        } else {
            if ($password != $password2) {
                $response = [
                    'status' => false,
                    'message' => 'Ulangi Password harus sesuai dengan Password',
                ];
            } else {
                $response = ['status' => true];
            }
        }

        return $response;
    }

    public function validasiEmail($email, $id = null)
    {
        if ($id == null || $id == '') {
            $data = User::where('email', $email)->get();
        } else {
            $data = User::where('email', $email)->where('id', '<>', $id)->get();
        }
        if (count($data) > 0) {
            $response = [
                'status' => false,
                'message' => 'Email ini sudah digunakan oleh user lain. Silahkan gunakan alamat email yang lain.',
            ];
        } else {
            $response = ['status' => true];
        }
        return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $users = User::findOrFail($id);

        return $users;
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
        $users = User::find($id);
        $save = $users->delete();
        if ($save) {
            $idUser = Auth::id();
            $users->update([
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

    public function lock_account(string $id)
    {
        $idUser = Auth::id();
        $users = User::findOrFail($id);
        // if ($password == '') {
        $save = $users->update([
            'lock_status' => 'Y',
            'upd_id_user' => (int) $idUser,
        ]);
        if ($save) {
            $response = [
                'status' => true,
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Terjadi kesalahan saat lock akun. Silahkan anda coba kembali.',
            ];
        }

        return $response;
    }

    public function unlock_account(string $id)
    {
        $idUser = Auth::id();
        $users = User::findOrFail($id);
        // if ($password == '') {
        $save = $users->update([
            'lock_status' => 'N',
            'upd_id_user' => (int) $idUser,
        ]);
        if ($save) {
            $response = [
                'status' => true,
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Terjadi kesalahan saat unlock akun. Silahkan anda coba kembali.',
            ];
        }

        return $response;
    }
}
