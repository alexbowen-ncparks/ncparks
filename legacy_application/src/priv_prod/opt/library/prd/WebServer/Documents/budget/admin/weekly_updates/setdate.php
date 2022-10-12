<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters


//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//$project_category=$_REQUEST['project_category'];
//$project_name=$_REQUEST['project_name'];

//echo $project_category;
//echo $project_name;




$table1="weekly_updates";
//$table2="project_notes2";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query1="SELECT max(end_date)as 'max_date' from weekly_updates where 1";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) from table=weekly_updates as variable=$max_date

//echo $max_date;
$query2="SELECT * from weekly_updates where end_date='$max_date'";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);//brings back 4 variables: $fiscal_year,$start_date,$end_date,$complete from 
               //table=weekly_updates for record with max(end_date) to be displayed on Form Header
//echo $start_date."to".$end_date."for".$fiscal_year;


echo "<html>";
echo "<head>
<style>
form {color: blue;}
input {color: red;}
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>
	


</head>";

echo "<H1 ALIGN=LEFT > <font color=brown><i>Weekly Updates-Set Dates</i> </font></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/menu.php?forum=blank> Return HOME </A></font></H2>";
echo "<br />";
echo
"<form method=post action=setdate1.php>";
echo "<font size=5>"; 
echo "fiscal_year:<input name='fiscal_year' type='text' size='12' id=fiscal_year value='$fiscal_year'>";
echo "<br />";
echo "start_date:&nbsp<input name='start_date' type='text' size='12' id=start_date value='$start_date'>";
echo "<br />";
echo "end_date:&nbsp&nbsp&nbsp<input name='end_date' type='text' size='12' id=end_date value='$end_date'>";
echo "<br />";
echo "complete:&nbsp&nbsp&nbsp<input name='complete' type='text' size='12' id=complete_date value='$complete'>";


echo "<br /><br />";

echo "&emsp";
echo "<input type=submit value=UPDATE>";

echo "</form>";



echo "</html>";
 
 
 
 ?>




















