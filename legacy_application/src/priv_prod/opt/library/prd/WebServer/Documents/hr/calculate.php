<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="hr";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

include("../_base_top.php");

echo "<table>";

if(!empty($_POST))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	foreach($_POST['hours_week'] as $beacon_posnum=>$val)
		{
		$clause="";
		$clause.="beacon_posnum='".$beacon_posnum."', ";
		$clause.="hours_week='".$val."', ";
		$clause.="billing_rate='".$billing_rate."', ";
		$clause.="park_code='".$park_code."', ";
		$clause.="number_weeks='".$_POST['number_weeks'][$beacon_posnum]."', ";
		$clause.="medical='".$_POST['medical'][$beacon_posnum]."'";
	$sql="REPLACE ts_cost set $clause";  //echo "$clause<br />";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
		}
	}

extract($_REQUEST);
$sql="SELECT distinct division as center_code
from temp_solutions as t1
where 1
order by t1.division";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$park_array[]=$row['center_code'];
	}

echo "<form><tr><td colspan='3'>Select park:</td><td><select name='park_code' onChange=\"this.form.submit()\">
<option value='' selected></option>\n";         
        foreach($park_array as $k=>$v)
		{
		if($park_code==$v){$s="selected";}else{$s="";}
		echo "<option value='$v' $s>$v</option>\n";
		}
echo "</select>
</td></tr></form>";

if(empty($park_code)){exit;}

@$pass_osbm=strtoupper($_REQUEST['osbm_title']);
//$billing_rate*$hours_week*$number_weeks)+($med);

// Entered Cost
//, (ceil((DATEDIFF(end_date,start_date)/7)/4))*1 as month 
//count(t3.id) as records,
$sql="SELECT t3.division, t1.osbm_title, date_format(t3.start_date,'%a %b %e, %Y') as start_date, date_format(t3.end_date,'%a %b %e, %Y') as end_date, t3.work_hours, t3.billing_rate,
group_concat(substring_index(t3.job_description,'-',1)) as positions,
t3.billing_rate*t3.work_hours as rate_hrs,
DATEDIFF(end_date,start_date) as num_days,
ceil((DATEDIFF(end_date,start_date)/7)) as num_wk
from seasonal_payroll_justification as t1 
left join temp_solutions as t3 on t3.job_title=t1.osbm_title 
where t3.division='$park_code' 
group by t1.osbm_title, t3.start_date, t3.end_date
order by t1.osbm_title";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
$requested_positions=array();
while ($row=mysqli_fetch_assoc($result))
	{
	extract($row);
	$exp=explode(',',$positions);
	$requested_positions=array_merge($requested_positions,$exp);
	$n=count($exp);  // number of positions on job request form
	$row['num_pos']=$n;
	$var2=($rate_hrs*$n);
	$row['tot_cost']=$var2;
	$entered_ARRAY[]=$row;
	}
//echo "$sql";
//echo "Entered Cost<pre>"; print_r($entered_ARRAY); echo "</pre>"; // exit;
//echo "Entered Cost<pre>"; print_r($requested_positions); echo "</pre>"; // exit;

echo "<table border='1'><tr><td colspan='6'>Positions Requested thru Temp Solutions:</td></tr>";
echo "<tr>
<td>Number - Title</td>
<td>Start - End Dates</td>
<td>Hours</td>
<td>Days in Period<br />
Workdays in Period</td>
<td>Weeks</td>
<td>Billing Rate * Hours * Weeks = Pay</td>
</tr>";
foreach($entered_ARRAY AS $index=>$array)
	{
	extract($array);
	$work_days=$num_days-(2*$num_wk);
	$pay=$billing_rate*$work_hours*$num_wk;
	$v1=number_format($pay,2);
	@$v_tot+=$pay;
	$f_positions=str_replace(",",", ",$positions);
	echo "<tr>
	<td>$num_pos - $osbm_title<br />$f_positions</td>
	<td>$start_date - $end_date</td>
	<td>$work_hours</td>
	<td align='center'>$num_days<br />$work_days</td>
	<td>$num_wk</td>
	<td align='right'>$billing_rate * $work_hours * $num_wk = $v1</td>
	</tr>";
	}
@$f_v_tot=number_format($v_tot,2);
echo "<tr><td colspan='6' align='right'><b>$f_v_tot</b></td>
</tr></table>";


// Estimated Cost
$sql="SELECT t1.osbm_title, 
(sum( t3.billing_rate*t3.hours_week*t3.number_weeks) +
(ceil(t3.number_weeks/4))*t3.medical) as cost
from seasonal_payroll_justification as t1
left join seasonal_payroll as t2 on t1.osbm_title=t2.osbm_title
left join ts_cost as t3 on t3.beacon_posnum=t2.beacon_posnum
where t2.center_code='$park_code'
group by t1.osbm_title, t3.beacon_posnum
order by t1.osbm_title";
//echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
$estimate_ARRAY=array();
while ($row=mysqli_fetch_assoc($result))
	{
	extract($row);
	if($cost>0)
		{
		@$estimate_ARRAY[$osbm_title]+=$cost;
		}
	
	}
	
$sql="SELECT t1.osbm_title, t2.beacon_posnum,  t2.avg_rate, t3.billing_rate, t3.hours_week, t3.number_weeks, t3.medical
from seasonal_payroll_justification as t1
left join seasonal_payroll as t2 on t1.osbm_title=t2.osbm_title
left join ts_cost as t3 on t3.beacon_posnum=t2.beacon_posnum
where t2.center_code='$park_code'
order by t1.osbm_title";
//echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$var_osbm=strtoupper($row['osbm_title']);
	$title_array[$var_osbm]=$var_osbm;
	if(in_array($pass_osbm,$row))
		{
		$ARRAY[]=$row;
		}
	}
//echo "$var_osbm <pre>"; print_r($ARRAY); echo "</pre>";  //exit;

echo "<hr /><form><table><tr><td colspan='3'>BEACON Job Titles for $park_code:</td><td><select name='osbm_title' onChange=\"this.form.submit()\">
<option value='' selected></option>\n";         
        foreach($title_array as $k=>$v)
		{
		if($pass_osbm==$v){$s="selected";}else{$s="";}
		echo "<option value='$k' $s>$k</option>\n";
		}
echo "</select>
<input type='hidden' name='park_code' value='$park_code'></td></tr></table>
</form>";

if(empty($_REQUEST['osbm_title'])){exit;}

$hour_array=array("40","28","24","16","0");
$medical_array=array("Yes"=>452,"No"=>0);
$c=count($ARRAY);
echo "<form method='POST' action='calculate.php' style=\"font-size:95%;\">
<table border='1' cellpadding='2'><tr><td colspan='7'>$pass_osbm positions available</td></tr>
<tr>
<td>title</td>
<td>position no.</td>
<td>billing rate</td>
<td>hours per week</td>
<td>weeks / months</td>
<td>medical benefit ($452/month)</td>
<td>cost</td>
</tr>";
foreach($ARRAY AS $index=>$array)
	{
	extract($array);
		if(in_array($beacon_posnum,$requested_positions)){continue;}

	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if($fld=="avg_rate"){continue;}
		if(in_array($beacon_posnum,$requested_positions)){continue;}
		if($fld=="billing_rate")
			{
			if(is_null($value))
				{
				$value=number_format(($array['avg_rate']*1.0765)+2,4);
				$billing_rate=$value;
				}
			}
		if($fld=="hours_week")
			{
			$temp="";
			foreach($hour_array as $k=>$v)
				{
				if(is_null($hours_week)){$hours_week=0;}
				if($hours_week==$v){$ck="checked";}else{$ck="";}
				$beacon=$array['beacon_posnum'];
				$temp.="<input type='radio' name='hours_week[$beacon]' value='$v' $ck>$v ";
				}
				$value=$temp;
			}
		if($fld=="number_weeks")
			{
			$num_months=ceil($number_weeks/4);
			$value="<input type='text' name='number_weeks[$beacon]' value='$number_weeks' size='3'> $num_months months";
			}
		if($fld=="medical")
			{
			$temp="";
			foreach($medical_array as $k=>$v)
				{
				if(is_null($medical)){$medical=0;}
				if($medical==$v){$ck="checked";}else{$ck="";}
				$beacon=$array['beacon_posnum'];
				$temp.="<input type='radio' name='medical[$beacon]' value='$v'  $ck>$k ";
				}
				$value=$temp;
			}
				
		echo "<td>$value</td>";
		}
		$num_months=ceil($number_weeks/4);
		$med=$medical*$num_months;
		@$position_cost+=($billing_rate*$hours_week*$number_weeks)+($med);
		$cost=number_format(($billing_rate*$hours_week*$number_weeks)+$med,2);
		echo "<td align='right'>$cost</td>";
		
	echo "</tr>";
	}

		@$f_position_cost=number_format($position_cost,2);
echo "<tr><td colspan='8' align='right'><b>$f_position_cost</b></td></tr>";
echo "<tr><td colspan='6' align='right'>
<input type='hidden' name='billing_rate' value='$billing_rate'>
<input type='hidden' name='park_code' value='$park_code'>
<input type='hidden' name='osbm_title' value='$osbm_title'>
<input type='submit' name='submit' value='Calculate'>
</td></tr>";
$grand_total=number_format($position_cost+$v_tot,2);
echo "<tr><td colspan='8' align='right'>Requested + Calculated: <b>$grand_total</b></td></tr>";
echo "</table></form>";

?>