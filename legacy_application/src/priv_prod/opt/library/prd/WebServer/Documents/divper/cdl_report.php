<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
// ***********Find person form****************
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);
//print_r($_SESSION);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";  //exit;

extract($_REQUEST);

if(empty($rep))
	{include("menu.php");}

//substring_index(t4.county,',',1) as 'Work County'
$sql = "SELECT 'DNCR' as COMPANY, 'Parks and Rec' AS DIVISION,t1.beacon_num AS 'BEACON Pos#', t3.beaconID AS 'BEACON ID#', t1.park as 'At Park', t2.currPark, concat(t3.Lname, ', ', t3.Fname, ' ', t3.Mname) as NAME, t3.chaunum as 'CDL License', cdl_exp_date, '10' as 'EMPLOYEEJOBCLASS', 'DOT' as 'EMPLOYEETYPE', t4.county as 'Work County', t3.emid
FROM divper.`position` as t1
left join divper.emplist as t2 on t2.beacon_num=t1.beacon_num
left join divper.empinfo as t3 on t2.emid=t3.emid
left join dpr_system.dprunit as t4 on t2.currPark=t4.parkcode
where t1.cdl='y'
order by currPark";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
	
$c=count($ARRAY);
$i=0;
$today=date("Y-m-d");
echo "<table border='1' cellpadding='3'>";
if(empty($rep))
	{echo "<tr><td colspan='2'><a href='cdl_report_csv.php?rep=1'>Excel export</a></td></tr>";}
if(@$rep=="1")
	{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=cdl_report.xls');
	}
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr><td></td>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
		$i++;
	echo "<tr><td>$i</td>";
	foreach($array as $fld=>$value)
		{
		IF($fld=="Work County" and $value=="")
			{
			if($array['currPark']=="EADI"){$value="Wayne";}
			if($array['currPark']=="WEDI"){$value="Iredell";}
			}
		
		IF($fld=="cdl_exp_date" and $value<date("Y-m-d",strtotime("+60 days")))
			{
			$value="<font color='red'>$value</font>";
			}
		if($fld=="BEACON Pos#" and empty($rep))
			{
			$emid=$array['emid'];
			$value="<a href='formEmpInfo_reg.php?submit=Find&emid=$emid&p=y' target='_blank'>$value</a>";
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";

if(empty($rep))
	{echo "</body></html>";}
?>