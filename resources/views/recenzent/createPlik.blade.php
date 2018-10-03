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
    @endif<br/>

    <div class="tekst"> Ostateczny termin oddania recenzji:@if(isset($data)) {{$data->data}}@else brak wyznaczonej daty @endif</div>
    <br>


        <div class="tekst"> Dodaj opinie przez: </div>
        <ul class="nav nav-tabs">

            <li><a href="{{route('recenzent.create',$page)}}">Formularz</a></li>
            <li class="active"><a href="#plik">Plik</a></li>

        </ul>
<div id="plik" class="tab">
    <div class="tekst"> <a href="{{route('recenzent.pobierz')}}">Pobierz</a> oraz uzupełnij odpowiednio plik np: Confidence: A<br>
        <a href="#przyklad" data-toggle="modal" data-target='#przyklad'>Przykład poprawnie uzupełnionego pliku</a>
    </div>
    @if($errors->any())
        <div class="row" style="text-align: center">
            @foreach($errors->all() as $error)
                <div class="col-sm-4">
                    <div class="alert alert-danger col-sm-12">{{$error}}</div>
                </div>
            @endforeach
        </div>
    @endif
    {!! Form::open(['route'=>['recenzent.store',$id],'method'=>'POST', 'files'=>true]) !!}
    <div class="form-group">
        {!! Form::label ('opinia','Wybierz plik .txt do wyslania opinni')!!}
        {!! Form::hidden('recenzja_id',$id->id) !!}
        {!! Form::file('opinia')!!}
    </div>
    {!! Form::submit('Zapisz',['class'=>'btn btn-primary','onClick'=>'return sprawdz()']) !!}
    {!! Form::close() !!}
</div>
<div id="przyklad" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="przyklad">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Poprawnie Uzupełniony plik</h4>
            </div>
            <div class="modal-body">
                Confidence: a <br/>
                (A = very confident, B = quite confident, C = not very confident)<br/>
                <br/>
                ----------------------------<br/>
                <br/>
                The decision: a<br/>
                <br/>
                A. accept as is (editorial changes only, can be done by the editor)<br/>
                B. accept, requires changes by the author to be approved by the editor<br/>
                C. reject, substantial author's revisions needed before resubmission
                for another review<br/>
                D. decision delayed, MML revision needed<br/>
                E. reject, no hope of getting anything of value<br/>
                <br/>
                ---------------------------<br/>
                <br/>
                Presentation: 0<br/>
                (0 - very poor, 1 - poor, 2 - good, 3 - very good)<br/>
                <br/>
                The quality of formalization:  2<br/>
                (0 - very poor, 1 - poor, 2 - good, 3 - very good)<br/>
                <br/>
                Significance for MML: 1<br/>
                (0 - very poor, 1 - poor, 2 - good, 3 - very good)<br/>
                <br/>
                -----------------------------<br/>
                <br/>
                Justification/comments (to be forwarded to the authors)<br/>
                Nie mam zastrzeżeń do artykułu.
                <br/>
                -----------------------------<br/>
                <br/>
                Comments to editors only<br/>

                Bardzo dobry artykuł.
                <br/>
                -----------------------------<br/>

                MML remarks<br/>

                Brak uwag.

            </div>
            <div class="modal-footer ">
                <button type="button" class="btn btn-default"  data-dismiss="modal" >Zamknij</button>
            </div>
        </div>
    </div>
</div>

@endsection