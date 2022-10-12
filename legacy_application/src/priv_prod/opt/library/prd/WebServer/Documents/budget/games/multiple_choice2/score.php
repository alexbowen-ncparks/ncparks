<?php
session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$tempID=$_SESSION['budget']['tempID'];
$player=$_SESSION['budget']['tempID'];


//echo "Score Page is Under Contructions";exit;
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
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");

extract($_REQUEST);
// echo "q=$qid<br />";
// $qid=htmlentities($quid);
// echo "q=$qid<br />"; //exit;

$query1="select pid from players where player='$player' ";

//echo "query1=$query1";exit;

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

//$num1=mysqli_num_rows($result1);
$row1=mysqli_fetch_array($result1);

extract($row1);

$query2="select min(qid) as 'qidF' from questions where gid='$gid' ";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2); //returns $qidF (First question in Game)
//echo "qidF=$qidF";echo "<br />";

$query3="select max(qid) as 'qidL' from questions where gid='$gid' ";
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$row3=mysqli_fetch_array($result3);
extract($row3); //returns $qidL (Last question in Game)
//echo "qidL=$qidL";echo "<br />";


//echo "player $player";echo "<br />";
//echo "pid $pid";echo "<br />";
//echo "gid $gid";echo "<br />";
//echo "qid $qid";echo "<br />";
//echo "choice $choice";echo "<br />";
//echo "qidF $qidF";echo "<br />";
//echo "qidL $qidL";echo "<br />";
//echo "sid $sid";echo "<br />";//exit;


$query4="update scores
         set choice='$choice'
		 where sid='$sid' and pid='$pid' and gid='$gid' and qid='$qid'		 
         ";

//echo "query4=$query4";//exit;

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");


$query5="update scores
         set points='1'
		 where sid='$sid' and pid='$pid' and gid='$gid' and qid='$qid' and choice=answer             		 
         ";

//echo "query5=$query5";exit;

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

//echo "success";exit;

//$qid=($qid+1);

$query6="select min(qid) as 'qid' from scores
         where sid='$sid' and pid='$pid' and gid='$gid'
		 and choice = '' ";

echo "query6=$query6<br />";		 
		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$row6=mysqli_fetch_array($result6);
extract($row6);
if($qid=='')
{
$query7="select max(qid) as 'qid' from scores
         where sid='$sid' and pid='$pid' and gid='$gid'
		 ";

echo "query7=$query7<br />";		 
		 
$result7 = mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");

$row7=mysqli_fetch_array($result7);
extract($row7);

$qid=($qid+1);

}
//echo "qid=$qid<br />"; exit;

header("location: games.php?sid=$sid&gidS=$gid&qid=$qid");
//exit;


?>