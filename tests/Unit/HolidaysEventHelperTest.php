<?php

namespace Tests\Unit;

use App\Helpers\HolidaysEventHelper;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class HolidaysEventHelperTest extends TestCase
{
    public function test_get_background_class_returns_correct_type_for_spring(): void
    {
        $date = Carbon::create(null, 3, 20);
        $backgroundClass = HolidaysEventHelper::getBackgroundClass($date);
        $this->assertEquals('spring', $backgroundClass);
    }

    public function test_get_background_class_returns_correct_type_for_summer(): void
    {
        $date = Carbon::create(null, 6, 20);
        $backgroundClass = HolidaysEventHelper::getBackgroundClass($date);
        $this->assertEquals('summer', $backgroundClass);
    }

    public function test_get_background_class_returns_correct_type_for_autumn(): void
    {
        $date = Carbon::create(null, 9, 22);
        $backgroundClass = HolidaysEventHelper::getBackgroundClass($date);
        $this->assertEquals('autumn', $backgroundClass);
    }

    public function test_get_background_class_returns_correct_type_for_halloween(): void
    {
        $date = Carbon::create(null, 10, 31);
        $backgroundClass = HolidaysEventHelper::getBackgroundClass($date);
        $this->assertEquals('halloween', $backgroundClass);
    }

    public function test_get_background_class_returns_correct_type_for_winter(): void
    {
        $date = Carbon::create(null, 12, 21);
        $backgroundClass = HolidaysEventHelper::getBackgroundClass($date);
        $this->assertEquals('winter', $backgroundClass);
    }

    public function test_get_background_class_returns_correct_type_for_christmas(): void
    {
        $date = Carbon::create(null, 12, 25);
        $backgroundClass = HolidaysEventHelper::getBackgroundClass($date);
        $this->assertEquals('christmas', $backgroundClass);
    }

    public function test_get_background_class_returns_correct_type_for_new_years_eve(): void
    {
        $date = Carbon::create(null, 12, 31);
        $backgroundClass = HolidaysEventHelper::getBackgroundClass($date);
        $this->assertEquals('new-year', $backgroundClass);
    }

    public function test_get_background_class_returns_correct_type_for_new_year(): void
    {
        $date = Carbon::create(null, 1, 1);
        $backgroundClass = HolidaysEventHelper::getBackgroundClass($date);
        $this->assertEquals('new-year', $backgroundClass);
    }

    public function test_get_background_class_returns_correct_type_for_easter(): void
    {
        $date = Carbon::createFromDate(2024, 3, 31);
        $backgroundClass = HolidaysEventHelper::getBackgroundClass($date);
        $this->assertEquals('easter', $backgroundClass);
    }

    public function test_get_background_class_returns_empty_string_when_no_holiday(): void
    {
        $date = Carbon::create(null, 7, 7);
        $backgroundClass = HolidaysEventHelper::getBackgroundClass($date);
        $this->assertEquals('', $backgroundClass);
    }

    public function test_easter_start_returns_correct_date_for2023(): void
    {
        $year = 2023;
        $expectedDate = Carbon::create($year, 4, 9);
        $calculatedDate = HolidaysEventHelper::easterStart(Carbon::createFromDate($year, 1, 1));
        $this->assertEquals($expectedDate, $calculatedDate);
    }

    public function test_easter_start_returns_correct_date_for2025(): void
    {
        $year = 2025;
        $expectedDate = Carbon::create($year, 4, 20);
        $calculatedDate = HolidaysEventHelper::easterStart(Carbon::createFromDate($year, 1, 1));
        $this->assertEquals($expectedDate, $calculatedDate);
    }
}
