<?php
date_default_timezone_set('America/New_York');
$current_year=date("Y");

ini_set('display_errors',1);
if(empty($_SESSION))
	{
	session_start();
	$level=$_SESSION['system_plan']['level'];
	}
	
// if($_SESSION['system_plan']['level']<1)
// 	{echo "You must first login to the Division Personnel/Park Info <a href='/divper/'>database</a>.<br /><br />Select the Land Acreage option under the \"Contact Info\" pull-down.";}
// 	{echo "You must first login to the Division Personnel/Park Info <a href='/divper/'>database</a>.<br /><br />Select the Land Acreage option under the \"Contact Info\" pull-down.";}

$database="dpr_system";
include("../../include/iConnect.inc"); // database connection parameters

mysqli_select_db($connection,$database);
include("menu.php");

IF($_SERVER['PHP_SELF']=="/system_plan/acreage.php")
IF($_SERVER['PHP_SELF']=="/system_plan/acreage.php")
	{
	INCLUDE("test_acreage_year.php");
	exit;
	}
$fld_names=array("id"=>"id","unit_type"=>"Unit Type","sub_classification"=>"sub_classification","unit"=>"Unit","fee_simple_acres"=>"Fee Simple System area (acres)","conservation_easement_acres"=>"Conservation Easement (acres)","system_area_acres"=>"system area (acres)","system_length_miles"=>"system length (miles)","approximate_non_system_length_miles"=>"approximate non-system length (miles)","year"=>"year","month"=>"month","day"=>"day","includes_easement_acres"=>"includes easement acres","unsurveyed_estimate"=>"unsurveyed estimate","gis_estimate"=>"GIS estimate","unregistered_survey_estimate"=>"unregistered survey estimate","includes_scuppernong_river_acreage"=>"includes Scuppernong River acreage","land_area_only"=>"land area only","water_area_only"=>"water area only","undeveloped_unit"=>"undeveloped unit","conservation_fund_donation_estimate"=>"Conservation Fund Donation estimate","has_easements_along_river_(see_sr_section)"=>"has easements along river (see SR section)","operated_units"=>"operated units");

$name_unit_type=array("SL"=>"State Lake","SNA"=>"State Natural Area","SP"=>"State Park","SR"=>"State River","SRA"=>"State Recreation Area","ST"=>"State Trail");

$footnote_type=array("1"=>"includes_easement_acres","2"=>"unsurveyed_estimate","3"=>"includes_scuppernong_river_acreage","4"=>"land_area_only","5"=>"water_area_only","6"=>"undeveloped_unit","6"=>"conservation_fund_donation_estimate","7"=>"has_easements_along_river_(see_sr_section)");

// Get total system acres
$sql="SELECT unit, unit_code, year, concat(year, lpad(month,2,'0'), lpad(day,2,'0')) as max, 
sum(fee_simple_acres) as num_acres_fee_simple, 
sum(system_area_acres) as num_acres_system, 
sum(conservation_easement_acres) as num_acres_easement,
sum(system_length_miles) as num_system_length_miles
from acreage 
where 1 
group by unit_code,  max
order by unit, concat(year, lpad(month,2,'0'), lpad(day,2,'0')) desc
";
$result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$temp_array[]=$row;
	}

// echo "<pre>"; print_r($temp_array); echo "</pre>";  exit;
$test_year="";
$test_unit="";
$test_max=0;
// $test_unit_array_fee_simple=array();
// $test_unit_array_system=array();

foreach($temp_array as $index=>$array)
	{
	extract($array);
	if($test_year!=$year)
		{
		$test_unit_array_fee_simple[$year][$unit][$max]=$num_acres_fee_simple;
		$test_unit_array_easement[$year][$unit][$max]=$num_acres_easement;
		$test_unit_array_system[$year][$unit][$max]=$num_acres_system;
		$test_unit_array_system_miles[$year][$unit][$max]=$num_system_length_miles;
		}
	$test_year=$year;
	}
// echo "<pre>"; print_r($test_unit_array_fee_simple); echo "</pre>";  exit;
// echo "<pre>"; print_r($test_unit_array_easement); echo "</pre>";  exit;
// echo "<pre>"; print_r($test_unit_array_system); echo "</pre>";  exit;

$total_acres_fee_simple="";
$total_acres_easement="";
$total_acres_system="";
$total_acres_system_miles="";
foreach($test_unit_array_fee_simple as $year=>$array)
	{
// 	echo "<pre>"; print_r($array); echo "</pre>";  exit;
	foreach($array as $unit=>$array1)
		{
		foreach($array1 as $date=>$acres_fee_simple)
			{
			$year_acreage_fee[]=$year."*".$unit."*".$date."*".$acres_fee_simple;
			if($year==$current_year){$total_acres_fee_simple+=$acres_fee_simple;}
			}
		}
	}
	
foreach($test_unit_array_easement as $year=>$array)
	{
// 	echo "<pre>"; print_r($array); echo "</pre>";  exit;
	foreach($array as $unit=>$array1)
		{
		foreach($array1 as $date=>$acres_easement)
			{
			$year_acreage_easement[]=$year."*".$unit."*".$date."*".$acres_easement;
			if($year==$current_year){$total_acres_easement+=$acres_easement;}
			}
		}
	}
// echo "<pre>"; print_r($year_acreage_easement); echo "</pre>";  exit;	
foreach($test_unit_array_system as $year=>$array)
	{
// 	echo "<pre>"; print_r($array); echo "</pre>";  exit;
	foreach($array as $unit=>$array1)
		{
		foreach($array1 as $date=>$acres_system)
			{
			$year_acreage_system[]=$year."*".$unit."*".$date."*".$acres_system;
			if($year==$current_year){$total_acres_system+=$acres_system;}
			}
		}
	}
// echo "$total_acres_fee_simple <pre>"; print_r($year_acreage); echo "</pre>";  exit;

foreach($test_unit_array_system_miles as $year=>$array)
	{
// 	echo "<pre>"; print_r($array); echo "</pre>";  exit;
	foreach($array as $unit=>$array1)
		{
		foreach($array1 as $date=>$miles_system)
			{
			$year_acreage_system_miles[]=$year."*".$unit."*".$date."*".$miles_system;
			if($year==$current_year){$total_acres_system_miles+=$miles_system;}
			}
		}
	}

$clause="where 1";
if(!empty($_POST))
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	unset($ARRAY);
	foreach($_POST as $fld=>$value)
		{
		if(empty($value)){continue;}
		if($fld=="year" and $value=="All"){continue;}
		$pass_value[$fld]=$value;
		$temp[]="$fld='$value'";
		}
	if(empty($year))
		{
		$clause.=" and year='$current_year'";
		}
	if(!empty($temp))
		{$clause.=" and ".implode(" and ",$temp);}
	
	$sql="SELECT  acreage.*, lpad(month,2,'0') as month, lpad(day,2,'0') as day  from acreage $clause
	order by unit, year desc, month desc, day desc
	";
	$result = @mysqli_QUERY($connection,$sql);
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
// 	echo "s49=$sql";
	}
	else
	{
	$sql="SELECT *, lpad(month,2,'0') as month, lpad(day,2,'0') as day from acreage where 1 order by unit limit 1";
	$result = @mysqli_QUERY($connection,$sql);
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
// 	echo "s58=$sql";
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

$select_array=array("unit_type","sub_classification","unit","unit_code","year");

foreach($select_array as $k=>$v)
	{
	$var="ARRAY_".$v;
	$sql="SELECT distinct $v as $var from acreage 
	$clause
	order by $v";
	$result = @mysqli_QUERY($connection,$sql);
	$var1=array();
	while($row=mysqli_fetch_assoc($result))
		{
		$var1[]=$row[$var];
		}
	${$var}=$var1;
	}

$ARRAY_year[]="All";
$tot_fee_simple=0;
$tot_easement=0;
$tot_system_acres=0;
$tot_system_miles=0;
$check_fsa_date=array();
$check_cea_date=array();
$check_saa_date=array();
$check_slm_date=array();

$river_array=array("Natural River","Scenic River","Recreational River");

$skip=array("num_acres_fee_simple");
$c=count($ARRAY);
echo "<form method='POST'><table id='acreage'>";
if($c>1){echo "<tr><td colspan='3'>$c records</td></tr>";}

foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			if(in_array($fld, $select_array))
				{
				if(is_array(${"ARRAY_".$fld}))
					{
					$drop_down_array=${"ARRAY_".$fld};
					
					if($fld=="year"){$drop_down_array=array_reverse($drop_down_array);}
					echo "<th>$fld<select name='$fld' onchange=\"this.form.submit()\"><option value=\"\"></option>\n";
					foreach($drop_down_array as $k=>$v)
						{
						if(isset($pass_value))
							{
							$test=stripslashes($pass_value[$fld]);
							if($test==$v){$s="selected";}else{$s="";}
							}
						$v_name=$v;
						if($fld=="unit_type")
							{
							$drop_down_name_array=${"name_".$fld};
							$v_name=$v."-".$drop_down_name_array[$v];
							}
							
						echo "<option value=\"$v\" $s>$v_name</option>\n";
						}
					echo "</select></th>";
					}
				}
				else
				{
				$var_fld=$fld_names[$fld];
				echo "<th>$var_fld</th>";
				}
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(empty($_REQUEST))  // default display when first hitting page
			{
			echo "<td colspan='5' style='text-align: center;'>".number_format($total_acres_fee_simple,3)." fee simple acres</td>";
			echo "<td colspan='2' style='text-align: center;'>".number_format($total_acres_easement,3)." easement acres</td>";
			echo "<td colspan='5' style='text-align: center;'>".number_format($total_acres_system,3)." system acres (includes state lake acreage)</td>";
			echo "<td colspan='6' style='text-align: center;'>".number_format($total_acres_system_miles,3)." system miles</td>";
			
			echo "</tr>";
			foreach($year_acreage_fee as $index=>$array_year_park)
				{
				$exp_fee=explode("*", $array_year_park);
				$exp_easement=explode("*", $year_acreage_easement[$index]);
				$exp_system=explode("*", $year_acreage_system[$index]);
				$exp_system_miles=explode("*", $year_acreage_system_miles[$index]);
				if($exp_fee[0]<$current_year)
					{continue;}
				if ( strpos( $exp_fee[3], "." ) !== false )
					{
					$nf_fee=number_format($exp_fee[3], 3);
					}
					else
					{
					$nf_fee=number_format($exp_fee[3]);
					}
				$nf_easement="";
				if($exp_easement[3]>0)
					{
					$nf_easement="(easement $exp_easement[3])";
					}
				if ( strpos( $exp_system[3], "." ) !== false )
					{
					$nf_system="(system ".number_format($exp_system[3], 3).")";
					}
					else
					{
					$nf_system="(system ".number_format($exp_system[3]).")";
					}
				if($exp_system[3]==$exp_fee[3]){$nf_system="";}
				
				if ( strpos( $exp_system_miles[3], "." ) !== false )
					{
					$nf_system_miles="(system miles ".number_format($exp_system_miles[3], 3).")";
					}
					else
					{
					$nf_system_miles="(system miles ".number_format($exp_system_miles[3]).")";
					}
				if($exp_system_miles[3]==0){$nf_system_miles="";}
				echo "<tr><td colspan='6'>$exp_fee[0] $exp_fee[1] $exp_fee[2] - (fee simple $nf_fee)  $nf_easement $nf_system $nf_system_miles</td></tr><tr>";
				}
			exit;
			}
			
// display after making a selection
		if(in_array($fld,$skip)){continue;}
		$temp_value=$value;
		if(empty($check_fsa_date[$array['unit']])){$check_fsa_date[$array['unit']]="";}
		if(empty($check_cea_date[$array['unit']])){$check_cea_date[$array['unit']]="";}
		if(empty($check_saa_date[$array['unit']])){$check_saa_date[$array['unit']]="";}
		if(empty($check_slm_date[$array['unit']])){$check_slm_date[$array['unit']]="";}
		if(strpos($fld, "acres")>-1 or strpos($fld, "miles")>-1)
			{
			if($fld=="fee_simple_acres")
				{
				if($array['year'].$array['month'].$array['day']>$check_fsa_date[$array['unit']])
					{
					$tot_fee_simple+=$value;
					}
				$check_fsa_date[$array['unit']]=$array['year'].$array['month'].$array['day'];
				}
			if($fld=="conservation_easement_acres")
				{
				if($array['year'].$array['month'].$array['day']>$check_cea_date[$array['unit']])
					{
					$tot_easement+=$value;
					}
				$check_cea_date[$array['unit']]=$array['year'].$array['month'].$array['day'];
				}
			if($fld=="system_area_acres")
				{
				if($array['year'].$array['month'].$array['day']>$check_saa_date[$array['unit']])
					{
					$tot_system_acres+=$value;
					}
				$check_saa_date[$array['unit']]=$array['year'].$array['month'].$array['day'];
				}
			if($fld=="system_length_miles")
				{
				if($array['sub_classification'].$array['year'].$array['month'].$array['day']>$check_slm_date[$array['unit']].$array['sub_classification'])
					{
					$tot_system_miles+=$value;
					}
				if(in_array($array['sub_classification'], $river_array))
					{
					$check_slm_date[$array['unit']].$array['sub_classification']=$array['sub_classification'].$array['year'].$array['month'].$array['day'];
					}
				}
			
			if(is_float($value+0))
				{
				$temp_value=number_format(($value+0),3);
				}
				else
				{
// 				$temp_value=number_format(($value+0));
				$temp_value=$value;
				}
			}
		
		if($fld=="id" and $level>3)
			{
			$temp_value="<a href='edit.php?id=$value'>$value</a>";
			}
		echo "<td>$temp_value</td>";
		}
	echo "</tr>";
	}
if(!empty($_POST['year']))
	{
	if ( strpos( $tot_fee_simple, "." ) !== false )
		{
		$tot_fee_simple=number_format($tot_fee_simple, 3);
		}
	if ( strpos( $tot_easement, "." ) !== false )
		{
		$tot_easement=number_format($tot_easement, 3);
		}
	if ( strpos( $tot_system_acres, "." ) !== false )
		{
		$tot_system_acres=number_format($tot_system_acres, 3);
		}
	if ( strpos( $tot_system_miles, "." ) !== false )
		{
		$tot_system_miles=number_format($tot_system_miles, 3);
		}
	echo "<tr style='background-color:#cccc00'><td colspan='10' style='text-align:right'>$tot_fee_simple</td>
	<td style='text-align:right'>$tot_easement</td>
	<td style='text-align:right'>$tot_system_acres</td>
	<td style='text-align:right'>$tot_system_miles</td>
	</tr>";
	}
echo "</table></form>";