<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;

$query7="delete from crs_tdrr_deposits_daily_summary where calyear='2019' ";

$result7=mysqli_query($connection, $query7) or die ("Couldn't execute query7. $query7");

$query8="insert into crs_tdrr_deposits_daily_summary(deposit_date_new,ncas_account,amount)
select deposit_date_new,ncas_account,sum(amount)
from crs_tdrr_deposits_daily where calyear='2019'
group by deposit_date_new,ncas_account;";

$result8=mysqli_query($connection, $query8) or die ("Couldn't execute query8. $query8");


$query9="update crs_tdrr_deposits_daily_summary
set calyear='2019',calmonth='may'
where deposit_date_new >= '20190501'
and deposit_date_new <= '20190531';";

$result9=mysqli_query($connection, $query9) or die ("Couldn't execute query9. $query9");


$query10="update crs_tdrr_deposits_daily_summary
set calyear='2019',calmonth='june'
where deposit_date_new >= '20190601'
and deposit_date_new <= '20190630';";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query10. $query10");








$query25="update project_steps_detail set status='complete' where project_category='fms'
         and project_name='daily_updates' and step_group='C' and step_num='5d'  ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");





header("location: step_group.php?project_category=fms&project_name=daily_updates&step_group=C ");



?>