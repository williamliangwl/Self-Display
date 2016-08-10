@extends('layouts.master')

@section('content')

    <div class="row ">
        <div class="col-md-8 col-md-offset-2">
            <h4>Tambah Pembelian Cash</h4>
            <form class="form-inline" name="add-expense" action="{{url('/cash-expense/create')}}" method="post">
                {!! csrf_field() !!}
                <div class="form-group">
                    <input class="form-control" type="date" placeholder="Tanggal" name="date" value="{{date('Y-m-d')}}" required/>
                </div>
                <div class="form-group">
                    <input class="form-control" type="number" placeholder="Jumlah" min="0" name="price" required/>
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="Deskripsi" name="description" required/>
                </div>
                <button id="add-user-btn" type="submit" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Tambah
                </button>
            </form>
        </div>
    </div>

    <br/>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(count($expenses) == 0)
                <h4>Tidak ada pembelian cash.</h4>
            @else
                <h4>List Pembelian Cash</h4>
                <table class="table">
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Deskripsi</th>
                        <th>Action</th>
                    </tr>
                    @foreach($expenses as $expense)
                        <tr>
                            <td>{{$expense->date}}</td>
                            <td>Rp{{number_format($expense->price, 0, ',', '.')}}</td>
                            <td>{{$expense->description}}</td>
                            <td>
                                <button type="button"
                                        class="btn btn-primary"
                                        data-toggle="modal"
                                        data-target="#updateModal"
                                        data-id="{{$expense->id}}"
                                        data-date="{{$expense->date}}"
                                        data-price="{{$expense->price}}"
                                        data-description="{{$expense->description}}">
                                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah
                                </button>
                                <button type="button"
                                        class="btn btn-danger"
                                        data-toggle="modal"
                                        data-target="#deleteModal"
                                        data-id="{{$expense->id}}"
                                        data-date="{{$expense->date}}"
                                        data-price="{{$expense->price}}"
                                        data-description="{{$expense->description}}">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>

    <form class="form-horizontal" action="{{url('cash-expense/delete')}}" method="post">
        <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #d9534f; color:white;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Konfirmasi</h4>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">Anda akan menghapus barang berikut</p>
                        <div class="form-group">
                            <label class="col-md-5 control-label">Tanggal</label>
                            <label id="item-date" class="col-md-7 form-control-static">Name</label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label">Jumlah</label>
                            <label id="item-price" class="col-md-7 form-control-static">Price</label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-5 control-label">Deskripsi</label>
                            <label id="item-description" class="col-md-7 form-control-static">Deskripsi</label>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" id="item-id" name="id" value="">
                        {{--<input id="add-transaction-btn" type="button" class="btn btn-primary" value="Record">--}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Yakin</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </form>

    <form class="form-horizontal" action="{{url('/cash-expense/update')}}" method="post">
        <div id="updateModal" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Pengubahan Pengeluaran</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="item-date" class="col-sm-3 control-label">Tanggal</label>
                            <div class="col-sm-7">
                                <input type="date" class="form-control" id="item-date" name="date" placeholder="Tanggal"
                                       value="" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="item-price" class="col-sm-3 control-label">Jumlah</label>
                            <div class="col-sm-7">
                                <input type="number" class="form-control" id="item-price" name="price" placeholder="Jumlah"
                                       value="" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="item-capital-price" class="col-sm-3 control-label">Deskripsi</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="item-description" name="description" placeholder="Deskripsi"
                                       value="" required>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" id="item-id" name="id" value="">
                        {{--<input id="add-transaction-btn" type="button" class="btn btn-primary" value="Record">--}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Ubah
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </form>

@endsection

@section('js')
    <script type="application/javascript" src="/js/cash.expense.branch.js"></script>
@endsection