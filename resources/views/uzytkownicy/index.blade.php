@extends('layouts.edytor')
@section('title', 'Zmiana ról')
@section('content')
    <h1>Użytkownicy</h1>
    <div class="tabs">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#Edytorzy">Edytorzy</a></li>
            <li><a href="#Uzytkownicy">Użytkownicy</a></li>


        </ul>


        <div class="tab-content">
            <div id="Edytorzy" class="tab">
                <table class="table table-hover">
                    <tr><th>Imię i Nazwisko</th> <th>Email</th> <th>Opcje</th></tr>
                    @foreach($edytorzy as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                {!! Form::open(['route'=>['uzytkownicy.edit'],'method'=>'POST']) !!}
                                {!! Form::hidden('users_id',$user->id) !!}
                                {!! Form::hidden('roles_id',2) !!}
                                {!! Form::submit('Użytkownik',['class'=>'btn btn-primary']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>


            <div id="Uzytkownicy" class="tab" style="display:none">
                <table class="table table-hover">
                    <tr> <th>Login</th> <th>Email</th> <th>Opcje</th>  </tr>
                    @foreach($uzytkownicy as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                {!! Form::open(['route'=>['uzytkownicy.edit'],'method'=>'POST']) !!}
                                {!! Form::hidden('users_id',$user->id) !!}
                                {!! Form::hidden('roles_id',1) !!}
                                {!! Form::submit('Edytor',['class'=>'btn btn-warning']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>



        </div>
    </div>

    <script>
        jQuery(document).ready(function() {
            jQuery('.tabs .nav-tabs a').on('click', function(e)  {
                var currentAttrValue = jQuery(this).attr('href');

                // Show/Hide Tabs
                jQuery('.tabs ' + currentAttrValue).show().siblings().hide();

                // Change/remove current tab to active
                jQuery(this).parent('li').addClass('active').siblings().removeClass('active');

                e.preventDefault();
            });
        });
    </script>







@endsection