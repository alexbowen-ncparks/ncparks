<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database); // database

$sql = "SELECT *
From vacant
where status='Filled'
";
// echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while ($row=mysqli_fetch_array($result))
	{
	$filled_array[]=$row['beacon_num'];
	}
// echo "<pre>"; print_r($filled_array); echo "</pre>"; // exit;


if(@$submit=="remove")
	{
	$query="DELETE from vacant_admin WHERE id='$id'";
//	echo "$query"; exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
	header("Location: findVacant_reg.php");
	exit;
	}


if(@$submit=="Add")
	{
	foreach($_POST as $k=>$v)
		{
		if($k!="submit"){$string.="$k='".$v."', ";}
		}
	$string=trim($string,", ");
	
	$query="REPLACE vacant_admin SET $string"; //echo "$query";exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
	
	$sql = "SELECT *
	From vacant as t1
	where t1.beacon_num='$beacon_num' and status!='Filled'
	";
//	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)<1)
		{ // Not previously vacated
		$query="REPLACE vacant SET beacon_num='$beacon_num'"; //echo "$query";exit;
		$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
		}
	header("Location: findVacant_dist.php");
	exit;
	}

include("menu.php");
// include("../../include/dist.inc");
//print_r($_REQUEST);//exit;
//print_r($_POST);exit;
// *************Entry Form 
echo "<html><head><title>Enter Emp Info</title>
<STYLE TYPE=\"text/css\">
<!--
body
{font-family:sans-serif;background:beige}
td
{font-size:90%;background:beige}
th
{font-size:95%;vertical-align:bottom}
--> 
</STYLE>
</head>
<body><font size='4' color='004400'>NC State Parks System Permanent Payroll</font>";

if(!isset($posTitle)){$posTitle="";}
if(!isset($posNum)){$posNum="";}
if(!isset($m)){$m="";}

echo "<div align='center'>
<table><tr><td><font size='4' color='red'>Filled</font> <font size='3' color='blue'>Position(s) that have been marked as VACANT.</font><font color='purple'> $posNum $posTitle
</font></td></tr><tr><td>$m</td></tr>
</table>

<table border='1'><tr><th>Fname</th><th>Lname</th><th>BEACON<br>Number</th>
<th>Position<br>Title</th><th>Park</th></tr>";

$sql = "SELECT empinfo.Fname,empinfo.Lname,vacant_admin.*, position.posTitle, position.park
From vacant_admin
LEFT JOIN position on position.beacon_num=vacant_admin.beacon_num
LEFT JOIN emplist on emplist.beacon_num=vacant_admin.beacon_num
LEFT JOIN empinfo on empinfo.tempID=emplist.tempID
where empinfo.Lname is NOT NULL
";
//echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while ($row=mysqli_fetch_array($result))
	{
	extract($row);
	$prevacated_array[]=$beacon_num;
	if(in_array($beacon_num,$filled_array)){continue;}
	echo "<tr><td>$Fname</td><td>$Lname</td>
	<td>$beacon_num</td><td>$posTitle</td><td>$park</td>
	<td><a href='vacant_admin.php?id=$id&submit=remove'>Remove</a></td>
	</tr>";
	}

$sql = "SELECT beacon_num as temp_bn From position
WHERE 1 
ORDER by beacon_num";
//echo "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while ($row=mysqli_fetch_array($result))
	{
	if(in_array($row['temp_bn'],$prevacated_array)){continue;}
	@$source_position.="\"".$row['temp_bn']."\",";
	}
echo "<form method='post' action='vacant_admin.php'>";

echo "<tr><td></td><td></td>
<td><input type='text' id='beacon_num' name='beacon_num'></td>";

echo "
	<script>
	$(function()
	{
		$( \"#beacon_num\" ).autocomplete({
		source: [ $source_position ]
			});
	});
	</script>";

echo "<td><input type='submit' name='submit' value='Add'></td>
</tr></table></form>";
echo "</div></body></html>";

?>