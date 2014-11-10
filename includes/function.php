<?php
function wogo_get_currency( $currency = '' ) {

    switch ($currency) {
        case 'BRL' :
            $symbol = '&#82;&#36;';
            break;
        case 'AUD' :
        case 'CAD' :
        case 'MXN' :
        case 'NZD' :
        case 'HKD' :
        case 'SGD' :
        case 'USD' :
            $symbol = '&#36;';
            break;
        case 'EUR' :
            $symbol = '&euro;';
            break;
        case 'CNY' :
        case 'RMB' :
        case 'JPY' :
            $symbol = '&yen;';
            break;
        case 'KRW' : $symbol = '&#8361;';
            break;
        case 'TRY' : $symbol = '&#84;&#76;';
            break;
        case 'NOK' : $symbol = '&#107;&#114;';
            break;
        case 'ZAR' : $symbol = '&#82;';
            break;
        case 'CZK' : $symbol = '&#75;&#269;';
            break;
        case 'MYR' : $symbol = '&#82;&#77;';
            break;
        case 'DKK' : $symbol = '&#107;&#114;';
            break;
        case 'HUF' : $symbol = '&#70;&#116;';
            break;
        case 'IDR' : $symbol = 'Rp';
            break;
        case 'INR' : $symbol = '&#8377;';
            break;
        case 'ILS' : $symbol = '&#8362;';
            break;
        case 'PHP' : $symbol = '&#8369;';
            break;
        case 'PLN' : $symbol = '&#122;&#322;';
            break;
        case 'SEK' : $symbol = '&#107;&#114;';
            break;
        case 'CHF' : $symbol = '&#67;&#72;&#70;';
            break;
        case 'TWD' : $symbol = '&#78;&#84;&#36;';
            break;
        case 'THB' : $symbol = '&#3647;';
            break;
        case 'GBP' : $symbol = '&pound;';
            break;
        case 'RON' : $symbol = 'lei';
            break;
        default : $symbol = '';
            break;
    }

    return $symbol;
}