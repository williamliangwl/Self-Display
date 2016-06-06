@extends('layouts.master')

@section('content')
    <div class="row ">
        <div class="col-md-9 col-md-offset-1">
            <h4>Tambah User</h4>
            <form class="form-inline" name="add-user" action="{{url('/user/create')}}" method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Nama" name="name" required/>
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Username" name="username" required/>
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" placeholder="Password" name="password" required/>
                </div>
                <div class="form-group">
                    <select name="role" class="form-control">
                        <option value="ADMIN">ADMIN</option>
                        <option value="BRANCH">BRANCH</option>
                    </select>
                </div>
                <button id="add-user-btn" type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah
                </button>
            </form>
        </div>
    </div>

    <br/>

    <div class="row">
        <div class="col-md-9 col-md-offset-1">
            @if(count($users) == 0)
                <h3>No user to be showed.</h3>
            @else
                <h4>List User</h4>
                <table class="table">
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->role}}</td>
                            <td>
                                <button type="button"
                                        class="btn btn-primary"
                                        data-toggle="modal"
                                        data-target="#updateModal"
                                        data-id="{{$user->id}}"
                                        data-name="{{$user->name}}"
                                        data-username="{{$user->username}}"
                                        data-role="{{$user->role}}">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah
                                </button>
                                <button type="button"
                                        class="btn btn-danger"
                                        data-toggle="modal"
                                        data-target="#deleteModal"
                                        data-id="{{$user->id}}"
                                        data-name="{{$user->name}}"
                                        data-username="{{$user->username}}"
                                        data-role="{{$user->role}}">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form class="form-horizontal" action="{{url('/user/delete')}}" method="post">
        <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #d9534f; color:white;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Konfirmasi</h4>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">Anda akan menghapus user berikut</p>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Nama</label>
                            <label id="user-name" class="col-md-7 form-control-static">Nama</label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Username</label>
                            <label id="user-username" class="col-md-7 form-control-static">Username</label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Role</label>
                            <label id="user-role-label" class="col-md-7 form-control-static">Role</label>
                        </div>
                        {!! csrf_field() !!}
                        <input type="hidden" id="user-id" name="id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Yakin</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </form>

    <form class="form-horizontal" action="{{url('/user/update')}}" method="post">
        <div id="updateModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Pengubahan User</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="user-name" class="col-sm-2 control-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="user-name" name="name" placeholder="Nama"
                                       value="" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user-username" class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="user-username" name="username"
                                       placeholder="Username"
                                       value="" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user-password" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="user-password" name="password"
                                       placeholder="Password"
                                       value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user-role" class="col-sm-2 control-label">Role</label>
                            <div class="col-sm-10">
                                <select id="user-role" name="role" class="form-control">
                                    <option value="ADMIN">ADMIN</option>
                                    <option value="BRANCH">BRANCH</option>
                                </select>
                            </div>
                        </div>
                        {!! csrf_field() !!}
                        <input type="hidden" id="user-id" name="id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </form>
@endsection

@section('js')
    <script type="application/javascript" src="/js/user.admin.js"></script>
@endsection