@extends('emails.layouts')

@section('content')
<h1>Twoja praca do poprawy</h1>

<h3>Praca o tytule: "{{$page->title}}", została przeznaczona do paprawy.</h3>
<h4>Komentarz: {{$request->komentarz}}</h4>


Wiadomość generowana automatycznie, prosimy na nią nie odpowiadać!!!

@endsection
