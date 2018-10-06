
<div style="box-shadow: 10px 10px 5px #888; padding: 30px;  margin-top: 10px; background-color: gainsboro;">
    <style>
        .ui-autocomplete {
            max-height: 300px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
         }
     </style>
    <form id="tabelauserow" method="post">
        <span>pobierz po nazwisku</span>
        <input id="szukacnazwisko" name="szukacnazwisko" type="text" style="width: 200px;"/>
        <span>pobierz po email</span>
        <input id="szukacmail" name="szukacmail" type="text" style="width: 200px;"/>
        <span>pobierz po firmie</span>
        <input id="szukacfirma" name="szukacfirma" type="text" style="width: 200px;"/>
        <span>aktywni/nieaktywni</span>
        <select id="szukacwarunek" name="szukacwarunek">
            <option value="0">wszyscy</option>
            <option value="1">aktywni</option>
            <option value="2">nieaktywni</option>
         </select>
        <span>stacjonarni/online</span>
         <select id="warunek2" name="warunek2" >
            <option selected="wszyscy">wszyscy</option>
            <option value="stacjonarni">stacjonarni</option>
            <option value="online">online</option>
        </select>
        <div id="tbl" style="max-width: 1465px;">
<!--            nie ma tabeli, jest generowana w całości-->
        </div>
    </form>
</div>

<div id="ajax_sun" title="trwa przetwarzanie" style="text-align: center" >
    <img src="/images/ajax_loaderc.gif" alt="ajax" height="70" width="70">
</div>
