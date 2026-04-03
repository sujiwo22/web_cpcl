@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Timeline Pelaksanaan Program') }}</h3>
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a class="nav-link mr-2 active" href="#" onclick="addForm()"><i
                                        class="fa fa-plus-circle"></i> Add Data</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card-body">
                    <div class="alert alert-success d-none" id="success-alert"></div>
                    <div class="row mb-2">
                        <div class="col-lg-2">
                            <label>Tahun</label>
                            <select name="tahun_filter" id="tahun_filter" class="form-control" aria-placeholder="Tahun" required>
                                <option value="">[Please Select]</option>
                                @for ($i=$tahun_mulai;$i<=$tahun_selesai; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                            </select>
                        </div>
                    </div>
                    <div id="showData"></div>
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
                        <label>Kegiatan *)</label>
                        <select class="form-control" id="id_kegiatan" name="id_kegiatan" required></select>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>Tahun Mulai *)</label>
                            <select name="tahun_start" id="tahun_start" class="form-control">
                                <option value="">[Please Select]</option>
                                @for ($i=$tahun_mulai;$i<=$tahun_selesai; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Bulan Mulai *)</label>
                            <select name="bulan_start" id="bulan_start" class="form-control">
                                <option value="">[Please Select]</option>
                                @for ($i=1;$i<=12; $i++)
                                    <option value="{{ $i }}">{{ nama_bulan($i) }}</option>
                                    @endfor
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>Tahun Selesai *)</label>
                            <select name="tahun_end" id="tahun_end" class="form-control">
                                <option value="">[Please Select]</option>
                                @for ($i=$tahun_mulai;$i<=$tahun_selesai; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Bulan Selesai *)</label>
                            <select name="bulan_end" id="bulan_end" class="form-control">
                                <option value="">[Please Select]</option>
                                @for ($i=1;$i<=12; $i++)
                                    <option value="{{ $i }}">{{ nama_bulan($i) }}</option>
                                    @endfor
                            </select>
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

<div class="modal fade" id="modalFormUpdate">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title"></h4>
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <form data-toggle="validator" id="formCRUDUpdate">
                @csrf
                <input id="id_data" name="id_data" type="hidden">
                <div class="modal-body">
                    <div class="alert alert-warning d-none" id="failed-alert"></div>
                    <div class="form-group">
                        <label>Kegiatan *)</label>
                        <span id="nama_kegiatan_span" class="form-control"></span>
                    </div>
                    <div class="form-group">
                        <label>Update ke Bulan *)</label>
                        <select name="bulan_end_new" id="bulan_end_new" class="form-control">
                            <option value="">[Please Select]</option>
                            @for ($i=1;$i<=12; $i++)
                                <option value="{{ $i }}">{{ nama_bulan($i) }}</option>
                                @endfor
                        </select>
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
    let nama_kelompok;
    let id_provinsi, id_kota, id_kecamatan, id_kelurahan, id_kelompok;
    $(function() {
        $('#tahun_filter').on('change', function() {
            var tahun = $(this).val();
            showTimeline(tahun);
        });
    });

    $('#formCRUD').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        var act = $('#act').val();
        var url;
        url = "/kegiatan_timeline_process";
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
                    var tahun = $('#tahun_filter').val();
                    showTimeline(tahun);
                    // table.ajax.reload(null, false);
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

    $('#formCRUDUpdate').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        var id = $('#id_data').val();
        var bulan_end_new = $('#bulan_end_new').val();
        // var url;
        // url = "/kegiatan_timeline_process";
        var url = "{{ route('kegiatan_timeline_process.update', ':id') }}";
        url = url.replace(':id', id);
        $(this).find('.error-text').text('');
        $('#success-alert').addClass('d-none').text('');
        $('#failed-alert').addClass('d-none').text('');

        $('#saveBtn').attr('disabled', true);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: url,
            data: {bulan_end_new:bulan_end_new},
            success: function(data) {
                if (data['status']) {
                    $('#modalFormUpdate').modal('hide');
                    $('#success-alert').removeClass('d-none').text("Data telah berhasil disimpan.");
                    var tahun = $('#tahun_filter').val();
                    showTimeline(tahun);
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
        list_kegiatan('id_kegiatan');
    };

    function showTimeline(tahun) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var url;
        url = "/kegiatan_timeline_process_view";
        $.ajax({
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: url,
            data: {
                tahun: tahun,
                type : 'setting'
            },
            // contentType: false,
            // processData: false,
            // enctype: "multipart/form-data",
            beforeSend: function() {
                $('#showData').html('<i class="fa fa-spinner fa-spin"></i> Processing...');
            },
            success: function(data) {
                console.log(data);
                $('#showData').html(data.html['original']);
            },
            error: function(response) {
                $('#showData').html('');
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

    function editData(id) {
        $('#modalFormUpdate').modal('show');
        $('#modalFormUpdate .modal-title').html('<i class="fa fa-edit"></i> Edit Data');
        $('#modalFormUpdate form')[0].reset();
        $('#modalFormUpdate #id_data').val(id);
        $('#modalFormUpdate #nama_kegiatan_span').text('');
        var url = "{{ route('kegiatan_timeline_process.show', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            method: 'GET',
            url: url,
            success: function(data) {
                console.log(data);
                $('#modalFormUpdate #nama_kegiatan_span').text(data.nama_kegiatan);
                $('#bulan_end_new').val(data.bulan_end);
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
            var url = "{{ route('kegiatan_timeline_process.destroy', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'delete',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                url: url,
                success: function(data) {
                    var tahun = $('#tahun_filter').val();
                    showTimeline(tahun);
                },
                error: function(response) {
                    alert('Something went wrong. Please try again.');

                }
            });
        }
    };
    
    function ubahUrutan(posisi,id) {
        if (confirm("Apakah anda yakin akan mengubah urutan data ini?")) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = "{{ route('kegiatan_timeline_process.update_urutan', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                method: 'put',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data:{posisi:posisi},
                url: url,
                success: function(data) {
                    var tahun = $('#tahun_filter').val();
                    showTimeline(tahun);
                },
                error: function(response) {
                    alert('Something went wrong. Please try again.');

                }
            });
        }
    };
</script>
@endsection