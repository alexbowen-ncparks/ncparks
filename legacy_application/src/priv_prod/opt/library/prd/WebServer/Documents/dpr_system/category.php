<?php
//ini_set('display_errors',1);

$database="dpr_system";
include("../../include/connectROOT.inc");

mysql_select_db('dpr_system',$connection);

$title="NC DPR Databases";
include("../_base_top.php");
extract($_GET);

$sql="SELECT distinct cat_name from home_page where 1 order by cat_name";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
while($row=mysql_fetch_assoc($result))
	{
	$cat_array[]=$row['cat_name'];
	}

if(!empty($cat_name))
	{
	$sql="SELECT distinct db from home_page where cat_name='$cat_name'
	order by db";
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	while($row=mysql_fetch_assoc($result))
		{
		$db_array[]=$row['db'];
		}
	}
	
echo "<table align='center'><tr><td>
Select a Category: <select name='cat_name' onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''></option>\n";

echo "<option value='/home.php'>Home Page</option>\n";
foreach($cat_array as $k=>$v)
	{
	$var_v=urlencode($v);
	$link="category.php?cat_name=$var_v";
	echo "<option value='$link'>$v</option>\n";
	}
echo "</select></td>";

if(!empty($cat_name))
	{
	echo "<td>
	Select a Database: <select name='db' onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''></option>\n";
	foreach($db_array as $k=>$v)
		{
		$var_v=urlencode($v);
		$cn=urlencode($cat_name);
		$link="category.php?cat_name=$cn&db=$var_v";
		echo "<option value='$link'>$v</option>\n";
		}
echo "</select></td>";
	}

echo "</tr></table>";
	
if(empty($_GET))
	{
	exit;
	}
if(!empty($_GET['cat_name']) AND empty($_GET['db']))
	{
	$update_file="update.php";
	$cat=$_GET['cat'];
	$sql="SELECT * from home_page where cat_name='$cat_name'
	order by db";
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	while($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	}
	
if(!empty($_GET['db']))
	{
	$update_file="update_subject.php";
	$subject=$_GET['db'];
	$sql="SELECT * from home_page_subject where db='$db'
	order by cat_subject";
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	while($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	}

//echo "$sql";
//echo "<pre>"; print_r($ARRAY); echo "</pre>";

echo "<form method='POST' action='$update_file'><table cellpadding='5' border='1' align='center'><tr><td colspan='1'><b>NC DPR Databases<b></td>";
if(!empty($db)){$target="Description of the db functions";}else{$target="Actual DB name and Public DB name";}
echo "<td colspan='3'>$target</td></tr>";

$skip=array("id");
if(!empty($_GET['db'])){$skip[]="web_link";}

if(empty($ARRAY))
	{
	echo "<tr><td>cat_name</td><td>db</td><td>cat_subject</td></tr>";
	}
else
	{
	foreach($ARRAY as $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($array as $k0=>$v0)
				{
				if(in_array($k0,$skip)){continue;}
				echo "<td>$k0</td>";
				}
			echo "</tr>";
			}
			echo "<tr>";
		foreach($array as $k1=>$v1)
			{
			if(in_array($k1,$skip)){continue;}
			$id=$array['id'];
			$size="25";
			if($k1=="cat_subject"){$size=45;}
			if($k1=="web_link"){$size=65;}
			if($k1=="db"){$size=15;}
			$fld=$k1."[$id]";
			if($k1=="cat_name"){$RO="READONLY";}else{$RO="";}
			echo "<td><input type='text' name='$fld' value=\"$v1\" size='$size' $RO></td>";
			}
			echo "</tr>";
		}
	}

if(!empty($_GET['cat_name']) AND empty($_GET['db']))
	{
	echo "<tr>
	<td><input type='text' name='new_cat_name' value=\"$cat_name\" size='25'></td>
	<td><input type='text' name='new_db' value=\"\" size='15'></td>
	<td><input type='text' name='new_db_name' value=\"\" size='25'></td>
	<td><input type='text' name='new_web_link' value=\"\" size='65'></td>
	</tr>";
	}

if(!empty($_GET['db']))
	{
	extract($_GET);
	echo "<tr>
	<td><input type='text' name='new_cat_name' value=\"$cat_name\" size='25'></td>
	<td><input type='text' name='new_db' value=\"$db\" size='15'></td>
	<td><input type='text' name='new_cat_subject' value=\"\" size='45'></td>
	</tr>";
	}	
	echo "<tr>
	<td colspan='4' align='center'><input type='submit' name='submit' value='Submit'></td>
	</tr>";
echo "</table></form>";
?>
