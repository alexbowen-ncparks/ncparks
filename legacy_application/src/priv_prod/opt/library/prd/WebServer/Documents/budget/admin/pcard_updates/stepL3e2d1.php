<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

$end_date_header=$end_date;
$start_date2=str_replace("-","",$start_date);
$end_date2=str_replace("-","",$end_date);

//echo "start_date2=$start_date2<br />";
//echo "end_date2=$end_date2<br />";

//exit;




$query1="insert ignore into pcard_unreconciled_xtnd_temp2_perm
(`xtnd_report_date`, `cardholder`, `division`, `pcard_users_match`, `post_date`, `trans_date`, `amount`, `merchant_name`, `city_state`, `trans_id`, `card_number`, `card_number2`, `dpr`, `admin_num`, `location`, `date_posted_new`, `date_purchased_new`, `company`, `center`, `last_name`, `first_name`, `report_date`, `account_id`, `document`, `date_posted`, `date_purchased`, `primary_account_holder`, `purchase_amount`, `vendor`, `amount_allocated`)
SELECT `xtnd_report_date`, `cardholder`, `division`, `pcard_users_match`, `post_date`, `trans_date`, `amount`, `merchant_name`, `city_state`, `trans_id`, `card_number`, `card_number2`, `dpr`, `admin_num`, `location`, `date_posted_new`, `date_purchased_new`, `company`, `center`, `last_name`, `first_name`, `report_date`, `account_id`, `document`, `date_posted`, `date_purchased`, `primary_account_holder`, `purchase_amount`, `vendor`, `amount_allocated`
from pcard_unreconciled_xtnd_temp2 where 1 ";
		  
		  
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query2="update pcard_unreconciled_xtnd_temp2_perm
set xtnd_rundate=concat(mid(xtnd_report_date,6,2),'/',mid(xtnd_report_date,9,2),'/',mid(xtnd_report_date,3,2))
where 1 and xtnd_report_date='$end_date2' ";
	
//echo "query2=$query2<br />";  exit;	
		  
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="update pcard_unreconciled_xtnd_temp2_perm
         set card_number=card_number2
         where 1 and xtnd_report_date='$end_date2' ";
		  
		  
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


$query4="update pcard_unreconciled_xtnd_temp2_perm
         set center=''
		 where center='none'
		 and xtnd_report_date='$end_date2' ";


//echo "<br />query4=$query4<br />";  exit;



$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");



//stepL3e2d1a.php


$query5="insert ignore into pcard_unreconciled_xtnd_temp2_perm_unique(cardholder,division,card_number2,dpr)
select cardholder,division,card_number2,dpr
from pcard_unreconciled_xtnd_temp2_perm
where 1
group by cardholder,division,card_number2,dpr; ";
		  
		  
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");



//stepL3e2d1b.php
//this is necessary because sometimes the weekly download from XTND includes DPR employee charges, BUT Rachel in Budget Office has not added PCARD/User to the "master pcard table" (table=pcard_users)
//Because of this, previous XTND downloads (which include all transactions for DNCR) may not have been MARKED as DPR employee charges.
// this is trying to identify transactions from "previous weeks" that were not previously identified as DPR Charges but now match a RECORD in Table=pcard_users
//Basically Rachel in Budget Office added DPR PCARD/USER "AFTER pcard transaction(s)" showed in my download.

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


//echo "<br />query6=$query6<br />";	//exit;

$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");


$query7="update pcard_unreconciled_xtnd_temp2_perm
         set primary_account_holder=concat(last_name,',',first_name)
         where xtnd_report_date='$end_date' and dpr='y' and backdate='y' ";


//echo "<br />query7=$query7<br />";	

$result7 = mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");


//stepL3e2d3.php

$query8="truncate table budget.pcard_unreconciled_xtnd; ";
mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");

$query8a="truncate table budget.pcard_unreconciled_xtnd_temp; ";
mysqli_query($connection, $query8a) or die ("Couldn't execute query 8a. $query8a");

$query8b="truncate table budget.pcard_unreconciled_xtnd_temp2; ";
mysqli_query($connection, $query8b) or die ("Couldn't execute query 8b. $query8b");


//stepL3e2d4.php


$query9="insert into pcard_unreconciled(location,admin_num,post_date,trans_date,amount,vendor_name,trans_id,pcard_num,cardholder_xtnd,xtnd_rundate,transdate_new,cardholder,transid_new,postdate_new,xtnd_rundate_new,center,company,last_name,first_name,report_date)
select location,admin_num,date_posted,date_purchased,amount,merchant_name,trans_id,card_number2,cardholder,
xtnd_rundate,date_purchased_new,primary_account_holder,trans_id,date_posted_new,'$end_date2',center,company,last_name,first_name,'$end_date2'
from pcard_unreconciled_xtnd_temp2_perm
where xtnd_report_date='$end_date2' and dpr='y' ; ";


//echo "<br />query9=$query9<br />";  exit;

$result9 = mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");


$query9a="update pcard_unreconciled,pcard_users
set pcard_unreconciled.employee_tempid=pcard_users.employee_tempid
where pcard_unreconciled.cardholder_xtnd=pcard_users.cardholder_xtnd
and pcard_unreconciled.pcard_num=pcard_users.card_number
and pcard_unreconciled.report_date='$end_date2' "; 

$result9a = mysqli_query($connection, $query9a) or die ("Couldn't execute query 9a.  $query9a");

$query9b="update pcard_unreconciled
          set admin_num='eadi'
		  where admin_num='core' 
		  and report_date >= '20171201' "; 

$result9b = mysqli_query($connection, $query9b) or die ("Couldn't execute query 9b.  $query9b");


$query9c="update pcard_unreconciled
          set admin_num='sodi'
		  where admin_num='pire'
          and report_date >= '20171201' "; 
		 

$result9c = mysqli_query($connection, $query9c) or die ("Couldn't execute query 9c.  $query9c");


$query9d="update pcard_unreconciled
          set admin_num='wedi'
		  where admin_num='more' 
		  and report_date >= '20171201' "; 
		  
		   

$result9d = mysqli_query($connection, $query9d) or die ("Couldn't execute query 9d.  $query9d");





$query9e="update pcard_report_dates
         set active='y',active_date='$today_date' where report_date='$end_date2' "; 

$result9e = mysqli_query($connection, $query9e) or die ("Couldn't execute query 9e.  $query9e");


$query9f="insert into pcard_report_dates_compliance(report_date,admin_num,record_count)
select report_date,admin_num,count(admin_num)
from pcard_unreconciled
where report_date='$end_date2'
group by admin_num;"; 

$result9f = mysqli_query($connection, $query9f) or die ("Couldn't execute query 9f.  $query9f");


$query23a="update budget.project_substeps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' and substep_num='$substep_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_substeps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and step_num='$step_num' and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);


{header("location: ../../../budget/aDiv/pcard_weekly_reports.php?report_date=$end_date_header");}


 
 ?>