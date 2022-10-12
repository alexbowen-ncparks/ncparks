<?php
include("menu.php");
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; EXIT;

include("../../include/iConnect.inc");
include("../../include/get_parkcodes_reg.php");
mysqli_select_db($connection,'divper');

$sql="SELECT distinct currPark 
from emplist
where 1 order by currPark";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_park[]=$row['currPark'];
	}

echo "<table align='center'>";
echo "<tr><td><select name='park_code' onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''></option>\n";
foreach($ARRAY_park as $k=>$v)
	{
	echo "<option value='personnel.php?park_code=$v'>$v</option>\n";
	}
echo "</select></td></tr></table>";

if(empty($park_code)){exit;}

$sql="SELECT t1.emid, t1.tempID, concat(t4.Lname,', ',t4.Fname) as name, t3.working_title
from fire.fire_train as t2
LEFT JOIN divper.emplist as t1 on t1.emid=t2.emp_id
LEFT JOIN divper.empinfo as t4 on t4.emid=t2.emp_id
LEFT JOIN divper.position as t3 on t3.beacon_num=t1.beacon_num
where t1.currPark='$park_code'
order by t3.working_title"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_fire[]=$row;
	}	
	
$sql="SELECT t1.emid, t1.tempID, concat(t4.Lname,', ',t4.Fname) as name, t3.working_title
from divper.emplist as t1
LEFT JOIN fire.fire_train as t2 on t1.emid=t2.emp_id
LEFT JOIN divper.empinfo as t4 on t4.emid=t2.emp_id
LEFT JOIN divper.position as t3 on t3.beacon_num=t1.beacon_num
where t1.currPark='$park_code'
order by t1.tempID"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}	
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; exit;

if(empty($ARRAY))
	{
	$none=1;
	$sql="SELECT t1.emid, t1.tempID, concat(t2.Lname,', ', t2.Fname) as name
	from divper.empinfo as t2
	LEFT JOIN divper.emplist as t1 on t1.emid=t2.emid
	where t1.currPark='$park_code'
	order by t2.Lname"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute select query. $sql ");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}	
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
echo "<div align='center'>";
echo "<form action='personnel_update.php' method='POST' enctype='multipart/form-data'>";

echo "<table border='1' cellpadding='5'>";

echo "<tr><td colspan='4'><font color='brown' size='+1'>$park_code Personnel Comparison</font></td></tr>";

if(empty($none))
	{
	$h3="Assigned to $park_code in Fire Training database.";
	}
else
	{
	$h3="<font color='red'>NOT Assigned to $park_code in Fire Training database.</font>";
	}
echo "<tr><th>Emp. ID</th><th>Current at $park_code</th><th>$h3</th><th>Title</th></tr>";
foreach($ARRAY as $index=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if($fld=="emid")
			{
			$value="<a href='training_edit.php?emp_id=$value'>link</a>";
			}	
		if($value=="")
			{
			$value="<font color='red'>Not entered into FT database.</font>";
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table><hr />";

IF(empty($ARRAY_fire)){echo "There are presently no personnel from $park_code in the fire training database.";exit;}

echo "<table border='1'>";
echo "<tr><th>Emp. ID</th><th>Current at $park_code</th><th>$h3</th><th>Title</th></tr>";
foreach($ARRAY_fire as $index=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if($fld=="emp_id")
			{
			$value="<a href='training_edit.php?emp_id=$value'>link</a>";
			}
		if($fld=="name")
			{
			$value="<font color='green'>$value</font>";
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";

echo "</div></html>";
?>