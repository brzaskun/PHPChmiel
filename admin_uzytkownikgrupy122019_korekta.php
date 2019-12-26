<style>
    .selectbar .ui-dropdown {
        width: 250px;
    }
    .selectbar1 .ui-dropdown {
        width: 150px;
    }
</style>
<div style="box-shadow: 10px 10px 5px #888; padding: 20px;  margin-top: 2px; background-color: gainsboro;">
    <div style="width: 500px;height: 30px;"><span style="color: blue; font-weight: 900;height: 30px;" id="wiadomoscprzeniesienie"  >
        </span>
    <form id="tabelauserow" >
        </div>
        <div  class="ui-grid ui-grid-fixed" style="width: 1100px;">
            <div class="ui-grid-row" id="polegorne">
                <div class="ui-grid-col-5 selectbar">
                    <select id="aktywnafirma" name="aktywnafirma"></select>
                </div>
<!--                <div class="ui-grid-col-3" id="warunekdiv">
                    <input id="warunek" type="checkbox" />
                    <span id="waruneklable">użytkownicy bez grup</span>
                </div>--> <div class="ui-grid-col-3 selectbar1" id="warunek0div">
                    <select id="warunek0" name="warunek0">
                        <option selected="grupy" value="tak">wszystkie grupy</option>
                        <option value="nie">tylko dane wrażliwe</option>
                    </select>

                </div>
                 <div class="ui-grid-col-3 selectbar1" id="warunekdiv">
                    <select id="warunek" name="warunek">
                        <option selected="wszyscy" value="wszyscy">z grupami + bez grup</option>
                        <option value="nie">przyporządkowani</option>
                        <option value="tak">nie przyporządkowani</option>
                    </select>

                </div>
                <div class="ui-grid-col-3 selectbar1" id="warunek1div">
                    <select id="warunek1" name="warunek1">
                        <option selected="wszyscy" value="wszyscy">aktywni + archiwalni</option>
                        <option value="aktywni">aktywni</option>
                        <option value="archiwalni">archiwalni</option>
                    </select>

                </div>
                <div class="ui-grid-col-3 selectbar1" id="warunek2div">
                    <select id="warunek2" name="warunek2">
                        <option selected="wszyscy">stacjon. + online</option>
                        <option value="stacjonarni">stacjonarni</option>
                        <option value="online">online</option>
                    </select>

                </div>
                <div class="ui-grid-col-3 selectbar1" id="grupastaradiv" style="margin-left: 20px;">
                    <select id="grupastara" name="grupastara">
                        <option selected>wybierz grupę nieprawidłową</option>
                    </select>
                </div>
                <div id="szczalki"><span style="font-weight: 900; color: blue;margin-left: 5px;margin-right: 5px;"> >>> </span></div>
                <div class="ui-grid-col-3 selectbar1" id="grupanowadiv">
                    <select id="grupanowa" name="grupanowa">
                        <option selected>wybierz grupę docelową</option>
                    </select>
                </div>
                <div class="ui-grid-col-2">
                    <button id="przeniesbutton" type="button" name="przeniesbutton" onclick="porzadkujgrupy()" style="width: 120px; margin-left: 20px;">przenieś</button>
                </div>

<!--                <div class="ui-grid-col-2">

                    <button id="zachowajbutton" type="button" name="zachowajbutton" onclick="pobierzwierszetabeli()" style="width: 120px;">zachowaj</button>
                </div>
                <div class="ui-grid-col-2" >
                    <button id="eksportbutton" type="button" name="eksportbutton" onclick="generujtabeleugxls()" style="width: 120px;">eksport XLS</button>
                </div> -->
            </div>
        </div>
        <div>
            <span id="wiadomosczmiany" style="color: red;"></span>
        </div>
        <div id="tbl" style="width: 1400px; margin-top: 10px;">
            <table id="tabuser" style="margin: 0px; width: 1400px;">
<!--                tu miesci sie tabela z wierszami wygenerowanymi upowaznien-->
            </table>
        </div>
    </form>
</div>
<div id="dialog-user" title="Potwierdzenie" style="display: none;">
    <p>
        <span class="ui-icon ui-icon-circle-check" style="float: left; margin: 0 7px 100px 0;"></span>
        Edycja użytkownika: </p><p><span id="uzytkownikwiadomosc"></span></p><p>zakończona sukcesem</p>
</div>
<div id="ajax_sun" title="przetwarzanie" style="display: none; text-align: center;">
    <img src="/images/ajax_loaderc.gif" alt="ajax" height="70" width="70">;
</div>
<div id="notify"></div>
<!--genialna rzecz sluzaca do otwierania plikow generowancyh przez php przez ajax--> 
<iframe id="iframe" style="display: none;"></iframe> 
