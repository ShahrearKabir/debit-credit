<?php

declare(strict_types=1);

namespace DebitCredit\Tests;

use DebitCredit\Cash\Deposit;
use DebitCredit\Handler\Helper;
use PHPUnit\Framework\TestCase;

class DepositTest extends TestCase
{
    public function testDepositInput()
    {
        $inputValue = array(
            "transactions_date"=> "2016-01-05",
            "user_id"=> "1",
            "user_type"=> "private",
            "transactions_type"=> "deposit",
            "amount"=> "1000",
            "currency"=> "EUR"
        );
        
        $helper = new Helper();
        $helper->currency_convert();
        
        $result = new Deposit($inputValue);
        $this->assertEquals(0.3, $result->__construct($inputValue));
    }
}