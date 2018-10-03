@extends('emails.layouts')

@section('content')
    <h1>Odrzucona Recenzja </h1>

    <h3>Użytkownik: {{$user->name}}, postanowił nie oddawać recenzji do pracy o tytule {{$title->title}}</h3><br/>
    <h4><a href="{{asset('/')}}" > Zaloguj się do systemu aby wprowadzić zmiany.</a></h4><br/>

    Wiadomość generowana automatycznie prosimy na nią nieodpowiadac!!!

@endsection
