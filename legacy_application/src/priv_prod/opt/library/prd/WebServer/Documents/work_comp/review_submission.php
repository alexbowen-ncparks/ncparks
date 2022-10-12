<?php
ini_set('display_errors',1);
include("../../include/get_parkcodes_i.php"); // database connection parameters

$database="work_comp";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters

$database="work_comp";
mysqli_select_db($connection,$database); // database

$message="";
if(!empty($_POST['submit']))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	extract($_POST);
	if(!empty($delete))
		{
		$sql="DELETE FROM employee_statement where wc_id='$wc_id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
		$sql="DELETE FROM form19 where wc_id='$wc_id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
		
		$sql="DELETE FROM incident_investigate where wc_id='$wc_id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
		
		$sql="DELETE FROM leave_options where wc_id='$wc_id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
		
		$sql="DELETE FROM refuse_treatment where wc_id='$wc_id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
		
		$sql="DELETE FROM release_info where wc_id='$wc_id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
		
		$sql="DELETE FROM wc_authorization where wc_id='$wc_id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
		
		echo "Deletion was successful.<br /><br />Return to <a href='welcome.php'>Home Page</a>";
		exit;
		}

	$pc=$park_comments;
	@$hrc=$hr_comments;
	@$hr_rep=$hr_rep_comments;
	if(!empty($wc_approved)){$wc=", wc_approved='$wc_approved'";}else{$wc="";}
	if(!empty($employee_status)){$es=", employee_status='$employee_status'";}else{$es="";}
	if(!empty($type_of_injury)){$ti=", type_of_injury='$type_of_injury'";}else{$ti="";}
	if(!empty($body_part)){$bp=", body_part='$body_part'";}else{$bp="";}
	if(!empty($osha)){$os=", osha='$osha'";}else{$os="";}
	
	$sql="UPDATE form19 set park_comments='$pc', hr_comments='$hrc', hr_rep_comments='$hr_rep' $wc $es $ti $bp $os
	where wc_id='$wc_id'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
	$message="Update was successful.<br />";
	}

//echo "<pre>"; print_r($dist_hr_array); echo "</pre>"; // exit;

extract($_REQUEST);
$where="";
if($level==1)
	{
	$parkList=explode(",",$_SESSION['work_comp']['accessPark']);
	if($parkList[0]!="")
		{
		$where=" and (";
		foreach($parkList as $k=>$v)
			{
			$where.="park_code='$v' OR ";
			}
		$where=rtrim($where," OR ").")";
		}
		else
		{$where=" and park_code='".$_SESSION['work_comp']['select']."'";}
	}
	

$query="SELECT t1.wc_id, t1.park_code, t1.date_of_injury, t1.timestamp, t2.file_link as form_19_link, t8.file_link as refuse_treatment_link, t3.file_link as wc_auth_link, t4.file_link as incident_investigate_link, t10.file_link as witness_statement_link, t5.file_link as emp_statement_link, t7.file_link as leave_options_link, t6.file_link as release_info_link, t9.file_link as tick_log_link, t1.park_comments, t1.hr_comments, t1.hr_rep_comments, t1.type_of_injury, t1.body_part, t1.employee_status, t1.wc_approved, t1.employee_name, t1.osha
from form19 as t1
left join form19_upload as t2 on t1.wc_id=t2.wc_id
left join form_wc_auth_upload as t3 on t1.wc_id=t3.wc_id
left join form_incident_investigate_upload as t4 on t1.wc_id=t4.wc_id
left join form_employee_statement_upload as t5 on t1.wc_id=t5.wc_id
left join form_release_info_upload as t6 on t1.wc_id=t6.wc_id
left join form_leave_options_upload as t7 on t1.wc_id=t7.wc_id
left join form_refuse_treatment_upload as t8 on t1.wc_id=t8.wc_id
left join form_tick_log_upload as t9 on t1.wc_id=t9.wc_id
left join form_witness_statement_upload as t10 on t1.wc_id=t10.wc_id

where t1.wc_id='$wc_id'
$where
"; 
//echo "$query";   //exit;
$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
if(empty($ARRAY)){echo "No WC records were found for wc_id = $wc_id $where. Please click your back button."; exit;}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

	include("../_base_top.php");

mysqli_select_db($connection,"divper"); // database

//  Bryan Dowdy - Parks Chief Ranger - 60033165
$sql="SELECT t3.email as chief_ranger
FROM position as t1
LEFT JOIN emplist as t2 on t1.beacon_num=t2.beacon_num
LEFT JOIN empinfo as t3 on t2.emid=t3.emid
where t1.beacon_num='60033165'
";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
$row=mysqli_fetch_assoc($result);
extract($row);

//  Keith Bilger - Safety Officer - 60033189
$sql="SELECT t3.email as safety_officer
FROM position as t1
LEFT JOIN emplist as t2 on t1.beacon_num=t2.beacon_num
LEFT JOIN empinfo as t3 on t2.emid=t3.emid
where t1.beacon_num='60033189'
";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
$row=mysqli_fetch_assoc($result);
extract($row);

$email="Dpr.hr@ncparks.gov";

// PASU
$park_code=$ARRAY[0]['park_code'];
$sql="SELECT group_concat(t3.Fname, ' ', t3.Lname order by t1.current_salary desc) as name, group_concat(t3.email order by t1.current_salary desc) as email

FROM position as t1 LEFT JOIN emplist as t2 on t1.beacon_num=t2.beacon_num LEFT JOIN empinfo as t3 on t2.emid=t3.emid where t1.park='$park_code' and t1.posTitle='Park Superintendent'
";  //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Select 85. $sql ".mysqli_error($connection));
$row=mysqli_fetch_assoc($result);
$exp1=explode(",",$row['name']);
$exp2=explode(",",$row['email']);
$to_pasu=$row['name'];
$email_pasu=$row['email'];

$rename=array("form_19_link"=>"Step 1: SUPERVISOR INCIDENT INVESTIGATION REPORT","date_of_injury"=>"Date of Injury","wc_auth_link"=>"Step 3: Medical Treatment Authorization","incident_investigate_link"=>"Step 4: Injury Data Collection form for Supervisors ","emp_statement_link"=>"Step 6: EMPLOYEE INCIDENT REPORT","release_info_link"=>"Step 8: Release of Information","park_code"=>"Park Code","wc_id"=>"Submission ID","timestamp"=>"Submission Timestamp","leave_options_link"=>"Step 7: Leave Options","park_comments"=>"Park Comments","hr_comments"=>"HR Comments","wc_approved"=>"Entered into CCMSI","employee_status"=>"Employee Status","refuse_treatment_link"=>"Step 2: Refuse Treatment","tick_log_link"=>"Tick Log","type_of_injury"=>"Injury Info","body_part"=>"Body Part", "hr_rep_comments"=>"HR Rep Comments", "witness_statement_link"=>"Step 5: Witness Statement");

$relink_action=array("form_19_link"=>"new_wc_request_1.php","wc_auth_link"=>"wc_authorization_3.php","incident_investigate_link"=>"incident_investigate_4.php","emp_statement_link"=>"employee_statement_6.php","release_info_link"=>"release_info.php","park_code"=>"Park Code","wc_id"=>"Submission ID","timestamp"=>"Submission Timestamp", "leave_options_link"=>"leave_options.php","refuse_treatment_link"=>"refuse_treatment.php","tick_log_link"=>"tick_related.php","witness_statement_link"=>"witness_statement_5.php");

$full_name=$ARRAY[0]['employee_name'];
$park_code=$ARRAY[0]['park_code'];

// echo "<pre>"; print_r($ARRAY); echo "</pre>"; 
//  exit;

$skip=array("employee_name","osha");
if($level<4)
	{$skip[]="type_of_injury";}

echo "<h2>Claim Review</h2>";
echo "<table border='1' cellpadding='5'><tr><td></td>
<td><font color='magenta'>$message</font> </td>
<td>Employee Name: <font color='magenta'><b>$full_name</b></font>
</td></tr>";

foreach($ARRAY AS $index=>$array)
	{
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="body_part"){continue;}
		$colspan="";
		if(strpos($fld,"_link")>0)
			{
			$action=$relink_action[$fld];
			
			if(!empty($value))
				{
				$no_delete=1;
				$var="<a href='$value' target='_blank'>View Uploaded Form</a>";
				if(($level>0 and $array['hr_comments']=="") or $level>1)
					{
					$wc_id=$ARRAY[0]['wc_id'];
					$var.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='delete_form.php?form=$fld&wc_id=$wc_id' onclick=\"return confirm('Are you sure you want to delete this Form?')\" target='_blank'>delete</a>";
					if($level>2)
						{
						$var.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='$action?wc_id=$wc_id' target='_blank'>View</a> page";
						}
					}
				
				$var.="</td>";
			$var.="<td>If necessary, upload PDF again. <form method='POST' action='$action' enctype='multipart/form-data'>
			<input type='hidden' name='wc_id' value='$wc_id'>
			<input type='file' name='files[]'>
			<input type=hidden name='reupload' value='reupload'>
			<input type=submit value='Upload File'>
			</form></td>";
			$value=$var;
				}
				else
				{
				$value="Nothing uploaded.";
				if(!empty($array['refuse_treatment_link']))
					{$value="Not needed. Employee refused treatment.";}
				if($fld=="refuse_treatment_link" and empty($array['refuse_treatment_link']))
					{$value="Treatment requested. This form not needed.";}
				if($fld=="tick_log_link" and empty($array['tick_log_link']))
					{$value="Not needed. Injury not tick related.";}
				$value.="<td><form method='POST' action='$action' enctype='multipart/form-data'>
			<input type='hidden' name='wc_id' value='$wc_id'>
			<input type='file' name='files[]'>
			<input type=hidden name='reupload' value='reupload'>
			<input type=submit value='Upload File'>
			</form></td>";
				}
			
			
			}
		$fld_rename=$rename[$fld];
		echo "<tr><td>$fld_rename</td>";
		
		if($fld=="park_comments")
			{
			echo "<form action='review_submission.php' method='POST'>"; // start form to capture comments and approval
			}
		if(strpos($fld,"_comments")>0)
			{
			$colspan="colspan='2'";
			$new_value="<textarea name='$fld' cols='80' rows='3'>$value</textarea>";
			if(($fld=="hr_comments" or $fld=="hr_rep_comments") and $level<3)
				{
				$new_value=$value;
				}
			$value=$new_value;
			}
		if($fld=="employee_status")
			{
			$cky="";$ckn="";
			if($value=="Permanent"){$cky="checked";}
			if($value=="Seasonal"){$ckn="checked";}
			$new_value="<input type='radio' name='$fld' value='Permanent' $cky>Permanent <input type='radio' name='$fld' value='Seasonal' $ckn>Seasonal";
			if($level<3)
				{
				$new_value=$value;
				}
			$value=$new_value;
			$cc=$safety_officer.";".$chief_ranger;
			$value.="</td><td>Email DPR  <a href=\"mailto:$email?cc=$cc&subject=$park_code Worker Comp for $full_name&body=https://10.35.152.9/work_comp/review_submission.php?wc_id=$wc_id You will need to login to the Worker's Comp db application to view. 
\">DPR-HR-Staff & Safety Officer</a>";
			}
		if($fld=="wc_approved")
			{
			if($value=="Yes"){$cky="checked";$ckn="";}else{$ckn="checked";$cky="";}
			$new_value="<input type='radio' name='$fld' value='Yes' $cky>Yes <input type='radio' name='$fld' value='No' $ckn>No";
			if($level<3)
				{
				$new_value=$value;
				}
			
			$value=$new_value;
			$body="https://10.35.152.9/work_comp/review_submission.php?wc_id=$wc_id  You will need to login to the Worker's Comp db application to view.";
			$value.="</td><td>Email PASU <a href=\"mailto:$email_pasu?subject=$park_code Worker Comp for $to_pasu&body=$body\">$to_pasu</a>";
			}
			
		if($fld=="type_of_injury")
			{
			$colspan="colspan='3'";//required
			$value="<table border='1'><tr><td>OSHA Classification<select name='osha' ><option value=''></option>\n";
			$osha_array=array("injury", "skin disorder (example rash)", "respiratory condition", "poisoning", "hearing loss", "all other illness (example tick bite)");
			foreach($osha_array as $k=>$v)
				{
				if($v==$array['osha'])
					{$s="selected";}
					else
					{$s="";}
				$value.="<option value=\"$v\" $s>$v</option>\n";
				}
			$value.="</select></td>";
			$type_of_injury=$array['type_of_injury'];//required
$value.="<td>Type of Injury<input type='text' name='$fld' value=\"$type_of_injury\" size='50' >";
			$body_part=$array['body_part'];//required
			$value.="</td><td>Body Part <input type='text' name='body_part' value=\"$body_part\" size='50' ></td></tr></table>";

			echo "<td $colspan>$value</td>";
			continue;
			}
			
		echo "<td align='center' $colspan>$value</td>";
		echo "</tr>";
		}
	}
if($level>0)
	{
	echo "<tr><td colspan='3' align='center'>
	<input type='hidden' name='wc_id' value='$wc_id'>
	<input type='submit' name='submit' value='Submit'>
	</td></tr>";
	echo "<tr><td colspan='3'><font color='red'>Click \"Submit\" to save your comments. Click \"DPR-HR-Staff & Safety Officer\" to generate email notification.</font></td></tr>";
	}
if($level>3 and empty($no_delete))
	{
	echo "<tr><td colspan='3' align='center'>
	<input type='hidden' name='delete' value='delete'>
	<input type='hidden' name='wc_id' value='$wc_id'>
	<input type='submit' name='submit' value='Delete'>
	</td></tr>";
	}
echo "</table>";
echo "</body></html>";
?>