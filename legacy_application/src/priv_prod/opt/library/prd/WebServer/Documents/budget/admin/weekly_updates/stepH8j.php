<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

/*
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
*/


//$end_date=str_replace("-","",$end_date);



//echo $end_date; exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;

//Tables used:
//budget.cab_dpr,budget.coa,budget.authorized_budget,budget.valid_fund_accounts,
//budget.project_steps_detail,budget.project_steps

/*
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
*/

//echo "<br />hello line 26<br />"; exit;

$sql="truncate table reconcilement_dpr";
mysqli_query($connection, $sql) or die ("Couldn't execute query sql.  $sql");

    
$sql="insert into reconcilement_dpr(fund,cab_dpr,bd725_dpr,exp_rev)
select fund,sum(disburse_amt-receipt_amt),'',''
from cab_dpr
where 1 and f_year='$fiscal_year'
and dpr_valid='y'
group by cab_dpr.fund";
mysqli_query($connection, $sql) or die ("Couldn't execute query sql.  $sql");


$sql="insert into reconcilement_dpr(fund,cab_dpr,bd725_dpr,exp_rev)
select fund,'',sum(disburse_amt-receipt_amt),''
from bd725_dpr
where 1 and f_year='$fiscal_year'
and dpr='y'
group by bd725_dpr.fund";
mysqli_query($connection, $sql) or die ("Couldn't execute query sql.  $sql");

$sql="insert into reconcilement_dpr(fund,cab_dpr,bd725_dpr,exp_rev)
select fund,'','',sum(debit-credit)
from exp_rev_ws
where 1 and f_year='$fiscal_year'
group by exp_rev_ws.new_fund";
mysqli_query($connection, $sql) or die ("Couldn't execute query sql.  $sql");


$sql="truncate table reconcilement_dpr2";
mysqli_query($connection, $sql) or die ("Couldn't execute query sql.  $sql");


$sql="insert into reconcilement_dpr2(fund,cab_dpr,bd725_dpr,exp_rev,oob)
select fund,cab_dpr,bd725_dpr,sum(exp_rev) as 'exp_rev', sum(cab_dpr+bd725_dpr-exp_rev) as 'oob'
from reconcilement_dpr
where 1
and (fund != '1685' and fund != '2235' and fund != '2802' and fund != '2803' and fund != '2605')
group by fund";

mysqli_query($connection, $sql) or die ("Couldn't execute query sql.  $sql");

$sql="update reconcilement_dpr2 set oob=cab_dpr+bd725_dpr-exp_rev where 1";

mysqli_query($connection, $sql) or die ("Couldn't execute query sql.  $sql");

$sql="select id from reconcilement_dpr2 where oob != '0.00' ";
//echo "<br />line 75: sql=$sql";
$result=mysqli_query($connection, $sql) or die ("Couldn't execute query sql.  $sql");

$num24=mysqli_num_rows($result);
//echo "<br />line 79: num24=$num24<br />"; exit;

if($num24!=0)
{
echo "<table align='center'><tr><td><font size='5'>TABLE=exp_rev_ws OUT of Balance</font><a href='/budget/b/reconcile.php?fy=$fiscal_year&fromTable=exp_rev_ws&submit=Submit' target='_blank'>VIEW</a></td></tr></table>";
exit;	

}


 ?>