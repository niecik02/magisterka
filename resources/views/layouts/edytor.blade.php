@extends('layouts.app')
@section('nav')
    <li><a href="{{route('hello.index')}}">Panel Edytora</a></li>
    <li><a href="{{route('uzytkownicy.index')}}">Użytkownicy</a></li>
    <li><a href="{{route('hello.statystyka')}}">Statystyki</a></li>
@endsection
