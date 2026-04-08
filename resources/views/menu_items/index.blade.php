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
                    <table class="table table-bordered table-sm nowrap" id="tableUserLevel">
                        <thead>
                            <tr class="bg-primary">
                                <th scope="col">No</th>
                                <th scope="col">Menu</th>
                                <th scope="col">URL</th>
                                <th scope="col">Posisi Menu</th>
                                <th scope="col">Created By</th>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <form id="formCRUD" data-toggle="validator">
                @csrf
                <input type="hidden" name="id" id="id">
                <input type="hidden" name="act" id="act">
                <div class="modal-body">
                    <div class="alert alert-warning d-none" id="failed-alert"></div>
                    <div class="row">
                        <div class="col-lg-2 form-group">
                            <label>Icon</label>
                            <select name="icon" id="icon" class="form-control">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="col-lg-10 form-group">
                            <label>Menu *)</label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Menu" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>URL *)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{ url('/') }}/</span>
                            </div>
                            <input type="text" name="url" id="url" class="form-control"
                                placeholder="Menu" required autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Parent Menu *)</label>
                        <select class="form-control" id="parent_id" name="parent_id"></select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i
                            class="fa fa-times-circle"></i> Close</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn"><i class="fa fa-save"></i>
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
        ajaxList();
    });

    $('#formCRUD').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        var act = $('#act').val();
        var url;
        // if (act == 'save') {
        url = "/menu_list";
        // } else {
        //     url = "/menu_list.update";
        // }
        // Clear previous errors
        $(this).find('.error-text').text('');
        $('#success-alert').addClass('d-none').text('');
        $('#failed-alert').addClass('d-none').text('');

        // Disable button
        $('#saveBtn').attr('disabled', true);

        $.ajax({
            type: 'POST',
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
                // Show success message
                // $('#formCRUD').trigger("reset");
                // fetch_all_data();
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
        list_parent_menu('parent_id');
    };

    function editData(id) {
        $('#modalForm').modal('show');
        $('#modalForm .modal-title').html('<i class="fa fa-edit"></i> Edit Data');
        $('#modalForm form')[0].reset();
        $('#modalForm #id').val(id);
        $('#modalForm #act').val('edit');
        // var url = "/menu_list/show/"+id;
        var url = "{{ route('menu_list.show', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            method: 'GET',
            url: url,
            success: function(data) {
                $('#name').val(data.name);
                $('#url').val(data.url);
                list_parent_menu('parent_id', data.parent_id);
                // Show success message
                // $('#formCRUD').trigger("reset");
                // fetch_all_data();
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
            // var url = "/menu_list/show/"+id;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = "{{ route('menu_list.destroy', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'delete',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                url: url,
                success: function(data) {
                    table.ajax.reload(null, false);
                    // $('#level_name').val(data.level_name);
                    // Show success message
                    // $('#formCRUD').trigger("reset");
                    // fetch_all_data();
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
    };

    function ajaxList() {
        table.destroy();
        table = $('#tableUserLevel').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('menu_list') }}",
                data: function(d) {
                    d.name = $('#filter_name').val();
                    // d.status = $('#filter_status').val();
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name'
                },
                {
                    data: 'url_show'
                },
                {
                    data: 'parent_menu'
                },
                {
                    data: 'crt_user_name'
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'action_button'
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

    function list_parent_menu(object, hasil = null) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var url = "{{ route('menu_list.list') }}";
        // url = url.replace(':id', id);
        $.ajax({
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: url,
            before: function() {
                $('#' + object).empty();
                $('#' + object).append('<option value="">Wait...</option>')
            },
            success: function(data) {
                $('#' + object).empty();
                $('#' + object).append('<option value="">[Please Select]</option>')
                $.each(data, function(key, value) {
                    if (hasil != null) {
                        if (hasil == value['id']) {
                            $('#' + object).append('<option value="' + value['id'] + '" selected>' +
                                value['posisi'] +
                                '</option>');
                        } else {
                            $('#' + object).append('<option value="' + value['id'] + '">' + value['posisi'] +
                                '</option>');
                        }
                    } else {
                        $('#' + object).append('<option value="' + value['id'] + '">' + value['posisi'] +
                            '</option>');
                    }
                });
            },
            error: function(response) {
                $('#' + object).empty();
            }
        });
    };
</script>
@endsection