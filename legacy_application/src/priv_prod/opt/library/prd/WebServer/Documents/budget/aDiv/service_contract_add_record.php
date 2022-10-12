<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);
$monthly_cost=str_replace(",","",$monthly_cost);
$monthly_cost=str_replace("$","",$monthly_cost);

$yearly_cost=str_replace(",","",$yearly_cost);
$yearly_cost=str_replace("$","",$yearly_cost);

$original_total=str_replace(",","",$original_total);
$original_total=str_replace("$","",$original_total);



//$ncas_center=str_replace("-","",$ncas_center);



//echo "tempid=$tempid";

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
echo "<pre>";print_r($_REQUEST);"</pre>"; exit;


$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
mysqli_select_db($connection,$database); // database
//include("../../../include/activity.php");// database connection parameters
include("../../../include/activity_new.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");



if($park==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($contract_type==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($service_type==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($vendor==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($contract_num==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($po_num==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($original_total==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($buy_entity==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($monthly_cost==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($yearly_cost==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($original_contract_start_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($original_contract_end_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
//if($first_renewal_date==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}
if($comments==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br />Click the BACK button on your Browser to complete Form </font><br />";exit;}



$entered_by=substr($tempid,0,-4);

//$date=$_POST['date'];
//$project_category=$_POST['project_category'];
//$project_name=$_POST['project_name'];
//$project_note=$_POST['project_note'];
//$weblink=$_POST['weblink'];
$system_entry_date=date("Ymd");
//$project_start_date=$_POST['project_start_date'];
//$project_end_date=$_POST['project_end_date'];
//$project_status=$_POST['project_status'];






$query1="insert into service_contracts
set division='dpr',park='$park',service_type='$service_type',vendor='$vendor',contract_num='$contract_num',po_num='$po_num',original_total='$original_total',buy_entity='$buy_entity',monthly_cost='$monthly_cost',yearly_cost='$yearly_cost',original_contract_start_date='$original_contract_start_date',original_contract_end_date='$original_contract_end_date',comments='$comments',entered_by='$entered_by'
";

echo "query1=$query1<br /><br />";
echo "You MUST specify a 'pay_center'. Click Button below to Return to Form";

echo "<form method='post' action='service_contracts1.php.php'>";
echo "<input type='hidden' name='purchase_description_Edit' value='$purchase_description_Edit'>";
echo "<input type='hidden' name='justification_Edit' value='$justification_Edit'>";
echo "<input type='hidden' name='menu_sc' value='SC1'>";
echo "<input type='hidden' name='submit' value='Submit'>";
echo "<input type='submit' name='submit2' value='Return to Form'>";
echo "</form>";

exit;

//mysqli_query($connection,$query1) or die ("Couldn't execute query 1.  $query1");

//echo "update successful";

header("location: service_contracts.php");


?>