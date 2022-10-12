<?php
ini_set('display_errors',1);
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;
//echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;


include("menu.php");

if(!empty($_POST))
	{
	$beacon_title=$_POST['beacon_title'];
	$db=$_POST['db'];
	$lev=$_POST['level'];
	$sql="UPDATE `emplist` as t1, position as t2
	set t1.$db='$lev'
	WHERE t2.beacon_num=t1.beacon_num and t2.beacon_title='$beacon_title'";
//	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute Select query. $sql ".mysqli_error($connection));
	}
	
if(!empty($beacon_title)){$title="and t2.beacon_title='$beacon_title'";}else{$title="";}

$sql = "SELECT t1.tempID, t1.beacon_num, t2.park as currPark, t1.$db, t2.postitle, t2.beacon_title
FROM `emplist` as t1
left join position as t2 on t1.beacon_num=t2.beacon_num
where t1.$db>0 $title
order by t1.$db desc, t1.currPark, t1.tempID";	
$result = mysqli_query($connection,$sql) or die ("Couldn't execute Select query. $sql ".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}

//echo "<pre>"; print_r($ARRAY); echo "</pre>"; exit;
//echo "$sql";
if(!empty($beacon_title))
	{
	echo "<table><form method='POST'><tr><td>Update all [ $beacon_title ] to Level <input type='text' name='level' size='2'> of database <font color='red'>$db</font></td>";
	echo "<td>
	<input type='hidden' name='db' value='$db'>
	<input type='hidden' name='beacon_title' value='$beacon_title'>
	<input type='submit' name='submit' value='Update'></td></tr></form></table>";
	}
if(empty($ARRAY))
	{
	echo "No $beacon_title has access.<br />";
	exit;
	}
echo "
<table border='1' cellpadding='2'>
<tr><th colspan='7'>DB = $db</th></tr>
<tr><td></td><td>TempID</td><td>BEACON Position #</td><td>Park</td><td>Level</td><td>Title</td><td>BEACON Title</td></tr>

<tr>";
foreach($ARRAY as $index=>$array)
		{
		@$i++;
		echo "<tr><td>$i</td>";
		foreach($array as $fld=>$val)
			{
			if($fld=="beacon_title")
				{
				$fld_val=urlencode($val);
				$val="<a href='find_users.php?db=$db&$fld=$fld_val'>$val</a>";
				}
			echo "<td>$val</td>";
			}
		echo "</tr>";
		
		}// end while
	echo "</table>";
	
unset($ARRAY);
$sql = "SELECT t1.Fname, t1.Lname, t1.tempID, t1.currPark, $db as Level
FROM `nondpr` as t1
where t1.$db>0 
order by t1.$db desc, t1.currPark, t1.Lname";	
$result = mysqli_query($connection,$sql) or die ("Couldn't execute Select query. $sql ".mysqli_error($connection));
while ($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}	
$skip=array();


echo "<br /><br /><table border='1' cellpadding='5'><tr><td colspan='4'>Temp Employees</td></tr>";

if(empty($ARRAY))
	{echo "<tr><td>No temps have access.</td></tr></table>"; exit;}
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</body></html>";

?>