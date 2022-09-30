<?php
ini_set('display_errors',1);
session_start();
$level=$_SESSION['annual_report']['level'];
if($level<2){@$park_code=$_SESSION['annual_report']['select'];}

$database="divper";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database 

extract($_REQUEST);
// old sql
// 	$sql="SELECT concat(t1.prefix,' ', t1.First_name ,' ', t1.Last_name) as name, t1.pac_term, t1.pac_terminates, t1.interest_group, t1.pac_chair
// 	FROM `divper`.`labels` as t1
// 	where park='$park_code' and pac_term!=''
// 	order by t1.Last_name";
	
$sql="SELECT concat(t1.prefix,' ', t1.First_name ,' ', t1.Last_name) as name, t1.pac_term, t1.pac_terminates, t1.interest_group, t1.pac_chair 
FROM `divper`.`labels` as t1 
left join labels_affiliation as t2 on t1.id=t2.person_id
where park='$park_code'  and t2.`affiliation_code` = 'pac' order by t1.Last_name
";

// 	echo "$sql"; 
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$personnel_array[]=$row;
	}

$count=count($personnel_array);

echo "<table cellpadding='10'><tr><td>Copy the <b>PAC</b> info, close this window, and paste into appropriate section.</td></tr></table>";

echo "<table><tr><td colspan='2'>$count PAC positions</td></tr>";
foreach($personnel_array as $index=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(!isset($value)){$value="vacant";}
		if($fld=="pac_term"){$value="Term: ".$value." yrs.";}
		if($fld=="pac_terminates"){$value="Terminates: ".$value;}
		if($fld=="pac_chair" AND $value!=''){$value="[chair]";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";