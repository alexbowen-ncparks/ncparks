<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
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
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="update pcard_unreconciled_xtnd set xtnd_rundate=trim(xtnd_rundate),
location=trim(location),
admin_num=trim(admin_num),
post_date=trim(post_date),
amount=trim(amount),
vendor_name=trim(vendor_name),
address=trim(address),
pcard_num=trim(pcard_num),
xtnd_cardholder=trim(xtnd_cardholder);";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$query2="update pcard_unreconciled_xtnd
set valid_record='y'
where mid(trans_date,4,1)='/'; ";
mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$query3="update pcard_unreconciled_xtnd
set complete_record='y'
where mid(trans_date,4,1)='/'
and pcard_num != ''; ";
mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");

$query4="CREATE TABLE `xtnd_cardholders` (
`location` VARCHAR( 10 ) NOT NULL ,
`cardholder` VARCHAR( 75 ) NOT NULL ,
`cardnumber` VARCHAR( 30 ) NOT NULL ); ";
mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

$query5="insert into xtnd_cardholders (
location,
cardholder,
cardnumber)
select distinct
location,
xtnd_cardholder,
pcard_num
from pcard_unreconciled_xtnd
where 1
and complete_record='y'; ";
mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

$query6="update pcard_unreconciled_xtnd,xtnd_cardholders
set pcard_unreconciled_xtnd.pcard_num=
xtnd_cardholders.cardnumber
where pcard_unreconciled_xtnd.location=xtnd_cardholders.location
and pcard_unreconciled_xtnd.xtnd_cardholder=xtnd_cardholders.cardholder
and pcard_unreconciled_xtnd.pcard_num=''
and pcard_unreconciled_xtnd.valid_record='y'; ";
mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");

$query7="update pcard_unreconciled_xtnd
set xtnd_rundate=concat(mid(xtnd_rundate,1,6),mid(xtnd_rundate,9,2))
where 1; ";
mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");

$query8="DROP TABLE `xtnd_cardholders`; ";
mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");


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

























