$(document).ready(function () {
    $("#ajax_sun").puidialog({
        height: 120,
        width: 200,
        resizable: false,
        closable: false,
        location: 'center',
        modal: true
    });
    podswietlmenu(rj('menubackup'));
    $("#potwierdz").puibutton();
    var uTable = $('#tab1').dataTable(
        {
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "keys": true,
            "select": "single",
            "language": {
                "url": "resources/dataTableNew/Polish.json"
            },
            "dom": 'lfrBtip',
            "buttons": [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4'
                }
            ]
        }
    );
    $('#tab1').addClass("compact");
    uTable.fnSort([[3, 'desc']]);
    var uTable1 = $('#tab2').dataTable(
        {
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "keys": true,
            "select": "single",
            "language": {
                "url": "resources/dataTableNew/Polish.json"
            },
            "dom": 'lfrBtip',
            "buttons": [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4'
                }
            ]
        }
    );
    $('#tab2').addClass("compact");
    uTable1.fnSort([[1, 'asc']]); 
    $('#tab1').addClass("compact");
    uTable.fnSort([[3, 'desc']]); 
    var uTable2 = $('#tab3').dataTable(
        {
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "keys": true,
            "select": "single",
            "language": {
                "url": "resources/dataTableNew/Polish.json"
            },
            "dom": 'lfrBtip',
            "buttons": [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4'
                }
            ]
        }
    );
    $('#tab3').addClass("compact");
    uTable2.fnSort([[4, 'desc']]); 
});
var archiwizuj = function () {
    $("#pole1").show();
    $("#pole2").hide();
    $("#ajax_sun").show();
    $.ajax({
        type: "POST",
        url: "databasebackup.php",
        cache: false,
        timeout: 300000, // sets timeout for the request
        error: function (xhr, status, error) {
            alert('Error: ' + xhr.status + ' - ' + error);
        },
        success: function (response) {
            $("#pole2").show();
            $("#ajax_sun").hide();
        }
    });
};