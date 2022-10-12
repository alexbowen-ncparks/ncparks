<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//$today_date=date("Ymd");
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";//exit;
//echo "<br />"; 
//echo "today_date=$today_date";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");


//echo "<br />start_date=$start_date<br />";
//echo "<br />"; 
//echo "<br />end_date=$end_date<br />"; //exit;

$query1="update partf_fund_trans,bd725_dpr
set partf_fund_trans.bd725_active='y'
where partf_fund_trans.fund_in=bd725_dpr.fund
and bd725_dpr.f_year='1819'
and bd725_dpr.dpr='y' ";

//echo "<br />query1: $query1<br />"; exit;

mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");


$query2="truncate table bd725_dpr_carol ";

//echo "<br />query1: $query1<br />"; exit;

mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");


$query3="insert into bd725_dpr_carol(bc,fund,fund_descript,dpr,account,account_descript,ptd,f_year,cash_type)
select bc,fund,fund_descript,dpr,account,account_descript,ptd,f_year,cash_type
from bd725_dpr
where f_year='1819' and dpr='y' and cash_type='receipt' ";

//echo "<br />query1: $query1<br />"; exit;

mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");


$query4="insert into bd725_dpr_carol(bc,fund,fund_descript,dpr,account,account_descript,ptd,f_year,cash_type)
select bc,fund,fund_descript,dpr,account,account_descript,-ptd,f_year,cash_type
from bd725_dpr
where f_year='1819' and dpr='y' and cash_type='disburse' ";

//echo "<br />query1: $query1<br />"; exit;

mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");


$query5="insert into bd725_dpr_carol(bc,fund,fund_descript,dpr,account,account_descript,ptd,f_year,cash_type,acct_cat)
select '',fund_in,'','y','none','appropriations',amount,'1819','receipt','fun'
from partf_fund_trans
where trans_type='appropriations'
and bd725_active='y' ";

//echo "<br />query1: $query1<br />"; exit;

mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");


$query6="update bd725_dpr_carol,coa
set bd725_dpr_carol.acct_cat=coa.acct_cat
where bd725_dpr_carol.account=coa.ncasnum ";

//echo "<br />query1: $query1<br />"; exit;

mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");


$query7="update bd725_dpr_carol
set fund_account='y'
where (acct_cat='fun' or acct_cat='rev') ";

//echo "<br />query1: $query1<br />"; exit;

mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");


$query8="truncate table bd725_dpr_carol2 ";

//echo "<br />query1: $query1<br />"; exit;

mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");


$query9="insert into bd725_dpr_carol2(account,account_descript,cash_type,acct_cat,amount) SELECT account,account_descript,cash_type,acct_cat,sum(ptd) FROM `bd725_dpr_carol` WHERE 1 and (acct_cat='fun' or acct_cat='rev') group by account ORDER BY cash_type desc,acct_cat asc,account asc ";

//echo "<br />query1: $query1<br />"; exit;

mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");


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

{$query25="update budget.project_steps set status='complete',time_complete=unix_timestamp(now())
where project_category='$project_category' and project_name='$project_name' and step_group='$step_group' ";
		 
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");
}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}




?>