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
                        </ul>
                    </div>
                </div>

                <div class="card-body">
                    <div class="alert alert-success d-none" id="success-alert"></div>
                    <div class="row">
                        <div class="col-lg-4 mb-1">
                            <label>Kementrian</label>
                            <select name="id_kementrian_filter" id="id_kementrian_filter" class="form-control"></select>
                        </div>
                    </div>
                    <table class="table table-bordered nowrap" id="tableUserLevel">
                        <thead>
                            <tr class="bg-primary">
                                <th scope="col">No</th>
                                <th scope="col">Kementrian</th>
                                <th scope="col">Nama Penyuluh</th>
                                <th scope="col">Contact Person</th>
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
                        <label>Kementrian *)</label>
                        <select name="id_kementrian" id="id_kementrian" class="form-control" required>

                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nama Penyuluh *)</label>
                        <input autocomplete="off" class="form-control" id="nama_penyuluh" name="nama_penyuluh"
                            placeholder="Nama Penyuluh" required type="text">
                    </div>
                    <div class="form-group">
                        <label>Contact Person *)</label>
                        <input autocomplete="off" class="form-control" id="contact_person" name="contact_person"
                            placeholder="Contact Person" required type="text">
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
    $(function() {
        list_kementrian('id_kementrian_filter');
        ajaxList();
    });

    $('#id_kementrian_filter').on('change',function(){
        ajaxList();
    })

    $('#formCRUD').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        var act = $('#act').val();
        var url;
        url = "/penyuluh";
        $(this).find('.error-text').text('');
        $('#success-alert').addClass('d-none').text('');
        $('#failed-alert').addClass('d-none').text('');

        // Disable button
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
    };

    function editData(id) {
        $('#modalForm').modal('show');
        $('#modalForm .modal-title').html('<i class="fa fa-edit"></i> Edit Data');
        $('#modalForm form')[0].reset();
        $('#modalForm #id').val(id);
        $('#modalForm #act').val('edit');
        var url = "{{ route('penyuluh.show', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            method: 'GET',
            url: url,
            success: function(data) {
                console.log(data);
                list_kementrian('id_kementrian', data.id_kementrian);
                $('#nama_penyuluh').val(data.nama_penyuluh);
                $('#contact_person').val(data.contact_person);
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
            var url = "{{ route('penyuluh.destroy', ':id') }}";
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

    function ajaxList() {
        var id_kementrian = $('#id_kementrian_filter').val();
        table.destroy();
        table = $('#tableUserLevel').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('penyuluh') }}",
                data: function(d) {
                    d.id_kementrian = id_kementrian
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_kementrian'
                },
                {
                    data: 'nama_penyuluh'
                },
                {
                    data: 'contact_person'
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