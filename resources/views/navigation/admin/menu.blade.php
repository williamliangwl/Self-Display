<li><a href="{{url('/user')}}">User</a></li>
<li><a href="{{url('/product')}}">Produk</a></li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        Transaksi <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="{{url('/transaction/in')}}">Histori Tambah Stok</a></li>
        <li><a href="{{url('/transaction/out')}}">Transaksi Keluar</a></li>
    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        Pengeluaran <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="{{url('/expense')}}">Pengeluaran Harian</a></li>
        <li><a href="{{url('/cash-expense')}}">Pembelian Cash</a></li>
    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        Laporan <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="{{url('/report/daily')}}">Laporan Harian</a></li>
        <li><a href="{{url('/report/weekly')}}">Laporan Mingguan</a></li>
        {{--<li><a href="{{url('/report/monthly')}}">Laporan Bulanan</a></li>--}}
    </ul>
</li>

