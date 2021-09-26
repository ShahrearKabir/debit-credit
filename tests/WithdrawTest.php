<?php

declare(strict_types=1);

namespace DebitCredit\Tests;

use DebitCredit\Cash\Withdraw;
use DebitCredit\Config\Constants;
use DebitCredit\Handler\Helper;
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
            "amount"=> 1100,
            "currency"=> "EUR",
            "weekly_count"=> 1,
            "total_amount"=> 1100,
            "chargeable_amount"=> 0,
        );

        $helper = new Helper();
        $helper->currency_convert();
        
        $result = new Withdraw($inputValue);
        $constant = Constants::$FINAL_COMISSION;
        
        $this->assertEquals(["0.30"], $constant);
    }
}