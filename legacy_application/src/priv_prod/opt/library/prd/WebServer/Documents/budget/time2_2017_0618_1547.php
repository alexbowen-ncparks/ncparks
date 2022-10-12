<?php
	// Set timezone
	date_default_timezone_set('America/New_York');

	// Start date
	$date = '2017-07-01';
	$date2 = '2017-06-30';
	// End date
	$end_date = '2018-06-30';
    $hid='1265';
	
	
	
	echo "<table>";
	while (strtotime($date) <= strtotime($end_date)) {
		        $dow=date('l',strtotime($date));
                echo "<tr><td>$hid</td><td>$date</td><td>$dow</td><td>$date2</td></tr>";
				$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
				$date2 = date ("Y-m-d", strtotime("+1 day", strtotime($date2)));
				$hid++;
	}
    echo "</table>";
?>