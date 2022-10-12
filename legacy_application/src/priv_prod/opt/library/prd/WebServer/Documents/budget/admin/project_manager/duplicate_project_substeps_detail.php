<?php

session_start();

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");


/*$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//$project_category=$_REQUEST['project_category'];
//$project_name=$_REQUEST['project_name'];

//echo $project_category;
//echo $project_name;




//$table1="weekly_updates";
//$table2="project_notes2";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");


$query="SELECT * FROM project_steps where project_category='$project_category' 
        and project_name='$project_name' ";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
$num=mysqli_num_rows($result);

// frees the connection to MySQL


////mysql_close();

$row=mysqli_fetch_array($result);
 extract($row);
 */
 
echo "<html>";
echo "<head>";
echo "<title>Add Record</title>";
echo "</head>";
echo "<body bgcolor='#FFF8DC'>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name</i> </font></H1>";
//echo "<H1 ALIGN=LEFT > <font color='red'><i>Add Record</i></font></H1>";
echo "<H3 ALIGN=CENTER > <A href=main.php> Return HOME </A></H3>";
//echo "<H1 ALIGN=CENTER > <font color='red'>Duplicate project_note_id=$project_note_id</font></H1>";

echo "<br/>";


echo "<form name='form1' method='post' action='duplicate_project_substeps_detail_insert.php'>";

echo "<font color=blue size=5>";



//echo  "user:<input name='user' type='text' id=user value=\"$user\">";
//echo "<br />system_entry_date:<input name='system_entry_date' type='text' id=system_entry_date value=\"$system_entry_date\">";
//echo "<br />Category:<input name='project_category' type='text' id=project_category size=50 value=\"$project_category\">";
//echo "<br />Topic:<input name='project_name' type='text' id=project_name size=50 value=\"$project_name\">";

echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr><th><font color='blue'>Field</font></th><th>Value</th></tr>";
	   echo "<tr><td><font color='blue'>fiscal_year</font></td><td><input type='text' name='fiscal_year' ></td></tr>";
	   echo "<tr><td><font color='blue'>start_date</font></td><td><input type='text' name='start_date' ></td></tr>";
	   echo "<tr><td><font color='blue'>end_date</font></td><td><input type='text' name='end_date' ></td></tr>";
	   echo "<tr><td><font color='red'>project_category</font></td><td><input type='text' name='project_category' ></td></tr>";
	   echo "<tr><td><font color='red'>project_name</font></td><td><input type='text' name='project_name' ></td></tr>";
	   echo "<tr><td><font color='red'>step_group</font></td><td><input type='text' name='step_group' ></td></tr>";
	   echo "<tr><td><font color='blue'>step</td></font><td><input type='text' name='step' ></td></tr>";
	   echo "<tr><td><font color='red'>step_num</td></font><td><input type='text' name='step_num' ></td></tr>";
	   echo "<tr><td><font color='blue'>step_name</td></font><td><input type='text' name='step_name' ></td></tr>";
	   echo "<tr><td><font color='red'>substep_num</td></font><td><input type='text' name='substep_num' ></td></tr>";
	   echo "<tr><td><font color='blue'>substep_name</td></font><td><input type='text' name='substep_name' ></td></tr>";
	   echo "<tr><td><font color='blue'>link</td></font><td><input type='text' name='link' ></td></tr>";
	   echo "<tr><td><font color='blue'>weblink</font></td><td><input type='text' name='weblink' ></td></tr>";
	   echo "<tr><td><font color='blue'>status</font></td><td><input type='text' name='status' ></td></tr>";
	   	   echo "</table>";

echo "<br /> <br />";
echo "<input type='submit' name='submit'
value='ADD New Record'>";

echo "</form>";


//echo "</font>";

//echo "</form>";



echo "</body>";
echo "</html>";



?>