<?php


session_start();
echo "f_year=$f_year";
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;
echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
//Tables used:
//budget.cab_dpr,budget.coa,budget.authorized_budget,budget.valid_fund_accounts,
//budget.project_steps_detail,budget.project_steps

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$query1="delete from `report_user_activity` where fyear='$f_year' ";

//echo "query1=$query1";exit;
			 
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query2="
insert into report_user_activity
(user_level,tempid,user_browser,position,posnum,beacon_num,location,centersess,filename,time1,time2,fyear)
select 
user_level,tempid,user_browser,position,posnum,beacon_num,location,centersess,filename,time1,time2,f_year
from activity_1314
where 1 
and f_year='$f_year' ";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

/*
$query2a="REPAIR TABLE `report_user_activity` ";

mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");
*/

/*
$query3="
update report_user_activity
set cyear=mid(time2,1,4)
where 1 ";

mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
*/

/*
$query4="
update report_user_activity
set fyear='$fiscal_year'
where 1 ";

mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
*/

/*

$query5="
update report_user_activity
set month_number=mid(time2,5,2)
where 1 ";

mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
 */
 
$query6="
update report_user_activity
set tempid1=left(tempid,char_length(tempid)-2)
where 1 ";

mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6"); 


$query7="
update report_user_activity,tempid_centers
set report_user_activity.postitle=tempid_centers.postitle
where report_user_activity.tempid=tempid_centers.tempid
";

mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7"); 


$query8="
update report_user_activity,tempid_centers_manual
set report_user_activity.postitle=tempid_centers_manual.postitle
where report_user_activity.tempid=tempid_centers_manual.tempid
";

mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8"); 


$query9="
update report_user_activity,activity_filegroups
set report_user_activity.filegroup=activity_filegroups.filegroup
where report_user_activity.filename=activity_filegroups.filename
";

mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9"); 







/*
$query9="
update report_user_activity set fyear='1314'
where fyear='' ";

mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9"); 

*/




 

 ?>




















