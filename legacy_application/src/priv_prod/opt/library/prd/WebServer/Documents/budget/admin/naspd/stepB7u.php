<?php
//ini_set('display_errors',1);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

//echo "<br />fiscal_year=$fiscal_year<br />"; exit;


$query0="delete from bd725_naspd6 where f_year='$fiscal_year' ";
		
		
//echo "<br />query0=$query0<br />"; exit;		
			 
mysqli_query($connection, $query0) or die ("Couldn't execute query0.  $query0");


$query1="insert into bd725_naspd6(center,center_description,project_type,f_year,exp,partf,nhtf,cwmtf,bond,lwcf,rtp,other,approp)
select center,center_description,project_type,f_year,sum(exp),sum(partf),sum(nhtf),sum(cwmtf),sum(bond),sum(lwcf),sum(rtp),sum(other),sum(approp)
from bd725_dpr_exp_rec
where 1
and f_year='$fiscal_year'
group by center";
		
		
//echo "<br />query1=$query1<br />"; exit;		
			 
mysqli_query($connection, $query1) or die ("Couldn't execute query1.  $query1");


$query2="update bd725_naspd6,bd725_dpr_account_detail3_exp
set bd725_naspd6.new_fund='y'
where bd725_naspd6.center=bd725_dpr_account_detail3_exp.center
and bd725_naspd6.f_year='$fiscal_year'
and bd725_dpr_account_detail3_exp.f_year='$fiscal_year'
and bd725_dpr_account_detail3_exp.new_fund='y'

";
		
		
//echo "<br />query2=$query2<br />"; exit;		
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query2.  $query2");














$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category' and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");


/*

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}

*/


////mysql_close();

/*

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0) 
//{echo "num24 not equal to zero";}

*/

{header("location: naspd_annual.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&f_year=$fiscal_year&report_type=form");}

 ?>