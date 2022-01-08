<?php declare(strict_types=1);

final class DueDateCalculator
{
    private $date_started;
    private $turnaround_time;

    private function _construct(string $date, int $turnaround)
    {
        $this->$date_started = $date;

        $this->$turnaround_time = $turnaround;
    }

    public function calculate_due_date(string $date, int $turnaround) : string
    {
        $report_hour = (int)date("H", strtotime($date));

        if(
            !(bool)strtotime($date) || $report_hour < 9 || $report_hour > 16
        ) throw new InvalidArgumentException('Date given was either invalid format or outside service hours!');

        $final_date = strtotime($date);
        
        while($turnaround > 0)
        {
            $current_hour = (int)date("H", $final_date);
            $current_day = date("D", $final_date);
            
            if(
                ($current_hour >= 9 && $current_hour <= 16) && ($current_day != 'Sat' && $current_day != 'Sun')
            ) $turnaround--;

            $final_date = strtotime("+1 hour", $final_date);
        }

        return date("Y-m-d H:i D", $final_date);
    }
}