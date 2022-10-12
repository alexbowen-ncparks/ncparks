<?php

$database="divper";
include("../../include/auth.inc"); // used to authenticate users
//echo "<pre>"; print_r($_SESSION); echo "</pre>";

// extract($_REQUEST);
include("../../include/iConnect.inc"); 
mysqli_select_db($connection,'divper'); // database

$sql="SELECT t1.*, t3.Fname, t3.Mname, t3.Lname
FROM `position` as t1
LEFT JOIN emplist as t2 on t2.beacon_num=t1.beacon_num
LEFT JOIN empinfo as t3 on t2.tempID=t3.tempID
where t1.beacon_num='$beacon_num'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while ($row=mysqli_fetch_assoc($result))
		{
		extract($row);
		}

$sql="SELECT t3.Fname as super_first, t3.Mname as super_mid, t3.Lname as super_last
FROM `position` as t1
LEFT JOIN emplist as t2 on t2.beacon_num=t1.beacon_num
LEFT JOIN empinfo as t3 on t2.tempID=t3.tempID
where t1.beacon_num='$super_bn'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while ($row=mysqli_fetch_assoc($result))
		{
		extract($row);
		}

$the_filename="JOB_DESCRIPTION_COVER_SHEET";
header( 'Pragma: public' );
header( 'Content-Type: application/msword' );
header( 'Content-Disposition: attachment; filename="' . $the_filename . '.doc"'); 


echo "<html xmlns:o=\"urn:schemas-microsoft-com:office:office\"
xmlns:w=\"urn:schemas-microsoft-com:office:word\"
xmlns=\"http://www.w3.org/TR/REC-html40\">";

echo "<table><tr><td align='center'><h2><u>JOB DESCRIPTION COVER SHEET</u></h2></td></tr></table>";


echo "<table border='1'>
<tr><td align='left'>Current Position Classification (<i>official title</i>)</td><td>$beacon_title</td></tr>
<tr><td align='left'>Working Title</td><td>$working_title</td></tr>
<tr><td align='left'>Position Beacon Number</td><td>$beacon_num</td></tr>";

$band=array("A","J","C","NG");
if(in_array($salary_grade,$band))
	{
	$status="Career Banded  <u>   $salary_grade   </u>      Traditional              ____";
	}
else
	{
	$status="Career Banded  ____      Traditional       <u>   $salary_grade   </u>";
	}
echo "<tr><td align='left'>Position Status</td><td>$status</tr>
<tr><td align='left'>Current Employee Name:</td><td>$Fname $Mname $Lname</td></tr>
<tr><td align='left'>Current Supervisor Name and Position Number:</td><td>$super_first $super_last $super_bn</td></tr>
<tr><td align='left'>Updated Job Description Status: X</td><td> Change ___      No Change ___</td></tr>
</table>";

echo "<br /><br /><br />";

echo "<table>
<tr><td align='center'>_____________________________________________________</td></tr>
<tr><td align='center'>Supervisor Signature/Date</td></tr></table>";

echo "<br /><br />";
echo "<table><tr><td align='center'>JUSTIFICATION OF CHANGE:</td></tr></table>";
?>