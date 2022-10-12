<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<h2><font color='red'>FIX Query Tony 4/19/13</font></h2>";
//echo "<pre>";print_r($_REQUEST);"</pre>";echo "fiscal_year=$fiscal_year";exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date"; exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

//$fiscal_year='1314';

//echo "fiscal_year=$fiscal_year";exit;

$query13="insert into crj_posted5_v2(center,f_year,jul)
select center,f_year,sum(amount) as 'jul'
from crj_posted2_v2_all
where f_year='$fiscal_year'
and month='07'
group by center,f_year,month; ";
//echo "query13=$query13";echo "<br />";//exit;
$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");

$query14="insert into crj_posted5_v2(center,f_year,aug)
select center,f_year,sum(amount) as 'aug'
from crj_posted2_v2_all
where f_year='$fiscal_year'
and month='08'
group by center,f_year,month; ";
//echo "query14=$query14";echo "<br />";//exit;
$result14=mysqli_query($connection, $query14) or die ("Couldn't execute query 14. $query14");

$query15="insert into crj_posted5_v2(center,f_year,sep)
select center,f_year,sum(amount) as 'sep'
from crj_posted2_v2_all
where f_year='$fiscal_year'
and month='09'
group by center,f_year,month; ";
//echo "query15=$query15";echo "<br />";//exit;
$result15=mysqli_query($connection, $query15) or die ("Couldn't execute query 15. $query15");

$query16="insert into crj_posted5_v2(center,f_year,oct)
select center,f_year,sum(amount) as 'oct'
from crj_posted2_v2_all
where f_year='$fiscal_year'
and month='10'
group by center,f_year,month; ";
//echo "query16=$query16";echo "<br />";//exit;
$result16=mysqli_query($connection, $query16) or die ("Couldn't execute query 16. $query16");


$query17="insert into crj_posted5_v2(center,f_year,nov)
select center,f_year,sum(amount) as 'nov'
from crj_posted2_v2_all
where f_year='$fiscal_year'
and month='11'
group by center,f_year,month; ";
//echo "query17=$query17";echo "<br />";//exit;
$result17=mysqli_query($connection, $query17) or die ("Couldn't execute query 17. $query17");


$query18="insert into crj_posted5_v2(center,f_year,dece)
select center,f_year,sum(amount) as 'dece'
from crj_posted2_v2_all
where f_year='$fiscal_year'
and month='12'
group by center,f_year,month; ";
//echo "query18=$query18";echo "<br />";//exit;
$result18=mysqli_query($connection, $query18) or die ("Couldn't execute query 18. $query18");

$query19="insert into crj_posted5_v2(center,f_year,jan)
select center,f_year,sum(amount) as 'jan'
from crj_posted2_v2_all
where f_year='$fiscal_year'
and month='01'
group by center,f_year,month; ";
//echo "query19=$query19";echo "<br />";//exit;
$result19=mysqli_query($connection, $query19) or die ("Couldn't execute query 19. $query19");

$query20="insert into crj_posted5_v2(center,f_year,feb)
select center,f_year,sum(amount) as 'feb'
from crj_posted2_v2_all
where f_year='$fiscal_year'
and month='02'
group by center,f_year,month; ";
//echo "query20=$query20";echo "<br />";//exit;
$result20=mysqli_query($connection, $query20) or die ("Couldn't execute query 20. $query20");

$query21="insert into crj_posted5_v2(center,f_year,mar)
select center,f_year,sum(amount) as 'mar'
from crj_posted2_v2_all
where f_year='$fiscal_year'
and month='03'
group by center,f_year,month; ";
//echo "query21=$query21";echo "<br />";//exit;
$result21=mysqli_query($connection, $query21) or die ("Couldn't execute query 21. $query21");

$query22="insert into crj_posted5_v2(center,f_year,apr)
select center,f_year,sum(amount) as 'apr'
from crj_posted2_v2_all
where f_year='$fiscal_year'
and month='04'
group by center,f_year,month; ";
//echo "query22=$query22";echo "<br />";//exit;
$result22=mysqli_query($connection, $query22) or die ("Couldn't execute query 22. $query22");

$query23="insert into crj_posted5_v2(center,f_year,may)
select center,f_year,sum(amount) as 'may'
from crj_posted2_v2_all
where f_year='$fiscal_year'
and month='05'
group by center,f_year,month; ";
//echo "query23=$query23";echo "<br />";//exit;
$result23=mysqli_query($connection, $query23) or die ("Couldn't execute query 23. $query23");

$query24="insert into crj_posted5_v2(center,f_year,jun)
select center,f_year,sum(amount) as 'jun'
from crj_posted2_v2_all
where f_year='$fiscal_year'
and month='06'
group by center,f_year,month; ";
//echo "query24=$query24";echo "<br />";//exit;
$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24. $query24");


$query25="update crj_posted5_v2
set total=jul+aug+sep+oct+nov+dece+jan+feb+mar+apr+may+jun
where 1 ; ";
//echo "query25=$query25";echo "<br />";exit;
$result25=mysqli_query($connection, $query25) or die ("Couldn't execute query 25. $query25");


$query26="update crj_posted5_v2,center
set crj_posted5_v2.park=center.parkcode
where crj_posted5_v2.center=center.center ; ";
//echo "query26=$query26";echo "<br />";exit;
$result26=mysqli_query($connection, $query26) or die ("Couldn't execute query 26. $query26");


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