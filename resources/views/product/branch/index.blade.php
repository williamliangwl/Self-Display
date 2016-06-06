@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(count($products) == 0)
                <h3>No user to be showed.</h3>
            @else
                <h4>Product List</h4>
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Action</th>
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
                                        data-target="#recordModal"
                                        data-id="{{$user->id}}"
                                        data-name="{{$user->name}}"
                                        data-price="{{$user->price}}"
                                        data-stock="{{$user->stock}}">
                                    <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> Record
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>

    <form class="form-horizontal" action="{{url('/transaction/out/create')}}" method="post">
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
                                <input class="form-control" type="number" placeholder="Quantity" name="quantity"
                                       required>
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
