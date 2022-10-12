<?php
//   echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//   echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
date_default_timezone_set('America/New_York');
$database="dpr_land"; 
$dbName="dpr_land";

include_once("../_base_top.php");
$pass_park_code=@$_SESSION[$database]['select'];
echo "
<style>

.head {
font-size: 22px;
color: #999900;
}

.ui-datepicker {
  font-size: 80%;
}
 input[name=submit_form] {
  background-color:#1aff1a;
 }
 
table.alternate tr:nth-child(even) td{
background-color: #d2a679;
}
table.alternate tr:nth-child(odd) td{
background-color: #ffd7b3;
}
</style>";
include("../../include/get_parkcodes_dist.php"); // include iConnect.inc with includes no_inject.php



if(@$_POST["submit_form"]=="Add Record")
	{
	include("add_action.php");
	}

$skip_tables=array("LANDBASE_1","SPO_LandAsset_ID", "balance");

$sql = "SHOW TABLES FROM $dbName"; 
$result = mysqli_query($connection,$sql) or die("23 $sql Error 1#");
while($row=mysqli_fetch_assoc($result))
	{
	extract($row);
	if(in_array($Tables_in_dpr_land, $skip_tables)){continue;}
	$ARRAY_table[]=$row;
	}
// echo "<pre>"; print_r($ARRAY_table); echo "</pre>"; // exit;

if(!empty($submit_admin) and empty($select_table))
	{
	echo "<div><form method='POST'>
	<table><tr><td class='head' colspan='2'>The DPR Land database - Manage Tables</td></tr>
	<tr><td>Select a table: 
	<select name='select_table' onChange=\"this.form.submit();\"><option value='' selected></option>\n";
	foreach($ARRAY_table as $index=>$array)
		{
		foreach($array as $k=>$v)
			{
			if(substr($v,0,2)=="z_"){continue;}  // hide old tables
			if(substr($v,-9,4)=="_201"){continue;}  // hide backup tables
			if(substr($v,-9,4)=="_202"){continue;}  // hide backup tables
			if(substr($v,-4,4)=="_old"){continue;}  // hide backup tables
			if($select_table==$v){$s="selected";}else{$s="";}
			echo "<option value='$v' $s>$v</option>\n";
			}
		}
	echo "</select>";
	// echo "<input type='hidden' name='allow_admin' value=\"1\">";
	echo "</td>";

	echo "</tr>
	</table>
	</form>
	</div>";

	}
if(empty($select_table))
	{
	exit;
	}

foreach($_REQUEST as $k=>$v)
	{
	if(!empty($v))
		{$post_query[$k]=$v;}
	}
$_SESSION['request_search_array']=$post_query;
// echo "<pre>"; print_r($post_query); echo "</pre>";
mysqli_select_db($connection,$dbName);

$sql = "SHOW COLUMNS FROM $select_table"; //echo "$sql";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

$hide_fld_array=array();
$ARRAY_fields=array();
$ARRAY_fields_type=array();
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_fields[]=$row['Field'];
	$ARRAY_fields_type[$row['Field']]=$row['Type'];
	if($row['Key']=="PRI" and $row['Extra']=="auto_increment")
		{
		$hide_fld_array[]=$row['Field'];  // used to hide this field when adding a new record
		}
	}
// echo "<pre>"; print_r($ARRAY_fields); echo "</pre>"; // exit;

$message="";
// if(in_array($select_table,$limit_array) and empty($_POST['submit_form']))
if(empty($_POST['submit_form']))
	{
	$limit="limit 20";
	}
	else
	{$limit="";}

$clause="";
$temp=array();
if(@$_POST["submit_form"]=="Search")
	{
	$skip_search=array("select_table","submit_form");
//  	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	foreach($_POST as $fld=>$value)
		{
		if(in_array($fld, $skip_search)){continue;}
		if(empty($value))
			{
			if($fld=="sos_inclusion")
				{
				if($value==="0")
					{
					$temp[]="$fld is NULL";
					}
				continue;
				}
				else
				{continue;}
			}
		if(substr($fld,-3)=="_id" or substr($fld,-11)=="_id_primary" or substr($fld,-13)=="_id_secondary")
			{
			$temp[]="$fld = '$value'";
			}
			else
			{
			if($ARRAY_fields_type[$fld]!="text")
				{
				$temp[]="$fld = '$value'";
				}
				else
				{
				$temp[]="$fld like '%$value%'";
				}
			}
		}
	if(empty($temp))
		{
		echo "A valid query could not be made for $select_table. Try again."; exit;
		}
	$clause="where ".implode(" and ",$temp);
	}
if(!empty($sort))
	{
	$order_by="order by $sort $d";
	}
	else
	{
	$order_by="";
	}
$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $select_table 
$clause
$order_by
$limit";
// if($level>4)
// 	{echo "$sql";}

$result = @mysqli_query($connection,$sql) or die("Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

$unit_type_array=array();
$sql = "SELECT unit_code, unit_type from dpr_system.acreage;";
$result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$unit_type_array[$row['unit_code']]=$row['unit_type'];
	}

// Form to add an item
echo "<style>
.head {
font-size: 22px;
color: #999900;
}

.ui-datepicker {
  font-size: 80%;
}
</style>";

$skip=array("id");
// $park_code_array=$parkCode;  //see get_parkcodes_dist.php


$textarea=array("notes","comments");

$date_array_search=array("date_submit"=>"datepicker1","date_issued"=>"datepicker2");
$date_array_add=array("date_submit"=>"datepicker1","date_issued"=>"datepicker2","document_date"=>"datepicker1","expires"=>"datepicker1");
// make sure jquery is being called in _base_top.php

echo "<hr />";

$table_length=strlen($select_table);

$dropdown_file="values_".$select_table.".php";

// $use_dropdowns set in this file
include("use_drop_downs.php");  // line 13 uses $dropdown_file
// echo "<pre>"; print_r($use_dropdowns); echo "</pre>"; // exit;

// $var=$select_table."_park_code_array";
// 
// if(is_array($var))
// 	{
// 	echo "<pre>"; print_r($land_leases_park_code_array); echo "</pre>";  exit;
// 	$use_dropdowns[]="park_code";
// 	}
	
$magenta_array=array();
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

// $drop_down_flip is an array created in use_drop_downs.php to flip numeric/string arrays
// if additonal arrays need flipping add them using $drop_down_flip[]="flip this field"

// SEARCH *****************
include("search_form.php");

// echo "<pre>"; print_r($unit_type_array); echo "</pre>"; exit;

// ADD *****************
if(empty($hide_fld_array))
	{$hide_fld_array=array();}
$skip_select_flds_array=array("acquisition_justification", "county_name", "park_name", "spo_milestones", "classification", "classification_abbreviation");
//    $show_field_id_array around line 189
// echo "<pre>"; print_r($date_array_add); echo "</pre>";  exit;
echo "
<div id=\"add_form\" style=\"display: none\">";
echo "<form action='add_form_tables.php' method='POST' enctype='multipart/form-data' >";
echo "<table><tr><td class='head' colspan='2'>Add to $select_table</td></tr>";
foreach($ARRAY_fields AS $index=>$fld)
	{
	if(in_array($fld,$skip)){continue;}
	if(in_array($fld,$hide_fld_array))
		{
		$primary_key_fld=$fld;
		continue;
		}
	if($level < 4 and in_array($fld,$admin_array)){continue;}
	$ck_field="";
	if(!array_key_exists($select_table, $show_field_id_array))
		{
		$ck_field=substr($fld,0,$table_length)."_id";
		}
		else
		{
		$primary_key_fld=$fld;
		}
	if($fld==$ck_field){continue;}
	echo "<tr>";
	$var_fld=$fld;
	if($fld=="link" and in_array($fld, $magenta_array))
		{$var_fld="<font color='magenta'>photo</font>";}
	echo "<td>$var_fld</td>";
	
	if(array_key_exists($fld,$date_array_add))
		{
		$var_id=$date_array_add[$fld];
		$var_id="datepicker1";
		}
		else
		{$var_id=$index;}
	$line="<td><input id='$var_id' type='text' name='$fld' value=\"\"></td>";
	if(in_array($fld,$drop_down))    // $drop_down set in use_drop_downs.php
		{
		$select_array=${$fld."_array"};  // arrays created in values_?_.php
		if(in_array($fld, $drop_down_flip))
			{
			$select_array=array_flip($select_array);
			}
		$line="<td><select name='$fld'><option value=\"\" selected></option>";
		foreach($select_array as $k=>$v)
			{
			$s="";
			$line.="<option value='$v' $s>$v - $k</option>";
			}
		$line.="</select></td>";
		}
	if($select_table=="edit_data_display")
		{
		if($fld=="select_table")
			{
			$select_array=$ARRAY_table;
			$line="<td><select name='$fld'><option value=\"\" selected></option>";
			foreach($select_array as $k=>$array)
				{
				$s="";
				$v=$array['Tables_in_dpr_land'];
				$line.="<option value='$v' $s>$v</option>";
				}
			}
		$line.="</select></td>";
		}
	if(in_array($fld, $skip_select_flds_array) )
		{
		$line="<td><input id='$var_id' type='text' name='$fld' value=\"\"></td>";
		}
	if(in_array($fld, $textarea))
		{
		$line="<td><textarea name='$fld' cols='50' rows='3'></textarea></td>";
		}
	
	if(in_array($fld,$radio_yn_array))
		{
		$asset_yn_array=array("Yes"=>"Yes","No"=>"No","NULL"=>"");
		$line="<td>";
		foreach($asset_yn_array as $k=>$v)
			{
			$line.="<input type='radio' name='$fld' value=\"$v\">$k";
			}
		$line.="</td>";
		}
	
// 	if(in_array($fld, $date_array_add))
// 		{
// 		$line="<td><input id='datepicker1' type='text' name='$fld' value=\"".date("Y-m-d")."\" readonly></td>";
// 		}		
	if($fld=="date_added")
		{
		$line="<td><input type='text' name='$fld' value=\"".date("Y-m-d")."\" readonly></td>";
		}		
	
	echo "$line";
	echo "</tr>";
	}
// <input type='hidden' name='primary_key_fld' value=\"$primary_key_fld\">
echo "<tr><td colspan='2' align='center'>
<input type='hidden' name='select_table' value=\"$select_table\">
<input type='submit' name='submit_form' value=\"Add\"></td>
</tr>";
echo "</table>";
echo "</form>";
echo "</div>";
if(empty($ARRAY))
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	ECHO "<br /><br />No records for table = $select_table."; exit;
	}

// table naming scheme didn't follow other tables for id
$id_fld=$select_table."_id";
include("reassign_id_fld.php"); // readonly_array created here

// echo "<pre>"; print_r($unit_type_array); echo "</pre>"; // exit;

$skip=array();
$c=count($ARRAY);
$message="";
if(empty($submit_form))
	{
	$message="Showing the first 20 or less of <strong>$num_records</strong> records for table <strong>$select_table</strong>.";
	}
	else
	{
	$message="[$c records retrieved] $clause";
	}
$table_id="";
if(empty($d)){$d="";}
if($d=="asc"){$d="desc";}else{$d="asc";}
// echo "<pre>"; print_r($ARRAY); echo "</pre>";

	$request_search_array[]=array_keys($ARRAY[0]);
// 	echo "<pre>"; print_r($request_search_array); echo "</pre>";
echo "<hr /><table class='alternate'><tr><td colspan='15'>$message</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			if(substr($fld,-3,3)=="_id" and empty($table_id))
				{$table_id=$fld;}
			$var_fld=str_replace("_"," ",$fld);

			// $var_fld="<a href='search_form_tables.php?select_table=$select_table&sort=$fld&d=$d'>$var_fld</a>";

$var_btn="<form action='search_form_tables.php' method='POST'>";

	$var_btn.="<input type='hidden' name='select_table' value=\"$select_table\">";
	$var_btn.="<input type='hidden' name='sort' value=\"$fld\">";
	$var_btn.="<input type='hidden' name='d' value=\"$d\">";
	$var_btn.="<input type='hidden' name='$k' value=\"$v\">";
	$var_btn.="<button type='submit_form' style='background-color: #4CAF50; color: white; font-size: 16px;'>$fld</button></form>";
	

			echo "<th>$var_btn</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld==$table_id)
			{
			$action_form="edit_form.php";
// 			if($level>4 and $select_table=="land_assets"){$action_form="edit_form_test.php";}
			$value="<form action='$action_form' method='post'>
			<input type='hidden' name='select_table' value='$select_table'>
			<input type='hidden' name='table_id' value='$value'>
			<input type='submit' name='submit_admin' value='Edit $value' style=\"background-color: #e6ccff;\">
			</form>";
			}
		if($fld=="land_assets_id" and $select_table!="land_assets")
			{
			$value="<form action='view_form.php' method='post' target='_blank'>
			<input type='hidden' name='select_table' value='$select_table'>
			<input type='hidden' name='land_assets_id' value='$value'>
			<input type='submit' name='submit_admin' value='View $value' style=\"background-color: #ccff99;\">
			</form>";
			}
		if($fld=="expires" and $select_table=="land_leases")
			{
			$var_id=$array['land_leases_id'];
			$value="<a href='send_email.php?var_id=$var_id&$fld=$value' target='_blank'>$value</a>";
			}
		if($fld=="landleaseid" and is_numeric($value))
			{
			$value="<a href='https://www.ncspo.com/FIS/dbLandLease_public.aspx?LandLeaseID=$value' target='_blank'>$value</a>";
			}

		echo "<td align='center'>$value</td>";
		}
	echo "</tr>";
	}
	
echo "</table>";
echo "</html>";

?>