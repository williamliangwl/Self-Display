@extends('layouts.master')

@section('content')

    <div class="row ">
        <div class="col-md-8 col-md-offset-2">
            <h4>Tambah Produk</h4>
            <form class="form-inline" name="add-product" action="{{url('/product/create')}}" method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Nama" name="name" required/>
                </div>
                <div class="form-group">
                    <input class="form-control" type="number" placeholder="Harga Modal" min="0" name="capital_price"
                           required/>
                </div>
                <div class="form-group">
                    <input class="form-control" type="number" placeholder="Harga Jual" min="0" name="price" required/>
                </div>
                <div class="form-group">
                    <input class="form-control" type="number" placeholder="Stok" min="0" name="stock" required/>
                </div>
                <div class="checkbox" style="padding: 15px 0;">
                    Untuk Cabang :
                    @foreach($users as $user)
                        <label class="checkbox-inline" >
                            <input type="checkbox" name="user_ids[]"
                                   value="{{$user->id}}" checked> {{$user->name}}
                        </label>
                    @endforeach
                </div>
                <br>
                <button id="add-user-btn" type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah
                </button>
            </form>
        </div>
    </div>

    <br/>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(count($productMap) == 0)
                <h3>No product to be showed.</h3>
            @else
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @foreach($productMap as $userName => $products)
                        <div class="panel panel-primary">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">
                                    <a href="#{{$userName}}" role="button" data-toggle="collapse"
                                       aria-expanded="true" aria-controls="{{$userName}}">
                                        {{$userName}}
                                    </a>
                                </h3>

                            </div>
                            <div id="{{$userName}}" class="panel-collapse collapse in" role="tabpanel">
                                <div class="panel-body">
                                    <table class="table">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Modal</th>
                                            <th>Harga Jual</th>
                                            <th>Stok</th>
                                            <th>Aksi</th>
                                        </tr>
                                        @foreach($products as $product)
                                            <tr>
                                                <td>{{$product->name}}</td>
                                                <td>Rp{{number_format($product->capital_price, 0, ',', '.')}}</td>
                                                <td>Rp{{number_format($product->price, 0, ',', '.')}}</td>
                                                <td>{{$product->stock}}</td>
                                                <td>
                                                    <button type="button"
                                                            class="btn btn-primary"
                                                            data-toggle="modal"
                                                            data-target="#updateModal"
                                                            data-id="{{$product->id}}"
                                                            data-name="{{$product->name}}"
                                                            data-price="{{$product->price}}"
                                                            data-capital="{{$product->capital_price}}"
                                                            data-stock="{{$product->stock}}">
                                                        <span class="glyphicon glyphicon-edit"
                                                              aria-hidden="true"></span> Ubah
                                                    </button>
                                                    <button type="button"
                                                            class="btn btn-danger"
                                                            data-toggle="modal"
                                                            data-target="#deleteModal"
                                                            data-id="{{$product->id}}"
                                                            data-name="{{$product->name}}"
                                                            data-price="{{$product->price}}"
                                                            data-capital="{{$product->capital_price}}"
                                                            data-stock="{{$product->stock}}">
                                                        <span class="glyphicon glyphicon-remove"
                                                              aria-hidden="true"></span> Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br>
                    @endforeach
                </div>


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
                            <label class="col-md-5 control-label">Nama</label>
                            <label id="item-name" class="col-md-7 form-control-static">Name</label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label">Harga Jual</label>
                            <label id="item-price" class="col-md-7 form-control-static">Price</label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label">Modal</label>
                            <label id="item-capital-price" class="col-md-7 form-control-static">Modal</label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label">Stok</label>
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
                            <label for="item-name" class="col-sm-5 control-label">Nama</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="item-name" name="product_name"
                                       placeholder="Nama"
                                       value="" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="item-price" class="col-sm-5 control-label">Harga Jual</label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" id="item-price" name="product_price"
                                       placeholder="Harga Jual"
                                       value="" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="item-capital-price" class="col-sm-5 control-label">Modal</label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" id="item-capital-price"
                                       name="product_capital_price" placeholder="Modal"
                                       value="" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="item-stock" class="col-sm-5 control-label">Stok</label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" id="item-stock" name="product_stock"
                                       placeholder="Stok"
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
