<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
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
//$query3="SELECT * FROM project_steps_detail where cid='$cid' ";
//$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
//$num3=mysqli_num_rows($result3);
//$row3=mysqli_fetch_array($result3);
//extract($row3);

 
echo "<html>";
echo "<head>";
echo "<title>Contract Expenditure Form</title>";
echo "</head>";
echo "<body bgcolor='#FFF8DC'>";
echo "<H1 ALIGN=CENTER > <font color=brown><i>Contract Expenditure Form</i> </font></H1>";
//echo "<H1 ALIGN=LEFT > <font color='red'><i>Add Record</i></font></H1>";
echo "<H3 ALIGN=CENTER > <A href=budget/menu.php?forum=blank> Return HOME </A></H3>";
//echo "<H1 ALIGN=CENTER > <font color='red'>Duplicate project_note_id=$project_note_id</font></H1>";

echo "<br/>";

//echo "<H2><font color='red'>WARNING-When changing step_group OR step_num, User must re-name associated PHP File</font></H2>";
echo "<form name='form1' method='post' action='add_record.php'>";

echo "<font color=blue size=5>";



//echo  "user:<input name='user' type='text' id=user value=\"$user\">";
//echo "<br />system_entry_date:<input name='system_entry_date' type='text' id=system_entry_date value=\"$system_entry_date\">";
//echo "<br />Category:<input name='project_category' type='text' id=project_category size=50 value=\"$project_category\">";
//echo "<br />Topic:<input name='project_name' type='text' id=project_name size=50 value=\"$project_name\">";

echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	  
	   echo "<tr><td><font color='blue'>Reporting Period (Date)</font></td><td><input type='text' name='reporting_period' value='$reporting_period' ></td><td>Purchase Order Number (Required)</td><td><input type='text' name='purchase_order_number' value='$purchase_order_number' ></td></tr>";
	  
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

























