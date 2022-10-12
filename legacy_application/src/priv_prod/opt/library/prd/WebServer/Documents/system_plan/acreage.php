<?php
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

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
include("menu.php");

if(!empty($_POST))
	{
// 	echo "<button style='color: green; font-size: 16px;' type='submit' form='form1' value='Submit'>System Table</button>";
	}

if(!empty($_SESSION[$database]['highest_year']))
	{
	$highest_year=$_SESSION[$database]['highest_year'];
	}
	else
	{
	$_SESSION[$database]['highest_year']=$current_year;
	$highest_year=$current_year;
	}
// echo "H $highest_year C $current_year";
if($highest_year<$current_year)
	{
	if($level<5)
		{
		echo "Database needs to be updated for new year."; 
		exit;
		}
	$sql = "SELECT concat(year,'-',month,'-',day) as test FROM acreage 
	group by concat(year,month,day) order by concat(year,month,day) desc limit 1";
	$result = @mysqli_query($connection,$sql) or die("26 $sql Error");
	$row=mysqli_fetch_assoc($result);
	$test=$row['test'];
	$exp=explode("-",$test);
	$sql = "SELECT * FROM acreage 
	where year='$exp[0]' and month='$exp[1]' and day='$exp[2]'";
	$result = @mysqli_query($connection,$sql) or die("26 $sql Error");
	while($row=mysqli_fetch_assoc($result))
		{$test_ARRAY[]=$row;}
	$c=count($test_ARRAY);
	echo "$c<pre>"; print_r($test_ARRAY); echo "</pre>";  exit;
	$skip_flds=array("id");
	foreach($test_ARRAY as $index=>$array)
		{
		$temp=array();
		foreach($array as $fld=>$val)
			{
			if(in_array($fld,  $skip_flds)){continue;}
			if($fld=="year"){$val=$current_year;}
			if($fld=="month"){$val=1;}
			if($fld=="day"){$val=1;}
			$val=mysqli_real_escape_string($connection, $val);
			$temp[]="$fld='$val'";
			}
		$clause=implode(", ",$temp);
		$sql="INSERT into acreage set $clause";
// 		echo "$index $sql<br /><br />"; 
// 		exit;
		$result = @mysqli_query($connection,$sql) or die("53 $sql Error");
		}
	unset($test_ARRAY);
	unset($temp);
	$_SESSION[$database]['highest_year']=$current_year;
// 	exit;
	}

// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
// echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
// IF($_SERVER['PHP_SELF']=="/system_plan/acreage.php")
// 	{
// 	INCLUDE("test_acreage_year.php");
// 	exit;
// 	}
$fld_names=array("id"=>"id","unit_type"=>"Unit Type","sub_classification"=>"sub_classification", "unit"=>"Unit","unit_code"=>"Unit Code","fee_simple_acres"=>"Fee Simple System Area (acres)","conservation_easement_acres"=>"Conservation Easement (acres)","system_area_acres"=>"System Area (acres)","system_length_miles"=>"System Length (miles)","approximate_non_system_length_miles"=>"approximate non-system length (miles)","year"=>"year","month"=>"month","day"=>"day","includes_easement_acres"=>"includes easement acres","unsurveyed_estimate"=>"unsurveyed estimate","gis_estimate"=>"GIS estimate","unregistered_survey_estimate"=>"unregistered survey estimate","includes_scuppernong_river_acreage"=>"includes Scuppernong River acreage","land_area_only"=>"land area only","water_area_only"=>"water area only","undeveloped_unit"=>"undeveloped unit","conservation_fund_donation_estimate"=>"Conservation Fund Donation estimate","has_easements_along_river"=>"has easements along river (see SR section)","operated_units"=>"operated units");

// also in system_summary.php
$name_unit_type=array("SL"=>"State Lake","SNA"=>"State Natural Area","SP"=>"State Park","SR"=>"State River","SRA"=>"State Recreation Area","ST"=>"State Trail");

$footnote_type=array("1"=>"includes_easement_acres","2"=>"unsurveyed_estimate","3"=>"gis_estimate","4"=>"unregistered_survey_estimate","5"=>"includes_scuppernong_river_acreage","6"=>"land_area_only","7"=>"water_area_only","8"=>"undeveloped_unit","9"=>"conservation_fund_donation_estimate","10"=>"has_easements_along_river");

// Get total system acres
$sql="SELECT unit, unit_code, year, concat(year, lpad(month,2,'0'), lpad(day,2,'0')) as max, 
sum(fee_simple_acres) as num_acres_fee_simple, 
sum(system_area_acres) as num_acres_system, 
sum(conservation_easement_acres) as num_acres_easement,
sum(system_length_miles) as num_system_length_miles,
sum(approximate_non_system_length_miles) as num_non_system_length_miles
from acreage 
where 1 and year='$current_year'
group by unit_code,  max
order by unit, concat(year, lpad(month,2,'0'), lpad(day,2,'0')) desc
";
$result = @mysqli_QUERY($connection,$sql);
if(mysqli_num_rows($result)<1)
	{
	echo "The system has not been updated for $current_year."; 
	include("acreage_semi_annual_update.php");
	exit;
	}
while($row=mysqli_fetch_assoc($result))
	{
	$temp_array[]=$row;
	}
$num_units=count($temp_array);
// echo "$sql<pre>"; print_r($temp_array); echo "</pre>";  exit;
$test_year="";
$test_unit="";
$test_max=0;
// $test_unit_array_fee_simple=array();
// $test_unit_array_system=array();

foreach($temp_array as $index=>$array)
	{
	extract($array);
	if($current_year==$year)
		{
		$test_unit_array_fee_simple[$year][$unit][$max]=$num_acres_fee_simple;
		$test_unit_array_easement[$year][$unit][$max]=$num_acres_easement;
		$test_unit_array_system[$year][$unit][$max]=$num_acres_system;
		$test_unit_array_system_miles[$year][$unit][$max]=$num_system_length_miles;
		$test_unit_array_non_system_miles[$year][$unit][$max]=$num_non_system_length_miles;
		}
	$test_year=$year;
	}
// echo "<pre>"; print_r($test_unit_array_fee_simple); echo "</pre>";  exit;
// echo "<pre>"; print_r($test_unit_array_easement); echo "</pre>";  exit;
// echo "<pre>"; print_r($test_unit_array_system); echo "</pre>";  exit;

$total_acres_fee_simple=0;
$total_acres_easement=0;
$total_acres_system=0;
$total_acres_system_miles=0;
$total_acres_non_system_miles=0;

$start_cal_year=date('Y')."0101";
foreach($test_unit_array_fee_simple as $year=>$array)
	{
// 	echo "<pre>"; print_r($array); echo "</pre>";  exit;
	foreach($array as $unit=>$array1)
		{
		foreach($array1 as $date=>$acres_fee_simple)
			{
// 			if($date=="20200101")
			if($date==$start_cal_year)
				{
				$year_acreage_fee[]=$year."*".$unit."*".$date."*".$acres_fee_simple;
				$test_acreage_fee[$unit]=number_format($acres_fee_simple,0);
				if($year==$current_year){$total_acres_fee_simple+=$acres_fee_simple;}
				}
			}
		}
// 	echo "<pre>"; print_r($year_acreage_fee); echo "</pre>";  exit;
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

foreach($test_unit_array_non_system_miles as $year=>$array)
	{
// 	echo "<pre>"; print_r($array); echo "</pre>";  exit;
	foreach($array as $unit=>$array1)
		{
		foreach($array1 as $date=>$miles_non_system)
			{
			$year_acreage_non_system_miles[]=$year."*".$unit."*".$date."*".$miles_non_system;
			if($year==$current_year){$total_acres_non_system_miles+=$miles_non_system;}
			}
		}
	}
	
$clause="where 1";
if(!empty($_POST))
	{
// 	echo "212<pre>"; print_r($_POST); echo "</pre>"; // exit;
	unset($ARRAY);
	foreach($_POST as $fld=>$value)
		{
		if(empty($value)){continue;}
		if($fld=="year" and $value=="All"){continue;}
// 		$value=addslashes($value);
		$pass_value[$fld]=$value;
		$temp[]="$fld='$value'";
		}
	if(empty($year))
		{
		$clause.=" and year='$current_year'";
		}
	if(!empty($temp))
		{$clause.=" and ".implode(" and ",$temp);}
// 	echo "$clause"; 
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
// echo "$sql <pre>"; print_r($ARRAY); echo "</pre>"; // exit;

$select_array=array("unit_type","sub_classification","unit","unit_code","year","month","operated_units");

foreach($select_array as $k=>$v)
	{
	$var="ARRAY_".$v;
	if(in_array($v, $select_array)){$clause="where 1";}
	if($v=="month")
		{
		if(empty($_POST['year'])){$m_year=$year;}else{$m_year=$_POST['year'];}
		$clause.=" and year='$m_year'";
		}
		
	$sql="SELECT distinct $v as $var from acreage 
	$clause
	order by $v";
	$result = @mysqli_QUERY($connection,$sql);
// 	echo "$sql $clause</br>"; 
	$var1=array();
	while($row=mysqli_fetch_assoc($result))
		{
		if($v=="month"){$row[$var]=STR_PAD($row[$var],2, "0",STR_PAD_LEFT);}
		$var1[]=$row[$var];
		}
	if($v=="month")
		{
		sort($var1);
		}
		
	${$var}=$var1;
	}
// echo "<pre>"; print_r($ARRAY_operated_units); echo "</pre>"; // exit;
$ARRAY_year[]="All";
$tot_fee_simple=0;
$tot_easement=0;
$tot_system_acres=0;
$tot_system_miles=0;
$tot_non_system_miles=0;
$check_fsa_date=array();
$check_cea_date=array();
$check_saa_date=array();
$check_slm_date=array();
$check_anslm_date=array();

$river_array=array("Natural River","Scenic River","Recreational River");
$trail_array=array("Designated Park Trail");

$skip=array("num_acres_fee_simple");

if(empty($ARRAY))
	{
	echo "Nothing was returned. If something is expected, copy and send this query to database.support:<br />$sql";
	exit;
	}
echo "<form action=\"acreage.php\" method=\"post\" id=\"form1\">
</form>";

$c=count($ARRAY);
echo "<table id='acreage'><form method='POST'>";
if($c>0)
	{
	echo "<tr><td colspan='3'>$c records &nbsp;&nbsp;&nbsp;<button style='color: magenta; font-size: 16px;' type='submit' form='form1' value='Submit'>RESET</button></td></tr>";
	}

foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			if(in_array($fld,$footnote_type)){continue;}
			$add_header[]="<th>$fld_names[$fld]</th>";
			if(in_array($fld, $select_array))
				{
				if(is_array(${"ARRAY_".$fld}))
					{
					$drop_down_array=${"ARRAY_".$fld};
// 					echo "<pre>"; print_r($drop_down_array); echo "</pre>"; // exit;
					if($fld=="year")
						{
						$drop_down_array=array_reverse($drop_down_array);
						if(empty($pass_value[$fld]))
							{$pass_value[$fld]=date("Y");}
						}
					$var_header=$fld;
					if($var_header=="operated_units"){$var_header=str_replace("_", " ",$var_header);}
					echo "<th>$var_header<select name='$fld' onchange=\"this.form.submit()\"><option value=\"\"></option>\n";
					foreach($drop_down_array as $k=>$v)
						{
						if(empty($v)){continue;}
						if(isset($pass_value))
							{
							@$test=stripslashes($pass_value[$fld]);
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
		echo "</tr></form>";
		}
	
	if($index>0 and fmod($index,20)==0)
		{
		echo "<tr>";
		foreach($add_header as $a=>$b){echo "$b";}
		echo "</tr>";
		}
		
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		$temp_value1="";
			if(in_array($fld,$footnote_type)){continue;}
		if(empty($_REQUEST))  // default display when first hitting page
			{
			include("acreage_header.php");
			exit;
			}
			
// display after making a selection
		if(in_array($fld,$skip)){continue;}
		$temp_value=$value;
		$var_foot=array();
		if(empty($check_fsa_date[$array['unit']])){$check_fsa_date[$array['unit']]="";}
		if(empty($check_cea_date[$array['unit']])){$check_cea_date[$array['unit']]="";}
		if(empty($check_saa_date[$array['unit']])){$check_saa_date[$array['unit']]="";}
		if(empty($check_slm_date[$array['unit']])){$check_slm_date[$array['unit']]="";}
		if(empty($check_anslm_date[$array['unit']])){$check_anslm_date[$array['unit']]="";}
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
			
			if($fld=="approximate_non_system_length_miles")
				{
if($array['year'].$array['month'].$array['day']>$check_anslm_date[$array['unit']])
					{
					$tot_non_system_miles+=$value;
					}
				if(in_array($array['sub_classification'], $trail_array))
					{
					$check_anslm_date[$array['unit']]=$array['year'].$array['month'].$array['day'];
					}
				}
			
			$temp_value=$value;	
			
			if(is_numeric($value))
				{
				$temp_value=number_format(($value));
				}
				
			if(is_float($value+0))
				{
				$temp_value=number_format(($value+0),3);
				}
				
			}
		
		if($fld=="unit")
			{
			foreach($footnote_type as $k=>$v)
				{
				if($array[$v]=="yes")
					{
					$var_foot[]=$k;
					}
				}
			if(!empty($var_foot))
				{
				$track_foot=1;
				$temp_foot=implode(",",$var_foot);
				$temp_value=$value." ($temp_foot)";
				}
			}
			
		if($fld=="id" and $level>3)
			{
			$temp_value="<form action=\"edit.php\" method=\"post\" id=\"form[$value]\">";
			if(!empty($year))
				{
				$y=$array['year'];
				$temp_value.="<input type=\"hidden\" name=\"year\" value=\"$y\">";
				 }
			if(!empty($month))
				{
				$m=$array['month'];
				$temp_value.="<input type=\"hidden\" name=\"month\" value=\"$m\">";
				 }
$temp_value.="<input type=\"hidden\" name=\"$fld\" value=\"$value\">
</form><button class='form_button_edit' type='submit' form='form[$value]' value='submit_form'>Edit</button>";
			if($level>4 and $index==0)
				{
				$temp_value1="<form action=\"add_record.php\" method=\"post\" id=\"form1[$value]\">
				<input type=\"hidden\" name=\"$fld\" value=\"$value\">
				<input type=\"hidden\" name=\"submit\" value=\"Add\">
				</form><button  class='form_button_add' type='submit' form='form1[$value]' value='submit_form'>Add</button>";
				}
			}
		echo "<td>$temp_value $temp_value1</td>";
		}
	echo "</tr>";
	}
if(!empty($_POST['year']))
	{
	if ( strpos( $tot_fee_simple, "." ) !== false )
		{
		$tot_fee_simple=number_format($tot_fee_simple, 3);
		}
		else{$tot_fee_simple=number_format($tot_fee_simple,0);}
	if ( strpos( $tot_easement, "." ) !== false )
		{
		$tot_easement=number_format($tot_easement, 3);
		}
		else{$tot_easement=number_format($tot_easement,0);}
	if ( strpos( $tot_system_acres, "." ) !== false )
		{
		$tot_system_acres=number_format($tot_system_acres, 3);
		}
		else{$tot_system_acres=number_format($tot_system_acres,0);}
	if ( strpos( $tot_non_system_miles, "." ) !== false )
		{
		$tot_non_system_miles=number_format($tot_non_system_miles, 3);
		}
		else{$tot_non_system_miles=number_format($tot_non_system_miles,0);}
	
	$c_1="";
	if($unit_type=="SR")
		{
		foreach($ARRAY as $index=>$array)
			{
			$count_unit[$array['unit_code']]=1;
			}
		$c_1="(".count($count_unit)." units)";
		}
	echo "<tr style='background-color:#cccc00'>
	<td colspan='9' style='text-align:right'>$c $unit_type $c_1</td>
	<td style='text-align:right'>$tot_fee_simple</td>
	<td style='text-align:right'>$tot_easement</td>
	<td style='text-align:right'>$tot_system_acres</td>
	<td style='text-align:right'>$tot_system_miles</td>
	<td style='text-align:right'>$tot_non_system_miles</td>
	</tr>";
	}
echo "</table>";

if(!empty($track_foot))
	{
	echo "<table>
	<tr><th colspan='2'>Footnotes</th></tr>";
	foreach($footnote_type as $k=>$v)
		{
		if($k==10){$v.=" [see SR section]";}
		echo "<tr><td>$k</td><td>$v</td></tr>";
		}
	echo "</table>";
	}
echo "</body></html>";