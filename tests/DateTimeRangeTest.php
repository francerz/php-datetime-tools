<?php

namespace Francerz\DateTimeTools\Tests;

use Francerz\DateTimeTools\DateTimeRange;
use Francerz\DateTimeTools\WeekDays;
use PHPUnit\Framework\TestCase;

class DateTimeRangeTest extends TestCase
{
    public function testNewRange()
    {
        $range = new DateTimeRange('2022-01-01', '2023-03-10');

        $this->assertEquals('2022', $range->getStart()->format('Y'));
        $this->assertEquals('01', $range->getStart()->format('m'));
        $this->assertEquals('01', $range->getStart()->format('d'));

        $this->assertEquals('2023', $range->getEnd()->format('Y'));
        $this->assertEquals('03', $range->getEnd()->format('m'));
        $this->assertEquals('10', $range->getEnd()->format('d'));
    }

    public function testIntersect()
    {
        $range = new DateTimeRange('2022-01-01', '2023-03-10');

        $this->assertFalse($range->intersect('2021-12-31'));
        $this->assertTrue($range->intersect('2022-01-01'));
        $this->assertTrue($range->intersect('2022-06-30'));
        $this->assertTrue($range->intersect('2023-03-10'));
        $this->assertFalse($range->intersect('2023-03-11'));
    }

    public function testTimeIntersect()
    {
        $range = new DateTimeRange('08:00', '15:00');

        $this->assertFalse($range->intersect('07:59'));
        $this->assertTrue($range->intersect('08:00'));
        $this->assertTrue($range->intersect('08:01'));
        $this->assertTrue($range->intersect('14:59'));
        $this->assertTrue($range->intersect('15:00'));
        $this->assertFalse($range->intersect('15:01'));
    }

    public function testIntersectRangeWithLimits()
    {
        $range = new DateTimeRange('2023-01-01', '2023-03-10');

        // Starts before, ends before
        $this->assertFalse($range->intersectRange(new DateTimeRange('2022-01-01', '2022-12-31')));
        // Starts before, ends at start
        $this->assertTrue($range->intersectRange(new DateTimeRange('2022-01-01', '2023-01-01')));
        // Starts before, ends middle
        $this->assertTrue($range->intersectRange(new DateTimeRange('2022-01-01', '2023-02-25')));
        // Starts before, ends at end
        $this->assertTrue($range->intersectRange(new DateTimeRange('2022-01-01', '2023-12-31')));
        // Starts before, ends after
        $this->assertTrue($range->intersectRange(new DateTimeRange('2022-01-01', '2023-12-31')));

        // Starts at start, ends at start
        $this->assertTrue($range->intersectRange(new DateTimeRange('2023-01-01', '2023-01-01')));
        // Starts at start, ends middle
        $this->assertTrue($range->intersectRange(new DateTimeRange('2023-01-01', '2023-02-25')));
        // Starts at start, ends at end
        $this->assertTrue($range->intersectRange(new DateTimeRange('2023-01-01', '2023-03-10')));
        // Starts at start, ends at after
        $this->assertTrue($range->intersectRange(new DateTimeRange('2023-01-01', '2023-12-31')));

        // Starts middle, ends middle
        $this->assertTrue($range->intersectRange(new DateTimeRange('2023-02-25', '2023-03-03')));
        // Starts middle, ends at end
        $this->assertTrue($range->intersectRange(new DateTimeRange('2023-02-25', '2023-03-10')));
        // Starts middle, ends after
        $this->assertTrue($range->intersectRange(new DateTimeRange('2023-02-25', '2023-12-31')));

        // Starts at end, ends at end
        $this->assertTrue($range->intersectRange(new DateTimeRange('2023-03-10', '2023-03-10')));
        // Starts at end, ends after
        $this->assertTrue($range->intersectRange(new DateTimeRange('2023-03-10', '2023-12-31')));

        // Starts after, ends after
        $this->assertFalse($range->intersectRange(new DateTimeRange('2023-03-11', '2023-12-31')));


        $range = new DateTimeRange('07:00', '20:00');
        // Starts before, ends before
        $this->assertFalse($range->intersectRange(new DateTimeRange('05:00', '06:00'), true));
        // Starts before, ends at start
        $this->assertFalse($range->intersectRange(new DateTimeRange('05:00', '07:00'), true));
        // Starts before, ends middle
        $this->assertTrue($range->intersectRange(new DateTimeRange('05:00', '08:00'), true));
        // Starts before, ends at end
        $this->assertTrue($range->intersectRange(new DateTimeRange('05:00', '20:00'), true));
        // Starts before, ends after
        $this->assertTrue($range->intersectRange(new DateTimeRange('05:00', '21:00'), true));
        // Starts at start, ends at start
        $this->assertTrue($range->intersectRange(new DateTimeRange('07:00', '07:00'), true));
        // Starts at start, ends middle
        $this->assertTrue($range->intersectRange(new DateTimeRange('07:00', '08:00'), true));
        // Starts at start, ends at end
        $this->assertTrue($range->intersectRange(new DateTimeRange('07:00', '20:00'), true));
        // Starts at start, ends at after
        $this->assertTrue($range->intersectRange(new DateTimeRange('07:00', '21:00'), true));
        // Starts middle, ends middle
        $this->assertTrue($range->intersectRange(new DateTimeRange('08:00', '19:00'), true));
        // Starts middle, ends at end
        $this->assertTrue($range->intersectRange(new DateTimeRange('08:00', '20:00'), true));
        // Starts middle, ends after
        $this->assertTrue($range->intersectRange(new DateTimeRange('08:00', '21:00'), true));
        // Starts at end, ends at end
        $this->assertTrue($range->intersectRange(new DateTimeRange('20:00', '20:00'), true));
        // Starts at end, ends after
        $this->assertFalse($range->intersectRange(new DateTimeRange('20:00', '21:00'), true));
        // Starts after, ends after
        $this->assertFalse($range->intersectRange(new DateTimeRange('21:00', '22:00'), true));
    }

    public function testRangeIntersect()
    {
        $range0 = new DateTimeRange('2023-01-02', '2023-03-15');

        $this->assertEquals(
            new DateTimeRange('2023-01-02', '2023-01-31'),
            $range0->getRangeIntersect(new DateTimeRange('2023-01-02', '2023-01-31'))
        );

        $this->assertEquals(
            new DateTimeRange('2023-02-01', '2023-02-28'),
            $range0->getRangeIntersect(new DateTimeRange('2023-02-01', '2023-02-28'))
        );

        $this->assertEquals(
            new DateTimeRange('2023-03-01', '2023-03-15'),
            $range0->getRangeIntersect(new DateTimeRange('2023-03-01', '2023-03-31'))
        );

        $range1 = new DateTimeRange('2023-03-16', '2023-06-09');

        $this->assertEquals(
            new DateTimeRange('2023-03-16', '2023-03-31'),
            $range1->getRangeIntersect(new DateTimeRange('2023-03-01', '2023-03-31'))
        );

        $this->assertNull($range1->getRangeIntersect(new DateTimeRange('2023-02-01', '2023-02-28')));
        $this->assertNull($range1->getRangeIntersect(new DateTimeRange('2023-01-02', '2023-01-31')));
    }

    public function testCountWeekDays()
    {
        $range = new DateTimeRange('2023-01-01', '2023-01-31');
        $this->assertEquals([
            WeekDays::SUNDAY => 5,
            WeekDays::MONDAY => 5,
            WeekDays::TUESDAY => 5,
            WeekDays::WEDNESDAY => 4,
            WeekDays::THURSDAY => 4,
            WeekDays::FRIDAY => 4,
            WeekDays::SATURDAY => 4
        ], $range->countWeekDays());

        $range = new DateTimeRange('2023-01-01', '2023-12-31');
        $this->assertEquals([
            WeekDays::SUNDAY => 53,
            WeekDays::MONDAY => 52,
            WeekDays::TUESDAY => 52,
            WeekDays::WEDNESDAY => 52,
            WeekDays::THURSDAY => 52,
            WeekDays::FRIDAY => 52,
            WeekDays::SATURDAY => 52
        ], $range->countWeekDays());

        $range = new DateTimeRange('2022-01-01', '2022-12-31');
        $this->assertEquals([
            WeekDays::SUNDAY => 52,
            WeekDays::MONDAY => 52,
            WeekDays::TUESDAY => 52,
            WeekDays::WEDNESDAY => 52,
            WeekDays::THURSDAY => 52,
            WeekDays::FRIDAY => 52,
            WeekDays::SATURDAY => 53
        ], $range->countWeekDays());

        $range = new DateTimeRange('2021-01-01', '2021-12-31');
        $this->assertEquals([
            WeekDays::SUNDAY => 52,
            WeekDays::MONDAY => 52,
            WeekDays::TUESDAY => 52,
            WeekDays::WEDNESDAY => 52,
            WeekDays::THURSDAY => 52,
            WeekDays::FRIDAY => 53,
            WeekDays::SATURDAY => 52
        ], $range->countWeekDays());

        $range = new DateTimeRange('2020-01-01', '2020-12-31');
        $this->assertEquals([
            WeekDays::SUNDAY => 52,
            WeekDays::MONDAY => 52,
            WeekDays::TUESDAY => 52,
            WeekDays::WEDNESDAY => 53,
            WeekDays::THURSDAY => 53,
            WeekDays::FRIDAY => 52,
            WeekDays::SATURDAY => 52
        ], $range->countWeekDays());

        $range = new DateTimeRange('2023-01-02', '2023-01-27');
        $this->assertEquals([
            WeekDays::SUNDAY => 3,
            WeekDays::MONDAY => 4,
            WeekDays::TUESDAY => 4,
            WeekDays::WEDNESDAY => 4,
            WeekDays::THURSDAY => 4,
            WeekDays::FRIDAY => 4,
            WeekDays::SATURDAY => 3
        ], $range->countWeekDays());

        $range = new DateTimeRange('2023-01-30', '2023-03-15');
        $this->assertEquals([
            WeekDays::SUNDAY => 6,
            WeekDays::MONDAY => 7,
            WeekDays::TUESDAY => 7,
            WeekDays::WEDNESDAY => 7,
            WeekDays::THURSDAY => 6,
            WeekDays::FRIDAY => 6,
            WeekDays::SATURDAY => 6
        ], $range->countWeekDays());

        $range = new DateTimeRange('2023-03-16', '2023-06-09');
        $this->assertEquals([
            WeekDays::SUNDAY => 12,
            WeekDays::MONDAY => 12,
            WeekDays::TUESDAY => 12,
            WeekDays::WEDNESDAY => 12,
            WeekDays::THURSDAY => 13,
            WeekDays::FRIDAY => 13,
            WeekDays::SATURDAY => 12
        ], $range->countWeekDays());

        $range = new DateTimeRange('2023-06-12', '2023-06-30');
        $this->assertEquals([
            WeekDays::SUNDAY => 2,
            WeekDays::MONDAY => 3,
            WeekDays::TUESDAY => 3,
            WeekDays::WEDNESDAY => 3,
            WeekDays::THURSDAY => 3,
            WeekDays::FRIDAY => 3,
            WeekDays::SATURDAY => 2
        ], $range->countWeekDays());

        $range = new DateTimeRange('2022-01-01', '2023-12-31');
        $this->assertEquals([
            WeekDays::SUNDAY => 105,
            WeekDays::MONDAY => 104,
            WeekDays::TUESDAY => 104,
            WeekDays::WEDNESDAY => 104,
            WeekDays::THURSDAY => 104,
            WeekDays::FRIDAY => 104,
            WeekDays::SATURDAY => 105
        ], $range->countWeekDays());

        $range = new DateTimeRange('2022-01-01', '2024-12-31');
        $this->assertEquals([
            WeekDays::SUNDAY => 157,
            WeekDays::MONDAY => 157,
            WeekDays::TUESDAY => 157,
            WeekDays::WEDNESDAY => 156,
            WeekDays::THURSDAY => 156,
            WeekDays::FRIDAY => 156,
            WeekDays::SATURDAY => 157
        ], $range->countWeekDays());

        $range = new DateTimeRange('1991-11-09', '1999-02-25');
        $this->assertEquals([
            WeekDays::SUNDAY => 381,
            WeekDays::MONDAY => 381,
            WeekDays::TUESDAY => 381,
            WeekDays::WEDNESDAY => 381,
            WeekDays::THURSDAY => 381,
            WeekDays::FRIDAY => 380,
            WeekDays::SATURDAY => 381
        ], $range->countWeekDays());
    }
}
