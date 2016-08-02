@extends('layouts.master')

@section('content')

    <h3>Laporan Bulanan</h3>
    <br>
    <div class="row">
        <div class="col-md-10">
            @if(count($reportData) == 0)
                <h4>No report to be showed.</h4>
            @else
                @foreach($reportData as $data)
                    <h4>{{date("F", mktime(0, 0, 0, $data['month'], 10))}}</h4>

                    <table class="table table-bordered">
                        <tr>
                            <th>Tanggal</th>
                            <th>Pendapatan</th>
                            <th>Modal</th>
                            <th>Pengeluaran</th>
                            <th>Pendapatan</th>
                            <th>Pembelian Cash</th>
                        </tr>

                        @foreach($data['details'] as $detail)
                            <tr>
                                <td>{{$detail['date']}}</td>
                                <td>Rp {{number_format($detail['deal'], 0, ',', '.')}}</td>
                                <td>Rp {{number_format($detail['capital'], 0, ',', '.')}}</td>
                                <td>Rp {{number_format($detail['deal'] - $detail['capital'], 0, ',', '.')}}</td>
                            </tr>
                        @endforeach

                    </table>
                    <br>
                @endforeach

            @endif
        </div>
    </div>

@endsection