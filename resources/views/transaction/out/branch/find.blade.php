@extends('layouts.master')

@section('content')

    <h3>Cek Histori Pelanggan</h3>

    <form action="{{url('/transaction/out/buyer')}}" method="post" class="form-inline">
        {!! csrf_field() !!}
        <div class="form-group">
            <input type="text" class="form-control" name="phone" id="phone-text" placeholder="Telepon">
        </div>
        <button class="btn btn-primary" type="submit" id="cek-button">Cek</button>
    </form>

    <hr>
    <div class="row">
        <div class="col-md-10">
            @if(!isset($transactions) || count($transactions) == 0)
                <h4>Tidak ditemukan transaksi apapun.</h4>
            @else
                <h3>{{$buyer->name}}</h3>
                <h5>{{$buyer->phone}}</h5>
                <pre style="padding:0; background-color:initial; border: none;">{{$buyer->address}}</pre>
                <br>
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @foreach($transactions as $date => $value)
                        <div class="panel panel-primary">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">
                                    <a href="#{{$date}}" role="button" data-toggle="collapse"
                                       aria-expanded="true" aria-controls="{{$date}}">
                                        Tanggal {{$date}}
                                    </a>
                                </h3>

                            </div>
                            <div id="{{$date}}" class="panel-collapse collapse in" role="tabpanel">
                                <div class="panel-body">
                                    @foreach($value as $transaction)
                                        <h5>Transaction Id: {{$transaction['transaction_id']}}</h5>
                                        <h5>Pada {{$transaction['transaction_date']}}</h5>
                                        <h5>Dengan {{$transaction['transaction_user_name']}}</h5>
                                        <a href="{{url('/transaction/out/report/' . $transaction['transaction_id'])}}"
                                           target="_blank"
                                           role="button"
                                           class="btn btn-primary hidden-xs"
                                           style="margin-bottom: 10px;">
                                            Lihat Nota
                                        </a>
                                        <a href="{{url('/transaction/out/report/' . $transaction['transaction_id'] . '/download')}}"
                                           target="_blank"
                                           role="button"
                                           class="btn btn-primary visible-xs"
                                           style="margin-bottom: 10px;">
                                            Download Nota
                                        </a>
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Nama</th>
                                                <th>Harga</th>
                                                <th>Kuantitas</th>
                                                <th>Subtotal</th>
                                            </tr>
                                            @foreach($transaction['transaction_details'] as $transactionDetail)
                                                <tr>
                                                    <td>{{$transactionDetail['product_name']}}</td>
                                                    <td>
                                                        Rp{{number_format($transactionDetail['product_price'],0,',','.')}}</td>
                                                    <td>{{$transactionDetail['product_quantity']}}</td>
                                                    <td>
                                                        Rp{{number_format($transactionDetail['product_price']*$transactionDetail['product_quantity'],0,',','.')}}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="3" style="text-align:center">
                                                    <strong>Total</strong>
                                                </td>
                                                <td>
                                                    <strong>Rp{{number_format($transaction['transaction_total'],0,',','.')}}</strong>
                                                </td>
                                            </tr>
                                        </table>
                                        <br>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <br>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

@endsection


@section('js')
    <script type="application/javascript" src="/js/transaction.out.check.branch.js"></script>
@endsection
