@extends('layouts.recenzent')
@section('title') {{$page->title}} @endsection
@section('content')


    <div class="naglowek">Tytuł:</div><div class="tekst">{{$page->title}}</div>
    <div class="naglowek"> Pliki:</div>
    @if(isset($page->plik_miz))
        <div class="row">
            <div class="col-xs-3 col-md-3">
                <a class="pobierz" href= {{asset($page->plik_miz)}}><span class="glyphicon glyphicon-download"></span><span>Pobierz plik miz</span> </a>
            </div>
            <div class="col-xs-3 col-md-3">
                <a class="pobierz" href= {{asset($page->plik_bib)}}><span class="glyphicon glyphicon-download"></span><span>Pobierz plik bib</span> </a>
            </div>
            @if(isset($page->plik_voc))
                <div class="col-xs-3 col-md-3">
                    <a class="pobierz" href= {{asset($page->plik_voc)}}><span class="glyphicon glyphicon-download"></span><span>Pobierz plik voc</span></a>
                </div>
            @endif
        </div>
    @else
        <div class="tekst">Brak plików do pobrania</div>
    @endif<br/>
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
    @endif<br/>

    <div class="tekst"> Ostateczny termin oddania recenzji:@if(isset($data)) {{$data->data}}@else brak wyznaczonej daty @endif</div>
    <br>

    @if($id->status==1)

        <fieldset>
            <legend>Czy wystawisz recenzje:</legend>
            <div class="col-xs-2 col-md-2">
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#odrzuc">
                    Odrzuć
                </button>

            </div>
            <div class="col-xs-2 col-md-2">
                {!! Form::model($id,['route'=>['recenzent.akceptuj',$id],'method'=>'PUT']) !!}
                {!! Form::submit('Akceptuj',['class'=>'btn btn-success','onClick'=>'return sprawdz()']) !!}
                {!! Form::close() !!}
            </div>
        </fieldset>
        <div id="odrzuc" class="modal fade" role="dialog">
            <div class="modal-dialog">
            {!! Form::model($id,['route'=>['recenzent.odrzuc',$id],'method'=>'PUT']) !!}
            <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="modal-title">Odrzuć</h3>
                    </div>
                    <div class="modal-body">
                        <h4>Czy na pewno nie chcesz wyznaczać recenzji?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                        {!! Form::submit('Odrzuć',['class'=>'btn btn-danger','onClick'=>'return sprawdz()']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>


@endif


    @if($id->status==2)
        <div class="tekst"> Dodaj opinie przez: </div>
        <ul class="nav nav-tabs">

            <li class="active"><a href="#formularz">Formularz</a></li>
            <li><a href="{{route('recenzent.createPlik',$page)}}">Plik</a></li>

        </ul>


    <div id="formularz" class="tab">
        {!! Form::open(['route'=>['recenzent.storeFormularz',$id]]) !!}
        {!! Form::hidden('recenzja_id',$id->id) !!}
        <div class="form-group {{ $errors->has('confidence') ? 'has-error' : '' }}">
            {!! Form::label('confidence','Confidence:') !!}<br>
            <input type="radio" name="confidence" value="Very confidence"> Very confidence
            <input type="radio" name="confidence" value="Quite confidence"> Quite confidence
            <input type="radio" name="confidence" value="Not very confidence"> Not very confidence
            @if ($errors->has('confidence'))
                <span class="help-block">
                    <strong>{{ $errors->first('confidence') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('decision') ? ' has-error' : '' }}" >
            {!! Form::label('decision','The decision:') !!}<br>
            <input type="radio" name="decision" value="accept as is (editorial changes only, can be done by the editor)"> accept as is (editorial changes only, can be done by the editor)<br>
            <input type="radio" name="decision" value="accept, requires changes by the author to be approved by the editor">  accept, requires changes by the author to be approved by the editor<br>
            <input type="radio" name="decision" value="reject, substantial author's revisions needed before resubmission for another review"> reject, substantial author's revisions needed before resubmission for another review<br>
            <input type="radio" name="decision" value="decision delayed, MML revision needed"> decision delayed, MML revision needed<br>
            <input type="radio" name="decision" value="reject, no hope of getting anything of value"> reject, no hope of getting anything of value<br>
            @if ($errors->has('decision'))
                <span class="help-block">
                    <strong>{{ $errors->first('decision') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('presentation') ? ' has-error' : '' }}">
            {!! Form::label('presentation','Presentation:') !!}<br>
            <input type="radio" name="presentation" value="very poor"> Very poor
            <input type="radio" name="presentation" value="poor"> Poor
            <input type="radio" name="presentation" value="good"> Good
            <input type="radio" name="presentation" value="very good"> Very good
            @if ($errors->has('presentation'))
                <span class="help-block">
                    <strong>{{ $errors->first('presentation') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('quality_of_formalization') ? ' has-error' : '' }}">
            {!! Form::label('quality_of_formalization','The quality of formalization:') !!}<br>
            <input type="radio" name="quality_of_formalization" value="very poor"> Very poor
            <input type="radio" name="quality_of_formalization" value="poor"> Poor
            <input type="radio" name="quality_of_formalization" value="good"> Good
            <input type="radio" name="quality_of_formalization" value="very good"> Very good
            @if ($errors->has('quality_of_formalization'))
                <span class="help-block">
                    <strong>{{ $errors->first('quality_of_formalization') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('significance_for_mml') ? ' has-error' : '' }}">
            {!! Form::label('significance_for_mml','Significance for MML:') !!}<br>
            <input type="radio" name="significance_for_mml" value="very poor"> Very poor
            <input type="radio" name="significance_for_mml" value="poor"> Poor
            <input type="radio" name="significance_for_mml" value="good"> Good
            <input type="radio" name="significance_for_mml" value="very good"> Very good
            @if ($errors->has('significance_for_mml'))
                <span class="help-block">
                    <strong>{{ $errors->first('significance_for_mml') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('comments') ? ' has-error' : '' }}">
            {!! Form::label('comments',"Justification/comments (to be forwarded to the authors):") !!}
            {!! Form::textarea('comments',null,['class'=>'form-control']) !!}
            @if ($errors->has('comments'))
                <span class="help-block">
                    <strong>{{ $errors->first('comments') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('comments_editors') ? ' has-error' : '' }}">
            {!! Form::label('comments_editors',"Comments to editors only:") !!}
            {!! Form::textarea('comments_editors',null,['class'=>'form-control']) !!}
            @if ($errors->has('comments_editors'))
                <span class="help-block">
                    <strong>{{ $errors->first('comments_editors') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group {{ $errors->has('mml_remarks') ? ' has-error' : '' }}">
            {!! Form::label('mml_remarks',"MML Remarks:") !!}
            {!! Form::textarea('mml_remarks',null,['class'=>'form-control']) !!}
            @if ($errors->has('mml_remarks'))
                <span class="help-block">
                    <strong>{{ $errors->first('mml_remarks') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            {!! Form::submit('Zapisz',['class'=>'btn btn-primary','onClick'=>'return sprawdz()']) !!}
            {!! link_to(URL::previous(),'Powrót',['class'=>'btn btn-default']) !!}
        </div>
        {!! Form::close() !!}

    </div>


@endif

@endsection