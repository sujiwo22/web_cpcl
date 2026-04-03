@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Kegiatan Timeline') }}</h3>
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
                        <table class="table table-bordered" id="tableUserLevel">
                            <thead>
                                <tr class="bg-primary">
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Kegiatan</th>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <form id="formCRUD" data-toggle="validator">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="act" id="act">
                    <div class="modal-body">
                        <div class="alert alert-warning d-none" id="failed-alert"></div>
                        {{-- <div id="response-message" style="color: green; margin-bottom: 10px;"></div> --}}
                        <div class="form-group">
                            <label>Nama Kegiatan *)</label>
                            <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-control"
                                placeholder="Nama Kegiatan" required autocomplete="off">
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
            url = "/kegiatan_timeline";
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
            var url = "{{ route('kegiatan_timeline.show', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'GET',
                url: url,
                success: function(data) {
                    $('#nama_kegiatan').val(data.nama_kegiatan);
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
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                var url = "{{ route('kegiatan_timeline.destroy', ':id') }}";
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
                    url: "{{ url('kegiatan_timeline') }}",
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
                        data: 'nama_kegiatan'
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
    </script>
@endsection
