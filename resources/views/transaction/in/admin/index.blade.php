@extends('layouts.master')

@section('content')

    <h3>Transaksi Masuk</h3>
    <br>
    <div class="row">
        <div class="col-md-10">
            @if(count($transactions) == 0)
                <h4>No transaction to be showed.</h4>
            @else
                @foreach($transactions as $transaction)
                    <h4>Transaction Id: {{$transaction['transaction_id']}}</h4>
                    <h5>At {{$transaction['transaction_date']}} By {{$transaction['transaction_user_name']}}</h5>

                    <table class="table table-bordered">
                        <tr>
                            <th>Item Name</th>
                            <th>Quantity</th>
                        </tr>
                        @foreach($transaction['transaction_details'] as $transactionDetail)
                            <tr>
                                <td>{{$transactionDetail['product_name']}}</td>
                                <td>{{$transactionDetail['product_quantity']}}</td>
                            </tr>
                        @endforeach
                    </table>
                    <br>
                @endforeach

            @endif
        </div>
    </div>

@endsection
