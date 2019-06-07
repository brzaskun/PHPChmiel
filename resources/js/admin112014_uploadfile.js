/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
    $('#IMPfirmauser').puidropdown({
        filter: true,
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
});

var firmadoimportu = function() {
    var ciasteczko = new Cookie("firmadoimportu");
    ciasteczko.value = encodeURIComponent($('#IMPfirmauser').val());
    ciasteczko.save();
    $('#zaladuj').show();
};

var dataszkoleniazachowaj = function() {
    var ciasteczko = new Cookie("dataszkolenia");
    var re = /^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))$/;
    var testw = $('#dataszkolenia').val();
    if (!testw.match(re)){
        $('#dataszkolenia').val("b\u0142ędna data");
        $('#dataszkolenia').select();
    } else {
        ciasteczko.value = testw.replace(/\./g,"-");
        ciasteczko.save();
        $('#przyciskladowanie').show();
    }
};


