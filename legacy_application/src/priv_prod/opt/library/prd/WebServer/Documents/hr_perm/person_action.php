<?php
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
date_default_timezone_set('America/New_York');
$database="hr_perm"; 
$dbName="hr_perm";

include("../../include/iConnect.inc");

ini_set('display_errors',1);

include("../_base_top.php");
if(!isset($parkCode)){include("../../include/get_parkcodes_reg.php");}

// ********** Set Variables *********
if(!isset($_SESSION)){session_start();}

@$level=$_SESSION['hr_perm']['level'];

mysqli_select_db($connection,$dbName);

echo "<style>
.head {
font-size: 22px;
color: #999900;
}

table.alternate tr:nth-child(odd) td{
background-color: #e6e6ff;
padding: 10px;
}
table.alternate tr:nth-child(even) td{
background-color: #e6ffe6;
padding: 10px;
}
.ui-datepicker {
  font-size: 80%;
}
</style>";
if(@$_POST["submit_form"]=="Enter Person")
	{
	include("add_person.php");
	}

if(@$_POST["submit_form"]=="Update Person")
	{
	include("update_person.php");
	}

if(@$_POST["submit_form"]=="Find Applicant")
	{
	include("find_applicant.php");
	}

if(@$_POST["submit_form"]=="Find Employee")
	{
	include("find_employee.php");
	}

if(@$_POST["submit_form"]=="Upload Forms")
	{
	include("upload_employee_forms.php");
	}
$table="applicants";
$sql = "SHOW COLUMNS FROM $table";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_add_person[]=$row['Field'];
	}

// echo "<pre>"; print_r($ARRAY_add_person); echo "</pre>";  exit;
// Form to add an item


$skip=array("id","tempID");
$drop_down=array("park_code","disposition","category","sub_cat");
$park_code_array=$parkCode;  //see get_parkcodes_reg.php above
// $disposition_array=array("Surplus","Scrap","Landfill","Park Use");
// $category_array=array("Monetary","Non-Monetary","Personal Belongings");
// $sub_cat_array=array("Cash","Credit Card", "Checkbook", "Traveler's Check");

$textarea=array("comments","track");

$caption=array("comments"=>"");

$rename_array=array("Lname"=>"Last Name", "Fname"=>"First Name", "M_initial"=>"Middle Initial", "ssn_last4"=>"Last four digits of SSN","driver_license"=>"Driver's License","beaconID"=>"Employee BEACON Number","e_verify"=>"E-Verify","track"=>"Action by","comments"=>"Comments");

$size_array=array("M_initial"=>"2", "ssn_last4"=>"5");

$date_array=array("date_submit"=>"datepicker1","date_issued"=>"datepicker2");
// make sure jquery is being called in _base_top.php

$var_action="Enter";
$phrase="Applicant Info";
if(!empty($id))
	{$var_action="Update";}
if($action_type=="find_applicant")
	{
	$var_action="Find";
	$phrase="Applicant";
	}
if($action_type=="find_employee")
	{
	$var_action="Find";
	$phrase="Employee";
	$skip[]="e_verify";
	$skip[]="comments";
	}
	
echo "<form action='person_action.php' method='POST' enctype='multipart/form-data' >";
echo "<table cellpadding='5'><tr><td class='head' colspan='2'>$var_action the following $phrase</td></tr>";
foreach($ARRAY_add_person AS $index=>$fld)
	{
	if(in_array($fld,$skip)){continue;}
	if($level < 4 and in_array($fld,$admin_array)){continue;}
	
	@$value=${$fld};
	echo "<tr>";
	$var_fld=$fld;
	if($fld=="link"){$var_fld="<font color='magenta'>photo</font>";}
	if(array_key_exists($fld,$rename_array))
		{$var_fld=$rename_array[$fld];}
	echo "<td>$var_fld</td>";
	
	if(array_key_exists($fld,$date_array))
		{
		$var_id=$date_array[$fld];
		}
		else
		{$var_id=$index;}
	
	if(array_key_exists($fld, $size_array)){$size=$size_array[$fld];}else{$size="";}
	$line="<td><input id='$var_id' type='text' name='$fld' value=\"$value\" size='$size'></td>";
	if(in_array($fld,$drop_down))
		{
		if($level<2){$value=$pass_park_code;}else{$value="";}
		$select_array=${$fld."_array"};
		$line="<td><select name='$fld'><option value=\"\" selected></option>";
		foreach($select_array as $k=>$v)
			{
			if($v==$value){$s="selected";}else{$s="";}
			$line.="<option value='$v' $s>$v</option>";
			}
		$line.="</select></td>";
		}
	if(in_array($fld,$textarea))
		{
		$rows=2;$cols=50;
		if($fld=="comments"){$rows=4;$cols=75;}
		$line="<td style=\"vertical-align:top\"><textarea name='$fld' cols='$cols' rows='$rows'>$value</textarea>";
		if(array_key_exists($fld,$caption))
			{
			$line.=" ".$caption[$fld];
			}
		
		if($fld=="track")
			{
			if(empty($track))
				{$val=substr($_SESSION[$dbName]['tempID'],0,-4);}
				else
				{$val=$track;}
		$rows=4;$cols=75;
		$line="<td style=\"vertical-align:top\"><textarea name='$fld' cols='$cols' rows='$rows' readonly>$val</textarea>";
		
		$line.="</td>";
			}	
		}
	if($fld=="link")
		{
		$line="<td>
		<input type='file' name='file_upload'  size='20'>
		</td>";
		}
	
	echo "$line";
	echo "</tr>";
	}
echo "<tr><td colspan='2' align='center'>";
if(!empty($id))
	{	
	echo "<input type='hidden' name='id' value=\"$id\">";
	}
echo "<input type='hidden' name='action_type' value=\"$action_type\">";
echo "<input type='submit' name='submit_form' value=\"$var_action $phrase\">
</td></tr>";
echo "</table>";
echo "</form></html>";

?>