<?php

session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
include("../../../../include/connectBUDGET.inc");// database connection parameters
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");

$query="update project_steps set step_group='$step_group',step='$step'
where cid='$cid' ";
mysqli_query($connection, $query) or die ("Error updating Database $query");

//$query2="SELECT * FROM $table where 1 and project_category='$project_category' and project_name='$project_name' and user='$user'  order by project_note_id asc";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
//$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
//$num2=mysqli_num_rows($result2);

 ////mysql_close();
header("location: main.php?project_category=$project_category&project_name=$project_name
      &fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");





?>















