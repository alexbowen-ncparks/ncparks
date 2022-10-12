<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;

$query7="delete from crs_tdrr_division_history_parks where source='manual' and fs_comments='refund issued' and amount='0.00' ";

$result7=mysqli_query($connection, $query7) or die ("Couldn't execute query7. $query7");



$query25="update project_steps_detail set status='complete' where project_category='fms'
         and project_name='daily_updates' and step_group='C' and step_num='5a'  ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");





header("location: step_group.php?project_category=fms&project_name=daily_updates&step_group=C ");

/*

$query13="update mission_scores
          set complete='1',
		  total='1000'
		  where gid='8'
		  and percomp='0'; ";

$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query13. $query13");


*/


//echo "gid=$gid";//exit;


//echo "query13=$query13";exit;

?>