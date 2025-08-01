<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

class HolidaysEventHelper
{
    public const SPRING = 'spring';
    public const SUMMER = 'summer';
    public const AUTUMN = 'autumn';
    public const HALLOWEEN = 'halloween';
    public const WINTER = 'winter';
    public const CHRISTMAS = 'christmas';
    public const NEW_YEAR = 'new-year';
    public const EASTER = 'easter';

    public static function getBackgroundClass(Carbon $currentDate): string
    {
        $easter = self::easterStart($currentDate);

        $holidays = [
            ['start' => Carbon::create(null, 3, 19), 'end' => Carbon::create(null, 3, 21), 'type' => self::SPRING],
            ['start' => Carbon::create(null, 6, 19), 'end' => Carbon::create(null, 6, 21), 'type' => self::SUMMER],
            ['start' => Carbon::create(null, 9, 21), 'end' => Carbon::create(null, 9, 23), 'type' => self::AUTUMN],
            ['start' => Carbon::create(null, 10, 31), 'end' => Carbon::create(null, 11, 1), 'type' => self::HALLOWEEN],
            ['start' => Carbon::create(null, 12, 20), 'end' => Carbon::create(null, 12, 22), 'type' => self::WINTER],
            ['start' => Carbon::create(null, 12, 24), 'end' => Carbon::create(null, 12, 26), 'type' => self::CHRISTMAS],
            ['start' => Carbon::create(null, 12, 31), 'end' => Carbon::create(null, 12, 31), 'type' => self::NEW_YEAR],
            ['start' => Carbon::create(null, 1, 1), 'end' => Carbon::create(null, 1, 1), 'type' => self::NEW_YEAR],
            ['start' => $easter ? $easter->copy()->subDays(2) : null, 'end' => $easter ? $easter->copy()->addDays(1) : null, 'type' => self::EASTER],
        ];

        foreach ($holidays as $holiday) {
            if ($holiday['start'] && $holiday['end'] && $currentDate->between($holiday['start'], $holiday['end'])) {
                return $holiday['type'];
            }
        }

        return '';
    }

    public static function easterStart(Carbon $date): ?Carbon
    {
        $year = $date->year;

        $a = $year % 19;
        $b = intdiv($year, 100);
        $c = $year % 100;
        $d = intdiv($b, 4);
        $e = $b % 4;
        $f = intdiv($b + 8, 25);
        $g = intdiv($b - $f + 1, 3);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = intdiv($c, 4);
        $k = $c % 4;
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = intdiv($a + 11 * $h + 22 * $l, 451);
        $month = intdiv($h + $l - 7 * $m + 114, 31);
        $day = ($h + $l - 7 * $m + 114) % 31 + 1;

        return Carbon::create($year, $month, $day);
    }
}
