<?php
//ini_set('display_errors',1);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;
echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters



$query0="update exp_rev_dncr_temp_part2
set eff_date=trim(eff_date),
eff_date2=trim(eff_date2),
comp=trim(comp),
account=trim(account),
valid_account=trim(valid_account),
account_description=trim(account_description),
center=trim(center),
valid_dpr_center=trim(valid_dpr_center),
doc_id=trim(doc_id),
line=trim(line),
inv_date=trim(inv_date),
pay_entity=trim(pay_entity),
txn_description=trim(txn_description),
check_num=trim(check_num),
ctrld=trim(ctrld),
grp=trim(grp),
sign=trim(sign),
amount=trim(amount),
sys=trim(sys),
vendor_num=trim(vendor_num),
buy_entity=trim(buy_entity),
po_number=trim(po_number)
";


mysqli_query($connection, $query0) or die ("Couldn't execute query0.  $query0");






$query1="update exp_rev_dncr_temp_part2
set eff_date2=CONCAT( MID( LPAD( eff_date, 8,  '0' ) , 5, 4 ) , MID( LPAD( eff_date, 8,  '0' ) , 1, 2 ) , MID( LPAD( eff_date, 8,  '0' ) , 3, 2 ) ) 
WHERE 1 ";

		 
mysqli_query($connection, $query1) or die ("Couldn't execute query1.  $query1");


$query13="update budget.exp_rev_dncr_temp_part2
set valid_account='n'
where mid(account,1,1)='0' ; ";

$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13");


$query13a="update budget.exp_rev_dncr_temp_part2
set valid_account='n'
where mid(account,1,1)='6' ; ";

$result13a=mysqli_query($connection, $query13a) or die ("Couldn't execute query 13a.  $query13a");



$query13b="update budget.exp_rev_dncr_temp_part2
set valid_account='n'
where mid(account,1,1)='7' ; ";

$result13b=mysqli_query($connection, $query13b) or die ("Couldn't execute query 13b.  $query13b");



$query13c="update budget.exp_rev_dncr_temp_part2
set valid_account='n'
where mid(account,1,1)='8' ; ";

$result13c=mysqli_query($connection, $query13c) or die ("Couldn't execute query 13c.  $query13c");


$query14c="update budget.exp_rev_dncr_temp_part2,center
set exp_rev_dncr_temp_part2.valid_dpr_center='y'
where exp_rev_dncr_temp_part2.center=center.new_center
and exp_rev_dncr_temp_part2.center != '' ";

$result14c=mysqli_query($connection, $query14c) or die ("Couldn't execute query 14c.  $query14c");





$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");





////mysql_close();



{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}

 ?>




















