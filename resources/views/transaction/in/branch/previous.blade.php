@extends('layouts.master')

@section('content')

    <h3>Histori Penambahan Stok Barang</h3>
    <br>
    <div class="row">
        <div class="col-md-10">
            @if(count($transactions) == 0)
                <h4>No transaction to be showed.</h4>
            @else
                @foreach($transactions as $transaction)
                    <h4>Transaction Id: {{$transaction['transaction_id']}}</h4>
                    <h5>Pada {{$transaction['transaction_date']}}</h5>
                    <h5>Oleh {{$transaction['transaction_user_name']}}</h5>
                    <button type="button"
                            class="btn btn-danger"
                            data-toggle="modal"
                            data-target="#deleteModal"
                            data-id="{{$transaction['transaction_id']}}">
                        Hapus
                    </button>
                    <br>
                    <br>
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

    <form class="form-horizontal" action="{{url('/transaction/in/delete')}}" method="post">
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
    <script type="application/javascript" src="/js/transaction.in.admin.js"></script>
@endsection
