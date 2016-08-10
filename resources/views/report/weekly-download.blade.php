<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Mingguan Cabang {{$user->name}}</title>
</head>
<body>
<h2>Laporan Mingguan Cabang {{$user->name}}</h2>
@foreach($data as $weekNumber => $reportData)
    <h3>Minggu ke-{{$weekNumber}}</h3>
    @if(count($reportData['details']) == 0)
        <h4>Belum ada data.</h4>
    @else
        <table style="width:100%; font-family: Consolas, monospace; font-weight: bold;" border="1">
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

    <table border="1" style="font-weight: bold; width:100%;">
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
    <br>
@endforeach
</body>
</html>