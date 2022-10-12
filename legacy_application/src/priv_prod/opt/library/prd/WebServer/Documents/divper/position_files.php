<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users

$level=$_SESSION['divper']['level'];
$test=$_SESSION['logname'];
$emp_beacon_num=$_SESSION['beacon_num'];
$accessPark=@$_SESSION['divper']['accessPark'];
if(empty($accessPark))
	{
	$this_park=$_SESSION['parkS'];
	}
	else
	{
	$exp=explode(",",$accessPark);
	$this_park=$exp[0];
	}
$position_title=@$_SESSION['position'];

//echo "<pre>"; print_r($_SESSION); echo "</pre>";
//echo "<pre>"; print_r($_POST); echo "</pre>";

include("menu.php"); 

include("../../include/iConnect.inc");
include("../../include/get_parkcodes_reg.php");

mysqli_select_db($connection,'divper'); // database

// extract($_REQUEST);

// Check for access
$sql="SELECT beacon_num
	FROM position_desc_access as t1
	WHERE t1.no_access!='x'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$allowed_access[]=$row['beacon_num'];
		}
		
if(!in_array($emp_beacon_num,$allowed_access) AND $level<2)
	{
	unset($allowed_access);
	$where="WHERE t1.park='$this_park'";
	if(!empty($accessPark))
		{
		foreach($exp as $k=>$v)   // $exp line 15
			{
			$temp[]="t1.park='".$v."'";
			}
		$where=" where ".implode(" or ",$temp);
		}
	$sql="SELECT beacon_num
	FROM position as t1
	$where"; // echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$allowed_access[]=$row['beacon_num'];
		}
	//	echo "<pre>"; print_r($allowed_access); echo "</pre>"; // exit;
	if(!in_array($beacon_num,$allowed_access))
		{
		echo "You do not have access. Contact Tom Howard if you need access.";
		exit;
		}
	}

// Check for supervisor
$sql="SELECT t2.beacon_num, concat( t3.Lname, ', ' ,t3.Fname) as supervisor, t4.beacon_title
	FROM divper.`supervisor_table` as t1
	LEFT JOIN divper.emplist as t2 on t1.supervisor=t2.beacon_num
	LEFT JOIN divper.empinfo as t3 on t3.tempID=t2.tempID
	LEFT JOIN divper.position as t4 on t4.beacon_num=t1.supervisor
	WHERE t1.supervisee='$beacon_num'"; 
// 	echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_assoc($result);
	$super1=$row['supervisor'];
	$super2=$row['beacon_title'];
	$super3=$row['beacon_num'];
	
// Add/Update supervisor
if(@$submit=="Submit")
	{
	$sql="SELECT t1.beacon_num, concat( t3.Lname, ', ' ,t3.Fname) as supervisor, t1.beacon_title
	FROM divper.`position` as t1
	LEFT JOIN divper.emplist as t2 on t1.beacon_num=t2.beacon_num
	LEFT JOIN divper.empinfo as t3 on t3.tempID=t2.tempID
	WHERE t1.beacon_num='$supervisor'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)>0)
		{
		$row0=mysqli_fetch_assoc($result);
		$super1=$row0['supervisor'];
		$super2=$row0['beacon_title'];
		$super3=$row0['beacon_num'];
		$sql="REPLACE supervisor_table set supervisee='$beacon_num', supervisor='$super3'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		}
	}

$ckPosition=strtolower($_SESSION['position']);

$sql="SELECT t1.* , concat(t3.Fname, ' ', if(Nname!='', concat('[',Nname,']'),''), ' ', t3.Lname) as name, concat(t4.add1, ' ',if(t4.add2!='', t4.add2, ''), ', ', t4.city, ', ', t4.county) as address
FROM divper.`position` as t1
LEFT JOIN divper.emplist as t2 on t1.beacon_num=t2.beacon_num
LEFT JOIN divper.empinfo as t3 on t3.tempID=t2.tempID
LEFT JOIN dpr_system.dprunit as t4 on t4.parkcode=t1.code
where t1.beacon_num='$beacon_num'"; 
// echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_assoc($result);

//Update supervisors table for any blank fields
// Record MUST contain the beacon_num
$sql="UPDATE supervisors as t1
LEFT JOIN position as t2 on t1.beacon_num=t2.beacon_num
LEFT JOIN emplist as t3 on t2.beacon_num=t3.beacon_num
LEFT JOIN empinfo as t4 on t3.tempID=t4.tempID
set t1.beacon_title=t2.beacon_title, t1.d=t2.working_title, t1.name=UPPER(concat( t4.Lname, ', ' ,t4.Fname))
where t1.beacon_num=t2.beacon_num and t1.name=''";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	
	$sql="SELECT t1.beacon_num, concat( t3.Lname, ', ' ,t3.Fname) as supervisor, t1.beacon_title
	FROM divper.`supervisors` as t1
	LEFT JOIN divper.emplist as t2 on t1.beacon_num=t2.beacon_num
	LEFT JOIN divper.empinfo as t3 on t3.tempID=t2.tempID
	WHERE 1
	order by t3.Lname"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while($row1=mysqli_fetch_assoc($result))
		{
		if($row1['supervisor']==""){continue;}
		if($row1['beacon_title']==""){continue;}
		$super_info[$row1['beacon_num']]=$row1['supervisor']."-".$row1['beacon_title'];
		}
//		$super_info[60033165]="Ledford, Lewis - Parks & Recreation Division Director";
//		$super_info[60033063]="Allen, Nancy - Food Service Supervisor IV";
//	print_r($super_info); echo "$sql";

//unset($super_info[60032866]);  // Ed Farr
//unset($super_info[60032840]);  // Jack Bradley
asort($super_info);
$name=$row['name'];
$parkcode=$row['code'];
@$park_name=$parkCodeName[$parkcode];
echo "<form action='position_files.php' method='POST'>";
echo "<table><tr><th colspan='2'>Information for the OSP Position Description Form</th></tr>";
echo "<tr><td>Name of Employee:</td><td>$name</td></tr>";
echo "<tr><td>BEACON Position Number:</td><td>$row[beacon_num]</td></tr>";
echo "<tr><td>Salary Grade or Banded Level:</td><td>$row[salary_grade]</td></tr>";
echo "<tr><td>Working Title:</td><td>$row[working_title]</td></tr>";
echo "<tr><td>BEACON Title:</td><td>$row[beacon_title]</td></tr>";
echo "<tr><td>Department:</td><td>DNCR</td></tr>";
echo "<tr><td>Division:</td><td>Div. of Parks & Rec.</td></tr>";
echo "<tr><td>Section / Unit:</td><td>$row[section] / $parkcode</td></tr>";
echo "<tr><td>Street Address, City and County:</td><td>$row[address]</td></tr>";
echo "<tr><td>Location of Workplace:</td><td>$park_name</td></tr>";

echo "<tr><td>Immediate Supervisor: <font color='blue'>$super1</font></td><td><select name='supervisor'><option selected=''></option>";
foreach($super_info as $k=>$v)
	{
	if($super3==$k){$s="selected";}else{$s="";}
	echo "<option value='$k' $s>$v</option>";
	}
if(!isset($super2)){$super2="";}
if(!isset($super3)){$super3="";}
echo "</select></td></tr>";
echo "<tr><td>Supervisor's Position Title and Number:</td><td>$super2 $super3</td>
<td>
<input type='hidden' name='beacon_num' value='$beacon_num'>
<input type='submit' name='submit' value='Submit'>
</td></tr>";
echo "<tr><td>Work Hours:</td><td></td></tr>";

echo "</table></form><hr />";

echo "</div>";

if($super3=="")
	{
	echo "Please select your supervisor from the drop-down menu. If your supervisor is NOT listed, contact Tom Howard.";
	exit;}

$bn=$row['beacon_num'];
$wt=$row['working_title'];
$bt=$row['beacon_title'];
$sg=$row['salary_grade'];

// Get the Position Desc Template form
$sql="SELECT form_name, file_link from position_desc_forms
where form_name='".$bt." ".$sg."'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$count=mysqli_num_rows($result);

if($count<1)
	{
	echo "The template for $bt $sg has NOT been uploaded to the database. Contact Tom Howard.";
	echo "<br />$sql";
	exit;
	}
$row=mysqli_fetch_assoc($result);

// Get any Completed form for a beacon_num
$sql="SELECT form_name, file_link from position_desc_complete
where beacon_num='$bn'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$count1=mysqli_num_rows($result);
$row1=mysqli_fetch_assoc($result);

// Get any Completed Description PDF for a beacon_num
$sql="SELECT form_name, file_link from position_desc_pdf
where beacon_num='$bn'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$count2=mysqli_num_rows($result);
$row2=mysqli_fetch_assoc($result);

// Get any Completed Cover Sheet PDF for a beacon_num
$sql="SELECT form_name, file_link from position_cover_pdf
where beacon_num='$bn'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$count3=mysqli_num_rows($result);
$row3=mysqli_fetch_assoc($result);


// Get the Position ADA Template form
$sql="SELECT file_link from position_ada_forms where 1";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$row_ada=mysqli_fetch_assoc($result);
$ada_blank_form=$row_ada['file_link'];


// Get any Completed ADA Word for a beacon_num
$sql="SELECT form_name, file_link from position_ada_word
where beacon_num='$bn'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$count7=mysqli_num_rows($result);
$row7=mysqli_fetch_assoc($result);

// Get any Completed ADA PDF for a beacon_num
$sql="SELECT form_name, file_link from position_ada_pdf
where beacon_num='$bn'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$count8=mysqli_num_rows($result);
$row8=mysqli_fetch_assoc($result);

// Get any Classification / Compensation for a beacon_num
$sql="SELECT form_name, file_link from position_class_comp_pdf
where beacon_num='$bn'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$count9=mysqli_num_rows($result);
$row9=mysqli_fetch_assoc($result);

// Instructions for Job Descriptions
echo "<table>";
	echo "<tr><td><h3><font color='red'>BE SURE TO READ THESE.</font> Click for <a href='/divper/position_desc_files/Job_Description_Guidelines_for_Writing_JD.pdf' target='_blank'>Guidelines</a>. (Guidelines for completing Job Descriptions.)</h3></td></tr>";
echo "</table>";


// Instructions for Steps 1 - 3
echo "<table>";
	echo "<tr><td><h3>Click for <a href='/divper/position_desc_files/PD-102_or_PD2010_instructions.pdf' target='_blank'>Instructions</a> for Steps 1 to 3 </h3></td></tr>";
echo "</table>";

// Word Template  from position_desc_forms
echo "<table>";
	echo "<tr><td><h3>Step 1</h3></td><td colspan='2'><font color='green'>Position Description Template (base Word form)</font><br />Use the info shown at the top of this page to complete the top section of the form.</td></tr>";
	
	echo "<tr><td></td><td>$row[form_name]</td><td>Download the template ==> <a href='$row[file_link]'>here</a></td></tr>";
echo "</table>";


// Word Completed Position Description from position_desc_complete
echo "<hr /><table>";
	echo "<form method='post' action='position_desc_complete_upload.php' enctype='multipart/form-data'><tr><td><h3>Step 2</h3></td>
		<td valign='top'><font color='purple'>The Customized Word File (Position Description) for $name - $bt $sg</font></td></tr>
		<tr><td valign='top'></td><td>Click to select your <b>completed Word</b> file, customized for $name, for upload. <br />
		<input type='file' name='file_upload'  size='40'> Then click this button. 
		<input type='hidden' name='beacon_num' value='$bn'>
		<input type='hidden' name='beacon_title' value='$wt'>
		<input type='hidden' name='form_name' value='$row[form_name]'>
		<input type='submit' name='submit' value='Add File'>
		</form></td>";
		if($count1>0)
			{
			$link=$row1['file_link'];
			echo "<td><b>View completed Word</b> <a href='$link'>file</a></td>";
			}
	echo "</tr>";
echo "</table>";


// PDF Completed
echo "<hr /><table>";
	echo "<form method='post' action='position_desc_pdf_upload.php' enctype='multipart/form-data'><tr><td><h3>Step 3</h3>
		<td valign='top'><font color='brown'>Completed AND SIGNED PDF - $bt $sg Position Description for $name</font></td></tr>
		<tr><td></td><td>Click to select your <b>signed PDF</b> file. 
		<input type='file' name='file_upload'  size='40'> Then click this button. 
		<input type='hidden' name='beacon_num' value='$bn'>
		<input type='hidden' name='beacon_title' value='$wt'>
		<input type='hidden' name='form_name' value='$row[form_name]'>
		<input type='submit' name='submit' value='Add File'>
		</form></td>";
		if($count2>0)
			{
			$link=$row2['file_link'];
			echo "<td><b>View completed PDF</b> <a href='$link'>file</a></td>";
			}
	echo "</tr>";
echo "</table><hr /><hr />";

// Instructions for Steps 4 - 5
echo "<table>";
	echo "<tr><td><h3>Click for <a href='/divper/position_desc_files/JOB_DESCRIPTION_COVER_SHEETFINALInstruc.pdf' target='_blank'>Instructions</a> for Steps 4 & 5 </h3></td></tr>";
echo "</table>";

// Cover Sheet Template
echo "<table>";
	echo "<tr><td><h3><font color='magenta'>Step</font> 4</h3></td><td colspan='2' valign='top'><font color='green'>Job Description Cover Sheet Template (Word document)</font></td></tr>";
	
	echo "<tr><td></td><td></td><td>Download the template ==> <a href='/divper/position_desc_cover_doc.php?beacon_num=$bn&super_bn=$super3'>here</a></td></tr>";
echo "</table>";

// PDF Completed
echo "<hr /><table>";
	echo "<form method='post' action='position_desc_cover_upload.php' enctype='multipart/form-data'><tr><td><h3><font color='magenta'>Step</font> 5</h3>
		<td valign='top'><font color='brown'>Completed AND SIGNED Cover Sheet (a PDF)- $bt $sg Job Description Cover Sheet for $name</font></td></tr>
		<tr><td></td><td>Click to select your <b>signed PDF</b> file. 
		<input type='file' name='file_upload'  size='40'> Then click this button. 
		<input type='hidden' name='beacon_num' value='$bn'>
		<input type='hidden' name='beacon_title' value='$wt'>
		<input type='hidden' name='form_name' value='$row[form_name]'>
		<input type='submit' name='submit' value='Add File'>
		</form></td>";
		if($count3>0)
			{
			$link=$row3['file_link'];
			echo "<td><b>View completed PDF</b> <a href='$link'>file</a></td>";
			}
	echo "</tr>";
echo "</table><hr /><hr />";

// Instructions for Steps 6 - 8
echo "<table>";
	echo "<tr><td><h3>Click for <a href='/divper/position_desc_files/ADA_ChecklistInstruction.pdf' target='_blank'>Instructions</a> for Steps 6 - 8 </h3></td></tr>";
echo "</table>";

// ADA Template
echo "<table>";
	echo "<tr><td><h3><font color='cyan'>Step</font> 6</h3></td><td colspan='2' valign='top'><font color='green'>ADA Blank Template (Word document)</font></td></tr>";
	
	echo "<tr><td></td><td></td><td>Download the ADA template ==> <a href='/divper/$ada_blank_form'>here</a></td></tr>";
echo "</table>";


// Word Completed ADA Form
echo "<hr /><table>";
	echo "<form method='post' action='position_ada_complete_upload.php' enctype='multipart/form-data'>
	<tr><td><h3><font color='cyan'>Step</font> 7</h3></td>
		<td valign='top'><font color='purple'>The Customized Word ADA Form for $name - $bt $sg</font></td></tr>
		<tr><td colspan='2'>Click to select your <b>completed ADA Word</b> file, customized for $name, for upload. </td></tr>
		 <tr><td colspan='2'>Then click this button. <input type='file' name='file_upload'  size='10'>
		<input type='hidden' name='beacon_num' value='$bn'>
		<input type='hidden' name='beacon_title' value='$wt'>
		<input type='hidden' name='form_name' value='$row[form_name]'>
		<input type='submit' name='submit' value='Add File'>
		</form></td>";
		if(@$count7>0)
			{
			$link=$row7['file_link'];
			echo "<td><b>View completed Word ADA Form</b> <a href='$link'>file</a></td>";
			}
	echo "</tr>";
echo "</table>";


// PDF Completed ADA
echo "<hr /><table>";
	echo "<form method='post' action='position_ada_pdf_upload.php' enctype='multipart/form-data'><tr><td><h3><font color='cyan'>Step</font> 8</h3>
		<td valign='top'><font color='brown'>Completed AND SIGNED ADA PDF - $bt $sg ADA Form for $name</font></td></tr>
		<tr><td></td><td>Click to select your <b>signed PDF</b> file. 
		<input type='file' name='file_upload'  size='10'> Then click this button. 
		<input type='hidden' name='beacon_num' value='$bn'>
		<input type='hidden' name='beacon_title' value='$wt'>
		<input type='hidden' name='form_name' value='$row[form_name]'>
		<input type='submit' name='submit' value='Add File'>
		</form></td>";
		if(@$count8>0)
			{
			$link=$row8['file_link'];
			echo "<td><b>View completed ADA PDF</b> <a href='$link'>file</a></td>";
			}
	echo "</tr>";
echo "</table>";

// Classification/Compensation Action Request Form
echo "<hr /><table>";
	echo "<form method='post' action='position_class_comp_upload.php' enctype='multipart/form-data'><tr><td colspan='3'>
	<h3><font color='red'>For the Class/Comp form – Only when requesting a reclassification do you complete this form.</font></h3></td></tr>
	<tr><td><h3><font color='cyan'>Step</font> 9</h3></td><td><a href='http://www.dpr.ncparks.gov/find/graphics/2015/Classification_CompensationAction_Request.doc'>blank form</a></td></tr>
	<tr><td colspan='3'><font color='brown'>COMPLETED Classification/Compensation Action Request Form - $bt $sg Classification/Compensation Form for $name</font></td></tr>
		<tr><td></td><td colspan='2'>Click to select your <b>completed PDF</b> file. 
		<input type='file' name='file_upload'  size='10'> Then click this button. 
		<input type='hidden' name='beacon_num' value='$bn'>
		<input type='hidden' name='beacon_title' value='$wt'>
		<input type='hidden' name='form_name' value='$row[form_name]'>
		<input type='submit' name='submit' value='Add File'>
		</form></td>";
		if(@$count9>0)
			{
			$link=$row9['file_link'];
			echo "<td><b>View completed Class/Comp</b> <a href='$link'>file</a></td>";
			}
	echo "</tr>";
echo "</table>";


// Check Out
echo "<hr /><table>";
	echo "<tr><td><h3><font color='red'>Step</font>&nbsp;10</h3>
		<td valign='top'><font color='green'>Final Step-REVIEW - you will have (4) files uploaded to the database for each employee:
</font></td></tr>
		<tr><td></td><td>(2) Job description- one as a <b>word document</b> and one as a <b>pdf file</b> signed by supervisor and employee</td></tr>
		<tr><td></td><td>(1) Cover sheet as a <b>pdf file</b>, indicating change (with justification) or no change, signed by the supervisor</td></tr>
		<tr><td></td><td>(1) ADA Checklist as a <b>pdf file</b>, with the Position Title, BEACON ID and Essential job functions listed and signed by the supervisor.  Keep the original signed paper documents for each employee on file in the Park or District Office and the electronic documents in a Job Description file folder on the computer.</td></tr>
		<tr><td></td><td>(1) <b>If there is a request for a reclassification</b> then there is an additional 5th <b>pdf file</b> for Step 9.</td></tr>
		";
		
	echo "</tr>";
echo "</table>";

?>