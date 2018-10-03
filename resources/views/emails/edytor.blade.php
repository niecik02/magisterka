@extends('emails.layouts')

@section('content')
    <h1>Zostala dodana nowa praca!!!</h1>

    <h3>Tytuł:{{$request->title}}</h3>

    Zaloguj się aby dodać recenzentów.<br/>
    <b>Wiadomość generowana automatycznie prosimy na nią nieodpowiadac!!!</b>

@endsection