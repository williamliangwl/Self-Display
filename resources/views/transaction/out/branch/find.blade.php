@extends('layouts.master')

@section('content')

    <div class="row ">
        <div class="col-md-12 form-inline">
            <h4>Cek Histori Pelanggan</h4>
            <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
            <div class="form-group">
                <input id="name-text-box" class="form-control" type="text" placeholder="Nama" name="name" autocomplete="off"/>
            </div>
            <div class="form-group">
                <input id="phone-text-box" class="form-control" type="text" placeholder="Telepon" name="phone" autocomplete="off"/>
            </div>
            <div class="form-group">
                <input id="address-text-box" class="form-control" type="text" placeholder="Alamat" name="address" autocomplete="off"/>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <h4>
                List Pelanggan
            </h4>
            <table id="buyer-table" class="table table-condensed">
                <tr>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                </tr>
            </table>
        </div>
    </div>

@endsection

@section('js')
    <script type="application/javascript" src="/js/transaction.out.find.branch.js"></script>
@endsection