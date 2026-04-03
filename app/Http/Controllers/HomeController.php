<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Proposal;
use App\Models\Kementrian;
use App\Models\Tps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['tahun'] = date('Y');
        return view('home', $data);
    }

    function totalCPCL()
    {
        $total = Anggota::all()->count();
        return $total;
    }

    function totalProposal($status)
    {
        $total = Proposal::where('status_proposal', $status)->count();
        return $total;
    }

    function dataProposal()
    {
        $data = DB::table('proposals')
            ->selectRaw("
                COUNT(*) as total,
                CASE 
                    WHEN status_proposal = 'Y' THEN 'Proposal'
                    ELSE 'Non Proposal'
                END as status_proposal,
                CASE 
                    WHEN status_proposal = 'Y' THEN '#00a65a'
                    ELSE '#f39c12'
                END as bg_chart
            ")
            ->whereNull('deleted_at')
            ->groupBy('status_proposal')
            ->get();
        // $result = Proposal::select("count(*) total,case when status_proposal='Y' then 'Proposal' else 'Non Proposal' end status_proposal")->groupBy('status_proposal')->get();
        return $data;
    }

    function dataKementrian()
    {
        $status = DB::raw("(SELECT 'Y' as status_proposal UNION ALL SELECT 'N') as s");

        // Subquery hitung total
        $sub = DB::table('proposal_view')
            ->selectRaw('COUNT(*) as total, nama_kementrian, status_proposal')
            ->groupBy('nama_kementrian', 'status_proposal');

        $data = DB::table('kementrians as a')
            ->crossJoin($status)
            ->leftJoinSub($sub, 'b', function ($join) {
                $join->on('a.nama_kementrian', '=', 'b.nama_kementrian')
                    ->on('s.status_proposal', '=', 'b.status_proposal');
            })
            ->where('a.deleted_at', null)
            ->selectRaw('a.singkatan, s.status_proposal, COALESCE(b.total, 0) as total')
            ->get();

        $data_result = [];
        foreach ($data as $dt) {
            $row = [];
            $row = [
                'singkatan' => $dt->singkatan,
                'status_proposal' => $dt->status_proposal,
                'total' => $dt->total
            ];
            $data_result[] = $row;
        }
        $data_new = collect($data_result);
        $grouped = $data_new->groupBy('singkatan');

        $labels = $grouped->keys();

        $dataY = [];
        $dataN = [];

        foreach ($grouped as $items) {
            $dataY[] = $items->firstWhere('status_proposal', 'Y')['total'] ?? 0;
            $dataN[] = $items->firstWhere('status_proposal', 'N')['total'] ?? 0;
        }

        $result_final = [
            'label' => $labels,
            'dataY' => $dataY,
            'dataN' => $dataN
        ];
        return $result_final;
    }

    function dataProposalKabKota()
    {
        $status = DB::raw("(SELECT 'Y' as status_proposal UNION ALL SELECT 'N') as s");

        // Subquery hitung total
        $sub = DB::table('proposal_view')
            ->selectRaw('COUNT(*) as total, nama_kota, status_proposal')
            ->groupBy('nama_kota', 'status_proposal');

        $data = DB::table('kotas as a')
            ->crossJoin($status)
            ->leftJoinSub($sub, 'b', function ($join) {
                $join->on('a.nama_kota', '=', 'b.nama_kota')
                    ->on('s.status_proposal', '=', 'b.status_proposal');
            })
            ->where('a.deleted_at', null)
            ->selectRaw('a.nama_kota, s.status_proposal, COALESCE(b.total, 0) as total')
            ->get();

        $data_result = [];
        foreach ($data as $dt) {
            $row = [];
            $row = [
                'nama_kota' => str_replace('KABUPATEN ','KAB. ',$dt->nama_kota),
                'status_proposal' => $dt->status_proposal,
                'total' => $dt->total
            ];
            $data_result[] = $row;
        }
        $data_new = collect($data_result);
        $grouped = $data_new->groupBy('nama_kota');

        $labels = $grouped->keys();

        $dataY = [];
        $dataN = [];

        foreach ($grouped as $items) {
            $dataY[] = $items->firstWhere('status_proposal', 'Y')['total'] ?? 0;
            $dataN[] = $items->firstWhere('status_proposal', 'N')['total'] ?? 0;
        }

        $result_final = [
            'label' => $labels,
            'dataY' => $dataY,
            'dataN' => $dataN
        ];
        return $result_final;
    }

    function totalTPS()
    {
        $total = Tps::all()->count();
        return $total;
    }
}
