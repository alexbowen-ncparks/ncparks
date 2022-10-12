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


//$table="infotrack_projects";
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
//$gid=10;
//echo "gid=$gid";exit;
$query4="
SELECT pid,gid,sum(points) as 'points'
from scores where valid_record='y'
and pid='281'
group by pid,gid
";
//echo "query4=$query4";

	 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);


echo "<br />";

while ($row4=mysqli_fetch_array($result4))
	{
	//$thumb[]=$row4['photo_location'];
	$pid[]=$row4['pid'];
	$gid[]=$row4['gid'];
	$points[]=$row4['points'];
	//$MyComments[]=$row4['comments2'];
	//$label[]=$row4['label'];
	//$id[]=$row4['id'];
	}	
echo "<pre>"; print_r($pid); echo "</pre>";  //exit;
echo "<pre>"; print_r($gid); echo "</pre>";  //exit;
echo "<pre>"; print_r($points); echo "</pre>";  //exit;

//$point_total=array_sum($points[]);
//$recs=count($pid[]);

//echo "points=$points<br />";  exit;




for($i=0; $i<$num4; $i++)
	{
	
	$query="update scored_games set points = '$points[$i]'
            where pid = '$pid[$i]' and gid = '$gid[$i]'
      			";

//echo "query=$query<br />";
				
	$result=mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
	
$j++;	
	}

$query2="update scored_games
         set score = (point_value*points)
         where 1 ";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");


echo "ok<br />";		 
	
exit;



/*


foreach($header_array AS $playstation=>$percomp)
	{
	
	//echo "<tr><th>$index</th></tr>";
	$query5="update mission_scores
	         set percomp='$percomp'
			 where playstation='$playstation'
			 and gid='10'; ";
	 
	 echo "query5=$query5<br />";
     $result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
	}
	

$query7a="update mission_scores
set percomp='.01'
where gid = '10' and percomp='0.00' ";



$result7a=mysqli_query($connection, $query7a) or die ("Couldn't execute query7a. $query7a");

 echo "query7a=$query7a<br />";

echo "ok";
*/
 echo "</body>";
 echo "</html>";

 

 ?>
 