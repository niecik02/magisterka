@extends('layouts.edytor')
@section('title', 'Edycja')
@section('content')
    <div class="naglowek">Tytuł</div><div class="tekst">{{$page->title}}</div>
    <div class="naglowek"> Autorzy:</div>
    <div class="tekst">@foreach($autorzy as $autor)
            {{$autor->name }}
        @endforeach
    </div>
    <div class="naglowek"> Pliki:</div>
    @if(isset($page->plik_miz))
        <a class="pobierz" href= {{asset($page->plik_miz)}}><span class="glyphicon glyphicon-download"></span><span>Pobierz plik miz</span> </a><br/>

        <a class="pobierz" href= {{asset($page->plik_bib)}}><span class="glyphicon glyphicon-download"></span><span>Pobierz plik bib</span> </a><br/>
        @if(isset($page->plik_voc))
            <a class="pobierz" href= {{asset($page->plik_voc)}}><span class="glyphicon glyphicon-download"></span><span>Pobierz plik voc</span></a><br/>
        @endif
    @else
        <div class="tekst">Brak plików do pobrania</div>
    @endif
    @if($komentarze!='[]')
        <div class="tekst">
            <div class="panel panel-primary">
                <div class="panel-heading" role="tab" id="headingOne">
                    <a class="pusta" data-toggle="collapse" data-parent="#accordion" href="#wiadomości" aria-expanded="false" aria-controls="wiadomości">
                        <h4 class="panel-title">
                            Wiadomości <span class="caret"></span>
                        </h4>
                    </a>
                </div>
                <div id="wiadomości" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    @foreach($komentarze as $komentarz)

                        <div class="panel-body">
                            <div class="naglowek">
                                @if($komentarz->status==2)
                                    <span class="glyphicon glyphicon-user">
                                    Edytor:
                                </span>
                                    {{$komentarz->komentarz}}
                                @else
                                    <span class="glyphicon glyphicon-user">
                                    Autor:
                                </span>
                                    {{$komentarz->komentarz}}
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    {!! Form::model($page,['route'=>['hello.zmienDate',$page],'method'=>'PUT']) !!}

    <div class="row">
        <div class='col-sm-6'>
            <div class="form-group {{ $errors->has('data') ? ' has-error' : '' }}">
                {!! Form::label('data','Zmień date oddania recenzjii') !!}
                <div class='input-group date' id='datetimepicker1'>
                    {!! Form::date('data',$data->data,['class'=>"form-control",'required'=>"true"]) !!}
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
                @if ($errors->has('data'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('data') }}</strong>
                                    </span>
                @endif
            </div>
        </div>

    </div>


    <div class="row">
        <div class="form-group">
            {!! Form::submit('Zapisz',['class'=>'btn btn-primary','onClick'=>'sprawdz()']) !!}
            {!! link_to(URL::previous(),'Powrót',['class'=>'btn btn-default']) !!}
            {!! Form::close() !!}
        </div>
    </div>







@endsection