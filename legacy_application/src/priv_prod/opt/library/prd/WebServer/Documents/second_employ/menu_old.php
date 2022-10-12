<?php

ini_set('display_errors',1);
$title="Secondary Employment";
include("../inc/_base_top_dpr.php");
$database="second_employ";

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";

include("../../include/auth.inc"); // used to authenticate users
include("../../include/connectROOT.inc");// database connection parameters
include("../../include/get_parkcodes.php");// database connection parameters

if(!empty($_REQUEST)){extract($_REQUEST);}

$level=$_SESSION[$database]['level'];
$tempID=$_SESSION[$database]['tempID'];

echo "<table align='center'>";
echo "<tr><th colspan='5'><font color='gray'>REQUEST FOR APPROVAL OF SUPPLEMENTARY EMPLOYMENT</font></th></tr>";

if($level==1)
	{
	echo "<tr>
	<td><a href='form.php?tempID=$tempID&a=enter'>Enter a Request</a></td>
	<td><a href='form.php?tempID=$tempID&a=view'>View Request Status</a></td>
	</tr>
	</table>";
		
	}

if($level==2)
	{
	
	echo "<tr>
	<td><a href='form.php?tempID=$tempID&a=enter'>Enter a Request</a></td>
	<td><a href='form.php?tempID=$tempID&a=view'>View Request Status</a></td>
	</tr>
	</table>";
	}


if($level>2)
	{
	echo "<tr>
	<td><a href='form.php?tempID=$tempID&a=enter'>Enter a Request</a></td>
	<td><a href='form.php?tempID=$tempID&a=view'>View Request Status</a></td>
	</tr>
	</table>";
	}

if(isset($id))
	{
	$db = mysql_select_db($database,$connection) or die ("Couldn't select database");
	$sql="SELECT *
	from request
	where id='$id'";
	$result=mysql_query($sql) or die ("Couldn't execute query. $sql");
	$row=mysql_fetch_assoc($result);
	extract($row);
	$action="Update";
	}
if(empty($id) AND @$a=="enter")
	{
	extract($_SESSION['second_employ']);
	$name=$full_name;
	$db = mysql_select_db('divper',$connection) or die ("Couldn't select database");
	$sql="SELECT t1.add1 as address, t1.city, t1.zip, t3.working_title as position, t3.code as park_code
	from divper.empinfo as t1
	LEFT JOIN divper.emplist as t2 on t1.tempID=t2.tempID
	LEFT JOIN divper.position as t3 on t2.beacon_num=t3.beacon_num
	where t1.tempID='$tempID'";
	$result=mysql_query($sql) or die ("Couldn't execute query. $sql");
	$row=mysql_fetch_assoc($result);
	extract($row);
	$action="Enter";
	}

if(isset($a) and $a=="view")
	{
	$db = mysql_select_db($database,$connection) or die ("Couldn't select database");
	$sql="SELECT *
	from request
	where tempID='$tempID'";
	$result=mysql_query($sql) or die ("Couldn't execute query. $sql");
	echo "<table align='center' border='1' cellpadding='5'>";
	while($row=mysql_fetch_assoc($result))
		{
		extract($row);
		echo "<tr><td>$employer</td><td>$job_title</td><td><a href='form.php?a=update&id=$id'>View</a></td></tr>";
		}
	exit;
	}	
?>