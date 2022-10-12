<?php

extract($_REQUEST);
if(empty($beacon_num))
	{

include("../css/TDnull.php");
	echo "<html><head></head><body>";

	echo "<table align='center'><tr><th>
	<h2><font color='purple'>NC DPR Seasonal Employee<br />DENR Request Form </font></h2></th></tr></table>";

	echo "<form method='POST'>
	Enter BEACON Position Number: <input type='text' name='beacon_num'>
	<input type='submit' name='submit' value='Submit'>
	</form>
	";
	exit;
	}

if(empty($submit_pdf))
	{
	
$database="hr";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database 

$sql="SELECT t1.* , t2.Fname, t2.M_initial as Mname, t2.Lname, t2.beaconID, t3.classification, t3.pay_grade, t3.budgeted_amount, t4.center
from employ_position as t1
LEFT JOIN sea_employee as t2 on t1.tempID=t2.tempID
LEFT JOIN classification as t3 on t1.beacon_num=t3.beacon_num
LEFT JOIN seasonal_payroll as t4 on t1.beacon_num=t4.beacon_posnum
where t1.beacon_num='$beacon_num'";
$result = mysql_query($sql);
$row=mysql_fetch_assoc($result);
extract($row);
//echo "$sql<pre>"; print_r($row); echo "</pre>";  exit;

	echo "<table align='c'><tr><th>
	<h2><font color='purple'>NC DPR Seasonal Employee<br />DENR Request Form </font></h2></th></tr></table>";

$name=$Fname." ".(!empty($Mname)?$Mname." ":'').$Lname;
$action_array=array("Hire","Separate","Reinstatement");
include("../css/TDnull.php");
	echo "<html><head></head><body>";
		echo "<form method='POST' action='denr_pdf.php'>
		<table>
	
		<tr><td>Employee Name:</td><td><input type='text' name='name' value=\"$name\"></td></tr>
		<tr><td> BEACON ID #:</td><td><input type='text' name='beaconID' value='$beaconID'></td></tr>
		<tr><td> Division:</td><td><input type='text' name='division' value='DPR - $parkcode'></td></tr>
		<tr><td> Date Effective:</td><td><input type='text' name='effective_date' value='$effective_date'></td></tr>";
	
		echo "<tr><td>BEACON Action:</td><td>
		<select name='beacon_action'><option selected=''></option>\n";
		foreach($action_array as $k=>$v)
			{
			echo "<option value='$v'>$v</option>\n";
			}
	
		echo "</select></td></tr>";
	
		echo "<tr><td>&nbsp;</td></tr>
	
		<tr><td> Classification:</td><td><input type='text' name='classification' value='$classification'></td></tr>
		<tr><td> BEACON Position Number:</td><td><input type='text' name='beacon_num' value='$beacon_num'></td></tr>
		<tr><td> Working Title (if different):</td><td><input type='text' name='position_title' value='$position_title'></td></tr>
		<tr><td> Salary Grade:</td><td><input type='text' name='pay_grade' value='$pay_grade'></td></tr>
		<tr><td> Requested Salary:</td><td><input type='text' name='pay_rate' value='$pay_rate'></td></tr>
		<tr><td> Budgeted Amount:</td><td><input type='text' name='budgeted_amount' value='$budgeted_amount'></td></tr>
		<tr><td> Funding Source:</td><td><input type='text' name='center' value='$center'></td></tr>
	
		<tr><td>&nbsp;</td></tr>
	
		<tr><td> BEACON Deadline Date:</td><td><input type='text' name='deadline_date' value='$deadline_date'></td></tr>
		<tr><td> Salary Reserve Created:</td><td><input type='text' name='salary_reserve_c' value='n/a'></td></tr>
		<tr><td> Salary Reserve Needed:</td><td><input type='text' name='salary_reserve_n' value='n/a'></td></tr>
	
		<tr><td> Justification/Comments:</td><td><input type='text' name='justification' value='Temporary hire for summer season.' size='80'></td></tr>
		<tr><th colspan='2'><input type='submit' name='submit_pdf' value='Submit'></td></tr>
		</table>
		</form>
		";

	exit;
	}


//include("denr_pdf.php");


?>