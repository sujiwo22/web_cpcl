<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Kelompok;
use App\Http\Controllers\FileController;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;

class ProposalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sumber = $request->sumber;
            $query = DB::table(Proposal::$view)->select('*');
            if ($sumber == '') {
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if ($request->filled('tahun')) {
                            $query->where('tahun', $request->tahun);
                        }
                        if ($request->filled('id_provinsi')) {
                            $query->where('id_provinsi', $request->id_provinsi);
                        }
                        if ($request->filled('id_kota')) {
                            $query->where('id_kota', $request->id_kota);
                        }
                        if ($request->filled('id_kecamatan')) {
                            $query->where('id_kecamatan', $request->id_kecamatan);
                        }
                        if ($request->filled('id_kelurahan')) {
                            $query->where('id_kelurahan', $request->id_kelurahan);
                        }
                        if ($request->filled('id_kelompok')) {
                            $query->where('id_kelompok', $request->id_kelompok);
                        }
                    }, true)
                    ->addIndexColumn()
                    ->addColumn('action_button', function ($row) {
                        return '<div class="btn-group">
                        <a class="btn btn-sm btn-success" id="btnExcel" href="' . route('proposal.download_excel', $row->id) . '"><i class="fa fa-file-excel"></i></a>
                        <div class="btn btn-sm btn-primary" id="btnEdit" onclick="editData(' . $row->id . ')"><i class="fa fa-edit"></i></div>
                        <div class="btn btn-sm btn-warning" id="btnDelete" onclick="viewData(' . $row->id . ')"><i class="fa fa-bars"></i></div>
                        <div class="btn btn-sm btn-danger" id="btnDelete" onclick="deleteData(' . $row->id . ')"><i class="fa fa-times-circle"></i></div>
                    </div>';
                    })
                    ->addColumn('proposal_button', function ($row) {
                        $file = $row->file;
                        $exp = explode('/', $file);
                        $file_name = $exp != null && count($exp) > 1 ? $exp[1] : '';
                        $url = 'view-file/' . $file_name;
                        $url2 = 'download-file/' . $file_name;
                        if ($row->status_proposal == 'N') {
                            return 'Tanpa Proposal';
                        } else {

                            if ($file_name == '') {
                                return '<span class="text-default">File Not Found!</span>';
                            } else {
                                $fileController = new FileController;
                                $checkFile = $fileController->checkFile($file_name);
                                if (!$checkFile) {
                                    return '<span class="text-default">File Not Found!</span>';
                                } else {
                                    return '<div class="btn-group">
                        <a class="btn btn-sm btn-primary" id="btnEdit" href="' . $url2 . '"><i class="fa fa-download"></i></a>
                        <a class="btn btn-sm btn-info" id="btnDelete" href="' . $url . '" target="_blank"><i class="fa fa-eye"></i></a>
                    </div>';
                                }
                            }
                        }
                    })
                    ->rawColumns(['action_button', 'proposal_button'])
                    ->make(true);
            } else {
                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if ($request->filled('tahun')) {
                            $query->where('tahun', $request->tahun);
                        }
                        if ($request->filled('id_provinsi')) {
                            $query->where('id_provinsi', $request->id_provinsi);
                        }
                        if ($request->filled('id_kota')) {
                            $query->where('id_kota', $request->id_kota);
                        }
                        if ($request->filled('id_kecamatan')) {
                            $query->where('id_kecamatan', $request->id_kecamatan);
                        }
                        if ($request->filled('id_kelurahan')) {
                            $query->where('id_kelurahan', $request->id_kelurahan);
                        }
                        if ($request->filled('id_kelompok')) {
                            $query->where('id_kelompok', $request->id_kelompok);
                        }
                    }, true)
                    ->addIndexColumn()
                    ->addColumn('action_button', function ($row) {
                        return '<div class="btn-group">
                        <a class="btn btn-sm btn-success" id="btnExcel" href="' . route('proposal.download_excel', $row->id) . '"><i class="fa fa-file-excel"></i></a>
                        <div class="btn btn-sm btn-primary" id="btnEdit" onclick="editDataProposal(' . $row->id . ')"><i class="fa fa-edit"></i></div>
                        <div class="btn btn-sm btn-warning" id="btnDelete" onclick="viewDataProposal(' . $row->id . ')"><i class="fa fa-bars"></i></div>
                        <div class="btn btn-sm btn-danger" id="btnDelete" onclick="deleteDataProposal(' . $row->id . ')"><i class="fa fa-times-circle"></i></div>
                    </div>';
                    })
                    ->addColumn('proposal_button', function ($row) {
                        $file = $row->file;
                        $exp = explode('/', $file);
                        $file_name = $exp != null && count($exp) > 1 ? $exp[1] : '';
                        $url = 'view-file/' . $file_name;
                        $url2 = 'download-file/' . $file_name;
                        if ($row->status_proposal == 'N') {
                            return 'Tanpa Proposal';
                        } else {

                            if ($file_name == '') {
                                return '<span class="text-default">File Not Found!</span>';
                            } else {
                                $fileController = new FileController;
                                $checkFile = $fileController->checkFile($file_name);
                                if (!$checkFile) {
                                    return '<span class="text-default">File Not Found!</span>';
                                } else {
                                    return '<div class="btn-group">
                        <a class="btn btn-sm btn-primary" id="btnEdit" href="' . $url2 . '"><i class="fa fa-download"></i></a>
                        <a class="btn btn-sm btn-info" id="btnDelete" href="' . $url . '" target="_blank"><i class="fa fa-eye"></i></a>
                    </div>';
                                }
                            }
                        }
                    })
                    ->rawColumns(['action_button', 'proposal_button'])
                    ->make(true);
            }
        }
        $data['title'] = 'Proposal';
        $data['tahun_mulai'] = date('Y') - 2;
        $data['tahun_selesai'] = date('Y') + 5;
        return view('proposals.index', $data);
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
        $id = null;
        if (isset($request->id)) {
            $id = $request->id;
            $source = 'proposal';
        } elseif (isset($request->id_proposal)) {
            $id = $request->id_proposal;
            $source = 'kelompok';
        } else {
            $id = null;
        }
        $act = null;
        if (isset($request->act)) {
            $act = $request->act;
            $source = 'proposal';
        } elseif (isset($request->actProposal)) {
            $act = $request->actProposal;
            $source = 'kelompok';
        } else {
            $act = null;
        }
        $file = null;
        $source = null;
        if (isset($request->file)) {
            $file = $request->file;
            $source = 'proposal';
        } elseif (isset($request->file_proposal)) {
            $file = $request->file_proposal;
            $source = 'kelompok';
        } else {
            $file = null;
        }
        // if ($file != null) {
        // }
        $tahun = null;
        if (isset($request->tahun)) {
            $tahun = $request->tahun;
        } elseif (isset($request->tahun_proposal)) {
            $tahun = $request->tahun_proposal;
        } else {
            $tahun = null;
        }
        $status_proposal = null;
        if (isset($request->status_proposal)) {
            $status_proposal = $request->status_proposal;
        } else {
            $status_proposal = null;
        }
        // $status_proposal = $request->status_proposal;
        $id_kelompok = null;
        if (isset($request->id_kelompok)) {
            $id_kelompok = $request->id_kelompok;
        } elseif (isset($request->id_kelompok_proposal)) {
            $id_kelompok = $request->id_kelompok_proposal;
        } else {
            $id_kelompok = null;
        }
        $nama_kelompok = null;
        if (isset($request->nama_kelompok)) {
            $nama_kelompok = $request->nama_kelompok;
        } elseif (isset($request->nama_kelompok_proposal)) {
            $nama_kelompok = $request->nama_kelompok_proposal;
        } else {
            $nama_kelompok = null;
        }
        $alamat_kelompok = null;
        if (isset($request->alamat_kelompok)) {
            $alamat_kelompok = $request->alamat_kelompok;
        } elseif (isset($request->alamat_kelompok_proposal)) {
            $alamat_kelompok = $request->alamat_kelompok_proposal;
        } else {
            $alamat_kelompok = null;
        }
        $id_program_alokasi = null;
        if (isset($request->id_program_alokasi)) {
            $id_program_alokasi = $request->id_program_alokasi;
        } elseif (isset($request->id_program_alokasi_proposal)) {
            $id_program_alokasi = $request->id_program_alokasi_proposal;
        } else {
            $id_program_alokasi = null;
        }
        $jenis_bantuan = null;
        if (isset($request->jenis_bantuan)) {
            $jenis_bantuan = $request->jenis_bantuan;
        } elseif (isset($request->jenis_bantuan_proposal)) {
            $jenis_bantuan = $request->jenis_bantuan_proposal;
        } else {
            $jenis_bantuan = null;
        }
        $jumlah_bantuan = null;
        if (isset($request->jumlah_bantuan)) {
            $jumlah_bantuan = $request->jumlah_bantuan;
        } elseif (isset($request->jumlah_bantuan_proposal)) {
            $jumlah_bantuan = $request->jumlah_bantuan_proposal;
        } else {
            $jumlah_bantuan = null;
        }
        $id_pic_penyuluh = null;
        if (isset($request->id_pic_penyuluh)) {
            $id_pic_penyuluh = $request->id_pic_penyuluh;
        } elseif (isset($request->id_pic_penyuluh_proposal)) {
            $id_pic_penyuluh = $request->id_pic_penyuluh_proposal;
        } else {
            $id_pic_penyuluh = null;
        }
        $nama_penyuluh = null;
        if (isset($request->nama_penyuluh)) {
            $nama_penyuluh = $request->nama_penyuluh;
        } elseif (isset($request->nama_penyuluh_proposal)) {
            $nama_penyuluh = $request->nama_penyuluh_proposal;
        } else {
            $nama_penyuluh = null;
        }
        $contact_person_penyuluh = null;
        if (isset($request->contact_person_penyuluh)) {
            $contact_person_penyuluh = $request->contact_person_penyuluh;
        } elseif (isset($request->contact_person_penyuluh_proposal)) {
            $contact_person_penyuluh = $request->contact_person_penyuluh_proposal;
        } else {
            $contact_person_penyuluh = null;
        }
        $id_pic_penanggung_jawab = null;
        if (isset($request->id_pic_penanggung_jawab)) {
            $id_pic_penanggung_jawab = $request->id_pic_penanggung_jawab;
        } elseif (isset($request->id_pic_penanggung_jawab_proposal)) {
            $id_pic_penanggung_jawab = $request->id_pic_penanggung_jawab_proposal;
        } else {
            $id_pic_penanggung_jawab = null;
        }
        $nama_penanggung_jawab = null;
        if (isset($request->nama_penanggung_jawab)) {
            $nama_penanggung_jawab = $request->nama_penanggung_jawab;
        } elseif (isset($request->nama_penanggung_jawab_proposal)) {
            $nama_penanggung_jawab = $request->nama_penanggung_jawab_proposal;
        } else {
            $nama_penanggung_jawab = null;
        }
        $contact_person_penanggung_jawab = null;
        if (isset($request->contact_person_penanggung_jawab)) {
            $contact_person_penanggung_jawab = $request->contact_person_penanggung_jawab;
        } elseif (isset($request->contact_person_penanggung_jawab_proposal)) {
            $contact_person_penanggung_jawab = $request->contact_person_penanggung_jawab_proposal;
        } else {
            $contact_person_penanggung_jawab = null;
        }

        $data_processed = [
            'tahun' => $tahun,
            'status_proposal' => $status_proposal,
            'id_kelompok' => $id_kelompok,
            'nama_kelompok' => $nama_kelompok,
            'alamat_kelompok' => $alamat_kelompok,
            'id_program_alokasi' => $id_program_alokasi,
            'jenis_bantuan' => $jenis_bantuan,
            'jumlah_bantuan' => $jumlah_bantuan,
            'id_pic_penyuluh' => $id_pic_penyuluh,
            'nama_penyuluh' => $nama_penyuluh,
            'contact_person_penyuluh' => $contact_person_penyuluh,
            'id_pic_penanggung_jawab' => $id_pic_penanggung_jawab,
            'nama_penanggung_jawab' => $nama_penanggung_jawab,
            'contact_person_penanggung_jawab' => $contact_person_penanggung_jawab,
        ];
        // echo json_encode($data_processed);
        $msg = null;
        if ($file != null) {
            if ($source == 'proposal') {
                $validator = Validator::make($request->all(), [
                    'file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
                ]);
                $msg = $validator->errors()->first('file');
                $path = $request->file('file')->store('private_pdfs', 'local');

                $data_processed['file'] = $path;
            } elseif ($source == 'kelompok') {
                $validator = Validator::make($request->all(), [
                    'file_proposal' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
                ]);
                $msg = $validator->errors()->first('file_proposal');
                $path = $request->file('file_proposal')->store('private_pdfs', 'local');
            }
            $data_processed['file'] = $path;
        }
        if ($msg != null) {
            $response = [
                'status' => false,
                'message' => $msg,
            ];
        } else {
            if ($act == 'edit') {
                $result = DB::table(Proposal::$view)->where(['id' => $id])->first();
                // echo json_encode($result);
                if (($result->status_proposal == 'N' && $status_proposal == 'Y' && $file == null)) {
                    $response = [
                        'status' => false,
                        'message' => 'Silahkan upload file proposal.',
                    ];
                } else {
                    $data_processed['upd_id_user'] = $idUser;
                    $save = Proposal::where('id', $id)->update($data_processed);
                    if ($save) {
                        $file_before = $result->file;
                        $exp = explode('/', $file_before);
                        $file_name = $exp != null && count($exp) > 1 ? $exp[1] : '';
                        if ($file_name != '' && $file != '') {
                            if (Storage::disk('local')->exists("private_pdfs/{$file_name}")) {
                                Storage::disk('local')->delete("private_pdfs/{$file_name}");
                            }
                        }
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
            } else {
                if ($status_proposal == 'Y' && $file == null) {
                    $response = [
                        'status' => false,
                        'message' => 'Silahkan upload file proposal.',
                    ];
                } else {
                    $data_processed['crt_id_user'] = $idUser;
                    $save = Proposal::create($data_processed);
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = DB::table(Proposal::$view)->where(['id' => $id])->first();
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
        $data = Proposal::find($id);
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

    function downloadExcel(string $id)
    {
        $result = DB::table(Proposal::$view)->where('id', $id)->first();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $col = get_col(1, 1);
        $col_2 = get_col(3, 6);
        $sheet->setCellValue($col, strtoupper($result->jenis_bantuan));
        $sheet->mergeCells('' . $col . ':' . $col_2 . '');
        $sheet->getStyle('' . $col . ':' . $col_2 . '')->applyFromArray(getStyleFontHeaderBlue());
        $data_array = [
            'NAMA KELOMPOK : ' . $result->nama_kelompok,
            'ALAMAT KELOMPOK : ' . $result->alamat_kelompok,
            'JENIS BANTUAN : ' . $result->jenis_bantuan,
            'JUMLAH BANTUAN : ' . number_format($result->jumlah_bantuan, 0, ',', '.') . ' ' . $result->satuan,
            'NAMA PENYULUH : ' . $result->nama_penyuluh,
            'NOMOR HP PENYULUH : ' . $result->contact_person_penyuluh,
            'NAMA PENANGGUNG JAWAB : ' . $result->nama_penanggung_jawab,
            'NOMOR HP PENANGGUNG JAWAB : ' . $result->contact_person_penanggung_jawab
        ];
        $startRow = 4;
        $startCol = 1;
        $row_number = $startRow;
        $col_number = $startCol;
        foreach ($data_array as $key_da) {
            $col = get_col($row_number, $col_number);
            $col_number += 5;
            $col_2 = get_col($row_number, $col_number);
            $sheet->setCellValue($col, $key_da);
            $sheet->mergeCells('' . $col . ':' . $col_2 . '');
            $sheet->getStyle('' . $col . ':' . $col_2 . '')->applyFromArray(getStyleRow());
            $row_number++;
            $col_number = $startCol;
        }
        $field = [
            'No',
            'Nama',
            'NIK',
            'Jabatan',
            'No. HP',
            'Alamat'
        ];
        foreach ($field as $fl) {
            $col = get_col($row_number, $col_number);
            $sheet->setCellValue($col, $fl);
            $sheet->getStyle($col)->applyFromArray(getStyleFontHeaderTableBlue());
            $col_number++;
        }
        $list_anggota = DB::table(Anggota::$view)->where('id_kelompok_final', $result->id_kelompok)->get();
        $data_anggota = [];
        $no = 0;
        foreach ($list_anggota as $la) {
            $no++;
            $rowData = [];
            $rowData[] = $no;
            $rowData[] = $la->nama_anggota;
            $rowData[] = $la->nik;
            $rowData[] = $la->nama_jabatan;
            $rowData[] = $la->no_hp;
            $rowData[] = $la->alamat;
            $data_anggota[] = $rowData;
        }
        $row_number++;
        foreach ($data_anggota as $da) {
            $col_number = $startCol;
            foreach ($da as $da_detail) {
                $col = get_col($row_number, $col_number);
                $sheet->setCellValue($col, $da_detail);
                $sheet->getStyle($col)->applyFromArray(getStyleRow());
                $col_number++;
            }
            $row_number++;
        }

        // $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // for ($i = 'A'; $i !=  $sheet->getHighestColumn(); $i++) {
        //     $sheet->getColumnDimension($i)->setAutoSize(TRUE);
        // }
        // $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }
        $sheet->setTitle('Data');

        $writer = new Xlsx($spreadsheet);
        $fileName = $result->nama_kelompok . '.xlsx';

        // Prepare headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');

        $writer->save('php://output');
    }
}
