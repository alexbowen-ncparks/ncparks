<?php
ini_set('display_errors',1);
session_start();
date_default_timezone_set('America/New_York');

$database="dpr_land"; 
$dbName="dpr_land";
if(empty($connection))
	{
	include("../../include/iConnect.inc");//  includes no_inject_i.php
// 	echo "<pre>"; print_r($parkCodeName); echo "</pre>"; // exit;
	}

mysqli_select_db($connection,$dbName);

$sql = "SELECT park_id, park_name, park_abbreviation from park_name order by park_abbreviation";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$parkCodeName[$row['park_abbreviation']]=$row['park_name'];
	}

include("form_arrays.php");  // get $ARRAY_county_id_table, $unit_name_array
if(!empty($_POST['countyname']))
	{$_POST['countyid']=$ARRAY_county_id_table[$_POST['countyname']];}
	// $parkCodeName from ../../include/get_parkcodes_dist.php
	
// if(empty($_POST['complexname']) and !empty($_POST['park_abbreviation']))
// 	{
// 	$_POST['complexname']=$parkCodeName[$_POST['park_abbreviation']];
// 	}
	
if(@$_POST["submit_form"]=="Update")
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	include("edit_action.php");
	 if(empty($record_updated))
		{
		$form_action="search_form_tables.php";
		$select_table=$_POST['select_table'];
		if(!empty($source))
			{
			$form_action=$source;
			unset($_POST['submit_form']);
// 	echo "$source<pre>"; print_r($_POST); echo "</pre>";  exit;
			include("$form_action");
			}
			else
			{
			unset($_POST['submit_form']);
// 	echo "$source<pre>"; print_r($_POST); echo "</pre>";  exit;
			include("$form_action");
			}
		exit;
		}
	}
if(@$_POST["submit_form"]=="Delete Item")
	{
	include("edit_action.php");
	}
include("_base_top.php");

if($level>4)
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
// echo "<pre>"; print_r($ARRAY_county_id_table); echo "</pre>";
	}
$pass_park_code=@$_SESSION[$database]['select'];

mysqli_select_db($connection,$dbName);
$sql = "SHOW COLUMNS FROM $select_table";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

$ARRAY_fields=array();
$ARRAY_fields_type=array();
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_fields[]=$row['Field'];
	$ARRAY_fields_type[$row['Field']]=$row['Type'];
	}

// Form to edit an item
echo "<style>
/* Header Buttons - lifted from somewhere on the web*/
 input[name=submit_form] {
  color:#08233e;
  font:2.1em Futura, ‘Century Gothic’, AppleGothic, sans-serif;
  font-size:100%;
  padding:2px;
 
  background-color:rgba(255,204,0,1);
  border:1px solid #ffcc00;
  -moz-border-radius:10px;
  -webkit-border-radius:10px;
  border-radius:10px;
  border-bottom:1px solid #9f9f9f;
  -moz-box-shadow:inset 0 1px 0 rgba(255,255,255,0.5);
  -webkit-box-shadow:inset 0 1px 0 rgba(255,255,255,0.5);
  box-shadow:inset 0 1px 0 rgba(255,255,255,0.5);
  cursor:pointer;
 }
 input[type=submit]:hover {
  background-color:rgba(255,204,0,0.8);
 }
 input[name=submit_admin] {
  background-color:rgba(255,204,0,0.8);
 }
 
 
.head {
font-size: 22px;
color: #999900;
}
td.top {
 vertical-align: text-top;
 }

.div-one {
    display: inline-block;
    margin: 0 15px 0 0;
    vertical-align: middle;
    width: 430px;
}
.div-two {
    display: inline-block;
    vertical-align: middle;
    width: 535px;
}
.div-three {
   position: relative;
  left: 600px;
  width: 200px;
  border: 3px solid #73AD21;
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
.list
{
background-color:#eeeedd;
position:relative;
left:140px;
text-align: center;
}
.ui-datepicker {
  font-size: 80%;
}
</style>";

// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
$id_fld=$select_table."_id";
if(empty($table_id))
	{
	$table_id=${$id_fld};
	}

$pass_table_id=$table_id;
// table naming scheme didn't follow other tables for id
include("reassign_id_fld.php");  // readonly_array created here


$readonly_array[]="date_edited";

// $use_dropdowns set in this file
$dropdown_file="values_".$select_table.".php";  // also search_form.tables.php

include("use_drop_downs.php");

// echo "<pre>"; print_r($_POST); echo "</pre>";
if(!empty($park_id)){$pass_table_id=$park_id;}
$sql="SELECT t1.*
from $select_table as t1
 WHERE t1.$id_fld='$pass_table_id'";
 
//  ECHO "183 $sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY=$row;
	}
	
if(empty($source)){$source="";}
//  echo "$sql<pre>"; print_r($ARRAY); echo "</pre>id_fld=$id_fld source=$source"; // exit;
 
$form_action="search_form_tables.php";
if(!empty($source)){$form_action=$source;}else{$source="";}
echo "<div style='position: relative; left: 160px;'><form action='$form_action' method='post'>
	<input type='hidden' name='select_table' value=\"$select_table\">
	<input type='hidden' name='allow_admin' value=\"1\">";

if(!empty($source)){
		echo "<input type='hidden' name='county_code' value=\"$county_code\">";
		echo "<input type='hidden' name='project_status' value=\"$project_status\">";
}

if(!empty($ARRAY['park_abbreviation']))
	{
	$var_pc=$ARRAY['park_abbreviation'];
	echo "<input type='hidden' name='park_abbreviation' value='$var_pc'>";
	}
	

echo "<input type='submit' name='submit_admin' value='Return to Table'>
	</form></div>";

$skip=array("id");
$i=0;

include("form_arrays.php"); // master file that sets many array attributes

$textarea=array("notes");
// echo "form_arrays.php select_table=$select_table<pre>"; print_r($drop_down); echo "</pre>$id";
 // exit;

// echo "<pre>"; print_r($ARRAY_fields); echo "</pre>";
if(!empty($record_updated)){$message="<td>Updated</td>";}else{$message="";}
echo "<form action='edit_form.php' method='POST' enctype='multipart/form-data' >";
echo "<div class='div-one'><table class='table'><tr>
<td class='head' colspan='2'>Update an Item in $select_table</td>
$message
</tr>";
foreach($ARRAY_fields AS $index=>$fld)
	{
	if(in_array($fld,$skip)){continue;}
	if($level < 4 and in_array($fld,$admin_array)){continue;}
	$fld_type=$ARRAY_fields_type[$fld];
	$value=$ARRAY[$fld];
	$i++;
	fmod($i,2)!=0?$tr="class='d0'":$tr="";
	echo "<tr $tr>";

	echo "<td>$fld</td>";
	
	if(array_key_exists($fld,$date_array))
		{
		$var_id=$date_array[$fld];
		}
		else
		{$var_id=$index;}
	
	$ro="";

	if(in_array($fld, $readonly_array))  // array set in values.$table_select.php
		{$ro="readonly";}
			
	$line="<td><input id='$var_id' type='text' name='$fld' value=\"$value\" size='42' $ro></td>";
	
	if(in_array($fld,$true_false_array))
		{
		$select_array=$true_false_values;
		$line="<td><select name='$fld'><option value=\"\" selected></option>";
		foreach($select_array as $k=>$v)
			{
			if($v===$value){$s="selected";}else{$s="";}
			$line.="<option value='$v' $s>$v</option>";
			}
		$line.="</select></td>";
		}
	if(in_array($fld,$drop_down))   // form_arrays.php
		{
		$temp=$fld."_array";
		if(!is_array($temp)){${$temp}=array();}
		$select_array=${$fld."_array"};
// 		echo "<pre>"; print_r($select_array); echo "</pre>"; // exit;
		if(!empty($select_array))
			{
			$line="<td><select name='$fld'><option value=\"\" selected></option>";
			foreach($select_array as $k=>$v)
				{
				if($k==$value){$s="selected";}else{$s="";}
				$line.="<option value='$k' $s>$k - $v</option>";
				}
			$line.="</select></td>";
			}
			else
			{
			$line="<td><input id='$var_id' type='text' name='$fld' value=\"$value\" size='42' $ro></td>";
			}
		}
	if(in_array($fld,$textarea))
		{
		$rows=2;$cols=50;
		if($fld=="comments"){$rows=4;$cols=75;}
		$line="<td style=\"vertical-align:top\"><textarea name='$fld' cols='$cols' rows='$rows' $ro>$value</textarea>";
		if(array_key_exists($fld,$caption))
			{
			$line.=" - ".$caption[$fld];
			}
		$line.="</td>";
		}
	if($fld=="link")
		{
		$line="<td>
		<input type='file' name='file_upload'  size='20'>";
		if(!empty($value))
			{
			$line.="<a href='$value' target='_blank'>View</a> Photo	
		<a href='edit_form.php?track_id=$id'  onclick=\"return confirm('Are you sure you want to delete this Photo?')\">Delete</a> Photo";
			}	
		$line.="</td>";
		}	
	
	if($fld=="park_abbreviation")
		{
		$line="<td><select name='$fld'><option value=\"\" selected></option>\n";
		foreach($parkCodeName as $pc=>$pn)
			{
			if($pc==$value){$s="selected";}else{$s="";}
			$line.="<option value='$pc' $s>$pc - $pn</option>\n";
			}
		$line.="</select></td>";
		}	
	
	if($fld=="qc_spo")
		{
		if($value=="Yes"){$cky="checked"; $ckn="";}else{$cky=""; $ckn="checked";}
		$line="<td><input type='radio' name='$fld' value=\"Yes\" $cky>Yes 
		<input type='radio' name='$fld' value=\"No\" $ckn>No</td>";
		}	
	if($fld=="lease_type") // also in Search section and Add sections of search_form.php
		{
		$radio_array=$radio_array_form[$fld];  // set in form_arrays.php
		$line="<td>";
		foreach($radio_array as $k=>$v)
			{
			if($fld=="lease_type" and $v==NULL){continue;}
			if($value==$v){$ck="checked";}else{$ck="";}
			$line.="<input type='radio' name='$fld' value=\"$v\" $ck>$k";
			}
		$line.="</td>";
		}	
	if($fld=="unit_type") // also in Search section and Add sections of search_form.php
		{
		$radio_array=$radio_array_form[$fld];  // set in form_arrays.php line 2
		$line="<td>";
// 		echo "v=$value<pre>"; print_r($radio_array); echo "</pre>";
		foreach($radio_array as $k=>$v)
			{
			if(strtoupper($value)==$k){$ck="checked";}else{$ck="";}
			$line.="|<input type='radio' name='$fld' value=\"$k\" $ck>$v|";
			}
		$line.="</td>";
		}	
	if($fld=="asset_yn")
		{
		$asset_yn_array=array("Yes"=>"Yes","No"=>"No","NULL"=>"");
		$line="<td>";
		foreach($asset_yn_array as $k=>$v)
			{
			if($value==$v){$ck="checked";}else{$ck="";}
			$line.="<input type='radio' name='$fld' value=\"$v\" $ck>$k";
			}
		$line.="</td>";
		}	
	if($fld=="entered_by")
		{
		$val=$_SESSION['dpr_land']['tempID'];
		$line="<td><input id='$var_id' type='text' name='$fld' value=\"$val\" readonly></td>";
		}	
	if($fld=="lease_start_date")
		{
		// code for datepicker1 in _base_top.php
		$line="<td><input id='datepicker1' type='text' name='$fld' value=\"$value\"></td>";
		}		
	if($fld=="date_edited")
		{
		$today=date("Y-m-d");
		$line="<td><input type='text' name='$fld' value=\"$today\" readonly></td>";
		}			
	if($fld=="expires")
		{
		// code for datepicker5 in _base_top.php
		$line="<td><input id='datepicker5' type='text' name='$fld' value=\"$value\"></td>";
		}
	if($fld=="landleaseid" and is_numeric($value))
		{
		$line="<td><a href='https://www.ncspo.com/FIS/dbLandLease_public.aspx?LandLeaseID=$value' target='_blank'>$value</a></td>";
		}
	echo "$line";
	echo "</tr>";
	}
echo "<tr><td colspan='2'>&nbsp;</td></tr></table></div>";
if(!empty($pass_table_id)){$table_id=$pass_table_id;}
echo "<div class='div-two'><p align='center'>";

if(!empty($source)){
		echo "<input type='hidden' name='county_code' value=\"$county_code\">";
		echo "<input type='hidden' name='project_status' value=\"$project_status\">";
		echo "<input type='hidden' name='source' value='$source'>";
		}
		

		if(!empty($_POST['park_id']))
			{
			echo "<input type='hidden' name='park_id' value=\"$park_id\">";
			}
echo "<input type='hidden' name='select_table' value=\"$select_table\">
<input type='hidden' name='id_fld' value=\"$id_fld\">
<input type='hidden' name='$id_fld' value=\"$table_id\">
<input type='submit' name='submit_form' value=\"Update\">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='submit' name='submit_form' value=\"Delete Item\" onclick=\"return confirm('Are you sure you want to delete the item?')\">

</p>";
echo "</form>";

// Get any existing docs
$ARRAY_docs=array();
$sql = "SELECT * from documents where table_name='$select_table' and table_record_id='$table_id'"; 
// echo "$sql";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_docs[]=$row;
	}
if(empty($ARRAY_docs)){$dis="none";}else{$dis="block";}
echo "<p align='center'>
<a onclick=\"toggleDisplay('systemalert');\" href=\"javascript:void('')\">Upload Document</a>
<div id=\"systemalert\" style=\"display: $dis; margin-left:70px\">";

include("upload_doc_form.php");

echo "</div>
</div>";
// echo "<div class='div-three'><p align='center'>test</p></div>";
echo "
</html>";

?>