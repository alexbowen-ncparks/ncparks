<?php

session_start();

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
include("../../../../include/connectBUDGET.inc");// database connection parameters

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
 
 
echo "<html>";
echo "<head>";
echo "<title>Add Record</title>";
echo "</head>";
echo "<body bgcolor='#FFF8DC'>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-($num Records)</i> </font></H1>";
//echo "<H1 ALIGN=LEFT > <font color='red'><i>Add Record</i></font></H1>";
echo "<H3 ALIGN=CENTER > <A href=main.php> Return HOME </A></H3>";
//echo "<H1 ALIGN=CENTER > <font color='red'>Duplicate project_note_id=$project_note_id</font></H1>";

echo "<br/>";


echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";

echo "<font color=blue size=5>";



//echo  "user:<input name='user' type='text' id=user value=\"$user\">";
//echo "<br />system_entry_date:<input name='system_entry_date' type='text' id=system_entry_date value=\"$system_entry_date\">";
//echo "<br />Category:<input name='project_category' type='text' id=project_category size=50 value=\"$project_category\">";
//echo "<br />Topic:<input name='project_name' type='text' id=project_name size=50 value=\"$project_name\">";
echo "<br />StepGroup&nbsp&nbsp&nbsp<textarea name='step_group' cols='80' rows='2'></textarea>";
echo "<br />Step&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<textarea name='step' cols='80' rows='2'></textarea>";
//echo "<br />Weblink<textarea name='weblink' cols='80' rows='2' ></textarea>";

//echo "<br />project_note_id:<input name='project_note_id' type='text' id=project_note_id value=\"$project_note_id\">";
echo "<input type='hidden' name='cid' value='$cid'>
       <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>";	   
	   	   
	   


echo "<br /> <br />";
echo "<input type='submit' name='submit'
value='ADD New Record'>";

echo "</form>";


echo "</font>";

//echo "</form>";



echo "</body>";
echo "</html>";



?>