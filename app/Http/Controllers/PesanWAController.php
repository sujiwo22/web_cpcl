<?php

namespace App\Http\Controllers;

use App\Models\pesanWA;
use App\Models\pesanWaDetail;
use App\Models\pesanWaPengirim;
use App\Models\pesanWaMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PesanWAController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = DB::table('pesan_wa_masuks')->select('*');
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('pengirim_print', function ($row) {
                    return $row->status == 'N' ? '<b>' . $row->pengirim . '</b>' : $row->pengirim;
                })
                ->addColumn('pesan_print', function ($row) {
                    $pesan_prt = strlen($row->pesan) > 50 ? substr($row->pesan, 0, 50) : $row->pesan;
                    return $row->status == 'N' ? '<strong>' . $pesan_prt . '</strong>' : $pesan_prt;
                })
                ->addColumn('tgl_print', function ($row) {
                    $tgl_pr = \Carbon\Carbon::parse($row->created_at)->locale('id')->diffForHumans();
                    // $tgl_pr = printMsgTime($row->created_at);
                    return $row->status == 'N' ? '<strong>' . $tgl_pr . '</strong>' : $tgl_pr;
                })
                ->addColumn('action_button', function ($row) {
                    return '<div class="btn btn-sm btn-danger" onlick="deleteInbox(' . $row->id . ')"><i class="fa fa-trash"></i></i></div>';
                })
                ->rawColumns(['pengirim_print', 'action_button', 'pesan_print', 'tgl_print'])
                ->make(true);
        }
        return view('pesan_wa.index');
    }

    function create()
    {
        $data['list_pengirim'] = pesanWaPengirim::where(['status' => 'A', 'deleted_at' => null])->get();
        return view('pesan_wa.create', $data);
    }

    function store(Request $request)
    {
        $idUser = Auth::id();
        $id_pengirim = $request->id_pengirim;
        $jenis_pesan = $request->jenis_pesan;
        $id_anggota = isset($request->id_anggota) ? $request->id_anggota : null;
        $penerima = isset($request->penerima) ? $request->penerima : null;
        $pesan = $request->pesan;
        $status = $request->status_msg;
        $pengirim = pesanWaPengirim::find($id_pengirim);
        $no_pengirim = $pengirim->no_pengirim;
        $data_save = [
            'id_no_pengirim' => $id_pengirim,
            'no_pengirim' => $no_pengirim,
            'pesan' => $pesan,
            'status' => $status,
            'crt_id_user' => $idUser
        ];
        $save = pesanWA::create($data_save);
        if ($save) {
            if ($status == 'S') {
                // $penerima = substr($penerima, -1) != ';' ? $penerima . ';' : $penerima;
                if ($jenis_pesan == 'tunggal') {
                    $expl_penerima = explode(",", $penerima);
                    $limit = $expl_penerima == null ? 1 : count($expl_penerima);
                    $start_arr = 0;
                    $data_save_detail = [];
                    for ($i = $start_arr; $i < $limit; $i++) {
                        $no_penerima = $expl_penerima[$i];
                        $row = [];
                        $row = [
                            'id_pesan'  => $save->id,
                            'no_hp_penerima' => $no_penerima,
                            'nama_penerima' => isset($nama_penerima) ? $nama_penerima : $no_penerima,
                            'crt_id_user' => $idUser
                        ];
                        $data_save_detail[] = $row;
                    }
                    $save_detail = pesanWaDetail::fillAndInsert($data_save_detail);
                } else {
                    $limit = count($id_anggota);
                    $start_arr = 0;
                    $data_save_detail = [];
                    $penerima = '';
                    for ($i = $start_arr; $i < $limit; $i++) {
                        $no_penerima = $id_anggota[$i];
                        $penerima .= $no_penerima;
                        $penerima .= $i > 0 ? ',' : '';
                        $row = [];
                        $row = [
                            'id_pesan'  => $save->id,
                            'no_hp_penerima' => $no_penerima,
                            'nama_penerima' => isset($nama_penerima) ? $nama_penerima : $no_penerima,
                            'crt_id_user' => $idUser
                        ];
                        $data_save_detail[] = $row;
                    }
                    $save_detail = pesanWaDetail::fillAndInsert($data_save_detail);
                }
                // if ($limit == 1) {
                //     $this->sendWa($penerima, $pesan, $id_pengirim);
                // } else {
                //     $data_send = [
                //         [
                //             "target" => $penerima,
                //             "message" => $pesan,
                //             "delay" => "5"
                //         ]
                //     ];
                //     $this->sendWaBroadcast($id_pengirim, $data_send);
                // }
            }
            $response = ['status' => true];
        } else {
            $response = ['status' => false];
        }
        return $response;
    }

    function sendWa($target, $message, $id_pengirim)
    {
        $pengirim = pesanWaPengirim::find($id_pengirim);
        return Http::withHeaders([
            'Authorization' => $pengirim->token
            // 'Authorization' => 'AGdHF1SRDaVLPBhS4Kj7'
        ])->asForm()->post('https://api.fonnte.com/send', [
            'target' => $target,
            'message' => $message,
        ])->json();
    }

    function sendBulkWa(array $messages)
    {
        return Http::withHeaders([
            'Authorization' => env('FONNTE_TOKEN')
        ])->asForm()->post('https://api.fonnte.com/send', [
            'data' => json_encode($messages)
        ])->json();
    }

    function receiveWA(Request $request)
    {
        $message = new pesanWaMasuk();
        $message->pengirim = $request->input('sender');
        $message->pesan = $request->input('message');
        $message->save();
        return response()->json(['status' => 'success'], 200);
    }

    function sendWaBroadcast($id_pengirim, $data)
    {
        $pengirim = pesanWaPengirim::find($id_pengirim);
        // $data = [
        //     [
        //         "target" => "08123456789",
        //         "message" => "1",
        //         "delay" => "1"
        //     ],
        //     [
        //         "target" => "08123456789,08987654321",
        //         "message" => "2",
        //         "delay" => "5"
        //     ],
        //     [
        //         "target" => "08123456789",
        //         "message" => "3",
        //         "delay" => "0"
        //     ]
        // ];

        $response = Http::withHeaders([
            'Authorization' => $pengirim->token
        ])->asForm()->post('https://api.fonnte.com/send', [
            'data' => json_encode($data) // ini kunci penting
        ]);

        $result = $response->body();

        return $result;
    }

    function kirimWA()
    {
        $target = '085271668215';
        $message = 'Tess';
        $id_pengirim = 1;
        return $this->sendWa($target, $message, $id_pengirim);
    }
}
