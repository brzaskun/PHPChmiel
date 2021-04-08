<?php
error_reporting(0); 
require_once($_SERVER['DOCUMENT_ROOT'] . '/resources/php/Rb.php');
R::setup($_SESSION['host'].'dbname=p6273_odomg', 'p6273_odomg', 'P3rsKy_K@tek1');
$_wynikszkolenia = R::getAll('select * from szkolenieust');
$_wynik_firmaall = R::getAll('SELECT * FROM zakladpracy ORDER BY `zakladpracy`.`nazwazakladu` ASC');
$_szkolenia = R::getAll('select * from szkoleniewykaz');
?>
<div style="box-shadow: 10px 10px 5px #888; padding: 30px; margin-top: 10px; background-color: gainsboro;">
    <form id="tabela" >
        <div id="tbl" style="max-width: 900px;">
<!--            nie ma tabeli, jest generowana w całości-->
        </div>
    </form>
</div>

 <script>
$(document).ready(function () {
    $("#emailust").blur(function () {
        validateeditszkolenie();
    });
});
var validateEmail = function(email) {
    // http://stackoverflow.com/a/46181/11236
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
};
var validateeditszkolenie = function() {
    var email = $("#emailust").val();
    if (validateEmail(email)) {
    } else {
        if (email.length > 1) {
            $("#emailust").val("nieprawidlowy adres email");
            $("#emailust").css("color", "red");
        }
    }
    return false;
};
</script>
<div id='editszkolenieust'  style='margin-top: 10px; display: none;' title="Edytuj szkolenie" onload="">
    <form id="formeditszkolenieust" >
        <table id="tabelaeditszkolenieust"  style="margin-bottom: 15px;" >
            <tbody>
                <tr hidden>
                    <td><span>id: </span></td><td><input type="text" id="idszkolenieust" name="idszkolenieust" style="width: 350px;"></td>
                </tr>
                <tr>
                    <td ><span>nazwa firmy firmy: </span></td><td>
                        <input id="firmaszkoleniaust" name="firmaszkoleniaust" style="width: 240px;" readonly="">
                    </td>
                </tr>
                <tr>
                    <td><span>nazwa szkolenia: </span></td><td>
                        <input id="nazwaszkoleniaust" name="nazwaszkoleniaust" style="width: 240px;" readonly="">
                    </td>
                </tr>
                <tr>
                    <td><span>ilość pytań: </span></td><td><input id="iloscpytanust" name="iloscpytanust" style="width: 40px;"></td>
                </tr>
                <tr>
                    <td><span>email: </span></td><td><input id="emailust" name="emailust" style="width: 240px;"></td>
                </tr>
                 <tr>
                    <td><span>nazwa upoważnienia: </span></td><td>
                        <select id="nazwaupowaznienia" name="nazwaupowaznienia" style="width: 240px;">
                            <option value="standard">standard</option>
                            <option value="sąd">sąd</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><span>próg zdawalności: </span></td><td><input id="progzdawalnosciust" name="progzdawalnosciust" style="width: 40px;"></td>
                </tr>
            </tbody>
        </table>
        <input id="edytujszkolenieust" name="edytujszkolenieust" value="edytuj" type="button" onclick="edytujtabeleszkolenieust();" style="padding: 5px;width: 120px; margin-left: 15%;">
        <input value="rezygnuj" type="button" onclick="canceleditszkolenieust();" style="padding: 5px;width: 120px; margin-left: 5%;">
    </form>
</div>
<div id='newszkolenieust'  style='margin-top: 10px; display: none;'  title="Nowe szkolenie">
    <form id="forminsertszkolenieust">
        <table   style="margin-bottom: 15px;">
            <tr hidden>
                    <td><span>id: </span></td><td><input type="text" id="id" name="id" style="width: 350px;"></td>
            </tr>
            <tr>
                <td><span>nazwa firmy firmy: </span></td><td>
                    <select id="Nfirmaszkoleniaust" name="Nfirmaszkoleniaust" style="width: 250px;">
                        <?php
                        error_reporting(0);
                        foreach ($_wynik_firmaall as $value) {
                            if ($value['firmaaktywna'] == TRUE) {
                                ?>
                                <option value="<?php error_reporting(0);
                        echo $value['nazwazakladu']
                                ?>"><?php error_reporting(0);
                                echo $value['nazwazakladu']
                                ?></option>

                                <?php
                                error_reporting(0);
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><span>nazwa szkolenia: </span></td><td>
                    <select id="Nnazwaszkoleniaust" name="Nnazwaszkoleniaust" style="width: 250px;">
                        <?php
                        error_reporting(0);
                        foreach ($_szkolenia as $value) {
                            ?>
                            <option value="<?php echo $value['nazwa']; ?>"><?php echo $value['nazwa']; ?></option>
    <?php error_reporting(0);
}
?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><span>ilość pytań: </span></td><td><input id="Niloscpytanust" name="Niloscpytanust" style="width: 100px;"></td>
            </tr>
             <tr>
                    <td><span>email: </span></td><td><input id="Nemailust" name="Nemailust" style="width: 240px;"></td>
                </tr>
             <tr>
                    <td><span>nazwa upoważnienia: </span></td><td>
                        <select id="Nnazwaupowaznienia" name="Nnazwaupowaznienia" style="width: 240px;">
                            <option value="standard">standard</option>
                            <option value="sąd">sąd</option>
                        </select>
                    </td>
                </tr>
        </table>
        <input id="Ndodajszkolenieust" name="Ndodajszkolenieust" value="dodaj" type="button" onclick="dodajnoweszkolenieust();"  style="padding: 5px; width: 120px; margin-left: 15%;">
        <input id="rezygnujszkolenie" name="rezygunjszkolenie" value="rezygnuj" type="button" onclick="rezygnujnoweszkolenieust();" style="padding: 5px; width: 120px; margin-left: 15%;">
    </form>
</div>
<div id="dialog_user_usun" title="" style="display: none;">
    <p>Czy napewno usunąć?</p> 
    <input value="tak" style="float: left; margin-left: 4%; width: 120px;" type="button"  onclick="tak_usunwiersz();"/> <input value="nie" type="button" onclick="nie_usunwiersz();" style="float: right; margin-right: 4%; width: 120px;"/>
</div>


