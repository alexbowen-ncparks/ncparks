<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

 
$query1="delete from budget.cab_dpr
where f_year='$fiscal_year' "; 

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query2="truncate table budget.cab_dpr_center"; 

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="delete from budget.bd725_dpr
where f_year='$fiscal_year' "; 

mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$query4="truncate table budget.xtnd_po_encumbrances"; 

mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

//$query5="truncate table budget.xtnd_ci_monthly_manual"; 
$query5="update budget.xtnd_ci_monthly_manual set balance='0',status='pending' where 1"; 

mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$query6="Truncate table budget.pcard_unreconciled_xtnd"; 

mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$query7="delete from budget.xtnd_vendor_payments
where f_year='$fiscal_year' "; 

mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");

$query7a="delete from budget.xtnd_vendor_payments_tax
where f_year='$fiscal_year' "; 

mysqli_query($connection, $query7a) or die ("Couldn't execute query 7a.  $query7a");


$query8="truncate table budget.commitments"; 

mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");


$query8a="truncate table budget.pcard_utility_xtnd_1646_down"; 

mysqli_query($connection, $query8a) or die ("Couldn't execute query 8a.  $query8a");

$query8b="truncate table budget.pcard_utility_xtnd_1646_ws"; 

mysqli_query($connection, $query8b) or die ("Couldn't execute query 8b.  $query8b");



$query9="update project_steps_detail set status='complete' 
        where project_category='$project_category' and project_name='$project_name'
		and step_group= '$step_group' and step_num= '$step_num' "; 

mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");

$query10="select * from project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");

$num10=mysqli_num_rows($result10);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num10==0)

{$query11="update project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");}

if($num10==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num10!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}

 
 ?>




















