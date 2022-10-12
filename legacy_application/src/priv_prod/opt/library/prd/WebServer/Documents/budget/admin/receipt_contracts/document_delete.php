<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;


include("../../../../include/connectBUDGET.inc");// database connection parameters

$query1="update project_steps set link='' where project_category='$project_category'
        and project_name='$project_name' and step_group='$step_group' ";

mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

////mysql_close();

echo "Update Successful-Document for $project_name-$step_group was deleted";

echo "</br> </br>";

echo "<A href=main.php?&project_category=$project_category&project_name=$project_name
       &step_group=$step_group&start_date=$start_date&end_date=$end_date>Return HOME </A>";



?>
