@extends('layouts.master')

@section('content')

    <h3>Laporan Mingguan</h3>
    <a href="{{url('/report/weekly/download')}}" target="_blank" class="btn btn-primary">Laporan minggu sebelumnya</a>
    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                @foreach($data as $userName => $reportData)
                    <div class="panel panel-primary">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h3 class="panel-title">
                                <a href="#{{str_replace(' ', '-',$userName)}}" role="button"
                                   data-toggle="collapse"
                                   aria-expanded="true"
                                   aria-controls="{{str_replace(' ', '-',$userName)}}">
                                    {{$userName}}
                                </a>
                            </h3>
                        </div>
                        <div id="{{str_replace(' ', '-',$userName)}}" class="panel-collapse collapse in"
                             role="tabpanel">
                            <div class="panel-body">
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
                                                <td>
                                                    Rp {{number_format($data['totalPenjualan'] - $data['totalModal'] - $data['totalPengeluaran'], 0, ',', '.')}}</td>
                                                <td>
                                                    Rp {{number_format($data['totalPengeluaranCash'], 0, ',', '.')}}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>Total</td>
                                            <td>Rp {{number_format($reportData['totalPenjualan'], 0, ',', '.')}}</td>
                                            <td>Rp {{number_format($reportData['totalModal'], 0, ',', '.')}}</td>
                                            <td>Rp {{number_format($reportData['totalPengeluaran'], 0, ',', '.')}}</td>
                                            <td>
                                                Rp {{number_format($reportData['totalPenjualan'] - $reportData['totalModal'] - $reportData['totalPengeluaran'], 0, ',', '.')}}</td>
                                            <td>
                                                Rp {{number_format($reportData['totalPengeluaranCash'], 0, ',', '.')}}</td>
                                        </tr>
                                    </table>
                                    <br>
                                @endif

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
                    </div>
                    <br>
                @endforeach
            </div>
        </div>
    </div>

@endsection