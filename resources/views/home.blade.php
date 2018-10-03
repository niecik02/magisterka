@extends('layouts.app')

@section('content')
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Panel</div>

                <div class="panel-body">
                    Zaloguj się jako:
                    <br/>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}

                        </div>

                    @endif
                        <a href="{{route('autor.index')}}"><button class="btn btn-primary">  Autor </button></a>
                    @if($recenzje>0)
                        <a href="{{route('recenzent.index')}}"><button class="btn btn-primary">Recenzent</button></a>
                    @endif
                    @if(Auth::user()->hasRole('edytor')==true)
                        <a href="{{route('hello.index')}}"><button class="btn btn-primary">Edytor</button></a>
                    @endif
                </div>

            </div>
        </div>

@endsection


