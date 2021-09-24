<?php

namespace DebitCredit\Handler;

use DebitCredit\Config\Constants;

class Helper
{
    /**
     * Show the View of Upload file.
     *
     * @param  float $value
     * @param  int $places
     *  set value in csv array
     * @return float value
     */
    public function round_up(float $value, $places = 0)
    {
        if ($places < 0) {
            $places = 0;
        }
        $mult = pow(10, $places);
        return ceil($value * $mult) / $mult;
    }

    public function currency_convert()
    {
        // set API Endpoint, access key, required parameters
        $endpoint = 'historical';
        $access_key = Constants::$CURRENCY_ACCESS_KEY;

        // $from = 'EUR';
        // $to = $currency;
        // $amount = 10;

        // initialize CURL: http://api.currencylayer.com/historical?access_key=3e521a883c3fd3297e5938c0ecf94e96&date=2010-09-23&currencies=USD,AUD,CAD,PLN,MXN&format=1
        $ch = curl_init('http://api.currencylayer.com/' . $endpoint . '?access_key=' . $access_key . '&date=' . date("Y-m-d") . '&currencies=EUR,USD,JPY&format=1');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // get the (still encoded) JSON data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $conversionResult = json_decode($json, true);

        // access the conversion result
        // var_dump( $conversionResult);
        echo "<pre>";
        echo json_encode($conversionResult, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        echo "</pre>";
    }
}
