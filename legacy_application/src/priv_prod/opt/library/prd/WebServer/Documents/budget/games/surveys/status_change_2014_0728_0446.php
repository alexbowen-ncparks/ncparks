<?php
session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$player=$_SESSION['budget']['tempID'];


extract($_REQUEST);

//echo "$report_date<br />";exit;


//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";exit;
if($status=='show'){$status_change='hide';}
if($status=='hide'){$status_change='show';}
//echo "status_change=$status_change";//exit;
//echo "<br />";
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters


//Insert Survey Questions into TABLE=survey_scores for all Centers in
//Centers TABLE where fund='1280'andactcenteryn='y'  (Centers82 x # of survey questions3=246)
//get inserted into table

//Query to get all the QID Values (unique questions) for the GID (unique survey)
//from TABLE=survey_questions
//echo "level=$level<br />";exit;
if($level=='5')
{

$query1="
select 
gid,qid,question,example_answer
from survey_questions
where
gid='$gid'
order by qid;
";
//echo "query4=$query4";

	 
$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");
$num1=mysql_num_rows($result1);


echo "<br />";


while ($row=mysql_fetch_assoc($result1))
	{
	$header_array[$row['qid']]="";
	}
//echo "<pre>"; print_r($header_array); echo "</pre>"; // exit;		

foreach($header_array AS $index=>$header)
	{
	
	//echo "<tr><th>$index</th></tr>";
	$query2="insert into survey_scores(gid,qid,playstation)
	         select '$gid',$index,parkcode
			 from center where fund='1280'
			 and actcenteryn='y'; ";
	 
     $result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");
	}


	
$query2a="update survey_scores,survey_questions
          set survey_scores.question=survey_questions.question,
          survey_scores.example_answer=survey_questions.example_answer
          where survey_scores.gid='$gid'
          and survey_questions.gid='$gid'
          and survey_scores.qid=survey_questions.qid; ";
//echo "query2a=$query2a";exit;


$result2a = mysql_query($query2a) or die ("Couldn't execute query2a. $query2a");
}	
	
	
	
if($level=='5')
{

$query3a="update survey_games set status='$status_change' where gid='$gid' ; ";
//echo "query3a=$query3a";exit;
}

$result3a = mysql_query($query3a) or die ("Couldn't execute query3a. $query3a");

header("location: games.php");

//exit;


?>