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
<tr><td><font size='+1'>You are on Step 2: <b>WC Refusal Of Treatment</b></font></td></tr>
<tr><td>&nbsp;</td></tr>

<tr><td><font size='+1'>
Does the injured person Accept or Refuse medical treatment?</font></td></tr>
<tr><td>
<form method='GET' action='wc_authorization_3.php'>
<input type='hidden' name='wc_id' value='$wc_id'>
<input type='submit' name='submit' value='I accept medical treatment.' style=\"color:green;margin-left:20px;font-size:20px;\">
</form></td>

<td><form method='GET' action='refuse_treatment.php'>
<input type='hidden' name='wc_id' value='$wc_id'>
<input type='submit' name='submit' value='I refuse medical treatment.' style=\"color:red;margin-left:20px;font-size:20px;\">
</form></td></tr>
</instructions>";
echo "</body></html>";
?>