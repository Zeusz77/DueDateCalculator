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
        if($turnaround % 8 == 0){
            $addable = sprintf("+%d day", $turnaround/8);
        }else{
            $addable = sprintf("+%d hour", $turnaround);
        }
        
        return date("Y-m-d H:i D", strtotime( $addable, strtotime($date)));
    }
}