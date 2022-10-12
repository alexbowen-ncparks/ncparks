<?php
ini_set('display_errors',1);

echo "<hr /><table align='center' cellpadding='5'>";

	echo "<tr><th colspan='4'>Incident Type and Form(s) Required</td></tr>

	<tr><th>Incident Types                         </th><th>Form(s) Used</th><th>Description</tr>

	<tr bgcolor='#D8F6CE'><td><b>NON-CRIMINAL INCIDENT</b>, park internal, non-vehicle accident, worker's comp (as applicable),<br /> visitor/volunteer accident/injury</td><td>PR-63</td><td>DPR Case Incident Report (CIR)</td><td></tr>

<tr><td></td><td></td><td></tr>

	<tr bgcolor='#CEF6F5'><td><b>CRIMINAL INCIDENT</b>, plus citation or arrest report if necessary</td><td>DCI-600F</td><td>Incident/Investigation Report</td></tr>
	<tr bgcolor='#CEF6F5'><td>      </td><td>DCI-602F</td><td>Continuation Page</td></tr>
	<tr bgcolor='#CEF6F5'><td></td><td>DCI-603F</td><td>Supplementary Investigation</td></tr>
	<tr bgcolor='#CEF6F5'><td></td><td>SBI-122</td><td>Traffic Stop Report</td></tr>

<tr><td></td><td></td><td></tr>

	<tr bgcolor='#F5D0A9'><td><b>ARREST Report</b>, use for all physical arrests and criminal citations,<br />not traffic or park rules, (used for hunting in state parks, possession of firearms)</td><td>DCI-608F</td><td>Arrest Report</tr>
	<tr bgcolor='#F5D0A9'><td></td><td>DCI-610F</td><td>Juvenile Contact Report</td></tr>

<tr><td></td><td></td><td></tr>

	<tr bgcolor='#BCA9F5'><td><b>CITATION</b>, (see note for Arrest Report)</td><td>CR-500</td><td>N.C. Uniform Citation</tr>

<tr><td></td><td></td><td></tr>

	<tr bgcolor='#F3F781'><td><b>VEHICLE Accident</b>, if > $1000 damage, plus ALL state vehicle accidents<br />DMV-349 <a href='https://www.ncdot.gov/dmv/offices-services/records-reports/Documents/dmv-349-crash-instructional-manual.pdf'>DMV-349 Instructional Manual</a></td><td>DMV-349</td><td>N.C. Collision Report Form</tr><tr><td>      </td><td></td><td></tr>
	<tr><td></td><td></td><td></tr>

	";
echo "</table>";

$var_rwt="ARREST REPORTS
	Mandatory 
1.	When a person is physically arrested and brought before a Magistrate.
2.	Possession of a firearm in a state park.
3.	Hunting in a state park.
4.	Public nudity in a state park.  

Note:  All supporting documentation should be added to the PR-63 along with the arrest report.  
            Examples of supporting documentation include but not limited to:  
1.	Citation(s)
2.	Magistrate’s order
3.	Witness statements
4.	Seizure forms  
5.	Photographs
6.	DWI:  Intox. results, SFST field sheets, etc.
7.	Other agencies report when necessary
8.	Lab results when necessary
9.	ETC.	


INCIDENT/INVESTIGATION REPORTS

	Whenever a crime is committed but you have no suspects or proof.  Examples include but not 
	limited to:
1.	Larceny 
2.	Break ins
3.	Vandalism
4.	Assaults
5.	ETC.

Note:  Remember to add supporting documentation as needed to the PR-63.

NOTE: There will be times when you need to submit a report before it is completed.  That is fine but when you are ready to edit/add to the report you will have to contact Chris or Keith so one of us can un-approve the report so changes can be made.  The report will than go back through the approval process again.  
";
echo "<table align='center'><tr><td>
<a onclick=\"toggleDisplay('report_tips');\" href=\"javascript:void('')\"><font color='red' size='+2'>Report Writing Tips</font></a>
<div id=\"report_tips\" style=\"display: block; margin-left: auto;
  margin-right: auto;\">";
echo nl2br($var_rwt);

echo "</div>
</td></tr>
</table>";


if(empty($connection))
	{	
	$database="le";
	include("../../include/iConnect.inc"); // database connection parameters
	}

mysqli_select_db($connection,"find") or die ("Couldn't select database FIND");
$sql="SELECT timeMod from forum where topic like '%BACKGROUND INVESTIGATION PACKET%'";
$result = mysqli_query($connection,$sql);
$row=mysqli_fetch_assoc($result);
$bip_date=$row['timeMod'];

$sql="SELECT timeMod from forum where topic like '%SBI-78 STATE PROPERTY REPORT%'";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
$row=mysqli_fetch_assoc($result);
$sbi_78_date=$row['timeMod'];



mysqli_select_db($connection,"le") or die ("Couldn't select database LE");
	
echo "<hr /><table align='center' cellpadding='5'><tr><th>
Links</th></tr>";

$sql="SELECT * from web_links where 1 order by sort_id";
$result = mysqli_query($connection,$sql) or mysqli_error($connection);
while($row=mysqli_fetch_assoc($result))
	{
	extract($row);
	$display_title=$title;
	if($title=="LE BACKGROUND INVESTIGATION PACKET")
		{
		$display_title.=" - updated on $bip_date";
	echo "<tr><td align='right'></td><td>$display_title</td></tr>";
	
	echo "<tr><td align='right'></td><td>SBI-78 STATE PROPERTY REPORT updated on $sbi_78_date</td></tr>";
		}
	
	echo "<tr><td>$title</td><td><a href='$link' target='_blank'>link</a></td></tr>";
	if($level>3)
		{
// $sort_id
		echo "<tr><td></td>
		<td><input type='text' name=\"title[$id]\" value=\"$title\" size='50'></td>
		<td><input type='text' name=\"link[$id]\" value='$link' size='80'></td>
		</tr>";
// 		echo "<tr><td>$name_title</td></tr>";
		}	
	}

if($level>3)
	{
	echo "<tr><td></td>
	<td>Title: <input type='text' name='new_title' value='' size='30'></td>
	<td>Link: <input type='text' name='new_link' value='' size='80'></td>
	</tr><tr><td></td><td><input type='submit' name='submit' value='Update'></td></tr></form>";
	}		
echo "</table>";
?>