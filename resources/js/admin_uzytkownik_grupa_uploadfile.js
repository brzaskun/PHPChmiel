$(document).ready(function () {
    $('#IMPfirmauser').puidropdown({
        filter: true,
        scrollHeight: 400,
        filterMatchMode: "contains",
        change: function (e) {
            firmadoimportu();
        },
        data: function (callback) {
            $.ajax({
                type: "POST",
                url: "pobierzfirmyJson_112014.php",
                dataType: "json",
                context: this,
                success: function (response) {
                    callback.call(this, response);
                }
            });
        }
    });
    $('#rodzajdanych').puidropdown({
        change: function (e) {
            pokazprzyciskladowania();
        }
    });
    podswietlmenu(rj('menuupowaznieniagrupa'));
});


var firmadoimportu = function () {
    var ciasteczko = new Cookie("firmadoimportu");
    ciasteczko.value = encodeURIComponent($('#IMPfirmauser').val());
    ciasteczko.save();
    $('#zaladuj').show();
};

var uploadfile_uzyt_grupa = function () {
    $("#ajax_sun").puidialog({
        height: 67,
        width: 150,
        resizable: false,
        closable: false,
        modal: true
    });
    $("#ajax_sun").puidialog('show');
     $.ajax({
        type: "POST",
        url: "upload_uzytkownik_grupa.php",
        cache: false,
        success: function(result){
            $("#ajax_sun").puidialog('hide');
            $('#glownydiv').empty();
            $('#notify').puigrowl('show', [{severity: 'info', summary: 'Udało się nanieść zmiany w upgrupy.'}]);
            var odpowiedz = "<p style=\"color:blue;font-size:large;\">Udało się nanieść zmiany dla: </p>";
            var tabela = JSON.parse(result);
            var sukces = tabela[0];
            var niesukces = tabela[1];
            var i = 1;
            sukces.forEach(function (item) {
                odpowiedz = odpowiedz+"<p>"+i+" "+item+"</p>";
                i++;
            });
            odpowiedz = odpowiedz+"<br/>";
            odpowiedz = odpowiedz+"<p style=\"color:red;font-size:large;\">Nieudało się nanieść zmiany dla: </p>";
            var i = 1;
            niesukces.forEach(function (item) {
                odpowiedz = odpowiedz+"<p>"+i+" "+item+"</p>";
                i++;
            });
            $("#glownydiv").append(odpowiedz);
            //window.location.href = "admin112014_uzytkownik_grupy.php";
        },
        error: function(xhr, status, error) { 
            $('#notify').puigrowl('show', [{severity: 'error', summary: 'Nie udało się nanieśc upoważnień.'}]);
        },
    });
}


