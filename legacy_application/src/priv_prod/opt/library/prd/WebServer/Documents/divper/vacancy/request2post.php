<?php
$database="divper";
include("../../../include/auth.inc"); // used to authenticate users

$test=$_SESSION['logname'];

$committee=array("Howard6319","Mitchener8455","McElhone8290","Oneal1133","Quinn0398","Fullwood1940","Bunn8227","Greenwood3841","Williams5894","Howerton3639","Blue7128","Chandler1195","Carter5486");

if(!in_array($test,$committee)){echo "You do not have access to this file."; exit;}

include("../../../include/iConnect.inc"); 
mysqli_select_db($connection,'divper'); // database


// extract($_REQUEST);

if(@$submit=="Update")
	{
	$sql="UPDATE position set 
	salary_grade='$salary_grade', section='$section', code='$code', beacon_title='$beacon_title'
	where beacon_num='$beacon_num'";   //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	echo "<font color='green'><b>Update completed.</b></font>";
	}
include("../menu.php"); 

if(!isset($beacon_num)){$beacon_num="";}
	echo "<form method='POST'>
	<table><tr><td>BEACON Number
	<input type='text' name='beacon_num' value='$beacon_num'>
	<input type='submit' name='submit' value='Find'>
	</td></tr></table>
	</form>";
if(empty($beacon_num))
	{exit;}


$level=$_SESSION['divper']['level'];
$ckPosition=strtolower($_SESSION['position']);

$sql="SELECT t1.* , concat(t3.Fname, ' ', if(Nname!='', concat('[',Nname,']'),''), ' ', t3.Lname) as name, concat(t4.add1, ' ',if(t4.add2!='', t4.add2, ''), ', ', t4.city, ', ', t4.county) as address, dateVac
FROM divper.`position` as t1
LEFT JOIN divper.emplist as t2 on t1.beacon_num=t2.beacon_num
LEFT JOIN divper.empinfo as t3 on t3.tempID=t2.tempID
LEFT JOIN dpr_system.dprunit as t4 on t4.parkcode=t1.code
LEFT JOIN divper.vacant as t5 on t1.beacon_num=t5.beacon_num
where t1.beacon_num='$beacon_num'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_assoc($result);

$sql="SELECT t1.hireMan, concat(t2.Fname,' ',t2.Lname) as sup_title, t4.working_title, t5.file_link
FROM divper.`vacant` as t1
LEFT JOIN divper.empinfo as t2 on t1.hireMan=t2.email
LEFT JOIN divper.emplist as t3 on t3.tempID=t2.tempID
LEFT JOIN divper.position as t4 on t3.beacon_num=t4.beacon_num
LEFT JOIN divper.position_desc_complete as t5 on t1.beacon_num=t5.beacon_num
where t1.beacon_num='$beacon_num'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$super_info=mysqli_fetch_assoc($result);
//echo "<pre>"; print_r($super_info); echo "</pre>"; // exit;

$sql="SELECT *
FROM divper.`request_to_post` as t1
where t1.beacon_num='$beacon_num'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$request_data=mysqli_fetch_assoc($result);
//echo "<pre>"; print_r($super_info); echo "</pre>"; // exit;


//$edit=array("salary_grade","section","code","beacon_title");
$edit=array();
$skip=array("seid","posTitle","current_salary","previous_salary","o_chart","posNum","toggle","markDel","posType");

if(empty($row)){echo "No position was found for BEACON Number $beacon_num";exit;}

echo "<table border='1' cellpadding='5'><tr>";
foreach($row as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	if($fld=="exempt" OR $fld=="working_title")
		{echo "</tr><tr>";}
	echo "<td><b>$fld</b><br />";
	
	if($fld=="name" AND $value==""){$value="vacant";}
	if(in_array($fld,$edit))
		{
		echo "<input type='text' name='$fld' value='$value'>";
		}
		else
		{
		echo "$value";
		}
	echo "</td>";
	}
echo "</tr>";

echo "</table>";

date_default_timezone_set('America/New_York');
$today=date("Y-m-d");
echo "<form action='request2post_update.php' method='POST' enctype='multipart/form-data'>";
echo "<table border='1' cellpadding='5'><tr><th colspan='2'>Information to be completed on the Request to Post Vacancy Announcement and Job Analysis Form</th></tr>";

if(empty($request_data['division_hrm']))
	{$division_hrm="Kimberly Whitaker";}
	else
	{$division_hrm=$request_data['division_hrm'];}
echo "<tr><td>TO: Division HR Manager</td><td><input type='text' name='division_hrm' value='$division_hrm'></td></tr>";

echo "<tr><td>Today's Date:</td><td>$today</td></tr>";
echo "<tr><td>BEACON Position Number:</td><td>$row[beacon_num]</td></tr>";
echo "<tr><td>Classification Title:</td><td>$row[beacon_title]</td></tr>";
echo "<tr><td>Working Title:</td><td>$row[working_title]</td></tr>";

echo "<tr><td>Date Vacant:</td><td>$row[dateVac]</td></tr>";
echo "<tr><td>Immediate Supervisor & Title:</td>
<td>$super_info[sup_title] - $super_info[working_title] - <a href='mailto:$super_info[hireMan]?subject=Request to Post for position $beacon_num $row[beacon_title] at $row[park]'>$super_info[hireMan]</a></td></tr>";

if(!isset($request_data['request_by']))
	{$request_by="";}
	else
	{$request_by=$request_data['request_by'];}
	
echo "<tr><td>Requested by: (database username - last name+4 digits)</td><td><input type='text' name='request_by' value='$request_by' size='70'></td></tr>";


if(!isset($request_data['approve_by']))
	{$approve_by="";}
	else
	{$approve_by=$request_data['approve_by'];}
echo "<tr><td>Approved by: (database username - last name+4 digits)</td><td><input type='text' name='approve_by' value='$approve_by' size='70'></td></tr>";

echo "<tr><td>Date of Approved Position Description</td><td>12/2011</td></tr>";

$ckn="";$cky="";
	if($request_data['accurate']=="n"){$ckn="checked";}
	if($request_data['accurate']=="y"){$cky="checked";}

echo "<tr><td valign='top'>Are the responsibilities and duties accurate and current?</td>
<td>
<input type='radio' name='accurate' value='n' $ckn>No
<input type='radio' name='accurate' value='y' $cky>Yes
<br />If \"No\", update with a new position description or addendum.</td></tr>";

$ckn="";$cky="";
	if($request_data['addendum_ck']=="n"){$ckn="checked";}
	if($request_data['addendum_ck']=="y"){$cky="checked";}

if(!empty($request_data['addendum_file']))
	{$file_link_addendum="<a href='$request_data[addendum_file]'>Link</a>";}
	else
	{$file_link_addendum="";}
echo "<tr><td valign='top'>Addendum or new job description attached:</td>
<td>
<input type='radio' name='addendum_ck' value='n' $ckn>No
<input type='radio' name='addendum_ck' value='y' $cky>Yes
<input type='file' name='file_upload[addendum]'>
$file_link_addendum to an Uploaded Addendum
</td></tr>";

if(!isset($request_data['add_begin']))
	{$add_begin="";}
	else
	{$add_begin=$request_data['add_begin'];}
if(!isset($request_data['add_end']))
	{$add_end="";}
	else
	{$add_end=$request_data['add_end'];}
echo "<tr><td valign='top'>Dates to be advertised:</td>
<td>
Beginning: <input type='text' name='add_begin' value='$add_begin'>
Ending:<input type='text' name='add_end' value='$add_end'></td></tr>";

$ck1="";$ck2="";$ck3="";
	if($request_data['extent']=="denr"){$ck1="checked";}
	if($request_data['extent']=="state"){$ck2="checked";}
	if($request_data['extent']=="external"){$ck3="checked";}
echo "<tr><td valign='top'>Select appropriate extent:</td>
<td>
<input type='radio' name='extent' value='denr' $ck1>Internal DENR (minimum 5 days)
<input type='radio' name='extent' value='state' $ck2>Internal State Gov't (minimum 7 days)
<input type='radio' name='extent' value='external' $ck3>External (minimum 7 days)
</td></tr>";

$ck1="";$ck2="";$ck3="";
	if($request_data['posting']=="a"){$ck1="checked";}
	if($request_data['posting']=="b"){$ck2="checked";}
	if($request_data['posting']=="c"){$ck3="checked";}
echo "<tr><td valign='top'>Select Posting option:</td>
<td>
<input type='radio' name='posting' value='a' $ck1>Option A - Post One Level<br />
<input type='radio' name='posting' value='b' $ck2>Option B - Post One Level with Flexibility in Salary Range<br />
<input type='radio' name='posting' value='c' $ck3>Option C - Flexibile to Post to all or Portion of Range
</td></tr>";

$ck1="";$ck2="";$ck3="";$ck4="";
	if($request_data['le']=="n"){$ck1="checked";}
	if($request_data['le']=="y"){$ck2="checked";}
	if($request_data['main']=="n"){$ck3="checked";}
	if($request_data['main']=="y"){$ck4="checked";}
echo "<tr><td valign='top'>Qualifications</td>
<td>
	<table border='1'>
	<tr>
	<td align='right'>Law Enforcement:
	<input type='radio' name='le' value='n' $ck1>No
	<input type='radio' name='le' value='y' $ck2>Yes
	</td>
	<td align='right'>Maintenance or other:
	<input type='radio' name='main' value='n' $ck3>No
	<input type='radio' name='main' value='y' $ck4>Yes
	</td>
	</tr>";

$ck1="";$ck2="";$ck3="";$ck4="";
	if($request_data['housing']=="n"){$ck1="checked";}
	if($request_data['housing']=="y"){$ck2="checked";}
	if($request_data['cdl']=="n"){$ck3="checked";}
	if($request_data['cdl']=="y"){$ck4="checked";}
	echo "<tr>
	<td align='right'>Housing Required:
	<input type='radio' name='housing' value='n' $ck1>No
	<input type='radio' name='housing' value='y' $ck2>Yes
	</td>
	<td align='right'>CDL:
	<input type='radio' name='cdl' value='n' $ck3>No
	<input type='radio' name='cdl' value='y' $ck4>Yes
	</td>
	</tr>";

$ck1="";$ck2="";$ck3="";$ck4="";
	if($request_data['leo']=="n"){$ck1="checked";}
	if($request_data['leo']=="y"){$ck2="checked";}
	if($request_data['well']=="n"){$ck3="checked";}
	if($request_data['well']=="y"){$ck4="checked";}
	echo "<tr>
	<td align='right'>LEO Certificaiton:
	<input type='radio' name='leo' value='n' $ck1>No
	<input type='radio' name='leo' value='y' $ck2>Yes
	</td>
	<td align='right'>C-Well:
	<input type='radio' name='well' value='n' $ck3>No
	<input type='radio' name='well' value='y' $ck4>Yes
	</td>
	</tr>";

$ck1="";$ck2="";$ck3="";$ck4="";
	if($request_data['waste']=="n"){$ck1="checked";}
	if($request_data['waste']=="y"){$ck2="checked";}
	if($request_data['pest']=="n"){$ck3="checked";}
	if($request_data['pest']=="y"){$ck4="checked";}
	echo "<tr>
	<td align='right'>Waste Operator:
	<input type='radio' name='waste' value='n' $ck1>No
	<input type='radio' name='waste' value='y' $ck2>Yes
	</td>
	<td align='right'>Pesticide:
	<input type='radio' name='pest' value='n' $ck3>No
	<input type='radio' name='pest' value='y' $ck4>Yes
	</td></table>
	</tr>
</td></tr>";

$desc_of_work=$request_data['desc_of_work'];
echo "<tr><td valign='top'>
Description of Work:<br />Link for 
<a href='http://www.dpr.ncparks.gov/divper/$super_info[file_link]'>Position Description</a>
</td><td>
<textarea name='desc_of_work' cols='80' rows='25'>$desc_of_work</textarea>
</td></tr>";

$ksa=$request_data['ksa'];
echo "<tr><td valign='top'>
Selective Criteria - in addition to the classification minimum training and experience requirements, what education, background, skills, and abilities are you looking for?:<br />
Knowledge, Skills, and Abilites<br />
Link for 
<a href='http://www.dpr.ncparks.gov/divper/$super_info[file_link]'>Position Description</a>
</td><td>
<textarea name='ksa' cols='80' rows='25'>$ksa</textarea><br />
Note: qualified applicants must possess minimum training and experience and KSAs.
</td></tr>";

$ck1="checked";$ck2="";
	if($request_data['trainee']=="n"){$ck1="checked";}
	if($request_data['trainee']=="y"){$ck2="checked";}
echo "<tr><td valign='top'>If this classification or position has been historically difficult to recruit and retain, do you wish to post requirements for a trainee appointment?</td>
<td>
<input type='radio' name='trainee' value='n' $ck1>No
<input type='radio' name='trainee' value='y' $ck2>Yes</td></tr>";

$ck1="checked";$ck2="";
	if($request_data['skills_ck']=="n"){$ck1="checked";}
	if($request_data['skills_ck']=="y"){$ck2="checked";}

if(!empty($request_data['skills_file']))
	{$file_link_skills="<a href='$request_data[skills_file]'>Link</a>";}
	else
	{$file_link_skills="";}
echo "<tr><td valign='top'>Interview Questions (see below)</td>
<td>Skills Assessment
<input type='radio' name='skills_ck' value='n' $ck1>No
<input type='radio' name='skills_ck' value='y' $ck2>Yes (If yes, attach.)
<input type='file' name='file_upload[skills]'><br />
$file_link_skills to an Uploaded Skills
</td></tr>";

if($request_data['interviewer']=="")
	{$interviewer="";}
	else
	{$interviewer=$request_data['interviewer'];}
echo "<tr><td valign='top'>Person(s) conducting interviews:</td>
<td><textarea name='interviewer' cols='80' rows='1'>$interviewer</textarea></td></tr></table>";

include("questions.php");

echo "<table align='center'><tr><td>
<input type='hidden' name='date_' value='$today'>
<input type='hidden' name='beacon_num' value='$beacon_num'>
<input type='submit' name='submit' value='Update'>
</td></tr>";

echo "</table></form>";
?>