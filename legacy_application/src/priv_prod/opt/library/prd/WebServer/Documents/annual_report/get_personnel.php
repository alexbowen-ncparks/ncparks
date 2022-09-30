<?php
ini_set('display_errors',1);
session_start();
$level=$_SESSION['annual_report']['level'];
if($level<2){@$park_code=$_SESSION['annual_report']['select'];}

$database="divper";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database 

extract($_REQUEST);

if($type=="permanent")
	{
	$sql="SELECT concat(t1.beacon_num, '-',t1.posTitle, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',if(t3.Fname is NULL,'vacant', concat(t3.Fname, ' ',t3.Lname))) as name
	FROM `position` as t1
	left join emplist as t2 on t1.beacon_num=t2.beacon_num
	left join empinfo as t3 on t2.tempID=t3.tempID
	where park='$park_code' and section='OPER'
	order by t1.o_chart,t3.Lname";
	$fy="for $park_code";
	}
	else
	{
	$sql="SELECT concat(t1.beacon_posnum, '-',t1.osbm_title, ' (Hours=', t1.budget_hrs_a, ') @',' ' ,t1.avg_rate_new) as position
	FROM `hr`.`seasonal_payroll_next` as t1
	where center_code='$park_code' and div_app='y' and park_approve='y' and fiscal_year='$f_year'
	order by t1.osbm_title";
	$fy= "for FY=$f_year";
	}
$personnel_array=array();	
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$personnel_array[]=$row;
	}

$count=count($personnel_array);

echo "<table cellpadding='10'><tr><td>Copy the <b>$type</b> info, close this window, and paste into appropriate section.</td></tr></table>";

echo "<table><tr><td>$count $type positions $fy at $park_code</td></tr>";
foreach($personnel_array as $index=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(!isset($value)){$value="vacant";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";