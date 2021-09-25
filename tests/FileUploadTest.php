<?php

declare(strict_types=1);

namespace DebitCredit\Tests;

use DebitCredit\View\FileUpload;
use PHPUnit\Framework\TestCase;

class FileUploadTest extends TestCase
{
    public function testExpectFooActualFoo(): void
    {
        $this->expectOutputString('foo');

        print 'foo';
    }

    public function testExpectBarActualBaz(): void
    {
        $this->expectOutputString('bar');

        print 'bar';
    }
}