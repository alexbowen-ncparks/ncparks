<?php
// echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
date_default_timezone_set('America/New_York');
$database="dpr_land"; 
$dbName="dpr_land";

include_once("../_base_top.php");
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

include("../../include/iConnect.inc"); // includes no_inject.php

if(@$_POST["submit_form"]=="Update")
	{
	include("display_data_action.php");
	}


echo "<div class='list'>";
echo "<table>
<tr>";

//"notes"=>"Notes", "political_info"=>"Political Info",  no separate tables - date fields in land_assets
//"balance"=>"Balance",  not used
$abstract_table_array=array("land_owner"=>"Owner Contact", "land_assets"=>"Data", "deed_history"=>"Deed History", "proposed_funding"=>"Proposed Funding", "funding"=>"Funding", "spo_milestones"=>"Milestones", "transactions"=>"Transactions", "fas_data"=>"FAS_Data", "documents"=>"Documents", "photos"=>"Photos", "associated_files"=>"Associated Files", "land_leases"=>"Leases"  );

foreach($abstract_table_array as $k=>$v)
	{
	echo "<td><form method='POST' action='edit_data_display.php'>
	<input type='hidden' name='select_table' value=\"$k\">
	<input type='submit' name='submit_form' value=\"$v\">
	</form></td>";
	}
echo "</tr>";
if(empty($var))
	{
	echo "<tr><th colspan='10'>Select an item to edit.</th></tr>";
	if(!empty($message))
		{
	echo "<tr><th colspan='10'>$message</th></tr>";}
	}

echo "</table>";
echo "</div>";

if(!empty($select_table))
	{
	$sql = "SELECT * FROM `edit_data_display` where select_table='$select_table'"; 
	$result = @mysqli_query($connection,$sql) or die("23 $sql Error 1#");
	if(mysqli_num_rows($result)<1)
		{
		echo "<p>The entries into the `edit_data_display` table that track the display of fields for table `$select_table` have not been completed.</p>"; 
		echo "<p>Add fields <a href='edit_data_display_manage.php?select_table=$select_table'>here</a></p>";
		exit;
		}
	$row=mysqli_fetch_assoc($result);
	extract($row);
	}


if(empty($select_table))
	{
	exit;
	}	
mysqli_select_db($connection,$dbName);
$sql = "SELECT * FROM edit_data_display where select_table='$select_table'";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_fields[]=$row;
	}
//  echo "<pre>"; print_r($ARRAY_fields); echo "</pre>";  exit;
	
// Form to add an item
echo "<script>
function all2yes() 
	{
	var group = document.getElementsByClassName(\"radiobtn\");
	for ( var i = 0; i < group.length; i++)
		{
		var x =document.getElementById(\"yes\"+String(i));
            	x.checked = true;	
		}
	}
function all2no() 
	{
	var group = document.getElementsByClassName(\"radiobtn\");
	for ( var i = 0; i < group.length; i++)
		{
		group.item(i).checked=true;
		}
	}
function all2blank() 
	{
	var group = document.getElementsByTagName(\"input\");
	for ( var i = 0; i < group.length; i++)
		{
		group.item(i).checked=\"\";
		}
	}

</script>
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

//  echo "<pre>"; print_r($ARRAY_fields); echo "</pre>";  exit;
echo "<input id=\"clickMe\" type=\"button\" value=\"Set all to No\" onclick=\"all2no();\" />";
echo "<input id=\"clickMe\" type=\"button\" value=\"Set all to Yes\" onclick=\"all2yes();\" />";
//echo "<input id=\"clickMe\" type=\"button\" value=\"Set all to Blank\" onclick=\"all2blank();\" />";
echo "<input type=button onClick=\"location.href='edit_data_display.php?select_table=$select_table'\" value='Reload Page'>";


echo "<form name='frm_display' action='edit_data_display.php' method='POST'>";
echo "<table class='alternate' border='1' cellpadding='3'><tr><td class='head' colspan='6'>Indicate which Fields to display when viewing <strong>$select_table</strong></td><td>

</td></tr>";
echo "<tr><th>table</th><th>field</th><th>Yes / No</th></tr>";
$i=0;
foreach($ARRAY_fields AS $index=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if(array_key_exists("field_name",$array)){$pass_field=$array['field_name'];}
 		if($fld=="show_field")
			{
			echo "<td>";
			$var_fld=$pass_field;
			$var_fld_id_1="yes".$i;
			$var_fld_id_2="no".$i;
			$i++;
			 if($value=="Yes"){$cky="checked";$ckn="";}else{$ckn="checked";$cky="";}
			echo "&nbsp;&nbsp;&nbsp;&nbsp;
			<input class='radio_btn' id='$var_fld_id_1' type='radio' name='$var_fld' value=\"Yes\" $cky>
			&nbsp;&nbsp;&nbsp;
			<input class='radiobtn' id='$var_fld_id_2' type='radio' name='$var_fld' value=\"No\" $ckn>";
			echo "</td>";
			continue;
			}
		
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}

echo "<tr><td colspan='4' align='center'>
<input type='hidden' name='pass_select_table' value=\"$select_table\">
<input type='hidden' name='select_table' value=\"edit_data_display\">
<input type='submit' name='submit_form' value=\"Update\">
</td></tr>";
echo "</table>";
echo "</form>";

echo "</html>";

?>