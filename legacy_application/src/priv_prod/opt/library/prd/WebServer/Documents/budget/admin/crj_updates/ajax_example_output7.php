<?php
session_start();


if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

extract($_REQUEST);

//echo $concession_location;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
$age = $_GET['age'];
$sex = $_GET['sex'];
$wpm = $_GET['wpm'];
	// Escape User Input to help prevent SQL Injection
$age = mysqli_real_escape_string($age);
$sex = mysqli_real_escape_string($sex);
$wpm = mysqli_real_escape_string($wpm);
	//build query
//$query = "SELECT * FROM ajax_example WHERE 1";
//$query = "SELECT * FROM ajax_example WHERE ae_sex = '$sex' order by id desc";
$query = "SELECT * FROM ajax_example WHERE ae_sex = 'm' order by id desc";
if(is_numeric($age))
	$query .= " AND ae_age <= $age";
if(is_numeric($wpm))
	$query .= " AND ae_wpm <= $wpm";
	//Execute query
//$qry_result = mysqli_query($connection, $query) or die(mysqli_error());
$qry_result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");


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