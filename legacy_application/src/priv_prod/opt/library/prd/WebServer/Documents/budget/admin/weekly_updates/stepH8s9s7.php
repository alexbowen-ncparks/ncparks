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

$fyear_F2=substr($fiscal_year,0,-2);
$fyear_L2=substr($fiscal_year,-2);
//echo "fiscal_year=$fiscal_year"; echo "<br />";
//echo "first2=$fyear_F2";echo "<br />";
//echo "last2=$fyear_L2";echo "<br />";
$py1=($fyear_F2-1).($fyear_L2-1);
$py2=($fyear_F2-2).($fyear_L2-2);
$py3=($fyear_F2-3).($fyear_L2-3);
$py4=($fyear_F2-4).($fyear_L2-4);
$py5=($fyear_F2-5).($fyear_L2-5);

//if($py4=='910'){$py4="0910";}


$py6="0910";
$py7="0809";
$py8="0708";
$py9="0607";
$py10="0506";
$py11="0405";
$py12="0304";

/*
echo "fiscal_year=$fiscal_year";echo "<br />";
echo "py1=$py1";echo "<br />";
echo "py2=$py2";echo "<br />";
echo "py3=$py3";echo "<br />";
echo "py4=$py4";echo "<br />";
echo "py5=$py5";echo "<br />";
echo "py6=$py6";echo "<br />";
echo "py7=$py7";echo "<br />";
echo "py8=$py8";echo "<br />";
echo "py9=$py9";echo "<br />";
echo "py10=$py10";echo "<br />";exit;
*/

$query13="insert into vmc_posted4_v2(park,center,cy_amount)
select park,center,sum(amount) as 'cy_amount'
from vmc_posted3_v2
where f_year='$fiscal_year'
group by f_year,park,center; ";
//echo "query13=$query13";echo "<br />";exit;
$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");

$query14="insert into vmc_posted4_v2(park,center,py1_amount)
select park,center,sum(amount) as 'py1_amount'
from vmc_posted3_v2
where f_year='$py1'
group by f_year,park,center; ";
//echo "query14=$query14";echo "<br />";exit;
$result14=mysqli_query($connection, $query14) or die ("Couldn't execute query 14. $query14");

$query15="insert into vmc_posted4_v2(park,center,py2_amount)
select park,center,sum(amount) as 'py2_amount'
from vmc_posted3_v2
where f_year='$py2'
group by f_year,park,center; ";
//echo "query15=$query15";echo "<br />";exit;
$result15=mysqli_query($connection, $query15) or die ("Couldn't execute query 15. $query15");


$query16="insert into vmc_posted4_v2(park,center,py3_amount)
select park,center,sum(amount) as 'py3_amount'
from vmc_posted3_v2
where f_year='$py3'
group by f_year,park,center; ";
//echo "query16=$query16";echo "<br />";exit;
$result16=mysqli_query($connection, $query16) or die ("Couldn't execute query 16. $query16");

$query17="insert into vmc_posted4_v2(park,center,py4_amount)
select park,center,sum(amount) as 'py4_amount'
from vmc_posted3_v2
where f_year='$py4'
group by f_year,park,center; ";
//echo "query17=$query17";echo "<br />";exit;
$result17=mysqli_query($connection, $query17) or die ("Couldn't execute query 17. $query17");


$query17a="insert into vmc_posted4_v2(park,center,py5_amount)
select park,center,sum(amount) as 'py5_amount'
from vmc_posted3_v2
where f_year='$py5'
group by f_year,park,center; ";
//echo "query17a=$query17a";echo "<br />";exit;
$result17a=mysqli_query($connection, $query17a) or die ("Couldn't execute query 17a. $query17a");

$query17b="insert into vmc_posted4_v2(park,center,py6_amount)
select park,center,sum(amount) as 'py6_amount'
from vmc_posted3_v2
where f_year='$py6'
group by f_year,park,center; ";
//echo "query17b=$query17b";echo "<br />";exit;
$result17b=mysqli_query($connection, $query17b) or die ("Couldn't execute query 17b. $query17b");

$query17c="insert into vmc_posted4_v2(park,center,py7_amount)
select park,center,sum(amount) as 'py7_amount'
from vmc_posted3_v2
where f_year='$py7'
group by f_year,park,center; ";
//echo "query17c=$query17c";echo "<br />";exit;
$result17c=mysqli_query($connection, $query17c) or die ("Couldn't execute query 17c. $query17c");

$query17d="insert into vmc_posted4_v2(park,center,py8_amount)
select park,center,sum(amount) as 'py8_amount'
from vmc_posted3_v2
where f_year='$py8'
group by f_year,park,center; ";
//echo "query17d=$query17d";echo "<br />";exit;
$result17d=mysqli_query($connection, $query17d) or die ("Couldn't execute query 17d. $query17d");

$query17e="insert into vmc_posted4_v2(park,center,py9_amount)
select park,center,sum(amount) as 'py9_amount'
from vmc_posted3_v2
where f_year='$py9'
group by f_year,park,center; ";
//echo "query17e=$query17e";echo "<br />";exit;
$result17e=mysqli_query($connection, $query17e) or die ("Couldn't execute query 17e. $query17e");

$query17f="insert into vmc_posted4_v2(park,center,py10_amount)
select park,center,sum(amount) as 'py10_amount'
from vmc_posted3_v2
where f_year='$py10'
group by f_year,park,center; ";
//echo "query17f=$query17f";echo "<br />";exit;
$result17f=mysqli_query($connection, $query17f) or die ("Couldn't execute query 17f. $query17f");


$query17g="insert into vmc_posted4_v2(park,center,py11_amount)
select park,center,sum(amount) as 'py11_amount'
from vmc_posted3_v2
where f_year='$py11'
group by f_year,park,center; ";
//echo "query17f=$query17f";echo "<br />";exit;
$result17g=mysqli_query($connection, $query17g) or die ("Couldn't execute query 17g. $query17g");


$query17h="insert into vmc_posted4_v2(park,center,py12_amount)
select park,center,sum(amount) as 'py12_amount'
from vmc_posted3_v2
where f_year='$py12'
group by f_year,park,center; ";
//echo "query17f=$query17f";echo "<br />";exit;
$result17h=mysqli_query($connection, $query17h) or die ("Couldn't execute query 17h. $query17h");



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