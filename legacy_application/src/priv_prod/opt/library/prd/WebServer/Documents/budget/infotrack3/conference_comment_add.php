<?php


session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

$tempID=$_SESSION['budget']['tempID'];
$tempID2=substr($tempID,0,-2);
$system_entry_date=date("Ymd");


/*
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
*/

/*
extract($_REQUEST);
$fee_amount=str_replace(",","",$fee_amount);
$fee_amount=str_replace("$","",$fee_amount);
$ncas_center=str_replace("-","",$ncas_center);
*/

//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
//echo "<pre>";print_r($_SESSION);"</pre>";exit;

extract($_REQUEST);

if($comment_note==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

$date=date("Ymd");
//$comment_note=addslashes($comment_note);

$query2=" insert into infotrack_projects_community4
          set user='$tempID2',system_entry_date='$system_entry_date',project_category='$project_category',project_name='$project_name',note_group='web',comment_note='$comment_note',comment_id='$project_note_id' ";

//echo "query2=$query2";exit;
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

header("location: project1_menu.php?comment=y&add_comment=y&folder=community&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=web&project_note_id=$project_note_id&im=n");





?>














