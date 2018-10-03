@extends('emails.layouts')

@section('content')
    <h1>Zostałeś Recenzentem </h1>

    <h3>Zostaleś wyznaczony do recenzenzji pracy o tytule:{{$page->title}}</h3>
    <h4><a href="{{asset('/')}}" > Zaloguj się do systemu aby zaakceptować lub odrzucić propozycje recenzji.</a></h4>

    Wiadomość generowana automatycznie prosimy na nią nieodpowiadac!!!

@endsection
