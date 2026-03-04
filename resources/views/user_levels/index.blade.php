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
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bg-primary">
                                    <th scope="col">User Level</th>
                                    <th scope="col">User Created</th>
                                    <th scope="col">Created at</th>
                                    <th scope="col" style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($userlevels as $userlevel)
                                    <tr>
                                        {{-- <td class="text-center">
                                            <img src="{{ asset('/storage/userlevels/'.$userlevel->image) }}" class="rounded" style="width: 150px">
                                        </td> --}}
                                        <td>{{ $userlevel->level_name }}</td>
                                        <td>{{ $userlevel->crt_id_user }}</td>
                                        <td>{{ $userlevel->crteated_at }}</td>
                                        <td class="text-center">
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                action="{{ route('user_level.destroy', $userlevel->id) }}" method="POST">
                                                <a href="{{ route('user_level.show', $userlevel->id) }}"
                                                    class="btn btn-sm btn-dark">SHOW</a>
                                                <a href="{{ route('user_level.edit', $userlevel->id) }}"
                                                    class="btn btn-sm btn-primary">EDIT</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <div class="alert alert-danger">
                                        Data Level User belum ada.
                                    </div>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $userlevels->links() }}
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
                        <div class="form-group">
                            <label>Bank *)</label>
                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Bank"
                                required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Logo</label>
                            <input type="file" name="logo" id="logo" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i
                                class="fa fa-times-circle"></i> Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript">
        function addForm() {
            $('#modalForm').modal('show');
            $('#modalForm .modal-title').html('<i class="fa fa-plus-circle"></i> Add Data');
            $('#modalForm form')[0].reset();
            $('#modalForm #id').val('');
            $('#modalForm #act').val('save');
        }
    </script>
@endsection
