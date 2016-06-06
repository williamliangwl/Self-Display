@extends('layouts.master')

@section('content')

    <div class="panel panel-default" style="width:50%;margin:auto;">
        <div class="panel-heading">
            Register
        </div>
        <div class="panel-body">
            <form class="form-horizontal" action="{{url('/user/create')}}" method="post">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="role" class="col-sm-2 control-label">Role</label>
                    <div class="col-sm-10">
                        <select id="role" name="role" class="form-control">
                            <option value="ADMIN" >ADMIN</option>
                            <option value="BRANCH" >BRANCH</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        {!! csrf_field() !!}
                        <button type="submit" class="btn btn-default">Register</button>
                        <span>Or <a href="{{url('/')}}">Login</a> </span>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection