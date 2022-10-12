<?php

if(empty($connection))
	{

	date_default_timezone_set('America/New_York');
	$current_year=date("Y");
	$current_month=date("m");

	ini_set('display_errors',1);
	if(empty($_SESSION))
		{
		session_start();
		$level=$_SESSION['system_plan']['level'];
		}

	$database="dpr_system";

	if($level<1)
		{
		echo "You must first login to the System Plan <a href='https://auth1.dpr.ncparks.gov/system_plan/index.html'>database</a>.<br /><br />Select the System Acreage option in the pull-down.";
		exit;
		}

	include("../../include/iConnect.inc"); // database connection parameters

	mysqli_select_db($connection,$database);
	}
	
if(!empty($submit_form))
	{
	if(empty($new_month ) or empty($new_day)){exit;}
	// make backup
	$new_table="acreage_".date("Y_m_d")."_".time(); //echo "$new_table";
	$sql="CREATE table $new_table SELECT * FROM acreage";
	$result = @mysqli_QUERY($connection,$sql);
	
// echo "<pre>"; print_r($_POST); echo "</pre>";
$where="year='$previous_year' and month='$new_month' and day='01'";
$where="concat('year','month','day') >= $current_year$new_month$new_day";

	if($new_month=="01")
		{
		$new_month="07";
		}
	$sql="INSERT INTO `acreage`( `year`,`month`,`day`, `unit_code`, `unit`, `unit_type`, `sub_classification`, `operated_units`, `fee_simple_acres`, `conservation_easement_acres`, `system_area_acres`, `system_length_miles`, `approximate_non_system_length_miles`, `includes_easement_acres`, `unsurveyed_estimate`, `gis_estimate`, `unregistered_survey_estimate`, `includes_scuppernong_river_acreage`, `land_area_only`, `water_area_only`, `undeveloped_unit`, `conservation_fund_donation_estimate`, `has_easements_along_river`) 
	SELECT  '$current_year', '$new_month', '$new_day', `unit_code`, `unit`, `unit_type`, `sub_classification`, `operated_units`, `fee_simple_acres`, `conservation_easement_acres`, `system_area_acres`, `system_length_miles`, `approximate_non_system_length_miles`, `includes_easement_acres`, `unsurveyed_estimate`, `gis_estimate`, `unregistered_survey_estimate`, `includes_scuppernong_river_acreage`, `land_area_only`, `water_area_only`, `undeveloped_unit`, `conservation_fund_donation_estimate`, `has_easements_along_river`
	FROM acreage
	where $where";
	
	echo "<br />$sql"; exit;
	
	$result = @mysqli_QUERY($connection,$sql);
	}
	
$sql="SELECT year, unit_code, concat(year, lpad(month,2,'0'), lpad(day,2,'0')) as max
from acreage 
where 1 
group by max
order by concat(year, lpad(month,2,'0'), lpad(day,2,'0')) desc
limit 1
";
// echo "$sql";
$result = @mysqli_QUERY($connection,$sql);

while($row=mysqli_fetch_assoc($result))
	{
	$temp_array[]=$row;
	}
echo "<a href='acreage.php'>Return</a><br /><br />";

$temp=$temp_array[0]['max'];
$previous_year=substr($temp,0,4);
$max=substr($temp,0,4)."-".substr($temp,4,2)."-".substr($temp,6,2);
$current_date=date("Y-m-d");
if($current_date<$max)
	{
	echo "Current date is less than ".$current_year."-07-01 then copy all records for ".$previous_year." to  $current_year-01-01. DOUBLE CHECK THIS BEFORE SUBMITTING.";
	echo "<form method='POST'>";
	echo "<table>
	<tr><th>Max $max</th></tr>
	<tr><td>Current Year<br /><input type='text' name='current_year' value=\"$current_year\"></td>
	<td> New Month<br /><input type='text' name='new_month' value=\"01\"></td>
	<td>New Day<br /><input type='text' name='new_day' value=\"01\" readonly></td></tr>
	<tr><td>$current_year</td><td>01</td><td>01</td></tr>
	<tr><td>
	<input type='hidden' name='previous_year' value=\"$previous_year\">
	<input type='submit' name='submit_form' value=\"Submit\">
	</td></tr>
	</table>";
	echo "</form>";

	}

if($current_date>$max)
	{
echo "Current date is greater than ".$current_year."-07-01. Copy all records for ".$previous_year." to  $current_year-07-01. DOUBLE CHECK THIS BEFORE SUBMITTING";
echo "<form method='POST'>";
echo "<table>
<tr><th>Max $max</th></tr>
<tr><td>Current Year<br /><input type='text' name='current_year' value=\"$current_year\"></td>
<td> New Month<br /><input type='text' name='new_month' value=\"01\"></td>
<td>New Day<br /><input type='text' name='new_day' value=\"01\" readonly></td></tr>
<tr><td>$current_year</td><td>01</td><td>01</td></tr>
<tr><td>
<input type='hidden' name='previous_year' value=\"$previous_year\">
<input type='submit' name='submit_form' value=\"Submit\">
</td></tr>
</table>";
echo "</form>";

	}
?>