<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class DueDateCalculatorTest extends TestCase
{
    public function test_exception_early_report(): void
    {
        $this->expectException(InvalidArgumentException::class);

        DueDateCalculator::calculate_due_date("2016-10-17 8:48:21", 1);
    }

    public function test_exception_late_report(): void
    {
        $this->expectException(InvalidArgumentException::class);

        DueDateCalculator::calculate_due_date("2016-10-17 17:48:21", 1);
    }

    public function test_exception_weekend(): void
    {
        $this->expectException(InvalidArgumentException::class);

        DueDateCalculator::calculate_due_date("2016-10-16 17:48:21", 1);
    }

    public function test_exception_wrong_format(): void
    {
        $this->expectException(InvalidArgumentException::class);

        DueDateCalculator::calculate_due_date("2016-1017 848:21", 1);
    }

    public function test_basic_assertion(): void
    {
        $this->assertEquals(
            "2016-10-17 15:48",
            DueDateCalculator::calculate_due_date("2016-10-17 14:48", 1)
        );
    }

    public function test_whole_day_turnaraound(): void
    {
        $this->assertEquals(
            "2016-10-19 14:48",
            DueDateCalculator::calculate_due_date("2016-10-17 14:48", 16)
        );
    }

    public function test_turnaround_over_not_whole_days(): void
    {
        $this->assertEquals(
            "2016-10-18 12:48",
            DueDateCalculator::calculate_due_date("2016-10-17 14:48", 6)
        );
    }

    public function test_turnaround_over_multiple_non_whole_days(): void
    {
        $this->assertEquals(
            "2016-10-20 12:48",
            DueDateCalculator::calculate_due_date("2016-10-17 14:48", 22)
        );
    }
/*
    public function test_long_turnaround(): void
    {
        $this->assertEquals(
            "2016-11-24 9:48",
            DueDateCalculator::calculate_due_date("2016-10-17 14:48", 219)
        );
    }*/

}