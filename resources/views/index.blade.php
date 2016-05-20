@extends('layouts.master')

@section('content')

    <div class="row ">
        <div class="col-md-8 col-md-offset-2">
            <h4>Add Product</h4>
            <form class="form-inline" name="add-product" action="{{url('/product/create')}}" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Name" name="name" required/>
                </div>
                <div class="form-group">
                    <input class="form-control" type="number" placeholder="Stock" name="stock" required/>
                </div>
                <div class="form-group">
                    <input class="form-control" type="number" placeholder="Price" name="price" required/>
                </div>
                <button id="add-product-btn" type="submit" class="btn btn-primary" >
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add
                </button>
            </form>
        </div>
    </div>

    <br/>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h4>Product List</h4>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->name}}</td>
                        <td>Rp{{$product->price}}</td>
                        <td>{{$product->stock}}</td>
                        <td>
                            <button type="button"
                                    class="btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#recordModal"
                                    data-id="{{$product->id}}"
                                    data-name="{{$product->name}}"
                                    data-price="{{$product->price}}"
                                    data-stock="{{$product->stock}}">
                                <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Record
                            </button>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <form class="form-horizontal" action="{{url('/transaction/create')}}" method="post">
        <div id="recordModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Record Transaction</h4>
                    </div>
                    <div class="modal-body">
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
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="item-quantity">Quantity</label>
                            <div class="col-md-7">
                                <input class="form-control" type="number" placeholder="Quantity" name="quantity" required>
                            </div>
                        </div>
                        {{--<input id="add-transaction-btn" type="button" class="btn btn-primary" value="Record">--}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </form>

@endsection



@section('js')
    <script type="application/javascript" src="js/index.js"></script>
@endsection
