<?php

/*

Copyright (C) 2002-2004 Ryan C. Creasey. All rights reserved. 
Copyright (C) 2004 Samuel J. Greear. All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions
are met:
1. Redistributions of source code must retain the above copyright
   notice, this list of conditions and the following disclaimer.
2. Redistributions in binary form must reproduce the above copyright
   notice, this list of conditions and the following disclaimer in the
   documentation and/or other materials provided with the distribution.

THIS SOFTWARE IS PROVIDED BY AUTHOR AND CONTRIBUTORS ``AS IS'' AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
ARE DISCLAIMED.  IN NO EVENT SHALL AUTHOR OR CONTRIBUTORS BE LIABLE
FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS
OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY
OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
SUCH DAMAGE.

$Id: $

*/

class Paypal {

    var $BasicInfo;
    var $AdvancedCustomInfo;
    var $CartInfo;
    var $TransactionInfo;
    var $CurrencyExchangeInfo;
    var $AuctionInfo;
    var $BuyerInfo;
    var $IPNInfo;
    var $SecurityInfo;
    var $MassPayInfo; // Unused
    var $SubscriptionInfo; // Unused

    var $PostString;

    var $Application;
    var $Database;

    function __construct($application) {
        $this->Application = $application;
        $this->Database = $this->Application->database;
    }

    function GetInfo() {
        foreach ($_POST as $key => $value)  {
            $this->PostString .= $key . "=" . $value . "&";
        }
        $this->PostString .= "cmd=_notify-validate";

        $c = curl_init();

        curl_setopt($c, CURLOPT_URL,"https://www.paypal.com/cgi-bin/webscr");
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $this->PostString);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);

        $CurlResult = curl_exec($c);
        curl_close($c);

        if ($curl_result == 'VERIFIED') {
            $this->GetBasicInfo();
            $this->GetAdvancedCustomInfo();
            $this->GetCartInfo();
            $this->GetTransactionInfo();
            $this->GetCurrencyExchangeInfo();
            $this->GetAuctionInfo();
            $this->GetBuyerInfo();
            $this->GetIPNInfo();
            $this->GetSecurityInfo();
            return true;
        } else {
            return false;
        }
    }

    function GetBasicInfo() {
        $this->BasicInfo['business'] = $_POST['business'];
        $this->BasicInfo['receiver_email'] = $_POST['receiver_email'];
        $this->BasicInfo['receiver_id'] = $_POST['receiver_id'];
        $this->BasicInfo['item_name'] = $_POST['item_name'];
        $this->BasicInfo['item_number'] = $_POST['item_number'];
        $this->BasicInfo['quantity'] = $_POST['quantity'];
    }

    function GetAdvancedCustomInfo() {
        $this->AdvancedCustomInfo['invoice'] = $_POST['invoice'];
        $this->AdvancedCustomInfo['custom'] = $_POST['custom'];
        $this->AdvancedCustomInfo['memo'] = $_POST['memo'];
        $this->AdvancedCustomInfo['note'] = $_POST['note'];
        $this->AdvancedCustomInfo['tax'] = $_POST['tax'];
    }

    function GetCartInfo() {
        for ($i = 1; ; ++$i) {
            $str = "option_name" . $i;
            if (isset($_POST[$str]))
                $this->CartInfo[$str] = $_POST[$str];
        }

        for ($i = 1; ; ++$i) {
            $str = "option_selection" . $i;
            if (isset($_POST[$str]))
                $this->CartInfo[$str] = $_POST[$str];
        }

        for ($i = 1; ; ++$i) {
            $str = "mc_gross_" . $i;
            if (isset($_POST[$str]))
                $this->CartInfo[$str] = $_POST[$str];
        }

        for ($i = 1; ; ++$i) {
            $str = "mc_handling" . $i;
            if (isset($_POST[$str]))
                $this->CartInfo[$str] = $_POST[$str];
        }

        for ($i = 1; ; ++$i) {
            $str = "mc_shipping" . $i;
            if (isset($_POST[$str]))
                $this->CartInfo[$str] = $_POST[$str];
        }

        $this->CartInfo['num_cart_items'] = $_POST['num_cart_items'];
        $this->CartInfo['tax'] = $_POST['tax'];
    }

    function GetTransactionInfo() {
        $this->TransactionInfo['payment_status'] = $_POST['payment_status'];
        $this->TransactionInfo['pending_reason'] = $_POST['pending_reason'];
        $this->TransactionInfo['reason_code'] = $_POST['reason_code'];
        $this->TransactionInfo['payment_date'] = $_POST['payment_date'];
        $this->TransactionInfo['txn_id'] = $_POST['txn_id'];
        $this->TransactionInfo['parent_txn_id'] = $_POST['parent_txn_id'];
        $this->TransactionInfo['tx_type'] = $_POST['txn_type'];
        $this->TransactionInfo['payment_type'] = $_POST['payment_type'];
    }

    function GetCurrencyExchangeInfo() {
        for ($i = 1; ; ++$i) {
            $str = "mc_handling" . $i;
            if (isset($_POST[$str]))
                $this->CurrencyExchangeInfo[$str] = $_POST[$str];
        }

        for ($i = 1; ; ++$i) {
            $str = "mc_shipping" . $i;
            if (isset($_POST[$str]))
                $this->CurrencyExchangeInfo[$str] = $_POST[$str];
        }

        $this->CurrencyExchangeInfo['mc_gross'] = $_POST['mc_gross'];
        $this->CurrencyExchangeInfo['mc_fee'] = $_POST['mc_fee'];
        $this->CurrencyExchangeInfo['mc_currency'] = $_POST['mc_currency'];
        $this->CurrencyExchangeInfo['settle_amount'] = $_POST['settle_amount'];
        $this->CurrencyExchangeInfo['settle_currency'] = $_POST['settle_currency'];
        $this->CurrencyExchangeInfo['exchange_rate'] = $_POST['exchange_rate'];
        $this->CurrencyExchangeInfo['payment_gross'] = $_POST['payment_gross'];
        $this->CurrencyExchangeInfo['payment_fee'] = $_POST['payment_fee'];
    }

    function GetAuctionInfo() {
        $this->AuctionInfo['for_auction'] = $_POST['for_auction'];
        $this->AuctionInfo['auction_buyer_id'] = $_POST['auction_buyer_id'];
        $this->AuctionInfo['auction_closing_date'] = $_POST['auction_closing_date'];
        $this->AuctionInfo['auction_multi_item'] = $_POST['auction_multi_item'];
    }

    function GetBuyerInfo() {
        $this->BuyerInfo['first_name'] = $_POST['first_name'];
        $this->BuyerInfo['last_name'] = $_POST['last_name'];
        $this->BuyerInfo['payer_business_name'] = $_POST['payer_business_name'];
        $this->BuyerInfo['address_name'] = $_POST['address_name'];
        $this->BuyerInfo['address_street'] = $_POST['address_street'];
        $this->BuyerInfo['address_city'] = $_POST['address_city'];
        $this->BuyerInfo['address_state'] = $_POST['address_state'];
        $this->BuyerInfo['address_zip'] = $_POST['address_zip'];
        $this->BuyerInfo['address_country'] = $_POST['address_country'];
        $this->BuyerInfo['address_status'] = $_POST['address_status'];
        $this->BuyerInfo['payer_email'] = $_POST['payer_email'];
        $this->BuyerInfo['payer_id'] = $_POST['payer_id'];
        $this->BuyerInfo['payer_status'] = $_POST['payer_status'];
    }

    function GetIPNInfo() {
        $this->IPNInfo['notify_version'] = $_POST['notify_version'];
    }

    function GetSecurityInfo() {
        $this->SecurityInfo['verify_sign'] = $_POST['verify_sign'];
    }
}

?>
