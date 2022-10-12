<?php
// new witness_investigate.php
ini_set('display_errors',1);
$database="work_comp";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database); // database
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

$query="SHOW 	COLUMNS from witness_statement"; //echo "$query";exit;
$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row['Field'];
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

extract($_REQUEST);

$sql="SELECT employee_name from form19 where wc_id='$wc_id'"; //echo "$query";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $query");
$row=mysqli_fetch_assoc($result);
extract($row);
	
$rename1=array("employee_name"=>"Employee's Name","employee_title"=>"Employee Title","division"=>"Division","county"=>"County","department_num"=>"Department #","supervisor_name"=>"Supervisor's Name","date_of_incident"=>"Date of Incident","date_incident_reported"=>"Date Incident Reported","description"=>"Description of Incident","witnesses"=>"Incident Witnesses","prevention"=>"How incident could have<br />been prevented");

$rename2=array("employee_sig"=>"Employee's Signature","print_witness"=>"Print Witness Name","employee_date"=>"Date Employee Signed","witness_sig"=>"Witness Signature","witness_address"=>"Witness Work Address","witness_date"=>"Date Witness Signed","witness_phone"=>"Witness Work Phone Number");

$rename3=array("could_anyone_assist"=>"Could anyone assist?","people_in_area"=>"Names of people<br />in immediate area","request_assistance"=>"Did you request<br />backing assistance?" ,"assistance_not_requested"=>"Explain if \"No\" given<br />for question 3." ,"driver_sig"=>"Driver's Signature","witness_list"=>"Incident Witness List","type_of_investigation"=>"Type of Investigation","name"=>"Name","title"=>"Title", "date_of_statment"=>"Date of Statment","witness_title"=>"Witness Title","witness_name"=>"Witness Name","pictures_of_incident"=>"Pictures of Incident","location_of_incident"=>"Location of Incident","time_of_incident"=>"Time of Incident");


$rename=array_merge($rename1,$rename2,$rename3);

$skip=array("wc_id","id","submit");

if(!empty($_POST))
	{
	$clause="set ";
	foreach($ARRAY as $index=>$fld)
		{
		if(in_array($fld,$skip)){continue;}
		if(!array_key_exists($fld, $_POST) OR $_POST[$fld]=="No")
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

echo "<!DOCTYPE html>
<html>
<head>";
include("page_js.php");

echo "
<style>
WCform
	{
	position:absolute;
	left:470px;
	top:5px;
	}
WCupload
	{
	position:absolute;
	left:510px;
	top:150px;
	width:590px;
	}
instructions
	{
	position:absolute;
	left:10px;
	top:10px;
	width:475px;
	background-color:rgba(200, 200, 200, 1);
	}
page2
	{
	position:absolute;
	left:15px;
	top:100px;
	}
</style>
</head><body>";

if(!empty($_FILES))
	{
	$wc_id=$_POST['wc_id'];
	include("upload_file_witness_statement.php");
	echo "<p><font size='+1'>You have successfully uploaded the <b>Witness Statement</b> form.</form></p>";
	if(@$_POST['reupload']=="reupload")
		{
		echo "Return to the WC Review <a href='review_submission.php?wc_id=$wc_id'>Form</a>";
		}
		else
		{
		echo "<p><font size='+1'>We will now work with uploading the <b>Employee Statement </b>form.</form></p>";
		echo "Go to Step 6 <a href='employee_statement_6.php?wc_id=$wc_id'>Form</a>";
		}
	exit;
	}

if(!empty($error) OR empty($_POST['submit']))
	{
	if(!empty($error))
		{
		$error_message="<font color='magenta'>Submission halted.</font> You failed to answer items <font color='red'>marked in red</font>.";
		}
	}
	else
	{
	$sql="REPLACE witness_statement $clause ,wc_id='$wc_id'"; //echo "$sql";
	$result=mysqli_query($connection,$sql);
	$show_witness_statement_upload=1;
	}


if(empty($show_witness_statement_upload) and empty($_POST['submit']))
	{
	echo "<WCform>";
	if(!empty($error_message))
		{echo "$error_message<br />";}
	echo "<img src='forms_marked_up/step_5.jpg' width='800'>
	<img src='employee_statement_2.jpg' width='800'>
	</WCform>";
	}
	else
	{
	echo "<WCupload><font size='+2'>You have indicated that all required <b>Witness Statement</b> fields are properly completed.<br /><br />You can now upload the signed form that has been scanned and saved as a PDF.</font><br /><br />
	<form method='POST' action='witness_statement_5.php' enctype='multipart/form-data'>
	<input type='hidden' name='wc_id' value='$wc_id'>
	<input type='file' name='files[]'>
	<input type=submit value='Upload File'>
	</form>
	</WCupload>";
	}
$na=array("employee_address","home_phone","assistance_not_requested");

echo "<page2>";
echo "<form action='witness_statement_5.php' method='POST'><table cellpadding='3'><tr>";
foreach($ARRAY AS $index=>$fld)
	{
	if(in_array($fld,$skip))
		{
		continue;
		}
	$fld_name=$fld;
	if(array_key_exists($fld,$rename))
		{$fld_name=$rename[$fld];}
	
	if($fld=="employee_name")
		{
		echo "<td bgcolor='beige'><fieldset><legend><b>Statement Section</b></legend><table>";
		}
	
	$cky="";
	$ckn="";
	$ckna="";	
	if(@$_POST[$fld]=="Yes" or @$_POST[$fld]=="N/A")
		{
		if($_POST[$fld]=="Yes")
			{
			$cky="checked";
			}
			else
			{
			$ckn="checked";
			
			if($_POST[$fld]=="N/A")
				{$ckna="checked"; $ckn="";}
			}
		$fc1="<font color='green'>";
		$fc2="</font>";
		}
		else
		{
		if(@in_array($fld,$error_fld))
			{
			$fc1="<font color='red'>";
			$fc2="</font>";
			}
			else
			{
			$fc1="";
			$fc2="";
			}
		}
		$cky="checked";
		$ckn="";
	echo "<tr><td>$fc1$fld_name$fc2</td>
	<td>
	<input type='radio' name='$fld' value='Yes' $cky required>Answered&nbsp;&nbsp;
	<input type='radio' name='$fld' value='No'>Not answered&nbsp;&nbsp;";
	if(in_array($fld,$na))
		{echo "<input type='radio' name='$fld' value='N/A' $ckna>N/A";}
	echo "</td>
	</tr>";
	
	if($fld=="prevention")
		{
		echo "</table></fieldset><tr>
		<td bgcolor='white'><fieldset><legend><b>Signatures</b></legend><table>";
		}
	if($fld=="home_phone")
		{
		echo "</table></fieldset><tr>
		<td bgcolor='beige'><fieldset><legend><b>Backing Accident Information</b></legend><table>";
		}
	}
echo "<tr><td colspan='2' align='center'>";

	echo "<input type='hidden' name='wc_id' value='$wc_id'>
	<input type='submit' name='submit' value='Click to Validate Responses'>";

echo "</td></tr></table></fieldset></td>

</tr></table>";
echo "</td></tr></table></form></page2>";

echo "<instructions><a onclick=\"toggleDisplay('instruction');\" href=\"javascript:void('')\">

You are on Step 5: Witness Statement - <font color='red'>Click for Instructions</font></a><br />
<h3>Employee Name: $employee_name</h3>
      <div id=\"instruction\" style=\"display: none\">
You must respond to each item listed below to successfully submit your WC claim.  For incomplete response(s), you will be prompted to complete before proceeding.<br />
Instructions:<br />
1.	Complete the paper Employee's Statement form<br />
2.	Respond to each item listed below which is the same information identified and required<br />
3.	Compare your completed form to the items listed to ensure all required fields are provided<br />
4.	Click \"Submit\" button to indicate you have <b>responded to all the items on the list</b><br />
5.	Scan and save your signed paper form as a PDF file<br />
6.	Click \"Browse\" to retrieve your document from the location where you have it saved<br />
7.	Click \"Upload\" to attach your document<br />
8.	Click \"Step 6\"  <br /><br /><br /><br />

Click the \"Instructions\" link to hide them.
         </div> </instructions>";

echo "</body></html>";
?>