<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class DueDateCalculatorTest extends TestCase
{
    public function test_exception_early_report(): void
    {
        $this->expectException(InvalidArgumentException::class);

        DueDateCalculator::calculate_due_date("2016-10-17 08:59", 1);
    }

    public function test_exception_late_report(): void
    {
        $this->expectException(InvalidArgumentException::class);

        DueDateCalculator::calculate_due_date("2016-10-17 17:00", 1);
    }

    public function test_exception_weekend(): void
    {
        $this->expectException(InvalidArgumentException::class);

        DueDateCalculator::calculate_due_date("2016-10-16 17:48", 1);
    }

    public function test_exception_wrong_format(): void
    {
        $this->expectException(InvalidArgumentException::class);

        DueDateCalculator::calculate_due_date("2016-1017 848", 1);
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

    public function test_whole_day_turnaraound_over_a_weekend(): void
    {
        $this->assertEquals(
            "2022-02-21 14:00",
            DueDateCalculator::calculate_due_date("2022-02-14 14:00", 40)
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
    
    public function test_report_right_before_weekend(): void
    {
        $this->assertEquals(
            "2022-01-10 09:30",
            DueDateCalculator::calculate_due_date("2022-01-07 16:30", 1)
        );
    }

    public function test_report_right_before_next_month(): void
    {
        $this->assertEquals(
            "2022-02-01 13:00",
            DueDateCalculator::calculate_due_date("2022-01-31 15:00", 6)
        );
    }

    public function test_report_right_before_non_office_hours(): void
    {
        $this->assertEquals(
            "2022-02-01 14:59",
            DueDateCalculator::calculate_due_date("2022-01-31 16:59", 6)
        );
    }

    public function test_turnaround_over_new_years(): void
    {
        $this->assertEquals(
          "2022-01-12 15:11",
          DueDateCalculator::calculate_due_date("2021-12-31 9:11", 70)
        );
    }

    public function test_one_day_task_over_new_years(): void
    {
        $this->assertEquals(
            "2022-01-03 09:11",
            DueDateCalculator::calculate_due_date("2021-12-31 09:11", 8)
          );
    }

    public function test_one_day_task_nine_to_five(): void
    {
        $this->assertEquals(
            "2022-01-03 09:00",
            DueDateCalculator::calculate_due_date("2021-12-31 09:00", 8)
          );
    }
}