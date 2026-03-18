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

    function ajaxList(id_provinsi, tahun) {
        table.destroy();
        table = $('#tableUserLevel').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            scrollY: '400px',
            scrollCollapse: true,
            ajax: {
                url: "{{ url('report_rekap_usulan_program') }}",
                data: function(d) {
                    d.id_provinsi = id_provinsi;
                    d.tahun = tahun;
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
                    data: 'nama_dirjen'
                },
                {
                    data: 'nama_program'
                },
                {
                    data: 'pic'
                },
                {
                    data: 'contact_person'
                },
                {
                    data: 'kuota'
                },
                <?php
                foreach ($list_kota as $lk) {
                    $namaKabTemp = str_replace('KABUPATEN ', '', $lk->nama_kota);
                    $namaKab = str_replace(' ', '_', $namaKabTemp);
                ?> {
                        data: '<?= $namaKab ?>'
                    },
                <?php } ?> {
                    data: 'cpcl_status'
                },
                {
                    data: 'verifikasi_status'
                },
                {
                    data: 'kontrak_status'
                },
                {
                    data: 'pengiriman_status'
                },
                {
                    data: 'distribusi_status'
                },

            ]
        });
    }
</script>
@endsection