@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-12">
            @if(count($products) == 0)
                <h3>No product to be showed.</h3>
            @else
                <h4>
                    Pilih Barang
                    <span>
                        <button id="checkout-button"
                                class="btn btn-primary"
                                data-toggle="modal"
                                data-target="#recordOutTransaction">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Checkout
                        </button>
                    </span>
                    <span>
                        <a href="{{url('/transaction/out/previous')}}"
                           target="_blank"
                           class="btn btn-default"
                           role="button">
                            Nota Sebelumnya
                        </a>
                    </span>
                </h4>

                <table id="product-table" class="table table-condensed">
                    <tr>
                        <th>Pilih</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Quantity</th>
                    </tr>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                <input class="selected-product" type="checkbox" value="{{$product->id}}">
                            </td>
                            <td>{{$product->name}}</td>
                            <td>Rp{{$product->price}}</td>
                            <td>{{$product->stock}}</td>
                            <td class="quantity-column" >
                                <input class="hidden" style="width:50px" type="number" min="1" max="{{$product->stock}}" value="1">
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>

    <div id="recordOutTransaction" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Konfirmasi</h4>
                </div>
                <div class="modal-body">
                    <p>Barang yang akan dibeli</p>
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-md-1 control-label" for="recipient">Penerima</label>
                            <div class="col-md-5">
                                <textarea name="recipient" id="recipient" class="form-control" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <table id="selected-product-table" class="table table-condensed">

                    </table>
                </div>
                <div class="modal-footer">
                    <span id="error-msg" class="text-danger" ></span>
                    <span id="success-msg" class="text-success" ></span>
                    <input id="_token" type="hidden" value="{{csrf_token()}}">
                    <a href="#" target="_blank" id="report-button" class="btn btn-success hidden" role="button" data-dismiss="modal">Nota</a>
                    <button type="button" id="cancel-button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="button" id="confirm-button" class="btn btn-primary">Yakin</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection

@section('js')
    <script type="application/javascript" src="/js/transaction.out.branch.js"></script>
@endsection
