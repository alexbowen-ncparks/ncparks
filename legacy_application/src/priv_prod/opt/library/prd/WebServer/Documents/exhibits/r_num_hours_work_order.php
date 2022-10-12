<?php
session_start();
if($_SESSION['work_order']['level']<4){exit;}
ini_set('display_errors',1);
extract ($_REQUEST);

if(empty($connection_i))
	{
	$db="mns";
	include("../../include/connect_mysqli.inc"); // database connection parameters
	}

$sql = "SELECT sum(t2.time) as hours, t1.work_order_number
FROM `work_order` as t1
left join work_order_workers as t2 on t1.work_order_number=t2.work_order_number
where date_completed!=''
group by t2.work_order_number
order by hours desc";  //echo "$sql"; exit;
	
$result = mysqli_query($connection_i,$sql) or die ("Couldn't execute query 1. $sql");
$check_hours="";
while($row=mysqli_fetch_assoc($result))
	{
	if($row['hours']!=$hours){continue;}
	$report_array[]=$row['work_order_number'];	
	}
	
@mysqli_free_result($result);

//echo "<pre>"; print_r($report_array); echo "</pre>";  exit;

$clause=" (";
foreach($report_array as $k=>$v)
{
$clause.="t1.work_order_number='".$v."' OR ";
}
$clause=rtrim($clause," OR ").")";
//echo "$clause"; exit;
$special_report=1;
include("search.php");
	
?>