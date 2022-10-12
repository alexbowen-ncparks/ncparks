<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";exit;
/*
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
*/
//include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

/*
$query0="SELECT py1 as 'previous_fiscal_year' from fiscal_year where report_year='$fiscal_year' ";

$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);//

echo "<br />previous_fiscal_year=$previous_fiscal_year<br />";
echo "<br />fiscal_year=$fiscal_year<br />";

exit;

// update previous fiscal year-START

$query0a="delete from report_budget_history where f_year='$previous_fiscal_year' ";
mysqli_query($connection, $query0a) or die ("Couldn't execute query 0a. $query0a");


$query0b="insert into report_budget_history
select f_year,budget_group,cash_type,acct as 'account',park_acct_desc as 'account_description',
exp_rev.center,parkcode,center.dist as 'district',sum(credit-debit) as 'amount',section,''
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
left join center on exp_rev.center=center.center
where 1
and exp_rev.center like '1680%'
and f_year='$previous_fiscal_year'
group by f_year,budget_group,acct,exp_rev.center; 
";
mysqli_query($connection, $query0b) or die ("Couldn't execute query 0b. $query0b");


$query0c="update report_budget_history,center
         set report_budget_history.parkcode=center.parkcode,
		 report_budget_history.district=center.dist,
		 report_budget_history.section=center.section
		 where report_budget_history.center=center.new_center
		 and report_budget_history.f_year='$previous_fiscal_year' ";		 

mysqli_query($connection, $query0c) or die ("Couldn't execute query 0c. $query0c");


$query0d="update report_budget_history,coa
         set report_budget_history.budget_group=coa.budget_group,
		 report_budget_history.cash_type=coa.cash_type,
		 report_budget_history.account_description=coa.park_acct_desc
		 where report_budget_history.account=coa.ncasnum";
		 
mysqli_query($connection, $query0d) or die ("Couldn't execute query 0d. $query0d");

// update previous fiscal year-END
*/

// update current fiscal year-START

$query1="delete from report_budget_history
where f_year='$fiscal_year';
";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="insert into report_budget_history(f_year,budget_group,cash_type,account,account_description,center,parkcode,district,amount,section)
select f_year,budget_group,cash_type,acct as 'account',park_acct_desc as 'account_description',
exp_rev.center,parkcode,center.dist as 'district',sum(credit-debit) as 'amount',section
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
left join center on exp_rev.center=center.center
where 1
and exp_rev.center like '1680%'
and f_year='$fiscal_year'
group by f_year,budget_group,acct,exp_rev.center; 
";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");


$query3="update report_budget_history,center
         set report_budget_history.parkcode=center.parkcode,
		 report_budget_history.district=center.dist,
		 report_budget_history.section=center.section
		 where report_budget_history.center=center.new_center
		 and report_budget_history.f_year='$fiscal_year' ";		 

mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

$query4="update report_budget_history,coa
         set report_budget_history.budget_group=coa.budget_group,
		 report_budget_history.cash_type=coa.cash_type,
		 report_budget_history.account_description=coa.park_acct_desc
		 where report_budget_history.account=coa.ncasnum ";
		 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");



$query4a="update report_budget_history set account_new=account where 1 ";
		 
mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a. $query4a");


$query4b="update report_budget_history as t1,report_budget_history_ware_corrections as t2 set t1.account_new=t2.account_new,t1.account_ware_correction='y' where t1.account=t2.account ";
		 
mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b. $query4b");


$query4c="update report_budget_history set valid_coa='n',valid_coa2='n' where 1 ";
		 
mysqli_query($connection, $query4c) or die ("Couldn't execute query 4c. $query4c");


$query4d="update report_budget_history as t1,coa as t2 set t1.valid_coa='y' where t1.account=t2.ncasnum ";
		 
mysqli_query($connection, $query4d) or die ("Couldn't execute query 4d. $query4d");


$query4e="update report_budget_history as t1,coa as t2 set t1.valid_coa2='y' where t1.account_new=t2.ncasnum ";
		 
mysqli_query($connection, $query4e) or die ("Couldn't execute query 4e. $query4e");


$query4f="update report_budget_history as t1,coa as t2 set t1.budget_group=t2.budget_group,t1.cash_type=t2.cash_type,t1.account_description=t2.park_acct_desc where t1.account_ware_correction='y' and t1.account_new=t2.ncasnum ";
		 
mysqli_query($connection, $query4f) or die ("Couldn't execute query 4f. $query4f");





// update current fiscal year-END

/*
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

*/


?>