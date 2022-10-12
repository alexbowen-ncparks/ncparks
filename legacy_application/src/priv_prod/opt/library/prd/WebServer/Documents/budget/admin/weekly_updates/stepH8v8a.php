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
include("../../../../include/activity.php");// database c
*/



//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);




$query1="delete from report_budget_history_inc_stmt_by_fyear
where  f_year='$fiscal_year';
";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

if($back_date_yn=='n')
{
$query2="insert into report_budget_history_inc_stmt_by_fyear
(center,parkcode,f_year,disburse_amt)
select center,parkcode,'$fiscal_year',-sum(cy_amount) as 'disburse_amt'
from report_budget_history_multiyear2
where 1
and cash_type='disburse'
group by center;
";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");


$query3="insert into report_budget_history_inc_stmt_by_fyear
(center,parkcode,f_year,receipt_amt)
select center,parkcode,'$fiscal_year',sum(cy_amount) as 'receipt_amt'
from report_budget_history_multiyear2
where 1
and cash_type='receipt'
group by center;
";

mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");
}



if($back_date_yn=='y')
{
$query2="insert into report_budget_history_inc_stmt_by_fyear
(center,parkcode,f_year,disburse_amt)
select center,parkcode,'$fiscal_year',-sum(py1_amount) as 'disburse_amt'
from report_budget_history_multiyear2
where 1
and cash_type='disburse'
group by center;
";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");


$query3="insert into report_budget_history_inc_stmt_by_fyear
(center,parkcode,f_year,receipt_amt)
select center,parkcode,'$fiscal_year',sum(py1_amount) as 'receipt_amt'
from report_budget_history_multiyear2
where 1
and cash_type='receipt'
group by center;
";

mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");
}





$query4="delete from report_budget_history_inc_stmt_by_fyear
where disburse_amt='0'
and receipt_amt='0' ;
";

mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

$query5="update report_budget_history_inc_stmt_by_fyear,center
set report_budget_history_inc_stmt_by_fyear.scope='park'
where report_budget_history_inc_stmt_by_fyear.center=center.new_center
and report_budget_history_inc_stmt_by_fyear.f_year='$fiscal_year'
and center.fund='1280'
and center.actcenteryn='y'
and stateparkyn='y';
";

mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

$query6="update report_budget_history_inc_stmt_by_fyear,center
set report_budget_history_inc_stmt_by_fyear.center_description=center.center_desc
where report_budget_history_inc_stmt_by_fyear.center=center.new_center
and report_budget_history_inc_stmt_by_fyear.f_year='$fiscal_year' ;
";

mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");

$query7="update report_budget_history_inc_stmt_by_fyear
set  center_description='none'
where center_description='';
";

mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");

/*
$query8="";

mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");

$query9="";

mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");

$query10="";

mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");
*/



/*
$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category' and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category' and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}

////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}
*/


 

?>