<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";  exit;
$today_date=date("Ymd");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
include("/opt/library/prd/WebServer/include/activity.php"); // connection parameters

$query2a1="SELECT report_date as 'report_date_4missing_rec' from pcard_report_dates where active='y' order by report_date desc limit 1 ";


//echo "query2a1=$query2a1<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result2a1 = mysqli_query($connection, $query2a1) or die ("Couldn't execute query 2a1.  $query2a1");

$row2a1=mysqli_fetch_array($result2a1);
extract($row2a1);

//echo "report_date_4missing_rec=$report_date_4missing_rec<br />";

exit;



//  Manually ADDING 1 Missing Record that was downloaded from XTND Report into MoneyCounts but did not get marked as DPR transaction. 
// (NOTE: XTND Download includes all "unreconciled transactions from DNCR including other Divisions")

//this is necessary because sometimes Rachel in Budget Office has not added PCARD/User to the "master pcard table" (table=pcard_users) at the time of XTND Download of PCARD transactions.
//Also occurs if Rachel added PCARD/User but mis-keyed the Card#
//Because of this, previous XTND downloads (which include all transactions for DNCR) may not have been MARKED as DPR employee charges.

/*
$query6="update pcard_unreconciled_xtnd_temp2_perm,pcard_users
         set pcard_unreconciled_xtnd_temp2_perm.location=pcard_users.location, 
		     pcard_unreconciled_xtnd_temp2_perm.admin_num=pcard_users.admin, 
		     pcard_unreconciled_xtnd_temp2_perm.last_name=pcard_users.last_name, 
		     pcard_unreconciled_xtnd_temp2_perm.first_name=pcard_users.first_name,
		     pcard_unreconciled_xtnd_temp2_perm.center=pcard_users.center,
		     pcard_unreconciled_xtnd_temp2_perm.xtnd_report_date='$end_date',
		     pcard_unreconciled_xtnd_temp2_perm.report_date='$end_date',			 
		     pcard_unreconciled_xtnd_temp2_perm.division='DPR_MANUAL',
		     pcard_unreconciled_xtnd_temp2_perm.backdate='y',			 
			 pcard_unreconciled_xtnd_temp2_perm.dpr='y'
             where pcard_unreconciled_xtnd_temp2_perm.card_number2=pcard_users.card_number
             and pcard_unreconciled_xtnd_temp2_perm.cardholder like concat('%',pcard_users.last_name,'%')
             and pcard_unreconciled_xtnd_temp2_perm.dpr='n'	
             and pcard_unreconciled_xtnd_temp2_perm.xtnd_report_date >= '20170831'			 ";


$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");


$query7="update pcard_unreconciled_xtnd_temp2_perm
         set primary_account_holder=concat(last_name,',',first_name)
         where xtnd_report_date='$end_date' and dpr='y' and backdate='y' ";


$result7 = mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");

$query9="insert into pcard_unreconciled(location,admin_num,post_date,trans_date,amount,vendor_name,trans_id,pcard_num,cardholder_xtnd,xtnd_rundate,transdate_new,cardholder,transid_new,postdate_new,xtnd_rundate_new,center,company,last_name,first_name,report_date)
select location,admin_num,date_posted,date_purchased,amount,merchant_name,trans_id,card_number2,cardholder,
xtnd_rundate,date_purchased_new,primary_account_holder,trans_id,date_posted_new,'$end_date2',center,company,last_name,first_name,'$end_date2'
from pcard_unreconciled_xtnd_temp2_perm
where xtnd_report_date='$end_date2' and dpr='y' ; ";


$result9 = mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");

$query9a="update pcard_unreconciled,pcard_users
set pcard_unreconciled.employee_tempid=pcard_users.employee_tempid
where pcard_unreconciled.cardholder_xtnd=pcard_users.cardholder_xtnd
and pcard_unreconciled.pcard_num=pcard_users.card_number
and pcard_unreconciled.report_date='$end_date2' "; 

$result9a = mysqli_query($connection, $query9a) or die ("Couldn't execute query 9a.  $query9a");


$query9f="select count(admin_num) as 'new_count'
from pcard_unreconciled
where report_date='$end_date2'
and admin_num='$admin_num_missing' ;"; 

$result9f = mysqli_query($connection, $query9f) or die ("Couldn't execute query 9f.  $query9f");

*/

exit;

//{header("location: aDiv/pcard_weekly_reports.php?report_date=$end_date_header");}





 
 ?>