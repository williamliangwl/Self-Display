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
                    <h4>Transaction Id: {{$transaction['transaction_id']}}</h4>
                    <h5>Pada {{$transaction['transaction_date']}}</h5>
                    <h5>Kepada {{$transaction['transaction_recipient']}}</h5>
                    <h5>Oleh {{$transaction['transaction_user_name']}}</h5>
                    <div style="margin-bottom: 10px;">
                        <a href="{{url('/transaction/out/report/' . $transaction['transaction_id'])}}"
                           target="_blank"
                           role="button"
                           class="btn btn-primary hidden-xs">
                            Lihat Nota
                        </a>
                        <a href="{{url('/transaction/out/report/' . $transaction['transaction_id'] . '/download')}}"
                           target="_blank"
                           role="button"
                           class="btn btn-primary visible-xs"
                           style="margin-bottom: 10px;">
                            Download Nota
                        </a>

                        <button type="button"
                                class="btn btn-danger"
                                data-toggle="modal"
                                data-target="#deleteModal"
                                data-id="{{$transaction['transaction_id']}}">
                            Hapus
                        </button>
                    </div>
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

    <form class="form-horizontal" action="{{url('/transaction/out/delete')}}" method="post">
        <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #d9534f; color:white;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Konfirmasi</h4>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">Yakin ingin menghapus data tersebut?</p>
                        {!! csrf_field() !!}
                        <input type="hidden" id="item-id" name="id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Yakin</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </form>

@endsection

@section('js')
    <script type="application/javascript" src="/js/transaction.out.admin.js"></script>
@endsection