<?php
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

//echo "<pre>";print_r($_REQUEST);"</pre>";  //exit;

extract($_REQUEST);

if($compliance_fyear==''){echo "compliance_fyear missing"; exit;}
if($compliance_month==''){echo "compliance_month missing"; exit;}

//echo "<br />hello line 14<br />";


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 


$query1="SELECT py1 as 'compliance_fyear_last' from fiscal_year where report_year='$compliance_fyear' ";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);
//echo "<br />py1=$py1<br />";

//exit;



//echo "park=$park<br />";
$gid=18;



if($compliance_month=='july' or $compliance_month=='august')
{
$compliance_fyear1=$compliance_fyear_last;
}
else
{
$compliance_fyear1=$compliance_fyear;
}	




//echo "gid=$gid";exit;
$query4="
SELECT park as 'G18_park', SUM( score ) / COUNT( id ) AS  'mission_score'
FROM wex_vehicle_compliance
WHERE 1 
AND wex_fyear =  '$compliance_fyear1'
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
	$header_array[$row['G18_park']]=$row['mission_score'];
	}
//echo "<pre>"; print_r($header_array); echo "</pre>";  exit;		




foreach($header_array AS $playstation=>$percomp)
	{
	
	//echo "<tr><th>$index</th></tr>";
	$query5="update mission_scores
	         set percomp='$percomp'
			 where playstation='$playstation'
			 and gid='18' and fyear='$compliance_fyear1' ; ";
	 
	 //echo "query5=$query5<br />";
     $result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
	}

// GID stands for "Game ID"
// GID Scores can be found in TABLE=mission_scores.  GID Value for WEX CARD USE=18. 
// Parks/Centers are scored on a Fiscal Year Basis which means that each Park/Center will have multiple records for GID=18
// ... each Park/Center has a Record for each Fiscal Year (FY1617, FY1718, etc...)
// The "default value" for Parks/Centers which are scored for "Wex Card Use" is VALUE=.01  
// Parks/Centers which have a VALUE of 0.00 are considered Parks/Centers that are NOT Scored (and that Park will have a Blank
// ... "no score" on the Wheelhouse for GID=18 (WEX Card Use).
//  For a good visual on this "kludge", follow these Steps:
//  Log into MoneyCounts as a Regional Superintendent (ie. John Fullwood)
//  Notice that the "PCI Compliance" is a tasx ONLY completed by CRS Parks  (NON-CRS Parks have NO Score, but
//  I need for those Parks to show up on John's WHEELHOUSE.  If not the Scores for each Park would not align with the Park Headers
//  Basically ALL Parks in the Coastal Region need a VALUE in table=mission_score for GID=18 EVEN if the Game/Task does not apply to them
// This applies to all "Wheelhouse Tasks" in MoneyCounts.  Parks that aren't required to complete a TASK are assigne a Value of 0.00
//  This means that the "Default Value" for all Parks that must complete the task is .01  instead of .00.   
//  Remember, 0.00 is reserved for "Placeholder Parks" which are not required to complete the "Wheelhouse Task" 

// the Query below insures that ALL Parks that are required to complete the Task receive an Over-ride VALUE of .01 
// ..even though their true value (from above) came back as 0.00

$query7a="update mission_scores
set percomp='.01'
where gid = '18'
and fyear = '$compliance_fyear1'
and percomp='0.00'

 ";


//echo "query7a=$query7a<br />";
$result7a=mysqli_query($connection, $query7a) or die ("Couldn't execute query7a. $query7a");

 

// The Query below just insures that Parks/Centers which are not required to "play the Game" (GID#18) receive a VALUE='0.00' 
// Those Parks/Centers with VALUE='0.00'  show up in Wheelhouse, but only as a PlACEHOLDER. NO Score shows for these Parks/Centers
 
 $query7b="update mission_scores,center
set mission_scores.percomp='0.00'
where mission_scores.gid = '18'
and mission_scores.fyear = '$compliance_fyear1'
and mission_scores.playstation=center.parkcode
and center.fund='1280'
and center.actcenteryn='y'
and center.wex_active='n'
 ";


//echo "query7b=$query7b<br />"; 
$result7b=mysqli_query($connection, $query7b) or die ("Couldn't execute query7b. $query7b");


 


$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&compliance_fyear=$compliance_fyear&compliance_month=$compliance_month&report_type=form");}
 


 

 ?>
 