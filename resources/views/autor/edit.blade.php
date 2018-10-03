@extends('layouts.autor')
@section('title') {{$page->title}} @endsection
@section('content')


    <div class="naglowek">Tytuł</div><div class="tekst">{{$page->title}}</div>
    <div class="naglowek">
        Pliki:
        <button type="button" class="btn btn-default" data-toggle="modal" data-placement="bottom" data-target="#edit_1plik" title="Edytuj Pliki">
            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
        </button>
    </div>
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




    <br>
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
                    <div class="navbar-right" style="margin-right: 20px; margin-top: 10px">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#odpowiedz">
                        Odpowiedz
                    </button>
                    </div>
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
    @else
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#odpowiedz">
            Odpowiedz
        </button>
    @endif






    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="tekst">
            Recenzenci:
            @if(isset($data))
                <?php $a=1?>
                @foreach($ilu as $jeden)
                    @if($jeden->status!=3)
                        <div class="panel panel-info">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <a class="pusta" data-toggle="collapse" data-parent="#accordion" href="#{{$jeden->id}}" aria-expanded="false" aria-controls="{{$jeden->id}}">
                                    <h4 class="panel-title">
                                        Recenzent{{$a}} <span class="caret"></span>
                                    </h4>
                                </a>
                            </div>
                            <div id="{{$jeden->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    @php $a=0 @endphp
                                    @foreach($recenzenci as $recenzent)
                                        @if($recenzent->users_id==$jeden->users_id)
                                            @switch($recenzent->status)
                                            @case(1)
                                            <h5 class="panel-title"> Oczekuje na akceptacje</h5>
                                            @break
                                            @case(2)
                                            @if($recenzent->recenzja_id==NULL)
                                                <h5 class="panel-title"> Brak recenzji</h5>
                                                @php $a++; @endphp
                                            @endif
                                            @forelse($recenzje as $recenzja)
                                                @if($recenzent->recenzja_id==$recenzja->pivot->recenzja_id)
                                                    @if($a==0)
                                                        <h5><b>Confidence:</b> {{$recenzja->confidence }}</h5>
                                                        <h5><b>Decision:</b> {{$recenzja->decision }}</h5>
                                                        <h5><b>Presentation:</b> {{$recenzja->presentation }}</h5>
                                                        <h5><b>Quality of formalization:</b> {{$recenzja->quality_of_formalization }}</h5>
                                                        <h5><b>Significance for mml:</b> {{$recenzja->significance_for_mml }}</h5>
                                                        <h5><b>Comments:</b> {{$recenzja->comments }}</h5>
                                                        <h5><b>Mml remarks:</b> {{$recenzja->mml_remarks }}</h5><br/>
                                                        @php $a++ @endphp
                                                    @else
                                                        <h5><b><a href="#" onclick="op('#{{$recenzja->id}}')">Poprzednia recenzja:  <span class="glyphicon glyphicon-chevron-down"></span> </a></b></h5>
                                                        <div id="{{$recenzja->id}}" style="display:none;">
                                                            <h5><b>Confidence:</b> {{$recenzja->confidence }}</h5>
                                                            <h5><b>Decision:</b> {{$recenzja->decision }}</h5>
                                                            <h5><b>Presentation:</b> {{$recenzja->presentation }}</h5>
                                                            <h5><b>Quality of formalization:</b> {{$recenzja->quality_of_formalization }}</h5>
                                                            <h5><b>Significance for mml:</b> {{$recenzja->significance_for_mml }}</h5>
                                                            <h5><b>Comments:</b> {{$recenzja->comments }}</h5>
                                                            <h5><b>Mml remarks:</b> {{$recenzja->mml_remarks }}</h5>
                                                        </div>
                                                    @endif
                                                @endif
                                            @empty
                                            @endforelse
                                            @break
                                            @endswitch
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    <?php $a++?>
                @endforeach
            @else
                Brak Recezentów
            @endif
        </div>
    </div>
    <script>
        jQuery(document).ready(function($){
            op = function(obj) {
                $(obj).stop().slideToggle();
                $(obj).find('span').removeClass('glyphicon-chevron-down')
            };
        });
    </script>
    <!-- Modal -->
    <div id="edit_1plik" class="modal fade" role="dialog">
        <div class="modal-dialog">
        {!! Form::open(['route'=>['autor.update',$page],'method'=>'PUT','onSubmit'=>"return sprawdz_form(this)", 'files'=>true]) !!}
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Zmień pliki</h4>
                </div>
                <div class="modal-body">
                    {!!Form::label ('plik_miz','Wybierz plik .miz do wyslania')!!}

                    {!!Form::file('plik_miz')!!}


                    {!!Form::label ('plik_bib','Wybierz plik .bib do wyslania')!!}

                    {!!Form::file('plik_bib')!!}

                    {!!Form::label ('plik_voc','Wybierz plik .voc do wyslania')!!}

                    {!!Form::file('plik_voc')!!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
                    {!! Form::submit('Zapisz',['class'=>'btn btn-primary','onClick'=>'return sprawdz()']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div id="odpowiedz" class="modal fade" role="dialog">
        <div class="modal-dialog">
        {!! Form::model($page,['route'=>['autor.odpowiedz',$page],'method'=>'PUT','onSubmit'=>"return sprawdz_form(this)"]) !!}
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Odpowiedz</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('komentarz',"Komentarz:") !!}
                        {!! Form::textarea('komentarz',null,['class'=>'form-control', 'placeholder'=>'Dodaj komentarz...']) !!}
                        <div class="error"></div>
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Anuluj</button>
                    {!! Form::submit('Wyślij',['class'=>'btn btn-primary']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>



@endsection