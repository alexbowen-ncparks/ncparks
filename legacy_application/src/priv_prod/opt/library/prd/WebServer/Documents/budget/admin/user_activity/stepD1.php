<?php

session_start();

extract($_REQUEST);
//echo "accounts=$accounts";
//echo "<pre>";print_r($_SERVER);"</pre>";exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

//$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters



{header("location: user_activity_matrix.php?report=user&section=all&user_level=all&period=fyear");}

?>





















	














