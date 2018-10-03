@extends('emails.layouts')

@section('content')
<h1>Zostałeś nowym Użytkownikiem</h1>

<h3>Wejdz na strone aby się zalogować:<a href="{{asset('/')}}" >Link</a></h3>
<h4>Login: {{$login}} </h4>
<h4>Haslo: {{$haslo}}</h4>


Wiadomość generowana automatycznie, prosimy na nią nie odpowiadać!!!

@endsection
