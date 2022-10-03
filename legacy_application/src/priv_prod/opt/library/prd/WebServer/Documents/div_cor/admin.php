<?php

ini_set('display_errors',1);
extract($_REQUEST);

$database="div_cor";
include("../../include/auth.inc");// database connection parameters
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database);

//echo "<pre>"; print_r($_SESSION); echo "</pre>";
//echo "<pre>"; print_r($_POST); echo "</pre>";

IF(@$_POST['submit']=="Add")
	{
	foreach($_POST AS $k=>$v)
		{
		if($k=="submit"){continue;}		
		$sql = "INSERT into access SET $k='$v'";
		$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		}
	UNSET($_GET);
	}

IF(@$_GET['del']=="y")
	{
	$fld=$_GET['section'];
	$b=$_GET['bn'];
	$sql = "UPDATE access SET $fld='' where $fld='$bn'"; //echo "$sql";exit;
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	}
	
$list=array("admin","operation","apc","engn","le","opaa");

$sql = "SELECT * FROM access WHERE 1";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

while($row=mysqli_fetch_array($result))
	{
	foreach($list as $k=>$v)
		{
		$var=$v."_id";
		if($row[$var])
			{
			$ARRAY[$var][]=$row[$var];
			}	
		}
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";

mysqli_select_db($connection,"divper");

echo "<html><head><script language='JavaScript'>
function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this record?')
 return (bConfirm);
}
</script></head>";
echo "Click on BEACON number to delete from list.";
echo "<table border='1' cellpadding='5'><tr>";
foreach($ARRAY as $section=>$array)
	{
	echo "<td valign='top'>";	
	echo "<form method='POST'><table><tr><td><b>$section</b></td></tr>";
	foreach($array as $k=>$v)
		{
		$sql = "SELECT if(t3.Nname!='',t3.Nname,t3.Fname) as Fname, t3.Lname, t1.working_title, t1.park 
		FROM position as t1
		LEFT JOIN emplist as t2 on t1.beacon_num=t2.beacon_num
		LEFT JOIN empinfo as t3 on t2.emid=t3.emid
		WHERE t1.beacon_num='$v'";
		$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		$row=mysqli_fetch_array($result); 
		@extract($row);
		$v="<a href='admin.php?section=$section&bn=$v&del=y' onClick='return confirmLink()'>$v</a>";
		if(empty($Fname))
			{
			$Fname="<font color='red'>Not Found</red>";
			}
		echo "<tr><td>$v $Fname $Lname $working_title $park</td></tr>";
		}
	echo "<tr><td><input type='text' name='$section'>
	<input type='submit' name='submit' value='Add'></td></tr>";
	echo "</table></form>";
	echo "</td>";
	}
echo "</tr></table>";
?>