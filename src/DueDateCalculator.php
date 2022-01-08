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
        $report_minute = (int)date("i", strtotime($date));

        if(
            !(bool)strtotime($date) || $report_hour < 9 || $report_hour > 16
        ) throw new InvalidArgumentException('Date given was either invalid format or outside service hours!');

        if($turnaround % 8 == 0){
            $addable = sprintf("+%d day", $turnaround/8);
        }else{
            $addable = sprintf("+%d hour", $turnaround);
        }
        
        return date("Y-m-d H:i D", strtotime( $addable, strtotime($date)));
    }
}