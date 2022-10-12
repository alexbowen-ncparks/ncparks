<?php

session_start();


//$file = "articles_menu.php";
//$lines = count(file($file));


//$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

/*
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];
*/

$system_entry_date=date("Ymd");
extract($_REQUEST);

//echo "<br />Line 30: concession_location=$concession_location<br />"; //exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo $system_entry_date;//exit;
//print_r($_SESSION);echo "</pre>";exit;
$email_location=$location;

//if($project_category==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
//if($project_name==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
if($comment_note==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}
//if($web_address==""){echo "<font color='brown' size='5'>Oops:We did not receive all the Values from your Form<br /><br /> Click the BACK button on your Browser to complete Form</font><br />";exit;}

//include("../../../include/connectBUDGET.inc");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
//$table1="infotrack_projects";
//$table2="infotrack_projects_community";

//$date=$_POST['date'];
//$project_category=$_POST['project_category'];
//$project_name=$_POST['project_name'];
//$project_note=$_POST['project_note'];
//$weblink=$_POST['weblink'];
$date=date("Ymd");
//$project_start_date=$_POST['project_start_date'];
//$project_end_date=$_POST['project_end_date'];
//$project_status=$_POST['project_status'];

$concession_location=strtolower($concession_location);
$location=strtolower($location);

if($concession_location=='admi' and $location != 'admi')
{$concession_location=$location;}
//echo "<br />Line 65: concession_location=$concession_location<br />"; exit;
/*
if($submit=='Add_Comment' and $folder=='personal')

{
$query1="insert ignore into $table1
(user,system_entry_date,project_category,project_name,project_note,weblink,note_group,comment_note,comment_id) 
values ('$tempID','$system_entry_date','$project_category','$project_name',
'$project_note','$weblink','web','$comment_note','$project_note_id')";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query");
}

*/

if($submit=='Add_Message' and $folder=='community')

{
$concession_location=strtolower($concession_location);
//$comment_note=addslashes($comment_note);
/*
$query2=" insert into infotrack_projects_community_com set
project_note_id='$project_note_id',
user='$tempID',system_entry_date='$system_entry_date',
comment_note='$comment_note',status='ip' ";
*/
//echo "<br />Line 91: concession_location=$concession_location<br />"; //exit;
if($alert_note!='y')
{
$query2=" insert into infotrack_projects_community_com set
project_note='$project_note',park='$concession_location',
user='$tempID',system_entry_date='$system_entry_date',
comment_note='$comment_note',status='ip' ";

//echo "query2=$query2";exit;
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
}

if($alert_note=='y')
{
$query2=" insert into infotrack_projects_community_com set
project_note='$project_note',park='$concession_location',
user='$tempID',system_entry_date='$system_entry_date',
comment_note='$comment_note',status='ip',alert='y',
original_entry_date='$system_entry_date' ";

//echo "query2=$query2";exit;
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

}

}

$query3="SELECT MAX(`comment_id`) as 'comment_id' 
FROM `infotrack_projects_community_com`
where 1 and user='$tempID'";
//echo "query3=$query3";exit;
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$row3=mysqli_fetch_array($result3);
extract($row3);

//echo "comment_id=$comment_id";exit;


if($project_note=='games' or $project_note=='cash_receipts' or $project_note=='user_activity' or $project_note=='park_budgets' or $project_note=='note_tracker')
{
header("location: /budget/infotrack/notes.php?comment=y&add_comment=y&project_note=$project_note&folder=$folder&category_selected=y&name_selected=y&email=y&email_location=$location&comment_id=$comment_id");
}
else
header("location: project1_menu_web.php?comment=y&add_comment=y&project_note_id=$project_note_id&folder=$folder&category_selected=y&name_selected=y");











?>














