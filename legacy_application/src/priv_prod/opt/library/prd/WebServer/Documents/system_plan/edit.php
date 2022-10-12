<?php
date_default_timezone_set('America/New_York');
$current_year=date("Y");

ini_set('display_errors',1);
if(empty($_SESSION))
	{
	session_start();
	$level=$_SESSION['system_plan']['level'];
	}
	
if($level<1)
	{echo "You must first login to the System Plan <a href='https://10.35.152.9/system_plan/'>database</a>.<br /><br />Select the System Acreage option in pull-down.";
	{echo "You must first login to the System Plan <a href='https://10.35.152.9/system_plan/'>database</a>.<br /><br />Select the System Acreage option in pull-down.";
	exit;
	}

$database="dpr_system";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

// 	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;

if(!empty($submit_form))
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
	$skip_update=array("id","submit_form");
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld,$skip_update)){continue;}
// 		if($fld=="system_area_acres" and ($_POST['unit_type']!="SL" AND $_POST['unit_type']!="ST"))
		if($fld=="system_area_acres" and $_POST['unit_type']!="SL" )
			{
			$temp[]="$fld='".($_POST['fee_simple_acres']+$_POST['conservation_easement_acres'])."'";
			continue;
			}
		$temp[]="$fld='$val'";
		}
// 	echo "<pre>"; print_r($temp); echo "</pre>"; // exit;
	$clause=implode(",",$temp);
	$sql="UPDATE acreage
	set $clause
	where id='$id'
	";
// 	echo "$sql"; exit;
	$result = @mysqli_QUERY($connection,$sql);
	}
include("menu.php");

// Get total system acres
$sql="SELECT *
from acreage 
where 1 and id='$id'
";
$result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$readonly=array("id","year","month","day","unit_code","unit","unit_type","classification","sub_classification");
// $drop_down=array("unit_type");
$radio_array=array("land_area_only","water_area_only","undeveloped_unit","operated_units","has_easements_along_river","conservation_fund_donation_estimate","includes_scuppernong_river_acreage","unregistered_survey_estimate","gis_estimate","unsurveyed_estimate","includes_easement_acres");

$yes_no=array("yes","no");

$unit_code=$ARRAY[0]['unit_code'];
$unit_type=$ARRAY[0]['unit_type'];
// echo "u=$unit_code";
echo "<form action=\"acreage.php\" method=\"post\" id=\"form1\">";
if(!empty($year))
	{
	echo "<input type=\"hidden\" name=\"year\" value='$year'>";
	}
if(!empty($month))
	{
	echo "<input type=\"hidden\" name=\"month\" value='$month'>";
	}
echo "<input type=\"hidden\" name=\"unit_type\" value='$unit_type'>
<input type=\"hidden\" name=\"unit_code\" value='$unit_code'>
<br />
</form>";

echo "<form method='POST' action='edit.php'>
<table id='acreage_edit' class=\"center\">
<tr><th>Field</th><th>Value</th>
<th><button type='submit' form='form1' value='Submit'>Return</button></th>";

echo "</tr>";
foreach($ARRAY AS $index=>$array)
	{

	foreach($array as $fld=>$value)
		{
		$ro="";
		$RO="";
		if(in_array($fld,$readonly))
			{
			$ro="readonly";
			$RO="<font size='-2'>readonly</font>";
			}
// 		if(in_array($fld, $drop_down_array))
// 			{
// 			$dd_array=${"name_".$fld};
// 			echo "<tr><td>$fld</td>";
// 			echo "<td><select name='$fld'><option value=\"\" selected></option>\n";
// 			foreach($dd_array as $k=>$v)
// 				{
// 				if($value==$k){$s="selected";}else{$s="";}
// 				echo "<option value='$k' $s>$k</option>\n";
// 				}
// 			echo "</select></td>";
// 			continue;
// 			}

		if(in_array($fld, $radio_array))
			{
			$dd_array=$yes_no;
			echo "<tr><td>$fld</td>";
			echo "<td>";
			foreach($dd_array as $k=>$v)
				{
				if($value==$v){$ck="checked";}else{$ck="";}
				echo "$v<input type='radio' name='$fld' value=\"$v\" $ck>";
				}
			echo "</td>";
			continue;
			}
// 		if($fld=="system_area_acres" and $array['unit_type']!="SL"  and $array['unit_type']!="ST")
		if($fld=="system_area_acres" and $array['unit_type']!="SL")
			{
			$value=$array['fee_simple_acres']+$array['conservation_easement_acres'];
			}
		echo "<tr><td>$fld $RO</td>
		<td>
		<input type='text' name='$fld' value=\"$value\" $ro>
		</td></tr>";
		}
	}
echo "<tr><th colspan='2'>
<input type='hidden' name='id' value=\"$id\">
<input type='submit' name='submit_form' value=\"Update\"> ".$ARRAY[0]['unit']."
</th></tr>";
echo "</table></html>";