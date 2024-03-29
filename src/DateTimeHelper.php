<?php

namespace Francerz\DateTimeTools;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;

abstract class DateTimeHelper
{
    public static function toDateTime($datetime): ?DateTime
    {
        if ($datetime instanceof DateTime) {
            return $datetime;
        }
        if ($datetime instanceof DateTimeInterface) {
            return new DateTime($datetime->format('Y-m-d H:i:s'), $datetime->getTimezone() ?: null);
        }
        if (is_string($datetime)) {
            return new DateTime($datetime);
        }
        if (is_int($datetime)) {
            return new DateTime("@{$datetime}");
        }
        return null;
    }

    public static function toDateTimeImmutable($datetime): ?DateTimeImmutable
    {
        if ($datetime instanceof DateTimeImmutable) {
            return $datetime;
        }
        if ($datetime instanceof DateTimeInterface) {
            return new DateTimeImmutable($datetime->format('Y-m-d H:i:s'), $datetime->getTimezone() ?: null);
        }
        if (is_string($datetime)) {
            return new DateTimeImmutable($datetime);
        }
        if (is_int($datetime)) {
            return new DateTimeImmutable("@{$datetime}");
        }
        return null;
    }

    /**
     * @param DateTimeInterface[]|string[]|int[] $datetimes
     * @return DateTime|null
     */
    public static function max(array $datetimes)
    {
        $max = null;
        foreach ($datetimes as $dt) {
            if (is_null($dt)) {
                continue;
            }
            $dt = static::toDateTime($dt);
            if (is_null($max)) {
                $max = $dt;
                continue;
            }
            if ($dt > $max) {
                $max = $dt;
            }
        }
        return $max;
    }

    /**
     * @param DateTimeInterface[]|string[]|int[] $datetimes
     * @return DateTime
     */
    public static function min(array $datetimes)
    {
        $min = null;
        foreach ($datetimes as $dt) {
            if (is_null($dt)) {
                continue;
            }
            $dt = static::toDateTime($dt);
            if (is_null($min)) {
                $min = $dt;
                continue;
            }
            if ($dt < $min) {
                $min = $dt;
            }
        }
        return $min;
    }

    /**
     * @ignore Uncomplete and failed function.
     * @param DateTimeInterface|string|int $datetime
     * @param WeekDays|int $firstDay
     * @return void
     */
    public static function getWeekOfYear($datetime, $firstDay = WeekDays::SUNDAY)
    {
        static $yearCache = [];

        $datetime = static::toDateTime($datetime);
        $days = $datetime->format('z');
        $year = $datetime->format('Y');


        if (!isset($yearCache[$year])) {
            $firstDayYear = new DateTime($datetime->format('Y-01-01'));
            $yearCache[$year] = $firstDayYear->format('w');
        }

        $days += ($yearCache[$year] + 7 - $firstDay) % 7;

        return floor($days / 7);
    }

    public static function isLeapYear($year)
    {
        if ($year % 4 != 0) {
            return false;
        }
        if ($year % 400 == 0) {
            return true;
        }
        return $year % 100 != 0;
    }
}
