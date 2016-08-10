@extends('layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(count($expensesMap) == 0)
                <h4>Tidak ada pengeluaran.</h4>
            @else
                <h4>List Pengeluaran</h4>

                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @foreach($expensesMap as $userName => $expenses)
                        <div class="panel panel-primary">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">
                                    <a href="#{{str_replace(' ', '-',$userName)}}" role="button" data-toggle="collapse"
                                       aria-expanded="true" aria-controls="{{str_replace(' ', '-',$userName)}}">
                                        {{$userName}}
                                    </a>
                                </h3>

                            </div>
                            <div id="{{str_replace(' ', '-',$userName)}}" class="panel-collapse collapse in"
                                 role="tabpanel">
                                <div class="panel-body">
                                    <table class="table">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jumlah</th>
                                            <th>Deskripsi</th>
                                        </tr>
                                        @foreach($expenses as $expense)
                                            <tr>
                                                <td>{{$expense->date}}</td>
                                                <td>Rp{{number_format($expense->price, 0, ',', '.')}}</td>
                                                <td>{{$expense->description}}</td>
                                            </tr>
                                        @endforeach
                                    </table>
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