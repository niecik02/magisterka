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






var a=0
function dodaj_autora(przycisk) {
    let wiersz = $(przycisk).closest('.dodaj_form');
    let skopiowanyWiersz = wiersz.clone();
    skopiowanyWiersz.find('option:selected').prop('selected',false)
    skopiowanyWiersz.find("#users_id").removeAttr("disabled");
    skopiowanyWiersz.find(".usun2").removeClass('usun2').addClass('usun');
    skopiowanyWiersz.find(".has-error").removeClass('has-error');
    skopiowanyWiersz.closest('.dodaj_form').find('.error span').remove();
    skopiowanyWiersz.find(".usun").removeAttr("disabled");
    skopiowanyWiersz.insertAfter(wiersz);
    pokazUkryjPrzyciskDodaj()
    pokazUkryjPrzyciskUsun()
}
function usun_autora(przycisk) {
    let wiersz = $(przycisk).closest('.row');
    wiersz.remove();
    pokazUkryjPrzyciskDodaj()
    pokazUkryjPrzyciskUsun()
}
function pokazUkryjPrzyciskDodaj() {
    if ($('.dodaj').length ==5) {
        $('.dodaj').attr('disabled', true);
    } else {
        $('.dodaj').removeAttr('disabled');
    }

}
function pokazUkryjPrzyciskUsun() {

    if(($('.usun').length==0)||($('.usun2').length==0&&$('.usun').length==2))
    {
        $('.usun').attr('disabled', true);
    }
    else {
        $('.usun').removeAttr('disabled');
    }
}

$(document).ready(function ()
{
    pokazUkryjPrzyciskDodaj()
    pokazUkryjPrzyciskUsun()
   //zapamietajWartosciUzytkownikow()

   /* $('body').delegate('.dodaj_form select', 'change', function () {
        zapamietajWartosciUzytkownikow();
    });*/


});
/*if($(this).val()==""){
    $(this).closest('.input-group').addClass('has-error')
    $(this).closest('.dodaj_form').find('.error').append('<span>Pole puste!</span>')
}
else
{
    $(this).closest('.input-group').removeClass('has-error')
    $(this).closest('.dodaj_form').find('.error span').remove();
}
*/
function zapamietajWartosciUzytkownikow() {
    a=0
    var czySiePowtarza=[]
    $('.dodaj_form select').each(function () {

        for(var i=0;i<=czySiePowtarza.length;i++)
        {
            $(this).closest('.input-group').removeClass('has-error')
            $(this).closest('.dodaj_form').find('.error span').remove();

            if(czySiePowtarza[i]==$(this).val()&&$(this).val()!="") {
                $(this).closest('.input-group').addClass('has-error')
                if ($(this).closest('.dodaj_form').find('.error span').length == 0) {
                    $(this).closest('.dodaj_form').find('.error').append('<span>Użytkownik został już wybrany!</span>')

                }
                i = czySiePowtarza.length
                a++
            }else
            if ($(this).val() == "") {
                $(this).closest('.input-group').addClass('has-error')
                if ($(this).closest('.dodaj_form').find('.error span').length == 0) {
                    $(this).closest('.dodaj_form').find('.error').append('<span>Pole puste!</span>')
                }
                i = czySiePowtarza.length
                a++
            }


        }
        czySiePowtarza.push($(this).val());
    });

}
function akceptuj_dodanie(){

        $('#myModal').modal('show');
        return false;



};




    function akceptuj(){
        $('#myModal').modal('show');

        zapamietajWartosciUzytkownikow()
        //console.log(a)
            if(a!=0){
                return false
            }else{
                sprawdz()
                return true
            }



    };
function sprawdz(){
        $('#myModal').modal('hide')

        //$this.button('loading');
        $("#loading").addClass("calosc")
        $('.calosc').append('<i class="fa fa-spinner fa-spin" style="font-size:80px;color: red"></i>')
};

function sprawdz_form(dane){
    kom=$(dane).find("#komentarz").val();
    $(dane).find('.form-group').removeClass('has-error')
    $(dane).find('.form-group').find('.error span').remove();
    if(kom==""||kom.length<6||kom.length>1000)
    {
        $(dane).find('.form-group').addClass('has-error').find('.error').append('<span>Źle uzupełnione pole komentarz musi zawierać od 6 do 1000 znaków!</span>')
        return false;
    }else {

        $("#loading").addClass("calosc")
        $('.calosc').append('<i class="fa fa-spinner fa-spin" style="font-size:80px;color: red"></i>')
    }
};






/*$('.loading').on('click', function() {
    var $this = $(przycisk);
    $this.button('loading');
    setTimeout(function () {
        $this.button('reset');
    }, 8000);

});*/



/*$(function() {

    // We can attach the `fileselect` event to all file inputs on the page
    $(document).on('change', ':file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });

    // We can watch for our custom `fileselect` event like this
    $(document).ready( function() {
        $(':file').on('fileselect', function(event, numFiles, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = numFiles > 1 ? numFiles + ' files selected' : label;

            if( input.length ) {
                input.val(log);
                console.log(log)
            } else {
                if( log ) alert(log);
            }

        });
    });

});*/


