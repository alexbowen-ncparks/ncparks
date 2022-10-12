<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;

$query7="update crs_tdrr_deposits_daily_summary2,crs_tdrr_deposits_daily_summary
set crs_tdrr_deposits_daily_summary2.`434140003`=crs_tdrr_deposits_daily_summary.`amount`
where crs_tdrr_deposits_daily_summary2.`deposit_date_new`=crs_tdrr_deposits_daily_summary.`deposit_date_new`
and crs_tdrr_deposits_daily_summary.`ncas_account`='434140003'
and crs_tdrr_deposits_daily_summary.calyear='2019' and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7=mysqli_query($connection, $query7) or die ("Couldn't execute query7. $query7");


$query7a="update crs_tdrr_deposits_daily_summary2,crs_tdrr_deposits_daily_summary
set crs_tdrr_deposits_daily_summary2.`434150004`=crs_tdrr_deposits_daily_summary.`amount`
where crs_tdrr_deposits_daily_summary2.`deposit_date_new`=crs_tdrr_deposits_daily_summary.`deposit_date_new`
and crs_tdrr_deposits_daily_summary.`ncas_account`='434150004'
and crs_tdrr_deposits_daily_summary.calyear='2019' and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7a=mysqli_query($connection, $query7a) or die ("Couldn't execute query7a. $query7a");


$query7b="update crs_tdrr_deposits_daily_summary2,crs_tdrr_deposits_daily_summary
set crs_tdrr_deposits_daily_summary2.`434196001`=crs_tdrr_deposits_daily_summary.`amount`
where crs_tdrr_deposits_daily_summary2.`deposit_date_new`=crs_tdrr_deposits_daily_summary.`deposit_date_new`
and crs_tdrr_deposits_daily_summary.`ncas_account`='434196001'
and crs_tdrr_deposits_daily_summary.calyear='2019' and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7b=mysqli_query($connection, $query7b) or die ("Couldn't execute query7b. $query7b");

$query7c="update crs_tdrr_deposits_daily_summary2,crs_tdrr_deposits_daily_summary
set crs_tdrr_deposits_daily_summary2.`434196002`=crs_tdrr_deposits_daily_summary.`amount`
where crs_tdrr_deposits_daily_summary2.`deposit_date_new`=crs_tdrr_deposits_daily_summary.`deposit_date_new`
and crs_tdrr_deposits_daily_summary.`ncas_account`='434196002'
and crs_tdrr_deposits_daily_summary.calyear='2019' and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7c=mysqli_query($connection, $query7c) or die ("Couldn't execute query7c. $query7c");


$query7d="update crs_tdrr_deposits_daily_summary2,crs_tdrr_deposits_daily_summary
set crs_tdrr_deposits_daily_summary2.`000434390`=crs_tdrr_deposits_daily_summary.`amount`
where crs_tdrr_deposits_daily_summary2.`deposit_date_new`=crs_tdrr_deposits_daily_summary.`deposit_date_new`
and crs_tdrr_deposits_daily_summary.`ncas_account`='000434390'
and crs_tdrr_deposits_daily_summary.calyear='2019' and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7d=mysqli_query($connection, $query7d) or die ("Couldn't execute query7d. $query7d");


$query7e="update crs_tdrr_deposits_daily_summary2,crs_tdrr_deposits_daily_summary
set crs_tdrr_deposits_daily_summary2.`000434410`=crs_tdrr_deposits_daily_summary.`amount`
where crs_tdrr_deposits_daily_summary2.`deposit_date_new`=crs_tdrr_deposits_daily_summary.`deposit_date_new`
and crs_tdrr_deposits_daily_summary.`ncas_account`='000434410'
and crs_tdrr_deposits_daily_summary.calyear='2019' and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7e=mysqli_query($connection, $query7e) or die ("Couldn't execute query7e. $query7e");

$query7f="update crs_tdrr_deposits_daily_summary2,crs_tdrr_deposits_daily_summary
set crs_tdrr_deposits_daily_summary2.`434410001`=crs_tdrr_deposits_daily_summary.`amount`
where crs_tdrr_deposits_daily_summary2.`deposit_date_new`=crs_tdrr_deposits_daily_summary.`deposit_date_new`
and crs_tdrr_deposits_daily_summary.`ncas_account`='434410001'
and crs_tdrr_deposits_daily_summary.calyear='2019' and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7f=mysqli_query($connection, $query7f) or die ("Couldn't execute query7f. $query7f");

$query7g="update crs_tdrr_deposits_daily_summary2,crs_tdrr_deposits_daily_summary
set crs_tdrr_deposits_daily_summary2.`434410002`=crs_tdrr_deposits_daily_summary.`amount`
where crs_tdrr_deposits_daily_summary2.`deposit_date_new`=crs_tdrr_deposits_daily_summary.`deposit_date_new`
and crs_tdrr_deposits_daily_summary.`ncas_account`='434410002'
and crs_tdrr_deposits_daily_summary.calyear='2019' and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7g=mysqli_query($connection, $query7g) or die ("Couldn't execute query7g. $query7g");


$query7h="update crs_tdrr_deposits_daily_summary2,crs_tdrr_deposits_daily_summary
set crs_tdrr_deposits_daily_summary2.`434410003`=crs_tdrr_deposits_daily_summary.`amount`
where crs_tdrr_deposits_daily_summary2.`deposit_date_new`=crs_tdrr_deposits_daily_summary.`deposit_date_new`
and crs_tdrr_deposits_daily_summary.`ncas_account`='434410003'
and crs_tdrr_deposits_daily_summary.calyear='2019' and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7h=mysqli_query($connection, $query7h) or die ("Couldn't execute query7h. $query7h");


$query7j="update crs_tdrr_deposits_daily_summary2,crs_tdrr_deposits_daily_summary
set crs_tdrr_deposits_daily_summary2.`434410004`=crs_tdrr_deposits_daily_summary.`amount`
where crs_tdrr_deposits_daily_summary2.`deposit_date_new`=crs_tdrr_deposits_daily_summary.`deposit_date_new`
and crs_tdrr_deposits_daily_summary.`ncas_account`='434410004'
and crs_tdrr_deposits_daily_summary.calyear='2019' and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7j=mysqli_query($connection, $query7j) or die ("Couldn't execute query7j. $query7j");


$query7k="update crs_tdrr_deposits_daily_summary2,crs_tdrr_deposits_daily_summary
set crs_tdrr_deposits_daily_summary2.`434410006`=crs_tdrr_deposits_daily_summary.`amount`
where crs_tdrr_deposits_daily_summary2.`deposit_date_new`=crs_tdrr_deposits_daily_summary.`deposit_date_new`
and crs_tdrr_deposits_daily_summary.`ncas_account`='434410006'
and crs_tdrr_deposits_daily_summary.calyear='2019' and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7k=mysqli_query($connection, $query7k) or die ("Couldn't execute query7k. $query7k");


$query7m="update crs_tdrr_deposits_daily_summary2,crs_tdrr_deposits_daily_summary
set crs_tdrr_deposits_daily_summary2.`434410007`=crs_tdrr_deposits_daily_summary.`amount`
where crs_tdrr_deposits_daily_summary2.`deposit_date_new`=crs_tdrr_deposits_daily_summary.`deposit_date_new`
and crs_tdrr_deposits_daily_summary.`ncas_account`='434410007'
and crs_tdrr_deposits_daily_summary.calyear='2019' and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7m=mysqli_query($connection, $query7m) or die ("Couldn't execute query7m. $query7m");


$query7n="update crs_tdrr_deposits_daily_summary2,crs_tdrr_deposits_daily_summary
set crs_tdrr_deposits_daily_summary2.`434410008`=crs_tdrr_deposits_daily_summary.`amount`
where crs_tdrr_deposits_daily_summary2.`deposit_date_new`=crs_tdrr_deposits_daily_summary.`deposit_date_new`
and crs_tdrr_deposits_daily_summary.`ncas_account`='434410008'
and crs_tdrr_deposits_daily_summary.calyear='2019' and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7n=mysqli_query($connection, $query7n) or die ("Couldn't execute query7n. $query7n");


$query7p="update crs_tdrr_deposits_daily_summary2,crs_tdrr_deposits_daily_summary
set crs_tdrr_deposits_daily_summary2.`000434420`=crs_tdrr_deposits_daily_summary.`amount`
where crs_tdrr_deposits_daily_summary2.`deposit_date_new`=crs_tdrr_deposits_daily_summary.`deposit_date_new`
and crs_tdrr_deposits_daily_summary.`ncas_account`='000434420'
and crs_tdrr_deposits_daily_summary.calyear='2019' and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7p=mysqli_query($connection, $query7p) or die ("Couldn't execute query7p. $query7p");

$query7r="update crs_tdrr_deposits_daily_summary2,crs_tdrr_deposits_daily_summary
set crs_tdrr_deposits_daily_summary2.`435200008`=crs_tdrr_deposits_daily_summary.`amount`
where crs_tdrr_deposits_daily_summary2.`deposit_date_new`=crs_tdrr_deposits_daily_summary.`deposit_date_new`
and crs_tdrr_deposits_daily_summary.`ncas_account`='435200008'
and crs_tdrr_deposits_daily_summary.calyear='2019' and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7r=mysqli_query($connection, $query7r) or die ("Couldn't execute query7r. $query7r");

$query7s="update crs_tdrr_deposits_daily_summary2,crs_tdrr_deposits_daily_summary
set crs_tdrr_deposits_daily_summary2.`435200009`=crs_tdrr_deposits_daily_summary.`amount`
where crs_tdrr_deposits_daily_summary2.`deposit_date_new`=crs_tdrr_deposits_daily_summary.`deposit_date_new`
and crs_tdrr_deposits_daily_summary.`ncas_account`='435200009'
and crs_tdrr_deposits_daily_summary.calyear='2019' and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7s=mysqli_query($connection, $query7s) or die ("Couldn't execute query7s. $query7s");

$query7t="update crs_tdrr_deposits_daily_summary2,crs_tdrr_deposits_daily_summary
set crs_tdrr_deposits_daily_summary2.`000435700`=crs_tdrr_deposits_daily_summary.`amount`
where crs_tdrr_deposits_daily_summary2.`deposit_date_new`=crs_tdrr_deposits_daily_summary.`deposit_date_new`
and crs_tdrr_deposits_daily_summary.`ncas_account`='000435700'
and crs_tdrr_deposits_daily_summary.calyear='2019' and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7t=mysqli_query($connection, $query7t) or die ("Couldn't execute query7t. $query7t");

$query7v="update crs_tdrr_deposits_daily_summary2,crs_tdrr_deposits_daily_summary
set crs_tdrr_deposits_daily_summary2.`435700006`=crs_tdrr_deposits_daily_summary.`amount`
where crs_tdrr_deposits_daily_summary2.`deposit_date_new`=crs_tdrr_deposits_daily_summary.`deposit_date_new`
and crs_tdrr_deposits_daily_summary.`ncas_account`='435700006'
and crs_tdrr_deposits_daily_summary.calyear='2019' and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7v=mysqli_query($connection, $query7v) or die ("Couldn't execute query7v. $query7v");

$query7w="update crs_tdrr_deposits_daily_summary2,crs_tdrr_deposits_daily_summary
set crs_tdrr_deposits_daily_summary2.`435900001`=crs_tdrr_deposits_daily_summary.`amount`
where crs_tdrr_deposits_daily_summary2.`deposit_date_new`=crs_tdrr_deposits_daily_summary.`deposit_date_new`
and crs_tdrr_deposits_daily_summary.`ncas_account`='435900001'
and crs_tdrr_deposits_daily_summary.calyear='2019' and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7w=mysqli_query($connection, $query7w) or die ("Couldn't execute query7w. $query7w");

$query7x="update crs_tdrr_deposits_daily_summary2
set total=`434140003`+`434150004`+`434196001`+`434196002`+ `000434390`+ `000434410`+ `434410001`+ `434410002`+ `434410003`+ `434410004`+ `434410006`+ `434410007`+ `434410008`+ `000434420`+ `435200008`+ `435200009`+ `000435700`+ `435700006`+`435900001`
where 1
and crs_tdrr_deposits_daily_summary2.calyear='2019' ";

$result7x=mysqli_query($connection, $query7x) or die ("Couldn't execute query7x. $query7x");


$query8="update crs_tdrr_deposits_daily_summary,coa
set crs_tdrr_deposits_daily_summary.dncr='y'
where crs_tdrr_deposits_daily_summary.ncas_account=coa.ncasnum2
and coa.dncr_daily_deposits='y'
and crs_tdrr_deposits_daily_summary.calyear='2019' ";

$result8=mysqli_query($connection, $query8) or die ("Couldn't execute query8. $query8");


$query8a="update crs_tdrr_deposits_daily,center
          set crs_tdrr_deposits_daily.center_parkcode=center.parkcode
		  where crs_tdrr_deposits_daily.new_center=center.new_center ";

$result8a=mysqli_query($connection, $query8a) or die ("Couldn't execute query8a. $query8a");












$query25="update project_steps_detail set status='complete' where project_category='fms'
         and project_name='daily_updates' and step_group='C' and step_num='5e'  ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");





header("location: step_group.php?project_category=fms&project_name=daily_updates&step_group=C ");



?>