@extends('layouts.master')

@section('content')

    <h3>Transaksi Keluar</h3>
    <br>
    <div class="row">
        <div class="col-md-10">
            @if(count($transactions) == 0)
                <h4>No transaction to be showed.</h4>
            @else
                @foreach($transactions as $transaction)
                    <h4>
                        Transaction Id: {{$transaction['transaction_id']}}
                    </h4>
                    <h5>Pada {{$transaction['transaction_date']}}</h5>
                    <h5>Kepada {{$transaction['transaction_recipient']}}</h5>
                    <h5>Oleh {{$transaction['transaction_user_name']}}</h5>
                    <a href="{{url('/transaction/out/report/' . $transaction['transaction_id'])}}"
                       target="_blank"
                       role="button"
                       class="btn btn-primary"
                       style="margin-bottom: 10px;">
                        Lihat Nota
                    </a>
                    <table class="table table-bordered">
                        <tr>
                            <th>Item Name</th>
                            <th>Item Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                        @foreach($transaction['transaction_details'] as $transactionDetail)
                            <tr>
                                <td>{{$transactionDetail['product_name']}}</td>
                                <td>Rp{{number_format($transactionDetail['product_price'],0,',','.')}}</td>
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

            @endif
        </div>
    </div>

@endsection
