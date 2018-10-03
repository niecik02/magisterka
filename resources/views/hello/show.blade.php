@extends('layouts.edytor')
@section('title') {{$page->title}} @endsection
@section('content')

    <div class="naglowek">Tytuł</div><div class="tekst">{{$page->title}}</div>
    <div class="naglowek"> Autor:</div>
    <div class="tekst">@foreach($autorzy as $autor)
            {{$autor->name }}
        @endforeach
    </div>
    <div class="naglowek"> Status:</div>
    <div class="tekst">
        @switch($page->status)
        @case(1)
            Złożona
        @break
        @case(2)
        Oczekuje na recenzje
        @break
        @case(3)
        Oczekiwanie na akceptacje
        @break
        @case(4)
        Zaakceptowana
        @break
        @case(5)
        Odrzucona
        @break
        @case(6)
        Do Poprawy
        @break
        @case(7)
        Poprawiona
        @break
        @endswitch
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

    <div class="tekst"> Ostateczny termin oddania recenzji:@if(isset($data)) {{$data->data}}@else brak wyznaczonej daty @endif</div>


    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable ="true">
        <div class="tekst">
        Recenzent:
        @if(isset($data))
            @foreach($ilu as $jeden)
                <div class="panel panel-info">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <a class="pusta" data-toggle="collapse" data-parent="#accordion" href="#{{$jeden->id}}" aria-expanded="false" aria-controls="{{$jeden->id}}">
                            <h4 class="panel-title">
                                {{$jeden->name}}
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
                                                        <h5><b>Comments editors:</b> {{$recenzja->comments_editors }}</h5>
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
                                                            <h5><b>Comments editors:</b> {{$recenzja->comments_editors }}</h5>
                                                            <h5><b>Mml remarks:</b> {{$recenzja->mml_remarks }}</h5>
                                                        </div>
                                                    @endif
                                                @endif
                                            @empty

                                            @endforelse
                                        @break
                                        @case(3)
                                            <h5 class="panel-title"> Użytkownik odmówił recenzji</h5>
                                        @break
                                    @endswitch
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            Brak Recezentów
        @endif
        </div>
    </div>
    @if($page->status==3)
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#dopoprawy">
            Popraw
        </button>
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#odrzuc">
            Odrzuć
        </button>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#akceptuj">
            Akceptuj
        </button>

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
                        <h4 class="modal-title">Czy napewno odrzucić Artykuł?</h4>
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

        <div id="akceptuj" class="modal fade" role="dialog">
            <div class="modal-dialog">
            {!! Form::model($page,['route'=>['hello.update',$page],'method'=>'PUT']) !!}
            <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Czy napewno akceptować Artykuł?</h4>
                    </div>

                    {!! Form::hidden('status',4) !!}
                    <div class="modal-footer ">
                        <button type="submit" class="btn btn-default" data-dismiss="modal" >Anuluj</button>
                        {!! Form::submit('Akceptuj',['class'=>'btn btn-success','onClick'=>"sprawdz()"]) !!}
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>

    @endif


    <script>
        jQuery(document).ready(function($){
            op = function(obj) {
                $(obj).stop().slideToggle();
                $(obj).find('span').removeClass('glyphicon-chevron-down')
            };
        });
    </script>
@endsection