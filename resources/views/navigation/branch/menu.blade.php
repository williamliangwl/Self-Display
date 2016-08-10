<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        Pengecekan <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="{{url('/transaction/out/buyer')}}">Cek Histori Pelanggan</a></li>
        <li><a href="{{url('/product/check')}}">Cek Stok Barang</a></li>
    </ul>
</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        Transaksi <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="{{url('/transaction/in/previous')}}">Histori Tambah Stok</a></li>
        <li><a href="{{url('/transaction/out/previous')}}">Transaksi Keluar</a></li>
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
<li><a href="{{url('/transaction/in')}}">Tambah Stok Barang</a></li>
<li><a href="{{url('/transaction/out')}}">Transaksi Keluar</a></li>
