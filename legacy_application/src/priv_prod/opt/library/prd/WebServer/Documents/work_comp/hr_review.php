<?php
$database="work_comp";
$title="Worker's Comp";
include("../_base_top.php");

include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

extract($_REQUEST);
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$where="";

if($level==1)
	{
	$parkList=explode(",",$_SESSION['work_comp']['accessPark']);
	if($parkList[0]!="")
		{
		$where=" and (";
		foreach($parkList as $k=>$v)
			{
			$where.="park_code='$v' OR ";
			}
		$where=rtrim($where," OR ").")";
		}
		else
		{$where=" and park_code='".$_SESSION['work_comp']['select']."'";}
	}

 if($level<2 AND $_SESSION['work_comp']['position_title']!="Law Enforcement Supervisor")
 	{echo "You do not have access to view the submitted WC Forms. Contact your Regional Office if you need assistance."; exit;}

// if($level<2)
// 	{echo "You do not have access to view the submitted WC Forms. Contact your District Office if you need assistance."; exit;}
// 	
if($level==2)
	{
// 	echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	include("../../include/get_parkcodes_dist.php");
	$distCode=$_SESSION['reg'];
	$menuList="array".$distCode; $parkList=${$menuList};
	
		$where=" and (";
		foreach($parkList as $k=>$v)
			{
			$where.="park_code='$v' OR ";
			}
		$where=rtrim($where," OR ").")";	
		
	}

if(empty($time_limit))
	{
	date_default_timezone_set('America/New_York');
	$var=strtotime('-3 month'); 
	$time_limit=date('Y-m-d',$var)." 00:00:00"; //echo "$time_limit";
	$where.=" and timestamp > '$time_limit'";
	$since=" Only those submitted since $time_limit are shown. To see all click <a href='hr_review.php?time_limit=1'>here</a>.";
	echo "$since";
	}
	mysqli_select_db($connection, "work_comp"); // database 	
$query="SELECT t1.wc_id, t1.park_code, t1.employee_name, t1.employee_status, t1.date_of_injury, t1.wc_approved, t1.timestamp, t1.park_comments, t1.hr_comments, t2.file_link as form_19_link, t6.file_link as release_info_link, t5.file_link as emp_statement_link, t3.file_link as wc_auth_link, t4.file_link as incident_investigate_link, t7.file_link as leave_option_link, t8.file_link as refuse_treatment_link, t9.file_link as witness_statement_link
from form19 as t1
left join form19_upload as t2 on t1.wc_id=t2.wc_id
left join form_wc_auth_upload as t3 on t1.wc_id=t3.wc_id
left join form_incident_investigate_upload as t4 on t1.wc_id=t4.wc_id
left join form_employee_statement_upload as t5 on t1.wc_id=t5.wc_id
left join form_release_info_upload as t6 on t1.wc_id=t6.wc_id
left join form_leave_options_upload as t7 on t1.wc_id=t7.wc_id
left join form_refuse_treatment_upload as t8 on t1.wc_id=t8.wc_id
left join form_witness_statement_upload as t9 on t1.wc_id=t9.wc_id

where 1 $where
order by t1.wc_approved, t1.timestamp desc, t1.park_code
";
// echo "<br /><br />$query<br /><br />";   //exit;
$result = mysqli_query($connection,$query) or die ("Couldn't execute query SELECT. $query");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
if(empty($ARRAY))
	{echo "No entries have been made."; exit;}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

	
echo "<!DOCTYPE html>
<html>
<head>
<style>
form19
	{
	position:absolute;
	left:520px;
	top:100px;
	}
upload19
	{
	position:absolute;
	left:530px;
	top:200px;
	}
</style>
</head><body>";


echo "<table border='1' cellpadding='3'><tr><td colspan='17' bgcolor='beige'>Workers' Comp Review</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			$rename=str_replace("_link","",$fld);
			if($fld=="wc_approved"){$rename="entered into CCMSI";}
			if($fld=="form_19_link"){$rename="Injury Data";}
			$rename=str_replace("_"," ",$rename);
			echo "<th>$rename</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		$tdc="<td align='center'>";
		if(strpos($fld,"_link")>0)
			{
			if(!empty($value))
				{$value="<a href='$value' target='_blank'>link</a>";}
			
			}
		if($fld=="wc_id")
			{
			$value="<a href='review_submission.php?wc_id=$value'>Review</a> $value";
			}
		if($fld=="park_comments")
			{
			$tdc="<td align='left'>";
			if(strlen($value)>99){$value=substr($value,0,100)."...";}
			}
		if($fld=="hr_comments")
			{
			$tdc="<td align='left'>";
			if(strlen($value)>99){$value=substr($value,0,100)."...";}
			}
		if($fld=="employee_status")
			{
			if($value=="Seasonal")
				{$value="<font color='magenta'>$value</font>";}
			if($value=="Permanent")
				{$value="<font color='purple'>$value</font>";}
			}
		if($fld=="wc_approved")
			{
			if($value=="No")
				{$value="<font color='red'>$value</font>";}
			if($value=="Yes")
				{$value="<font color='green'>$value</font>";}
			}
		echo "$tdc$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
echo "</body></html>";
?>