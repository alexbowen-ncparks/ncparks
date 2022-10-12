<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="dpr_it"; 
$dbName="dpr_it";
include("../../include/auth.inc"); // include iConnect.inc with includes no_inject.php
include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);

 echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$level=$_SESSION[$database]['level'];
$location=$_SESSION[$database]['select'];
//echo "level=$level  location=$location";

$sql="UPDATE $select_table
	set computer_status='bwo'
	where id='$id'
	"; 
		// ECHO "level 4 $sql"; //exit;
// 		$result = mysqli_query($connection,$sql) or die("$sql");

echo "<form method='POST' ACTION='search_form.php'>";
echo "<table align='right'>";
echo "<tr><td bgcolor='#ffcc00'>";
if(!empty(${$select_table}))
	{
	$force_array=${$select_table};
	foreach($force_array as $k=>$v)
		{
		echo "<input type='hidden' name='$k' value=\"$v\">";
		}
	}
echo "<input type='hidden' name='select_table' value=\"$select_table\">
<input type='submit' name='submit_form' value=\"Return\">";
echo "</tr></table>";
echo "</form>";
echo "<pre>"; print_r($force_array); echo "</pre>"; // exit;
?>
