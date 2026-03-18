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
                        </ul>
                    </div>
                </div>

                <div class="card-body">
                    <div class="alert alert-success d-none" id="success-alert"></div>
                    <div class="row mb-2">
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
                    <table class="table table-bordered nowrap" id="tableUserLevel">
                        <thead>
                            <tr class="bg-primary">
                                <th scope="col">No</th>
                                <th scope="col" style="width: 20%">Actions</th>
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

<!-- <div class="modal fade" id="modalForm">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"></h4>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="btn btn-success" onclick="tambahAnggota()"
                <table class="table table-bordered table-sm" id="tableAnggota">
                    <thead>
                        <tr class="bg-primary">
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama Lengkap</th>
                            <th>Jabatan</th>
                            <th>No. HP</th>
                            <th>Alamat</th>
                            <th>Created by</th>
                            <th>Created at</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div> -->
@endsection

@section('javascript')
<script type="text/javascript">
    var table = $('#tableUserLevel').DataTable();
    let id_provinsi, id_kota, id_kecamatan;
    $(function() {
        list_provinsi('id_provinsi_filter');
        $('#id_provinsi_filter').on('change', function() {
            id_provinsi = $('#id_provinsi_filter').val();
            list_kota('id_kota_filter', id_provinsi);
            // ajaxList(id_provinsi);
        });
        $('#id_provinsi').on('change', function() {
            var id_provinsi = $('#id_provinsi').val();
            list_kota('id_kota', id_provinsi);
        });
        $('#id_kota_filter').on('change', function() {
            id_kota = $('#id_kota_filter').val();
            list_kecamatan('id_kecamatan_filter', id_kota);
            // ajaxList(id_provinsi, id_kota);
        });
        $('#id_kota').on('change', function() {
            var id_kota = $('#id_kota').val();
            list_kecamatan('id_kecamatan', id_kota);
        });
        $('#id_kecamatan_filter').on('change', function() {
            id_kecamatan = $('#id_kecamatan_filter').val();
            list_kelurahan('id_kelurahan_filter', id_kecamatan);
            // ajaxList(id_provinsi, id_kota, id_kecamatan);
        });
        $('#id_kecamatan').on('change', function() {
            var id_kecamatan = $('#id_kecamatan').val();
            list_kelurahan('id_kelurahan', id_kecamatan);
        });
        $('#id_kelurahan_filter').on('change', function() {
            id_kelurahan = $('#id_kelurahan_filter').val();
            // ajaxList(id_provinsi, id_kota, id_kecamatan, id_kelurahan);
        });

        $('#btnSearch').on('click', function() {
            // var tahun = $('#tahun_filter').val();
            // var program_kementrian = $('#program_kementrian_filter').val();
            // var id_kementrian = $('#id_kementrian_filter').val();
            id_provinsi = $('#id_provinsi_filter').val();
            id_kota = $('#id_kota_filter').val();
            id_kecamatan = $('#id_kecamatan_filter').val();
            id_kelurahan = $('#id_kelurahan_filter').val();
            ajaxList(id_provinsi, id_kota, id_kecamatan, id_kelurahan);
        });
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

    function addForm() {
        $('#modalForm').modal('show');
        $('#modalForm .modal-title').html('<i class="fa fa-plus-circle"></i> Add Data');
        $('#modalForm form')[0].reset();
        $('#modalForm #id').val('');
        $('#modalForm #act').val('save');
        var id_prov = $('#id_provinsi_filter').val();
        var id_kota = $('#id_kota_filter').val();
        var id_kec = $('#id_kecamatan_filter').val();
        var id_kel = $('#id_kelurahan_filter').val();

        list_provinsi('id_provinsi', id_prov != null ? id_prov : null);
        list_kota('id_kota', id_prov != null ? id_prov : null, id_kota != null ? id_kota : null);
        list_kecamatan('id_kecamatan', id_kota != null ? id_kota : null, id_kec != null ? id_kec : null);
        list_kelurahan('id_kelurahan', id_kec != null ? id_kec : null, id_kel != null ? id_kel : null);

    };

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

    function ajaxList(id_provinsi, id_kota = null, id_kecamatan = null, id_kelurahan = null) {
        table.destroy();
        table = $('#tableUserLevel').DataTable({
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
</script>
@endsection