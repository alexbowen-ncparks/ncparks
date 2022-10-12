<?php


session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
//header("location: /login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

extract($_REQUEST);

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database

//echo "hello world<br />";


$f_year='1415';


$query4="update mission_scores 
         set complete='0',total='0'
         where gid='1' ";

$result4 = mysql_query($query4) or die ("Couldn't execute query 4.  $query4");	

	 

$query5="select park,count(id) as 'total' from vmc_posted7_v2
where f_year='$f_year'
and parent_record != 'y'
group by park
order by park ";

//echo "query5=$query5<br />";



$result5 = mysql_query($query5) or die ("Couldn't execute query 5.  $query5");

while ($row5=mysql_fetch_array($result5)){

extract($row5);

//echo "$park";
/*
echo "update mission_scores
     set total='$total'
	 where playstation='$park'
	 and gid='1'<br /> ";
*/
	 
$query_score_gid1_total="update mission_scores
     set total='$total'
	 where playstation='$park'
	 and gid='1' ";

$result_score_gid1_total = mysql_query($query_score_gid1_total) or die ("Couldn't execute query score gid1 total.  $query_score_gid1_total");
	 
	 
	 
}

//echo "<br /><br />";

$query6="select park,count(id) as 'complete' from vmc_posted7_v2
where f_year='$f_year'
and parent_record != 'y'
and record_complete = 'y'
group by park
order by park ";

//echo "query6=$query6<br />";



$result6 = mysql_query($query6) or die ("Couldn't execute query 6.  $query6");

while ($row6=mysql_fetch_array($result6)){

extract($row6);

//echo "$park";
/*
echo "update mission_scores
     set complete='$complete'
	 where playstation='$park'
	 and gid='1'<br /> ";
*/	 

$query_score_gid1_complete="update mission_scores
     set complete='$complete'
	 where playstation='$park'
	 and gid='1' ";

$result_score_gid1_complete = mysql_query($query_score_gid1_complete) or die ("Couldn't execute query score gid1 complete.  $query_score_gid1_complete");

}

?>