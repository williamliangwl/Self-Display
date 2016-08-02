@extends('layouts.master')

@section('content')

    <h3>Laporan Mingguan</h3>
    <br>
    <div class="row">
        <div class="col-md-10">
            @if(count($reportData['details']) == 0)
                <h4>Belum ada data.</h4>
            @else
                <table class="table table-bordered">
                    <tr>
                        <th>Tanggal</th>
                        <th>Penjualan</th>
                        <th>Modal</th>
                        <th>Pengeluaran</th>
                        <th>Pendapatan</th>
                        <th>Pembelian Cash</th>
                    </tr>
                    @foreach($reportData['details'] as $data)
                        <tr>
                            <td>{{$data['date']}}</td>
                            <td>Rp {{number_format($data['totalPenjualan'], 0, ',', '.')}}</td>
                            <td>Rp {{number_format($data['totalModal'], 0, ',', '.')}}</td>
                            <td>Rp {{number_format($data['totalPengeluaran'], 0, ',', '.')}}</td>
                            <td>Rp {{number_format($data['totalPenjualan'] - $data['totalModal'] - $data['totalPengeluaran'], 0, ',', '.')}}</td>
                            <td>Rp {{number_format($data['totalPengeluaranCash'], 0, ',', '.')}}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>Total</td>
                        <td>Rp {{number_format($reportData['totalPenjualan'], 0, ',', '.')}}</td>
                        <td>Rp {{number_format($reportData['totalModal'], 0, ',', '.')}}</td>
                        <td>Rp {{number_format($reportData['totalPengeluaran'], 0, ',', '.')}}</td>
                        <td>Rp {{number_format($reportData['totalPenjualan'] - $reportData['totalModal'] - $reportData['totalPengeluaran'], 0, ',', '.')}}</td>
                        <td>Rp {{number_format($reportData['totalPengeluaranCash'], 0, ',', '.')}}</td>
                    </tr>
                </table>
                <br>
            @endif

            <br>
            <table class="table table-bordered" style="font-weight: bold;">
                <tr>
                    <td>Total Penjualan</td>
                    <td>
                        Rp {{number_format($reportData['totalPenjualan'], 0, ',', '.')}}</td>
                </tr>
                <tr>
                    <td>Total Pengeluaran Cash</td>
                    <td>Rp {{number_format($reportData['totalPengeluaranCash'], 0, ',', '.')}}</td>
                </tr>
                <tr>
                    <td>Total Pengeluaran</td>
                    <td>
                        Rp {{number_format($reportData['totalPengeluaran'], 0, ',', '.')}}</td>

                </tr>
                <tr>
                    <td>Total Keuntungan</td>
                    <td>
                        Rp {{number_format($reportData['totalPenjualan'] - $reportData['totalPengeluaranCash'] - $reportData['totalPengeluaran'], 0, ',', '.')}}</td>

                </tr>
            </table>

        </div>
    </div>

@endsection