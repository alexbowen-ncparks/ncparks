<?php
ini_set('display_errors',1);
session_start();
$level=$_SESSION['annual_report']['level'];
if($level<2){@$park_code=$_SESSION['annual_report']['select'];}

$database="park_use";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database 

extract($_REQUEST);

$year1="20".substr($f_year,0,2);
$year2="20".substr($f_year,-2);

$y1="20".substr($f_year,0,2)."0701";
$y2="20".substr($f_year,-2)."0630";

$y1_1="20".substr($f_year,0,2)."07";
$y2_1="20".substr($f_year,-2)."06";

// Community Service Workers hours and number
$sql="SELECT csw_hours, csw_number
from stats_day
where `year_month_day`>='$y1' and `year_month_day`<='$y2'
and park like '$park_code%'";
//echo "$f_year $y1 $y2 $sql";
	
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_csw_hrs[]=$row['csw_hours'];
	$ARRAY_csw_num[]=$row['csw_number'];
	}
// echo "$sql <pre>"; print_r($ARRAY_csw_hrs); echo "</pre>"; // exit;
$total_csw_hours=array_sum($ARRAY_csw_hrs);
$total_csw_numbers=array_sum($ARRAY_csw_num);


// Volunteer hours and number
$sql="SELECT *
from vol_stats
where `year_month`>='$y1_1' and `year_month`<='$y2_1'
and park = '$park_code'
";
// echo "$f_year $y1 $y2 $sql";
	
$tot_vol_hours=array();

$item_array=array("admin_hours","camp_host_hours","trail_hours","ie_hours","main_hours","research_hours","res_man_hours","other_hours");
foreach($item_array as $index=>$fld)
	{
	$tot_vol_numbers[$fld]=0;
	}
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	foreach($row as $fld=>$val)
		{
		if(in_array($fld,$item_array))
			{
			$tot_vol_numbers[$fld]+=$val;
			}
		}
		
	$ARRAY_vol_num[]=$row['Lname'].$row['Fname'];
	}
// echo "$sql <pre>"; print_r($tot_vol_numbers); echo "</pre>"; // exit;
$total_fld_hours=array_sum($tot_vol_hours);
$total_vol_hours=array_sum($tot_vol_hours);
$total_vol_numbers=count(array_unique($ARRAY_vol_num));



// Recycling
$sql="SELECT *
from recycle_stats
where `year_month`>='$y1_1' and `year_month`<='$y2_1'
and park = '$park_code'
";
// echo "$f_year $y1 $y2 $sql";
	

$item_array=array("aluminum","plastic","glass","metal","paper","cardboard","co_mingled","other_recycle");
foreach($item_array as $index=>$fld)
	{
	$tot_recycle_pounds[$fld]=0;
	}
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	foreach($row as $fld=>$val)
		{
		if(in_array($fld,$item_array))
			{
			$tot_recycle_pounds[$fld]+=$val;
			}
		}
	
	}
// echo "$sql <pre>"; print_r($tot_recycle_pounds); echo "</pre>"; // exit;

$sql="SELECT *
from litter_events
where `date_`>='$y1' and `date_`<='$y2'
and park='$park_code'";
//echo "$f_year $y1 $y2 $sql";
	
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_1[]=$row;
	}
//echo "<pre>";print_r($ARRAY_1);echo "</pre>";
$rename=array("csw_number"=>"Number of offenders: ","csw_hours"=>"Hours worked: ");

$skip=array("id","park");
$tot_staff=0;
$tot_num_vol=0;
$tot_bags=0;
$tot_hours=0;
$tot_pounds=0;
$num_hours=0;
$num_pounds=0;

echo "<table cellpadding='10'><tr><td>Copy the <b>CSW Stats</b> for July 1, $year1 through June 30, $year2 and paste into appropriate section in other tab.
<br />Number of CSW: $total_csw_numbers<br />CSW hours: $total_csw_hours</td></tr></table>";

$tot_vol=0;
echo "<table cellpadding='0'><tr><td>Copy the <b>Volunteer Stats</b> for July 1, $year1 through June 30, $year2 and paste into appropriate section in other tab. </td></tr>";
if(!empty($tot_vol_numbers))
	{
	foreach($tot_vol_numbers as $item=>$value)
		{
		$tot_vol+=$value;
		echo "<tr><td>Hours of $item worked:</td><td align='right'>$value</td></tr>";
		}
	echo "<tr><td colspan='2' align='right'>Total hours: $tot_vol</td></tr>";
	}

echo "</table>";

$tot_recyle=0;
echo "<table cellpadding='1'><tr><td colspan='3'>Copy the <b>Recycling Stats</b> for July 1, $year1 through June 30, $year2 and paste into appropriate section. </td></tr>";
if(!empty($tot_recycle_pounds))
	{
	foreach($tot_recycle_pounds as $item=>$pounds)
		{
		$tot_recyle+=$pounds;
		echo "<tr><td>Pounds of $item recycled:</td><td align='right'>$pounds</td></tr>";
		}
	echo "<tr><td colspan='2' align='right'>Total poundage: $tot_recyle</td></tr>";
	}

echo "</table>";

echo "<table cellpadding='10'><tr><td>Copy the <b>Litter Stat</b> info, close this window, and paste into appropriate section.</td></tr></table>";

echo "<table><tr><td>Litter Stat totals for July 1, $year1 through June 30, $year2:</td></tr>";
if(isset($ARRAY_1))
	{
	foreach($ARRAY_1 as $index=>$array)
		{
// 		echo "<tr><td>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip) OR $value=="0"){continue;}
			if(!isset($value)){$value="blank";}
			if(is_numeric($value))
				{
				if($fld=="num_staff"){$tot_staff+=$value;}
				if($fld=="num_vol"){$tot_num_vol+=$value;}
				if($fld=="num_bags"){$tot_bags+=$value;}
				if($fld=="num_hours"){$tot_hours+=$value;}
				if($fld=="num_pounds"){$tot_pounds+=$value;}
				}
	//		$fld=$rename[$fld];
// 			echo "<b>$fld</b> = $value&nbsp;&nbsp;&nbsp;";
			}
// 		echo "</td></tr>";
		}
	echo "<tr><td>Total Staff = $tot_staff</td></tr>";
	echo "<tr><td>Total Volunteers = $tot_num_vol</td></tr>";
	echo "<tr><td>Total Hours = $tot_hours</td></tr>";
	echo "<tr><td>Total Bags = $tot_bags</td></tr>";
	echo "<tr><td>Total Pounds = $tot_pounds</td></tr>";
	echo "</table>";
	}
	else
	{
	echo "<tr><td>None</td></tr></table>";
	}