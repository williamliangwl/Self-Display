@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-12">
            @if(count($products) == 0)
                <h3>No product to be showed.</h3>
            @else
                <h4>
                    Pilih Barang <br class="visible-xs">
                    <span>
                        <button id="checkout-button"
                                class="btn btn-primary"
                                data-toggle="modal"
                                data-target="#recordOutTransaction">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Checkout
                        </button>
                    </span>
                </h4>

                <table id="chosen-product-table" class="table table-condensed">
                    <tr>
                        <th>Pilih</th>
                        <th>Nama</th>
                        <th>Stok</th>
                        <th>Harga Jual</th>
                        <th>Kuantitas</th>
                        <th>Harga Deal</th>
                    </tr>
                </table>

                <hr>
                <h4>List Barang</h4>
                <div class="form-group">
                    <input id="name-text-box" class="form-control" type="text" placeholder="Nama Barang" name="name"
                           autocomplete="off"/>
                </div>
                <table id="product-table" class="table table-condensed">
                    <tr>
                        <th>Pilih</th>
                        <th>Nama</th>
                        <th>Stok</th>
                        <th>Harga Jual</th>
                        <th></th>
                        <th></th>
                    </tr>
                    {{--@foreach($products as $product)--}}
                        {{--<tr>--}}
                            {{--<td>--}}
                                {{--<input class="selected-product" type="checkbox" value="{{$product->id}}">--}}
                            {{--</td>--}}
                            {{--<td>{{$product->name}}</td>--}}
                            {{--<td>{{$product->stock}}</td>--}}
                            {{--<td>Rp{{number_format($product->price, 0, ',', '.')}}</td>--}}
                            {{--<td class="quantity-column">--}}
                                {{--<input class="hidden" style="width:50px" type="number" min="1" max="{{$product->stock}}"--}}
                                       {{--value="1">--}}
                            {{--</td>--}}
                            {{--<td class="deal-price-column">--}}
                                {{--<input class="hidden" style="width:70px" type="number" min="1"--}}
                                       {{--value="{{$product->price}}">--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                    {{--@endforeach--}}
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
                    <label style="font-weight: normal;">Data Pembeli:</label>
                    <br>
                    <label>Isi nomor telepon terlebih dahulu. Data pelanggan akan diisi berdasarkan nomor
                        telepon.</label>
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-md-4">
                                <input type="text" id="name-text" class="form-control" name="name" placeholder="Nama"
                                       required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="phone-text" class="form-control" name="phone"
                                       placeholder="Telepon" required>
                            </div>
                            <div class="col-md-5">
                                <textarea id="address-text" name="address" id="address" placeholder="Alamat"
                                          class="form-control" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <table id="selected-product-table" class="table table-condensed">

                    </table>
                </div>
                <div class="modal-footer">
                    <span id="error-msg" class="text-danger"></span>
                    <span id="success-msg" class="text-success"></span>
                    <input id="_token" type="hidden" value="{{csrf_token()}}">
                    <a href="#" target="_blank" id="report-button" class="btn btn-success hidden" role="button">Nota</a>
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
