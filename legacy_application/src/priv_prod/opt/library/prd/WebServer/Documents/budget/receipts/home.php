<?php

session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");


$table="receipts_reports";

$query1="SELECT body_bgcolor
from format_custom
WHERE 1 and user_id='tony'
";

$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$row1=mysqli_fetch_array($result1);

extract($row1);

$body_bg=$body_bgcolor;

echo "<html>";
echo "<head>
<title>Home</title>";

//include ("css/test_style.php");



echo "
<style type='text/css'>
body { background-color: $body_bg; }
table { background-color: $body_bg; font-color: blue; font-size: 10;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
</style>";


echo "</head>";



//echo "<H1 ALIGN=left><font color=brown><i>Revenue Reports</i></font></H1>";

echo "<br />";

$query2="select distinct title from receipts_reports where 1 
         order by title";
		 
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$num2=mysqli_num_rows($result2);

//echo "<html>";

 if($title_selected !='y') 
 
{
//echo "<h2 ALIGN=left><font color=green>WebGroups:$num4</font></h2>";
echo "<H1 ALIGN=left><font color=brown><i>Receipts</i></font></H1>";
//echo "<H1 ALIGN=left><font color=brown><i>Revenue Reports-$num2</i></font></H1>";
//
echo "<table border=1>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<th align=left><font color=brown>Report</font></th>"; 

while ($row2=mysqli_fetch_array($result2)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row2);

if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           <td><a href='home.php?&title=$title&title_selected=y'>$title</a></td> 
	          
</tr>";

}
 exit;
}

if($title_selected =='y')
{

$query3="SELECT *
FROM $table
WHERE 1 and title='$title'
ORDER BY title ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$row3=mysqli_fetch_array($result3);

extract($row3);
//echo $web_address;
{header("location: $web_address");}


}
else {exit;}

?>



















	














