@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" onclick="addForm()"><i
                                        class="fa fa-plus-circle"></i> Add Data</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link bg-success" href="#" onclick="downloadExcel()"><i
                                        class="fa fa-download"></i> Download Excel</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card-body">
                    <div class="alert alert-success d-none" id="success-alert"></div>
                    <div class="row mb-2">
                        <div class="col-lg-1">
                            <label>Tahun</label>
                            <select name="tahun_filter" id="tahun_filter" class="form-control" placeholder="Tahun">
                                <option value="">[Please Select]</option>
                                @for ($i=$tahun_mulai;$i<=$tahun_selesai; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label>Provinsi</label>
                            <select name="id_provinsi_filter" id="id_provinsi_filter" class="form-control" placeholder="Provinsi">
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label>Kota</label>
                            <select name="id_kota_filter" id="id_kota_filter" class="form-control" placeholder="Kota">
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label>Kecamatan</label>
                            <select name="id_kecamatan_filter" id="id_kecamatan_filter" class="form-control" placeholder="Kecamatan">
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label>Kelurahan</label>
                            <select name="id_kelurahan_filter" id="id_kelurahan_filter" class="form-control" placeholder="Kelurahan">
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label>Kelompok</label>
                            <select name="id_kelompok_filter" id="id_kelompok_filter" class="form-control" placeholder="Kelompok Masyarakat">
                            </select>
                        </div>
                        <div class="col-lg-1">
                            <div class="btn btn-app bg-warning mt-2" id="btnSearch"><i class="fa fa-search"></i>Cari</div>
                        </div>
                    </div>
                    <table class="table table-bordered nowrap" id="tableUserLevel">
                        <thead>
                            <tr class="bg-primary">
                                <th scope="col">No</th>
                                <th scope="col" style="width: 20%">Actions</th>
                                <th scope="col" style="width: 20%">Proposal</th>
                                <th scope="col">Tahun</th>
                                <th scope="col">Kementrian</th>
                                <th scope="col">Nama Kelompok Masyarakat</th>
                                <th scope="col">Jenis Bantuan</th>
                                <th scope="col">Jumlah Bantuan</th>
                                <th scope="col">Created by</th>
                                <th scope="col">Created at</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalForm">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"></h4>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <form data-toggle="validator" id="formCRUD" enctype="multipart/form-data">
                @csrf
                <input id="id" name="id" type="hidden">
                <input id="act" name="act" type="hidden">
                <div class="modal-body">
                    <div class="alert alert-warning d-none" id="failed-alert"></div>
                    <div class="row">
                        <div class="col-lg-2 form-group">
                            <label>Tahun *)</label>
                            <select name="tahun" id="tahun" class="form-control" aria-placeholder="Tahun" required>
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
                                <input type="file" class="custom-file-input" id="file" name="file">
                                <label class="custom-file-label" for="file">Choose file</label>
                            </div>
                            <div id="txtSmall"><small class="text-red">Jika file tidak diganti, maka kosongkan saja.</small></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label>Kelompok Masyarakat *)</label>
                                <div class="input-group">
                                    <span name="nama_kelompok_span" id="nama_kelompok_span" class="form-control"></span>
                                    <input type="hidden" name="nama_kelompok" id="nama_kelompok" class="form-control" required readonly>
                                    <input type="hidden" name="alamat_kelompok" id="alamat_kelompok" class="form-control" required readonly>
                                    <input type="hidden" name="id_kelompok" id="id_kelompok" class="form-control" required readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-success" style="cursor: pointer;" onclick="cariKelompok()"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label>Program/Jenis Bantuan *)</label>
                                <div class="input-group">
                                    <span name="jenis_bantuan_span" id="jenis_bantuan_span" class="form-control"></span>
                                    <input type="hidden" name="jenis_bantuan" id="jenis_bantuan" class="form-control" required readonly>
                                    <input type="hidden" name="id_program_alokasi" id="id_program_alokasi" class="form-control" required readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text bg-success" style="cursor: pointer;" onclick="cariProgram()"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 form-group">
                            <label>Jumlah Bantuan *)</label>
                            <input type="number" class="form-control" name="jumlah_bantuan" id="jumlah_bantuan" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>Penyuluh</label>
                            <select id="id_pic_penyuluh" name="id_pic_penyuluh" class="form-control select2" onchange="detailPIC('id_pic_penyuluh','nama_penyuluh','contact_person_penyuluh')">
                            </select>
                            <input autocomplete="off" class="form-control" id="nama_penyuluh" name="nama_penyuluh" type="hidden">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Contact Person Penyuluh</label>
                            <input autocomplete="off" class="form-control" id="contact_person_penyuluh" name="contact_person_penyuluh"
                                placeholder="Contact Person" required type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>Penanggung Jawab</label>
                            <select id="id_pic_penanggung_jawab" name="id_pic_penanggung_jawab" class="form-control select2" onchange="detailPIC('id_pic_penanggung_jawab','nama_penanggung_jawab','contact_person_penanggung_jawab')">
                            </select>
                            <input autocomplete="off" class="form-control" id="nama_penanggung_jawab" name="nama_penanggung_jawab" type="hidden">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Contact Person Penanggung Jawab</label>
                            <input autocomplete="off" class="form-control" id="contact_person_penanggung_jawab" name="contact_person_penanggung_jawab"
                                placeholder="Contact Person" required type="text">
                        </div>
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

<div class="modal fade" id="modalFormKelompok">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"></h4>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-lg-2">
                        <label>Provinsi</label>
                        <select name="id_provinsi_filter_kelompok" id="id_provinsi_filter_kelompok" class="form-control" placeholder="Provinsi">
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label>Kota</label>
                        <select name="id_kota_filter_kelompok" id="id_kota_filter_kelompok" class="form-control" placeholder="Kota">
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label>Kecamatan</label>
                        <select name="id_kecamatan_filter_kelompok" id="id_kecamatan_filter_kelompok" class="form-control" placeholder="Kecamatan">
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label>Kelurahan</label>
                        <select name="id_kelurahan_filter_kelompok" id="id_kelurahan_filter_kelompok" class="form-control" placeholder="Kelurahan">
                        </select>
                    </div>
                    <div class="col-lg-1">
                        <div class="btn btn-app bg-warning mt-2" id="btnFilterKelompok"><i class="fa fa-filter"></i>Filter</div>
                    </div>
                </div>
                <table class="table table-bordered nowrap" id="tableKelompok">
                    <thead>
                        <tr class="bg-primary">
                            <th scope="col">No</th>
                            <th scope="col" style="width: 20%">Actions</th>
                            <th scope="col">Nama Kelompok</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Penanggung Jawab</th>
                            <th scope="col">No. HP</th>
                            <th scope="col">Jml. Angggota</th>
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

<div class="modal fade" id="modalFormDetail">
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
                <table class="table table-bordered table-striped table-sm" id="tableListAnggota">
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
@endsection

@section('javascript')
<script type="text/javascript">
    var table = $('#tableUserLevel').DataTable({
        scrollX: true,
        scrollY: '400px',
        scrollCollapse: true,
    });
    var tableKelompok = $('#tableKelompok').DataTable();
    var tableProgram = $('#tableProgram').DataTable();
    var tableAnggota = $('#tableListAnggota').DataTable();
    let id_provinsi, id_kota, id_kecamatan, id_kelurahan, tahun;
    $(function() {
        list_provinsi('id_provinsi_filter');
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
            list_kelompok('id_kelompok_filter', id_kelurahan);
        });

        $('#btnSearch').on('click', function() {
            tahun = $('#tahun_filter').val();
            id_provinsi = $('#id_provinsi_filter').val();
            id_kota = $('#id_kota_filter').val();
            id_kecamatan = $('#id_kecamatan_filter').val();
            id_kelurahan = $('#id_kelurahan_filter').val();
            id_kelompok = $('#id_kelompok_filter').val();
            if (tahun == '') {
                alert('Silahkan pilih tahun terlebih dahulu. Terima Kasih...');
            } else {
                ajaxList(tahun, id_provinsi, id_kota, id_kecamatan, id_kelurahan, id_kelompok);
            }
        });

        // Start Form
        $('#status_proposal').on('change', function() {
            var status_proposal = $(this).val();
            if (status_proposal == 'Y') {
                $('#file').attr('disabled', false);
                $('#file').attr('required', true);
            } else {
                $('#file').attr('disabled', true);
                $('#file').attr('required', false);
            }
        });
        // End Form

        // Start Kelompok
        $('#id_provinsi_filter_kelompok').on('change', function() {
            var id_provinsi2 = $('#id_provinsi_filter_kelompok').val();
            list_kota('id_kota_filter_kelompok', id_provinsi2);
        });
        $('#id_kota_filter_kelompok').on('change', function() {
            var id_kota2 = $('#id_kota_filter_kelompok').val();
            list_kecamatan('id_kecamatan_filter_kelompok', id_kota2);
        });
        $('#id_kecamatan_filter_kelompok').on('change', function() {
            var id_kecamatan2 = $('#id_kecamatan_filter_kelompok').val();
            list_kelurahan('id_kelurahan_filter_kelompok', id_kecamatan2);
        });

        $('#btnFilterKelompok').on('click', function() {
            var id_provinsi2 = $('#id_provinsi_filter_kelompok').val();
            var id_kota2 = $('#id_kota_filter_kelompok').val();
            var id_kecamatan2 = $('#id_kecamatan_filter_kelompok').val();
            var id_kelurahan2 = $('#id_kelurahan_filter_kelompok').val();
            if (id_provinsi2 == '') {
                alert('Silahkan pilih provinsi terlebih dahulu. Terima Kasih...');
            } else {
                ajaxListKelompok(id_provinsi2, id_kota2, id_kecamatan2, id_kelurahan2);
            }
        });
        // End Kelompok

        // Start Program
        $('#program_kementrian_filter_program').on('change', function() {
            var program_kementrian = $(this).val();
            if (program_kementrian == 'Y') {
                $('#id_kementrian_filter_program').attr('disabled', false);
                list_kementrian('id_kementrian_filter_program');
            } else {
                $('#id_kementrian_filter_program').val('');
                $('#id_kementrian_filter_program').attr('disabled', true);
            }
        });
        $('#btnFilterProgram').on('click', function() {
            var tahun = $('#tahun').val();
            var program_kementrian = $('#program_kementrian_filter_program').val();
            var id_kementrian = $('#id_kementrian_filter_program').val();
            ajaxListProgram(tahun, program_kementrian, id_kementrian);
        });
        // End Program


    });

    $('#formCRUD').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        var act = $('#act').val();
        var url;
        url = "/proposal";
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
            enctype: "multipart/form-data",
            success: function(data) {
                if (data['status']) {
                    $('#modalForm').modal('hide');
                    $('#success-alert').removeClass('d-none').text("Data telah berhasil disimpan.");
                    table.ajax.reload(null, false);
                } else {
                    $('#failed-alert').removeClass('d-none').text(data['message']);
                }
                $('#saveBtn').attr('disabled', false);
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
                $('#saveBtn').attr('disabled', false);
            },
            complete: function() {
                // Re-enable button
                $('#saveBtn').attr('disabled', false);
            }
        });
    });

    function addForm() {
        $('#modalForm').modal('show');
        $('#modalForm .modal-title').html('<i class="fa fa-plus-circle"></i> Add Data');
        $('#modalForm form')[0].reset();
        $('#modalForm #id').val('');
        $('#modalForm #nama_kelompok_span').text('');
        $('#modalForm #jenis_bantuan_span').text('');
        $('#modalForm #act').val('save');
        var tahun = $('#tahun_filter').val();
        $('#tahun').val(tahun);
        list_pic('id_pic_penyuluh');
        list_pic('id_pic_penanggung_jawab');
        $('#txtSmall').addClass('d-none');
    };

    function editData(id) {
        $('#modalForm').modal('show');
        $('#modalForm .modal-title').html('<i class="fa fa-edit"></i> Edit Data');
        $('#modalForm form')[0].reset();
        $('#modalForm #id').val(id);
        $('#modalForm #act').val('edit');
        var url = "{{ route('proposal.show', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            method: 'GET',
            url: url,
            success: function(data) {
                console.log(data);
                $('#tahun').val(data.tahun);
                $('#status_proposal').val(data.status_proposal);
                if (data.status_proposal == 'N') {
                    $('#file').attr('disabled', true);
                } else {
                    $('#file').attr('disabled', false);
                }
                $('#file').attr('required', false);
                $('#txtSmall').removeClass('d-none');
                // $('#file').val(data.file);
                $('#nama_kelompok_span').text(data.nama_kelompok);
                $('#nama_kelompok').val(data.nama_kelompok);
                $('#alamat_kelompok').val(data.alamat_kelompok);
                $('#id_kelompok').val(data.id_kelompok);
                $('#jenis_bantuan_span').text(data.jenis_bantuan);
                $('#jenis_bantuan').val(data.jenis_bantuan);
                $('#jumlah_bantuan').val(data.jumlah_bantuan);
                $('#id_program_alokasi').val(data.id_program_alokasi);
                list_pic('id_pic_penyuluh', data.id_pic_penyuluh);
                $('#nama_penyuluh').val(data.nama_penyuluh);
                $('#contact_person_penyuluh').val(data.contact_person_penyuluh);
                list_pic('id_pic_penanggung_jawab', data.id_pic_penanggung_jawab);
                $('#nama_penanggung_jawab').val(data.nama_penanggung_jawab);
                $('#contact_person_penanggung_jawab').val(data.contact_person_penanggung_jawab);
                $('#tahun').val(data.tahun);
                $('#pic').val(data.pic);
                $('#contact_person').val(data.contact_person);
                $('#kuota').val(data.kuota);
                $('#satuan').val(data.satuan);
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

    function viewData(id) {
        $('#modalFormDetail').modal('show');
        var url = "{{ route('proposal.show', ':id') }}";
        url = url.replace(':id', id);
        var url_download = "{{ route('proposal.download_excel', ':id') }}";
        url_download = url_download.replace(':id', id);
        $.ajax({
            method: 'GET',
            url: url,
            beforeSend: function() {
                $('#modalFormDetail .modal-title').html('Loading...');
                $('#modalFormDetail #nama_kelompok').text('Loading...');
                $('#modalFormDetail #alamat_kelompok').text('Loading...');
                $('#modalFormDetail #jenis_bantuan').text('Loading...');
                $('#modalFormDetail #jumlah_bantuan').text('Loading...');
                $('#modalFormDetail #nama_penyuluh').text('Loading...');
                $('#modalFormDetail #contact_person_penyuluh').text('Loading...');
                $('#modalFormDetail #nama_penanggung_jawab').text('Loading...');
                $('#modalFormDetail #contact_person_penanggung_jawab').text('Loading...');
            },
            success: function(data) {
                console.log(data);
                $('#modalFormDetail .modal-title').html('<span style="text-transform:uppercase;">' + data.jenis_bantuan + '</span>');
                $('#modalFormDetail #nama_kelompok').text(data.nama_kelompok);
                $('#modalFormDetail #alamat_kelompok').text(data.alamat_kelompok);
                $('#modalFormDetail #jenis_bantuan').text(data.jenis_bantuan);
                $('#modalFormDetail #jumlah_bantuan').text(data.jumlah_bantuan);
                $('#modalFormDetail #nama_penyuluh').text(data.nama_penyuluh);
                $('#modalFormDetail #contact_person_penyuluh').text(data.contact_person_penyuluh);
                $('#modalFormDetail #nama_penanggung_jawab').text(data.nama_penanggung_jawab);
                $('#modalFormDetail #contact_person_penanggung_jawab').text(data.contact_person_penanggung_jawab);
                $('#modalFormDetail #btnDownloadDetail').attr('href', url_download);
                ajaxListAnggota(data.id_kelompok);
            },
            error: function(response) {
                $('#modalFormDetail .modal-title').html('Error!');
                $('#modalFormDetail #nama_kelompok').text('Error!');
                $('#modalFormDetail #alamat_kelompok').text('Error!');
                $('#modalFormDetail #jenis_bantuan').text('Error!');
                $('#modalFormDetail #jumlah_bantuan').text('Error!');
                $('#modalFormDetail #nama_penyuluh').text('Error!');
                $('#modalFormDetail #contact_person_penyuluh').text('Error!');
                $('#modalFormDetail #nama_penanggung_jawab').text('Error!');
                $('#modalFormDetail #contact_person_penanggung_jawab').text('Error!');
            },
        });
    };

    function ajaxListAnggota(id_kelompok) {
        tableAnggota.destroy();
        tableAnggota = $('#tableListAnggota').DataTable({
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

    function deleteData(id) {
        if (confirm("Apakah anda yakin akan menghapus data ini?")) {
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
                    table.ajax.reload(null, false);
                },
                error: function(response) {
                    alert('Something went wrong. Please try again.');

                }
            });
        }
    };

    function ajaxList(tahun, id_provinsi = null, id_kota = null, id_kecamatan = null, id_kelurahan = null, id_kelompok = null) {
        table.destroy();
        table = $('#tableUserLevel').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            scrollY: '400px',
            scrollCollapse: true,
            ajax: {
                url: "{{ url('proposal') }}",
                data: function(d) {
                    d.tahun = tahun;
                    d.id_provinsi = id_provinsi;
                    d.id_kota = id_kota;
                    d.id_kecamatan = id_kecamatan;
                    d.id_kelurahan = id_kelurahan;
                    d.id_kelompok = id_kelompok;
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
                    data: 'nama_kelompok'
                },
                {
                    data: 'jenis_bantuan'
                },
                {
                    data: 'jumlah_bantuan'
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

    function cariKelompok() {
        $('#modalFormKelompok').modal('show');
        $('#modalFormKelompok .modal-title').html('<i class="fa fa-search"></i> Cari Data Kelompok Masyarakat');
        list_provinsi('id_provinsi_filter_kelompok');
    }

    function ajaxListKelompok(id_provinsi, id_kota = null, id_kecamatan = null, id_kelurahan = null) {
        tableKelompok.destroy();
        tableKelompok = $('#tableKelompok').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            scrollY: '400px',
            scrollCollapse: true,
            ajax: {
                url: "{{ url('kelompok_daftar') }}",
                data: function(d) {
                    d.id_provinsi = id_provinsi;
                    d.id_kota = id_kota;
                    d.id_kecamatan = id_kecamatan;
                    d.id_kelurahan = id_kelurahan;
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

    function selectDataKelompok(id, nama_kelompok) {
        $('#modalFormKelompok').modal('hide');
        $('#id_kelompok').val(id);
        $('#nama_kelompok').val(nama_kelompok);
        $('#nama_kelompok_span').text(nama_kelompok);
    }

    function cariProgram() {
        var tahun = $('#tahun').val();
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
        $('#id_program_alokasi').val(id);
        $('#jenis_bantuan').val(jenis_bantuan);
        $('#jenis_bantuan_span').text(jenis_bantuan);
    }

    function downloadExcelDetail(id) {

    }
</script>
@endsection