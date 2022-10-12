<?php
	// Set timezone
	date_default_timezone_set('America/New_York');

	// Start date
	$date = '2017-07-01';
	// End date
	$end_date = '2018-06-30';
    $hid='1265';
	
	$deposit_date_dow=date('l',strtotime($deposit_date))
	
	echo "<table>";
	while (strtotime($date) <= strtotime($end_date)) {
		        $dow=date('l',strtotime($date))
                echo "<tr><td>$hid</td><td>$date</td><td>$dow</td></tr>";
				$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
				$hid++;
	}
    echo "</table>";
?>