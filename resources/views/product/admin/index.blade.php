@extends('layouts.master')

@section('content')

    <div class="row ">
        <div class="col-md-9 col-md-offset-2">
            <h4>Tambah Produk</h4>
            <form class="form-inline" name="add-product" action="{{url('/product/create')}}" method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Nama" name="name" required/>
                </div>
                <div class="form-group">
                    <input class="form-control" type="number" placeholder="Harga" name="price" required/>
                </div>
                <div class="form-group">
                    <input class="form-control" type="number" placeholder="Stok" name="stock" required/>
                </div>
                <button id="add-user-btn" type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah
                </button>
            </form>
        </div>
    </div>

    <br/>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(count($products) == 0)
                <h3>No user to be showed.</h3>
            @else
                <h4>List Produk</h4>
                <table class="table">
                    <tr>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                    @foreach($products as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>Rp{{$user->price}}</td>
                            <td>{{$user->stock}}</td>
                            <td>
                                <button type="button"
                                        class="btn btn-primary"
                                        data-toggle="modal"
                                        data-target="#updateModal"
                                        data-id="{{$user->id}}"
                                        data-name="{{$user->name}}"
                                        data-price="{{$user->price}}"
                                        data-stock="{{$user->stock}}">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah
                                </button>
                                <button type="button"
                                        class="btn btn-danger"
                                        data-toggle="modal"
                                        data-target="#deleteModal"
                                        data-id="{{$user->id}}"
                                        data-name="{{$user->name}}"
                                        data-price="{{$user->price}}"
                                        data-stock="{{$user->stock}}">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>

    <form class="form-horizontal" action="{{url('/product/delete')}}" method="post">
        <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #d9534f; color:white;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Konfirmasi</h4>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">Anda akan menghapus barang berikut</p>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Name</label>
                            <label id="item-name" class="col-md-7 form-control-static">Name</label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Price</label>
                            <label id="item-price" class="col-md-7 form-control-static">Price</label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Stock</label>
                            <label id="item-stock" class="col-md-7 form-control-static">Stock</label>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" id="item-id" name="product_id" value="">
                        {{--<input id="add-transaction-btn" type="button" class="btn btn-primary" value="Record">--}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Yakin</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </form>

    <form class="form-horizontal" action="{{url('/product/update')}}" method="post">
        <div id="updateModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Pengubahan Produk</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="item-name" class="col-sm-2 control-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="item-name" name="product_name" placeholder="Nama"
                                       value="" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="item-price" class="col-sm-2 control-label">Harga</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="item-price" name="product_price" placeholder="Harga"
                                       value="" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="item-stock" class="col-sm-2 control-label">Stok</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="item-stock" name="product_stock" placeholder="Stok"
                                       value="" required>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" id="item-id" name="product_id" value="">
                        {{--<input id="add-transaction-btn" type="button" class="btn btn-primary" value="Record">--}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </form>
@endsection

@section('js')
    <script type="application/javascript" src="/js/product.admin.js"></script>
@endsection
