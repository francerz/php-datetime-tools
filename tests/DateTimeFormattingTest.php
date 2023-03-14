<?php

namespace Francerz\DateTimeTools\Tests;

use DateTime;
use PHPUnit\Framework\TestCase;

class DateTimeFormattingTest extends TestCase
{
    public function testWeekOfYear()
    {
        $this->assertEquals('01', (new DateTime('2015-01-01'))->format('W'));
    }
}
