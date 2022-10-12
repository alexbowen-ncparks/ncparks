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
background-color: #eeeedd;
}
table.alternate tr:nth-child(odd) td{
background-color: #ddddbb;
}
</style>";
include("../../include/get_parkcodes_dist.php"); // include iConnect.inc with includes no_inject.php

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

echo "</td>";

echo "</tr>
</table>
</form>
</div>";
// echo "<pre>"; print_r($table_fields); echo "</pre>"; // exit;

if(empty($select_table))
	{
	exit;
	}	
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
if($level>4)
	{echo "$sql";}

$result = @mysqli_query($connection,$sql) or die("Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

$sql = "SELECT FOUND_ROWS() as num_records;";
$result1 = @mysqli_query($connection,$sql);
$row1=mysqli_fetch_assoc($result1);
extract($row1);  // number of records in $select_table before $limit

while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}

include("form_arrays.php");

// echo "<pre>"; print_r($unit_type_array); echo "</pre>";
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
$park_code_array=$parkCode;  //see get_parkcodes_dist.php

$textarea=array("notes","comments");

$radio_yn_array=array("asset_yn","lease_type","unit_type"); // line 214

$date_array_search=array("date_submit"=>"datepicker1","date_issued"=>"datepicker2");
$date_array_add=array("date_submit"=>"datepicker1","date_issued"=>"datepicker2","document_date"=>"datepicker1","expires"=>"datepicker1","lease_start_date"=>"datepicker3");
// make sure jquery is being called in _base_top.php

echo "<hr />";

$table_length=strlen($select_table);

$dropdown_file="values_".$select_table.".php";
// 
// // $use_dropdowns set in this file
include("use_drop_downs.php");  // line 13 uses $dropdown_file
// // echo "<pre>"; print_r($use_dropdowns); echo "</pre>"; // exit;

include("form_arrays.php");   // master file that sets many array attributes
// 
// $var=$select_table."_park_code_array";

// $use_dropdowns=array("land_easements");
$search_drop_down_flds=array("park_code");
foreach($search_drop_down_flds as $k=>$v)
	{
	${$v."_array"}=array();
	$t=array();
	if(in_array($v, $ARRAY_fields))
		{
// 		$t=${$v."_array"};
		$sql="SELECT distinct $v from $select_table order by $v";
		$result = @mysqli_query($connection,$sql) or die("Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		while($row=mysqli_fetch_assoc($result))
			{
			if(empty($row[$v])){continue;}
			$t[]=$row[$v];
			}
		}
	${$v."_array"}=$t;
	}
// echo "$sql<pre>"; print_r($park_code_array); echo "</pre>"; // exit;
$magenta_array=array();
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

// $drop_down_flip is an array created in use_drop_downs.php to flip numeric/string arrays
// if additonal arrays need flipping add them using $drop_down_flip[]="flip this field"

// SEARCH *****************
$show_field_id_array=array("land_assets"=>"land_assets_id", "gis_update"=>"land_asset_id", "land_owner"=>"land_owner_id", "land_asset_land_owner_junction"=>"land_asset_id", "deed_history"=>"deed_history_id");

$block="none";
if(!empty($select_table))
	{
// 	$dis="block";
	$dis="none";
	if(!empty($submit_form)){$dis="none";}
	}
	
echo "<table><tr><td>";
echo "<a onclick=\"toggleDisplay('search_form');\" href=\"javascript:void('')\">Search Form</a> for $select_table</td>";

echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick=\"toggleDisplay('add_form');\" href=\"javascript:void('')\">Add Record</a> to $select_table</td>";

echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>";

echo "<td><form action='search_form_tables.php' method='post'>
<input type='hidden' name='select_table' value='$select_table'>
<input type='submit' name='submit_form' value='Show All Records' style=\"background-color: #e6ccff;\">
</form></td></tr></table>";

// Search
echo "<div id=\"search_form\" style=\"display: $dis\">";
echo "<form action='search_form_tables.php' method='POST' enctype='multipart/form-data' >";
echo "<table><tr><td class='head' colspan='2'>Search $select_table</td></tr>";

// echo "ARRAY_fields<pre>"; print_r($ARRAY_fields); echo "</pre>"; // exit;
foreach($ARRAY_fields AS $index=>$fld)
	{
	if(in_array($fld,$skip)){continue;}
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
	
	if(array_key_exists($fld,$date_array_search))
		{
		$var_id=$date_array_search[$fld];
		}
		else
		{$var_id=$index;}
	$line="<td><input id='$var_id' type='text' name='$fld' value=\"\"></td>";
	if(in_array($fld,$search_drop_down_flds))
		{
		$select_array=${$fld."_array"};

// 		echo "<pre>"; print_r($select_array); echo "</pre>"; // exit;
		$drop_down_flip=array("descr");
		if(in_array($fld, $drop_down_flip))
			{
			$select_array=array_flip($select_array);
			}
// 		echo "<pre>"; print_r($select_array); echo "</pre>"; // exit;
		$line="<td><select name='$fld'><option value=\"\" selected></option>";
		foreach($select_array as $k=>$v)
			{
			$s="";
			$line.="<option value='$v' $s>$v - $k</option>";
			}
		$line.="</select></td>";
		}
	
	if(in_array($fld,$radio_yn_array)) // also edit Search section and edit_form.php
		{
		$radio_array=$radio_array_form[$fld];  // set in form_arrays.php
		if($fld=="unit_type"){echo "<pre>"; print_r($radio_array); echo "</pre>";}
		$line="<td>";
		foreach($radio_array as $k=>$v)
			{
			if($fld=="lease_type" and $v==NULL){continue;}
			$line.="<input type='radio' name='$fld' value=\"$v\">$k";
			}
		$line.="</td>";
		}
	
	echo "$line";
	echo "</tr>";
	}
echo "<tr><td colspan='2' align='center'>
<input type='hidden' name='select_table' value=\"$select_table\">
<input type='submit' name='submit_form' value=\"Search\"></td>
</tr>";
echo "</table>";
echo "</form>";
echo "</div>";


// ADD *****************

// $sql = "SELECT * from county_name"; 
// $result = mysqli_query($connection,$sql) or die("23 $sql ".mysqli_error($connection));
// $source_county="";
// while($row=mysqli_fetch_assoc($result))
// 	{
// 	$ARRAY_county_id_table[$row['county_name']]=$row['county_id'];
// 	$source_county.="\"".$row['county_name']."\",";		
// 	}
$source_county=rtrim($source_county,",");  // from form_arrays.php
echo "<script>
$(function()
	{
	$( \"#name_county\" ).autocomplete({
	source: [ $source_county ]
		});
	});
</script>";

if(empty($hide_fld_array))
	{$hide_fld_array=array();}
$skip_select_flds_array=array("acquisition_justification", "county_name", "park_name", "spo_milestones", "classification", "classification_abbreviation");
$required_array=array("park_code","unit_type","termlength_years","lease_start_date","expires","countyname", "lease_type");
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
	if(in_array($fld, $required_array)){$req="required";}else{$req="";}
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
	echo "<td>$var_fld <font color='red'>$req</font></td>";
	
	if(array_key_exists($fld,$date_array_add))
		{
		$var_id=$date_array_add[$fld];
// 		$var_id="datepicker1";
		}
		else
		{$var_id=$index;}
	
	// default $line
	$line="<td><input id='$var_id' type='text' name='$fld' value=\"\" $req></td>";
	
	if($fld=="countyname")
		{
		
	$line="<td><input id='name_county' type='text' name='$fld' value=\"\" $req></td>";
	}
		
// 	id=\"name_cn\"
	if(in_array($fld,$drop_down))    // $drop_down set in use_drop_downs.php
		{
		$select_array=${$fld."_array"};  // arrays created in values_?_.php
		if(in_array($fld, $drop_down_flip))
			{
			$select_array=array_flip($select_array);
			}
		$line="<td><select name='$fld' $req><option value=\"\" selected></option>";
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
		$line="<td><input id='$var_id' type='text' name='$fld' value=\"\" $req></td>";
		}
	if(in_array($fld, $textarea))
		{
		$line="<td><textarea name='$fld' cols='50' rows='3'></textarea></td>";
		}
	if(in_array($fld,$radio_yn_array))  // also edit Search section and edit_form.php
		{
		$radio_array=$radio_array_form[$fld];  // set in form_arrays.php
		$line="<td>";
		foreach($radio_array as $k=>$v)
			{
			$line.="<input type='radio' name='$fld' value=\"$v\" $req>$k";
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