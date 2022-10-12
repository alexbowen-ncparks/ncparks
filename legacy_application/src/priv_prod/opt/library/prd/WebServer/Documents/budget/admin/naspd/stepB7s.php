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


$query0="update bd725_dpr_exp_rec
set fun_total_transfers_yes=fun_partf+fun_nhtf+fun_cwmtf+fun_bond+fun_lwcf+fun_rtp+fun_other+fun_approp+fun_transfers
where 1 and f_year='$fiscal_year' ";
		
		
//echo "<br />query0=$query0<br />"; exit;		
			 
mysqli_query($connection, $query0) or die ("Couldn't execute query0.  $query0");


$query1="update bd725_dpr_exp_rec
set fun_total_transfers_no=fun_partf+fun_nhtf+fun_cwmtf+fun_bond+fun_lwcf+fun_rtp+fun_other+fun_approp
where 1 and f_year='$fiscal_year' ";
		
		
//echo "<br />query1=$query1<br />"; exit;		
			 
mysqli_query($connection, $query1) or die ("Couldn't execute query1.  $query1");

$query2="update bd725_dpr_exp_rec
set partf_per=fun_partf/fun_total_transfers_no
where 1 and f_year='$fiscal_year' ";
		
		
//echo "<br />query2=$query2<br />"; exit;		
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query2.  $query2");

$query3="update bd725_dpr_exp_rec
set nhtf_per=fun_nhtf/fun_total_transfers_no
where 1 and f_year='$fiscal_year' ";
		
		
//echo "<br />query3=$query3<br />"; exit;		
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query3.  $query3");


$query4="update bd725_dpr_exp_rec
set cwmtf_per=fun_cwmtf/fun_total_transfers_no
where 1 and f_year='$fiscal_year' ";
		
		
//echo "<br />query4=$query4<br />"; exit;		
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query4.  $query4");


$query5="update bd725_dpr_exp_rec
set bond_per=fun_bond/fun_total_transfers_no
where 1 and f_year='$fiscal_year' ";
		
		
//echo "<br />query5=$query5<br />"; exit;		
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query5.  $query5");


$query6="update bd725_dpr_exp_rec
set lwcf_per=fun_lwcf/fun_total_transfers_no
where 1 and f_year='$fiscal_year' ";
		
		
//echo "<br />query6=$query6<br />"; exit;		
			 
mysqli_query($connection, $query6) or die ("Couldn't execute query6.  $query6");

$query7="update bd725_dpr_exp_rec
set rtp_per=fun_rtp/fun_total_transfers_no
where 1 and f_year='$fiscal_year' ";
		
		
//echo "<br />query7=$query7<br />"; exit;		
			 
mysqli_query($connection, $query7) or die ("Couldn't execute query7.  $query7");


$query8="update bd725_dpr_exp_rec
set other_per=fun_other/fun_total_transfers_no
where 1 and f_year='$fiscal_year' ";
		
		
//echo "<br />query8=$query8<br />"; exit;		
			 
mysqli_query($connection, $query8) or die ("Couldn't execute query8.  $query8");


$query9="update bd725_dpr_exp_rec
set approp_per=fun_approp/fun_total_transfers_no
where 1 and f_year='$fiscal_year' ";
		
		
//echo "<br />query9=$query9<br />"; exit;		
			 
mysqli_query($connection, $query9) or die ("Couldn't execute query9.  $query9");


$query10="update bd725_dpr_exp_rec
set total_per=partf_per+nhtf_per+cwmtf_per+bond_per+lwcf_per+rtp_per+other_per+approp_per
where 1 and f_year='$fiscal_year' ";
		
		
//echo "<br />query10=$query10<br />"; exit;		
			 
mysqli_query($connection, $query10) or die ("Couldn't execute query10.  $query10");




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