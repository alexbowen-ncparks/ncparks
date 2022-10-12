<?php
ini_set('display_errors',1);
$database="work_comp";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database); // database
//echo "<pre>"; print_r($_POST); echo "</pre>"; exit;

$query="SHOW 	COLUMNS from tick_log"; //echo "$query";exit;
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
	
$rename1=array("month_ending"=>"Does this form cover the correct time period?","employee_name"=>"Employee's Name is on this form.");

$rename=$rename1;

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
	top:-5px;
	}
WCupload
	{
	position:absolute;
	left:510px;
	top:150px;
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
	left:8px;
	top:110px;
	}
</style>
</head><body>";

if(!empty($_FILES))
	{
	$wc_id=$_POST['wc_id'];
	include("upload_tick_form.php");
	echo "<p><font size='+1'>You have successfully uploaded the <b>Tick Log </b>form.</font></p>";
	if(@$_POST['reupload']=="reupload")
		{
		echo "Return to the Tick Log <a href='review_submission.php?wc_id=$wc_id'>Form</a>";
		}
		else
		{
		echo "<p><font size='+1'>You have now completed all the forms.</font></p>";
		echo "Click <a href='review_submission.php?wc_id=$wc_id'>here</a> to review the submission.";
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
	$sql="REPLACE refuse_treatment $clause ,wc_id='$wc_id'"; //echo "$sql"; exit;
	$result=mysqli_query($connection,$sql);
	$show_wc_authorizaiton_upload=1;
	}


if(empty($show_wc_authorizaiton_upload) and empty($_POST['submit']))
	{
	echo "<WCform>";
	if(!empty($error_message))
		{echo "$error_message<br />";}
	echo "<img src='tick_log.jpg' width='800'>
	</WCform>";
	}
	else
	{
	if(!empty($error_message))
		{echo "<WCupload>$error_message <img src='tick_log.jpg' width='800'></WCupload>";}
		else
		{
		echo "<WCupload><font size='+2'>You have indicated that all required <b>Tick Form</b> fields are properly completed.<br /><br />
		You can now upload the form that has been scanned and saved as a PDF.</font><br /><br />
		<form method='POST' action='tick_related.php' enctype='multipart/form-data'>
		<input type='hidden' name='wc_id' value='$wc_id'>
		<input type='file' name='files[]'>
		<input type=submit value='Upload File'>
		</form>
		</WCupload>";
		}
	}
$na=array("employee_work_phone");

echo "<page2>";
echo "<form action='tick_related.php' method='POST'><table cellpadding='3'><tr>";
foreach($ARRAY AS $index=>$fld)
	{
	if(in_array($fld,$skip))
		{
		continue;
		}
	$fld_name=$fld;
	if(array_key_exists($fld,$rename))
		{$fld_name=$rename[$fld];}
	
	if($fld=="form_date")
		{
		echo "<td bgcolor='beige'><fieldset><legend><b>Refusal of Treatment</b></legend><table>";
		}
		
	if(@$_POST[$fld]=="Yes" or @$_POST[$fld]=="N/A")
		{
		if($_POST[$fld]=="Yes")
			{$cky="checked";}
			else
			{$ckn="checked";}
		$fc1="<font color='green'>";
		$fc2="</font>";
		}
		else
		{
		$cky="";
		$ckn="";
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
	//	$ckn="";
	echo "<tr><td>$fc1$fld_name$fc2</td>
	<td>
	<input type='radio' name='$fld' value='Yes' $cky required>Yes&nbsp;&nbsp;
	<input type='radio' name='$fld' value='No'>No&nbsp;&nbsp;";
	if(in_array($fld,$na))
		{echo "<input type='radio' name='$fld' value='N/A' $ckn>N/A";}
	echo "</td>
	</tr>";
	
	}
echo "<tr><td colspan='2' align='center'>";


echo "<input type='hidden' name='wc_id' value='$wc_id'>
<input type='submit' name='submit' value='Click to Validate Responses'>";

echo "</td></tr></table></fieldset></td>

</tr></table>";
echo "</td></tr></table></form></page2>";

echo "<instructions><a onclick=\"toggleDisplay('instruction');\" href=\"javascript:void('')\">

You are on Step 8: WC Tick Log - <font color='red'>Click for Instructions</font></a><br />
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
7.	Click \"Upload\" to attach your document<br /><br /><br />


Click the \"Instructions\" link to hide them.
         </div> </instructions>";
echo "</body></html>";
?>