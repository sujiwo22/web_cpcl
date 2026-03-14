@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Anggota Kelompok Masyarakat') }}</h3>
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
                                <th scope="col">NIK</th>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">Jabatan</th>
                                <th scope="col">No. HP</th>
                                <th scope="col">Alamat</th>
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
                    <div class="form-group">
                        <label>Nama Kelompok *)</label>
                        <input type="hidden" name="id_kelompok" id="id_kelompok">
                        <span class="form-control" id="nama_kelompok" name="nama_kelompok"></span>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>NIK *)</label>
                            <input autocomplete="off" class="form-control" id="nik" name="nik"
                                placeholder="NIK" required type="text">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Nama Lengkap *)</label>
                            <input autocomplete="off" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                placeholder="Nama Lengkap" type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>No. HP *)</label>
                            <input autocomplete="off" class="form-control" id="no_hp" name="no_hp"
                                placeholder="No. HP (Contact Person)" type="text">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Jabatan/Status dalam Kelompok *)</label>
                            <select class="form-control" id="id_jabatan" name="id_jabatan"
                                placeholder="No. HP">
                            </select>
                        </div>
                    </div>
                    <label>Alamat</label>
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3" placeholder="Alamat Lengkap" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Provinsi *)</label>
                                <select name="id_provinsi" id="id_provinsi" class="form-control" aria-placeholder="Provinsi" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Kota *)</label>
                                <select name="id_kota" id="id_kota" class="form-control" aria-placeholder="Kota" required>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Kecamatan *)</label>
                                <select name="id_kecamatan" id="id_kecamatan" class="form-control" aria-placeholder="Kecamatan" required>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Kelurahan *)</label>
                                <select name="id_kelurahan" id="id_kelurahan" class="form-control" aria-placeholder="Kelurahan" required>
                                </select>
                            </div>
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
    let nama_kelompok;
    let id_provinsi, id_kota, id_kecamatan, id_kelurahan, id_kelompok;
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
            list_kelompok('id_kelompok_filter', id_kelurahan);
        });

        $('#btnSearch').on('click', function() {
            id_provinsi = $('#id_provinsi_filter').val();
            id_kota = $('#id_kota_filter').val();
            id_kecamatan = $('#id_kecamatan_filter').val();
            id_kelurahan = $('#id_kelurahan_filter').val();
            id_kelompok = $('#id_kelompok_filter').val();
            if (id_provinsi == '' || id_kota == '' || id_kecamatan == '' || id_kelurahan == '' || id_kelompok == '') {
                alert('Silahkan pilih kelompok masyarakat terlebih dahulu. Terima Kasih...');
            } else {
                ajaxList(id_provinsi, id_kota, id_kecamatan, id_kelurahan, id_kelompok);
            }
        });
    });

    $('#formCRUD').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        var act = $('#act').val();
        var url;
        url = "/kelompok_anggota";
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
        var id_prov = $('#id_provinsi_filter').val();
        var id_kota = $('#id_kota_filter').val();
        var id_kec = $('#id_kecamatan_filter').val();
        var id_kel = $('#id_kelurahan_filter').val();
        var id_kelmpk = $('#id_kelompok_filter').val();

        if (id_prov == '' || id_kota == '' || id_kec == '' || id_kel == '' || id_kelmpk == '') {
            alert('Silahkan pilih kelompok masyarakat terlebih dahulu. Terima Kasih...');
        } else {
            $('#modalForm').modal('show');
            $('#modalForm .modal-title').html('<i class="fa fa-plus-circle"></i> Add Data');
            $('#modalForm form')[0].reset();
            $('#modalForm #id').val('');
            $('#modalForm #act').val('save');
            $('#id_kelompok').val(id_kelmpk);
            cekNamaKelompok(id_kelmpk);
            list_provinsi('id_provinsi', id_prov != null ? id_prov : null);
            list_kota('id_kota', id_prov != null ? id_prov : null, id_kota != null ? id_kota : null);
            list_kecamatan('id_kecamatan', id_kota != null ? id_kota : null, id_kec != null ? id_kec : null);
            list_kelurahan('id_kelurahan', id_kec != null ? id_kec : null, id_kel != null ? id_kel : null);
            list_kelompok('id_kelompok', id_kel != null ? id_kel : null, id_kelmpk != null ? id_kelmpk : null);
            list_jabatan('id_jabatan');
        }
    };

    function cekNamaKelompok(id_kelompok) {
        var url = "{{ route('kelompok_daftar.show', ':id') }}";
        url = url.replace(':id', id_kelompok);
        $.ajax({
            method: 'GET',
            url: url,
            success: function(data) {
                nama_kelompok = data.nama_kelompok;
                $('#nama_kelompok').text(nama_kelompok);

            },
            error: function(response) {
                nama_kelompok = 'Unidentified';
            }
        });
    }

    function editData(id) {
        $('#modalForm').modal('show');
        $('#modalForm .modal-title').html('<i class="fa fa-edit"></i> Edit Data');
        $('#modalForm form')[0].reset();
        $('#modalForm #id').val(id);
        $('#modalForm #act').val('edit');
        var url = "{{ route('kelompok_anggota.show', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            method: 'GET',
            url: url,
            success: function(data) {
                console.log(data);
                // $('#id').val(data.id);
                $('#nama_kelompok').text(data.nama_kelompok);
                $('#id_kelompok').val(data.id_kelompok);
                list_provinsi('id_provinsi', data.id_provinsi);
                list_kota('id_kota', data.id_provinsi, data.id_kota);
                list_kecamatan('id_kecamatan', data.id_kota, data.id_kecamatan);
                list_kelurahan('id_kelurahan', data.id_kecamatan, data.id_kelurahan);
                list_jabatan('id_jabatan',data.id_jabatan);
                $('#nama_lengkap').val(data.nama_anggota);
                $('#alamat').val(data.alamat);
                $('#nik').val(data.nik);
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
            var url = "{{ route('kelompok_anggota.destroy', ':id') }}";
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

    function ajaxList(id_provinsi, id_kota, id_kecamatan, id_kelurahan, id_kelompok) {
        table.destroy();
        table = $('#tableUserLevel').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            scrollY: '400px',
            scrollCollapse: true,
            ajax: {
                url: "{{ url('kelompok_anggota') }}",
                data: function(d) {
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