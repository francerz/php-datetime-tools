<?php

namespace Francerz\DateTimeTools;

use DateInterval;

abstract class DateIntervalHelper
{
    public static function create($y = 0, $m = 0, $d = 0, $h = 0, $i = 0, $s = 0)
    {
        $duration = 'P';
        if (!empty($y)) {
            $duration .= "{$y}Y";
        }
        if (!empty($m)) {
            $duration .= "{$m}M";
        }
        if (!empty($d)) {
            $duration .= "{$d}D";
        }
        if (!empty($h) || !empty($i) || !empty($s) || !empty($f)) {
            $duration .= 'T';
        }
        if (!empty($h)) {
            $duration .= "{$h}H";
        }
        if (!empty($i)) {
            $duration .= "{$i}M";
        }
        if (!empty($s)) {
            $duration .= "{$s}S";
        }
        return new DateInterval($duration);
    }
}
