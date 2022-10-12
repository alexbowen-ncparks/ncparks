<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

//echo "<pre>";print_r($_REQUEST);"</pre>";  //exit;

extract($_REQUEST);

if($compliance_fyear==''){echo "compliance_fyear missing"; exit;}
if($compliance_month==''){echo "compliance_month missing"; exit;}

echo "<br />hello line 14<br />";

//exit;

// Queries below for ALL Months except July, calculate "cummulative score" for GID=10 (Cash Imprest Count) for current Fiscal Year
// After calculating "cummulative score", the VALUE is passed to TABLE=mission_scores for GID=10

if($compliance_month != 'july')
{


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

//echo "park=$park<br />";
$gid=10;
//echo "gid=$gid";exit;
$query4="
SELECT park as 'G10_park', SUM( score ) / COUNT( id ) AS  'mission_score'
FROM cash_imprest_count_detail
WHERE 1 
AND fyear =  '$compliance_fyear'
AND valid =  'y'
GROUP BY park
ORDER BY park
";
//echo "query4=$query4";
//exit;

	 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);


echo "<br />";


while ($row=mysqli_fetch_assoc($result4))
	{
	$header_array[$row['G10_park']]=$row['mission_score'];
	}
//echo "<pre>"; print_r($header_array); echo "</pre>";  //exit;		


foreach($header_array AS $playstation=>$percomp)
	{
	
	//echo "<tr><th>$index</th></tr>";
	$query5="update mission_scores
	         set percomp='$percomp'
			 where playstation='$playstation'
			 and gid='10' and fyear='$compliance_fyear' ; ";
	 
	 //echo "query5=$query5<br />";
     $result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
	}
	

$query7a="update mission_scores
set percomp='.01'
where gid = '10'
and fyear = '$compliance_fyear'
and percomp='0.00'
and playstation != 'eadi'
and playstation != 'nodi'
and playstation != 'sodi'
and playstation != 'wedi'
 ";



$result7a=mysqli_query($connection, $query7a) or die ("Couldn't execute query7a. $query7a");

// echo "query7a=$query7a<br />";

//echo "ok";


$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");


}

// This PHP file does not Update TABLE=mission_scores for GID=10 when compliance_month=July.  
// July Update in TABLE=mission_scores for GID=10 occurs during the YearEnd Re-Set of MoneyCounts
// Just marks step as complete  via query23a

if($compliance_month=='july')
{
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 
	
$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");
	

	
}



{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&compliance_fyear=$compliance_fyear&compliance_month=$compliance_month&report_type=form");}
 

 

 ?>
 