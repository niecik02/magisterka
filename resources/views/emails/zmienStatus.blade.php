@extends('emails.layouts')

@section('content')
<h1>Twoja praca ma zmieniony Status</h1>

<h3>W praca o tytule: "{{$page->title}}", został zmieniony status</h3>
<h4>Aby uzyskać więcej informacji zaloguj się do serwisu <a href="{{asset('/')}}" >Link</a></h4>


Wiadomość generowana automatycznie, prosimy na nią nie odpowiadać!!!

@endsection
