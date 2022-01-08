<?php declare(strict_types=1);

final class DueDateCalculator
{
    public function calculate_due_date(string $date, int $turnaround) : string
    {

        // Exception handling
        if(!strtotime($date)) throw new InvalidArgumentException('Date given was invalid format!');

        $report_hour = (int)date("H", strtotime($date));
        $report_day = (int)date("D", strtotime($date));
        
        if(
            ($report_hour < 9 || $report_hour > 16) || ($report_day != 'Sat' && $report_day != 'Sun')
        ) throw new InvalidArgumentException('Date given was outside service hours!');

        // Solution
        $final_date = strtotime($date);
        
        while($turnaround > 0)
        {
            $current_hour = (int)date("H", $final_date);
            $current_day = date("D", $final_date);

            // The turnaround is only decresade if it's a working hour on a non-weekend day
            if(
                ($current_hour > 8 && $current_hour < 17) && ($current_day != 'Sat' && $current_day != 'Sun')
            ) $turnaround--;
            
            $final_date = strtotime("+1 hour", $final_date);
        }

        // Returning the final date at an acceptable
        return date("Y-m-d H:i", $final_date);
    }
}