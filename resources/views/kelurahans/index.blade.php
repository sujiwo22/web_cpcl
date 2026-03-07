@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Kelurahan') }}</h3>
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
                    <div class="row">
                        <div class="col-lg-3">
                            <label>Provinsi</label>
                            <select name="id_provinsi_filter" id="id_provinsi_filter" class="form-control" placeholder="Provinsi">
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label>Kota</label>
                            <select name="id_kota_filter" id="id_kota_filter" class="form-control" placeholder="Kota">
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label>Kecamatan</label>
                            <select name="id_kecamatan_filter" id="id_kecamatan_filter" class="form-control" placeholder="Kecamatan">
                            </select>
                        </div>
                    </div>
                    <table class="table table-bordered nowrap" id="tableUserLevel">
                        <thead>
                            <tr class="bg-primary">
                                <th scope="col">No</th>
                                <th scope="col">Provinsi</th>
                                <th scope="col">Kota</th>
                                <th scope="col">Kecamatan</th>
                                <th scope="col">ID Kelurahan</th>
                                <th scope="col">Nama Kelurahan</th>
                                <th scope="col">Created by</th>
                                <th scope="col">Created at</th>
                                <th scope="col" style="width: 20%">Actions</th>
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
                        <label>Provinsi *)</label>
                        <select name="id_provinsi" id="id_provinsi" class="form-control" aria-placeholder="Provinsi" required>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kota *)</label>
                        <select name="id_kota" id="id_kota" class="form-control" aria-placeholder="Kota" required>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kecamatan *)</label>
                        <select name="id_kecamatan" id="id_kecamatan" class="form-control" aria-placeholder="Kecamatan" required>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>ID Kelurahan *)</label>
                        <input autocomplete="off" class="form-control" id="id_kelurahan" name="id_kelurahan"
                            placeholder="ID Kelurahan" required type="text">
                    </div>
                    <div class="form-group">
                        <label>Nama Kelurahan *)</label>
                        <input autocomplete="off" class="form-control" id="nama_kelurahan" name="nama_kelurahan"
                            placeholder="Nama Kelurahan" required type="text">
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
@endsection

@section('javascript')
<script type="text/javascript">
    var table = $('#tableUserLevel').DataTable();
    let id_provinsi,id_kota,id_kecamatan;
    $(function() {
        list_provinsi('id_provinsi_filter');
        $('#id_provinsi_filter').on('change', function() {
            id_provinsi = $('#id_provinsi_filter').val();
            list_kota('id_kota_filter', id_provinsi);
            ajaxList(id_provinsi);
        });
        $('#id_provinsi').on('change', function() {
            var id_provinsi = $('#id_provinsi').val();
            list_kota('id_kota', id_provinsi);
        });
        $('#id_kota_filter').on('change', function() {
            id_kota = $('#id_kota_filter').val();
            list_kecamatan('id_kecamatan_filter', id_kota);
            ajaxList(id_provinsi, id_kota);
        });
        $('#id_kota').on('change', function() {
            var id_kota = $('#id_kota').val();
            list_kecamatan('id_kecamatan', id_kota);
        });
        $('#id_kecamatan_filter').on('change', function() {
            id_kecamatan = $('#id_kecamatan_filter').val();
            // list_kecamatan('id_kecamatan_filter',id_kota);
            ajaxList(id_provinsi, id_kota, id_kecamatan);
        });
    });

    $('#formCRUD').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        var act = $('#act').val();
        var url;
        url = "/kelurahan";
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
        list_provinsi('id_provinsi');
    };

    function editData(id) {
        $('#modalForm').modal('show');
        $('#modalForm .modal-title').html('<i class="fa fa-edit"></i> Edit Data');
        $('#modalForm form')[0].reset();
        $('#modalForm #id').val(id);
        $('#modalForm #act').val('edit');
        var url = "{{ route('kelurahan.show', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            method: 'GET',
            url: url,
            success: function(data) {
                console.log(data);
                list_provinsi('id_provinsi', data.id_provinsi);
                list_kota('id_kota', data.id_provinsi, data.id_kota);
                list_kecamatan('id_kecamatan', data.id_kota, data.id_kecamatan);
                $('#id_kelurahan').val(data.id_kelurahan);
                $('#nama_kelurahan').val(data.nama_kelurahan);
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
            var url = "{{ route('kelurahan.destroy', ':id') }}";
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

    function ajaxList(id_provinsi, id_kota = null, id_kecamatan = null) {
        table.destroy();
        table = $('#tableUserLevel').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('kelurahan') }}",
                data: function(d) {
                    d.id_provinsi = id_provinsi;
                    d.id_kota = id_kota;
                    d.id_kecamatan = id_kecamatan;
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_provinsi'
                },
                {
                    data: 'nama_kota'
                },
                {
                    data: 'nama_kecamatan'
                },
                {
                    data: 'id_kelurahan'
                },
                {
                    data: 'nama_kelurahan'
                },
                {
                    data: 'crt_user_name'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'action_button',
                    orderable: false,
                    searchable: false
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