@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('Alokasi Program') }}</h3>
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
                        <div class="col-lg-3">
                            <label>Tahun</label>
                            <select name="tahun_filter" id="tahun_filter" class="form-control" placeholder="Tahun">
                                <option value="">[Please Select]</option>
                                @for ($i=$tahun_mulai;$i<=$tahun_selesai; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label>Status Program</label>
                            <select name="program_kementrian_filter" id="program_kementrian_filter" class="form-control" placeholder="Status Program">
                                <option value="">[Please Select]</option>
                                <option value="Y">Program Kementrian</option>
                                <option value="N">Program Non Kementrian</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label>Kementrian</label>
                            <select name="id_kementrian_filter" id="id_kementrian_filter" class="form-control" placeholder="Kementrian">
                                <option value="">[Please Select]</option>
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
                                <th scope="col">Kementrian</th>
                                <th scope="col">Dirjen</th>
                                <th scope="col">Nama Program</th>
                                <th scope="col">PIC</th>
                                <th scope="col">Contact Person</th>
                                <th scope="col">Kuota</th>
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
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>Tahun</label>
                            <select name="tahun" id="tahun" class="form-control" aria-placeholder="Tahun" required>
                                <option value="">[Please Select]</option>
                                @for ($i=$tahun_mulai;$i<=$tahun_selesai; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Status Program *)</label>
                            <select name="program_kementrian" id="program_kementrian" class="form-control" aria-placeholder="Program Kementrian" required>
                                <option value="">[Please Select]</option>
                                <option value="Y">Program Kementrian</option>
                                <option value="N">Program Non Kementrian</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Kementrian *)</label>
                                <select name="id_kementrian" id="id_kementrian" class="form-control" aria-placeholder="Kementrian">
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Dirjen *)</label>
                                <select name="id_dirjen" id="id_dirjen" class="form-control" aria-placeholder="Dirjen">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Program *)</label>
                        <select name="id_program" id="id_program" class="form-control" aria-placeholder="Program" required>
                            <option value="">[Please Select]</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>PIC</label>
                            <select id="id_pic" name="id_pic" class="form-control select2" onchange="detailPIC()">
                            </select>
                            <input autocomplete="off" class="form-control" id="pic" name="pic"
                                placeholder="Nama PIC/Penanggung Jawab" type="hidden">
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Contact Person PIC</label>
                            <input autocomplete="off" class="form-control" id="contact_person" name="contact_person"
                                placeholder="Contact Person" required type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label>Kuota *)</label>
                            <input autocomplete="off" class="form-control" id="kuota" name="kuota" placeholder="Kuota" type="text" required>
                        </div>
                        <div class="col-lg-6 form-group">
                            <label>Satuan *)</label>
                            <select name="satuan" id="satuan" class="form-control" aria-placeholder="Satuan" required>
                                <option value="">[Please Select]</option>
                                <option value="pkt">pkt</option>
                                <option value="ha">ha</option>
                                <option value="unit">unit</option>
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
@endsection

@section('javascript')
<script type="text/javascript">
    var table = $('#tableUserLevel').DataTable();
    let id_provinsi, id_kota, id_kecamatan;
    $(function() {
        $('#program_kementrian_filter').on('change', function() {
            var program_kementrian = $(this).val();
            if (program_kementrian == 'Y') {
                $('#id_kementrian_filter').attr('disabled', false);
                list_kementrian('id_kementrian_filter');
            } else {
                $('#id_kementrian_filter').val('');
                $('#id_kementrian_filter').attr('disabled', true);
            }
        });

        $('#program_kementrian').on('change', function() {
            var program_kementrian = $(this).val();
            if (program_kementrian == 'Y') {
                $('#id_kementrian').attr('disabled', false);
                $('#id_dirjen').attr('disabled', false);
                list_kementrian('id_kementrian');
            } else {
                $('#id_kementrian').val('');
                $('#id_kementrian').attr('disabled', true);
                $('#id_dirjen').val('');
                $('#id_dirjen').attr('disabled', true);
            }
        });

        $('#id_kementrian').on('change', function() {
            var id_kementrian = $(this).val();
            list_dirjen('id_dirjen', id_kementrian);
        });
        $('#btnSearch').on('click', function() {
            var tahun = $('#tahun_filter').val();
            var program_kementrian = $('#program_kementrian_filter').val();
            var id_kementrian = $('#id_kementrian_filter').val();
            ajaxList(tahun, program_kementrian, id_kementrian);
        });
    });

    $('#formCRUD').submit(function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        var act = $('#act').val();
        var url;
        url = "/alokasi_program";
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
                $('#saveBtn').attr('disabled', false);
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
                $('#saveBtn').attr('disabled', false);
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
        var tahun = $('#tahun_filter').val();
        var program_kementrian = $('#program_kementrian_filter').val();
        var id_kementrian = $('#id_kementrian_filter').val();
        $('#tahun').val(tahun);
        $('#program_kementrian').val(program_kementrian);
        if (program_kementrian == 'Y') {
            $('#id_kementrian').attr('disabled', false);
            $('#id_dirjen').attr('disabled', false);
            list_kementrian('id_kementrian', id_kementrian);
            if (id_kementrian != '') {
                list_dirjen('id_dirjen', id_kementrian);
            }
        } else {
            $('#id_kementrian').attr('disabled', true);
            $('#id_dirjen').attr('disabled', true);
        }
        list_program('id_program');
        list_pic('id_pic');
    };

    function editData(id) {
        $('#modalForm').modal('show');
        $('#modalForm .modal-title').html('<i class="fa fa-edit"></i> Edit Data');
        $('#modalForm form')[0].reset();
        $('#modalForm #id').val(id);
        $('#modalForm #act').val('edit');
        var url = "{{ route('alokasi_program.show', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            method: 'GET',
            url: url,
            success: function(data) {
                console.log(data);
                $('#program_kementrian').val(data.program_kementrian);
                $('#id_kementrian').val(data.id_kementrian);
                $('#id_dirjen').val(data.id_dirjen);
                list_program('id_program', data.id_program);
                list_pic('id_pic', data.id_pic);
                $('#tahun').val(data.tahun);
                $('#pic').val(data.pic);
                $('#contact_person').val(data.contact_person);
                $('#kuota').val(data.kuota);
                $('#satuan').val(data.satuan);
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

    function detailPIC() {
        var id = $('#id_pic').val();
        var url = "{{ route('pic.show', ':id') }}";
        url = url.replace(':id', id);
        $.ajax({
            method: 'GET',
            url: url,
            success: function(data) {
                console.log(data);
                $('#pic').val(data.nama_pic);
                $('#contact_person').val(data.contact_person);
            },
            error: function(response) {
                alert('Something went wrong. Please try again.');
            }
        });
    }

    function deleteData(id) {
        if (confirm("Apakah anda yakin akan menghapus data ini?")) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = "{{ route('alokasi_program.destroy', ':id') }}";
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

    function ajaxList(tahun, program_kementrian = null, id_kementrian = null) {
        table.destroy();
        table = $('#tableUserLevel').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            scrollY: '400px',
            scrollCollapse: true,
            ajax: {
                url: "{{ url('alokasi_program') }}",
                data: function(d) {
                    d.tahun = tahun;
                    d.program_kementrian = program_kementrian;
                    d.id_kementrian = id_kementrian;
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    name: 'col_kementrian',
                    data: 'nama_kementrian'
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
            ],
            rowsGroup: [1]
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