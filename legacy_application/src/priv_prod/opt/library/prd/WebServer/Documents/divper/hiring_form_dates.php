<?php
if(!empty($display_target_date))
	{$target_date=$display_target_date;}
	$x=$day_count;

if(empty($target_date)){$target_date=date("Y-m-d");}
$exp=explode("-",$target_date);
$t = mktime( 0, 0, 0, $exp[1], $exp[2], $exp[0] );
 
    // loop for X days
for($i=0; $i<$x; $i++){

        // add 1 day to timestamp
        $addDay = 86400;

        // get what day it is next day
        $nextDay = date('w', ($t+$addDay));

        // if it's Saturday or Sunday get $i-1
        if($nextDay == 0 || $nextDay == 6)
			{
			$i--;
			}

        // if it's a Holiday get $i-1
        if(in_array(($t+$addDay),$holiday_array))
			{
			$i--;
			}

        // modify timestamp, add 1 day
        $t = $t+$addDay;
        $target_date=date("Y-m-d", $t);
    }


$date = date_create($target_date);
$display_target_date=date_format($date, 'Y-m-d');

?>