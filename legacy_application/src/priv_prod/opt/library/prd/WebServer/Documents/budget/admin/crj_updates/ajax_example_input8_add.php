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
	// Retrieve data from Query String
$age2 = $_GET['age2'];
$sex2 = $_GET['sex2'];
$wpm2 = $_GET['wpm2'];
$name2 = $_GET['name2'];
	// Escape User Input to help prevent SQL Injection
$age2 = mysqli_real_escape_string($age2);
$sex2 = mysqli_real_escape_string($sex2);
$wpm2 = mysqli_real_escape_string($wpm2);
$name2 = mysqli_real_escape_string($name2);
	//build query
//$query = "SELECT * FROM ajax_example WHERE 1";
$query = "insert into ajax_example
          set ae_name='$name2',ae_age='$age2',ae_sex='$sex2',ae_wpm='$wpm2' ";
	
/*
if(is_numeric($age))
	$query .= " AND ae_age <= $age";
if(is_numeric($wpm))
	$query .= " AND ae_wpm <= $wpm";
	//Execute query
*/

$qry_result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
	//Build Result String
	/*
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
*/
?>