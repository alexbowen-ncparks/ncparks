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
$y2="20".substr($f_year,-2)."0630"; // works for both weekly and daily tables

//echo "f=$f_year"; exit;

if($f_year<1112)
	{
	$sql="SELECT sum(attend_tot) as total from stats
	where year_month_week>='$y1' and year_month_week<='$y2'
	and park='$park_code'";
}
// we started recording daily attendance instead of weekly on Jan. 1, 2012
if($f_year==1112)
	{
	$sql="SELECT sum(attend_tot) as total1 from stats
	where year_month_week>='20110701' and year_month_week<='20121231'
	and park='$park_code'";
	$sql.= " UNION ";
	$sql.="SELECT sum(attend_tot) as total1 from stats_day
	where year_month_day>='20120101' and year_month_day<='20120630'
	and park like '$park_code%'";
}
if($f_year>1112)
	{
	$sql="SELECT sum(attend_tot) as total from stats_day
	where year_month_day>='$y1' and year_month_day<='$y2'
	and park like '$park_code%'";
}
//echo "$f_year $y1 $y2 <br />$sql ";
	
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_1[]=$row;
	}

if($f_year==1112)
	{
	$combine=$ARRAY_1[0]['total1'] + $ARRAY_1[1]['total1'];
	unset($ARRAY_1);
	$ARRAY_1[0]['total']=$combine;
	}
//echo "<pre>"; print_r($ARRAY_1); echo "</pre>"; // exit;

if($f_year<1112)
	{
	$sql="SELECT left(year_month_week,6) as y1,sum(attend_tot) as total from stats
	where year_month_week>='$y1' and year_month_week<='$y2'
	and park='$park_code'
	group by y1
	order by total desc";
	}
if($f_year==1112)
	{
	$sql="SELECT left(year_month_week,6) as y1,sum(attend_tot) as total from stats
	where year_month_week>='20110701' and year_month_week<='20121231'
	and park='$park_code'
	group by y1";

	$sql.=" UNION ";

	$sql.="SELECT left(year_month_day,6) as y2,sum(attend_tot) as total from stats_day
	where year_month_day>='$y1' and year_month_day<='$y2'
	and park like '$park_code%'
	group by y2";
	
$sql.=" order by total desc";
	}

//echo "$f_year $y1 $y2 $sql";
if($f_year>1112)
	{
	$sql="SELECT left(year_month_day,6) as y1,sum(attend_tot) as total from stats_day
	where year_month_day>='$y1' and year_month_day<='$y2'
	and park like '$park_code%'
	group by y1
	order by total desc";
	}
//echo "$f_year $y1 $y2 $sql";
	
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_2[]=$row;
	}

//echo "<pre>"; print_r($ARRAY_2); echo "</pre>"; // exit;
	
echo "<table cellpadding='10'><tr><td>Copy the <b>Visitation</b> info, close this window, and paste into appropriate section.</td></tr></table>";

echo "<table>";
foreach($ARRAY_1 as $index=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(!isset($value)){$value="blank";}
		$text="Visitation total for July 1, $year1 through June 30, $year2:";
		$value=number_format($value,0);
		echo "<td>$text $value</td>";
		}
	echo "</tr>";
	}
echo "</table>";

//echo "<pre>";print_r($ARRAY_2);echo "</pre>";
$count=count($ARRAY_2);

// High
$month_h1=$ARRAY_2[0]['y1'];
$month_h1=substr($month_h1,-2);
$month_h2=$ARRAY_2[1]['y1'];
$month_h2=substr($month_h2,-2);
$month_h3=$ARRAY_2[2]['y1'];
$month_h3=substr($month_h3,-2);

// Low
$month_l3=$ARRAY_2[$count-1]['y1'];
$month_l3=substr($month_l3,-2);
$month_l2=$ARRAY_2[$count-2]['y1'];
$month_l2=substr($month_l2,-2);
$month_l1=$ARRAY_2[$count-3]['y1'];
$month_l1=substr($month_l1,-2);

date_default_timezone_set('America/New_York');
$month_h1=strftime("%B", strtotime("$month_h1/01/$year1"));
$month_h2=strftime("%B", strtotime("$month_h2/01/$year1"));
$month_h3=strftime("%B", strtotime("$month_h3/01/$year1"));


$month_l3=strftime("%B", strtotime("$month_l3/01/$year1"));
$month_l2=strftime("%B", strtotime("$month_l2/01/$year1"));
$month_l1=strftime("%B", strtotime("$month_l1/01/$year1"));


$high_1=number_format($ARRAY_2[0]['total'],0);
$high_2=number_format($ARRAY_2[1]['total'],0);
$high_3=number_format($ARRAY_2[2]['total'],0);

$low_3=number_format($ARRAY_2[$count-1]['total'],0);
$low_2=number_format($ARRAY_2[$count-2]['total'],0);
$low_1=number_format($ARRAY_2[$count-3]['total'],0);

echo "<table>";
echo "<tr><td>Highest visitation - $month_h1 with $high_1</td></tr>";
echo "<tr><td>Next Highest visitation - $month_h2 with $high_2</td></tr>";
echo "<tr><td>Next Highest visitation - $month_h3 with $high_3</td></tr>";
echo "<tr><td> </td></tr>";
echo "<tr><td>Lowest visitation - $month_l3 with $low_3</td></tr>";
echo "<tr><td>Next Lowest visitation - $month_l2 with $low_2</td></tr>";
echo "<tr><td>Next Lowest visitation - $month_l1 with $low_1</td></tr>";
echo "</table>";