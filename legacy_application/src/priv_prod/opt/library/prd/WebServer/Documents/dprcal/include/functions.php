<?phpfunction get_date_from_week($year, $week){global $year, $week_one_start, $week;	$first_day = strtotime($year."-01-01");	$is_monday = date("w", $first_day) == 1;	$is_weekone = strftime("%V", $first_day) == 1;	if($is_weekone)	{		$week_one_start = $is_monday ? $first_day : strtotime("last monday", $first_day);	}	else	{		$week_one_start = strtotime("next monday", $first_day);	}	return $week_one_start+(3600*24*7*($week-1)-3600*24);}/*  test code to get the week ending on Sunday$year = "2002";$week = "1";get_date_from_week($year, $week);$weekDate = date("M-d-Y", $week_one_start+(3600*24*7*($week-1)-3600*24));//$weekDate = date(M-d-Y, $week_one_start+(3600*24*7*($week-1))); original code from www.php.net*/function getWeekNumber($n){global $year, $week, $weekEnd, $n;$year = date(Y);$week = $n;$weekEnd = date("M-d-Y", get_date_from_week($year, $week));echo "Week $n ends $weekEnd";}?>