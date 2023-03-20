<?php

namespace Francerz\DateTimeTools\Tests;

use Francerz\DateTimeTools\DateTimeHelper;
use Francerz\DateTimeTools\WeekDays;
use PHPUnit\Framework\TestCase;

class DateTimeHelperTest extends TestCase
{
    public function testMaxMin()
    {
        $this->assertNull(DateTimeHelper::max([]));
        $this->assertNull(DateTimeHelper::min([]));

        $datetimes = [
            '1991-11-09 08:45:00',
            '1995-10-07 05:00:00',
            '1999-02-25 12:00:00',
            '1970-11-29 00:00:00',
        ];

        $max = DateTimeHelper::max($datetimes);
        $this->assertEquals('1999-02-25 12:00:00', $max->format('Y-m-d H:i:s'));

        $min = DateTimeHelper::min($datetimes);
        $this->assertEquals('1970-11-29 00:00:00', $min->format('Y-m-d H:i:s'));
    }

    public function atestGetWeekOfYear()
    {
        $this->assertEquals(0, DateTimeHelper::getWeekOfYear('2023-01-01', WeekDays::SUNDAY));
        $this->assertEquals(0, DateTimeHelper::getWeekOfYear('2023-01-01', WeekDays::MONDAY));
        $this->assertEquals(0, DateTimeHelper::getWeekOfYear('2023-01-01', WeekDays::TUESDAY));
        $this->assertEquals(0, DateTimeHelper::getWeekOfYear('2023-01-01', WeekDays::WEDNESDAY));
        $this->assertEquals(0, DateTimeHelper::getWeekOfYear('2023-01-01', WeekDays::THURSDAY));
        $this->assertEquals(0, DateTimeHelper::getWeekOfYear('2023-01-01', WeekDays::FRIDAY));
        $this->assertEquals(0, DateTimeHelper::getWeekOfYear('2023-01-01', WeekDays::SATURDAY));

        $this->assertEquals(1, DateTimeHelper::getWeekOfYear('2023-01-08', WeekDays::SUNDAY));
        $this->assertEquals(1, DateTimeHelper::getWeekOfYear('2023-01-08', WeekDays::MONDAY));
        $this->assertEquals(1, DateTimeHelper::getWeekOfYear('2023-01-08', WeekDays::TUESDAY));
        $this->assertEquals(1, DateTimeHelper::getWeekOfYear('2023-01-08', WeekDays::WEDNESDAY));
        $this->assertEquals(1, DateTimeHelper::getWeekOfYear('2023-01-08', WeekDays::THURSDAY));
        $this->assertEquals(1, DateTimeHelper::getWeekOfYear('2023-01-08', WeekDays::FRIDAY));
        $this->assertEquals(1, DateTimeHelper::getWeekOfYear('2023-01-08', WeekDays::SATURDAY));

        $this->assertEquals(0, DateTimeHelper::getWeekOfYear('2023-01-04', WeekDays::SUNDAY));
        $this->assertEquals(1, DateTimeHelper::getWeekOfYear('2023-01-04', WeekDays::MONDAY));
        $this->assertEquals(1, DateTimeHelper::getWeekOfYear('2023-01-04', WeekDays::TUESDAY));
        $this->assertEquals(1, DateTimeHelper::getWeekOfYear('2023-01-04', WeekDays::WEDNESDAY));
        $this->assertEquals(0, DateTimeHelper::getWeekOfYear('2023-01-04', WeekDays::THURSDAY));
        $this->assertEquals(0, DateTimeHelper::getWeekOfYear('2023-01-04', WeekDays::FRIDAY));
        $this->assertEquals(0, DateTimeHelper::getWeekOfYear('2023-01-04', WeekDays::SATURDAY));

        $this->assertEquals(10, DateTimeHelper::getWeekOfYear('2023-03-13', WeekDays::SUNDAY));
        $this->assertEquals(11, DateTimeHelper::getWeekOfYear('2023-03-13', WeekDays::MONDAY));
        $this->assertEquals(10, DateTimeHelper::getWeekOfYear('2023-03-13', WeekDays::TUESDAY));
        $this->assertEquals(10, DateTimeHelper::getWeekOfYear('2023-03-13', WeekDays::WEDNESDAY));
        $this->assertEquals(10, DateTimeHelper::getWeekOfYear('2023-03-13', WeekDays::THURSDAY));
        $this->assertEquals(10, DateTimeHelper::getWeekOfYear('2023-03-13', WeekDays::FRIDAY));
        $this->assertEquals(10, DateTimeHelper::getWeekOfYear('2023-03-13', WeekDays::SATURDAY));

        $this->assertEquals(12, DateTimeHelper::getWeekOfYear('2023-04-01', WeekDays::SUNDAY));
        $this->assertEquals(13, DateTimeHelper::getWeekOfYear('2023-04-01', WeekDays::MONDAY));
        $this->assertEquals(13, DateTimeHelper::getWeekOfYear('2023-04-01', WeekDays::TUESDAY));
        $this->assertEquals(13, DateTimeHelper::getWeekOfYear('2023-04-01', WeekDays::WEDNESDAY));
        $this->assertEquals(13, DateTimeHelper::getWeekOfYear('2023-04-01', WeekDays::THURSDAY));
        $this->assertEquals(13, DateTimeHelper::getWeekOfYear('2023-04-01', WeekDays::FRIDAY));
        $this->assertEquals(13, DateTimeHelper::getWeekOfYear('2023-04-01', WeekDays::SATURDAY));

        $this->assertEquals(0, DateTimeHelper::getWeekOfYear('2022-01-01', WeekDays::SUNDAY));
        $this->assertEquals(0, DateTimeHelper::getWeekOfYear('2022-01-01', WeekDays::MONDAY));
        $this->assertEquals(0, DateTimeHelper::getWeekOfYear('2022-01-01', WeekDays::TUESDAY));
        $this->assertEquals(0, DateTimeHelper::getWeekOfYear('2022-01-01', WeekDays::WEDNESDAY));
        $this->assertEquals(0, DateTimeHelper::getWeekOfYear('2022-01-01', WeekDays::THURSDAY));
        $this->assertEquals(0, DateTimeHelper::getWeekOfYear('2022-01-01', WeekDays::FRIDAY));
        $this->assertEquals(0, DateTimeHelper::getWeekOfYear('2022-01-01', WeekDays::SATURDAY));

        $this->assertEquals(44, DateTimeHelper::getWeekOfYear('1991-11-09', WeekDays::SUNDAY));
        $this->assertEquals(44, DateTimeHelper::getWeekOfYear('1991-11-09', WeekDays::MONDAY));
        $this->assertEquals(44, DateTimeHelper::getWeekOfYear('1991-11-09', WeekDays::TUESDAY));
        $this->assertEquals(44, DateTimeHelper::getWeekOfYear('1991-11-09', WeekDays::WEDNESDAY));
        $this->assertEquals(44, DateTimeHelper::getWeekOfYear('1991-11-09', WeekDays::THURSDAY));
        $this->assertEquals(44, DateTimeHelper::getWeekOfYear('1991-11-09', WeekDays::FRIDAY));
        $this->assertEquals(45, DateTimeHelper::getWeekOfYear('1991-11-09', WeekDays::SATURDAY));
    }

    public function testIsLeapYear()
    {
        $this->assertTrue(DateTimeHelper::isLeapYear(2024));
        $this->assertFalse(DateTimeHelper::isLeapYear(2023));
        $this->assertFalse(DateTimeHelper::isLeapYear(2022));
        $this->assertFalse(DateTimeHelper::isLeapYear(2021));
        $this->assertTrue(DateTimeHelper::isLeapYear(2020));
        $this->assertTrue(DateTimeHelper::isLeapYear(2004));
        $this->assertTrue(DateTimeHelper::isLeapYear(2000));
        $this->assertTrue(DateTimeHelper::isLeapYear(1996));
        $this->assertTrue(DateTimeHelper::isLeapYear(1904));
        $this->assertFalse(DateTimeHelper::isLeapYear(1900));
        $this->assertTrue(DateTimeHelper::isLeapYear(1896));
        $this->assertFalse(DateTimeHelper::isLeapYear(1800));
        $this->assertFalse(DateTimeHelper::isLeapYear(1700));
        $this->assertTrue(DateTimeHelper::isLeapYear(1600));
        $this->assertFalse(DateTimeHelper::isLeapYear(1500));
        $this->assertFalse(DateTimeHelper::isLeapYear(1400));
        $this->assertFalse(DateTimeHelper::isLeapYear(1300));
        $this->assertTrue(DateTimeHelper::isLeapYear(1200));
        $this->assertTrue(DateTimeHelper::isLeapYear(4));
        $this->assertTrue(DateTimeHelper::isLeapYear(-4));
    }
}
