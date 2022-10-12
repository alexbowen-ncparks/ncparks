<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
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
include("../../../../include/activity.php");// database connection parameters

$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
*/

//if($submit1=="Execute")

//{
/*
$query1="select count(whid) as 'exprev_count',sum(debit-credit) as 'exprev_amount'
from exp_rev_ws
where f_year=
'$fiscal_year'
and acctdate <=
'$end_date'
and (description like '%bank of america%'  ) 
and acct != '535675';
";
*/

$query1="select count(whid) as 'exprev_count',sum(debit-credit) as 'exprev_amount'
from exp_rev_ws
where f_year=
'$fiscal_year'
and acctdate <=
'$end_date2'
and pcardyn='y' ";



$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);
//echo "charge_amount='$charge_amount'"; //exit;
//echo "<br />echo query1=$query1<br />";

$query2="select count(id)as 'pce_count',sum(debit-credit)as 'pce_amount'
from pcard_extract
where 1
and f_year=
'$fiscal_year'
;
";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);


//$exprev_count=number_format($exprev_count,2);
//$exprev_amount=number_format($exprev_amount,2);
//$pce_count=number_format($pce_count,2);
//$pce_amount=number_format($pce_amount,2);


//echo "<br />exprev_count=$exprev_count<br />";
//echo "<br />pce_count=$pce_count<br />";
//echo "<br />exprev_amount=$exprev_amount<br />";
//echo "<br />pce_amount=$pce_amount<br />";

if($exprev_count==$pce_count){$count_balanced='y';}else{$count_balanced='n';}
if($exprev_amount==$pce_amount){$amount_balanced='y';}else{$amount_balanced='n';}

//echo "<br />count_balanced=$count_balanced<br />";
//echo "<br />amount_balanced=$amount_balanced<br />";


//exit;


if($count_balanced=='n' or $amount_balanced=='n')
{

{echo "<br /><font color='red' size='8'>Table=pcard_extract and Table=exp_rev_ws are NOT in BALANCE</font><br />"; exit;}

}


/*

if($count_balanced=='y' and $amount_balanced=='y')
{

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
         where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}


}	

*/


 
 
 ?>