<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
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

$query0="select max(calyear) as 'current_calyear' from report_budget_history_calyear where 1";
//echo "<br />query0=$query0<br />";
$result0=mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");
$row0=mysqli_fetch_array($result0);
extract($row0);

$previous_calyear=$current_calyear-1;
//$previous_calyear2=$current_calyear-2;


//echo "<br />current_calyear=$current_calyear<br />";
//echo "<br />previous_calyear=$previous_calyear<br />";

//exit;


$query1="
truncate table report_budget_history_monthly_cyear; ";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");


$query2="
insert into report_budget_history_monthly_cyear(c_year,account,center,january)
select calyear,account,center,sum(amount)
from report_budget_history_calyear
where calyear='$current_calyear'
and month='01'
group by calyear,account,center; ";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");


$query3="
insert into report_budget_history_monthly_cyear(c_year,account,center,february)
select calyear,account,center,sum(amount)
from report_budget_history_calyear
where calyear='$current_calyear'
and month='02'
group by calyear,account,center; ";

mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

$query4="
insert into report_budget_history_monthly_cyear(c_year,account,center,march)
select calyear,account,center,sum(amount)
from report_budget_history_calyear
where calyear='$current_calyear'
and month='03'
group by calyear,account,center; ";

mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

$query5="
insert into report_budget_history_monthly_cyear(c_year,account,center,april)
select calyear,account,center,sum(amount)
from report_budget_history_calyear
where calyear='$current_calyear'
and month='04'
group by calyear,account,center; ";

mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

$query6="
insert into report_budget_history_monthly_cyear(c_year,account,center,may)
select calyear,account,center,sum(amount)
from report_budget_history_calyear
where calyear='$current_calyear'
and month='05'
group by calyear,account,center; ";

mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");

$query7="
insert into report_budget_history_monthly_cyear(c_year,account,center,june)
select calyear,account,center,sum(amount)
from report_budget_history_calyear
where calyear='$current_calyear'
and month='06'
group by calyear,account,center; ";

mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");

$query8="
insert into report_budget_history_monthly_cyear(c_year,account,center,july)
select calyear,account,center,sum(amount)
from report_budget_history_calyear
where calyear='$current_calyear'
and month='07'
group by calyear,account,center; ";

mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");

$query9="
insert into report_budget_history_monthly_cyear(c_year,account,center,august)
select calyear,account,center,sum(amount)
from report_budget_history_calyear
where calyear='$current_calyear'
and month='08'
group by calyear,account,center; ";

mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");

$query10="
insert into report_budget_history_monthly_cyear(c_year,account,center,september)
select calyear,account,center,sum(amount)
from report_budget_history_calyear
where calyear='$current_calyear'
and month='09'
group by calyear,account,center; ";

mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");


$query11="
insert into report_budget_history_monthly_cyear(c_year,account,center,october)
select calyear,account,center,sum(amount)
from report_budget_history_calyear
where calyear='$current_calyear'
and month='10'
group by calyear,account,center; ";

mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$query12="
insert into report_budget_history_monthly_cyear(c_year,account,center,november)
select calyear,account,center,sum(amount)
from report_budget_history_calyear
where calyear='$current_calyear'
and month='11'
group by calyear,account,center; ";

mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");

$query13="
insert into report_budget_history_monthly_cyear(c_year,account,center,december)
select calyear,account,center,sum(amount)
from report_budget_history_calyear
where calyear='$current_calyear'
and month='12'
group by calyear,account,center; ";

mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");

$query14="
delete from report_budget_history_monthly_cyear2
where c_year='$current_calyear'; ";

mysqli_query($connection, $query14) or die ("Couldn't execute query 14. $query14");

$query15="
insert into report_budget_history_monthly_cyear2
(c_year,account,center,january,february,march,april,may,june,july,august,september,october,november,december)
select c_year,account,center,
sum(january),sum(february),sum(march),sum(april),sum(may),sum(june),sum(july),sum(august),sum(september),sum(october),sum(november),sum(december)
from report_budget_history_monthly_cyear
where c_year='$current_calyear'
group by c_year,account,center; ";

mysqli_query($connection, $query15) or die ("Couldn't execute query 15. $query15");

$query16="
update report_budget_history_monthly_cyear2,coa
set report_budget_history_monthly_cyear2.account_description=coa.park_acct_desc
 where report_budget_history_monthly_cyear2.account=coa.ncasnum; ";

mysqli_query($connection, $query16) or die ("Couldn't execute query 16. $query16");

$query17="
update report_budget_history_monthly_cyear2,center
set report_budget_history_monthly_cyear2.center_description=center.center_desc
 where report_budget_history_monthly_cyear2.center=center.new_center; ";

mysqli_query($connection, $query17) or die ("Couldn't execute query 17. $query17");

$query18="
update report_budget_history_monthly_cyear2
set total=january+february+march+april+may+june+july+august+september+october+november+december
where 1; ";

mysqli_query($connection, $query18) or die ("Couldn't execute query 18. $query18");


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