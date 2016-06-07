@extends('layouts.master')

@section('content')
    <div class="row ">
        <div class="col-md-9 col-md-offset-2">
            <h4>Catat Barang Masuk</h4>
            <label class="text-danger">Nama barang yang ingin ditambah harus sudah sama dengan yang sudah ada.</label>
            <form class="form-inline" name="add-in-transaction" action="{{url('/transaction/in/create')}}"
                  method="post">
                <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
                <div class="form-group">
                    <input id="name-text-box" class="form-control" type="text" placeholder="Nama" name="name" required/>
                </div>
                <div class="form-group">
                    <input class="form-control" type="number" placeholder="Stok Tambahan" name="stock" required/>
                </div>
                <button id="add-in-transaction-btn" type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah
                </button>
            </form>
            <label id="success-msg"></label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(count($products) == 0)
                <h3>No product to be showed.</h3>
            @else
                <h4>
                    List Barang
                </h4>

                <table id="product-table" class="table table-condensed">
                    <tr>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                    </tr>
                    {{--@foreach($products as $product)--}}
                        {{--<tr>--}}
                            {{--<td>{{$product->name}}</td>--}}
                            {{--<td>Rp{{$product->price}}</td>--}}
                            {{--<td>{{$product->stock}}</td>--}}
                        {{--</tr>--}}
                    {{--@endforeach--}}
                </table>
            @endif
        </div>
    </div>
@endsection

@section('js')
    <script type="application/javascript" src="/js/jquery-ui.min.js"></script>
    <script type="application/javascript" src="/js/transaction.in.branch.js"></script>
@endsection