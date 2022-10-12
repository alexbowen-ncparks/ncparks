<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

//echo "<br />Hello Line 25 park_purchase_request_reset.php<br />";
//exit;


$today_date=date("Y-m-d");
$query20="select report_date as 'report_date_current1',id as 'id1',f_year as 'f_year2' 
          FROM `purchase_approval_report_dates`
		  WHERE 1 and active='y'
		  order by id desc 
		  limit 1	 ";

//echo "query20=$query20<br />";


$result20 = mysqli_query($connection, $query20) or die ("Couldn't execute query 20.  $query20");

$row20=mysqli_fetch_array($result20);
extract($row20);

$today_date2=str_replace("-","",$today_date);
$report_date_current2=str_replace("-","",$report_date_current1);


//echo "<br />today_date2=$today_date2<br />";
//echo "<br />report_date_current2=$report_date_current2<br />";

//exit;

if($today_date2 > $report_date_current2)
{
	
$query_compliance="insert into preapproval_report_dates_compliance(report_date,fiscal_year,center_code,district,record_count)
select report_date,f_year,center_code,district,count(id)
from purchase_request_3
where report_date='$report_date_current2'
group by center_code,report_date";

//echo "<br />query_compliance=$query_compliance<br />";
//exit;

$result_query_compliance = mysqli_query($connection, $query_compliance) or die ("Couldn't execute query compliance.  $query_compliance");

// added on 06/20/20:  sets center_approved=y for District Office "purchase requests" only. This eliminates the need for District Managers to REVIEW District Office Requests as both "Center Manager" and "District Manager"

$query_compliance2="update preapproval_report_dates_compliance set center_approved='y' where report_date='$report_date_current2' and (center_code='eadi' or center_code='sodi' or center_code='nodi' or center_code='wedi') ";

//echo "<br />query_compliance2=$query_compliance2<br />";
//exit;

$result_query_compliance2 = mysqli_query($connection, $query_compliance2) or die ("Couldn't execute query compliance2.  $query_compliance2");


// Added on 9/17/20

$query_compliance3="insert ignore into preapproval_report_dates_compliance(fiscal_year,report_date,center_code,district,section,record_count)
SELECT '$f_year2','$report_date_current2',parkcode,dist,section,'0' from center where preapproval_required='y'";

//echo "<br />query_compliance3=$query_compliance3<br />";
//exit;

$result_query_compliance3 = mysqli_query($connection, $query_compliance3) or die ("Couldn't execute query compliance3.  $query_compliance3");



$report_date_new=date_create("$report_date_current1");
date_sub($report_date_new,date_interval_create_from_date_string("-7 days"));
$report_date_new_ymd=date_format($report_date_new,"Ymd");

$start_date_new=date_create("$report_date_current1");
date_sub($start_date_new,date_interval_create_from_date_string("-1 days"));
$start_date_new_ymd=date_format($start_date_new,"Ymd");

$end_date_new_ymd=$report_date_new_ymd;

//echo "<br />report_date_new_ymd=$report_date_new_ymd<br />";
//echo "<br />start_date_new_ymd=$start_date_new_ymd<br />";
//echo "<br />end_date_new_ymd=$end_date_new_ymd<br />";


$query20a="select report_year as 'report_year1'
           from fiscal_year 
		   where start_date <= '$report_date_new_ymd' and end_date >= '$report_date_new_ymd' ";

//echo "query20a=$query20a<br />";


$result20a = mysqli_query($connection, $query20a) or die ("Couldn't execute query 20a.  $query20a");

$row20a=mysqli_fetch_array($result20a);
extract($row20a);
//echo "<br />report_year1=$report_year1<br />";
	
$query20b="insert into purchase_approval_report_dates set report_date='$report_date_new_ymd',system_start='$start_date_new_ymd',system_end='$end_date_new_ymd',f_year='$report_year1',active='y' ";

//echo "query20b=$query20b<br />";


$result20b = mysqli_query($connection, $query20b) or die ("Couldn't execute query 20b.  $query20b");
	
}
/*
if($today_date2 <= $report_date_current2)
{
echo "<br /><font color='red'>No New Report Needed</font><br />";
}
*/


?>
