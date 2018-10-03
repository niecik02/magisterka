@extends('layouts.edytor')
@section('title','Statystyki')
@section('content')

    {!! Form::open(['route'=>'hello.statystyka','method'=>'GET']) !!}
        <div class="row">
            <div class='col-sm-3'>
                <div class="form-group">
                    {!! Form::label('data_pocz','Od kiedy:') !!}
                    <div class='input-group date'>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        {!! Form::date('data_pocz','2018-04-30',['class'=>"form-control",'required'=>"true"]) !!}
                    </div>
                </div>
            </div>
            <div class='col-sm-3'>
                <div class="form-group">
                    {!! Form::label('data_kon','Do kiedy:') !!}
                    <div class='input-group date'>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        {!! Form::date('data_kon',date('Y-m-d'),['class'=>"form-control",'required'=>"true"]) !!}
                    </div>
                </div>
            </div>
            <div class='col-sm-3'>
                <div class="form-group">
                    {!! Form::label('szukaj','Szukaj:') !!}
                    <div class='input-group'>
                        <div class="input-group-addon"><span class="glyphicon glyphicon-list"></span></div>
                        {!! Form::select('szukaj',[1=>'Akceptowanych artykułów',2=>'Wystawionych recenzji',3=>'Odrzuconych artykułów',4=>'Odrzuconych recenzji',5=>'Wszystkie Artykuły'],null,['class'=>"form-control ",'required'=>"true"]) !!}
                    </div>
                </div>
            </div>
            <div class='col-sm-3 navbar-right'>
                <div class="form-group">
                    {!! Form::submit('Filtruj',['class'=>'btn btn-block','style'=>'margin-top:27px;']) !!}
                </div>
            </div>
            <div class='col-sm-2'>
                <div class="form-group">
                    {!! Form::label('ilosc','Na stronie :') !!}
                    <div class='input-group'>
                        <div class="input-group-addon"><span class="glyphicon glyphicon-eye-open"></span></div>
                        {!! Form::select('ilosc',[5=>'5',10=>'10',25=>'25',50=>'50'],null,['class'=>"form-control ",'required'=>"true"]) !!}
                    </div>
                </div>
            </div>
            <div class='col-sm-2'>
                <div class="form-group">
                    {!! Form::label('sortuj','Sortuj :') !!}
                    <div class='input-group'>
                        <div class="input-group-addon"><span class="glyphicon glyphicon-eye-open"></span></div>
                        {!! Form::select('sortuj',['DESC'=>'Malejąco','ASC'=>'Rosnąco'],null,['class'=>"form-control ",'required'=>"true"]) !!}
                    </div>
                </div>
            </div>

        </div>
    {!! Form::close() !!}


    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped" style="margin-top: 20px;">
                <thead>
                    <tr>
                        <th>
                            Użytkownik
                        </th>
                        <th>
                            Ilość
                        </th>

                        <th width="33%" >
                            Procent wszystkich
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dane as $dana)
                        <tr>
                            @foreach($dane2 as $dana2)
                                @if($dana->id==$dana2->id)
                                    <td>{{$dana->name}}</td>
                                    <td>{{$dana->ilosc}}</td>

                                    <td width="33%">{{round($dana->ilosc/$dana2->wszystkie*100,2)}}%</td>
                                @endif
                            @endforeach
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center"> Brak danych</td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th>Wszystkie:</th><th>{{$szukane}}</th><th width="33%" >{{round($szukane/$wszystko*100,2)}}%</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection