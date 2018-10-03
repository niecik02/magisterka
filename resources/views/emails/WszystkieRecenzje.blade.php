@extends('emails.layouts')

@section('content')
    <h1>Wszystkie Recenzje!! </h1>

    <h3>Do pracy o tytule: {{$title->title}}, dodano wszystkie recenzje.</h3><br/>
    <h4><a href="{{asset('/')}}" > Zaloguj się do systemu aby wprowadzić zmiany.</a></h4><br/>

    Wiadomość generowana automatycznie prosimy na nią nieodpowiadac!!!

@endsection
