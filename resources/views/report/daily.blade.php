@extends('layouts.master')

@section('content')

    <h3>Laporan Harian</h3>
    <br>
    <div class="row">
        <div class="col-md-10">
            @if(count($reportData) == 0)
                <h4>No report to be showed.</h4>
            @else
                <h4>{{date("d F y")}}</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Nama</th>
                        <th>Kuantitas</th>
                        <th>Harga Jual</th>
                        <th>Modal</th>
                        <th>Penjualan</th>
                        <th>Subtotal Modal</th>
                    </tr>
                    @foreach($reportData['details'] as $data)
                        <tr>
                            <td>{{$data['name']}}</td>
                            <td>{{$data['quantity']}}</td>
                            <td>Rp {{number_format($data['deal'], 0, ',', '.')}}</td>
                            <td>Rp {{number_format($data['capital'], 0, ',', '.')}}</td>
                            <td>Rp {{number_format($data['deal'] * $data['quantity'], 0, ',', '.')}}</td>
                            <td>Rp {{number_format($data['capital'] * $data['quantity'], 0, ',', '.')}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" >Total</td>
                        <td>Rp {{number_format($reportData['totalPenjualan'], 0, ',', '.')}}</td>
                        <td>Rp {{number_format($reportData['totalModal'], 0, ',', '.')}}</td>
                    </tr>
                </table>
                <br>

            @endif
        </div>
    </div>

@endsection