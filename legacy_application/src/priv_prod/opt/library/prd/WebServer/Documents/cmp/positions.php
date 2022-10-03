<?php
session_start();
$database="cmp";
include("../../include/iConnect.inc");// database connection parameters
$database="divper";
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

//echo "<pre>"; print_r($_SESSION); echo "</pre>";

extract($_REQUEST);
if(empty($park_code))
	{$park_code=$_SESSION['cmp']['select'];}

$where="t3.park='$park_code'";

$arch=array("DIRO","OPS1","OPS2","PACR","NARA","REMA","LAND","TRAIL","PAR3","BUOF");

if(in_array($park_code,$arch))
	{
	$where="t3.park='ARCH'";
	}
/*
$buof=array("BUOF","DEDE");
if(in_array($park_code,$buof))
	{
	$where="t3.code='$park_code'";
	}
*/

$sql = "SELECT concat(t2.Lname, ', ', if(t2.Nname!='',t2.Nname,t2.Fname), '  [',t1.beacon_num,']') as name, t3.working_title as title, t2.phone, t2.email
FROM emplist as t1
LEFT JOIN empinfo as t2 on t2.emid=t1.emid
LEFT JOIN position as t3 on t1.beacon_num=t3.beacon_num
WHERE $where
order by t2.Lname"; 

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));      		
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}

$c=count($ARRAY);
if($c<1){$com="We have not linked names and position titles for this Unit Code => $park_code. You will need to type in the name and position title.";}
else{$com="";}
echo "<html><head></header><body>";

echo "<table>";
echo "<tr><td colspan='3'>Name and position number for $park_code staff. Copy and paste into form.<br />$com</td></tr>";
foreach($ARRAY as $index=>$array)
	{
	echo "<tr><td>";
	$var="";
	foreach($array as $fld=>$value)
		{
		$var.=$value." * ";
		}
	$var=rtrim($var," * ");
	echo "$var</td></tr>";
	}
echo "</table></body></html>";
?>