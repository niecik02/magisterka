@extends('layouts.autor')
@section('title', 'Dodawanie')
@section('content')

    <h2>Dodaj Artykuł</h2>


    {!! Form::open(['route'=>'autor.uploadfile','method'=>'POST', 'files'=>true]) !!}

    @if ($errors->any())


        {{Session::forget('_old_input.users_id')}}

        @foreach($errors->all() as $error)
            <div class="btn btn-danger">{{$error}}</div>
        @endforeach


    @endif

    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="form-group">

                 {!! Form::label('title',"Tytuł:") !!}
                    <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-text-width"> </span></div>

                        {!! Form::text('title',null,['class'=>'form-control', 'placeholder'=>'Dodaj Tytuł']) !!}
                    </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-4">
            {!!Form::label ('plik_miz','Wybierz plik .miz do wyslania')!!}
            {!!Form::file('plik_miz')!!}
        </div>

        <div class="col-sm-12 col-md-4">
            {!!Form::label ('plik_bib','Wybierz plik .bib do wyslania')!!}
            {!!Form::file('plik_bib')!!}

        </div>
        <div class="col-sm-12 col-md-4">
            {!!Form::label ('plik_voc','Wybierz plik .voc do wyslania(opcjonalne)')!!}
            {!!Form::file('plik_voc')!!}

        </div>

    </div>
    <br/>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body alert-success">
                    <p>Czy kontynuować dodawanie pracy?</p>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
                    {!! Form::submit('Kontynuuj',['class'=>'btn btn-primary loading','id'=>'przycisk','onClick'=>'return sprawdz()']) !!}
                </div>
            </div>

        </div>
    </div>
    <div class="form-group">
        {!! Form::submit('Zapisz',['class'=>'btn btn-primary loading','id'=>'przycisk','onClick'=>'return akceptuj_dodanie()']) !!}
        {!! link_to(URL::previous(),'Powrót',['class'=>'btn btn-default']) !!}
        {!! Form::close() !!}
    </div>




    <script src="{{ asset('js/moj.js') }}"></script>


@endsection