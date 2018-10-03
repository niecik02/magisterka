@extends('layouts.app')
@section('title', 'Zmiana danych')
@section('content')
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">Zmień dane</div>
            <div class="panel-body">

                <div class="panel panel-default">
                    <div class="panel-heading">Imię i Nazwisko: {{$uzytkownik->name}}
                        <div class="navbar-right">
                            <a class="pusta" data-toggle="collapse" data-parent="#accordion" href="#Imie" aria-expanded="false" aria-controls="Imie">
                                <button type="button" class="glyphicon glyphicon-edit" style="margin-right: 20px">
                                    Edytuj
                                </button>
                            </a>
                        </div>
                    </div>
                    <div id="Imie" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <table  class="tabela"  cellpadding="10">
                            <tbody>
                                <tr>
                                    <td>
                                        <form class="form-horizontal" role="form">
                                            {{ csrf_field() }}
                                            <div class="form-group" id="imie" >
                                                <label for="imie" class="col-md-6 control-label">Imie i Nazwisko:</label>
                                                <div class="col-md-6">
                                                    <input type="text" id="imie_dane" class="form-control" name="imie">
                                                    <div class="error"></div>
                                                </div>
                                            </div>
                                        </form>

                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td>
                                    <button type="submit" class="btn btn-primary" id="ZmienImie" onClick='return sprawdz()'>
                                        Zmień
                                    </button>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>



                <div class="panel panel-default">
                    <div class="panel-heading">

                            Hasło:*********

                        <div class="navbar-right">
                            <a class="pusta" data-toggle="collapse" data-parent="#accordion" href="#Haslo" aria-expanded="false" aria-controls="Haslo">
                                <button type="button" class="glyphicon glyphicon-edit" style="margin-right: 20px">
                                    Edytuj
                                </button>
                            </a>
                        </div>

                    </div>
                    <div id="Haslo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <table  class="tabela"  cellpadding="10">
                            <tbody>
                            <tr>
                                <td>
                                    <form class="form-horizontal" role="form">
                                        {{ csrf_field() }}
                                        <div class="form-group" id="stare" >
                                            <label for="stare" class="col-md-4 control-label">Bieżące Hasło:</label>
                                            <div class="col-md-6">
                                                <input type="password" id="stare_dane" class="form-control" name="stare" required autofocus>
                                                <div class="error"></div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="nowe">
                                            <label for="nowe" class="col-md-4 control-label">Nowe Hasło: </label>
                                            <div class="col-md-6">
                                                <input  type="password" id="nowe_dane" class="form-control" name="nowe"  required>
                                                <div class="error"></div>
                                            </div>
                                        </div>

                                        <div class="form-group" id="powtorz">
                                            <label for="powtorz" class="col-md-4 control-label">Powtórz Hasło: </label>
                                            <div class="col-md-6">
                                                <input  type="password" id="powtorz_dane" class="form-control" name="powtorz"  required>
                                                <div class="error"></div>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td>
                                    <button type="submit" class="btn btn-primary" id="ZmienHaslo" onClick='return sprawdz()'>
                                        Zmień
                                    </button>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>



            </div>




        </div>
    </div>
    <script>
        $(document).ready(function(){
            $('#ZmienHaslo').click(function(){
                $('#stare').removeClass('has-error')
                $('#stare').find('.error span').remove()
                $('#nowe').removeClass('has-error')
                $('#nowe').find('.error span').remove();
                $('#powtorz').removeClass('has-error')
                $('#powtorz').find('.error span').remove();

                $.ajax({
                    type:"POST",
                    url:"zmienHaslo",
                    data :{
                        '_token':$('input[name=_token]').val(),
                        'stare':$('input[name=stare]').val(),
                        'nowe':$('input[name=nowe]').val(),
                        'nowe_confirmation':$('input[name=powtorz]').val(),
                    },
                    dataType: 'json',
                   error: function (dane) {
                       $("#loading").removeClass("calosc")
                       $('#loading').find('i').remove()
                       console.log(dane)
                        if(dane.responseJSON.errors.stare){
                            $('#stare').addClass('has-error')
                            $('#stare').find('.error').append('<span>'+dane.responseJSON.errors.stare+'</span>')
                        }
                        if(dane.responseJSON.errors.nowe){
                            $('#nowe').addClass('has-error')
                            $('#nowe').find('.error').append('<span>'+dane.responseJSON.errors.nowe+'</span>')
                        }
                       if(dane.responseJSON.errors.nowe_confirmation){
                           $('#powtorz').addClass('has-error')
                           $('#powtorz').find('.error').append('<span>'+dane.responseJSON.errors.nowe_confirmation+'</span>')
                       }
                    },
                    success:function(users){
                        $("#loading").removeClass("calosc")
                        $('#loading').find('i').remove()
                        wyczysc_pola_haslo()
                        swal({
                            title:"Poprawnie zmieniono hasło!!",
                            type:"success"
                        })
                    }
                })
            });



            $('#ZmienImie').click(function(){
                $('#imie').removeClass('has-error')
                $('#imie').find('.error span').remove()
                $.ajax({
                    type:"POST",
                    url:"zmienImie",
                    data :{

                        '_token':$('input[name=_token]').val(),
                        'imie':$('input[name=imie]').val(),
                    },
                    dataType: 'json',
                    error: function (dane) {
                        $("#loading").removeClass("calosc")
                        $('#loading').find('i').remove()
                        console.log(dane)
                        if(dane.responseJSON.errors.imie){
                            $('#imie').addClass('has-error')
                            $('#imie').find('.error').append('<span>'+dane.responseJSON.errors.imie+'</span>')
                        }
                    },
                    success:function(users){
                        $("#loading").removeClass("calosc")
                        $('#loading').find('i').remove()
                        swal({
                            title:"Poprawnie zmieniono Imie i Nazwisko!!",
                            type:"success"
                        })
                        location.reload(true);
                    }
                })
            });

        });


        function wyczysc_pola_haslo() {
            $('#stare_dane').val('')
            $('#nowe_dane').val('')
            $('#powtorz_dane').val('')
        }
    </script>
@endsection