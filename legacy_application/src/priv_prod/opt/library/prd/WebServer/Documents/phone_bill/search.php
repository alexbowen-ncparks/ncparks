<?php
extract($_REQUEST);
ini_set('display_errors',1);

include("menu.php");
	
include("../../include/connectROOT.inc");// database connection parameters
include("../../include/get_parkcodes.php");// list of parks
$parkCode[]="ARCH";
$parkCode[]="YORK";
$parkCode[]="NODI";
$parkCode[]="SODI";
$parkCode[]="EADI";
$parkCode[]="WEDI";
sort($parkCode);

$database="divper";
$db = mysql_select_db($database,$connection)
	   or die ("Couldn't select database");
//echo "<pre>"; print_r($_POST); echo "</pre>";
if(isset($_POST) AND count($_POST)>0)
	{
	extract($_POST);
	if($last_name!="")
		{
		$where="and t1.Lname like '$last_name%'";
		$where_alt="and t1.location like '%$last_name%'";
		}
	if($work_phone!="")
		{
		$where="and t1.phone like '%$work_phone%'";
		$where_alt="and t1.alt_lines like '%$work_phone%'";
		}
	if($work_cell!="")
		{
		$where="and t1.work_cell like '%$work_cell%'";
		$where_alt="and t1.alt_lines like '%$work_cell%'";
		}
	if($park_code!="")
		{
		$where="and t2.currPark = '$park_code'";
		$where_alt="and t1.location like '%$park_code%'";
		}
	
	$sql="SELECT t1.Fname, t1.Nname, t1.Lname, t1.phone as work_phone, t1.work_cell, t1.fax, t2.currPark as park
	from divper.empinfo as t1
	LEFT JOIN divper.emplist as t2 on t2.emid=t1.emid
	where 1 $where
	and t2.currPark is not NULL
	order by t1.Lname, t1.Fname"; //echo "$sql $connection";
	$result=mysql_query($sql,$connection);
	if($result)
		{
		while($row=mysql_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
		
//		echo "<pre>"; print_r($ARRAY); echo "</pre>";
		}
		else
		{
		echo "No phone(s) was found using <font color='blue'>$where</font>";
		}
	
	$db = mysql_select_db("phone_bill",$connection)
	   or die ("Couldn't select database");
	   $sql="SELECT * from alt_lines as t1
	where 1 $where_alt"; //echo "$sql $connection";
	$result=mysql_query($sql,$connection);
	if($result)
		{
		while($row=mysql_fetch_assoc($result))
			{
			$ARRAY_alt[]=$row;
			}
		}
//		echo "<pre>"; print_r($ARRAY); echo "</pre>";
	}
echo "<form method='POST'><table align='center'>";
echo "<tr><th>Search Phone Database</td></tr>";

echo "<tr><td>Last Name</td><td><input type='text' name='last_name'></td></tr>";
echo "<tr><td>Work Phone</td><td><input type='text' name='work_phone'></td></tr>";
echo "<tr><td>Work Cell</td><td><input type='text' name='work_cell'></td></tr>";

echo "<tr><td>Park/Location</td><td><select name='park_code'><option selected=''></option>";
foreach($parkCode as $index=>$park_code)
	{
	echo "<option value='$park_code'>$park_code</option>";
	}
echo "</select></td></tr>";

echo "<tr><td><input type='submit' name='submit' value='Find'></td></tr>";
echo "</table></form>";

if(isset($ARRAY))
	{
	echo "<table border='1' cellpadding='5'>";
	echo "<tr><th colspan='8'>Results for Contact Info:</td></tr>";
	foreach($ARRAY as $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($array as $fld=>$value)
				{
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			echo "<td>$value</td>";
			}
		}
	echo "</tr>";
	}

echo "</table>";

//*************** Alt lines ******************
if(isset($ARRAY_alt))
	{
	echo "<table border='1' cellpadding='5'>";
	echo "<tr><th colspan='8'>Results for Alternate Lines:</td></tr>";
	foreach($ARRAY_alt as $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($array as $fld=>$value)
				{
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			echo "<td>$value</td>";
			}
		}
	echo "</tr>";
	}

echo "</table>";


echo "</div></body></html>";

?>