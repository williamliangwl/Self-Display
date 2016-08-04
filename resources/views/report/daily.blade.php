@extends('layouts.master')

@section('content')

    <h3>Laporan Harian {{date("d F Y")}}</h3>
    <br>
    <div class="row">
        <div class="col-md-10">
            @if(count($reportData['details']) == 0)
                <h4>Belum ada transaksi.</h4>
            @else
                <h3></h3>
                <h4>Pendapatan</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Cabang</th>
                        <th>Barang</th>
                        <th>Kuantitas</th>
                        <th>Penjualan</th>
                        <th>Modal Barang</th>
                        <th>Subtotal Penjualan</th>
                        <th>Subtotal Modal</th>
                    </tr>
                    @foreach($reportData['details'] as $data)
                        <tr>
                            <td>{{$data['user_name']}}</td>
                            <td>{{$data['name']}}</td>
                            <td>{{$data['quantity']}}</td>
                            <td>Rp {{number_format($data['deal'], 0, ',', '.')}}</td>
                            <td>Rp {{number_format($data['capital'], 0, ',', '.')}}</td>
                            <td>Rp {{number_format($data['deal'] * $data['quantity'], 0, ',', '.')}}</td>
                            <td>Rp {{number_format($data['capital'] * $data['quantity'], 0, ',', '.')}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4">Total</td>
                        <td>Rp {{number_format($reportData['totalPenjualan'], 0, ',', '.')}}</td>
                        <td>Rp {{number_format($reportData['totalModal'], 0, ',', '.')}}</td>
                    </tr>
                </table>

            @endif
            <br>

            @if(count($reportData['expenses']) == 0)
                <h4>Belum ada pengeluaran.</h4>
            @else
                <h4>Pengeluaran</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                    </tr>
                    @foreach($reportData['expenses'] as $data)
                        <tr>
                            <td>{{$data['description']}}</td>
                            <td>Rp {{number_format($data['price'], 0, ',', '.')}}</td>
                            {{--<td>Rp {{number_format($data['capital'], 0, ',', '.')}}</td>--}}
                            {{--<td>Rp {{number_format($data['deal'] * $data['quantity'], 0, ',', '.')}}</td>--}}
                            {{--<td>Rp {{number_format($data['capital'] * $data['quantity'], 0, ',', '.')}}</td>--}}
                        </tr>
                    @endforeach
                </table>
            @endif
            <br>

            <table class="table table-bordered" style="font-weight: bold;">
                <tr>
                    <td>Total Penjualan</td>
                    <td>
                        Rp {{number_format($reportData['totalPenjualan'] - $reportData['totalModal'], 0, ',', '.')}}</td>
                </tr>
                <tr>
                    <td>Total Pengeluaran</td>
                    <td>Rp {{number_format($reportData['totalExpenses'], 0, ',', '.')}}</td>
                </tr>
                <tr>
                    <td>Total Pendapatan</td>
                    <td>
                        Rp {{number_format($reportData['totalPenjualan'] - $reportData['totalModal'] - $reportData['totalExpenses'], 0, ',', '.')}}</td>

                </tr>
            </table>

        </div>
    </div>

@endsection