Date and Time Tools
=======================================

A set of PHP functions to handle date and time units.

## Class `DateTimeHelper`

```php
class DateTimeHelper
{
    public static function toDateTime($datetime): ?DateTime

    public static function toDateTimeImmutable($datetime): ?DateTimeImmutable

    public static function max($datetimes): ?DateTime

    public static function min($datetimes): ?DateTime
}
```

## Class `DateTimeRange`

```php
class DateTimeRange
{
    public function __construct($start, $end);

    public function getStart(): ?DateTime;

    public function getEnd(): ?DateTime;

    public function intersect($datetime, $excludeLimits = false): bool;

    public function intersectRange(DateTimeRange $range, bool $excludeLimits = false): bool;

    public function countSeconds(): int
    
    public function countWeekDays(): int[];
}
```
