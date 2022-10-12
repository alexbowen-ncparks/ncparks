<?php

session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
include("../../../../include/connectBUDGET.inc");// database connection parameters
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
$query="SELECT * FROM project_steps where 1 and cid='$cid'  group by cid";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
$num=mysqli_num_rows($result);

// frees the connection to MySQL
 ////mysql_close();
 
 $row=mysqli_fetch_array($result);
 extract($row);
   
echo "<html>";
echo "<head>";
echo "<title>Edit Record</title>";
echo "</head>";
echo "<body bgcolor=#FFF8DC>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name</i>-<font color=red>(Edit Record)</font> </font></H1>";
//echo "<H1 ALIGN=CENTER > <font color=red>Update project_note_id $project_note_id</font></H1>";
echo "<H3 ALIGN=CENTER > <A href=main.php?project_category=$project_category&project_name=$project_name&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date> Return HOME </A></H3>";

echo "<br/>";


echo "<form name='form1' method='post' action='edit_notes_update.php'>";

echo "<font color=blue size=5>";

echo "<br />StepGroup<textarea name='step_group' cols='80' rows='2'>$step_group</textarea>";
echo "<br />Step&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<textarea name='step' cols='80' rows='2' >$step</textarea>";
//echo "<br />project_note_id:<input name='project_note_id' type='text' id=project_note_id value=\"$project_note_id\">";

echo  "<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>   
	   <input type='hidden' name='cid' value='$cid'>";	   
	   

echo "<br /> <br />";
echo "<input type='submit' name='submit'
value='UPDATE'>";

echo "</form>";

echo "</font>";

echo "</body>";
echo "</html>";

?>

 
 
 
  















