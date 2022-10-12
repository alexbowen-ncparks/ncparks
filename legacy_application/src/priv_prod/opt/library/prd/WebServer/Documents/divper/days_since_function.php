<?php
if(empty($f_year))
	{
	ini_set('date.timezone', 'America/New_York');
	$testMonth=date('n');
	if($testMonth >0 and $testMonth<9){$year2=date('Y')-1;}
	if($testMonth >8){$year2=date('Y');}
	$yearNext=$year2+1;
	$yx=substr($year2,2,2);
	$year3=$yearNext;$yy=substr($year3,2,2);
	$f_year=$yx.$yy;
	
	if(@$prev_year=="prev")
		{
		$yx=substr(($year2-1),2,2);
		$yy=substr(($year3-1),2,2);
		$f_year=$yx.$yy;
		}
	
	$pf_year=$yx=substr(($year2-1),2,2);
	$yy=substr(($year3-1),2,2);
	$pf_year=$yx.$yy;
	}
$f_year_array=array($f_year, $pf_year);

if(empty($pass_f_year))
	{$pass_f_year=$pf_year;}
	
$holiday_array=array();
$sql = "SELECT `date` From hiring_form_holidays
WHERE 1 and f_year='$pass_f_year'
ORDER by id";
// echo "$sql"; exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
$i=0;
while ($row=mysqli_fetch_assoc($result))
	{
// echo "<pre>"; print_r($row); echo "</pre>"; // exit;
	if(($i==0 )and $row['date']=="0000-00-00")
		{
	//	include("hiring_form_menu.php");
		echo "No Holidays have been entered for fy $pass_f_year."; 
		exit;
		}
	$i++;
	$exp=explode("-",$row['date']);
	$t = mktime( 0, 0, 0, $exp[1], $exp[2], $exp[0] );
	$holiday_array[]=$t;
	}
if(empty($holiday_array))
	{
	echo "No Holidays have been entered for fy $pass_f_year."; 
	echo "<br /><br /><a href='hiring_form_holidays.php'>Update Holidays</a> for $pass_f_year"; 
	
		exit;
	}
// echo "<pre>"; print_r($holiday_array); echo "</pre>";  exit;	

function days_since($vacated, $today) 
	{
	global $holiday_array;
	if(empty($vacated)){echo "There is an issue with the date vacated."; exit;}
	$exp=explode("-",$vacated);
	$var_vacate = mktime( 0, 0, 0, $exp[1], $exp[2], $exp[0] );
	
	if(empty($today)){$today=date("Y-m-d");}
//	$today="2014-04-10";
	$exp=explode("-",$today);
	$var_today = mktime( 0, 0, 0, $exp[1], $exp[2], $exp[0] );
//echo " 1=$var_vacate 2=$t"; exit;
	// loop for X days
	$i=0;
	$j=0;
	while($var_vacate<$var_today)
		{
		$i++;
		$j++;
		// add 1 day to timestamp
		$addDay = 86400;

		// get what day it is next day
		$nextDay = date('w', ($var_vacate+$addDay));

		// if it's Saturday or Sunday get $i-1
		if($nextDay == 0 || $nextDay == 6)
			{
			$i--;
			}

		// if it's a Holiday get $i-1
		if(in_array(($var_vacate+$addDay),$holiday_array))
			{
			$i--;
			}

		// modify timestamp, add 1 day
		$var_vacate = $var_vacate+$addDay;

	//	$target_date=date("Y-m-d", $t);
		}

//	$date = date_create($target_date);
//	$display_target_date=date_format($date, 'Y-m-d');
	return  "$j*$i";
	}

?>