<?php
//ini_set('display_errors',1);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;

/*
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters

*/

/*
$project_category='fms';
$project_name='weekly_updates';
$step_group='C';
$step_num='1y';

$query0="select back_date_yn,fiscal_year,start_date,end_date
         from project_steps_mode
		 where project_category='$project_category' and project_name='$project_name' "; 



$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);

$end_date=str_replace("-","",$end_date);


*/

$f_year=$fiscal_year;

//echo "f_year=$f_year"; exit;

/*
$sql="delete from exp_rev_ws where f_year='$f_year' and description != 'warehouse'
and sys != 'wa'";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query line 25. $sql");
*/

$sql="truncate table exp_rev_ws";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query line 25. $sql");




$sql="insert into exp_rev_ws(new_center,new_fund,acctdate,invoice,pe,description,debit,credit,sys,
acct,f_year,dist,debit_credit,comp,line,inv_date,check_num,ctrld,grp,vendor_num,buy_entity,po_number,pc_merchantname,agency_admin,agency_location,pc_transid,pc_transdate,pc_cardname,pc_purchdate)
select center,fund,eff_date2,doc_id,pay_entity,txn_description,debit,credit,sys,account,f_year,'',sum(debit-credit),comp,line,inv_date,check_num,ctrld,grp,vendor_num,buy_entity,po_number,pc_merchantname,agency_admin,agency_location,pc_transid,pc_transdate,pc_cardname,pc_purchdate
from exp_rev_dncr_temp_part2_dpr
where 1 and f_year='$f_year'
and valid_dpr_center='y' and valid_account_dpr='y'
group by id ";

//echo "$sql"; exit;

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query line 38. $sql");
//$af=mysql_affected_rows();


$sql="update exp_rev_ws
        set center=new_center,fund=new_fund
        where f_year='$f_year'";
		
  $result = mysqli_query($connection, $sql) or die ("Couldn't execute line 84. $sql");


$sql="update exp_rev_ws
 set month=mid(acctdate,5,2)
 where 1
 and f_year='$f_year'
 and month=''";
  $result = mysqli_query($connection, $sql) or die ("Couldn't execute line 47. $sql");
    
$sql="update exp_rev_ws
 set calyear=mid(acctdate,1,4)
 where 1
 and f_year='$f_year'
 and calyear=''";
  $result = mysqli_query($connection, $sql) or die ("Couldn't execute line 54. $sql");

$sql="update exp_rev_ws
 set acct6=mid(acct,1,6)
 where 1
 and f_year='$f_year'
 and acct6=''";
  $result = mysqli_query($connection, $sql) or die ("Couldn't execute line 61. $sql");

$sql="update exp_rev_ws
 set ciad=concat(center,'-',invoice,'-',debit_credit,'-',acctdate)
 where 1
 and f_year='$f_year'
 and ciad=''";
  $result = mysqli_query($connection, $sql) or die ("Couldn't execute line 68. $sql");

$sql="update exp_rev_ws
 set caa6=concat(center,'-',debit_credit,'-',acct6)
 where 1
 and f_year='$f_year'
 and caa6=''";
  $result = mysqli_query($connection, $sql) or die ("Couldn't execute line 75. $sql");


 /* 
  

$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

*/

//{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}



 ?>