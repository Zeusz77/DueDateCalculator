<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class DueDateCalculatorTest extends TestCase
{
    public function test_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);

        DueDateCalculator::calculate_due_date("2016-10-17 8:48:21", 1);
    }

    public function test_basic_assertion(): void
    {
        $this->assertEquals(
            "2016-10-17 15:48 Mon",
            DueDateCalculator::calculate_due_date("2016-10-17 14:48:21", 1)
        );
    }

    public function test_whole_day_turnaraound(): void
    {
        $this->assertEquals(
            "2016-10-19 14:48 Wed",
            DueDateCalculator::calculate_due_date("2016-10-17 14:48:21", 16)
        );
    }

    public function test_turnaround_over_not_whole_days(): void
    {
        $this->assertEquals(
            "2016-10-18 16:48 Wed",
            DueDateCalculator::calculate_due_date("2016-10-17 14:48:21", 10)
        );
    }

}