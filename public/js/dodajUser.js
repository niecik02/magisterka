/**
 * Created by Robert on 14.05.2018.
 */
$(document).ready(function(){
    $('#rejestracja').click(function(){

        $('#email').removeClass('has-error')
        $('#email').find('.error span').remove()
        $('#name').removeClass('has-error')
        $('#name').find('.error span').remove();

        $.ajax({
            type:"POST",
            url:"dodajUser",
            data :{
                '_token':$('input[name=_token]').val(),
                'name':$('input[name=name]').val(),
                'email':$('input[name=email]').val(),
            },
            dataType: 'json',
            error: function (users) {
                $("#loading").removeClass("calosc")
                $('#loading').find('i').remove()
                if(users.responseJSON.errors.email){
                    $('#email').addClass('has-error')
                    $('#email').find('.error').append('<span>'+users.responseJSON.errors.email+'</span>')
                }
                if(users.responseJSON.errors.name){
                    $('#name').addClass('has-error')
                    $('#name').find('.error').append('<span>'+users.responseJSON.errors.name+'</span>')
                }
            },
            success:function(users){
                var list = $(".select");
                list.append(new Option(users.name, users.id));
                $('#dodajUser').modal('hide');
                $("#loading").removeClass("calosc")
                $('#loading').find('i').remove()
                wyczysc_pola()
                swal({
                    title:"Dodano Użytkownika",
                    type:"success"
                })

            }
        })
    });

});


function wyczysc_pola() {
    $('#name_dane').val('')
    $('#email_dane').val('')
}
