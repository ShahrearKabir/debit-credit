<?php

namespace DebitCredit\Cash;

use DebitCredit\Config\Constants;
use DebitCredit\Handler\Helper;

class Deposit
{
    private $depositChargeAmount = 0;

    /**
     * Show the View of Upload file.
     *
     * @param mixed $withdrawTransactionsObject
     *  set value in global deposit variable $DEPOSIT_LIST_USER_WISE
     * @return void
     */
    public function __construct(array $depositTransactionsObject)
    {
        $helper = new Helper();
        // use helper fn for round up decimal
        $depositAmount = $helper->round_up((float)$depositTransactionsObject["amount"], 2);
        
        // Current date wise start & end of the week 
        $getCurrentDate = strtotime($depositTransactionsObject["transactions_date"]);
        $getStartOfWeek = date("Y-m-d", strtotime('monday this week', $getCurrentDate));
        $getEndOfWeek = date("Y-m-d", strtotime('sunday this week', $getCurrentDate));
        
        // Deposit calculation
        $this->depositChargeAmount = ($depositAmount * Constants::$DEPOSIT_CHARGE) / 100;
        $depositTransactionsObject["chargeable_amount"] = $helper->round_up($this->depositChargeAmount, 2);

        // SET Deposit object in global variable
        Constants::$DEPOSIT_LIST_USER_WISE[$depositTransactionsObject["user_id"]][$getStartOfWeek . ":" . $getEndOfWeek][$depositTransactionsObject["transactions_date"]][$depositTransactionsObject["currency"]] = $depositTransactionsObject;
    }
}
