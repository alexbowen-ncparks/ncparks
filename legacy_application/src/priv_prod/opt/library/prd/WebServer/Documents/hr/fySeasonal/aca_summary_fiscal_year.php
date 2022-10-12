<?php
ini_set('display_errors',1);
session_start();
$level=$_SESSION['hr']['level'];
$fiscal_year=$_SESSION['hr']['fiscal_year'];

if($level<1){echo "You do not have access to this database. <a href='http://www.dpr.ncsparks.gov/hr/'>login</a>";exit;}

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
if($level>4)
	{
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>"; 
//	echo "<pre>"; print_r($_POST); echo "</pre>"; 
	//exit;
	}

include("../../../include/iConnect.inc"); // database connection parameters
include("../../../include/get_parkcodes_reg.php");
date_default_timezone_set('America/New_York');

$database="hr";
mysqli_select_db($connection,$database);


$sql="SELECT t4.district, t1.center_code,t1.osbm_title, t1.beacon_posnum, t1.ncas_account, t1.month_11,
round((t1.budget_hrs_a * t1.budget_weeks_a)) as aca_hours
FROM seasonal_payroll_fiscal_year as t1 
LEFT JOIN employ_position as t2 on t1.beacon_posnum=t2.beacon_num 
LEFT JOIN employ_separate as t3 on t1.beacon_posnum=t3.beacon_num 
LEFT JOIN dpr_system.parkcode_names as t4 on t1.center_code=t4.park_code 
WHERE 1 and park_approve='y' and fiscal_year='$fiscal_year'
group by center_code, beacon_posnum
ORDER BY t4.district, t1.center_code, t1.beacon_posnum, t1.osbm_title";
//echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	if($row['month_11']=="y"){@$month_11_tot++;}
	if($row['aca_hours']>1559){@$aca_tot++;}
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
$c=count($ARRAY);
echo "<table><tr><td colspan='4'>$c positions</td><td>11-month = $month_11_tot</td><td>ACA eligible = $aca_tot</td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		$display_value=$value;
		if($fld=="district" and $value=="")
			{$display_value="STWD";}
		if($fld=="month_11" and $value=="y")
			{
			@$tot_month_11++;
			$display_value="<font color='red'>$value</td>";
			}
		if($fld=="aca_hours" and $value>1559)
			{
			@$tot_aca++;
			$display_value="<font color='magenta'>$value</td>";
			}
		
		echo "<td>$display_value</td>";
		}
	echo "</tr>";
		if($ARRAY[$index]['center_code']!=@$ARRAY[$index+1]['center_code'])
			{
			echo "<tr bgcolor='aliceblue'><td colspan='5' align='right'>Center: </td><td>$tot_month_11</td><td align='left'>$tot_aca</td></tr>";
			@$dist_tot_month_11+=$tot_month_11;
			$tot_month_11=0;
			@$dist_tot_aca+=$tot_aca;
			$tot_aca=0;
			}
		if($ARRAY[$index]['district']!=@$ARRAY[$index+1]['district'])
			{
			echo "<tr bgcolor='aliceblue'><td colspan='5' align='right'>District: </td><td>$dist_tot_month_11</td><td>$dist_tot_aca</td></tr>";
			$dist_tot_month_11="";
			$dist_tot_aca="";
			}
	}
echo "</table>";

?>

