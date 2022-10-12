<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters


//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//$fiscal_year=$_REQUEST['fiscal_year'];
//$project_category=$_REQUEST['project_category'];
//$project_name=$_REQUEST['project_name'];
//$start_date=$_REQUEST['start_date'];
$end_date=$_REQUEST['end_date'];
//$step_group=$_REQUEST['step_group'];
//echo "fiscal_year=$fiscal_year";
//echo "project_category=$project_category";
//echo "project_name=$project_name";
//echo "start_date=$start_date";
//echo "end_date=$end_date";
//echo "step=$step";
//exit;
$end_date=str_replace('-','',$end_date);
$db_backup="budget$end_date";
//echo $db_backup;
//exit;

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");



//Table backup
$query2="insert into
$db_backup.authorized_budget
select *
from budget.authorized_budget";

mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


//Table backup
$query3="insert into
$db_backup.bd725_dpr
select *
from budget.bd725_dpr";

mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

//Table backup
$query4="insert into
$db_backup.budget_center_allocations
select *
from budget.budget_center_allocations";

mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

//Table backup
$query5="insert into
$db_backup.cab_dpr
select *
from budget.cab_dpr";

mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

//Table backup
$query6="insert into
$db_backup.cid_vendor_invoice_payments
select *
from budget.cid_vendor_invoice_payments";

mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");


//Table backup
$query7="insert into
$db_backup.equipment_request_3
select *
from budget.equipment_request_3";

mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");


//Table backup
$query8="insert into
$db_backup.exp_rev_extract
select *
from budget.exp_rev_extract";

mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");

//Table backup
$query9="insert into
$db_backup.partf_fund_trans
select *
from budget.partf_fund_trans" ;

mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");


//Table backup
$query10="insert into
$db_backup.partf_payments
select *
from budget.partf_payments";

mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");


//Table backup
$query11="insert into
$db_backup.pcard_extract
select *
from budget.pcard_extract";

mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");


//Table backup
$query12="insert into
$db_backup.pcard_unreconciled
select *
from budget.pcard_unreconciled" ;

mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");


//Table backup
$query13="insert into
$db_backup.warehouse_billings_2
select *
from budget.warehouse_billings_2";

mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13");

//Table backup
$query14="insert into
$db_backup.xtnd_ci_monthly
select *
from budget.xtnd_ci_monthly";

mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14");


//Table backup
$query15="insert into
$db_backup.xtnd_po_encumbrances
select *
from budget.xtnd_po_encumbrances";

mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15");

//Table backup
$query16="insert into
$db_backup.manual_allocations_3
select *
from budget.manual_allocations_3";


mysqli_query($connection, $query16) or die ("Couldn't execute query 16.  $query16");

//Table backup
$query17="insert into
$db_backup.opexpense_request_3
select *
from budget.opexpense_request_3";

mysqli_query($connection, $query17) or die ("Couldn't execute query 17.  $query17");

//Table backup
$query18="insert into
$db_backup.approved_grants_3
select *
from budget.approved_grants_3";


mysqli_query($connection, $query18) or die ("Couldn't execute query 18.  $query18");



//Table backup
$query19="insert into
$db_backup.opexpense_transfers_4
select *
from budget.opexpense_transfers_4";

mysqli_query($connection, $query19) or die ("Couldn't execute query 19.  $query19");

//Table backup
$query20="insert into
$db_backup.partf_projects
select *
from budget.partf_projects";

mysqli_query($connection, $query20) or die ("Couldn't execute query 20.  $query20");


//Table backup
$query21="insert into
$db_backup.xtnd_vendor_payments
select *
from budget.xtnd_vendor_payments" ;

mysqli_query($connection, $query21) or die ("Couldn't execute query 21.  $query21");

//Table backup
$query22="insert into
$db_backup.beacon_payments
select *
from budget.beacon_payments";

mysqli_query($connection, $query22) or die ("Couldn't execute query 22.  $query22");


//Table backup
$query23="insert into
$db_backup.coa
select *
from budget.coa";

mysqli_query($connection, $query23) or die ("Couldn't execute query 23.  $query23");


//Table backup
$query24="insert into
$db_backup.center
select *
from budget.center";

mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");


//Table backup
$query25="insert into
$db_backup.reversions
select *
from budget.reversions";

mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");


//Table backup
$query26="insert into
$db_backup.purchase_request_3
select *
from budget.purchase_request_3";

mysqli_query($connection, $query26) or die ("Couldn't execute query 26.  $query26");

//Table backup
$query27="insert into
$db_backup.pcard_utility_xtnd_1646
select *
from budget.pcard_utility_xtnd_1646";

mysqli_query($connection, $query27) or die ("Couldn't execute query 27.  $query27");

//Table backup
$query28="update budget.weekly_updates_steps_detail set status='complete' 
          where step_group='b' and step_num='2' ";

mysqli_query($connection, $query28) or die ("Couldn't execute query 28.  $query28");

////mysql_close();

header("location: step_groupb.php?fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");

?>