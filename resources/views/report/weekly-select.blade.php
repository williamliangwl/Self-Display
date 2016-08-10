@extends('layouts.master')

@section('content')

    <h3>Download Laporan Mingguan</h3>
    <br>
    <div class="row">
        <div class="col-md-10">
            <table class="table" >
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>
                            <a href="{{url('/report/weekly/'.$user->id.'/download')}}"
                               class="btn btn-primary" target="_blank">Download</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endsection