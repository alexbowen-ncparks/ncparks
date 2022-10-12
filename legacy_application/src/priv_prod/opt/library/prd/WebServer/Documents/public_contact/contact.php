<?php
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="public_contact"; 

$dbName=$database;
session_start();
if(empty($_SESSION['public_contact']['level'])){exit;}
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php

include("../../include/get_parkcodes_reg.php");
mysqli_select_db($connection,$dbName);
//,"legislative_inquiry"
$not_required=array("response","comments","edited_by");

if(!empty($submit_form))
	{
// echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  exit;
	mysqli_select_db($connection,$dbName);

	IF(in_array($park_code, $adm_region))
		{$_POST['region_section']="DPR ADM";}
		ELSE
		{$_POST['region_section']=$region[$park_code];}
	
	$skip=array("submit_form","select_table");
	if($submit_form=="Update")
		{$skip[]="record_id";}
	FOREACH($_POST as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		$temp[]="`".$fld."`='".$value."'";
		}
	$var="[".substr($_SESSION[$dbName]['tempID'],0,-3)." ".date("Y-m-d H:i")."]";
	$temp[]="`edited_by`=concat('$var',' ',edited_by)";
	$clause=implode(", ",$temp);
	
	if($submit_form=="Add")
		{
		$sql="INSERT INTO records set $clause"; 
		}
		else
		{
		$sql="UPDATE records set $clause where id='$record_id'"; 
		}
		
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	if(empty($record_id))
		{
		$record_id=mysqli_insert_id($connection);
		}
	if($record_id>0)
		{
		if(!empty($_FILES['file_upload']))
			{
			include("upload_file.php");
			}
		$sql="SELECT * from records where id='$record_id'"; 
		$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_error($connection));
		$row=mysqli_fetch_assoc($result);
		extract($row);
		}
	}

if(!empty($record_id))
	{
	$sql="SELECT t1.*, t2.id as file_id, t2.file_name, t2.link from records as t1
	left join uploads as t2 on t1.id=t2.record_id
	where t1.id='$record_id'"; 
// 	echo "$sql";
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_error($connection));
	while($row_id=mysqli_fetch_assoc($result))
			{
			if(!empty($row_id['file_id']))
				{
				$ARRAY_files[$row_id['file_id']]=array("link"=>$row_id['link'],"file_name"=>$row_id['file_name']);
				}
			extract($row_id);
			}
	}
	
include("_base_top_1.php");

echo "<style>
.head {
padding: 5px;
font-size: 22px;
color: #999900;
}

td
{
padding: 3px;
}
 tr.d0 td {
  background-color: #ddddbb;
  color: black;
}
.table {
    border: 1px solid #8e8e6e; 
	margin: 5px 5px 5px 5px;
	background-color:#eeeedd;
	border-collapse:collapse;
  color: black;
}

table.alternate tr:nth-child(odd) td{
background-color: #ddddbb;
}
table.alternate tr:nth-child(even) td{
background-color: #eeeedd;
}

.search_box {
    border: 1px solid #8e8e6e;
	background-color:#f2e6ff;
	border-collapse:collapse;
  color: black;
}
.table_uno {
    border: 1px solid #8e8e6e; 
	margin: 5px 5px 5px 5px;
	background-color:#e0ebeb;
	border-collapse:collapse;
  color: black;
}
.ui-datepicker {
  font-size: 80%;
}
</style>";

$select_table="records";

$sql = "SHOW COLUMNS FROM $select_table";  //echo "hello3"; exit;
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$search_fields[]=$row['Field'];
	}
// echo "<pre>"; print_r($search_fields); echo "</pre>";  //exit;

include("get_arrays.php");
// returns 
// $ARRAY_contact_method_code
// $ARRAY_contact_method_name
// $ARRAY_contact_type_code
// $ARRAY_contact_type_name
 
 
$skip=array("id","region_section","void");

$rename_flds=array("contact_date"=>"Contact Date", "region_section"=>"Region / Section", "name_of_person"=>"Person making Inquiry", "park_code"=>"Park / Section", "contact_type"=>"Type of Contact", "contact_method"=>"Method Received", "contact_info"=>"Contact Info", "description"=>"Description", "handled_by"=>"Handled By", "response"=>"Response", "comments"=>"Comments", "edited_by"=>"Person(s) Adding/Updating Record", "legislative_inquiry"=>"Legislative Inquiry<br /><a href='DNCR_Legislative_Contact_Form.docx'>Legislative Contact Form</a>");

$drop_down=array("park_code");
$drop_down_arrays=array("park_code"=>"parkCode");

$radio=array("contact_method","contact_type","legislative_inquiry");
$radio_arrays=array("contact_method"=>"ARRAY_contact_method_code","contact_type"=>"ARRAY_contact_type_code","legislative_inquiry"=>"ARRAY_legislative_inquiry");

$ARRAY_legislative_inquiry=array("Yes","No");


$text_fld=array("description","handled_by","response","contact_info","comments");

// $alt_value_array=array("make","model","os");

array_unshift($parkCode,"ARCH","YORK");
	
echo "<form method='POST' action='contact.php' enctype='multipart/form-data'>";
echo "<table><tr><td><h4><font color='#39ac73'>Document a Public / Legislature Contact</h4></td></tr></table>";
echo "<table class='alternate'>";
foreach($search_fields as $index=>$fld)
	{
	if(in_array($fld, $skip)){continue;}
	if(!in_array($fld, $not_required))
		{$req="required";}
		else
		{$req="";}
		
	$value="";
	if(!empty(${$fld})) // get values for form from previously entered data
		{$value=${$fld};}
	
	$var_fld=$rename_flds[$fld];
	$line="<tr><td>$var_fld</td>
		<td><input type='text' name='$fld' value=\"$value\" $req> <font color='red' size='-1'>$req</font></td></tr>";
		
	if($fld=="contact_date")
		{
		$line="<tr><td>$var_fld</td>
		<td><input type='text' id=\"datepicker1\" name='$fld' value=\"$value\" $req> <font color='red' size='-1'>$req</font></td></tr>";
		}
	if(in_array($fld, $drop_down))
		{
		$line="<tr><td>$var_fld</td>
		<td><select name='$fld' $req><option value=\"\" selected></option>\n";
		if(array_key_exists($fld,$drop_down_arrays))
			{
			$select_array=${$drop_down_arrays[$fld]};
			foreach($select_array as $k=>$v)
				{
				if($v=="WOED"){continue;}  // part of CHRO
				if($value==$v){$s="selected";}else{$s="";}
				if($fld=="park_code")
					{
					$vv="- ".$parkCodeName[$v];
					}
				$line.="<option value='$v' $s>$v $vv</option>\n";
				}
		$line.="</select> <font color='red' size='-1'>$req</font></td></tr>";
			}
		}
		
	if(in_array($fld, $radio))
		{
		$line="<tr><td>$var_fld</td>
		<td>";
		$radio_array=${$radio_arrays[$fld]};
		foreach($radio_array as $k=>$v)
			{
			if($fld=="contact_method")
				{
				$vv=$ARRAY_contact_method_name[$v];
				}
			if($fld=="contact_type")
				{
				$vv=$ARRAY_contact_type_name[$v];
				}
			if($fld=="legislative_inquiry")
				{
				$vv=$v;
				if($v=="Yes")
					{
					$vv=$v." <font color='magenta' size='-1'>If yes, be sure to upload the completed form (see Upload below).</font>";}
					}
			if($v==$value){$ck="checked";}else{$ck="";}
			$line.="<input type='radio' name='$fld' value=\"$v\" $ck $req>$vv";
			}
		$line.=" <font color='red' size='-1'>$req</font></td></tr>";
		}
		
	if(in_array($fld, $text_fld))
		{
		$var="";
		if($fld=="contact_info"){$var="<br /><font color='#39ac73' size='-1'>email address, phone number, mailing address</font>";}
		if($fld=="description"){$var="<br /><font color='#39ac73' size='-1'>describe the situation</font>";}
		if($fld=="handled_by"){$var="<br /><font color='#39ac73' size='-1'>add names of those responding</font>";}
		if($fld=="response"){$var="<br /><font color='#39ac73' size='-1'>DPRs reply or replies</font>";}
		$line="<tr><td>$var_fld $var</td>
		<td>";
		$line.="<textarea name='$fld' rows='3' cols='55'  $req>$value</textarea> <font color='red' size='-1'>$req</font></td></tr>";
		}
		
	if($fld=="edited_by")
		{
		if(empty($value))
			{
			$value=substr($_SESSION[$database]['tempID'],0,-4);
			}
		$line="<td>$var_fld</td><td><font size='-2'>$value</font></td>";
		}
		
	echo "$line";

	}

// ************* Files ******************
if(!empty($ARRAY_files))
	{
// 	echo "<pre>"; print_r($ARRAY_files); echo "</pre>"; // exit;
	$substr_array=array(".jpg",".JPG",".png",".PNG",".pdf",".PDF");
	foreach($ARRAY_files as $file_id=>$array)
		{
		extract($array);
		$del="<td><a href='del_file.php?id=$file_id' onclick=\"return confirm('Are you sure you want to delete this File?')\">delete</a></td>";
		if(in_array(substr($link,-4), $substr_array))		
			{
			$var_ft=explode("/",$link);
			$file=array_pop($var_ft);
			array_push($var_ft, "tn_".$file);
			$file_name="<img src='".implode("/",$var_ft)."'>";
			$file_name=str_replace(".pdf",".jpg",$file_name);
			}
		
		echo "<tr style='background-color:#b3e6cc';><td>$file_name</td><td><a href='$link' target='_blank'>link</a></td>$del</tr>";
		}
	}

if(empty($record_id))
	{$action="Add"; $var_update="";}
	else
	{
	$action="Update";
	$var_update="<input type='hidden' name='record_id' value=\"$record_id\">";
	}
echo "<tr><td colspan='2' style='background-color:#d9f2e6';>Upload any associated photos, scans, files, etc.
<input type='file' name='file_upload[]' value=\"\"> Click \"$action\" after selecting file.
</td>";
if($level>3 and !empty($record_id)){echo "<td><a href='void.php?id=$record_id'>Void</a></td>";}
echo "</tr>";

echo "<tr><td colspan='2' align='center' style='background-color:#8cd9b3';><input type='hidden' name='select_table' value=\"$select_table\">";
echo "$var_update
<input type='submit' name='submit_form' value=\"$action\">";
echo "</td></tr></table>";
echo "</form>";

?>
