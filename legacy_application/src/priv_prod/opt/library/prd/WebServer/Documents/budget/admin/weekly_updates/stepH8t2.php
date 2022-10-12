<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
echo "<h2><font color='red'>FIX Query Tony 4/19/13</font></h2>";
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
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


//$query13="truncate table rbh_multiyear_concession_fees2;";
$query13="update rbh_multiyear_concession_fees2 set cy_amount='0.00' where 1;";
$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");


$query13a0="insert into rbh_multiyear_concession_fees2 (center,park,vendor,cy_amount) select ncas_center,park,vendor_name,sum(fee_amount) from concessions_vendor_fees where f_year='1718' and post2ncas='y' group by ncas_center,park,vendor_name;";

$result13a0=mysqli_query($connection, $query13a0) or die ("Couldn't execute query 13a0. $query13a0");


/*
$query13a1="insert into rbh_multiyear_concession_fees2 (center,park,vendor,py1_amount) select ncas_center,park,vendor_name,sum(fee_amount) from concessions_vendor_fees where f_year='1617' and post2ncas='y' group by ncas_center,park,vendor_name;";

$result13a1=mysqli_query($connection, $query13a1) or die ("Couldn't execute query 13a1. $query13a1");


$query13a="insert into rbh_multiyear_concession_fees2 (center,park,vendor,py2_amount) select ncas_center,park,vendor_name,sum(fee_amount) from concessions_vendor_fees where f_year='1516' and post2ncas='y' group by ncas_center,park,vendor_name;";

$result13a=mysqli_query($connection, $query13a) or die ("Couldn't execute query 13a. $query13a");


$query13b="insert into rbh_multiyear_concession_fees2 (center,park,vendor,py3_amount) select ncas_center,park,vendor_name,sum(fee_amount) from concessions_vendor_fees where f_year='1415' and post2ncas='y' group by ncas_center,park,vendor_name;";

$result13b=mysqli_query($connection, $query13b) or die ("Couldn't execute query 13b. $query13b");


$query13c="insert into rbh_multiyear_concession_fees2 (center,park,vendor,py4_amount) select ncas_center,park,vendor_name,sum(fee_amount) from concessions_vendor_fees where f_year='1314' and post2ncas='y' group by ncas_center,park,vendor_name;";

$result13c=mysqli_query($connection, $query13c) or die ("Couldn't execute query 13c. $query13c");


$query13d="insert into rbh_multiyear_concession_fees2 (center,park,vendor,py5_amount) select ncas_center,park,vendor_name,sum(fee_amount) from concessions_vendor_fees where f_year='1213' and post2ncas='y' group by ncas_center,park,vendor_name;";

$result13d=mysqli_query($connection, $query13d) or die ("Couldn't execute query 13d. $query13d");

$query13e="insert into rbh_multiyear_concession_fees2 (center,park,vendor,py6_amount) select ncas_center,park,vendor_name,sum(fee_amount) from concessions_vendor_fees where f_year='1112' and post2ncas='y' group by ncas_center,park,vendor_name;";

$result13e=mysqli_query($connection, $query13e) or die ("Couldn't execute query 13e. $query13e");

$query13f="insert into rbh_multiyear_concession_fees2 (center,park,vendor,py7_amount) select ncas_center,park,vendor_name,sum(fee_amount) from concessions_vendor_fees where f_year='1011' and post2ncas='y' group by ncas_center,park,vendor_name;";

$result13f=mysqli_query($connection, $query13f) or die ("Couldn't execute query 13f. $query13f");

$query13g="insert into rbh_multiyear_concession_fees2 (center,park,vendor,py8_amount) select ncas_center,park,vendor_name,sum(fee_amount) from concessions_vendor_fees where f_year='0910' and post2ncas='y' group by ncas_center,park,vendor_name;";

$result13g=mysqli_query($connection, $query13g) or die ("Couldn't execute query 13g. $query13g");


$query13h="insert into rbh_multiyear_concession_fees2 (center,park,vendor,py9_amount) select ncas_center,park,vendor_name,sum(fee_amount) from concessions_vendor_fees where f_year='0809' and post2ncas='y' group by ncas_center,park,vendor_name;";

$result13h=mysqli_query($connection, $query13h) or die ("Couldn't execute query 13h. $query13h");

$query13j="insert into rbh_multiyear_concession_fees2 (center,park,vendor,py10_amount) select ncas_center,park,vendor_name,sum(fee_amount) from concessions_vendor_fees where f_year='0708' and post2ncas='y' group by ncas_center,park,vendor_name;";

$result13j=mysqli_query($connection, $query13j) or die ("Couldn't execute query 13j. $query13j");


$query13ja="insert into rbh_multiyear_concession_fees2 (center,park,vendor,py11_amount) select ncas_center,park,vendor_name,sum(fee_amount) from concessions_vendor_fees where f_year='0607' and post2ncas='y' group by ncas_center,park,vendor_name;";

$result13ja=mysqli_query($connection, $query13ja) or die ("Couldn't execute query 13ja. $query13ja");


$query13jb="insert into rbh_multiyear_concession_fees2 (center,park,vendor,py12_amount) select ncas_center,park,vendor_name,sum(fee_amount) from concessions_vendor_fees where f_year='0506' and post2ncas='y' group by ncas_center,park,vendor_name;";

$result13jb=mysqli_query($connection, $query13jb) or die ("Couldn't execute query 13jb. $query13jb");


$query13jc="insert into rbh_multiyear_concession_fees2 (center,park,vendor,py13_amount) select ncas_center,park,vendor_name,sum(fee_amount) from concessions_vendor_fees where f_year='0405' and post2ncas='y' group by ncas_center,park,vendor_name;";

$result13jc=mysqli_query($connection, $query13jc) or die ("Couldn't execute query 13jc. $query13jc");

*/









$query13k="truncate table rbh_multiyear_concession_fees3;";

$result13k=mysqli_query($connection, $query13k) or die ("Couldn't execute query 13k. $query13k");

$query13m="insert into rbh_multiyear_concession_fees3 (center,park,vendor,cy_amount,py1_amount,py2_amount,py3_amount,py4_amount,py5_amount,py6_amount,py7_amount,py8_amount,py9_amount,py10_amount,py11_amount,py12_amount,py13_amount) select center,park,vendor,sum(cy_amount),sum(py1_amount),sum(py2_amount),sum(py3_amount),sum(py4_amount),sum(py5_amount),sum(py6_amount),sum(py7_amount),sum(py8_amount),sum(py9_amount),sum(py10_amount),sum(py11_amount),sum(py12_amount),sum(py13_amount) from rbh_multiyear_concession_fees2 where 1 group by center,park,vendor;";

$result13m=mysqli_query($connection, $query13m) or die ("Couldn't execute query 13m. $query13m");


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