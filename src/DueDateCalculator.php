<?php declare(strict_types=1);

final class DueDateCalculator
{

    private static function add_time(int $time_stamp, int $turnaround, string $unit = 'hour'): int
    {
        while($turnaround > 0)
        {
            
            $time_stamp = strtotime("+1 " . $unit, $time_stamp);
            
            $current_day = date("D", $time_stamp);
            $current_time = (int)(date("H", $time_stamp) . date("i", $time_stamp));
            
            if(
                ($current_time > 900 && $current_time <= 1700) &&
                !in_array($current_day, ['Sat', 'Sun'])
            )
            {
                $turnaround--;
            }
        }

        return $time_stamp;
    }

    /**
     * Get the date/time when an issue is resolved.
     * 
     * @author Áron Franta <aron.franta@gmail.com>
     * 
     * @param string $date  The date when the issue is reported.
     * @param int $turnaround The resolution time of the issue in hours.
     * 
     * @return string
     * 
     * @throws InvalidArgumentException In case the date is a weekend or is outside of service hours, or in case the given Date string isn't in a valid date format.
     */
    public static function calculate_due_date(string $date, int $turnaround) : string
    {
        if(!strtotime($date))
        {
            throw new InvalidArgumentException('Date given was invalid format!');
        }

        $report_day = date("D", strtotime($date));
        $report_time = (int)(date("H", strtotime($date)) . date("i", strtotime($date)));
        
        if(
            in_array($report_day, ['Sat', 'Sun'])
        )
        {
            throw new InvalidArgumentException('Date given is a weekend!');
        } 

        if(
            $report_time < 900 || $report_time > 1700
        )
        {
            throw new InvalidArgumentException('Date given was outside service hours!');
        } 

        $final_date = strtotime($date);

        $days = $turnaround / 8;
        $weeks = $days / 5;
        $days = $days % 5;
        $turnaround = $turnaround % 8;

        $final_date = strtotime(sprintf("+%d week", $weeks) ,$final_date);

        $final_date = DueDateCalculator::add_time($final_date, $days, "day");

        $final_date = DueDateCalculator::add_time($final_date, $turnaround, "hour");

        return date("Y-m-d H:i", $final_date);
    }
}