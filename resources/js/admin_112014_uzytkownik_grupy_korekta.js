$(document).ready(function () {
    MYAPP.liczbazmian =  0;
    var notf = $('#notify').puinotify({
        easing: 'easeInOutCirc',
        position: 'bottom'
    })
    $('#aktywnafirma').puidropdown({
        filter: true,
        scrollHeight: 400,
        filterMatchMode: "contains",//a
        change: function (e) {
            wybierzaktywnafirme();
            $(notf).hide();
        },
        data: function (callback) {
            $.ajax({
                type: "POST",
                url: "pobierzfirmyJson_122019_korekta.php",
                dataType: "json",
                context: this,
                success: function (response) {
                    callback.call(this, response);
                }
            });
        }
    });
    $("#ajax_sun").puidialog({
        height: 120,
        width: 200,
        resizable: false,
        closable: false,
        modal: true
    });
   
    $('#warunek0').puidropdown({
        change: function (e) {
         wybierzaktywnafirme();
         $(notf).hide();
        },
        style: {
            "width": "540px;"
        }
     });
      $('#warunek').puidropdown({
        change: function (e) {
         wybierzaktywnafirme();
         $(notf).hide();
        },
        style: {
            "width": "540px;"
        }
     });
     $('#warunek1').puidropdown({
        change: function (e) {
         wybierzaktywnafirme();
         $(notf).hide();
        },
        style: {
            "width": "540px;"
        }
     });
     $('#warunek2').puidropdown({
        change: function (e) {
         wybierzaktywnafirme();
         $(notf).hide();
        },
        style: {
            "width": "540px;"
        }
     });
     
    $('#warunek0div').hide();
    $('#warunekdiv').hide();
    $('#warunek1div').hide();
    $('#warunek2div').hide();
    $('#grupastaradiv').hide();
    $('#szczalki').hide();
    $('#przeniesbutton').hide();
    $('#grupanowadiv').hide();
    $('#polegorne').mouseover(function() {
        let nazwafirmy1 = $("#aktywnafirma").val();
        if (nazwafirmy1 === "wybierz bieżącą firmę do korekty") {
            $(notf).show();
        };
    });
    podswietlmenu(rj('menuupowaznieniagrupa'));
});


var tableinit2 = function (uTable) {
    $(":input:not(:checkbox):not(:button)").puiinputtext();
};


var wybierzaktywnafirme = function () {
    var nazwafirmy = $("#aktywnafirma").val();
    MYAPP.nazwafirmy = nazwafirmy;
    if (nazwafirmy !== "wybierz bieżącą firmę do korekty") {
        var jakiegrupy = document.getElementById("warunek0").value;
        var bezgrup = document.getElementById("warunek").value;
        var uczestnicyrodzaj = document.getElementById("warunek1").value;
        var stacjonarnionline = document.getElementById("warunek2").value;
        var teststring = "firmanazwa=" + nazwafirmy + "&bezgrup=" +bezgrup + "&uczestnicyrodzaj=" +uczestnicyrodzaj+ "&stacjonarnionline=" +stacjonarnionline+ "&jakiegrupy=" +jakiegrupy;
        $("#ajax_sun").puidialog('show');
        $.ajax({
            type: "POST",
            url: "pobierzuczestnicy_122019_korekta.php",
            data: teststring,
            cache: false,
            error: function (xhr, status, error) {
                $('#notify').puigrowl('show', [{severity: 'error', summary: 'Nie udało się pobrać grup firmy.'}]);
                $("#ajax_sun").puidialog('hide');
            },
            success: function (response) {
                try {
                    var tablice = $.parseJSON(decodeURIComponent(response));
                    MYAPP.tablice = tablice;
                    $('#tabuser').remove();
                    $('#tabuser_wrapper').remove();
                    var contener = "<table id=\"tabuser\" class=\"context-menu-one box menu-1\"  style=\"margin: 0px; \"></table>";
                    $('#tbl').find("#komunikatobraku").remove();
                    $('#tbl').append(contener);
                    if (tablice[0].length > 0) {
                        $('#notify').puigrowl('show', [{severity: 'info', summary: 'Uczestnicy z firmy  ' + nazwafirmy}]);
                        var uTable = $('#tabuser').dataTable({
                            "bDestroy": true,
                            "bJQueryUI": true,
                            "sPaginationType": "full_numbers",
                            "aoColumns": nazwykolumnagrupa(tablice[0]),
                            "keys": true,
                            "select": "single",
                            "language": {
                                "url": "resources/dataTableNew/Polish.json"
                            },
                            "drawCallback": function( settings ) {
                                tableinit2(uTable);
                            }
                        });
                        uTable.fnAddData(tablice[1]);
                        uTable.fnSort([[1, 'asc']]);
                        podswietlmenu(rj('menuupowaznieniagrupa'));
                        //tableinit2(uTable);
                        // Add event listener for opening and closing details
                        $(uTable).addClass("compact");
                        $(uTable).on( 'search.dt', function () {
                            wycentruj('#tabuser');
                        } );
                        $('#tabuser tbody').on('click', 'td.details-control', function () {
                            var tr = $(this).closest('tr');
                            var row = uTable.api().row(tr);
                            var id_uz = row.data()[1];
                            $.ajax({
                                type: "POST",
                                url: "pobierzuczestnik.php",
                                data: "id=" + id_uz,
                                context: this,
                                success: function (response) {
                                    var tab = $.parseJSON(response);
                                    if (row.child.isShown()) {
                                        // This row is already open - close it
                                        row.child.hide();
                                        tr.removeClass('shown');
                                    } else {
                                        // Open this row
                                        row.child(format(tab)).show();
                                        tr.addClass('shown');
                                    }
                                }
                            });
                        });
                        wycentruj('#tabuser');
                        var zwrotgrupy = new Array();
                        zwrotgrupy.push("wybierz grupę nieprawidłową");
                        for (var i = 0; i < tablice[0].length; i++) {
                            o1 = tablice[0][i].nazwagrupy;
                            zwrotgrupy.push(o1);
                        }
                        var zwrotgrupy2 = new Array();
                        zwrotgrupy2.push("wybierz grupę docelową");
                        for (var i = 0; i < tablice[0].length; i++) {
                            o1 = tablice[0][i].nazwagrupy;
                            zwrotgrupy2.push(o1);
                        }
                        $('#grupastara').puidropdown({
                            data: zwrotgrupy,
                            change: function (e) {
                                document.getElementById("wiadomoscprzeniesienie").innerHTML="Wybierz grupę docelową";
                                $('#notify').puigrowl('show', [{severity: 'info', summary: 'Wybrano grupę do usunięcia'}]);
                            },
                            style: {
                                "width": "540px;"
                            }
                         });
                         $('#grupanowa').puidropdown({
                            data: zwrotgrupy2,
                            change: function (e) {
                                document.getElementById("wiadomoscprzeniesienie").innerHTML="Wciśnij przycisk: przenieś";
                                $('#notify').puigrowl('show', [{severity: 'info', summary: 'Wybrano grupę docelową'}]);
                            },
                            style: {
                                "width": "540px;"
                            }
                         });
                          
                    }
                    $("#ajax_sun").puidialog('hide');
                    $('#warunek0div').show();
                    $('#warunekdiv').show();
                    $('#warunek1div').show();
                    $('#warunek2div').show();
                    $('#szczalki').show();
                    $('#przeniesbutton').show();
                    $('#grupastaradiv').show();
                    $('#grupanowadiv').show();
                    while ($('#komunikatobraku').length) {
                        $('#komunikatobraku').remove();
                    }
                    
                } catch (e) {
                    $("#ajax_sun").puidialog('hide');
                    $('#tabuser').remove();
                    $('#tabuser_wrapper').remove();
                    var info = teststring.replace(/\&/g," ");
                    $('#tbl').append("<p id='komunikatobraku' name='komunikatobraku' style='color: red'><span> Żaden rekord nie spełnia warunków zapytania: "+info+"</span></p>");
                }
               
            }
        });
    } else {
        $('#tabuser').remove();
        $('#tabuser_wrapper').remove();
        $('#tbl').find("#komunikatobraku").remove();
        $('#warunek0div').hide();
        $('#warunekdiv').hide();
        $('#warunek1div').hide();
        $('#warunek2div').hide();
        $('#szczalki').hide();
        $('#przeniesbutton').hide();
        $('#grupastaradiv').hide();
        $('#grupanowadiv').hide();
    }
};

var wycentruj = function(tabela) {
    var czekboksy = $(tabela).find(".czekgrupy");
    $.each(czekboksy, function() {
        var par = $(this).parent();
        par.css("text-align", "center");
    });
};

var format = function (d) {
    var nazwaszkolenia = d['nazwaszkolenia'];
    var ilosclogowan = d['ilosclogowan'];
    var ip = d['iplogowania'];
    var sessionstart = d['sessionstart'] !== null ? d['sessionstart'] : "nie rozpoczęto";
    var sessionend = d['sessionend'] !== null ? d['sessionend'] : "nie zakończono";
    var utworzony = d['utworzony'] !== null ? d['utworzony'] : "brak danych";
    var zmodyfikowany = d['zmodyfikowany'] !== null ? d['zmodyfikowany'] : "brak danych";
    var wyniktestu = d['wyniktestu'] !== null ? d['wyniktestu'] : "brak danych";
    var poprawne = d['iloscpoprawnych'] !== null ? d['iloscpoprawnych'] : "";
    var bledne = d['iloscblednych'] !== null ? d['iloscblednych'] : "";
    var ogolem = d['iloscodpowiedzi'] !== null ? d['iloscodpowiedzi'] : "";
    var dataostatniegologowania = d['dataostatniegologowania'] !== null ? d['dataostatniegologowania'] : "";
    var ostatnireset = d['ostatnireset'] !== null ? d['ostatnireset'] : "nieresetowany";
    var wcisnietyklawisz = d['wcisnietyklawisz'] !== null ? d['wcisnietyklawisz'] : "nie";
    
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
            '<tr>' +
            '<td>szkolenie:</td>' +
            '<td>' + nazwaszkolenia + '</td>' +
            '<td>ip logowania</td>' +
            '<td>' + ip + '</td>' +
            '<td>ilość logowań</td>' +
            '<td>' + ilosclogowan + '</td>' +
            '<td>ostatnie logowanie</td>' +
            '<td>' + dataostatniegologowania +'</td>' +
            '</tr>' + 
            '<tr>' +
            '<td>rozpoczeto</td>' +
            '<td>' + sessionstart + '</td>' +
            '<td>zakończono</td>' +
            '<td>' + sessionend + '</td>' +
            '<td>utworzono w bazie</td>' +
            '<td>' + utworzony + '</td>' +
            '<td>zmodyfikowano dane</td>' +
            '<td>' + zmodyfikowany + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>wynik testu</td>' +
            '<td>' + wyniktestu + '</td>' +
            '<td>odpowiedzi: ogół/dobre/złe</td>' +
            '<td>' + ogolem + '/'+ poprawne + '/' + bledne +'</td>' +
            '<td>ostatni reset</td>' +
            '<td>' + ostatnireset + '</td>' +
            '<td>wciśnięto generowanie</td>' +
            '<td>' + wcisnietyklawisz + '</td>' +
            '</tr>' +
            '</table>';
};

var isDataTable = function () {
    var ex = document.getElementById('tabuser');
    if ($.fn.DataTable.fnIsDataTable(ex)) {
        return true;
    }
    return false;
};

var nazwykolumnagrupa = function (tablica) {
    var zwrot = new Array();
    var o0 = {"sTitle": "",
        "className": 'details-control',
        "orderable": false,
        "data": null,
        "defaultContent": ''
    };
    zwrot.push(o0);
    var o1 = {"sTitle": "id"};
    zwrot.push(o1);
    o1 = {"sTitle": "email"};
    zwrot.push(o1);
    o1 = {"sTitle": "imię i nazwisko", "sWidth": "200px"};
    zwrot.push(o1);
    o1 = {"sTitle": "nr upoważnienia"};
    zwrot.push(o1);
    o1 = {"sTitle": "identyfikator"};
    zwrot.push(o1);
    o1 = {"sTitle": "data nadania"};
    zwrot.push(o1);
    o1 = {"sTitle": "data ustania"};
    zwrot.push(o1);
    o1 = {"sTitle": "wysłano up."};
    zwrot.push(o1);
    for (var i = 0; i < tablica.length; i++) {
        o1 = {"sTitle": tablica[i].nazwagrupy};
        zwrot.push(o1);
    }
//    o1 = {"sTitle" : "wybierz"};
//    zwrot.push(o1);
//    o1 = {"sTitle" : "edytuj"};
//    zwrot.push(o1);
    return zwrot;
};

var edytujgrupaupowaznien = function () {
    $(MYAPP.pola[0]).html($('#idgrupa').val());
    $(MYAPP.pola[1]).html($('#firmanazwa').val());
    $(MYAPP.pola[2]).html($('#nazwagrupy').val());
    $("#editnazwagrupy").puidialog('hide');
    var teststring = "idgrupa=" + rj("idgrupa").value + "&firmanazwa=" + rj("firmanazwa").value + "&nazwagrupy=" + rj("nazwagrupy").value;
    $.ajax({
        type: "POST",
        url: "editnazwagrupy_112014.php",
        data: teststring,
        cache: false,
        error: function (xhr, status, error) {
            $('#notify').puigrowl('show', [{severity: 'error', summary: 'Nie udało się zmienić danych użytkownika.'}]);
        },
        success: function (response) {
            $('#notify').puigrowl('show', [{severity: 'info', summary: 'Edytowano nowego użytkownika'}]);
        }

    });
};



var porzadkujgrupy = function() {
    var stara = $("#grupastara").val();
    var nowa = $("#grupanowa").val();
    if (stara===nowa) {
        usunduplikat(stara);
    } else {
        przesundogrupy(stara, nowa)
    }
};

var usunduplikat = function(grupa) {
    document.getElementById("wiadomoscprzeniesienie").innerHTML="Wybrano te same grupy";
    $('#notify').puigrowl('show', [{severity: 'info', summary: 'Wybrano te same grupy '+grupa}]);
};

var przesundogrupy = function(stara,nowa) {
    var nazwafirmy = $("#aktywnafirma").val();
    MYAPP.nazwafirmy = nazwafirmy;
    var teststring = "firma=" + nazwafirmy + "&stara=" + stara + "&nowa=" + nowa;
    if (nazwafirmy !== "wybierz bieżącą firmę do korekty") {
        $.ajax({
        type: "POST",
        url: "przesundogrupy_122019.php",
        data: teststring,
        cache: false,
        error: function (xhr, status, error) {
            $('#notify').puigrowl('show', [{severity: 'error', summary: 'Nie udało się zamienić grup.'}]);
        },
        success: function (response) {
            response = response.trim();
            if (response=="0") {
                wybierzaktywnafirme();
                $('#notify').puigrowl('show', [{severity: 'info', summary: 'Przesunięto uczestników do właściwej grupy'}]);
                document.getElementById("wiadomoscprzeniesienie").innerHTML="Przesunięto uczestników do właściwej grupy";
            } else {
                $('#notify').puigrowl('show', [{severity: 'error', summary: 'Nieprzesunięto wszystkich uczestników do właściwej grupy'}]);
            }
        }

    });
    }
};

function getCookie(name){
  var str = '; '+ document.cookie +';';
  var index = str.indexOf('; '+ escape(name) +'=');
  if (index != -1) {
    index += name.length+3;
    var value = str.slice(index, str.indexOf(';', index));
    return unescape(value);
  }
};





