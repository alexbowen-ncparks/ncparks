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

//fun_partf
$query0="update bd725_dpr_exp_rec,bd725_dpr_account_detail3_rec_summary
set bd725_dpr_exp_rec.fun_partf=bd725_dpr_account_detail3_rec_summary.ptd
where
bd725_dpr_exp_rec.center=bd725_dpr_account_detail3_rec_summary.center
and bd725_dpr_account_detail3_rec_summary.funding_type='partf'
and bd725_dpr_exp_rec.f_year='$fiscal_year' 
and bd725_dpr_account_detail3_rec_summary.f_year='$fiscal_year' ";
		
		
//echo "<br />query0=$query0<br />"; exit;		
			 
mysqli_query($connection, $query0) or die ("Couldn't execute query0.  $query0");

//fun_nhtf
$query1="update bd725_dpr_exp_rec,bd725_dpr_account_detail3_rec_summary
set bd725_dpr_exp_rec.fun_nhtf=bd725_dpr_account_detail3_rec_summary.ptd
where
bd725_dpr_exp_rec.center=bd725_dpr_account_detail3_rec_summary.center
and bd725_dpr_account_detail3_rec_summary.funding_type='nhtf'
and bd725_dpr_exp_rec.f_year='$fiscal_year' 
and bd725_dpr_account_detail3_rec_summary.f_year='$fiscal_year' ";
		
		
//echo "<br />query1=$query1<br />"; exit;		
			 
mysqli_query($connection, $query1) or die ("Couldn't execute query1.  $query1");

//fun_cwmtf
$query2="update bd725_dpr_exp_rec,bd725_dpr_account_detail3_rec_summary
set bd725_dpr_exp_rec.fun_cwmtf=bd725_dpr_account_detail3_rec_summary.ptd
where
bd725_dpr_exp_rec.center=bd725_dpr_account_detail3_rec_summary.center
and bd725_dpr_account_detail3_rec_summary.funding_type='cwmtf'
and bd725_dpr_exp_rec.f_year='$fiscal_year' 
and bd725_dpr_account_detail3_rec_summary.f_year='$fiscal_year' ";
		
		
//echo "<br />query2=$query2<br />"; exit;		
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query2.  $query2");

//fun_bond
$query3="update bd725_dpr_exp_rec,bd725_dpr_account_detail3_rec_summary
set bd725_dpr_exp_rec.fun_bond=bd725_dpr_account_detail3_rec_summary.ptd
where
bd725_dpr_exp_rec.center=bd725_dpr_account_detail3_rec_summary.center
and bd725_dpr_account_detail3_rec_summary.funding_type='bond'
and bd725_dpr_exp_rec.f_year='$fiscal_year' 
and bd725_dpr_account_detail3_rec_summary.f_year='$fiscal_year' ";
		
		
//echo "<br />query3=$query3<br />"; exit;		
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query3.  $query3");

//fun_lwcf
$query4="update bd725_dpr_exp_rec,bd725_dpr_account_detail3_rec_summary
set bd725_dpr_exp_rec.fun_lwcf=bd725_dpr_account_detail3_rec_summary.ptd
where
bd725_dpr_exp_rec.center=bd725_dpr_account_detail3_rec_summary.center
and bd725_dpr_account_detail3_rec_summary.funding_type='lwcf'
and bd725_dpr_exp_rec.f_year='$fiscal_year' 
and bd725_dpr_account_detail3_rec_summary.f_year='$fiscal_year' ";
		
		
//echo "<br />query4=$query4<br />"; exit;		
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query4.  $query4");



$query5="update bd725_dpr_exp_rec,bd725_dpr_account_detail3_rec_summary
set bd725_dpr_exp_rec.fun_rtp=bd725_dpr_account_detail3_rec_summary.ptd
where
bd725_dpr_exp_rec.center=bd725_dpr_account_detail3_rec_summary.center
and bd725_dpr_account_detail3_rec_summary.funding_type='rtp'
and bd725_dpr_exp_rec.f_year='$fiscal_year' 
and bd725_dpr_account_detail3_rec_summary.f_year='$fiscal_year' ";
		
		
//echo "<br />query5=$query5<br />"; exit;		
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query5.  $query5");


$query6="update bd725_dpr_exp_rec,bd725_dpr_account_detail3_rec_summary
set bd725_dpr_exp_rec.fun_other=bd725_dpr_account_detail3_rec_summary.ptd
where
bd725_dpr_exp_rec.center=bd725_dpr_account_detail3_rec_summary.center
and bd725_dpr_account_detail3_rec_summary.funding_type='other'
and bd725_dpr_exp_rec.f_year='$fiscal_year' 
and bd725_dpr_account_detail3_rec_summary.f_year='$fiscal_year' ";
		
		
//echo "<br />query6=$query6<br />"; exit;		
			 
mysqli_query($connection, $query6) or die ("Couldn't execute query6.  $query6");


$query7="update bd725_dpr_exp_rec,bd725_dpr_account_detail3_rec_summary
set bd725_dpr_exp_rec.fun_approp=bd725_dpr_account_detail3_rec_summary.ptd
where
bd725_dpr_exp_rec.center=bd725_dpr_account_detail3_rec_summary.center
and bd725_dpr_account_detail3_rec_summary.funding_type='appropriation'
and bd725_dpr_exp_rec.f_year='$fiscal_year' 
and bd725_dpr_account_detail3_rec_summary.f_year='$fiscal_year' ";
		
		
//echo "<br />query7=$query7<br />"; exit;		
			 
mysqli_query($connection, $query7) or die ("Couldn't execute query7.  $query7");


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