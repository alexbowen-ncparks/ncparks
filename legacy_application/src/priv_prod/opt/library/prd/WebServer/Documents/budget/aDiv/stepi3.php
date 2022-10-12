<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST); echo "</pre>";//exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");
echo "start_date=$start_date";
echo "<br />"; 
echo "end_date=$end_date";//exit;
echo "<br />"; 
echo "today_date=$today_date";exit;

include("../../../../include/connectBUDGET.inc");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="delete from budget_center_allocations
where budget_group='operating_expenses'
and fy_req=
'$fiscal_year'
and allocation_justification='approved_equipment_purchase';";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="insert into budget_center_allocations(center,ncas_acct,fy_req,equipment_request,user_id,allocation_level,allocation_amount,allocation_justification,allocation_date,budget_group,entrydate,comments)
select 
pay_center,
'533900',
'$fiscal_year',
'',
'',
'budget_office',
-sum(requested_amount),
'approved_equipment_purchase',
system_entry_date,
'operating_expenses',
'$today_date',
concat('er',er_num) as 'er_num'
from equipment_request_3
where 1
and f_year=
'$fiscal_year'
and division_approved='y'
and ncas_account like '534%'
and status='active'
and funding_source='opex_transfer'
group by id;";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$query3="delete from budget_center_allocations
where budget_group='equipment'
and fy_req=
'$fiscal_year'
and allocation_justification='approved_equipment_purchase';";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

$query4="insert into budget_center_allocations(center,ncas_acct,fy_req,equipment_request,user_id,allocation_level,allocation_amount,allocation_justification,allocation_date,budget_group,entrydate,comments)
select pay_center,ncas_account,f_year,'','','division', sum(ordered_amount),'approved_equipment_purchase','system_entry_date','equipment',
'$today_date',concat('er',er_num) as 'er_num'
from equipment_request_3
where 1
and f_year=
'$fiscal_year'
and division_approved='y'
and order_complete='y'
and ncas_account like '534%'
and status='active'
group by er_num;";
mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

$query5="insert into budget_center_allocations(center,ncas_acct,fy_req,equipment_request,user_id,allocation_level,allocation_amount,allocation_justification,allocation_date,budget_group,entrydate)
select pay_center,ncas_account,f_year,'','','division',sum(unit_quantity*unit_cost),'approved_equipment_purchase','system_entry_date','equipment',
'$today_date'
from equipment_request_3
where 1
and f_year=
'$fiscal_year'
and division_approved='y'
and order_complete='n'
and ncas_account like '534%'
and status='active'
group by er_num;";
mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

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




?>

























