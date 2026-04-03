@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>WhatsApp</h3>
                </div>
                <!-- <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Inbox</li>
                    </ol>
                </div> -->
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <a href="{{ route('pesan_wa') }}" class="btn btn-primary btn-block mb-3"><i class="fas fa-inbox"></i> Kembali ke Kotak Masuk</a>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Folders</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item">
                                <a href="{{ route('pesan_wa') }}" class="nav-link">
                                    <i class="fas fa-inbox"></i> Kotak Masuk
                                    <span class="badge bg-primary float-right" id="lblKotakMasuk">12</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pesan_wa_terkirim') }}" class="nav-link">
                                    <i class="fas fa-envelope"></i> Pesan Terkirim
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pesan_wa_draft') }}" class="nav-link">
                                    <i class="far fa-file-alt"></i> Draft Pesan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pesan_wa_setting') }}" class="nav-link">
                                    <i class="fa fa-cog"></i> Pengaturan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pesan_wa_dihapus') }}" class="nav-link">
                                    <i class="far fa-trash-alt"></i> Pesan Dihapus
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Kirim Pesan Baru</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-2">
                        <div class="alert alert-warning d-none" id="failed-alert"></div>
                        <div class="alert alert-success d-none" id="success-alert"></div>
                        <div class="form-group">
                            <label>No. Pengirim</label>
                            <select name="id_pengirim" id="id_pengirim" class="form-control">
                                <option value="">[Silahkan Pilih]</option>
                                @foreach($list_pengirim as $lp)
                                <option value="{{$lp->id}}">{{ $lp->no_pengirim }} ({{ $lp->alias }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Jenis Pesan</label>
                            <select id="jenis_pesan" name="jenis_pesan" class="form-control">
                                <option value="">[Silahkan Pilih]</option>
                                <option value="tunggal">Pesan Tunggal</option>
                                <option value="bc_group">Pesan Broadcast ke Grup</option>
                            </select>
                        </div>
                        <div class="form-group d-none" id="pilihanPenerima">
                            <label>Pilih Group/Kelompok Masyarakat</label>
                            <!-- <div  class="select2-purple"> -->
                            <select id="id_kelompok" name="id_kelompok" class="form-control">
                                <option value="">[Silahkan Pilih]</option>
                            </select>
                            <!-- </div> -->
                        </div>
                        <div class="form-group d-none" id="listPenerima">
                            <label>List Penerima</label>
                            <div class="select2-purple">
                                <select id="id_anggota" name="id_anggota" class="select2" multiple="multiple" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                    <option value="">[Silahkan Pilih]</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group d-none" id="formPenerimaTunggal">
                            <label>Penerima</label>
                            <div class="input-group">
                                <input type="text" name="penerima" id="penerima" class="form-control">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-green"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Pesan</label>
                            <textarea name="pesan" id="pesan" class="form-control" required rows="3" placeholder="Pesan"></textarea>
                        </div>
                        <div class="form-group">
                            <div name="btnCancel" id="btnCancel" class="btn btn-secondary" onclick="resetForm()"><i class="fa fa-times-circle"></i> Cancel</div>
                            <!-- <div name="btnDraft" id="btnDraft" class="btn btn-warning" onclick="sendMessage('D')"><i class="fa fa-file"></i> Draft</div> -->
                            <div name="btnSave" id="btnSave" class="btn btn-success" onclick="sendMessage('S')"><i class="fa fa-paper-plane"></i> Kirim</div>
                        </div>
                        <!-- /.mail-box-messages -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer p-0">

                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        // $('#id_kelompok').select2();
        $('#id_anggota').select2();

        $('#jenis_pesan').on('change', function() {
            var jenis_pesan = $(this).val();
            if (jenis_pesan == 'tunggal') {
                $('#formPenerimaTunggal').removeClass('d-none');
                $('#pilihanPenerima').addClass('d-none');
                $('#listPenerima').addClass('d-none');
            } else if (jenis_pesan == 'bc_group') {
                $('#pilihanPenerima').removeClass('d-none');
                $('#listPenerima').removeClass('d-none');
                $('#formPenerimaTunggal').addClass('d-none');
                list_kelompok('id_kelompok', 'null');
            }
        });
        $('#id_kelompok').on('change', function() {
            var id_kelompok = $(this).val();
            list_kontak_for_wa('id_anggota', id_kelompok, false);
        })
    });

    function sendMessage(status_msg) {
        var id_pengirim = $('#id_pengirim').val();
        var penerima = $('#penerima').val();
        var jenis_pesan = $('#jenis_pesan').val();
        var id_anggota = $('#id_anggota').val();
        var id_kelompok = $('#id_kelompok').val();
        var pesan = $('#pesan').val();
        var url = "/pesan_wa_send";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $('#success-alert').addClass('d-none').text('');
        $('#failed-alert').addClass('d-none').text('');
        $.ajax({
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: url,
            data: {
                id_pengirim: id_pengirim,
                jenis_pesan: jenis_pesan,
                id_anggota: id_anggota,
                id_kelompok: id_kelompok,
                penerima: penerima,
                pesan: pesan,
                status_msg: status_msg
            },
            beforeSend: function() {
                if (status_msg == 'D') {
                    $('#btnDraft').html('<i class="fa fa-spinner fa-spin"></i> Sedang Diproses...');
                } else {
                    $('#btnSave').html('<i class="fa fa-spinner fa-spin"></i> Sedang Diproses...');
                }
            },
            success: function(data) {
                if (data['status']) {
                    $('#success-alert').removeClass('d-none').text("Pesan telah berhasil dikirim.");
                    resetForm();
                } else {
                    $('#failed-alert').removeClass('d-none').text(data['message']);
                }
                if (status_msg == 'D') {
                    $('#btnDraft').html('<i class="fa fa-file"></i> Draft');
                } else {
                    $('#btnSave').html('<i class="fa fa-paper-plane"></i> Kirim');
                }
            },
            error: function(response) {
                if (status_msg == 'D') {
                    $('#btnDraft').html('<i class="fa fa-file"></i> Draft');
                } else {
                    $('#btnSave').html('<i class="fa fa-paper-plane"></i> Kirim');
                }
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

    function resetForm() {
        $('#id_pengirim').val('');
        $('#penerima').val('');
        $('#pesan').val('');
    }

    $('#formCRUD').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        var act = $('#act').val();
        var url;
        url = "/pesan_wa_setting";
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

    $('#tableInbox tbody').on('click', 'tr', function() {
        // Get the data for the clicked row
        var rowData = table.row(this).data();
        console.log(rowData);
        // Do something with the data, for example, show an alert
        if (rowData) {
            var url = "{{ route('pesan_wa_baca',':id') }}".replace(':id', rowData['id']);
            window.location.href = url;
            // alert('You clicked on ' + rowData['id'] + '\'s row');
            // You can also use the data to redirect to a new page, etc.
            // window.location.href = "details.html?id=" + rowData[0];
        }
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
        var url = "{{ route('pesan_wa_setting.show', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            method: 'GET',
            url: url,
            success: function(data) {
                console.log(data);
                $('#no_pengirim').val(data.no_pengirim);
                $('#token').val(data.token);
                $('#status').val(data.status);
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
            var url = "{{ route('pesan_wa_setting.destroy', ':id') }}";
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
        table.destroy();
        table = $('#tableInbox').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('pesan_wa') }}",
                data: function(d) {
                    d.name = $('#filter_name').val();
                    // d.status = $('#filter_status').val();
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },
            columns: [{
                    data: 'action_button',
                    orderable: false,
                    searchable: false
                },
                {
                    className: "pengirim_column",
                    data: 'pengirim_print'
                },
                {
                    data: 'pesan_print'
                },
                {
                    data: 'tgl_print'
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