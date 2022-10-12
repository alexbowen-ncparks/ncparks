<?php

session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];


extract($_REQUEST);
//$tempid2=$tempid;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;


$database="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//echo "cashier=$cashier<br />";

$query1="insert into pcard_users(`dncr`, `employee`, `last_name`, `first_name`, `middle_initial`, `suffix`, `position_number`, `affirmation_abundance`, `photo_location`, `photo_comment`, `employee_number`, `job_title`, `employee_tempid`, `phone_number`, `act_id`, `parkcode`, `location`, `admin`, `dup_record`,`monthly_limit`, `last_update`, `date_added`, `count`, `pcard_numname`, `center`, `park_active`, `active_eva`, `bank`, `status`, `act_id_030707`, `last5`, `comments`, `justification`, `justification_manager`, `transactions`, `total_amount`, `pcard_usage`, `view`, `document_location`, `document_location_final`, `sed`, `entered_by`, `cashier`, `cashier_date`, `pcard_holder`, `pcard_holder_date`, `manager`, `manager_date`, `fs_approver`, `fs_approver_date`, `quiz_id`, `student_id`, `student_test_date`, `student_score`,`dup_id`,`dup_yn`)
SELECT 
`dncr`, `employee`, `last_name`, `first_name`, `middle_initial`, `suffix`, `position_number`, `affirmation_abundance`, `photo_location`, `photo_comment`, `employee_number`, `job_title`, `employee_tempid`, `phone_number`, `act_id`, `parkcode`, `location`, `admin`,`dup_record`, `monthly_limit`, `last_update`, `date_added`, `count`, `pcard_numname`, `center`, `park_active`, `active_eva`, `bank`, `status`, `act_id_030707`, `last5`, `comments`, `justification`, `justification_manager`, `transactions`, `total_amount`, `pcard_usage`, `view`, `document_location`, `document_location_final`, `sed`, `entered_by`, `cashier`, `cashier_date`, `pcard_holder`, `pcard_holder_date`, `manager`, `manager_date`, `fs_approver`, `fs_approver_date`, `quiz_id`, `student_id`, `student_test_date`, `student_score`,'$id_duplicate','y'
from pcard_users where id='$id_duplicate' ";


//echo "<br />query1=$query1<br />";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query1. $query1");


//exit;

header("Location:/budget/acs/editPcardHolders.php?m=pcard&admin=$admin&submit_acs=Find");







?>