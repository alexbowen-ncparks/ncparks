<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";  exit;
//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date"; //exit;
/*
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
*/


//echo "submit1=$submit1";echo "submit2=$submit2";exit;


/*
$today_date=date("Ymd");
//echo "<br />today_date=$today_date"; //exit;
$query1="ALTER TABLE exp_rev RENAME exp_rev_$today_date ";
//echo "<br />$query1";//exit;
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="ALTER TABLE exp_rev_ws RENAME exp_rev ";
//echo "<br />$query2";exit;
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
*/


//Determine the MAX fiscal year in TABLE=exp_rev
$query0="select max(f_year) as 'exp_rev_fyear' from exp_rev where 1 ";

$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);


//Determine the MAX fiscal year in TABLE=exp_rev_ws
$query0a="select max(f_year) as 'exp_rev_ws_fyear' from exp_rev_ws where 1 ";

$result0a = mysqli_query($connection, $query0a) or die ("Couldn't execute query 0a.  $query0a");

$row0a=mysqli_fetch_array($result0a);
extract($row0a);


//If MAX fiscal year in TABLE="exp_rev" is not equal to MAX fiscal year in TABLE="exp_rev_ws", then 


if($exp_rev_fyear != $exp_rev_ws_fyear){$beg_of_year_equip_adjust='y';}else{$beg_of_year_equip_adjust='n';}

//echo "<br />exp_rev_fyear=$exp_rev_fyear<br />";
//echo "<br />exp_rev_ws_fyear=$exp_rev_ws_fyear<br />";
//echo "<br />beg_of_year_equip_adjust=$beg_of_year_equip_adjust<br />";

//exit;


if($beg_of_year_equip_adjust=='y')
{
$query3="insert into budget_center_allocations(center,ncas_acct,fy_req,allocation_level,allocation_amount,allocation_justification,budget_group,entrydate)
SELECT center,acct,'$exp_rev_ws_fyear','division',-sum(debit-credit),'reverse_last_year','equipment','$first_day_of_fyear' 
FROM `exp_rev`
WHERE `f_year` LIKE '$exp_rev_fyear' and acct like '534%' and center like '1680%' group by center,acct";


//echo "<br />query3=$query3<br />";
//exit;


$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");	
	
}

/*
if($beg_of_year_equip_adjust=='n')
{

echo "<br />Equipment Adjustment NOT Needed<br />";
exit;


//$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");	
	
}
echo "<br />Line 97<br />";
exit;

*/



$query1="delete from exp_rev where f_year='$fiscal_year' ";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");



$query2="insert into exp_rev(`center`, `new_center`, `old_center`, `fund`, `new_fund`, `old_fund`, `acctdate`, `invoice`, `pe`, `description`, `debit`, `credit`, `sys`, `acct`, `f_year`, `dist`, `debit_credit`, `acct6`, `ciad`, `caa6`, `month`, `calyear`, `ciad_count`, `pcard_vendor`, `pcard_user`, `pcard_trans_date`, `vendor_description`, `pcardyn`, `ciaadd`, `ciaa`, `cvip_match`, `caa`, `pcard_transid`, `acct_description`, `cash_type2`, `budget`, `center_description`, `park`, `proj_dncr`, `comp`, `line`, `inv_date`, `check_num`, `ctrld`, `grp`, `vendor_num`, `buy_entity`, `po_number`, `pc_merchantname`, `agency_admin`, `agency_location`, `pc_transid`, `pc_transdate`, `pc_cardname`, `pc_purchdate`)
select `center`, `new_center`, `old_center`, `fund`, `new_fund`, `old_fund`, `acctdate`, `invoice`, `pe`, `description`, `debit`, `credit`, `sys`, `acct`, `f_year`, `dist`, `debit_credit`, `acct6`, `ciad`, `caa6`, `month`, `calyear`, `ciad_count`, `pcard_vendor`, `pcard_user`, `pcard_trans_date`, `vendor_description`, `pcardyn`, `ciaadd`, `ciaa`, `cvip_match`, `caa`, `pcard_transid`, `acct_description`, `cash_type2`, `budget`, `center_description`, `park`, `proj_dncr`, `comp`, `line`, `inv_date`, `check_num`, `ctrld`, `grp`, `vendor_num`, `buy_entity`, `po_number`, `pc_merchantname`, `agency_admin`, `agency_location`, `pc_transid`, `pc_transdate`, `pc_cardname`, `pc_purchdate`
from exp_rev_ws where 1";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");









?>