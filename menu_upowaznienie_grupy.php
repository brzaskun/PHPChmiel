<script type="text/javascript">  
    $(document).ready(function() {
        $('#mb1').puimenubar({
            autoDisplay: true
        });  
     });
</script>
<ul id="mb1">
    <li><a data-icon=" ui-icon-person" href="/admin112014_uzytkownicy.php"  style="width: 110px;">Użytkownicy</a></li>
    <li> <a data-icon="ui-icon-suitcase" href="/admin112014_firmy.php"  style="width: 110px;">Firmy</a></li>  
    <li><a data-icon="ui-icon-document" href="/admin112014_szkolenia.php"  style="width: 110px;">Szkolenia</a></li>  
    <li><a data-icon="ui-icon-circle-check" href="/admin112014_testy.php"  style="width: 110px;">Testy</a></li>
    <li  id="menuupowaznieniegrupy"><a data-icon="ui-icon-folder-collapsed" href="/admin112014_uzytkownik_grupy.php"  style="width: 110px;">Up.Grupy</a>
        <ul>   
            <li><a data-icon="ui-icon-plus" onclick="nowanazwagrupy();">Dodaj grupę</a></li>   
            <li><a data-icon="ui-icon-arrowthick-2-e-w" href="/admin112014_uzytkownik_grupy.php">Użytkownik - grupy</a></li>   
        </ul> 
    </li>
    <li><a data-icon="ui-icon-locked" href="/admin082016_all.php"  style="width: 110px;">Duża tabela</a></li>
    <li><a data-icon="ui-icon-locked" href="/admin112014_haslo.php"  style="width: 110px;">Hasło</a></li>
    <li id="menubackup"><a data-icon="ui-icon-suitcase" href="/admin072017_backup.php"  style="width: 110px;">Diagnostyka</a></li>   
    <li id="menuupowaznienia"><a data-icon="ui-icon-suitcase" href="/admin072017_upowaznienia.php"  style="width: 110px;">Upoważnienia</a></li>
    <li id="menuzaswiadczenia"><a data-icon="ui-icon-suitcase" href="/admin062018_zaswiadczenia.php"  style="width: 110px;">Zaświadczenia</a></li>
</ul>  

