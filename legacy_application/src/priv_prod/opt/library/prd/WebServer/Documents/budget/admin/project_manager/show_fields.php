<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query1="SELECT * FROM project_substeps_detail where 1 ";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1[]=mysqli_fetch_array($result1);
echo "<pre>";print_r($row1); echo "</pre>";//exit;
//$query2="select count(distinct transid_new) as 'pcu_count' from pcard_unreconciled where reconciled='n'";

//$row2=mysqli_fetch_array($result2);
//extract($row2);

?>

























