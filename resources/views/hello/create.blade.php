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
@if($recenzenci=='[]')
        {!! Form::open(['route'=>['hello.store',$page]]) !!}

        <div class="row">
            <div class='col-sm-3 col-xs-3 col-md-3'>
                <div class="form-group {{ $errors->has('data') ? ' has-error' : '' }}">
                    {!! Form::label('data','Wyznacz date oddania recenzji:') !!}
                    <div class='input-group date' id='datetimepicker1'>
                        {!! Form::date('data',$data,['class'=>"form-control",'required'=>"true"]) !!}
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
            <div class="col-sm-12 col-md-12">
                {!! Form::label('users_id[]', 'Dodaj Recenzentów:') !!}
            </div>
        </div>


        <div class="row dodaj_form">
            <div class="col-xs-5 col-md-5 col-sm-5">
                <div class="input-group">
                    <div class="input-group-addon "><span class="glyphicon glyphicon-list"> </span></div>
                    {!! Form::select('users_id[]', $users ,null,['class'=>"form-control select",'id'=>'users_id','required'=>'required','placeholder'=>'Wybierz ...','data-live-search'=>"true"]) !!}
                </div>
                <div class="error"></div>
            </div>
            <div class="col-xs-4 col-md-4 col-sm-4">
                <button type="button" class="btn btn-danger usun"  onclick='usun_autora(this)'>
                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Usuń
                </button>
                <button type="button" class="btn btn-info dodaj" onclick='dodaj_autora(this)'>
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Dodaj
                </button>
            </div>
        </div>

        <div class="row dodaj_form">
            <div class="col-xs-5 col-md-5">
                <div class="input-group">
                    <div class="input-group-addon "><span class="glyphicon glyphicon-list"> </span></div>
                    {!! Form::select('users_id[]', $users ,null,['class'=>"form-control select",'id'=>'users_id','required'=>'required','placeholder'=>'Wybierz ...','data-live-search'=>"true"]) !!}
                </div>
                <div class="error"></div>
            </div>
            <div class="col-xs-4 col-md-4">
                <button type="button" class="btn btn-danger usun"  onclick='usun_autora(this)'>
                    <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Usuń
                </button>
                <button type="button" class="btn btn-info dodaj" onclick='dodaj_autora(this)'>
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Dodaj
                </button>
            </div>
        </div>
        <div class="form-group">
            {!! Form::button('Dodaj nowego użytkownika',['class'=>'btn btn-primary loading','data-toggle'=>"modal", 'data-target'=>'#dodajUser']) !!}
        </div>

            <div class="row form-group">
                <div class="col-xs-10 col-md-10">
                    <div class="navbar-left">
                    {!! link_to(URL::previous(),'Powrót',['class'=>'btn btn-default']) !!}
                    {!! Form::submit('Zapisz',['class'=>'btn btn-primary loading','data-loading-text'=>"Zapisuje",'id'=>'przycisk','onClick'=>'return akceptuj()']) !!}
                    {!! Form::close() !!}
                    </div>
                    <div class="navbar-right">
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#dopoprawy">
                            Popraw
                        </button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#odrzuc">
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            Odrzuć
                        </button>
                    </div>
                </div>
            </div>


@else
    {!! Form::open(['route'=>['hello.ponow',$page]]) !!}
    <div class="row">
        <div class='col-sm-6'>
            <div class="form-group {{ $errors->has('data') ? ' has-error' : '' }}">
                {!! Form::label('data','Wyznacz date oddania recenzjii') !!}
                <div class='input-group date' id='datetimepicker1'>
                    {!! Form::date('data',$data,['class'=>"form-control",'required'=>"true"]) !!}
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

    <div class="col-sm-12 col-md-12">
        {!! Form::label('users_id[]', 'Wyślij do tych samych recenzentów:') !!}
    </div>
    @foreach($recenzenci as $recenzent)
        @if($recenzent->status!=3)

        <div class="col-xs-12 col-md-12">
            <div class="row dodaj_form">
                <div class="col-xs-8 col-md-8">
                    <div class="input-group">
                        <div class="input-group-addon "><span class="glyphicon glyphicon-list"> </span></div>
                        {!! Form::select('users_id[]', $users ,$recenzent->users_id,['class'=>'form-control select','id'=>'users_id','placeholder'=>'Wybierz...','required'=>'required']) !!}
                    </div>
                    <div class="error"></div>
                </div>
                <div class="col-xs-4 col-md-4">
                    <button type="button" class="btn btn-danger usun"  onclick='usun_autora(this)'>
                        <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-info dodaj" onclick='dodaj_autora(this)'>
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </button>
                </div>
            </div>
        </div>
        @endif
    @endforeach
        <div class="form-group">
            <div class="col-xs-10 col-md-10">
                <div class="navbar-left">
                    {!! link_to(URL::previous(),'Powrót',['class'=>'btn btn-default']) !!}
                    {!! Form::submit('Zapisz',['class'=>'btn btn-primary loading','data-loading-text'=>"Zapisuje",'id'=>'przycisk', 'onClick'=>'return sprawdz()']) !!}
                    {!! Form::close() !!}
                </div>
                <div class="navbar-right">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#dopoprawy">
                        Popraw
                    </button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#odrzuc">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                        Odrzuć
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif


        <div id="dodajUser" class="modal fade"  tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Dodawanie nowego użytkownika</h4>
                    </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form">
                            {{ csrf_field() }}
                            <div class="form-group" id="name" >
                                <label for="name" class="col-md-4 control-label">Imie i Nazwisko</label>
                                <div class="col-md-6">
                                    <input type="text" id="name_dane" class="form-control" name="name" required autofocus>
                                    <div class="error"></div>
                                </div>
                            </div>
                            <div class="form-group" id="email">
                                <label for="email" class="col-md-4 control-label">E-Mail </label>
                                <div class="col-md-6">
                                    <input  type="email"id="email_dane" class="form-control" name="email"  required>
                                    <div class="error"></div>
                                </div>
                            </div>
                            </form>
                        </div>
                        <div class="modal-footer ">
                            <button type="button" class="btn btn-default" onClick='wyczysc_pola()' data-dismiss="modal" >Anuluj</button>
                            <button type="submit" class="btn btn-primary" onClick='sprawdz()' id="rejestracja">
                                Rejestracja
                            </button>
                        </div>
                </div>
            </div>
        </div>


        <div id="dopoprawy" class="modal fade" role="dialog">
            <div class="modal-dialog">
                {!! Form::model($page,['route'=>['hello.poprawa',$page],'method'=>'PUT','onSubmit'=>"return sprawdz_form(this)"]) !!}
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do poprawy</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                                {!! Form::label('komentarz',"Komentarz:") !!}
                                {!! Form::textarea('komentarz',null,['class'=>'form-control', 'placeholder'=>'Dodaj komentarz...','required','id'=>'komentarz']) !!}
                            <div class="error"></div>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
                        {!! Form::submit('Do poprawy',['class'=>'btn btn-warning']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>






        <div id="odrzuc" class="modal fade" role="dialog">
            <div class="modal-dialog">
            {!! Form::model($page,['route'=>['hello.odrzuc',$page],'method'=>'PUT','onSubmit'=>"return sprawdz_form(this)"]) !!}
            <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Czy napewno odrzucić artykuł?</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            {!! Form::label('komentarz',"Komentarz:") !!}
                            {!! Form::textarea('komentarz',null,['class'=>'form-control', 'placeholder'=>'Dodaj komentarz...','required','id'=>'komentarz']) !!}
                            <div class="error"></div>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
                        <button type="submit" class='btn btn-danger'>
                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                            Odrzuć
                        </button>

                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>


        <script src="{{ asset('js/dodajUser.js') }}"></script>
    @endsection