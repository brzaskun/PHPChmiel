/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    podswietlmenu(rj('menuuzytkownicy'));
    $('#notify').puigrowl({
        life: 6000
    });
    $('.ui-listbox').css("width",400);
    $('#aktywnafirma').puidropdown({
            filter: true,
            scrollHeight: 400,
            filterMatchMode: "contains",
            change: function (e) {
                $('#pracownicyfirma').show();
                przetworzuczestnicy();
             },
            data: function (callback) {
                $.ajax({
                    type: "POST",
                    url: "pobierzfirmyJsonprzenies_022019.php",
                    dataType: "json",
                    context: this,
                    success: function (response) {
                        callback.call(this, response);
                    }
                });
            }
        });
        $('#aktywnafirma2').puidropdown({
            filter: true,
            scrollHeight: 400,
            filterMatchMode: "contains",
            change: function (e) {
                $('#pracownicyfirma2').show();
                $('#buttonzachowaj').show();
                przetworzuczestnicy2();
            },
            data: function (callback) {
                $.ajax({
                    type: "POST",
                    url: "pobierzfirmyJsonprzenies_022019.php",
                    dataType: "json",
                    context: this,
                    success: function (response) {
                        callback.call(this, response);
                    }
                });
            }
        });
    });
    
var przetworzuczestnicy = function() {
    var firm = $('#aktywnafirma').val();
    var uczestnicyrodzaj = "wszyscy";
    $.ajax({
        type: "POST",
        data: "firmanazwa="+firm+"&uczestnicyrodzaj="+uczestnicyrodzaj,
        url: "pobierzuczestnicyprzenoszenie_022019.php",
        dataType: "json",
        context: this,
        success: function (response) {
            przetworz('#pracownicyfirma',response);
            $('#notify').puigrowl('show', [{severity: 'info', summary: 'Pobrano użytkowników'}]);
        }
    });
}

var przetworzuczestnicy2 = function() {
    var firm = $('#aktywnafirma2').val();
    var uczestnicyrodzaj = "wszyscy";
    $.ajax({
        type: "POST",
        data: "firmanazwa="+firm+"&uczestnicyrodzaj="+uczestnicyrodzaj,
        url: "pobierzuczestnicyprzenoszenie_022019.php",
        dataType: "json",
        context: this,
        success: function (response) {
            przetworz('#pracownicyfirma2',response);
            $('#notify').puigrowl('show', [{severity: 'info', summary: 'Pobrano użytkowników'}]);
        }
    });
}

var przetworz = function(lista,response) {
    $(lista).empty();
    response.forEach(function (item){
       $(lista).append('<option value="'+item[1]+'">'+item[0]+'</option>');
    });
};

var zachowajprzesuniecie = function() {
    var firmalewa = $("#aktywnafirma option:selected").val();
    var firmaprawa = $("#aktywnafirma2 option:selected").val();
    var opcjelewe = JSON.stringify(pobierzopcje("pracownicyfirma"));
    var opcjeprawe = JSON.stringify(pobierzopcje("pracownicyfirma2"));
    $.ajax({
        type: "POST",
        data: "firmanazwa="+firmalewa+"&uczestnicy="+opcjelewe,
        url: "edituserprzenies_022019.php",
        dataType: "json",
        context: this,
    });
    $.ajax({
        type: "POST",
        data: "firmanazwa="+firmaprawa+"&uczestnicy="+opcjeprawe,
        url: "edituserprzenies_022019.php",
        dataType: "json",
        context: this,
    });
    $('#notify').puigrowl('show', [{severity: 'info', summary: 'Zachowano użytkowników'}]);
};

var pobierzopcje = function (lista) {
    var x = document.getElementById(lista);
    var i;
    var j = x.length;
    var tab = new Array();
    for (i = 0; i < j; i++) {
        var subtab = new Array();
        subtab.push(x.options[i].text);
        subtab.push(x.options[i].value);
        tab.push(subtab);
    }
    return tab;
}
