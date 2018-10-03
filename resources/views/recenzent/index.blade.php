@extends('layouts.recenzent')
@section('title', 'Recenzent')
@section('content')

<h1>Moje Recenzje</h1>
    <div class="tabs">

        <ul class="nav nav-tabs">

            <li class="active"><a href="#do_wystawienia">Do wystawienia</a></li>
            <li><a href="#wystawione">Wystawione</a></li>
        </ul>
        <br/>
        <div class="tab-content">
            <div id="do_wystawienia" class="table-responsive">

                <div class="input-group">
                    {!! Form::text('szukaj_do_wystawienia',null,['placeholder'=>'wpisz tytuł','id'=>'szukaj_wyznacz','class'=>'form-control']) !!}
                    <div class="input-group-addon"><span class="glyphicon glyphicon-search"> </span></div>
                </div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Tytuł</th>
                        <th>Data dodania</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($do_wystawienia as $page)
                        <tr>
                            <th><a class="text" href="{{route('recenzent.create',$page)}}">{{$page->title}}</a></th>
                            <th>{{$page->created_at}}</th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div id="wystawione" class="table-responsive" style="display:none">
                <div class="input-group">
                    {!! Form::text('szukaj_wystawione',null,['placeholder'=>'wpisz tytuł','id'=>'szukaj_akceptacja','class'=>'form-control']) !!}
                    <div class="input-group-addon"><span class="glyphicon glyphicon-search"> </span></div>
                </div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Tytuł</th>
                        <th>Data dodania</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($wystawione as $page)
                        <tr>
                            <th><a class="text" href="{{route('recenzent.show',$page)}}">{{$page->title}}</a></th>
                            <th>{{$page->created_at}}</th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>



        </div>
    </div>



    <script>
        $('#szukaj_wystawione').keyup(function() {
            var $rows = $('#wyznacz_recenzentow .table tbody tr');
            var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
                reg = RegExp(val, 'i'),
                text;

            $rows.show().filter(function() {
                text = $(this).text().replace(/\s+/g, ' ');
                return !reg.test(text);
            }).hide();

        });

        $('#szukaj_do_wystawienia').keyup(function() {
            var $rows = $('#do_akceptacji .table tbody tr');
            var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
                reg = RegExp(val, 'i'),
                text;

            $rows.show().filter(function() {
                text = $(this).text().replace(/\s+/g, ' ');
                return !reg.test(text);
            }).hide();

        });

    </script>

@endsection