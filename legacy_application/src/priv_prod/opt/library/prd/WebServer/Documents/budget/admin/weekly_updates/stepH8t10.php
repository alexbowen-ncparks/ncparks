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
echo "Under Construction";
echo "<pre>";print_r($_REQUEST);"</pre>";exit;
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


$query13="insert into crj_posted5(center,f_year,jul)
          select center,f_year,sum(amount)
          from crj_posted2
          where f_year='$fiscal_year'
		  and month='07'
          group by center,f_year,month; ";
		  
$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");

$query13a="insert into crj_posted5(center,f_year,aug)
          select center,f_year,sum(amount)
          from crj_posted2
          where f_year='$fiscal_year'
		  and month='08'
          group by center,f_year,month; ";
		  
$result13a=mysqli_query($connection, $query13a) or die ("Couldn't execute query 13a. $query13a");


$query13b="insert into crj_posted5(center,f_year,sep)
          select center,f_year,sum(amount)
          from crj_posted2
          where f_year='$fiscal_year'
		  and month='09'
          group by center,f_year,month; ";
		  
$result13b=mysqli_query($connection, $query13b) or die ("Couldn't execute query 13b. $query13b");


$query13c="insert into crj_posted5(center,f_year,oct)
          select center,f_year,sum(amount)
          from crj_posted2
          where f_year='$fiscal_year'
		  and month='10'
          group by center,f_year,month; ";
		  
$result13c=mysqli_query($connection, $query13c) or die ("Couldn't execute query 13c. $query13c");


$query13d="insert into crj_posted5(center,f_year,nov)
          select center,f_year,sum(amount)
          from crj_posted2
          where f_year='$fiscal_year'
		  and month='11'
          group by center,f_year,month; ";
		  
$result13d=mysqli_query($connection, $query13d) or die ("Couldn't execute query 13d. $query13d");


$query13e="insert into crj_posted5(center,f_year,dece)
          select center,f_year,sum(amount)
          from crj_posted2
          where f_year='$fiscal_year'
		  and month='12'
          group by center,f_year,month; ";
		  
$result13e=mysqli_query($connection, $query13e) or die ("Couldn't execute query 13e. $query13e");


$query13f="insert into crj_posted5(center,f_year,jan)
          select center,f_year,sum(amount)
          from crj_posted2
          where f_year='$fiscal_year'
		  and month='01'
          group by center,f_year,month; ";
		  
$result13f=mysqli_query($connection, $query13f) or die ("Couldn't execute query 13f. $query13f");

$query13g="insert into crj_posted5(center,f_year,feb)
          select center,f_year,sum(amount)
          from crj_posted2
          where f_year='$fiscal_year'
		  and month='02'
          group by center,f_year,month; ";
		  
$result13g=mysqli_query($connection, $query13g) or die ("Couldn't execute query 13g. $query13g");

$query13h="insert into crj_posted5(center,f_year,mar)
          select center,f_year,sum(amount)
          from crj_posted2
          where f_year='$fiscal_year'
		  and month='03'
          group by center,f_year,month; ";
		  
$result13h=mysqli_query($connection, $query13h) or die ("Couldn't execute query 13h. $query13h");


$query13j="insert into crj_posted5(center,f_year,apr)
          select center,f_year,sum(amount)
          from crj_posted2
          where f_year='$fiscal_year'
		  and month='04'
          group by center,f_year,month; ";
		  
$result13j=mysqli_query($connection, $query13j) or die ("Couldn't execute query 13j. $query13j");

$query13k="insert into crj_posted5(center,f_year,may)
          select center,f_year,sum(amount)
          from crj_posted2
          where f_year='$fiscal_year'
		  and month='05'
          group by center,f_year,month; ";
		  
$result13k=mysqli_query($connection, $query13k) or die ("Couldn't execute query 13k. $query13k");

$query13m="insert into crj_posted5(center,f_year,jun)
          select center,f_year,sum(amount)
          from crj_posted2
          where f_year='$fiscal_year'
		  and month='06'
          group by center,f_year,month; ";
		  
$result13m=mysqli_query($connection, $query13m) or die ("Couldn't execute query 13m. $query13m");

$query13n="update crj_posted5
           set total=jul+aug+sep+oct+nov+dece+jan+feb+mar+apr+may+jun
           where 1; ";
		  
$result13n=mysqli_query($connection, $query13n) or die ("Couldn't execute query 13n. $query13n");

$query13p="update crj_posted5,center
           set crj_posted5.park=center.parkcode
           where crj_posted5.center=center.center; ";
		  
$result13p=mysqli_query($connection, $query13p) or die ("Couldn't execute query 13p. $query13p");


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