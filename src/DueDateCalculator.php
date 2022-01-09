<?php declare(strict_types=1);

final class DueDateCalculator
{
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
     * @throws InvalidArgumentException In case the date is a weekend or is outside of service hours, or in case the given Date sting isn't in a valid date format.
     */
    public function calculate_due_date(string $date, int $turnaround) : string
    {

        // Exception handling

        // Throws an exception is strtotime returns with null, meaning it has failed to format the string
        if(!strtotime($date))
        {
            throw new InvalidArgumentException('Date given was invalid format!');
        }

        $report_hour = (int)date("H", strtotime($date));
        $report_day = date("D", strtotime($date));
        
        // Weekends are outside service hours
        if(
            in_array($report_day, ['Sat', 'Sun'])
        )
        {
            throw new InvalidArgumentException('Date given is a weekend!');
        } 

        // If the step above didn't raise an issue, checks, if the dateTime of the report falls inside service hours.
        if(
            !($report_hour >= 9 && $report_hour < 17)
        )
        {
            throw new InvalidArgumentException('Date given was outside service hours!');
        } 

        // Solution
        $final_date = strtotime($date);
        
        while($turnaround > 0)
        {
            
            $final_date = strtotime("+1 hour", $final_date);
            
            $current_hour = (int)date("H", $final_date);
            $current_day = date("D", $final_date);
            
            // The turnaround is only decresade if it's a working hour on a non-weekend day
            if(
                ($current_hour >= 9 && $current_hour <= 16) && ($current_day != 'Sat' && $current_day != 'Sun')
            )
            {
                $turnaround--;
            }
        }

        // Returning the final date in Y-m-d H:i format. (this is what the test cases watch for, but can be modified freely. The test cases can be reworked to watch any accaptable format.)
        return date("Y-m-d H:i", $final_date);
    }
}