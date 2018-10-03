@extends('emails.layouts')

@section('content')
<h1>Praca poprawiona</h1>

<h3>Praca o tytule: "{{$page->title}}", została poprawiona.</h3>
<h4><a href="{{asset('/')}}" > Zaloguj się do systemu aby zaakceptować prace.</a></h4>


Wiadomość generowana automatycznie, prosimy na nią nie odpowiadać!!!

@endsection
