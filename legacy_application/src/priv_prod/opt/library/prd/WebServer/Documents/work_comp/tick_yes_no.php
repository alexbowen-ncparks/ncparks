<?php
ini_set('display_errors',1);
$database="work_comp";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database); // database
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
extract($_REQUEST);

echo "<!DOCTYPE html>
<html>
<head>";

echo "
<style>
instructions
	{
	position:absolute;
	left:10px;
	top:10px;
	
	}
</style>
</head><body>";

echo "<instructions>
<table>
<tr><td><font size='+1'>You are on Step 9: <b>WC Tick Related Treatment</b></font></td></tr>

<tr><td><font size='+1'>If this is a tick related medical treatment, upload the tick log.</font></td></tr>
<tr><td> <br /></td></tr>
<tr><td>
<form method='GET' action='tick_related_9.php'>
<input type='hidden' name='wc_id' value='$wc_id'>
<input type='submit' name='submit' value='I need to upload the tick log.' style=\"color:green;margin-left:20px;font-size:20px;\">
</form></td>

<td><form method='GET' action='review_submission_steps.php'>
<input type='hidden' name='wc_id' value='$wc_id'>
<input type='submit' name='submit' value='I do not need to upload a tick log.' style=\"color:red;margin-left:20px;font-size:20px;\">
</form></td></tr>
</instructions>";
echo "</body></html>";
?>