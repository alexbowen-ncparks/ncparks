<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");

//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//$today_date=date("Ymd");
//echo "start_date=$start_date";
//echo "<br />";
//echo "end_date=$end_date";
//echo "<br />";
//echo "today_date=$today_date";
//echo "<br />";//exit;


//////mysql_connect($host,$username,$password);
//@mysql_select_db($database) or die( "Unable to select database");
$query3="SELECT * FROM project_steps_detail where cid='$cid' ";
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
$row3=mysqli_fetch_array($result3);
extract($row3);

 
echo "<html>";
echo "<head>";
echo "<title>Edit Record</title>";
echo "</head>";
echo "<body bgcolor='#FFF8DC'>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name</i> </font></H1>";
//echo "<H1 ALIGN=LEFT > <font color='red'><i>Add Record</i></font></H1>";
echo "<H3 ALIGN=CENTER > <A href=main.php> Return HOME </A></H3>";
//echo "<H1 ALIGN=CENTER > <font color='red'>Duplicate project_note_id=$project_note_id</font></H1>";

echo "<br/>";


echo "<form name='form1' method='post' action='edit_project_steps_detail_update.php'>";

echo "<font color=blue size=5>";



//echo  "user:<input name='user' type='text' id=user value=\"$user\">";
//echo "<br />system_entry_date:<input name='system_entry_date' type='text' id=system_entry_date value=\"$system_entry_date\">";
//echo "<br />Category:<input name='project_category' type='text' id=project_category size=50 value=\"$project_category\">";
//echo "<br />Topic:<input name='project_name' type='text' id=project_name size=50 value=\"$project_name\">";

echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr><th><font color='blue'>Field</font></th><th>Value</th></tr>";
	   echo "<tr><td><font color='blue'>fiscal_year</font></td><td><input type='text' name='fiscal_year' value='$fiscal_year' ></td></tr>";
	   echo "<tr><td><font color='blue'>start_date</font></td><td><input type='text' name='start_date' value='$start_date'></td></tr>";
	   echo "<tr><td><font color='blue'>end_date</font></td><td><input type='text' name='end_date' value='$end_date'></td></tr>";
	   echo "<tr><td><font color='red'>project_category</font></td><td><input type='text' name='project_category' value='$project_category' ></td></tr>";
	   echo "<tr><td><font color='red'>project_name</font></td><td><input type='text' name='project_name' value='$project_name'></td></tr>";
	   echo "<tr><td><font color='red'>step_group</font></td><td><input type='text' name='step_group' value='$step_group'></td></tr>";
	   echo "<tr><td><font color='blue'>step</td></font><td><input type='text' name='step' value='$step'></td></tr>";
	   echo "<tr><td><font color='red'>step_num</td></font><td><input type='text' name='step_num' value='$step_num'></td></tr>";
	   //echo "<tr><td><font color='blue'>step_name</td></font><td><input type='text' size='35' name='step_name' value='$step_name'></td></tr>";
	   echo "<tr><td><font color='blue'>step_name</td></font><td><textarea name='step_name' cols='30' rows='5'>$step_name</textarea></td></tr>";
	   echo "<tr><td><font color='blue'>link</td></font><td><input type='text' name='link' value='$link' ></td></tr>";
	   echo "<tr><td><font color='blue'>weblink</font></td><td><input type='text' name='weblink' value='$weblink'></td></tr>";
	   echo "<tr><td><font color='blue'>status</font></td><td><input type='text' name='status' value='$status'></td></tr>";
	   	   echo "</table>";

//echo "<br /> <br />";
echo "<input type='hidden' name='cid' value='$cid'>";
echo "<input type='submit' name='submit'
value='Edit$cid'>";

echo "</form>";


//echo "</font>";

//echo "</form>";



echo "</body>";
echo "</html>";

?>

























