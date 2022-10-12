<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;

$today_date=date("Ymd");

//echo "today_date=$today_date";  //exit;

$query7="delete from crs_tdrr_deposits_daily where calyear='2019' ";

$result7=mysqli_query($connection, $query7) or die ("Couldn't execute query7. $query7");




$query8="insert into crs_tdrr_deposits_daily(center_parkcode,new_center,deposit_id,deposit_date_new,ncas_account,amount,source_table)
         SELECT center_parkcode,new_center,deposit_id,deposit_date_new,ncas_account,sum(amount), 'ctdhp'
		 FROM `crs_tdrr_division_history_parks` where deposit_date_new >= '20190501' and deposit_date_new <= '20190630'
         group by center_parkcode,new_center,deposit_id,ncas_account";

$result8=mysqli_query($connection, $query8) or die ("Couldn't execute query8. $query8");



$query9="insert into crs_tdrr_deposits_daily(center_parkcode,new_center,deposit_id,deposit_date_new,ncas_account,amount,source_table)
         select 'all','all',depositid_cc,depositid_cc_last_deposit,ncas_account,sum(amount),'ctca'
         from crs_tdrr_cc_all where depositid_cc_last_deposit >= '20190501' and depositid_cc_last_deposit <= '20190630'
         group by depositid_cc,ncas_account";

$result9=mysqli_query($connection, $query9) or die ("Couldn't execute query9. $query9");

/*
$query10="insert into crs_tdrr_deposits_daily(center_parkcode,new_center,deposit_id,deposit_date_new,ncas_account,amount,source_table)
         select center.parkcode,exp_rev.center,mid(description,1,6),acctdate,acct,sum(credit-debit),'exprev'
         from exp_rev 
		 left join center on exp_rev.center=center.new_center
		 where acctdate >= '20180501' and acctdate <= '20180630'
		 and acct='434196001'
         group by mid(description,1,6),acctdate,acct";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query10. $query10");
*/

/*
$query10="insert into crs_tdrr_deposits_daily(center_parkcode,new_center,deposit_id,deposit_date_new,ncas_account,amount,source_table)
          select park,center,deposit_id,deposit_date,account,amount,'ctddm'
		  from crs_tdrr_deposits_daily_manual
		  where deposit_date >= '20190501' and deposit_date <= '20190630' 
          group by park,center,deposit_id,account ";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query10. $query10");
*/

$query11="update crs_tdrr_deposits_daily
          set calyear='2019',calmonth='may'
          where deposit_date_new >= '20190501' and deposit_date_new <= '20190531'		  ";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query11. $query11");


$query12="update crs_tdrr_deposits_daily
          set calyear='2019',calmonth='june'
          where deposit_date_new >= '20190601' and deposit_date_new <= '20190630'		  ";

$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query12. $query12");

$query12="delete from crs_tdrr_deposits_daily
          where deposit_date_new >= '$today_date'		  ";
		  
		  
//echo "<br />query12=$query12<br />";  exit;		  
		  

$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query12. $query12");



$query25="update project_steps_detail set status='complete' where project_category='fms'
         and project_name='daily_updates' and step_group='C' and step_num='5c'  ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");





header("location: step_group.php?project_category=fms&project_name=daily_updates&step_group=C ");



?>