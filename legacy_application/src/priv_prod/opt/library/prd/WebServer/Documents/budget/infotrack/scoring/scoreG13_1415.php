<?php
/*
session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: /login_form.php?db=budget");
}
*/
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}



//$file = "articles_menu.php";
//$lines = count(file($file));


$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$playstation=$_SESSION['budget']['select'];
$playstation_center=$_SESSION['budget']['centerSess'];
//$pcode=$_SESSION['budget']['select'];



//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;


//include("../../../include/connectBUDGET.inc");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

//echo "park=$park<br />";
$gid=13;
//echo "gid=$gid";exit;
$query4="
SELECT park as 'G13_park', SUM( score ) / COUNT( id ) AS  'mission_score'
FROM fuel_tank_usage
WHERE 1 
AND fyear =  '1415'
AND valid =  'y'
GROUP BY park
ORDER BY park
";
//echo "query4=$query4";

	 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);


echo "<br />";


while ($row=mysqli_fetch_assoc($result4))
	{
	$header_array[$row['G13_park']]=$row['mission_score'];
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
			 and gid='13' and fyear='1415' ; ";
	 
	 echo "query5=$query5<br />";
     $result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
	}
	

$query7a="update mission_scores
set percomp='.01'
where gid = '13'
and fyear = '1415'
and percomp='0.00'
and playstation != 'eadi'
and playstation != 'nodi'
and playstation != 'sodi'
and playstation != 'wedi'
 ";



$result7a=mysqli_query($connection, $query7a) or die ("Couldn't execute query7a. $query7a");

 echo "query7a=$query7a<br />";

echo "ok";

 echo "</body>";
 echo "</html>";

 

 ?>
 