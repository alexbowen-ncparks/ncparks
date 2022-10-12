<?php

echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);


header("location: budget/test_upload.php");

 
 ?>




















