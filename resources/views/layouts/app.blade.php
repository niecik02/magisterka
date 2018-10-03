<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> @yield('title') </title>


    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">



    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <link rel="stylesheet" href="{{asset('css/mojestyle.css')}}">
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">




    <script src="https://unpkg.com/sweetalert2@7.18.0/dist/sweetalert2.all.js"></script>



</head>
<body>
@include('sweetalert::alert')
<div id="app">
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Główna
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav navbar-header">
                    @guest
                    &nbsp;
                    @else

                        @yield('nav')

                        @endguest

                </ul>


                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->

                    @guest
                    <li><a href="{{ route('login') }}"><span class="glyphicon glyphicon-log-in"></span> Zaloguj</a></li>
                    <li><a href="{{ route('register') }}"><span class="glyphicon glyphicon-user"></span> Rejestracja</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <span class="glyphicon glyphicon-user">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                    </span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('uzytkownik.zmiendane') }}">
                                        Edytuj
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Wyloguj
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endguest

                </ul>
            </div>
        </div>
    </nav>



    <div class="container">
        <div class="content">
            @yield('content')
        </div>

    </div>


    <footer class="panel-footer navbar-fixed-bottom">
        &copy Praca Magisterska- Robert Niecikowski
    </footer>
</div>
<div id="loading">

</div>


<script src="{{ asset('js/moj.js') }}"></script>


</body>
</html>
