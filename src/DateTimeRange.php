<?php

namespace Francerz\DateTimeTools;

class DateTimeRange
{
    private $start;
    private $end;

    /**
     * @param DateTime|string|int $start
     * @param DateTime|string|int $end
     */
    public function __construct($start, $end)
    {
        $this->start = DateTimeHelper::toDateTime($start);
        $this->end = DateTimeHelper::toDateTime($end);
    }

    public function getStart()
    {
        return $this->start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function intersect($datetime, bool $excludeLimits = false)
    {
        $datetime = DateTimeHelper::toDateTime($datetime);
        return $excludeLimits ?
            $datetime > $this->start && $datetime < $this->end :
            $datetime >= $this->start && $datetime <= $this->end;
    }

    public function intersectRange(DateTimeRange $range, bool $excludeLimits = false)
    {
        if (
            $this->intersect($range->start, $excludeLimits) ||
            $this->intersect($range->end, $excludeLimits) ||
            $range->intersect($this->start, $excludeLimits) ||
            $range->intersect($this->end, $excludeLimits)
        ) {
            return true;
        }
        if (!$excludeLimits && $this->start == $range->start && $this->end == $range->end) {
            return true;
        }
        return false;
    }

    public function countSeconds()
    {
        $startSec = $this->start->format('U');
        $endSec = $this->end->format('U');
        return $endSec - $startSec;
    }

    public function countDays()
    {
        $startYear = $this->start->format('Y');
        $endYear = $this->end->format('Y');

        if ($startYear == $endYear) {
            $startDay = $this->start->format('z');
            $endDay = $this->end->format('z');
            return $endDay - $startDay + 1;
        }

        $firstRange = new DateTimeRange($this->start, $this->start->format('Y-12-31'));
        $lastRange = new DateTimeRange($this->end->format('Y-01-01'), $this->end);

        $days = $firstRange->countDays() + $lastRange->countDays();
        for ($y = $startYear + 1; $y < $endYear; $y++) {
            $range = new DateTimeRange("{$y}-01-01", "{$y}-12-31");
            $days += $range->countDays();
        }

        return $days;
    }

    /**
     * @return int[]
     */
    public function countWeekDays(): array
    {
        $days = $this->countDays();
        $weeks = floor($days / 7);

        $resultado = [
            WeekDays::SUNDAY => $weeks,
            WeekDays::MONDAY => $weeks,
            WeekDays::TUESDAY => $weeks,
            WeekDays::WEDNESDAY => $weeks,
            WeekDays::THURSDAY => $weeks,
            WeekDays::FRIDAY => $weeks,
            WeekDays::SATURDAY => $weeks,
        ];

        $residuo = $days % 7;
        $firstWeekDay = $this->start->format('w');
        $max = $firstWeekDay + $residuo;
        for ($d = $firstWeekDay; $d < $max; $d++) {
            $resultado[$d % 7]++;
        }

        return $resultado;
    }
}
