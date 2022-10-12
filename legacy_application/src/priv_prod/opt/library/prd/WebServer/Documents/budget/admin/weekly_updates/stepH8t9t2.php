<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<h2><font color='red'>FIX Query Tony 4/19/13</font></h2>";
//echo "<pre>";print_r($_REQUEST);"</pre>";echo "fiscal_year=$fiscal_year";exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

//$fiscal_year='1213';

//echo "fiscal_year=$fiscal_year";exit;

$query13="insert into crj_posted7_v2
(center,f_year,month,deposit_id,day,acctdate,amount_park)
select center,f_year,month,description,day,acctdate,sum(amount) as 'amount_park'
from crj_posted2_v2_all
where f_year='$fiscal_year' and source='park'
group by center,f_year,month,description,acctdate; ";
//echo "query13=$query13";echo "<br />";//exit;
$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");

$query14="insert into crj_posted7_v2
(center,f_year,month,deposit_id,day,acctdate,amount_2751)
select center,f_year,month,description,day,acctdate,sum(amount) as 'amount_2751'
from crj_posted2_v2_all
where f_year='$fiscal_year' and source='2751'
group by center,f_year,month,description,acctdate; ";
//echo "query14=$query14";echo "<br />";//exit;
$result14=mysqli_query($connection, $query14) or die ("Couldn't execute query 14. $query14");

$query15="insert into crj_posted7_v2
(center,f_year,month,deposit_id,day,acctdate,amount_1000)
select center,f_year,month,description,day,acctdate,sum(amount) as 'amount_1000'
from crj_posted2_v2_all
where f_year='$fiscal_year' and source='1000'
group by center,f_year,month,description,acctdate; ";
//echo "query15=$query15";echo "<br />";//exit;
$result15=mysqli_query($connection, $query15) or die ("Couldn't execute query 15. $query15");

$query16="update crj_posted7_v2,center
set crj_posted7_v2.park=center.parkcode
where crj_posted7_v2.center=center.center ; ";
//echo "query16=$query16";echo "<br />";exit;
$result16=mysqli_query($connection, $query16) or die ("Couldn't execute query 16. $query16");


$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}





?>