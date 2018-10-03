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

    <div class="tekst">Ostateczny termin oddania recenzji:@if(isset($data)) {{$data->data}}@else brak wyznaczonej daty @endif</div>

    {!! Form::open(['route'=>['hello.updateRecenzent',$page],'method'=>'PUT']) !!}
    @if($errors->any())
        <div class="row">
            @foreach($errors->all() as $error)
                <div class="alert alert-danger col-sm-12">{{$error}}</div>
            @endforeach
        </div>
    @endif

<div class="row">
        <div class="col-sm-12 col-md-12">
            {!! Form::label('users_id[]', 'Zmień Recenzentów:') !!}

        </div>
        @foreach($recenzenci as $recenzent)
            <div class="col-xs-12 col-md-12">
                @if($recenzent->pivot->recenzja_id!=NULL)
                    <div class="row dodaj_form">
                        <div class="col-xs-8 col-md-8">
                            <div class="input-group">
                                <div class="input-group-addon "><span class="glyphicon glyphicon-list"> </span></div>
                                {!! Form::select('users_id[]', $users ,$recenzent->id,['class'=>'form-control select','id'=>'users_id','placeholder'=>'Wybierz...','required'=>'required','disabled'=>'disabled']) !!}
                            </div>
                            <div class="error"></div>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            <button type="button" class="btn btn-danger usun2" id="usun"  onclick='usun_autora(this)' disabled="disabled">
                                <span class="glyphicon glyphicon-minus" aria-hidden="true">Usuń</span>
                            </button>
                            <button type="button" class="btn btn-info dodaj" onclick='dodaj_autora(this)'>
                                <span class="glyphicon glyphicon-plus" aria-hidden="true">Dodaj</span>
                            </button>
                        </div>
                    </div>
                    @else
                    <div class="row dodaj_form">
                        <div class="col-xs-8 col-md-8">
                            <div class="input-group">
                                <div class="input-group-addon "><span class="glyphicon glyphicon-list"> </span></div>
                                {!! Form::select('users_id[]', $users ,$recenzent->id,['class'=>'form-control select','id'=>'users_id','placeholder'=>'Wybierz...','required'=>'required']) !!}
                            </div>
                            <div class="error"></div>
                        </div>
                        <div class="col-xs-4 col-md-4">
                            <button type="button" class="btn btn-danger usun2" id="usun"  onclick='usun_autora(this)'>
                                <span class="glyphicon glyphicon-minus" aria-hidden="true">Usuń</span>
                            </button>
                            <button type="button" class="btn btn-info dodaj" onclick='dodaj_autora(this)'>
                                <span class="glyphicon glyphicon-plus" aria-hidden="true">Dodaj</span>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    <div class="col-sm-12 col-md-12">
    <div class="form-group">
    {!! Form::button('Dodaj nowego użytkownika',['class'=>'btn btn-primary loading','data-toggle'=>"modal", 'data-target'=>'#dodajUser']) !!}
    </div>

        <div class="form-group">
            {!! Form::submit('Zapisz',['class'=>'btn btn-primary loading','id'=>'przycisk', 'onClick'=>'return akceptuj()']) !!}
            {!! link_to(URL::previous(),'Powrót',['class'=>'btn btn-default']) !!}
            {!! Form::close() !!}
        </div>
    </div>


    <div id="dodajUser" class="modal fade"  tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Dadawanie nowego użytkownika</h4>
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
                    <button type="submit" class="btn btn-primary" id="rejestracja">
                        Rejestracja
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>



    <script src="{{ asset('js/dodajUser.js') }}"></script>
@endsection