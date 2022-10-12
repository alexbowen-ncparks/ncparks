<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

extract($_REQUEST);

//echo $concession_location;


//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

$query1a="select count(id) as 'cashier_count' from cash_handling_roles where park='$concession_location' and role='cashier' and tempid='$tempid' ";
$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");		  
$row1a=mysqli_fetch_array($result1a);
extract($row1a);

$query1b="select count(id) as 'manager_count' from cash_handling_roles where park='$concession_location' and role='manager' and tempid='$tempid' ";	 
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
$row1b=mysqli_fetch_array($result1b);
extract($row1b);

$query1c="select count(id) as 'puof_count' from cash_handling_roles
		  where park='admi' and role='puof' and tempid='$tempid' ";	 

$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");		  
$row1c=mysqli_fetch_array($result1c);
extract($row1c);


$query1d="select count(id) as 'buof_count' from cash_handling_roles
		  where park='admi' and role='buof' and tempid='$tempid' ";	 

$result1d = mysqli_query($connection, $query1d) or die ("Couldn't execute query 1d.  $query1d");		  
$row1d=mysqli_fetch_array($result1d);
extract($row1d);



echo "tempid=$tempid<br />";
echo "cashier_count=$cashier_count<br />";
echo "manager_count=$manager_count<br />";
echo "puof_count=$puof_count<br />";
echo "buof_count=$buof_count<br />";

?>