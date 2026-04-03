@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $title }}</h3>
                    <div class="card-tools">
                        <!-- <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" onclick="addForm()"><i
                                        class="fa fa-plus-circle"></i> Add Data</a>
                            </li>
                        </ul> -->
                    </div>
                </div>

                <div class="card-body">
                    <div class="alert alert-success d-none" id="success-alert"></div>
                    <!-- <h3>REKAPAN ASPIRASI H. ALEX INDRA LUKMAN, S.Sos, M.A.P</h3> -->
                    <div class="row mb-2">
                        <div class="col-lg-2">
                            <label>Tahun</label>
                            <select name="tahun_filter" id="tahun_filter" class="form-control">
                                @php
                                @for ($i=$tahun_mulai;$i<=$tahun_selesai; $i++)
                                    <option value="{{ $i }}" {{ $i == $tahun_now ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label>Provinsi</label>
                            <select name="id_provinsi_filter" id="id_provinsi_filter" class="form-control"
                                placeholder="Provinsi">
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <div class="btn btn-app bg-warning mt-2" id="btnSearch"><i class="fa fa-search"></i>Cari
                            </div>
                            <div class="btn btn-app bg-success mt-2" id="btnExcel"><i class="fa fa-file-excel"></i>Export
                            </div>
                        </div>
                    </div>
                    <div id="showData"></div>
                </div>
            </div>
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
            <form data-toggle="validator" id="formCRUD">
                @csrf
                <input id="code" name="code" type="hidden">
                <input id="id" name="id" type="hidden">
                <div class="modal-body">
                    <div class="alert alert-warning d-none" id="failed-alert"></div>
                    <div class="form-group">
                        <label>Status *)</label>
                        <select class="form-control" id="status" name="status"
                            placeholder="Status" required></select>
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
    var table = $('#tableUserLevel').DataTable({
        scrollX: true,
        scrollY: '400px',
        scrollCollapse: true,
    });
    $(function() {
        list_provinsi('id_provinsi_filter');

        $('#btnSearch').on('click', function() {
            // var tahun = $('#tahun_filter').val();
            // var program_kementrian = $('#program_kementrian_filter').val();
            // var id_kementrian = $('#id_kementrian_filter').val();
            var id_provinsi = $('#id_provinsi_filter').val();
            var tahun = $('#tahun_filter').val();
            showReport(id_provinsi, tahun);
        });

        $('#formCRUD').submit(function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            var act = $('#act').val();
            var url;
            url = "/update_status_alokasi_program";
            $(this).find('.error-text').text('');
            $('#success-alert').addClass('d-none').text('');
            $('#failed-alert').addClass('d-none').text('');

            $.ajax({
                method: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#saveBtn').attr('disabled', true);
                },
                success: function(data) {
                    $('#saveBtn').attr('disabled', false);
                    if (data['status']) {
                        $('#modalFormUpdate').modal('hide');
                        $('#success-alert').removeClass('d-none').text("Data telah berhasil disimpan.");
                        $('#' + data['code'] + data['id']).text(data['status_data']);
                        $('#' + data['code'] + data['id']).removeClass('text-green');
                        $('#' + data['code'] + data['id']).removeClass('text-red');
                        $('#' + data['code'] + data['id']).removeClass('text-yellow');
                        $('#' + data['code'] + data['id']).addClass(data['new_tl']);
                        // table.ajax.reload(null, false);
                    } else {
                        $('#failed-alert').removeClass('d-none').text(data['message']);
                    }
                },
                error: function(response) {
                    $('#saveBtn').attr('disabled', false);
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
        });
    });

    function showReport(id_provinsi, tahun) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var url;
        url = "/report_rekap_usulan_program_view";
        $.ajax({
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: url,
            data: {
                id_provinsi: id_provinsi,
                tahun: tahun
            },
            // contentType: false,
            // processData: false,
            // enctype: "multipart/form-data",
            beforeSend: function() {
                $('#showData').html('<i class="fa fa-spinner fa-spin"></i> Processing...');
                $('#uploadBtn').attr('disabled', true);
            },
            success: function(data) {
                // $('#btnPreview').html('<i class="fa fa-eye"></i> Preview Data');
                // if (data['status']) {
                console.log(data);
                $('#showData').html(data.html['original']);
                // $('#uploadBtn').attr('disabled', false);
                // } else {
                //     $('#failed-alert').removeClass('d-none').text(data['message']);
                //     $('#uploadBtn').attr('disabled', true);
                // }
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

    function updateStatus(code, id, status = null) {
        $('#modalFormUpdate').modal('show');
        $('#modalFormUpdate .modal-title').html('<i class="fa fa-plus-circle"></i> Update Status');
        $('#modalFormUpdate form')[0].reset();
        $('#modalFormUpdate #code').val(code);
        $('#modalFormUpdate #id').val(id);
        $('#status').empty();
        if (code == 'cpcl') {
            $('#status').append('<option value="BELUM LENGKAP">BELUM LENGKAP</option>');
            $('#status').append('<option value="SUDAH LENGKAP">SUDAH LENGKAP</option>');
        } else {
            $('#status').append('<option value="BELUM">BELUM</option>');
            $('#status').append('<option value="ON PROCESS">ON PROCESS</option>');
            $('#status').append('<option value="SUDAH">SUDAH</option>');
        }
        $('#status').val(status).change();
    }
</script>
@endsection