<?php

declare(strict_types=1);

namespace DebitCredit\Tests;

use DebitCredit\Cash\Withdraw;
use DebitCredit\Config\Constants;
use PHPUnit\Framework\TestCase;

class WithdrawTest extends TestCase
{
    public function testWithdrawTest()
    {
        $inputValue = array(
            "transactions_date"=> "2015-01-05",
            "user_id"=> "2",
            "user_type"=> "private",
            "transactions_type"=> "withdraw",
            "amount"=> "1100",
            "currency"=> "EUR"
        );
        $result = new Withdraw($inputValue);
        $constant = Constants::$FINAL_COMISSION;
        
        $this->assertEquals(["0.30"], $constant);
    }
}