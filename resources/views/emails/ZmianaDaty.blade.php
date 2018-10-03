@extends('emails.layouts')

@section('content')
    <h1>Zmieniono date oddania recenzji </h1>

    <h3>Tytuł pracy:{{$page->title}}</h3>
    <h4>Nowy termin oddania recenzji: {{$request->data}} </h4>


    Wiadomość generowana automatycznie prosimy na nią nieodpowiadac!!!

@endsection
