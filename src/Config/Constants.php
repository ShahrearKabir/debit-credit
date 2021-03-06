<?php

namespace DebitCredit\Config;

class Constants
{

    public static $DEPOSIT_CHARGE = 0.03;
    public static $WITHDRAW_CHARGE_PRIVATE = 0.3;
    public static $WITHDRAW_CHARGE_BUSINESS = 0.5;
    public static $FREE_MAX_WITHDRAW_AMOUNT = 1000;
    public static $FREE_MAX_WITHDRAW_DAYS_IN_WEEK = 3;
    public static $OPERATIONS = [
        "transactions_date",
        "user_id",
        "user_type",
        "transactions_type",
        "amount",
        "currency"
    ];
    public static $DEPOSIT_LIST_USER_WISE = array();
    public static $WITHDRAW_LIST_USER_WISE = array();
    public static $FINAL_COMISSION = array();
    public static $CURRENCY_ACCESS_KEY = "a43d96bb9a0d7a311f7c0440150926be";
    public static $CURRENCY_CONVERSION = [ 
        "EUR:EUR" => 1.00, 
        "EUR:USD" => 1.1497, 
        "EUR:JPY" => 129.53,
        "JPY:USD" => 0.0090,
        "USD:USD" => 1.00,
        "JPY:EUR" => 0.0077,
        "USD:EUR" => 0.85,
    ];
    public static $CURRENCY_CONVERSION_API = array();
}
