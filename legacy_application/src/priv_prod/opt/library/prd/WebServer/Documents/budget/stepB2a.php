<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");

//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");
//echo "start_date=$start_date";
//echo "<br />";
//echo "end_date=$end_date";
//echo "<br />";
//echo "today_date=$today_date";
//echo "<br />";//exit;


//////mysql_connect($host,$username,$password);
//@mysql_select_db($database) or die( "Unable to select database");
/*
$query3="SELECT * FROM project_steps_detail where cid='$cid' ";
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
$row3=mysqli_fetch_array($result3);
extract($row3);
*/
 
echo "<html>";
echo "<head>";
echo "<title>Add Record</title>";
echo "</head>";
echo "<body bgcolor='#FFF8DC'>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>$step</i> </font></H1>";
echo "<H2 ALIGN=LEFT > <font color=brown><i>$step_name</i> </font></H2>";
//echo "<H1 ALIGN=LEFT > <font color='red'><i>Add Record</i></font></H1>";
echo "<H3 ALIGN=CENTER > <A href=main.php> Return HOME </A></H3>";
//echo "<H1 ALIGN=CENTER > <font color='red'>Duplicate project_note_id=$project_note_id</font></H1>";

echo "<br/>";

//echo "<H2><font color='red'>WARNING-When changing step_group OR step_num, User must re-name associated PHP File</font></H2>";
echo "<form name='form1' method='post' action='stepB2a_update.php'>";

echo "<font color=blue size=5>";



//echo  "user:<input name='user' type='text' id=user value=\"$user\">";
//echo "<br />system_entry_date:<input name='system_entry_date' type='text' id=system_entry_date value=\"$system_entry_date\">";
//echo "<br />Category:<input name='project_category' type='text' id=project_category size=50 value=\"$project_category\">";
//echo "<br />Topic:<input name='project_name' type='text' id=project_name size=50 value=\"$project_name\">";
if($message=='y'){echo "Score Rule added for Gid=$gid and Score Month=$score_month2 <img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />";}
echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr><th><font color='blue'>Field</font></th><th>Value</th></tr>";
	   echo "<tr><td><font color='blue'>fiscal_year</font></td><td><input type='text' readonly='readonly' name='fiscal_year' value='$fiscal_year' ></td></tr>";
	   echo "<tr><td><font color='red'>GID (game id)</td></font><td><input type='text' name='gid' value='$gid'></td></tr>";
	   echo "<tr><td><font color='red'>Score Month (jul,etc.)</td></font><td><input type='text' name='score_month' value='$score_month'></td></tr>";
	   echo "<tr><td><font color='red'>Score Value (100,90,etc.)</td></font><td><input type='text' name='score_value' value='$score_value'></td></tr>";
	   echo "<tr><td><font color='red'>Completion Date Begin (20140701,etc.)</td></font><td><input type='text' name='completion_date_begin' value='$completion_date_begin'></td></tr>";
	   echo "<tr><td><font color='red'>Completion Date End (20140710,etc.)</td></font><td><input type='text' name='completion_date_end' value='$completion_date_end'></td></tr>";
	   
	   	   echo "</table>";

//echo "<br /> <br />";
//echo "<input type='hidden' name='cid' value='$cid'>";
/*
echo "<input type='submit' name='submit'
value='Add_Step'>";
*/
echo "<input type='submit' name='submit'
value='Insert Records'>";





echo "</form>";


//echo "</font>";

//echo "</form>";



echo "</body>";
echo "</html>";

?>

























