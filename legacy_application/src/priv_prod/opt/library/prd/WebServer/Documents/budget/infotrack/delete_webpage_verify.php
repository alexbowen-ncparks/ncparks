<?php

session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//$project_category=$_REQUEST['project_category'];
//$project_name=$_REQUEST['project_name'];
include("../../include/connect.php");
$database="mamajone_cookiejar";
$table="project_notes";
////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="SELECT * FROM $table where 1 and project_note_id='$project_note_id'  ";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
$num=mysqli_num_rows($result);

$row=mysqli_fetch_array($result);

extract($row);



$query10="SELECT body_bgcolor
from projects_customformat
WHERE 1 and user_id='$myusername'
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;

//echo "record_count=$num";//exit;
// frees the connection to MySQL
 ////mysql_close();


//echo 'project';
//echo $project_category; 
//exit;

echo "<html>";

echo "<head>
<style type='text/css'>

body { background-color: $body_bg; }
table { background-color: $body_bg; font-color: blue; font-size: 10;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
</style>
	

</head>";

echo "<font color='red' size='3'><b>CAUTION! Are you sure you want to PERMANENTLY Delete WebPage named: $project_category-$project_name<br />Description: $project_note </b></font>";
echo "<br /><br />";



echo "<form method=post action=welcome.php>";
//echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";
//echo "<input type='hidden' name='project_category' value='$project_category'>";
//echo "<input type='hidden' name='project_name' value='$project_name'>";
	   
echo "<input type='submit' name='submit' value='NO-Return to Home Page'>";

echo "</form>";

echo "<form method=post action=webpage_delete.php>";
echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";
echo "<input type='hidden' name='project_category' value='$project_category'>";
echo "<input type='hidden' name='project_name' value='$project_name'>";
echo "<input type='hidden' name='project_note' value='$project_note'>";
	   
echo "<input type='submit' name='submit' value='YES-DELETE WebTool named $category $topic'>";
echo "</form>";
//echo "<br />";


echo "</html>";
?>