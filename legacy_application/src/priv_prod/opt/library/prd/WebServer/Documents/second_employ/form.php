<?php
include("menu.php");

if(empty($a)){exit;}

echo "<form action='update_form.php' method='POST'>";

echo "<table border='1' align='center' cellpadding='5'>";

if(empty($id)){$display="block";}else{$display="none";}
echo "<tr><td colspan='2' bgcolor='aliceblue'>
<a onclick=\"toggleDisplay('policy');\" href=\"javascript:void('')\">Policy</a>
       </td></tr>";
echo "<td colspan='2'>";
echo "<div id=\"policy\" style=\"display: $display\">";
include("policy.txt");
echo "</div></td>";
echo "</tr>";

echo "<tr><td colspan='2' bgcolor='aliceblue'>Employee Information</td></tr>";
echo "<tr><td>Name: <input type='text' name='name' value='$name'></td><td>Division: <input type='text' name='div' value='Division of Parks & Recreation' READONLY size='25'></td></tr>";
@$station=$parkCodeName[$select];
if(!isset($working_title)){$working_title="";}
echo "<tr><td>Position Classification: <input type='text' name='position' value='$position'  size='25'></td><td>Duty Station: ";
echo "<select name='park_code'><option selected=''></option>\n";
$parkCode[]="ARCH";
$parkCode[]="YORK";
foreach($parkCode as $k=>$v)
	{
	if($park_code==$v){$s="selected";}else{$s="value";}
	echo "<option $s='$v'>$v</option>\n";
	}
echo "</select></td></tr>";

echo "<tr><td>Home Address: <input type='text' name='address' value='$address'  size='45'></td><td>City: <input type='text' name='city' value='$city' size='25'> State: <input type='text' name='state' value='NC' size='2' READONLY> Zip: <input type='text' name='zip' value='$zip' size='10'></td></tr>";

echo "</table>";
// *********************************
if(!isset($employer)){$employer="";}
if(!isset($job_title)){$job_title="";}
if(!isset($employer_address)){$employer_address="";}
if(!isset($employer_state)){$employer_state="";}
if(!isset($employer_city)){$employer_city="";}
if(!isset($employer_zip)){$employer_zip="";}
if(!isset($business)){$business="";}
if(!isset($duties)){$duties="";}
if(!isset($work_day)){$work_day="";}
if(!isset($dates)){$dates="";}
echo "<table border='1' align='center' cellpadding='5'>";
echo "<tr><td colspan='2' bgcolor='aliceblue'>Supplementary Employer</td></tr>";
echo "<tr><td>Employer: <input type='text' name='employer' value='$employer' size='45'></td><td>Job Title: <input type='text' name='job_title' value='$job_title' size='25'></td></tr>";

echo "<tr><td>Street Address: <input type='text' name='employer_address' value='$employer_address'  size='45'></td><td>City: <input type='text' name='employer_city' value='$employer_city' size='25'> State: <input type='text' name='employer_state' value='$employer_state' size='2'> Zip: <input type='text' name='employer_zip' value='$employer_zip' size='10'></td></tr>";

echo "<tr><td colspan='2'>Nature of employer’s business or profession: <input type='text' name='business' value='$business'  size='75'></td>";

echo "<tr><td colspan='2'>Description of duties to be performed: <input type='text' name='duties' value='$duties'  size='75'></td>";
echo "<tr><td colspan='2'>Days and hours of employment: <input type='text' name='work_day' value='$work_day'  size='75'></td>";
echo "<tr><td colspan='2'>Anticipated dates of employment: <input type='text' name='dates' value='$dates'  size='75'></td>";
echo "</tr>";

echo "<tr><td colspan='2' align='center' bgcolor='pink'>$action Request for $tempID
<input type='hidden' name='action' value='$action'>";
if(!empty($id))
	{
	echo "<input type='hidden' name='id' value='$id'>";
	}
echo "
<input type='hidden' name='tempID' value='$tempID'>
<input type='submit' name='submit' value='Submit'></td>";
echo "</tr>";
echo "</table>";
// *******************************

if(empty($id)){$display="none";}else{$display="block";}
echo "<table border='1' align='left' cellpadding='5'>";
echo "<tr><td colspan='2' bgcolor='aliceblue'>
<a onclick=\"toggleDisplay('cert');\" href=\"javascript:void('')\">Employee Certification</a>
       </td></tr></td></tr>";
echo "<tr><td colspan='2'>";
echo "<div id=\"cert\" style=\"display: $display\">";
echo "I understand:<br />
•	The policy governing secondary employment.   My secondary employment will not have any impact on and will not create any possibility of conflict with my primary employment.<br />
•	That failure to provide accurate information regarding my secondary employment approval request or to follow all policies regarding secondary employment may be considered unacceptable personal conduct which could subject me to discipline up to and including dismissal.<br />
•	That secondary employment information is public and may be disclosed to third parties.</div>
</td>";
echo "</table></form>";
// *****************
echo "<table border='1' align='left' cellpadding='5'>";
echo "<tr><td colspan='2' bgcolor='aliceblue'>Employee Signature</td></tr>";
echo "<tr><td colspan='2'>After completeing the form, <b>print this form, sign, date, and upload.</b>
</td>";
echo "</table></form>";

?>