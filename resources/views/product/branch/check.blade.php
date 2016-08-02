@extends('layouts.master')

@section('content')
    <div class="row ">
        <div class="col-md-8 col-md-offset-2">
            <h4>Cek Stok Barang</h4>
            <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
            <div class="form-group">
                <input id="name-text-box" class="form-control" type="text" placeholder="Nama Barang" name="name" autocomplete="off"/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h4>
                List Barang
            </h4>
            <table id="product-table" class="table table-condensed">
                <tr>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Stok</th>
                </tr>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script type="application/javascript" src="/js/jquery-ui.min.js"></script>
    <script type="application/javascript" src="/js/product.check.branch.js"></script>
@endsection