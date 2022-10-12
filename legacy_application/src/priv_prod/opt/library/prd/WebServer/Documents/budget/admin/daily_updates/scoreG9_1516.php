<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}
extract($_REQUEST);

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

/*

$query7="truncate table mission_scoring;";

$result7=mysqli_query($connection, $query7) or die ("Couldn't execute query7. $query7");

$query8="insert into mission_scoring(gid,playstation,complete)
         select '9',park,count(id) as 'complete'
		 from cash_summary
		 where valid='y'
		 and weekend='n'
		 and compliance='y'
		 and fyear='1516'
		 group by park;";

$result8=mysqli_query($connection, $query8) or die ("Couldn't execute query8. $query8");


$query9="insert into mission_scoring(gid,playstation,total)
         select '9',park,count(id) as 'total'
		 from cash_summary
		 where valid='y'
		 and weekend='n'
		 and fyear='1516'
		 group by park;";

$result9=mysqli_query($connection, $query9) or die ("Couldn't execute query9. $query9");



$query10="truncate table mission_scoring2;";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query10. $query10");


$query11="insert into mission_scoring2(gid,playstation,complete,total)
          select gid,playstation,sum(complete),sum(total)
		  from mission_scoring
		  where 1
		  group by gid,playstation;";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query11. $query11");



$query12="update mission_scores,mission_scoring2
          set mission_scores.complete=mission_scoring2.complete,
		  mission_scores.total=mission_scoring2.total
		  where mission_scores.gid='9' and mission_scoring2.gid='9'
		  and mission_scores.fyear='1516'
		  and mission_scores.playstation=mission_scoring2.playstation;";

$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query12. $query12");



$query13="update mission_scores
set percomp=complete/total*100
where gid = '9'
and fyear='1516' ";



$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query13. $query13");




$query14="update mission_scores
set percomp='.01'
where gid='9'
and complete='0'
and total >= '1'
and fyear='1516' ;";



$result14=mysqli_query($connection, $query14) or die ("Couldn't execute query14. $query14");

*/

$project_category='fms';
$project_name='daily_updates';
$step_group='C';
$step='Update CRS data in Money Counts';
$step_num='5';


$query12="update budget.project_steps_detail set status='complete' 
          where project_category='$project_category' and project_name='$project_name'
		  and step_group='$step_group' and step_num='$step_num' ";
		  
		  
mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");




{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&step=$step&step_num=$step_num&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date");}




?>