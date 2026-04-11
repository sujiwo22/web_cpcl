<style>
    .table-container {
        max-height: 600px;
        /* Set a fixed height to enable scrolling */
        overflow-y: auto;
        /* Add vertical scrollbar when content overflows */
        width: 100%;
        border: 1px solid #ccc;
    }

    .table-container table {
        width: 100%;
        border-collapse: collapse;
        /* Collapse borders for a cleaner look */
    }

    .table-container th,
    td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
        background-color: #f9f9f9;
        /* Add background color to prevent text overlap */
    }

    .table-container thead th {
        position: sticky;
        /* Make headers sticky */
        z-index: 10;
        /* Ensure headers appear above body content */
    }

    /* Define the top position for each header row */
    .table-container thead tr:first-child th {
        top: 0;
        /* The first row sticks to the top of the container */
    }

    .table-container thead tr:nth-child(2) th {
        /* The second row sticks below the first row. Adjust '42px' based on the actual height of the first row. */
        top: 35px;
    }

    /* Repeat for additional header rows if necessary */

    .table-container tbody {
        /* You do not need "display: block" on tbody with this method,
       which helps preserve default table layout and column alignment. */
    }
</style>
@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Kelompok Masyarakat') }}</h3>
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" onclick="addForm()"><i
                                        class="fa fa-plus-circle"></i> Add Data</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link bg-success ml-2" href="#" onclick="uploadForm()"><i
                                        class="fa fa-upload"></i> Upload Data</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card-body">
                    <div class="alert alert-success d-none" id="success-alert"></div>
                    <div class="alert alert-warning d-none" id="failed-alert"></div>
                    <div class="row mb-2">
                        <div class="col-lg-2">
                            <label>Kementrian</label>
                            <select name="id_kementrian_filter" id="id_kementrian_filter" class="form-control"
                                placeholder="Kementrian">
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label>Provinsi</label>
                            <select name="id_provinsi_filter" id="id_provinsi_filter" class="form-control"
                                placeholder="Provinsi">
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label>Kota</label>
                            <select name="id_kota_filter" id="id_kota_filter" class="form-control" placeholder="Kota">
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label>Kecamatan</label>
                            <select name="id_kecamatan_filter" id="id_kecamatan_filter" class="form-control"
                                placeholder="Kecamatan">
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label>Kelurahan</label>
                            <select name="id_kelurahan_filter" id="id_kelurahan_filter" class="form-control"
                                placeholder="Kelurahan">
                            </select>
                        </div>
                        <div class="col-lg-1">
                            <div class="btn btn-app bg-warning mt-2" id="btnSearch"><i class="fa fa-search"></i>Cari
                            </div>
                        </div>
                    </div>
                    <div id="spaceFrontTable">
                        <table class="table table-bordered nowrap" id="tableKelompok">
                            <thead>
                                <tr class="bg-primary">
                                    <th scope="col">No</th>
                                    <th scope="col" style="width: 20%">Actions</th>
                                    <th scope="col">Kementrian</th>
                                    <th scope="col">Nama Kelompok</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Penanggung Jawab</th>
                                    <th scope="col">No. HP</th>
                                    <th scope="col">Jml. Angggota</th>
                                    <!-- <th scope="col">Kecamatan</th>
                                <th scope="col">Kota</th>
                                <th scope="col">Provinsi</th> -->
                                    <th scope="col">Created by</th>
                                    <th scope="col">Created at</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div id="spaceForDetail">
                        <div class="card card-primary card-tabs">
                            <div class="card-header p-0 pt-1">
                                <div class="card-tools">
                                    <div class="btn btn-tool btn-sm text-white" onclick="backToFront()">
                                        <i class="fas fa-chevron-left"></i> Kembali
                                    </div>
                                </div>

                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true"><i class="fa fa-list"></i> Detail Kelompok</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false" onclick="viewTableAnggota()"><i class="fa fa-users"></i> List Anggota</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false" onclick="viewTableProposal()"><i class="fa fa-file"></i> Proposal/Pengajuan Bantuan</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                        <div class="row">
                                            <div class="col-lg-3">NAMA KELOMPOK</div>
                                            <input type="hidden" id="id_kelompok_det">
                                            <div class="col-lg-9"><span id="namaKelompokSpn"></span></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3">ALAMAT</div>
                                            <div class="col-lg-9"><span id="alamatKelompokSpn"></span></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3">KABUPATEN/KOTA</div>
                                            <input type="hidden" id="id_provinsi_det">
                                            <input type="hidden" id="id_kota_det">
                                            <div class="col-lg-9"><span id="kotaSpn"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3">KECAMATAN</div>
                                            <input type="hidden" id="id_kecamatan_det">
                                            <div class="col-lg-9"><span id="kecamatanSpn"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3">KELURAHAN</div>
                                            <input type="hidden" id="id_kelurahan_det">
                                            <div class="col-lg-9"><span id="kelurahanSpn"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3">PENANGGUNG JAWAB</div>
                                            <div class="col-lg-9"><span id="namaPenanggungJawabSpn"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3">NO. HP PENANGGUNG JAWAB</div>
                                            <div class="col-lg-9"><span id="noHpPenanggungJawabSpn"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3">KEMENTRIAN</div>
                                            <div class="col-lg-9"><span id="kementrianSpn"></div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                        <div class="clearfix" style="float: right;">
                                            <div class="btn btn-success mb-1" id="btnAddAnggota" onclick="addAnggota()"><i class="fa fa-user-plus"></i> Tambah Anggota</div>
                                        </div>
                                        <table class="table table-bordered table-sm nowrap" id="tableAnggota">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th>No</th>
                                                    <th>NIK</th>
                                                    <th>Nama Lengkap</th>
                                                    <th>Jabatan</th>
                                                    <th>No. HP</th>
                                                    <th>TPS</th>
                                                    <th>Tingkat Dukungan</th>
                                                    <th>Alamat</th>
                                                    <th>Created by</th>
                                                    <th>Created at</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                                        <div class="clearfix" style="float: right;">
                                            <div class="btn btn-success mb-1" id="btnAddProposal" onclick="addProposal()"><i class="fa fa-plus-circle"></i> Tambah Proposal</div>
                                        </div>
                                        <!-- <div class="table-container"> -->
                                        <table class="table table-bordered nowrap" id="tableProposal">
                                            <thead>
                                                <tr class="bg-primary">
                                                    <th scope="col" rowspan="2" style="vertical-align: middle; background-color: #007bff; color:#FFFFFF;" nowrap>No</th>
                                                    <th scope="col" rowspan="2" style="vertical-align: middle; background-color: #007bff; color:#FFFFFF;" nowrap>Actions</th>
                                                    <th scope="col" rowspan="2" style="vertical-align: middle; background-color: #007bff; color:#FFFFFF;" nowrap>Proposal</th>
                                                    <th scope="col" rowspan="2" style="vertical-align: middle; background-color: #007bff; color:#FFFFFF;" nowrap>Tahun</th>
                                                    <th scope="col" rowspan="2" style="vertical-align: middle; background-color: #007bff; color:#FFFFFF;" nowrap>Kementrian</th>
                                                    <th scope="col" rowspan="2" style="vertical-align: middle; background-color: #007bff; color:#FFFFFF;" nowrap>Jenis Bantuan</th>
                                                    <th scope="col" rowspan="2" style="vertical-align: middle; background-color: #007bff; color:#FFFFFF;" nowrap>Jml. Bantuan</th>
                                                    <th scope="col" colspan="5" class="text-center" nowrap>STATUS</th>
                                                    <th scope="col" rowspan="2" style="vertical-align: middle; background-color: #007bff; color:#FFFFFF;" nowrap>Created by</th>
                                                    <th scope="col" rowspan="2" style="vertical-align: middle; background-color: #007bff; color:#FFFFFF;" nowrap>Created at</th>
                                                </tr>
                                                <tr>
                                                    <th scope="col" style=" background-color: #007bff; color:#FFFFFF;" nowrap>CPCL</th>
                                                    <th scope="col" style=" background-color: #007bff; color:#FFFFFF;" nowrap>VERIFIKASI</th>
                                                    <th scope="col" style=" background-color: #007bff; color:#FFFFFF;" nowrap>KONTRAK</th>
                                                    <th scope="col" style=" background-color: #007bff; color:#FFFFFF;" nowrap>PENGIRIMAN</th>
                                                    <th scope="col" style=" background-color: #007bff; color:#FFFFFF;" nowrap>DISTRIBUSI</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                        <!-- </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalForm">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"></h4>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <form data-toggle="validator" id="formCRUD">
                @csrf
                <input id="id" name="id" type="hidden">
                <input id="act" name="act" type="hidden">
                <div class="modal-body">
                    <div class="alert alert-warning d-none" id="failed-alert"></div>
                    <div class="form-group">
                        <label>Kementrian</label>
                        <select name="id_kementrian" id="id_kementrian" class="form-control" aria-placeholder="Kementrian" required>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Provinsi *)</label>
                                <select name="id_provinsi" id="id_provinsi" class="form-control"
                                    aria-placeholder="Provinsi" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Kota *)</label>
                                <select name="id_kota" id="id_kota" class="form-control" aria-placeholder="Kota"
                                    required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Kecamatan *)</label>
                                <select name="id_kecamatan" id="id_kecamatan" class="form-control"
                                    aria-placeholder="Kecamatan" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Kelurahan *)</label>
                                <select name="id_kelurahan" id="id_kelurahan" class="form-control"
                                    aria-placeholder="Kelurahan" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nama Kelompok *)</label>
                        <input autocomplete="off" class="form-control" id="nama_kelompok" name="nama_kelompok"
                            placeholder="Nama Kelompok Masyarakat" required type="text">
                    </div>
                    <div class="form-group">
                        <label>Alamat *)</label>
                        <input autocomplete="off" class="form-control" id="alamat" name="alamat" placeholder="Alamat"
                            required type="text">
                    </div>
                    <div class="form-group">
                        <label>Penanggung Jawab *)</label>
                        <input autocomplete="off" class="form-control" id="penanggung_jawab" name="penanggung_jawab"
                            placeholder="Nama Penanggung Jawab" type="text">
                    </div>
                    <div class="form-group">
                        <label>No. HP (Contact Person) *)</label>
                        <input autocomplete="off" class="form-control" id="no_hp" name="no_hp"
                            placeholder="No. HP (Contact Person)" type="text">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default pull-left" data-dismiss="modal" type="button"><i
                            class="fa fa-times-circle"></i> Close</button>
                    <button class="btn btn-primary" id="saveBtn" type="submit"><i class="fa fa-save"></i>
                        Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFormUpload">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"></h4>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <form data-toggle="validator" id="formUpload" enctype="multipart/form-data">
                @csrf
                <input id="id" name="id" type="hidden">
                <input id="act" name="act" type="hidden">
                <input id="id_kelompok" name="id_kelompok" type="hidden">
                <div class="modal-body">
                    <div class="alert alert-warning d-none" id="failed-alert-upload"></div>
                    <div class="alert alert-success d-none" id="success-alert-upload"></div>
                    <div class="form-group">
                        <label>Upload Excel</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" name="file">
                            <label class="custom-file-label" for="file">Choose file</label>
                        </div>
                    </div>
                    <button class="btn btn-block btn-success mb-2" type="submit" id="btnPreview"><i class="fa fa-eye"></i> Preview Data</button>
                    <div id="previewSec"></div>
                </div>
            </form>
            <div class="modal-footer">
                <button class="btn btn-default pull-left" data-dismiss="modal" type="button"><i
                        class="fa fa-times-circle"></i> Close</button>
                <button class="btn btn-primary" id="uploadBtn" type="button" onclick="processUpload()" disabled><i class="fa fa-upload"></i>
                    Upload</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFormAnggota">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"></h4>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">



            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFormAddAnggota">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"></h4>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <form data-toggle="validator" id="formCRUDAnggota">
                @csrf
                <input id="id" name="id" type="hidden">
                <input id="act" name="act" type="hidden">
                <div class="modal-body">
                    <div class="alert alert-warning d-none" id="failed-alert"></div>
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <input type="hidden" name="id_kelompok_anggota" id="id_kelompok_anggota">
                            <label>NIK *)</label>
                            <input autocomplete="off" class="form-control" id="nik_anggota" name="nik_anggota"
                                placeholder="NIK" required type="text">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Nama Lengkap *)</label>
                            <input autocomplete="off" class="form-control" id="nama_lengkap_anggota" name="nama_lengkap_anggota"
                                placeholder="Nama Lengkap" type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>No. HP</label>
                            <input autocomplete="off" class="form-control" id="no_hp_anggota" name="no_hp_anggota"
                                placeholder="No. HP (Contact Person)" type="text">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Jabatan/Status dalam Kelompok *)</label>
                            <select class="form-control" id="id_jabatan_anggota" name="id_jabatan_anggota"
                                placeholder="No. HP">
                            </select>
                        </div>
                    </div>
                    <label>Alamat</label>
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat_anggota" id="alamat_anggota" class="form-control" rows="3" placeholder="Alamat Lengkap" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Provinsi *)</label>
                                <select name="id_provinsi_anggota" id="id_provinsi_anggota" class="form-control" aria-placeholder="Provinsi" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Kota *)</label>
                                <select name="id_kota_anggota" id="id_kota_anggota" class="form-control" aria-placeholder="Kota" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Kecamatan *)</label>
                                <select name="id_kecamatan_anggota" id="id_kecamatan_anggota" class="form-control" aria-placeholder="Kecamatan" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Kelurahan *)</label>
                                <select name="id_kelurahan_anggota" id="id_kelurahan_anggota" class="form-control" aria-placeholder="Kelurahan" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>TPS</label>
                                <select name="id_tps_anggota" id="id_tps_anggota" class="form-control" aria-placeholder="TPS">
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Tingkat Dukungan</label>
                                <select name="tingkat_dukungan_anggota" id="tingkat_dukungan_anggota" class="form-control" aria-placeholder="Tingkat Dukungan">
                                    <option value="">[Please Select]</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default pull-left" data-dismiss="modal" type="button"><i
                            class="fa fa-times-circle"></i> Close</button>
                    <button class="btn btn-primary" id="saveAnggotaBtn" type="submit"><i class="fa fa-save"></i>
                        Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFormProposal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"></h4>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <form data-toggle="validator" id="formCRUDProposal" enctype="multipart/form-data">
                @csrf
                <input id="id_proposal" name="id_proposal" type="hidden">
                <input id="actProposal" name="actProposal" type="hidden">
                <div class="modal-body">
                    <!-- <div class="alert alert-warning d-none" id="failed-alert"></div> -->
                    <div class="alert alert-success d-none" id="success-alert-proposal"></div>
                    <div class="alert alert-warning d-none" id="failed-alert-proposal"></div>
                    <div class="row">
                        <div class="col-lg-2 form-group">
                            <label>Tahun *)</label>
                            <select name="tahun_proposal" id="tahun_proposal" class="form-control" aria-placeholder="Tahun" required>
                                <option value="">[Please Select]</option>
                                @for ($i=$tahun_mulai;$i<=$tahun_selesai; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Apakah Menggunakan Proposal? *)</label>
                            <select name="status_proposal" id="status_proposal" class="form-control" required>
                                <option value="">[Please Select]</option>
                                <option value="Y">Iya. Dengan Proposal</option>
                                <option value="N">Tidak. Tanpa Proposal</option>
                            </select>
                        </div>
                        <div class="col-lg-4 form-group">
                            <label>File Proposal</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="file_proposal" name="file_proposal">
                                <label class="custom-file-label" for="file_proposal">Choose file</label>
                            </div>
                            <div id="txtSmall"><small class="text-red">Jika file tidak diganti, maka kosongkan saja.</small></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label>Kelompok Masyarakat *)</label>
                                <span name="nama_kelompok_span" id="nama_kelompok_span" class="form-control"></span>
                                <input type="hidden" name="nama_kelompok_proposal" id="nama_kelompok_proposal" class="form-control" required readonly>
                                <input type="hidden" name="alamat_kelompok_proposal" id="alamat_kelompok_proposal" class="form-control" required readonly>
                                <input type="hidden" name="id_kelompok_proposal" id="id_kelompok_proposal" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label>Program/Jenis Bantuan *)</label>
                                <div class="input-group">
                                    <span name="jenis_bantuan_span" id="jenis_bantuan_span" class="form-control"></span>
                                    <input type="hidden" name="jenis_bantuan_proposal" id="jenis_bantuan_proposal" class="form-control" required readonly>
                                    <input type="hidden" name="id_program_alokasi_proposal" id="id_program_alokasi_proposal" class="form-control" required readonly>
                                    <input type="hidden" name="id_program_proposal" id="id_program_proposal" class="form-control" required readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-success" style="cursor: pointer;" onclick="cariProgram()"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 form-group">
                            <label>Jumlah Bantuan *)</label>
                            <input type="number" class="form-control" name="jumlah_bantuan_proposal" id="jumlah_bantuan_proposal" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>Penyuluh</label>
                            <select id="id_pic_penyuluh_proposal" name="id_pic_penyuluh_proposal" class="form-control select2" onchange="detailPIC('id_pic_penyuluh_proposal','nama_penyuluh_proposal','contact_person_penyuluh_proposal')">
                            </select>
                            <input autocomplete="off" class="form-control" id="nama_penyuluh_proposal" name="nama_penyuluh_proposal" type="hidden">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Contact Person Penyuluh</label>
                            <input autocomplete="off" class="form-control" id="contact_person_penyuluh_proposal" name="contact_person_penyuluh_proposal"
                                placeholder="Contact Person" required type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>Penanggung Jawab</label>
                            <select id="id_pic_penanggung_jawab_proposal" name="id_pic_penanggung_jawab_proposal" class="form-control select2" onchange="detailPIC('id_pic_penanggung_jawab_proposal','nama_penanggung_jawab_proposal','contact_person_penanggung_jawab_proposal')">
                            </select>
                            <input autocomplete="off" class="form-control" id="nama_penanggung_jawab_proposal" name="nama_penanggung_jawab_proposal" type="hidden">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Contact Person Penanggung Jawab</label>
                            <input autocomplete="off" class="form-control" id="contact_person_penanggung_jawab_proposal" name="contact_person_penanggung_jawab_proposal"
                                placeholder="Contact Person" required type="text">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default pull-left" data-dismiss="modal" type="button"><i
                            class="fa fa-times-circle"></i> Close</button>
                    <button class="btn btn-primary" id="saveBtnProposal" type="submit"><i class="fa fa-save"></i>
                        Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFormProgram">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"></h4>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-lg-3">
                        <label>Status Program</label>
                        <select name="program_kementrian_filter_program" id="program_kementrian_filter_program" class="form-control" placeholder="Status Program">
                            <option value="">[Please Select]</option>
                            <option value="Y">Program Kementrian</option>
                            <option value="N">Program Non Kementrian</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label>Kementrian</label>
                        <select name="id_kementrian_filter_program" id="id_kementrian_filter_program" class="form-control" placeholder="Kementrian">
                            <option value="">[Please Select]</option>
                        </select>
                    </div>
                    <div class="col-lg-1">
                        <div class="btn btn-app bg-warning mt-2" id="btnFilterProgram"><i class="fa fa-filter"></i>Filter</div>
                    </div>
                </div>
                <table class="table table-bordered nowrap" id="tableProgram">
                    <thead>
                        <tr class="bg-primary">
                            <th scope="col">No</th>
                            <th scope="col" style="width: 20%">Actions</th>
                            <th scope="col">Kementrian</th>
                            <th scope="col">Dirjen</th>
                            <th scope="col">Nama Program</th>
                            <th scope="col">PIC</th>
                            <th scope="col">Contact Person</th>
                            <th scope="col">Kuota</th>
                            <th scope="col">Created by</th>
                            <th scope="col">Created at</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default pull-left" data-dismiss="modal" type="button"><i
                        class="fa fa-times-circle"></i> Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFormDetailProposal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"></h4>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3">NAMA KELOMPOK</div>
                    <input type="hidden" name="id_proposal" id="id_proposal">
                    <div class="col-lg-9">: <span id="nama_kelompok"></span></div>
                </div>
                <div class="row">
                    <div class="col-lg-3">ALAMAT KELOMPOK</div>
                    <div class="col-lg-9">: <span id="alamat_kelompok"></span></div>
                </div>
                <div class="row">
                    <div class="col-lg-3">JENIS BANTUAN</div>
                    <div class="col-lg-9">: <span id="jenis_bantuan"></span></div>
                </div>
                <div class="row">
                    <div class="col-lg-3">JUMLAH BANTUAN</div>
                    <div class="col-lg-9">: <span id="jumlah_bantuan"></span></div>
                </div>
                <div class="row">
                    <div class="col-lg-3">PENYULUH</div>
                    <div class="col-lg-9">: <span id="nama_penyuluh"></span></div>
                </div>
                <div class="row">
                    <div class="col-lg-3">NOMOR HP PENYULUH</div>
                    <div class="col-lg-9">: <span id="contact_person_penyuluh"></span></div>
                </div>
                <div class="row">
                    <div class="col-lg-3">PENANGGUNG JAWAB</div>
                    <div class="col-lg-9">: <span id="nama_penanggung_jawab"></span></div>
                </div>
                <div class="row">
                    <div class="col-lg-3">NOMOR HP PENANGGUNG JAWAB</div>
                    <div class="col-lg-9">: <span id="contact_person_penanggung_jawab"></span></div>
                </div>
                <table class="table table-bordered table-striped table-sm nowrap" id="tableListAnggota">
                    <thead>
                        <tr class="bg-info">
                            <th>No</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Jabatan</th>
                            <th>No. HP</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default pull-left" data-dismiss="modal" type="button"><i
                        class="fa fa-times-circle"></i> Close</button>
                <a class="btn btn-success" type="button" href="#" id="btnDownloadDetail"><i
                        class="fa fa-file-excel"></i> Download Excel</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFormUpdate">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"></h4>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <form data-toggle="validator" id="formCRUDUpdateStatus">
                @csrf
                <input id="code" name="code" type="hidden">
                <input id="id_status" name="id_status" type="hidden">
                <div class="modal-body">
                    <div class="alert alert-warning d-none" id="failed-alert"></div>
                    <div class="form-group">
                        <label>Status *)</label>
                        <select class="form-control" id="status" name="status"
                            placeholder="Status" required></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default pull-left" data-dismiss="modal" type="button"><i
                            class="fa fa-times-circle"></i> Close</button>
                    <button class="btn btn-primary" id="saveBtnUpdateStatus" type="submit"><i class="fa fa-save"></i>
                        Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    var table = $('#tableKelompok').DataTable({
        scrollX: true,
        scrollY: '400px',
        scrollCollapse: true,
    });
    var tableAnggota = $('#tableAnggota').DataTable();
    var tableListAnggota = $('#tableListAnggota').DataTable();
    var tableProposal = $('#tableProposal').DataTable();
    var tableProgram = $('#tableProgram').DataTable();
    let id_kementrian, id_provinsi, id_kota, id_kecamatan;
    $(function() {
        list_kementrian('id_kementrian_filter');
        list_provinsi('id_provinsi_filter');
        $('#spaceForDetail').addClass('d-none');
        $('#id_provinsi_filter').on('change', function() {
            id_provinsi = $('#id_provinsi_filter').val();
            list_kota('id_kota_filter', id_provinsi);
        });
        $('#id_provinsi').on('change', function() {
            var id_provinsi = $('#id_provinsi').val();
            list_kota('id_kota', id_provinsi);
        });
        $('#id_kota_filter').on('change', function() {
            id_kota = $('#id_kota_filter').val();
            list_kecamatan('id_kecamatan_filter', id_kota);
        });
        $('#id_kota').on('change', function() {
            var id_kota = $('#id_kota').val();
            list_kecamatan('id_kecamatan', id_kota);
        });
        $('#id_kecamatan_filter').on('change', function() {
            id_kecamatan = $('#id_kecamatan_filter').val();
            list_kelurahan('id_kelurahan_filter', id_kecamatan);
        });
        $('#id_kecamatan').on('change', function() {
            var id_kecamatan = $('#id_kecamatan').val();
            list_kelurahan('id_kelurahan', id_kecamatan);
        });
        $('#id_kelurahan_filter').on('change', function() {
            id_kelurahan = $('#id_kelurahan_filter').val();
        });

        $('#btnSearch').on('click', function() {
            $('#spaceForDetail').addClass('d-none');
            $('#spaceFrontTable').removeClass('d-none');
            showData();
        });

        $('#nik_anggota').on('keyup', function() {
            var nik = $(this).val();
            if (nik.length == 16) {
                var url = "{{ route('kelompok_anggota.cek_nik', ':id') }}";
                url = url.replace(':id', nik);
                $.ajax({
                    method: 'GET',
                    url: url,
                    beforeSend: function() {
                        $('#nama_lengkap_anggota').val('');
                        $('#alamat_anggota').val('');
                        $('#no_hp_anggota').val('');
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.nik != null) {
                            list_provinsi('id_provinsi_anggota', data.id_provinsi);
                            list_kota('id_kota_anggota', data.id_provinsi, data.id_kota);
                            list_kecamatan('id_kecamatan_anggota', data.id_kota, data.id_kecamatan);
                            list_kelurahan('id_kelurahan_anggota', data.id_kecamatan, data.id_kelurahan);
                            list_tps('id_tps_anggota', data.id_kelurahan, data.id_tps);
                            list_jabatan('id_jabatan_anggota', data.id_jabatan);
                            $('#nama_lengkap_anggota').val(data.nama_anggota);
                            $('#alamat_anggota').val(data.alamat);
                            $('#no_hp_anggota').val(data.no_hp);
                        } else {
                            var id_provinsi = $('#id_provinsi_det').val();
                            var id_kota = $('#id_kota_det').val();
                            var id_kecamatan = $('#id_kecamatan_det').val();
                            var id_kelurahan = $('#id_kelurahan_det').val();
                            list_provinsi('id_provinsi_anggota', id_provinsi);
                            list_kota('id_kota_anggota', id_provinsi, id_kota);
                            list_kecamatan('id_kecamatan_anggota', id_kota, id_kecamatan);
                            list_kelurahan('id_kelurahan_anggota', id_kecamatan, id_kelurahan);
                            list_tps('id_tps_anggota');
                            list_jabatan('id_jabatan_anggota');
                            $('#nama_lengkap_anggota').val('');
                            $('#alamat_anggota').val('');
                            $('#no_hp_anggota').val('');
                        }
                    },
                    error: function(response) {
                        alert('Something went wrong. Please try again.');
                    },
                    complete: function() {
                        // Re-enable button
                        $('#saveBtn').attr('disabled', false);
                    }
                });
            }
        });

        $('#btnFilterProgram').on('click', function() {
            var tahun = $('#tahun').val();
            var program_kementrian = $('#program_kementrian_filter_program').val();
            var id_kementrian = $('#id_kementrian_filter_program').val();
            ajaxListProgram(tahun, program_kementrian, id_kementrian);
        });

        // Start Form
        $('#status_proposal').on('change', function() {
            var status_proposal = $(this).val();
            if (status_proposal == 'Y') {
                $('#file_proposal').attr('disabled', false);
                $('#file_proposal').attr('required', true);
            } else {
                $('#file_proposal').attr('disabled', true);
                $('#file_proposal').attr('required', false);
            }
        });
        // End Form
    });

    $('#formCRUD').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        var act = $('#act').val();
        var url;
        url = "/kelompok_daftar";
        $(this).find('.error-text').text('');
        $('#success-alert').addClass('d-none').text('');
        $('#failed-alert').addClass('d-none').text('');

        $('#saveBtn').attr('disabled', true);

        $.ajax({
            method: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data['status']) {
                    $('#modalForm').modal('hide');
                    $('#success-alert').removeClass('d-none').text("Data telah berhasil disimpan.");
                    table.ajax.reload(null, false);
                } else {
                    $('#failed-alert').removeClass('d-none').text(data['message']);
                }
            },
            error: function(response) {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                } else {
                    alert('Something went wrong. Please try again.');
                }
            },
            complete: function() {
                // Re-enable button
                $('#saveBtn').attr('disabled', false);
            }
        });
    });

    $('#formUpload').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        var act = $('#act').val();
        var url;
        url = "/upload_data_kelompok";
        $(this).find('.error-text').text('');
        $('#success-alert-upload').addClass('d-none').text('');
        $('#failed-alert-upload').addClass('d-none').text('');


        $.ajax({
            method: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            enctype: "multipart/form-data",
            beforeSend: function() {
                $('#btnPreview').html('<i class="fa fa-spinner fa-spin"></i> Processing...');
                $('#uploadBtn').attr('disabled', true);
            },
            success: function(data) {
                $('#btnPreview').html('<i class="fa fa-eye"></i> Preview Data');
                if (data['status']) {
                    console.log(data);
                    $('#previewSec').html(data.html['original']);
                    $('#uploadBtn').attr('disabled', false);
                } else {
                    $('#failed-alert-upload').removeClass('d-none').text(data['message']);
                    $('#uploadBtn').attr('disabled', true);
                }
            },
            error: function(response) {
                $('#uploadBtn').attr('disabled', true);
                $('#btnPreview').html('<i class="fa fa-eye"></i> Preview Data');
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                } else {
                    alert('Something went wrong. Please try again.');
                }
            },
        });
    });

    $('#formCRUDAnggota').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        var act = $('#act').val();
        var url;
        url = "/kelompok_anggota";
        $(this).find('.error-text').text('');
        $('#success-alert').addClass('d-none').text('');
        $('#failed-alert').addClass('d-none').text('');

        $('#saveBtn').attr('disabled', true);

        var id_kelompok_anggota = $('#id_kelompok_anggota').val();
        var nik_anggota = $('#nik_anggota').val();
        var nama_lengkap_anggota = $('#nama_lengkap_anggota').val();
        var no_hp_anggota = $('#no_hp_anggota').val();
        var id_jabatan_anggota = $('#id_jabatan_anggota').val();
        var alamat_anggota = $('#alamat_anggota').val();
        var id_provinsi_anggota = $('#id_provinsi_anggota').val();
        var id_kota_anggota = $('#id_kota_anggota').val();
        var id_kecamatan_anggota = $('#id_kecamatan_anggota').val();
        var id_kelurahan_anggota = $('#id_kelurahan_anggota').val();
        var id_tps_anggota = $('#id_tps_anggota').val();
        var tingkat_dukungan_anggota = $('#tingkat_dukungan_anggota').val();
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        $.ajax({
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: url,
            data: {
                id_kelompok: id_kelompok_anggota,
                nik: nik_anggota,
                nama_lengkap: nama_lengkap_anggota,
                no_hp: no_hp_anggota,
                id_jabatan: id_jabatan_anggota,
                alamat: alamat_anggota,
                id_provinsi: id_provinsi_anggota,
                id_kota: id_kota_anggota,
                id_kecamatan: id_kecamatan_anggota,
                id_kelurahan: id_kelurahan_anggota,
                id_tps: id_tps_anggota,
                tingkat_dukungan: tingkat_dukungan_anggota,
            },
            // contentType: false,
            // processData: false,
            success: function(data) {
                if (data['status']) {
                    $('#modalFormAddAnggota').modal('hide');
                    $('#success-alert').removeClass('d-none').text("Data telah berhasil disimpan.");
                    tableAnggota.ajax.reload(null, false);
                } else {
                    $('#failed-alert').removeClass('d-none').text(data['message']);
                }
            },
            error: function(response) {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                } else {
                    alert('Something went wrong. Please try again.');
                }
            },
            complete: function() {
                // Re-enable button
                $('#saveBtn').attr('disabled', false);
            }
        });
    });

    $('#formCRUDProposal').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        var act = $('#actProposal').val();
        var url;
        url = "/proposal";
        $(this).find('.error-text').text('');
        $('#success-alert').addClass('d-none').text('');
        $('#success-alert-proposal').addClass('d-none').text('');
        $('#failed-alert-proposal').addClass('d-none').text('');

        $('#saveBtnProposal').attr('disabled', true);

        $.ajax({
            method: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            enctype: "multipart/form-data",
            success: function(data) {
                if (data['status']) {
                    $('#modalFormProposal').modal('hide');
                    $('#success-alert').removeClass('d-none').text("Data telah berhasil disimpan.");
                    $('#success-alert-proposal').removeClass('d-none').text("Data telah berhasil disimpan.");
                    $('#failed-alert-proposal').addClass('d-none').text('');
                    tableProposal.ajax.reload(null, false);
                } else {
                    $('#failed-alert-proposal').removeClass('d-none').text(data['message']);
                }
                $('#saveBtnProposal').attr('disabled', false);
            },
            error: function(response) {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                } else {
                    alert('Something went wrong. Please try again.');
                }
                $('#saveBtnProposal').attr('disabled', false);
            },
            complete: function() {
                // Re-enable button
                $('#saveBtnProposal').attr('disabled', false);
            }
        });
    });

    $('#formCRUDUpdateStatus').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        var act = $('#act').val();
        var url;
        url = "/update_status_proposal";
        $(this).find('.error-text').text('');
        $('#success-alert').addClass('d-none').text('');
        $('#failed-alert').addClass('d-none').text('');

        $.ajax({
            method: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#saveBtnUpdateStatus').attr('disabled', true);
            },
            success: function(data) {
                $('#saveBtnUpdateStatus').attr('disabled', false);
                if (data['status']) {
                    $('#modalFormUpdate').modal('hide');
                    $('#success-alert').removeClass('d-none').text("Data telah berhasil disimpan.");
                    $('#' + data['code'] + data['id']).text(data['status_data']);
                    $('#' + data['code'] + data['id']).removeClass('text-green');
                    $('#' + data['code'] + data['id']).removeClass('text-red');
                    $('#' + data['code'] + data['id']).removeClass('text-yellow');
                    $('#' + data['code'] + data['id']).addClass(data['new_tl']);
                    // table.ajax.reload(null, false);
                } else {
                    $('#failed-alert').removeClass('d-none').text(data['message']);
                }
            },
            error: function(response) {
                $('#saveBtnUpdateStatus').attr('disabled', false);
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                } else {
                    alert('Something went wrong. Please try again.');
                }
            },
        });
    });

    function processUpload() {
        const form = document.querySelector('#formUpload');
        let formData = new FormData(form);
        var act = $('#act').val();
        var url;
        url = "/upload_data_kelompok_process";
        $(this).find('.error-text').text('');
        $('#success-alert-upload').addClass('d-none').text('');
        $('#failed-alert-upload').addClass('d-none').text('');


        $.ajax({
            method: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            enctype: "multipart/form-data",
            beforeSend: function() {
                $('#uploadBtn').html('<i class="fa fa-spinner fa-spin"></i> Processing...');
                // $('#uploadBtn').attr('disabled', true);
            },
            success: function(data) {
                $('#uploadBtn').html('<i class="fa fa-uload"></i> Upload');
                if (data['status']) {
                    console.log(data);
                    $('#modalFormUpload').modal('hide');
                    $('#success-alert-upload').removeClass('d-none').text("Data telah berhasil diupload.");
                    showData();
                    // table.ajax.reload(null, false);
                    // $('#previewSec').html(data.html['original']);
                    // $('#uploadBtn').attr('disabled', false);
                } else {
                    $('#failed-alert-upload').removeClass('d-none').text(data['message']);
                    // $('#uploadBtn').attr('disabled', true);
                }
            },
            error: function(response) {
                // $('#uploadBtn').attr('disabled', true);
                $('#uploadBtn').html('<i class="fa fa-uload"></i> Upload');
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                } else {
                    alert('Something went wrong. Please try again.');
                }
            },
        });
    }

    function addForm() {
        $('#modalForm').modal('show');
        $('#modalForm .modal-title').html('<i class="fa fa-plus-circle"></i> Add Data');
        $('#modalForm form')[0].reset();
        $('#modalForm #id').val('');
        $('#modalForm #act').val('save');
        var id_kemn = $('#id_kementrian_filter').val();
        var id_prov = $('#id_provinsi_filter').val();
        var id_kota = $('#id_kota_filter').val();
        var id_kec = $('#id_kecamatan_filter').val();
        var id_kel = $('#id_kelurahan_filter').val();

        list_kementrian('id_kementrian', id_kemn != null ? id_kemn : null);
        list_provinsi('id_provinsi', id_prov != null ? id_prov : null);
        list_kota('id_kota', id_prov != null ? id_prov : null, id_kota != null ? id_kota : null);
        list_kecamatan('id_kecamatan', id_kota != null ? id_kota : null, id_kec != null ? id_kec : null);
        list_kelurahan('id_kelurahan', id_kec != null ? id_kec : null, id_kel != null ? id_kel : null);

    };

    function viewDetailKelompok(id) {
        var url = "{{ route('kelompok_daftar.show', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            method: 'GET',
            url: url,
            success: function(data) {
                console.log(data);
                $('#id_kelompok_det').val(id);
                $('#id_provinsi_det').val(data.id_provinsi);
                $('#id_kota_det').val(data.id_kota);
                $('#id_kecamatan_det').val(data.id_kecamatan);
                $('#id_kelurahan_det').val(data.id_kelurahan);
                $('#namaKelompokSpn').text(data.nama_kelompok);
                $('#alamatKelompokSpn').text(data.alamat);
                $('#kotaSpn').text(data.nama_kota);
                $('#kecamatanSpn').text(data.nama_kecamatan);
                $('#kelurahanSpn').text(data.nama_kelurahan);
                $('#namaPenanggungJawabSpn').text(data.penanggung_jawab);
                $('#noHpPenanggungJawabSpn').text(data.no_hp);
                $('#kementrianSpn').text(data.nama_kementrian);
            },
            error: function(response) {
                alert('Something went wrong. Please try again.');
            },
            complete: function() {
                // Re-enable button
                $('#saveBtn').attr('disabled', false);
            }
        });
    }

    function editData(id) {
        $('#modalForm').modal('show');
        $('#modalForm .modal-title').html('<i class="fa fa-edit"></i> Edit Data');
        $('#modalForm form')[0].reset();
        $('#modalForm #id').val(id);
        $('#modalForm #act').val('edit');
        var url = "{{ route('kelompok_daftar.show', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            method: 'GET',
            url: url,
            success: function(data) {
                console.log(data);
                list_kementrian('id_kementrian', data.id_kementrian);
                list_provinsi('id_provinsi', data.id_provinsi);
                list_kota('id_kota', data.id_provinsi, data.id_kota);
                list_kecamatan('id_kecamatan', data.id_kota, data.id_kecamatan);
                list_kelurahan('id_kelurahan', data.id_kecamatan, data.id_kelurahan);
                $('#nama_kelompok').val(data.nama_kelompok);
                $('#alamat').val(data.alamat);
                $('#penanggung_jawab').val(data.penanggung_jawab);
                $('#no_hp').val(data.no_hp);
            },
            error: function(response) {
                alert('Something went wrong. Please try again.');
            },
            complete: function() {
                // Re-enable button
                $('#saveBtn').attr('disabled', false);
            }
        });
    };

    function deleteData(id) {
        if (confirm("Apakah anda yakin akan menghapus data ini?")) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = "{{ route('kelompok_daftar.destroy', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'delete',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                url: url,
                success: function(data) {
                    table.ajax.reload(null, false);
                },
                error: function(response) {
                    alert('Something went wrong. Please try again.');

                }
            });
        }
    };

    function showData() {
        id_kementrian = $('#id_kementrian_filter').val();
        id_provinsi = $('#id_provinsi_filter').val();
        id_kota = $('#id_kota_filter').val();
        id_kecamatan = $('#id_kecamatan_filter').val();
        id_kelurahan = $('#id_kelurahan_filter').val();
        ajaxList(id_provinsi, id_kementrian, id_kota, id_kecamatan, id_kelurahan);
    }

    function ajaxList(id_provinsi, id_kementrian = null, id_kota = null, id_kecamatan = null, id_kelurahan = null) {
        table.destroy();
        table = $('#tableKelompok').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            scrollY: '400px',
            scrollCollapse: true,
            ajax: {
                url: "{{ url('kelompok_daftar') }}",
                data: function(d) {
                    d.id_kementrian = id_kementrian;
                    d.id_provinsi = id_provinsi;
                    d.id_kota = id_kota;
                    d.id_kecamatan = id_kecamatan;
                    d.id_kelurahan = id_kelurahan;
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action_button',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_kementrian'
                },
                {
                    data: 'nama_kelompok'
                },
                {
                    data: 'alamat_lengkap_kelompok'
                },
                {
                    data: 'penanggung_jawab'
                },
                {
                    data: 'no_hp'
                },
                {
                    data: 'total_anggota'
                },
                // {
                // data: 'nama_kecamatan'
                // },
                // {
                // data: 'nama_kota'
                // },
                // {
                // data: 'nama_provinsi'
                // },
                {
                    data: 'crt_user_name'
                },
                {
                    data: 'created_at'
                },

            ]
        });

        $('#filter').click(function() {
            table.draw();
        });

        $('#reset').click(function() {
            $('#filter_name').val('');
            // $('#filter_status').val('');
            $('#start_date').val('');
            $('#end_date').val('');
            table.draw();
        });
    }

    function uploadForm() {
        $('#modalFormUpload').modal('show');
        $('#modalFormUpload .modal-title').html('<i class="fa fa-plus-circle"></i> Upload Data');
        $('#modalFormUpload form')[0].reset();
        $('#modalFormUpload #id').val('');
        $('#modalFormUpload #act').val('save');
        $('#modalFormUpload #failed-alert-upload').addClass('d-none');
        $('#modalFormUpload #success-alert-upload').addClass('d-none');
        $('#modalFormUpload #previewSec').html('');
    };

    function viewAnggota(id, nama) {
        $('#spaceFrontTable').addClass('d-none');
        $('#spaceForDetail').removeClass('d-none');
        // $('#modalFormAnggota').modal('show');
        // $('#modalFormAnggota .modal-title').html('<i class="fa fa-list"></i> Detail Kelompok ' + nama);
        viewDetailKelompok(id);
        ajaxListProposal(id);
        tableAnggota.destroy();
        tableAnggota = $('#tableAnggota').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            scrollY: '400px',
            scrollCollapse: true,
            ajax: {
                url: "{{ url('kelompok_anggota') }}",
                data: function(d) {
                    d.id_kelompok = id;
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nik'
                },
                {
                    data: 'nama_anggota'
                },
                {
                    data: 'nama_jabatan'
                },
                {
                    data: 'no_hp'
                },
                {
                    data: 'nama_tps'
                },
                {
                    data: 'tingkat_dukungan'
                },
                {
                    data: 'alamat_lengkap_anggota'
                },
                // {
                // data: 'nama_kecamatan'
                // },
                // {
                // data: 'nama_kota'
                // },
                // {
                // data: 'nama_provinsi'
                // },
                {
                    data: 'crt_user_name'
                },
                {
                    data: 'created_at'
                },

            ]
        });

        $('#filter').click(function() {
            tableAnggota.draw();
        });
    };

    function viewTableAnggota() {
        // console.log('Detail.....');
        tableAnggota.ajax.reload(null, false);
    }

    function viewTableProposal() {
        // console.log('Detail.....');
        tableProposal.ajax.reload(null, false);
    }

    function ajaxListProposal(id_kelompok) {
        tableProposal.destroy();
        tableProposal = $('#tableProposal').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            scrollY: '400px',
            scrollCollapse: true,
            ajax: {
                url: "{{ url('proposal') }}",
                data: function(d) {
                    d.id_kelompok = id_kelompok;
                    d.sumber = 'kelompok';
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action_button',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'proposal_button',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tahun'
                },
                {
                    data: 'nama_kementrian'
                },
                {
                    data: 'jenis_bantuan'
                },
                {
                    data: 'jumlah_bantuan'
                },
                {
                    data: 'cpcl_column'
                },
                {
                    data: 'verifikasi_column'
                },
                {
                    data: 'kontrak_column'
                },
                {
                    data: 'pengiriman_column'
                },
                {
                    data: 'distribusi_column'
                },
                {
                    data: 'crt_user_name'
                },
                {
                    data: 'created_at'
                },

            ],
            // rowsGroup: [1]
        });

        $('#filter').click(function() {
            tableProposal.draw();
        });

        $('#reset').click(function() {
            $('#filter_name').val('');
            // $('#filter_status').val('');
            $('#start_date').val('');
            $('#end_date').val('');
            tableProposal.draw();
        });
    }

    function addAnggota() {
        $('#modalFormAddAnggota').modal('show');
        $('#modalFormAddAnggota .modal-title').html('<i class="fa fa-plus-circle"></i> Add Data');
        $('#modalFormAddAnggota form')[0].reset();
        $('#modalFormAddAnggota #id').val('');
        $('#modalFormAddAnggota #act').val('save');
        var id_kelmpk = $('#id_kelompok_det').val();
        var id_prov = $('#id_provinsi_det').val();
        var id_kota = $('#id_kota_det').val();
        var id_kec = $('#id_kecamatan_det').val();
        var id_kel = $('#id_kelurahan_det').val();
        $('#id_kelompok_anggota').val(id_kelmpk);
        list_provinsi('id_provinsi_anggota', id_prov != null ? id_prov : null);
        list_kota('id_kota_anggota', id_prov != null ? id_prov : null, id_kota != null ? id_kota : null);
        list_kecamatan('id_kecamatan_anggota', id_kota != null ? id_kota : null, id_kec != null ? id_kec : null);
        list_kelurahan('id_kelurahan_anggota', id_kec != null ? id_kec : null, id_kel != null ? id_kel : null);
        list_kelompok('id_kelompok_anggota', id_kel != null ? id_kel : null, id_kelmpk != null ? id_kelmpk : null);
        list_jabatan('id_jabatan_anggota');
        list_tps('id_tps_anggota');
    };

    function cariProgram() {
        var tahun = $('#tahun_proposal').val();
        if (tahun == '') {
            alert('Silahkan pilih tahun terlebih dahulu.');
        } else {
            $('#modalFormProgram').modal('show');
            $('#modalFormProgram .modal-title').html('<i class="fa fa-search"></i> Cari Data Program Bantuan Tahun '.$tahun);
        }
    }

    function ajaxListProgram(tahun, program_kementrian = null, id_kementrian = null) {
        tableProgram.destroy();
        tableProgram = $('#tableProgram').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            scrollY: '400px',
            scrollCollapse: true,
            ajax: {
                url: "{{ url('alokasi_program') }}",
                data: function(d) {
                    d.tahun = tahun;
                    d.program_kementrian = program_kementrian;
                    d.id_kementrian = id_kementrian;
                    d.action = 'search';
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action_button',
                    orderable: false,
                    searchable: false
                },
                {
                    name: 'col_kementrian',
                    data: 'nama_kementrian'
                },
                {
                    data: 'nama_dirjen'
                },
                {
                    data: 'nama_program'
                },
                {
                    data: 'pic'
                },
                {
                    data: 'contact_person'
                },
                {
                    data: 'kuota'
                },
                {
                    data: 'crt_user_name'
                },
                {
                    data: 'created_at'
                },

            ],
            rowsGroup: [1]
        });

        $('#filter').click(function() {
            table.draw();
        });

        $('#reset').click(function() {
            $('#filter_name').val('');
            // $('#filter_status').val('');
            $('#start_date').val('');
            $('#end_date').val('');
            table.draw();
        });
    }

    function selectDataProgram(id, jenis_bantuan) {
        $('#modalFormProgram').modal('hide');
        $('#id_program_alokasi_proposal').val(id);
        $('#jenis_bantuan_proposal').val(jenis_bantuan);
        $('#jenis_bantuan_span').text(jenis_bantuan);
    }

    function addProposal() {
        $('#modalFormProposal').modal('show');
        $('#modalFormProposal .modal-title').html('<i class="fa fa-plus-circle"></i> Add Data');
        $('#modalFormProposal form')[0].reset();
        $('#modalFormProposal #id').val('');
        $('#modalFormProposal #nama_kelompok_span').text('');
        $('#modalFormProposal #jenis_bantuan_span').text('');
        $('#modalFormProposal #actProposal').val('save');
        var id_kelompok = $('#id_kelompok_det').val();
        var nama_kelompok = $('#namaKelompokSpn').text();
        var alamat_kelompok = $('#alamatKelompokSpn').text();
        // var tahun = $('#tahun_filter').val();
        const currentYear = new Date().getFullYear();
        $('#tahun_proposal').val(currentYear);
        $('#id_kelompok_proposal').val(id_kelompok);
        $('#nama_kelompok_span').text(nama_kelompok);
        $('#nama_kelompok_proposal').val(nama_kelompok);
        $('#alamat_kelompok_proposal').val(alamat_kelompok);
        list_pic('id_pic_penyuluh_proposal');
        list_pic('id_pic_penanggung_jawab_proposal');
        $('#txtSmall').addClass('d-none');
    };

    function detailPIC(obj_id, obj_name, obj_cp) {
        var id = $('#' + obj_id).val();
        var url = "{{ route('pic.show', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            method: 'GET',
            url: url,
            success: function(data) {
                console.log(data);
                $('#' + obj_name).val(data.nama_pic);
                $('#' + obj_cp).val(data.contact_person);
            },
            error: function(response) {
                alert('Something went wrong. Please try again.');
            }
        });
    }

    function backToFront() {
        $('#spaceForDetail').addClass('d-none');
        $('#spaceFrontTable').removeClass('d-none');
        table.ajax.reload(null, false);
    }

    function editDataProposal(id) {
        $('#modalFormProposal').modal('show');
        $('#modalFormProposal .modal-title').html('<i class="fa fa-edit"></i> Edit Proposal');
        $('#modalFormProposal form')[0].reset();
        $('#modalFormProposal #id_proposal').val(id);
        $('#modalFormProposal #actProposal').val('edit');
        var url = "{{ route('proposal.show', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            method: 'GET',
            url: url,
            success: function(data) {
                console.log(data);
                $('#tahun_proposal').val(data.tahun);
                $('#status_proposal').val(data.status_proposal);
                if (data.status_proposal == 'N') {
                    $('#file_proposal').attr('disabled', true);
                } else {
                    $('#file_proposal').attr('disabled', false);
                }
                $('#file_proposal').attr('required', false);
                $('#txtSmall').removeClass('d-none');
                // $('#file').val(data.file);
                $('#nama_kelompok_span').text(data.nama_kelompok);
                $('#nama_kelompok_proposal').val(data.nama_kelompok);
                $('#alamat_kelompok_proposal').val(data.alamat_kelompok);
                $('#id_kelompok_proposal').val(data.id_kelompok);
                $('#jenis_bantuan_span').text(data.jenis_bantuan);
                $('#jenis_bantuan_proposal').val(data.jenis_bantuan);
                $('#jumlah_bantuan_proposal').val(data.jumlah_bantuan);
                $('#id_program_alokasi_proposal').val(data.id_program_alokasi);
                list_pic('id_pic_penyuluh_proposal', data.id_pic_penyuluh);
                $('#nama_penyuluh_proposal').val(data.nama_penyuluh);
                $('#contact_person_penyuluh_proposal').val(data.contact_person_penyuluh);
                list_pic('id_pic_penanggung_jawab_proposal', data.id_pic_penanggung_jawab);
                $('#nama_penanggung_jawab_proposal').val(data.nama_penanggung_jawab);
                $('#contact_person_penanggung_jawab_proposal').val(data.contact_person_penanggung_jawab);
                $('#pic_proposal').val(data.pic);
                $('#contact_person_proposal').val(data.contact_person);
                $('#kuota_proposal').val(data.kuota);
                $('#satuan_proposal').val(data.satuan);
            },
            error: function(response) {
                alert('Something went wrong. Please try again.');
            },
            complete: function() {
                // Re-enable button
                $('#saveBtn').attr('disabled', false);
            }
        });
    };

    function viewDataProposal(id) {
        $('#modalFormDetailProposal').modal('show');
        var url = "{{ route('proposal.show', ':id') }}";
        url = url.replace(':id', id);
        var url_download = "{{ route('proposal.download_excel', ':id') }}";
        url_download = url_download.replace(':id', id);
        $.ajax({
            method: 'GET',
            url: url,
            beforeSend: function() {
                $('#modalFormDetailProposal .modal-title').html('Loading...');
                $('#modalFormDetailProposal #nama_kelompok').text('Loading...');
                $('#modalFormDetailProposal #alamat_kelompok').text('Loading...');
                $('#modalFormDetailProposal #jenis_bantuan').text('Loading...');
                $('#modalFormDetailProposal #jumlah_bantuan').text('Loading...');
                $('#modalFormDetailProposal #nama_penyuluh').text('Loading...');
                $('#modalFormDetailProposal #contact_person_penyuluh').text('Loading...');
                $('#modalFormDetailProposal #nama_penanggung_jawab').text('Loading...');
                $('#modalFormDetailProposal #contact_person_penanggung_jawab').text('Loading...');
            },
            success: function(data) {
                console.log(data);
                $('#modalFormDetailProposal .modal-title').html('<span style="text-transform:uppercase;">' + data.jenis_bantuan + '</span>');
                $('#modalFormDetailProposal #nama_kelompok').text(data.nama_kelompok);
                $('#modalFormDetailProposal #alamat_kelompok').text(data.alamat_kelompok);
                $('#modalFormDetailProposal #jenis_bantuan').text(data.jenis_bantuan);
                $('#modalFormDetailProposal #jumlah_bantuan').text(data.jumlah_bantuan);
                $('#modalFormDetailProposal #nama_penyuluh').text(data.nama_penyuluh);
                $('#modalFormDetailProposal #contact_person_penyuluh').text(data.contact_person_penyuluh);
                $('#modalFormDetailProposal #nama_penanggung_jawab').text(data.nama_penanggung_jawab);
                $('#modalFormDetailProposal #contact_person_penanggung_jawab').text(data.contact_person_penanggung_jawab);
                $('#modalFormDetailProposal #btnDownloadDetail').attr('href', url_download);
                ajaxListAnggota(data.id_kelompok);
            },
            error: function(response) {
                $('#modalFormDetailProposal .modal-title').html('Error!');
                $('#modalFormDetailProposal #nama_kelompok').text('Error!');
                $('#modalFormDetailProposal #alamat_kelompok').text('Error!');
                $('#modalFormDetailProposal #jenis_bantuan').text('Error!');
                $('#modalFormDetailProposal #jumlah_bantuan').text('Error!');
                $('#modalFormDetailProposal #nama_penyuluh').text('Error!');
                $('#modalFormDetailProposal #contact_person_penyuluh').text('Error!');
                $('#modalFormDetailProposal #nama_penanggung_jawab').text('Error!');
                $('#modalFormDetailProposal #contact_person_penanggung_jawab').text('Error!');
            },
        });
    };

    function ajaxListAnggota(id_kelompok) {
        tableListAnggota.destroy();
        tableListAnggota = $('#tableListAnggota').DataTable({
            searching: false,
            lengthChange: false,
            processing: true,
            serverSide: true,
            scrollX: true,
            scrollY: '400px',
            scrollCollapse: true,
            ajax: {
                url: "{{ url('kelompok_anggota') }}",
                data: function(d) {
                    d.id_kelompok = id_kelompok;
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_anggota'
                },
                {
                    data: 'nik'
                },
                {
                    data: 'nama_jabatan'
                },
                {
                    data: 'no_hp'
                },
                {
                    data: 'alamat_lengkap_anggota'
                },
            ]
        });
    }

    function deleteDataProposal(id) {
        if (confirm("Apakah anda yakin akan menghapus proposal ini?")) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = "{{ route('proposal.destroy', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'delete',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                url: url,
                success: function(data) {
                    $('#success-alert').removeClass('d-none').text("Proposal telah berhasil dihapus.");
                    tableProposal.ajax.reload(null, false);
                },
                error: function(response) {
                    alert('Something went wrong. Please try again.');

                }
            });
        }
    };

    function updateStatus(code, id, status = null) {
        $('#modalFormUpdate').modal('show');
        $('#modalFormUpdate .modal-title').html('<i class="fa fa-plus-circle"></i> Update Status');
        $('#modalFormUpdate form')[0].reset();
        $('#modalFormUpdate #code').val(code);
        $('#modalFormUpdate #id_status').val(id);
        $('#status').empty();
        if (code == 'cpcl') {
            $('#status').append('<option value="BELUM LENGKAP">BELUM LENGKAP</option>');
            $('#status').append('<option value="SUDAH LENGKAP">SUDAH LENGKAP</option>');
        } else {
            $('#status').append('<option value="BELUM">BELUM</option>');
            $('#status').append('<option value="ON PROCESS">ON PROCESS</option>');
            $('#status').append('<option value="SUDAH">SUDAH</option>');
        }
        $('#status').val(status).change();
    }
</script>
@endsection