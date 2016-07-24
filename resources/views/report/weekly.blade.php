@extends('layouts.master')

@section('content')

    <h3>Laporan Mingguan</h3>
    <br>
    <div class="row">
        <div class="col-md-10">
            @if(count($reportData) == 0)
                <h4>No report to be showed.</h4>
            @else
                <table class="table table-bordered">
                    <tr>
                        <th>Tanggal</th>
                        <th>Penjualan</th>
                        <th>Modal</th>
                    </tr>
                    @foreach($reportData['details'] as $data)
                        <tr>
                            <td>{{$data['date']}}</td>
                            <td>Rp {{number_format($data['totalPenjualan'], 0, ',', '.')}}</td>
                            <td>Rp {{number_format($data['totalModal'], 0, ',', '.')}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>Total</td>
                        <td>Rp {{number_format($reportData['totalPenjualan'], 0, ',', '.')}}</td>
                        <td>Rp {{number_format($reportData['totalModal'], 0, ',', '.')}}</td>
                    </tr>
                </table>
                <br>
            @endif
        </div>
    </div>

@endsection