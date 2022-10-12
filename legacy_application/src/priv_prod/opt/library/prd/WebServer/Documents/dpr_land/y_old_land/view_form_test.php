<?php

date_default_timezone_set('America/New_York');
$database="dpr_land"; 
$dbName="dpr_land";

include_once("../_base_top.php");
echo "
<style>
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
 
 table.alternate tr:nth-child(odd) td{
background-color: #fff2e6;
}
table.alternate tr:nth-child(even) td{
background-color: #ffffff;
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
 </style>
 ";

if($level<1){exit;}

if($level>4)
	{
//  	echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
	}

IF(empty($connection))
	{
	include("../../include/iConnect.inc");
	}
	else
	{
	// when updating by_pass iConnect
	include("../no_inject_i.php");
	}

$sql="SELECT t1.*, t2.park_abbreviation, t2.park_name, t3.county_name, t4.project_status, t5.land_interest_type, t6.acquisition_justification as 'primary', t7.acquisition_justification as 'secondary', t8.description as 'priority', t9.classification
from land_assets as t1
left join park_name as t2 on t1.park_id=t2.park_id
left join county_name as t3 on t1.county_id=t3.county_id
left join project_status as t4 on t1.project_status_id=t4.project_status_id
left join land_interest_type as t5 on t1.land_interest_id=t5.land_interest_type_id
left join acquisition_justification as t6 on t1.acquisition_justification_id_primary=t6.acquisition_justification_id
left join acquisition_justification as t7 on t1.acquisition_justification_id_secondary=t7.acquisition_justification_id
left join priority as t8 on t1.priority_id=t8.priority_id
left join park_classification as t9 on t1.park_classification_id=t9.park_classification_id
WHERE t1.land_assets_id='$land_assets_id'"; //ECHO "$sql<br />"; //exit;

$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$row=mysqli_fetch_assoc($result);
extract($row);
$file_number=$park_abbreviation."-".$county_id."-".$land_assets_id;
foreach($row as $fld=>$val)
	{
	if(substr($fld,-3,3)=="_id")
		{
		$ARRAY_id[$fld]=$val;
		}
	}
	// echo "<pre>"; print_r($ARRAY_id); echo "</pre>";  exit;
	

//  echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;	
if(!empty($submit_form))
	{
	include("view_action.php");
	}
//  echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

echo "<div>";
echo "<table class='list' border='1' cellpadding='3'>
<tr><td align='center' colspan='11'><font size='5' color='#cc00cc'>File Number: $file_number for $park_name </td></tr>
<tr>
<td>Project Status:<br /><strong>$project_status</strong></td>
<td>County:<br /><strong>$county_name</strong></td>
<td>Interest:<br /><strong>$land_interest_type</strong></td>
<td>Primary:<br /><strong>$primary</strong></td>
<td>Secondary:<br /><strong>$secondary</strong></td>
<td>Priority:<br /><strong>$priority</strong></td>
<td>Classification:<br /><strong>$classification</strong></td>
<td>Critical:<br /><strong>$critical</strong></td>
<td>Payments Complete:<br /><strong>table not loaded</strong></td>
</tr></table>

<table><tr>";
// "political_info"=>"Political Info", 
$abstract_table_array=array("land_owner"=>"Owner Contact", "land_assets"=>"Data", "deed_history"=>"Deed History", "proposed_funding"=>"Proposed Funding", "funding"=>"Funding", "spo_milestones"=>"Milestones", "transactions"=>"Transactions", "fas_data"=>"FAS_Data", "documents"=>"Documents", "photos"=>"Photos", "notes"=>"Notes", "balance"=>"Balance", "associated_files"=>"Associated Files" );


foreach($abstract_table_array as $k=>$v)
	{
	echo "<td><form method='POST' action='view_form_test.php'>
	<input type='hidden' name='var' value=\"$k\">
	<input type='hidden' name='land_assets_id' value=\"$land_assets_id\">";
	if(!empty($edit))
		{
		echo "
		<input type='hidden' name='edit' value=\"$edit\">";
		}
	echo "<input type='submit' name='submit_form' value=\"$v\">
	</form></td>";
	
	}


echo "</tr>";
if(empty($var))
	{
	echo "<tr><th colspan='10'>Select an item to view.</th></tr>";
	exit;
	}
if(!empty($message))
	{
	echo "<tr><th colspan='10'>$message</th></tr>";
	exit;
	}

echo "</table>";
echo "</div>";

if(empty($edit)){$edit="";}
$pass_var=$var;
$dollar_format_array=array("list_price", "option_price", "estimated_purchase_price", "consideration", "actual_award", "reimbursement_amount", "inv_amount_loi", "inv_amount_not_loi", "fas_value");

//     , "land_owner_affiliation_id"
$select_array=array("project_status", "classification", "acquisition_justification_primary", "acquisition_justification_secondary", "river_basin", "priority", "critical");
// select arrays created in sql_$var.php  e.g., sql_land_assets.php

//  echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
if(!empty($ARRAY))
	{
	$skip=array();
	$c=count($ARRAY);
	$i=0;
	
	$edit_array=array("Howard6319","Carter5486","carter5486");
	$edit_table_array=array("land_assets","land_owner");
	IF($edit==1 and in_array($var,$edit_table_array) and in_array($_SESSION['dpr_land']['tempID'],$edit_array))
		{
		$action="update_".$var.".php";
		echo "$action<form action='$action' method='POST'>";
		}
	echo "<table class='table' border='1' cellpadding='5'><tr><td colspan='2'></td></tr>";
	foreach($ARRAY AS $index=>$array)
		{
		$item=$index+1;
		echo "<tr><td colspan='2' bgcolor='yellow'><strong>$submit_form</strong> Item $item</td></tr>";
		foreach($array as $fld=>$value)
			{
			$i++;
			fmod($i,2)!=0?$tr="class='d0'":$tr="";
			echo "<tr $tr>";
			if(in_array($fld,$skip)){continue;}
			$display_value=$value;
			if(in_array($fld, $dollar_format_array) and !empty($value))
				{
				$display_value="$".number_format($value,2);
				}
			echo "<td>$fld</td><td><strong>$display_value</strong></td>";
			
		IF($edit==1 and in_array($var,$edit_table_array) and in_array($_SESSION['dpr_land']['tempID'],$edit_array))
				{
				include("read_only.php");
				if(in_array($fld, $read_only_array))
					{$ro="readonly";}else{$ro="";}
				$var_display="<td>
				<input type='text' name='$fld' value=\"$value\" size='30' $ro> $ro
				</td>";

// select arrays created in sql_$var.php  e.g., sql_land_assets.php
// $switch_select created in sql_$var.php
	if(empty($switch_select))
		{$switch_select=array();}

				if(in_array($fld,$select_array))
					{
					if($fld=="critical")  // binary NULL or 1
						{					
						$critical_array=array("1"=>"Critical");
						if($value==1){$value="Critical";} // no conversion in the query
						}
					$var_display="<td><select name='$fld'><option value=\"\" selected></option>\n";
					foreach(${$fld."_array"} as $k=>$v)
						{
						$ck_select=$v;
						if(in_array($fld, $switch_select))
							{
							$ck_select=$k;
							}
						if($value==$ck_select){$s="selected";}else{$s="";}
						$var_display.="<option value='$k' $s>$v</option>\n";
						}
					$var_display.="</select></td>";
					}
				echo "$var_display";
				}
			echo "</tr>";
			}
		
		IF($edit==1 and in_array($pass_var,$edit_table_array) and in_array($_SESSION['dpr_land']['tempID'],$edit_array))
			{
			echo "<tr><td colspan='3' align='center'>
			<input type='hidden' name='land_assets_id' value=\"$land_assets_id\">
			<input type='submit' name='submit_form' value=\"Update\">
			</td></tr></table><table>
			</form>";
			}
		}
	$limit_fields_array=array("land_assets","land_owner","transactions");
	if(empty($show_all) and in_array($pass_var,$limit_fields_array))
		{
		echo "<tr><td colspan='2' align='center'><form method='POST' action='view_form_test.php'>
		<input type='hidden' name='show_all' value=\"all\">
		<input type='hidden' name='var' value=\"$pass_var\">";
	
	//$edit_array=array("Howard6319","Carter5486");
	IF($edit==1 and in_array($var,$edit_table_array) and in_array($_SESSION['dpr_land']['tempID'],$edit_array))
		{
		echo "<input type='hidden' name='edit' value=\"$edit\">";
		}
		echo "<input type='hidden' name='land_assets_id' value=\"$land_assets_id\">
		<input type='submit' name='submit_form' value=\"Show All Fields\">
		</form></td></tr>";
		}
	echo "</table>";
	}
	else
	{
	echo "No $var record for land_assets_id $land_assets_id.";
	}

?>