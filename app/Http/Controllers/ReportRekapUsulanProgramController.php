<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Kelompok;
use App\Models\Kota;
use App\Http\Controllers\FileController;
use App\Models\Anggota;
use App\Models\Kementrian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;

class ReportRekapUsulanProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $list_kota = Kota::where('id_provinsi', $request->id_provinsi)->orderBy('nama_kota', 'asc')->get();
            $sql_add_1 = '';
            $sql_add_2 = '';
            foreach ($list_kota as $lk) {
                $namaKabTemp = str_replace('KABUPATEN ', '', $lk->nama_kota);
                $namaKab = str_replace(' ', '_', $namaKabTemp);
                $sql_add_1 .= ", SUM(CASE WHEN x.nama_kota='" . $lk->nama_kota . "' THEN x.jumlah_bantuan ELSE 0 END) $namaKab ";
                $sql_add_2 .= ",b2.$namaKab";
            }
            $sql_query = "SELECT b.* $sql_add_2 FROM (
                SELECT a.tahun, a.nama_kementrian,a.nama_dirjen,case when a.program_kementrian='N' then 1000 ELSE a.id_kementrian END urutan, 
                a.id_program, a.nama_program,a.pic,a.contact_person,a.kuota,a.satuan,a.cpcl_status,a.verifikasi_status,a.kontrak_status,a.pengiriman_status,a.distribusi_status
                FROM program_alokasi_view a
                WHERE tahun=$request->tahun) b
                LEFT JOIN (SELECT x.id_program,x.tahun,x.nama_program
                $sql_add_1 
                FROM( 
                SELECT f.id_program,a.tahun, g.nama_program, e.id_kota,e.nama_kota,SUM(a.jumlah_bantuan) jumlah_bantuan 
                FROM proposal_view a
                LEFT JOIN kelompoks b ON a.id_kelompok=b.id
                LEFT JOIN kelurahans c ON b.id_kelurahan=c.id_kelurahan
                LEFT JOIN kecamatans d ON c.id_kecamatan=d.id_kecamatan
                LEFT JOIN kotas e ON d.id_kota=e.id_kota
                LEFT JOIN program_alokasis f ON a.id_program_alokasi=f.id
                LEFT JOIN programs g ON f.id_program=g.id
                GROUP BY f.id_program,a.tahun, g.nama_program,e.id_kota,e.nama_kota) x GROUP BY x.id_program,x.tahun,x.nama_program) b2 ON b.id_program=b2.id_program AND b.tahun=b2.tahun 
                ORDER BY b.urutan,b.nama_dirjen asc";
            return $sql_query;
            $query = DB::select($sql_query);
            return DataTables::of($query)
                // ->filter(function ($query) use ($request) {
                //     if ($request->filled('tahun')) {
                //         $query->where('tahun', $request->tahun);
                //     }
                // }, true)
                ->addIndexColumn()
                // ->addColumn('action_button', function ($row) {
                //     return '<div class="btn-group">
                //         <a class="btn btn-sm btn-success" id="btnExcel" href="' . route('proposal.download_excel', $row->id) . '"><i class="fa fa-file-excel"></i></a>
                //         <div class="btn btn-sm btn-primary" id="btnEdit" onclick="editData(' . $row->id . ')"><i class="fa fa-edit"></i></div>
                //         <div class="btn btn-sm btn-warning" id="btnDelete" onclick="viewData(' . $row->id . ')"><i class="fa fa-bars"></i></div>
                //         <div class="btn btn-sm btn-danger" id="btnDelete" onclick="deleteData(' . $row->id . ')"><i class="fa fa-times-circle"></i></div>
                //     </div>';
                // })
                // ->addColumn('proposal_button', function ($row) {
                //     $file = $row->file;
                //     $exp = explode('/', $file);
                //     $file_name = $exp != null && count($exp) > 1 ? $exp[1] : '';
                //     $url = 'view-file/' . $file_name;
                //     $url2 = 'download-file/' . $file_name;
                //     if ($row->status_proposal == 'N') {
                //         return 'Tanpa Proposal';
                //     } else {

                //         if ($file_name == '') {
                //             return '<span class="text-default">File Not Found!</span>';
                //         } else {
                //             $fileController = new FileController;
                //             $checkFile = $fileController->checkFile($file_name);
                //             if (!$checkFile) {
                //                 return '<span class="text-default">File Not Found!</span>';
                //             } else {
                //                 return '<div class="btn-group">
                //         <a class="btn btn-sm btn-primary" id="btnEdit" href="' . $url2 . '"><i class="fa fa-download"></i></a>
                //         <a class="btn btn-sm btn-info" id="btnDelete" href="' . $url . '" target="_blank"><i class="fa fa-eye"></i></a>
                //     </div>';
                //             }
                //         }
                //     }
                // })
                // ->rawColumns(['action_button', 'proposal_button'])
                ->make(true);
        }
        $id_provinsi = 13;
        $list_kota = Kota::where('id_provinsi', $id_provinsi)->orderBy('nama_kota', 'asc')->get();
        $data['list_kota'] = $list_kota;
        $data['jml_col'] = $list_kota->count();
        $data['title'] = 'REKAPAN ASPIRASI H. ALEX INDRA LUKMAN, S.Sos, M.A.P';
        $data['tahun_mulai'] = date('Y') - 2;
        $data['tahun_selesai'] = date('Y') + 5;
        $data['tahun_now'] = date('Y');
        return view('report_rekap_usulan_program.index', $data);
    }
    
    function viewReport(Request $request)
    {
        $list_kota = Kota::where('id_provinsi', $request->id_provinsi)->orderBy('nama_kota', 'asc')->get();
        $list_kementrian = Kementrian::withoutTrashed()->orderBy('urutan', 'asc')->get();
        $sql_add_1 = '';
        $sql_add_2 = '';
        foreach ($list_kota as $lk) {
            $namaKabTemp = str_replace('KABUPATEN ', '', $lk->nama_kota);
            $namaKab = str_replace(' ', '_', $namaKabTemp);
            $sql_add_1 .= ", SUM(CASE WHEN x.nama_kota='" . $lk->nama_kota . "' THEN x.jumlah_bantuan ELSE 0 END) $namaKab ";
            $sql_add_2 .= ",b2.$namaKab";
        }
        $sql_query = "SELECT b.* $sql_add_2 FROM (
                SELECT a.id,a.tahun,a.id_kementrian, a.nama_kementrian,a.nama_dirjen,case when a.program_kementrian='N' then 1000 ELSE a.urutan END urutan, 
                a.id_program, a.nama_program,a.pic,a.contact_person,a.kuota,a.satuan,a.cpcl_status,a.verifikasi_status,a.kontrak_status,a.pengiriman_status,a.distribusi_status
                FROM program_alokasi_view a
                WHERE tahun=$request->tahun) b
                LEFT JOIN (SELECT x.id_program,x.tahun,x.nama_program
                $sql_add_1 
                FROM( 
                SELECT f.id_program,a.tahun, g.nama_program, e.id_kota,e.nama_kota,SUM(a.jumlah_bantuan) jumlah_bantuan 
                FROM proposal_view a
                LEFT JOIN kelompoks b ON a.id_kelompok=b.id
                LEFT JOIN kelurahans c ON b.id_kelurahan=c.id_kelurahan
                LEFT JOIN kecamatans d ON c.id_kecamatan=d.id_kecamatan
                LEFT JOIN kotas e ON d.id_kota=e.id_kota
                LEFT JOIN program_alokasis f ON a.id_program_alokasi=f.id
                LEFT JOIN programs g ON f.id_program=g.id
                GROUP BY f.id_program,a.tahun, g.nama_program,e.id_kota,e.nama_kota) x GROUP BY x.id_program,x.tahun,x.nama_program) b2 ON b.id_program=b2.id_program AND b.tahun=b2.tahun 
                ORDER BY b.urutan,b.nama_dirjen asc";
        // return $sql_query;
        $query = DB::select($sql_query);
        $result = [];
        foreach ($query as $qr) {
            $row = [];
            $row['id'] = $qr->id;
            $row['tahun'] = $qr->tahun;
            $row['id_program'] = $qr->id_program;
            $row['nama_dirjen'] = $qr->nama_dirjen;
            $row['nama_program'] = $qr->nama_program;
            $row['pic'] = $qr->pic;
            $row['contact_person'] = $qr->contact_person;
            $row['kuota'] = $qr->kuota;
            foreach ($list_kota as $lkt) {
                $kota = str_replace(' ', '_', str_replace('KABUPATEN ', '', $lkt->nama_kota));
                $row[$kota] = $qr->$kota;
            }
            $row['cpcl_status'] = $qr->cpcl_status;
            $row['verifikasi_status'] = $qr->verifikasi_status;
            $row['kontrak_status'] = $qr->kontrak_status;
            $row['pengiriman_status'] = $qr->pengiriman_status;
            $row['distribusi_status'] = $qr->distribusi_status;
            $result[$qr->id_kementrian][] = $row;
        }
        // $result_row = collect($result[3])->countBy('nama_dirjen');
        $result_row = [];
        foreach ($list_kementrian as $lkMen) {
            $result_row[$lkMen->id] = collect($result[$lkMen->id])->countBy('nama_dirjen');
        }
        // return $result_row;
        ob_start();
        $data['list_kota'] = $list_kota;
        $data['list_kementrian'] = $list_kementrian;
        $data['jml_col'] = $list_kota->count();
        $data['result'] = $result;
        $data['result_row'] = $result_row;
        echo view('report_rekap_usulan_program.report', $data);
        $content = ob_get_clean();
        return ['html' => response($content)];
    }
}
