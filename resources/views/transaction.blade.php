@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-10">
            @foreach($transactions as $transaction)
                <h3>Transaction Id: {{$transaction['transaction_id']}}</h3>
                <h5>At {{$transaction['transaction_date']}} By {{$transaction['transaction_user_name']}}</h5>

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
                            <td>Rp{{$transactionDetail['product_price']}}</td>
                            <td>{{$transactionDetail['product_quantity']}}</td>
                            <td>Rp{{$transactionDetail['product_price']*$transactionDetail['product_quantity']}}</td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <strong>Total: Rp{{$transaction['transaction_total']}}</strong>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <br>
            @endforeach
        </div>
    </div>

@endsection
