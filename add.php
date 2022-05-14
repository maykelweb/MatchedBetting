<?php
require "config.php";
require "header.php";
require "topNav.php";
?>

<section id="addBetContainer">
<form name="betForm" method="post" id="betForm" action="">
    <div class="form-group">
        <span id="betType" class="col-sm-2 control-label">Bet Type</span>
        <div class="col-sm-5">
            <select name="ddlBetType" id="ddlBetType" class="form-control" onchange="updateLay()">
                <option selected="selected" value="Normal">NORMAL</option>
                <option value="SNR">FREE BET (SNR)</option>
                <option value="SR">FREE BET (SR)</option>
                <option value="RiskFree">RISK FREE</option>
            </select>
            <input type="hidden" name="hf_ddlBetType" id="hf_ddlBetType" value="Normal">
        </div>
    </div>

    <div class="form-group">
        <span id="backStake" title="Enter the amount that you intend to bet at the bookmaker
        This will be the amount of the FREE BET or the QUALIFYING BET" class="col-sm-3 control-label">Back Stake</span>
        <div class="col-sm-3">
            <div class="input-group">
                <span class="input-group-addon ">£</span>
                <input name="txtBookieStake" type="text" id="txtBookieStake" tabindex="1" step="0.01" onmouseup="this.select();" onkeyup="updateLay()" onchange="updateLay()" class="form-control" autocomplete="off" value="">
                <span class="input-group-addon hide">£</span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <span id="lblBackOdds" title="Enter the odds that you will back at the Bookmaker's website" class="col-sm-3 control-label">Back Odds</span>
        <div class="col-sm-3">
            <input name="txtBookieOdds" type="text" id="txtBookieOdds" tabindex="2" step="0.01" onmouseup="this.select();" onkeyup="updateLay()" onchange="updateLay()" class="form-control" autocomplete="off" value="">
        </div>
        <span id="lblBackCommission" title="Enter the Bookmaker's commission - this is usually 0% for most bookmakers" class="col-sm-3 control-label">Back Commission</span>
            <div class="col-sm-3">
                <div class="input-group">
                    <input name="txtBookieComm" type="text" id="txtBookieComm" tabindex="7" step="0.01" onmouseup="this.select();" onkeyup="updateLay()" onchange="updateLay()" class="form-control" autocomplete="off" value="0">
                    <span class="input-group-addon">%</span>
                </div>
                <input type="hidden" name="blBackTax" id="blBackTax" value="0">
            </div>
        </div>
    </div>

    <div class="form-group">
        <span id="lblLayOdds" title="Enter the odds that you will LAY from the Exchange website (Betfair, Smarkets etc)" class="col-sm-3 control-label">Lay Odds</span>
        <div class="col-sm-3">
            <input name="txtExchangeOdds" type="text" id="txtExchangeOdds" tabindex="3" step="0.01" onmouseup="this.select();" onkeyup="updateLay()" onchange="updateLay()" class="form-control exchangeStep" autocomplete="off" value="">
        </div>
        <span id="lblLayCommission" title="Enter your current commission rate at the Exchange (default 5%)" class="col-sm-3 control-label">Lay Commission</span>
        <div class="col-sm-3">
            <div class="input-group">
                <input name="txtExchangeComm" type="text" value="0" id="txtExchangeComm" tabindex="4" step="0.01" onmouseup="this.select();" onkeyup="updateLay()" onchange="updateLay()" class="form-control" autocomplete="off">
                <span class="input-group-addon">%</span>
            </div>
        </div>
    </div>

    <div id="divRiskFreeInput" class="form form-horizontal form-bookmaker" style="display:none">
        <div class="form-group">
            <span id="lblFreeBetAward" title="Enter the risk free amount" class="col-sm-3 control-label">Free Bet Award</span>
            <div class="col-sm-3">
                <div class="input-group">
                    <span class="input-group-addon ">£</span>
                    <input name="txtFreeBetAward" type="text" id="txtFreeBetAward" tabindex="5" step="0.01" onmouseup="this.select();" onkeyup="updateLay()" onchange="updateLay()" class="form-control" autocomplete="off" value="">
                    <span class="input-group-addon hide">£</span>
                </div>
            </div>
            <span id="lblFreeBetRetention" title="The amount you expect to retain from the free bet (normally 80%)" class="col-sm-3 control-label">Free Bet Retention</span>
            <div class="col-sm-3">
                <div class="input-group">
                    <input name="txtFreeBetRetention" type="text" id="txtFreeBetRetention" tabindex="6" step="0.01" onmouseup="this.select();" onkeyup="updateLay()" onchange="updateLay()" class="form-control" autocomplete="off" value="80">
                    <span class="input-group-addon">%</span>
                </div>
            </div>
        </div>
    </div>
</form>
</section>

<?php
require "bottomNav.php";
?>

    