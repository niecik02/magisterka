@extends('emails.layouts')

@section('content')
<h1>Twoja praca została usunięta</h1>

<h3>Praca o tytule: "{{$page->title}}", została usunięta.</h3>
<h4>Komentarz: {{$request->komentarz}}</h4>


Wiadomość generowana automatycznie, prosimy na nią nie odpowiadać!!!

@endsection
