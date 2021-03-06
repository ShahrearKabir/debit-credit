<?php

namespace DebitCredit\Cash;

use DebitCredit\Config\Constants;
use DebitCredit\Handler\Helper;

class Withdraw
{
    private $withdrawChargePercent = 0;

    public function __construct(array $transactionsObject)
    {
        $helper = new Helper();
        // use helper fn for round up decimal
        $withdrawAmount = $helper->round_up((float)$transactionsObject["amount"], 2);

        // user type wise percent assign
        $transactionsObject["user_type"] == "private" ?
            $this->withdrawChargePercent = Constants::$WITHDRAW_CHARGE_PRIVATE :
            $this->withdrawChargePercent = Constants::$WITHDRAW_CHARGE_BUSINESS;

        // Current Date wise weekly calculation
        $result = $this->getWeeklyCalculationByCurrentDate($transactionsObject);

        $this->withdrawChargeAmpunt = ($withdrawAmount * $this->withdrawChargePercent) / 100;

        return $result;
    }

    /**
     * Show the View of Upload file.
     *
     * @param mixed $WITHDRAW_LIST_USER_WISE
     *  set value in global withdraw variable
     * @return void
     */
    public function getWeeklyCalculationByCurrentDate($transactionsObject)
    {
        $helper = new Helper();

        // Get Start & End of the week
        $getCurrentDate = strtotime($transactionsObject["transactions_date"]);
        $getStartOfWeek = date("Y-m-d", strtotime('monday this week', $getCurrentDate));
        $getEndOfWeek = date("Y-m-d", strtotime('sunday this week', $getCurrentDate));

        // Current date wise Start & End date of the week
        $inRange = fn ($transactions_date) => $transactions_date["transactions_date"] >= $getStartOfWeek && $transactions_date["transactions_date"] < $getEndOfWeek;
        // $this->filteredData = array_filter($this->transactionsList, $inRange);

        $weeklyTotalAmount = 0;
        if ($transactionsObject["user_type"] == "private" && isset(Constants::$WITHDRAW_LIST_USER_WISE[$transactionsObject["user_id"]][$getStartOfWeek . ":" . $getEndOfWeek])) {
            // Get Currency from last array
            $lastKey = array_key_last(end(Constants::$WITHDRAW_LIST_USER_WISE[$transactionsObject["user_id"]][$getStartOfWeek . ":" . $getEndOfWeek]));
            // echo ($lastKey) . "<br>";

            // Get last row from array
            $lastRowInfo = end(Constants::$WITHDRAW_LIST_USER_WISE[$transactionsObject["user_id"]][$getStartOfWeek . ":" . $getEndOfWeek])[$lastKey];

            // calculate weekly total amount
            $weeklyTotalAmount = $transactionsObject["amount"] + $lastRowInfo["total_amount"];
            $withdrawTransactionsObject["total_amount"] = $helper->round_up((float)$weeklyTotalAmount, 2);
            
            // calculate weekly day count
            $withdrawTransactionsObject["weekly_count"] = 1 + $lastRowInfo["weekly_count"];

            // Calculation for FREE_MAX_WITHDRAW_AMOUNT & FREE_MAX_WITHDRAW_DAYS_IN_WEEK
            if ($weeklyTotalAmount > Constants::$FREE_MAX_WITHDRAW_AMOUNT || $withdrawTransactionsObject["weekly_count"] > Constants::$FREE_MAX_WITHDRAW_DAYS_IN_WEEK) {

                $total = 0;
                $lastRowInfo["total_amount"] < Constants::$FREE_MAX_WITHDRAW_AMOUNT ? $total = $weeklyTotalAmount - Constants::$FREE_MAX_WITHDRAW_AMOUNT : $total = $weeklyTotalAmount - $lastRowInfo["total_amount"];

                $withdrawTransactionsObject["chargeable_amount"] = $helper->round_up((float)((($total) * $this->withdrawChargePercent) / 100), 2);
            } else {
                $withdrawTransactionsObject["chargeable_amount"] = 0;
            }
        } else if ($transactionsObject["user_type"] == "business") {
            $withdrawTransactionsObject["weekly_count"] = 1;
            $withdrawTransactionsObject["total_amount"] = $helper->round_up((float)$transactionsObject["amount"], 2);

            $withdrawTransactionsObject["chargeable_amount"] = $helper->round_up((float)((($transactionsObject["amount"]) * $this->withdrawChargePercent) / 100), 2);
        } else {
            $withdrawTransactionsObject["weekly_count"] = 1;
            $withdrawTransactionsObject["total_amount"] = $helper->round_up((float)$transactionsObject["amount"], 2);

            // Calculation for Business Withdraw
            if ($transactionsObject["amount"] > Constants::$FREE_MAX_WITHDRAW_AMOUNT || $withdrawTransactionsObject["weekly_count"] > Constants::$FREE_MAX_WITHDRAW_DAYS_IN_WEEK) {
                $withdrawTransactionsObject["chargeable_amount"] = $helper->round_up((float)((($transactionsObject["amount"] - Constants::$FREE_MAX_WITHDRAW_AMOUNT) * $this->withdrawChargePercent) / 100), 2);
            } else {
                $withdrawTransactionsObject["chargeable_amount"] = 0;
            }
        }

        // SET Withdraw object in global variable
        Constants::$WITHDRAW_LIST_USER_WISE[$transactionsObject["user_id"]][$getStartOfWeek . ":" . $getEndOfWeek][$transactionsObject["transactions_date"]][$transactionsObject["currency"]] = array_merge($transactionsObject, $withdrawTransactionsObject);

        $numberFormat = 0;
        switch ($transactionsObject["currency"]) {
            case 'JPY':
                $numberFormat = number_format(((float) $withdrawTransactionsObject["chargeable_amount"] * Constants::$CURRENCY_CONVERSION_API["JPY"]), 2, '.', '');
                break;
            case 'USD':
                $numberFormat = number_format(((float) $withdrawTransactionsObject["chargeable_amount"] * Constants::$CURRENCY_CONVERSION_API["USD"]), 2, '.', '');
                break;
            case 'EUR':
                $numberFormat = number_format(((float) $withdrawTransactionsObject["chargeable_amount"] * Constants::$CURRENCY_CONVERSION_API["EUR"]), 2, '.', '');
                break;
            default:
                $numberFormat = number_format((float) $withdrawTransactionsObject["chargeable_amount"], 2, '.', '');
                break;
        }

        // $numberFormat = number_format((float) $withdrawTransactionsObject["chargeable_amount"], 2, '.', '');
        array_push(Constants::$FINAL_COMISSION, $numberFormat);
        return $numberFormat;
    }
}
