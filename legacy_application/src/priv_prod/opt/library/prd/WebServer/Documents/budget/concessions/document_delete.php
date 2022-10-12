<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
if($level=='5' and $tempID !='Dodd3454')

{echo "<pre>";print_r($_SESSION);"</pre>";//exit;
echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
}
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

$query1="SELECT *
from concessions_documents
WHERE  project_note_id='$project_note_id'
";
$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$row1=mysqli_fetch_array($result1);

extract($row1);


$query2="SELECT *
from projects_customformat
WHERE 1 and user_id='$myusername'
";

$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$row2=mysqli_fetch_array($result2);

extract($row2);

$body_bg=$body_bgcolor;

//echo "record_count=$num";//exit;
// frees the connection to MySQL
 //////mysql_close();


//echo 'project';
//echo $project_category; 
//exit;
echo "<html>";
echo "<head>
<title>document_delete</title>";

//include ("test_style.php");
include ("test_style.php");

echo "</head>";



$table1="concessions_documents";


$query3="delete from $table1 where project_note_id='$project_note_id' ";

mysqli_query($connection, $query3) or die ("couldn't execute query 3. $query3");


echo "Document: $project_name $project_note has been successfully deleted";

echo "</br> </br>";

echo "<A href=documents_personal_search.php>Return-Documents Home </A>";

?>
