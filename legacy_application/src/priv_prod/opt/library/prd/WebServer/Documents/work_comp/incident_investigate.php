<?php
ini_set('display_errors',1);
$database="work_comp";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database); // database
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

$query="SHOW 	COLUMNS from incident_investigate"; //echo "$query";exit;
$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row['Field'];
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

extract($_REQUEST);

$sql="SELECT employee_name from form19 where wc_id='$wc_id'"; //echo "$query";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $query");
$row=mysqli_fetch_assoc($result);
extract($row);
	
$rename1=array("employee_name"=>"Employee's Name","employee_title"=>"Employee Title","employee_num"=>"Employee Number","division"=>"Division","county"=>"County","unit"=>"Branch/Section/Unit","num_emp_injured"=>"Number Employees Injured","num_party_injured"=>"Number Parties Injured","date_of_incident"=>"Date of Incident","date_incident_reported"=>"Date Incident Reported","desc_incident"=>"Description of Incident","root_cause"=>"Root Cause");

$rename2=array("corrective_action"=>"Corrective Action","person_corrective_action"=>"Person Responsible for Corrective Action","accident_conditions"=>"Did Conditions result from accident?", "controlled_substance"=>"Was Post-accident Testing Conducted","team_members"=>"Investigative Team Members","supervisor_sig"=>"Investigating Supervisor Signature","date_of_investigation"=>"Date of Investigation","subcommittee_members"=>"Subcommittee Members","corrective_comments"=>"Has Corrective Action been completed?","subcommittee_chair"=>"Subcommittee Chair Signature","subcommittee_review"=>"Subcommittee Review Date","name_super_safe_officer"=>"Investigating Supervisor/Safety Officer","statistical_data"=>"Statistical Data-Personal Injury");

$rename=array_merge($rename1,$rename2);

$skip=array("wc_id","id","submit");

if(!empty($_POST))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	$yn_array=array("accident_conditions","controlled_substance");
	$clause="set ";
	foreach($ARRAY as $index=>$fld)
		{
		if(in_array($fld,$skip)){continue;}
		if(in_array($fld,$yn_array))
			{
			@$val=$_POST[$fld];
			$clause.="$fld='$val', ";
			continue;
			}
		if(!array_key_exists($fld, $_POST) OR ($_POST[$fld]=="No"))
			{ // track errors
			$error_fld[]=$fld;
			$error[]=$rename[$fld];
			}
			else
			{ // create update clause which will be used if no errors
			$val=$_POST[$fld];
			$clause.="$fld='$val', ";
			}
		}
	$clause=rtrim($clause,", ");
	}
//echo "<pre>"; print_r($error); echo "</pre>"; // exit;
//echo "$clause"; exit;

echo "<!DOCTYPE html>
<html>
<head>";
include("page_js.php");

echo "
<style>
WCform
	{
	position:absolute;
	left:525px;
	top:5px;
	}
WCupload
	{
	position:absolute;
	left:550px;
	top:150px;
	}
instructions
	{
	position:absolute;
	left:10px;
	top:10px;
	width:532px;
	background-color:rgba(200, 200, 200, 1);
	}
page2
	{
	position:absolute;
	left:15px;
	top:90px;
	}
</style>
</head><body>";

if(!empty($_FILES))
	{
	$wc_id=$_POST['wc_id'];
	include("upload_file_incident_investigate.php");
	echo "<p><font size='+1'>You have successfully uploaded the <b>Incident Investigation</b> form.</form></p>";
	if(@$_POST['reupload']=="reupload")
		{
		echo "Return to the WC Review <a href='review_submission.php?wc_id=$wc_id'>Form</a>";
		}
		else
		{
		echo "<p><font size='+1'>We will now work with uploading the <b>Employee's Statement</b> form.</form></p>";
		echo "Go to Step 5 <a href='employee_statement.php?wc_id=$wc_id'>Form</a>";
		}
	exit;
	}

if(!empty($error) OR empty($_POST['submit']))
	{
	if(!empty($error))
		{
		$error_message="<font color='magenta'>Submission halted.</font> You failed to answer items <font color='red'>marked in red</font>.";
		//echo "$error_message"; exit;
		}
	}
	else
	{
	$sql="REPLACE incident_investigate $clause ,wc_id='$wc_id'"; //echo "$sql";
	$result=mysqli_query($connection,$sql);
	$show_incident_investigate_upload=1;
	}


if((empty($show_incident_investigate_upload) and empty($_POST['submit'])) or !empty($error_message))
	{
	echo "<WCform>";
	if(!empty($error_message))
		{echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$error_message<br />";}
	echo "<img src='Initial Claim Report Form for Supervisors.jpg' width='750'>
	
	</WCform>";
	}
	else
	{
	echo "<WCupload><font size='+2'>You have indicated that all required <b>Incident Investigation</b> fields are properly completed.<br /><br />You can now upload the signed form that has been scanned and saved as a PDF.</font><br /><br />
	<form method='POST' action='incident_investigate.php' enctype='multipart/form-data'>
	<input type='hidden' name='wc_id' value='$wc_id'>
	<input type='file' name='files[]'>
	<input type=submit value='Upload File'>
	</form>
	</WCupload>";
	}
$na=array("employee_work_phone");

if(!empty($wc_id))
	{
	$query="SELECT * from incident_investigate where wc_id='$wc_id'"; //echo "$query";exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_1[]=$row;
		}

	//echo "<pre>"; print_r($ARRAY); echo "</pre>";  
	//echo "<pre>"; print_r($ARRAY_1); echo "</pre>";  exit;
	}
	ELSE
	{$ARRAY_1[]=array();}
	
echo "<page2>";
echo "<form action='incident_investigate.php' method='POST'><table cellpadding='3'><tr><td>We are in the process of changing to this form.<br />The questions below do not yet match the form.<br />Be sure to complete all sections of the new form.<br />Scan completed new form and upload.</td><tr>";
foreach($ARRAY AS $index=>$fld)
	{
	if(in_array($fld,$skip))
		{
		continue;
		}
	$fld_name=$fld;
	@$value=$ARRAY_1[0][$fld];
	
	if(array_key_exists($fld,$rename))
		{$fld_name=$rename[$fld];}
	
	if($fld=="employee_name")
		{
		echo "<td bgcolor='beige'><fieldset><legend><b>Employee Section</b></legend><table>";
		}
		
		$cky="checked";
		$ckn="";
		$fc1="";
		$fc2="";
	if($value=="Yes" or $value=="N/A")
		{
		if($value=="Yes")
			{$cky="checked";}
			else
			{$ckn="checked";}
		$fc1="<font color='green'>";
		$fc2="</font>";
		}
	if(@in_array($fld,$error_fld))
		{
		$fc1="<font color='red'>";
		$fc2="</font>";
		$cky="";
		$ckn="";
		}
		
		
	
	$answer_value="Answered";
	$not_answer_value="Not answered";
	if($fld=="accident_conditions")
		{
		if($value=="Yes")
			{
			$cky="checked";
			$ckn="";
			$fc1="<font color='green'>";
			$fc2="</font>";
			}
		if($value=="No")
			{
			$ckn="checked";
			$cky="";
			$fc1="<font color='green'>";
			$fc2="</font>";
			}
		$answer_value="Yes";
		$not_answer_value="No";
		}
	if($fld=="controlled_substance")
		{
		if($value=="Yes")
			{
			$cky="checked";
			$fc1="<font color='green'>";
			$fc2="</font>";
			}
		
		if($value=="No")
			{
			$ckn="checked";
			$cky="";
			$fc1="<font color='green'>";
			$fc2="</font>";
			}
		$answer_value="Yes";
		$not_answer_value="No";
		}
	echo "<tr><td>$fc1$fld_name$fc2</td>
	<td>
	<input type='radio' name='$fld' value='Yes' $cky required>$answer_value&nbsp;&nbsp;
	<input type='radio' name='$fld' value='No' $ckn>$not_answer_value&nbsp;&nbsp;";
	if(in_array($fld,$na))
		{
		echo "<input type='radio' name='$fld' value='N/A' $ckn>N/A";
		}
	echo "</td>
	</tr>";
	
	if($fld=="date_incident_reported")
		{
		echo "</table></fieldset><tr>
		<td bgcolor='white'><fieldset><legend><b>Part I: Incident Investigation</b></legend><table>";
		}
	if($fld=="person_corrective_action")
		{
		echo "</table></fieldset><tr>
		<td bgcolor='beige'><fieldset><legend><b><b>Part II: Post Accident Testing</b></b></legend><table>";
		}
	if($fld=="date_of_investigation")
		{
		echo "</table></fieldset><tr>
		<td bgcolor='white'><fieldset><legend><b>Part III: Status of Corrective Action</b></legend><table>";
		}
	if($fld=="subcommittee_review")
		{
		echo "</table></fieldset><tr>
		<td bgcolor='white'><fieldset><legend><b>Part IV: Statistical Data-Personal Injury/Incident Factors</b></legend><table>";
		}
	}
echo "<tr><td colspan='2' align='center'>";


echo "<input type='hidden' name='wc_id' value='$wc_id'>
<input type='submit' name='submit' value='Click to Validate Responses'>";

echo "</td></tr></table></fieldset></td>

</tr></table>";
echo "</td></tr></table></form></page2>";
	
echo "<instructions><a onclick=\"toggleDisplay('instruction');\" href=\"javascript:void('')\">

You are on Step 4: Incident Investigation - <font color='red'>Click for Instructions</font></a><br />
<h3>Employee Name: $employee_name</h3>
      <div id=\"instruction\" style=\"display: none\">
You must respond to each item listed below to successfully submit your WC claim.  For incomplete response(s), you will be prompted to complete before proceeding.<br />
Instructions:<br />
1.	Complete the paper Incident Investigation form<br />
2.	Respond to each item listed below which is the same information identified and required<br />
3.	Compare your completed form to the items listed to ensure all required fields are provided<br />
4.	Click \"Submit\" button to indicate you have <b>responded to all the items on the list</b><br />
5.	Scan and save your signed paper form as a PDF file<br />
6.	Click \"Browse\" to retrieve your document from the location where you have it saved<br />
7.	Click \"Upload\" to attach your document<br />
8.	Click \"Step 5\"  <br /><br /><br /><br />

Click the \"Instructions\" link to hide them.
         </div> </instructions>";


echo "</body></html>";
?>