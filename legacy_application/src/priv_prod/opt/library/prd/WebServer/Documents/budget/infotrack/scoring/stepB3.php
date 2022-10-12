<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

echo "<pre>";print_r($_REQUEST);"</pre>";  exit;

extract($_REQUEST);

if($compliance_fyear==''){echo "compliance_fyear missing"; exit;}
if($compliance_month==''){echo "compliance_month missing"; exit;}

echo "<br />hello line 14<br />";

//exit;

if($compliance_month != 'july')
{


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

$gid=16;
//echo "gid=$gid";exit;
$query4="
SELECT park as 'G16_park', SUM( score ) / COUNT( id ) AS  'mission_score'
FROM concessions_pci_compliance
WHERE 1 
AND fyear =  '$compliance_fyear'
AND valid =  'y'
GROUP BY park
ORDER BY park
";
echo "query4=$query4";
exit;

	 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);


echo "<br />";


while ($row=mysqli_fetch_assoc($result4))
	{
	$header_array[$row['G16_park']]=$row['mission_score'];
	}
echo "<pre>"; print_r($header_array); echo "</pre>";  //exit;		

/*
$query9="update mission_scores
         set percomp='$mission_score'
         where playstation='$concession_location' and gid='10' ";
		 
		 
$query5="insert into survey_questions_test(gid,qid,parkcode)
	         select '$gid',$index,parkcode
			 from center where fund='1280'
			 and actcenteryn='y'; ";		 
		 
		 
*/




foreach($header_array AS $playstation=>$percomp)
	{
	
	//echo "<tr><th>$index</th></tr>";
	$query5="update mission_scores
	         set percomp='$percomp'
			 where playstation='$playstation'
			 and gid='16' and fyear='$compliance_fyear' ; ";
	 
	 echo "query5=$query5<br />";
     $result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
	}
	

$query7a="update mission_scores
set percomp='.01'
where gid = '16'
and fyear = '$compliance_fyear'
and percomp='0.00'
and playstation != 'eadi'
and playstation != 'nodi'
and playstation != 'sodi'
and playstation != 'wedi'
and playstation != 'disw'
and playstation != 'foma'
and playstation != 'jori'
and playstation != 'sila'
and playstation != 'cacr'
and playstation != 'hari'
and playstation != 'mari'
and playstation != 'chro'
and playstation != 'moje'

 ";



$result7a=mysqli_query($connection, $query7a) or die ("Couldn't execute query7a. $query7a");

 echo "query7a=$query7a<br />";
}

if($compliance_month=='july')
{
echo "<br />Line 95: No Update Necessary<br />";
exit;	
	
}

$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&compliance_fyear=$compliance_fyear&compliance_month=$compliance_month&report_type=form");}
 

 

 ?>
 