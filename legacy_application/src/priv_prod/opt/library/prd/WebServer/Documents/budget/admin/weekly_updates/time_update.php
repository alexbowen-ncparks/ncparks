<?php

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/authBUDGET.inc");
extract($_REQUEST);



//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$project_category=$_REQUEST['project_category'];
$project_name=$_REQUEST['project_name'];
$end_date=$_REQUEST['end_date'];
$time_start=$_REQUEST['time_start'];
$time_end=$_REQUEST['time_end'];
$id=$_REQUEST['id'];

if(!empty ($time_start)){$set1= "set time_start='$time_start'";}
if(!empty ($time_end)){$set2= "set time_end='$time_end'";}
//if(!empty ($time_end)){$where2="and time_end='$time_end'";}
//echo "where 1=$where1"; //$where2; 
//echo $set1.$set2;
//exit;
//else {echo "time_start is empty";} exit;
//echo "project_category='$project_category'";
//echo "project_name='$project_name'";
//echo "end_date='$end_date'";
//echo "time_start='$time_start'";
//echo "time_end='$time_end'";
//echo "id='$id' ";exit;





$table1="weekly_updates_steps_status";
//$table2="project_notes2";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");




$query="update $table1 $set1 $set2
where id='$id' ";
mysqli_query($connection, $query) or die ("Error updating Database $query");


 ////mysql_close();
 
header("location: main.php?project_category=$project_category&project_name=$project_name&end_date='$end_date' ");
 
 ?>















