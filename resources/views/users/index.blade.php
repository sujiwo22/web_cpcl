@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('User Level') }}</h3>
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
                        <table class="table table-sm table-bordered nowrap" id="tableUser">
                            <thead>
                                <tr class="bg-primary">
                                    <th scope="col">No</th>
                                    <th scope="col" style="width: 20%">Actions</th>
                                    <th scope="col">User Level</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Created by</th>
                                    <th scope="col">Created at</th>
                                    <th scope="col">Updated by</th>
                                    <th scope="col">Updated at</th>
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
                        {{-- <div id="response-message" style="color: green; margin-bottom: 10px;"></div> --}}
                        <div class="form-group">
                            <label>Level User *)</label>
                            <select class="form-control" id="id_user_level" name="id_user_level" placeholder="Level User"
                                required>

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nama User *)</label>
                            <input class="form-control" id="name" name="name" placeholder="Nama User" required
                                type="text">
                        </div>
                        <div class="form-group">
                            <label>Alamat Email *)</label>
                            <input class="form-control" id="email" name="email" placeholder="Alamat Email" required
                                type="email">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Password *)</label>
                                    <input class="form-control" id="password" name="password" placeholder="Password"
                                        type="password">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Ulangi Password *)</label>
                                    <input class="form-control" id="password2" name="password2"
                                        placeholder="Ulangi Password" type="password">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="alert alert-success d-none" id="edit-password">*) Jika password tidak diganti, maka kosongkan saja bagian ini. Terima Kasih...</div>
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
            url = "/user_list";
            // } else {
            //     url = "/user_list.update";
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
            list_user_level('id_user_level');
            $('#edit-password').addClass('d-none');
        };

        function editData(id) {
            $('#modalForm').modal('show');
            $('#modalForm .modal-title').html('<i class="fa fa-edit"></i> Edit Data');
            $('#modalForm form')[0].reset();
            $('#modalForm #id').val(id);
            $('#modalForm #act').val('edit');
            $('#edit-password').removeClass('d-none');
            // var url = "/user_list/show/"+id;
            var url = "{{ route('user_list.show', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'GET',
                url: url,
                success: function(data) {
                    list_user_level('id_user_level',data.id_user_level);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
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
                var url = "{{ route('user_list.destroy', ':id') }}";
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

                    },
                    complete: function() {
                        $('#saveBtn').attr('disabled', false);
                    }
                });
            }
        };

        function ajaxList() {
            table.destroy();
            table = $('#tableUser').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                scrollY: '400px',
                scrollCollapse: true,
                ajax: {
                    url: "{{ url('user_list') }}",
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
                        data: 'action_button',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'level_name'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'status_user'
                    },
                    {
                        data: 'crt_user_name'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'upd_user_name'
                    },
                    {
                        data: 'updated_at'
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

        function list_user_level(object, hasil = null) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = "{{ route('user_level.list') }}";
            // url = url.replace(':id', id);
            $.ajax({
                method: 'POST',
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
                            if (hasil == value.id) {
                                $('#' + object).append('<option value="' + value.id + '" selected>' +
                                    value.level_name +
                                    '</option>');
                            } else {
                                $('#' + object).append('<option value="' + value.id + '">' + value
                                    .level_name +
                                    '</option>');
                            }
                        } else {
                            $('#' + object).append('<option value="' + value.id + '">' + value
                                .level_name +
                                '</option>');
                        }
                    });
                },
                error: function(response) {
                    $('#' + object).empty();
                }
            });
        };

        function lockAccount(id) {
            if (confirm("Apakah anda yakin akan mengunci/menon-aktifkan akun ini?")) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                var url = "{{ route('user_list.lock', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    method: 'get',
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

        function unlockAccount(id) {
            if (confirm("Apakah anda yakin akan membuka kunci/mengaktifkan akun ini?")) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                var url = "{{ route('user_list.unlock', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    method: 'get',
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
    </script>
@endsection
