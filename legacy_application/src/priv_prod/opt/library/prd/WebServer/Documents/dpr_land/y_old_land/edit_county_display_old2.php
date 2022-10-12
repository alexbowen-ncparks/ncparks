<?php
//    echo "I'm working on this.   <pre>"; print_r($_POST); echo "</pre>";  //exit;
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="dpr_land"; 
$dbName="dpr_land";

include_once("../_base_top.php");
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
echo "
<style>
/* Header Buttons */
 input[name=submit_form] {
  color:#08233e;
  font:2.1em Futura, ‘Century Gothic’, AppleGothic, sans-serif;
  font-size:100%;
  padding:2px;
 
  background-color: #b3e6cc;
  border:1px solid #39ac73;
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
background-color: #ffd7b3;
}
table.alternate tr:nth-child(even) td{
background-color: #ffffff;
}
 </style>
 ";

include("../../include/iConnect.inc"); // includes no_inject_i.php

if(@$_POST["submit_form"]=="Update")
	{
//	include("display_data_action.php");
	}
$ARRAY_project_status[33]="All statuses";
$sql = "SELECT * FROM project_status order by project_status_id";  //echo "hello3"; exit;
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_project_status[$row['project_status_id']]=$row['project_status'];
	}

$sql = "SELECT distinct t1.county_id as county_number, t2.county_name 
FROM land_assets as t1
left join `county_name` as t2 on t1.county_id=t2.county_id
order by t2.county_name"; 
// echo "$sql";
$result = @mysqli_query($connection,$sql) or die("23 $sql Error 1#");
while($row=mysqli_fetch_assoc($result))
	{
	if(empty($row['county_name'])){continue;}
	$ARRAY_county_code[$row['county_number']]=$row['county_name'];
	}
// echo "<pre>"; print_r($ARRAY_county_code); echo "</pre>"; // exit;	
echo "<form method='POST'><table>
<tr>";
// <td>Passed SPO Review: <input type='radio' name='qc_spo' value=\"Yes\">Yes 
// <input type='radio' name='qc_spo' value=\"No\" checked>No 
// <input type='radio' name='qc_spo' value=\"No\" checked>Either 
// </td>

echo "<td>County Code: <select name='county_code' value=\"\" onChange=\"this.form.submit()\">
<option value=''></option>\n";
foreach($ARRAY_county_code as $k=>$v)
	{
	if($county_code==$k){$s="selected";}else{$s="";}
	echo "<option value='$k' $s>$v - $k</option>\n";
	}
echo "</select></td>";

$ps_clause="";
if(!empty($project_status))
	{
	$ps_clause="and t1.project_status_id='$project_status'";
	if($project_status==33)
		{$ps_clause="";}
	}

echo "<td>Project Status: <select name='project_status' onchange=\"this.form.submit();\">
<option value='' selected></option>\n";
foreach($ARRAY_project_status as $k=>$v)
	{
	if($k==$project_status){$s="selected";}else{$s="";}
	echo "<option value='$k' $s>$v</option>\n";
	}
echo "</select>
";
echo "</tr></table></form>";

$clause="";
if(empty($county_code))
	{
	if(empty($project_status))
		{exit;}
	$clause=1;
	}
	else
	{
// 	if($qc_spo=="No")
// 		{$qc_spo="No' or qc_spo='')";}
// 		else
// 		{$qc_spo="Yes' )";}
// 	$clause="t1.`county_id` = '$county_code' and (qc_spo='$qc_spo ";
	$clause="t1.`county_id` = '$county_code' ";
	}	
mysqli_select_db($connection,$dbName);

$order_by="order by park_code";
if(@$sort_by=="asc")
	{$order_by="order by $sort_fld asc";}
if(@$sort_by=="desc")
	{$order_by="order by $sort_fld desc";}
$sql="SELECT t1.qc_spo, t3.park_abbreviation as park_code, t2.CountyName, t1.`land_assets_id` , t1.`acreage`, t1.`consideration`, t2.deedacres, t1.spo_closed_number, t2.spo_number, t2.spo_landAsset_id_number, group_concat(distinct t4.notes separator '<br /><br />') as notes_2 

FROM `land_assets` as t1 

left join SPO_LandAsset_ID as t2 on t1.`county_id`=t2.CountyID and t1.acreage=t2.deedacres 

left join `park_name` as t3 on t1.park_id=t3.park_id 

left join `land_notes` as t4 on t1.land_assets_id=t4.land_assets_id 

WHERE $clause $ps_clause
group by t1.land_assets_id 
$order_by";
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//     ECHO "$sql<br /><br />";  //exit;
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$park_code_select[$row['park_code']]=$row['park_code'];
	$CountyName_select[$row['CountyName']]=$row['CountyName'];
	}
//  echo "<pre>"; print_r($ARRAY_fields); echo "</pre>";  exit;
	
// Form to add an item
echo "
<style>
table.alternate tr:nth-child(odd) td{
background-color: #fff2e6;
}
table.alternate tr:nth-child(even) td{
background-color: #ffffff;
}
.head {
font-size: 22px;
color: #999900;
}

.ui-datepicker {
  font-size: 80%;
}
</style>";

$skip=array("id");
$drop_select=array("park_code", "CountyName");
//  echo "<pre>"; print_r($ARRAY_fields); echo "</pre>";  exit;

if(empty($ARRAY))
	{ECHO "No asset found for county_code=$county_code $ps_clause."; exit;}
$c=count($ARRAY);
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		$asc=""; $desc="";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$var_fld=str_replace("_"," ",$fld);
			if($var_fld=="spo closed number")
				{
				$var_fld="a_".$var_fld;
				}
			if($var_fld=="spo number")
				{
				$var_fld="b_".$var_fld;
				}
			$asc="<form action='edit_county_display.php' method='post'>
			<input type='hidden' name='sort_by' value='asc'>
			<input type='hidden' name='sort_fld' value='$fld'>
			<input type='hidden' name='county_code' value='$county_code'>
			<input type='hidden' name='project_status' value='$project_status'>
			<input type='submit' name='submit_admin' value='A' style=\"background-color: #f3e6ff;\">
			</form>";
			$desc="<form action='edit_county_display.php' method='post'>
			<input type='hidden' name='sort_by' value='desc'>
			<input type='hidden' name='sort_fld' value='$fld'>
			<input type='hidden' name='county_code' value='$county_code'>
			<input type='hidden' name='project_status' value='$project_status'>
			<input type='submit' name='submit_admin' value='D' style=\"background-color: #f3e6ff;\">
			</form>";
			if(in_array($fld,$drop_select))
				{
				$select_menu="<form action='edit_county_display.php' method='post'>
				<select name='$fld' onchange=\"this.form.submit();\">
				<option value=\"All\">All</option>\n";
				$menu_select_array=${$fld."_select"};
				sort($menu_select_array);
				foreach($menu_select_array as $sk=>$sv)
					{
					if($sv==@$_POST[$fld]){$s="selected";}else{$s="";}
					$select_menu.="<option value='$sv' $s>$sv</option>\n";
					}
				$select_menu.="</select><input type='hidden' name='sort_by' value='drop_down'>
			<input type='hidden' name='sort_fld' value='$fld'>
			<input type='hidden' name='county_code' value='$county_code'>
			<input type='hidden' name='project_status' value='$project_status'></form>";
				$var[]="<th>$var_fld $select_menu</th>";
				}
				else
				{
				$var[]="<th>$var_fld $asc $desc</th>";
				}
			}
		$header_array_0=implode($var);

$span=count($var);
// echo "<form name='frm_display' action='edit_county_display.php' method='POST'>";
echo "<table class='alternate' border='1' cellpadding='3'><tr><td class='head' colspan='$span'>Comparing MySQL table 'a_land_assets' values with those from 'b_SPO_LandAsset_ID' <br />for county code: <strong>$county_code</strong> and a_acreage = b_deedacres [ $c records ] ";
echo "</td></tr>";

		}
	if(fmod($index,25)==0 and empty($skip_row))
		{echo "<tr bgcolor='yellow'>$header_array_0</tr>";}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
	//	if(in_array($fld,$skip)){continue;}
		$td="";
		if(!empty($_POST['sort_by']))
			{
			if($_POST['sort_by']=="drop_down")
				{
				$var_t=$_POST['sort_fld'];  //echo "$var_t";
				@$test_value=$_POST[$var_t];  //echo "$test_value";
				if($array[$var_t] != @$_POST[$var_t])
					{
					if(@$_POST[$var_t]!="All")
						{
					$skip_row=1;
					continue;
						}
					}
				
				}
			}
		if($fld=="land_assets_id")
			{
			$td=" align='center'";
			$action_form="edit_form.php";
// 			if($level>4){$action_form="edit_form_test.php";}
			$add1="<form action='$action_form' method='post'>
			<input type='hidden' name='source' value='edit_county_display.php'>
			<input type='hidden' name='county_code' value='$county_code'>
			<input type='hidden' name='project_status' value='$project_status'>
			<input type='hidden' name='select_table' value='land_assets'>
			<input type='hidden' name='table_id' value='$value'>
			<input type='submit' name='submit_admin' value='Edit $value' style=\"background-color: #f3e6ff;\">
			</form>";
			$add2="<form action='view_form.php' method='post' target='_blank'>
			<input type='hidden' name='land_assets_id' value='$value'>
			<input type='hidden' name='select_table' value='land_assets'>
			<input type='submit' name='submit_admin' value='View $value' style=\"background-color: #e6ffcc;\">
			</form>";
			$value=$add1.$add2;
			}
		if($fld=="spo_landAsset_id_number")
			{
			$value="<a href='https://www.ncspo.com/FIS/dbLandAsset_public.aspx?LandAssetID=$value' target='_blank'>$value</a>";
			}
		
		if($fld=="consideration")
			{
			$value="$".number_format($value,2);
			}
		if($fld=="qc_spo" and $value=="Yes")
			{
			$value="<font color='green'><strong>$value</strong></font>";
			}
		if($fld=="spo_closed_number")
			{
			if($value==$ARRAY[$index]['spo_number'])
				{$value="<font color='green'><strong>$value</strong></font>";}
			}
		echo "<td$td>$value</td>";
		}
	echo "</tr>";
	}

echo "</table>";
// echo "</form>";

echo "</html>";

?>