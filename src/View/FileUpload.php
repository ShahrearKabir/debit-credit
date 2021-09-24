<?php

namespace DebitCredit\View;

use DebitCredit\Cash\Deposit;
use DebitCredit\Cash\Withdraw;
use DebitCredit\Config\Constants;
use DebitCredit\Handler\Helper;

class FileUpload
{
    private $csv = array();
    private $transactionsObj;
    private $transactionsList = array();

    public function __construct()
    {
        $this->view();
        // $helper = new Helper();
        // $helper->currency_convert();
    }

    /**
     * 
     * Show the View of Upload file.
     * 
     */
    private function view()
    {
        require_once __DIR__ . './FileUploadView.php';
    }

    /**
     * Show the View of Upload file.
     *
     * @param  mixed $file_tmp
     *  set value in csv array
     * @return void
     */
    public function fileHandleCSV($file_tmp)
    {

        if (($handle = fopen($file_tmp, 'r')) !== FALSE) {
            // necessary if a large csv file
            set_time_limit(0);

            $row = 0;

            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                // number of fields in the csv
                $col_count = count($data);

                // get the values from the csv
                $this->csv[$row]['col1'] = $data[0];
                // inc the row
                $row++;
            }
            fclose($handle);
        }
    }

    /**
     * Show the View of Upload file After all Calculation.
     */
    public function getCSVData()
    {
        $helper = new Helper();
        $getCSVFile = array_values($this->csv);

        foreach ($getCSVFile as $key => $value) {
            $fileData = $value["col1"];
            $splitFileData = explode(',', $fileData);
            $operationsList = Constants::$OPERATIONS;

            foreach ($operationsList as $operation_key => $operation) {
                $this->transactionsObj[$operation] = $splitFileData[$operation_key];
            }

            if ($this->transactionsObj["currency"] == "JPY") {
                $this->transactionsObj["amount"] = $helper->round_up((float)($this->transactionsObj["amount"] / Constants::$CURRENCY_CONVERSION["EUR:JPY"]), 2);
            } 
            else if ($this->transactionsObj["currency"] == "USD") {
                $this->transactionsObj["amount"] = $helper->round_up((float)($this->transactionsObj["amount"] / Constants::$CURRENCY_CONVERSION["EUR:USD"]), 2);
            } 
            else if ($this->transactionsObj["currency"] == "EUR") {
                $this->transactionsObj["amount"] = $helper->round_up((float)($this->transactionsObj["amount"] / Constants::$CURRENCY_CONVERSION["EUR:EUR"]), 2);
            }
            else{
                $this->transactionsObj["amount"] = $helper->round_up((float)($this->transactionsObj["amount"]), 2);
            }

            // $this->transactionsObj["amount"] = $helper->round_up((float)($this->transactionsObj["amount"]), 2);

            array_push($this->transactionsList, $this->transactionsObj);


            if ($this->transactionsObj["transactions_type"] == "deposit") {
                /**
                 * send data for deposit calculation.
                 *
                 * @param  array $transactionsObj
                 * @see  Constant DEPOSIT_LIST_USER_WISE: set value
                 * @return void 
                 */
                new Deposit($this->transactionsObj);
            } else if ($this->transactionsObj["transactions_type"] == "withdraw") {
                /**
                 * send data for Withdraw calculation.
                 *
                 * @param  array $transactionsObj
                 * @param  array $transactionsList
                 * @see  Constant WITHDRAW_LIST_USER_WISE: set value
                 * @return void 
                 */
                new Withdraw($this->transactionsObj, $this->transactionsList);
            }
        }
        echo "<br/>";
        echo '<pre>';
        // echo json_encode(["DEPOSIT" => Constants::$DEPOSIT_LIST_USER_WISE], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        echo "<br/>";
        // echo json_encode(["WITHDRAW" => Constants::$WITHDRAW_LIST_USER_WISE], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        echo "<br/>";
        echo "<br/>";
        // echo json_encode(["COMISSION" => Constants::$FINAL_COMISSION], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        foreach (Constants::$FINAL_COMISSION as $key => $comission) {
            echo $comission . "<br/>";
        }
        echo "</pre>";
    }
}
