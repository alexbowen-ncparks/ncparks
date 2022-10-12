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
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");
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

$query1="delete from fixed_assets1 where field4='';";
mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="delete from fixed_assets1 where field4 like '%ACCOUNTS%' ;";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$query3="delete from fixed_assets1 where field4 like '%ASSET%' ;";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

$query4="delete from fixed_assets1 where field4 like '%PERIOD%' ;";
mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

$query5="delete from fixed_assets1 where field4 like '%NUMBER%' ;";
mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

$query6="delete from fixed_assets1 where field4 like '%INVOICE%' ;";
mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");

$query7="delete from fixed_assets1 where field4 like '%----%' ;";
mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");

$query8="update fixed_assets1
set field1=trim(field1),field2=trim(field2),field3=trim(field3),
field4=trim(field4),field5=trim(field5),field6=trim(field6),
field7=trim(field7),field8=trim(field8); ";
mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");

$query9="update fixed_assets1
set field1=replace(field1,'\"','');";

mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");

$query10="update fixed_assets1
set field8=replace(field8,'\"','');";

mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");


$query11="update fixed_assets1
set field1=trim(field1),field2=trim(field2),field3=trim(field3),
field4=trim(field4),field5=trim(field5),field6=trim(field6),
field7=trim(field7),field8=trim(field8); ";

mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$query12="insert into fixed_assets2(field1,field2,field3,field4,field5,field6,field7,field8)
select field1,field2,field3,field4,field5,field6,field7,field8
from fixed_assets1 where field1 not like '%016%'; ";

mysqli_query($connection, $query12) or die ("Couldn't execute query 12. $query12");

$query13="insert into fixed_assets3(field1,field2,field3,field4,field5,field6,field7,field8)
select field1,field2,field3,field4,field5,field6,field7,field8
from fixed_assets1 where field1 like '%016%'; ";

mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");

$query14="update fixed_assets3,fixed_assets2
set fixed_assets3.field9=fixed_assets2.field1,
fixed_assets3.field10=fixed_assets2.field2,
fixed_assets3.field11=fixed_assets2.field3,
fixed_assets3.field12=fixed_assets2.field4,
fixed_assets3.field13=fixed_assets2.field5,
fixed_assets3.field14=fixed_assets2.field6,
fixed_assets3.field15=fixed_assets2.field7,
fixed_assets3.field16=fixed_assets2.field8
where fixed_assets3.id=fixed_assets2.id; ";

mysqli_query($connection, $query14) or die ("Couldn't execute query 14. $query14");

$query15="update fixed_assets3
set lvl1=mid(field1,1,3), 
lvl2=mid(field1,6,3),
temp_an=mid(field1,12,8), 
asset_descript=field9,
budget_code=field2,
buy_entity=field10,
center=field3,
pay_entity=field11,
invoice=field12,
account=field5,
std_descript=field13,
control_date=mid(field6,1,6),
vendor_num=field14,
control_group=mid(field6,10,4),
acq_date=field7,
cost=field8,
vendor_name=field16
where 1; ";

mysqli_query($connection, $query15) or die ("Couldn't execute query 15. $query15");


$query15a="update fixed_assets3
set check_num=mid(field4,13,9)
where field4 like '%NC%'; ";

mysqli_query($connection, $query15a) or die ("Couldn't execute query 15a. $query15a");

$query15b="update fixed_assets3
set check_num=mid(field4,1,9)
where field4 not like '%NC%'; ";

mysqli_query($connection, $query15b) or die ("Couldn't execute query 15b. $query15b");

$query15c="update fixed_assets3
set po_number=mid(field4,1,10)
where field4 like '%NC%'; ";

mysqli_query($connection, $query15c) or die ("Couldn't execute query 15c. $query15c");


$query16="update fixed_assets3
set cost=replace(cost,',','')
where 1; ";

mysqli_query($connection, $query16) or die ("Couldn't execute query 16. $query16");

$query17="insert into fixed_assets4(lvl1,lvl2,temp_an,asset_descript,budget_code,buy_entity,
center,pay_entity,po_number,invoice,check_num,account,std_descript,control_date,
vendor_num,control_group,acq_date,cost,vendor_name)
select
lvl1,lvl2,temp_an,asset_descript,budget_code,buy_entity,
center,pay_entity,po_number,invoice,check_num,account,std_descript,control_date,
vendor_num,control_group,acq_date,cost,vendor_name
from fixed_assets3
where 1; ";

mysqli_query($connection, $query17) or die ("Couldn't execute query 17. $query17");

$query18="update fixed_assets4,center
set valid_dpr='y'
where fixed_assets4.center=center.center; ";

mysqli_query($connection, $query18) or die ("Couldn't execute query 18. $query18");

$query19="update fixed_assets4
set report_date='$end_date'
where 1; ";

mysqli_query($connection, $query19) or die ("Couldn't execute query 19. $query19");

$query20="update fixed_assets4,center
set fixed_assets4.center_name=center.center_desc,
fixed_assets4.center_mgr=center.centerman
where fixed_assets4.center=center.center; ";

mysqli_query($connection, $query20) or die ("Couldn't execute query 20. $query20");



$query23a="update budget.project_substeps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' and substep_num='$substep_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_substeps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and step_num='$step_num' and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group ");}

if($num24!=0)

{header("location: step$step_group$step_num.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step_num=$step_num ");}




?>

























