@extends('layouts.autor')
@section('title', 'Autor')
@section('content')

<h1>Moje Artykuły</h1>

{!! Form::text('szukaj',null,['placeholder'=>'wpisz tytuł','id'=>'szukaj','class'=>'form-control']) !!}
<table  class="table table-hover">
    <thead>
        <tr>
            <th>Tytuł</th>
            <th>Status</th>
            <th>Data dodania</th>
            <th>Opcje</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pages as $page)
            <tr>
                <th><a class="text" href="{{route('autor.show',$page->id)}}">{{$page->title}}</a></th>
                <th>
                    @foreach($statusy as $status)
                        @if($status->id==$page->status)
                            {{$status->status}}
                        @endif
                    @endforeach
                </th>
                <th>{{$page->created_at}}</th>
                <th>
                    @if($page->status==6)
                        <a href="{{route('autor.edit',$page)}}">
                            <button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Edytuj">
                            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        </button>
                        </a>
                    @endif
                </th>
            </tr>
        @endforeach
    </tbody>
</table>




<script type="text/javascript" src={{asset("js/paginathing.js")}}></script>
    <script>
        var $rows = $('.table tbody tr');
        $('#szukaj').keyup(function() {

            var val = '^(?=.*\\b' + $.trim($(this).val()).split(/\s+/).join('\\b)(?=.*\\b') + ').*$',
                reg = RegExp(val, 'i'),
                text;

            $rows.show().filter(function() {
                text = $(this).text().replace(/\s+/g, ' ');
                return !reg.test(text);
            }).hide();
        });



        jQuery(document).ready(function($){

            $('.table tbody').paginathing({
                perPage: 10,
                insertAfter: '.table',

            });
        });
    </script>

@endsection