<?php


session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

//$file = "articles_menu.php";
//$lines = count(file($file));


//$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];
$pcode=$_SESSION['budget']['select'];

$tempID2=substr($tempID,0,-2);
if($tempID2=='Kno'){$tempID2='Knott';}
//echo "tempID2=$tempID2";

//echo "beacnum=$beacnum";

//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;


//include("../../../include/connectBUDGET.inc");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 
//echo "f_year=$f_year";




$age = $_GET['age'];
$sex = $_GET['sex'];
$wpm = $_GET['wpm'];
	// Escape User Input to help prevent SQL Injection
$age = mysqli_real_escape_string($age);
$sex = mysqli_real_escape_string($sex);
$wpm = mysqli_real_escape_string($wpm);
	//build query
//$query = "SELECT * FROM ajax_example WHERE 1";
$query = "SELECT * FROM ajax_example WHERE ae_sex = '$sex' order by id desc";
if(is_numeric($age))
	$query .= " AND ae_age <= $age";
if(is_numeric($wpm))
	$query .= " AND ae_wpm <= $wpm";
	//Execute query
$qry_result = mysqli_query($connection, $query) or die(mysqli_error());

	//Build Result String
$display_string = "<table>";
$display_string .= "<tr>";
$display_string .= "<th>Name</th>";
$display_string .= "<th>Age</th>";
$display_string .= "<th>Sex</th>";
$display_string .= "<th>WPM</th>";
$display_string .= "</tr>";

	// Insert a new row in the table for each person returned
while($row = mysqli_fetch_array($qry_result)){
	$display_string .= "<tr>";
	$display_string .= "<td>$row[ae_name]</td>";
	$display_string .= "<td>$row[ae_age]</td>";
	$display_string .= "<td>$row[ae_sex]</td>";
	$display_string .= "<td>$row[ae_wpm]</td>";
	$display_string .= "</tr>";
	
}
echo "Query: " . $query . "<br />";
$display_string .= "</table>";
echo $display_string;
?>