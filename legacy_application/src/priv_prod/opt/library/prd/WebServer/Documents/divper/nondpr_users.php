<?php
session_start();
if($_SESSION['divper']['level']<5){exit;}
$database="divper";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

if(@$_POST['submit']=="Delete")
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	$query="DELETE FROM nondpr where listid='$_POST[listid]'"; //echo "$query";exit;
		$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
	echo "That person has been deleted";
	echo "<p>Show <a href='nondpr_users.php'>all</a></p>";
	exit;
	}
	
if(!empty($_POST))
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
	$string="";
	foreach($_POST as $k=>$v)
		{
		if($k!="submit"){$string.="$k='$v', ";}
		}
	$string=trim($string,", ");
	
// 	echo "$string"; exit;
	
	if($_POST['submit']=="Add")
		{
		$query="INSERT nondpr SET $string"; //echo "$query";exit;
		$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query".mysqli_error($connection));
// 		$database="divper";
// 		include("../../include/iConnect_PUB.inc"); // database connection parameters
// 		mysqli_select_db($connection,$database);
// 		$query="INSERT nondpr SET $string"; //echo "$query";exit;
// 		$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query".mysqli_error($connection));

		$location="Location: /divper/nondpr_users.php";
		$location="Location: /divper/nondpr_users.php";
// 		$location="Location: /divper/nondpr_users.php?string=$string,submit=Add";
// 		$location="Location: /divper/nondpr_users.php?string=$string,submit=Add";
		header($location);
		exit;
		}
	else
		{
		$query="REPLACE nondpr SET $string"; //echo "$query";exit;
		$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
		$location="Location: /divper/nondpr_users.php?string=$string,submit=Update";
		$location="Location: /divper/nondpr_users.php?string=$string,submit=Update";
		header($location);
		exit;
		}	
	}


include("menu.php");
// ******** Enter your SELECT statement here **********
if(!empty($edit)){$where1="and listid='$edit'";}else{$where1="";}
$sql = "SELECT  * 
From nondpr
where 1 $where1
order by listid desc";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");

$skip_access=array("listid","emid");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	foreach($row as $k=>$v)
		{
		if(in_array($k,$skip_access)){continue;}
		if($v>0)
			{$access_array[$k]=$v;}
		}
	}
if(!empty($access_array) and !empty($edit))
	{
	ksort($access_array);
	echo "<pre>"; print_r($access_array); echo "</pre>"; // exit;
	}
$fieldNames=array_values(array_keys($ARRAY[0]));
for($i=0;$i<17; $i++)
	{
	$static_fld_names[]=$fieldNames[$i];
	}
for($i=17;$i<count($fieldNames); $i++)
	{
	$sort_fld_names[]=$fieldNames[$i];
	}
sort($sort_fld_names);
$fieldNames=array_merge($static_fld_names, $sort_fld_names);
//echo "<pre>"; print_r($fieldNames); echo "</pre>"; // exit;
$num=count($ARRAY);

$excludeFields=array("listid","emid");
	
if(!empty($edit))
	{
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
	echo "<form method='POST'>
	<table><tr><td></td><td>Show <a href='nondpr_users.php'>all</a></td>";
	foreach($ARRAY AS $index=>$array)
		{
		foreach($fieldNames as $temp=>$fld)
			{
			$value=$array[$fld];
			if(in_array($fld,$excludeFields)){$ro="readonly";}else{$ro="";}
			echo "<tr><td>$fld</td><td><input type='text' name='$fld' value=\"$value\" size='15' $ro></td></tr>";
			}
		}
	echo "<tr><td colspan='2' align='center'>
	<input type='submit' name='submit' value='Update'>
	</td><td colspan='2' align='center'>
	<input type='submit' name='submit' value='Delete' onclick=\"javascript:return confirm('Are you sure you want to delete this person?')\">
	</td></tr>";
	echo "</table></form>";
	echo "</body></html>";
	exit;
	}
	
if(empty($edit))
	{
	echo "<html><table border='1' cellpadding='2'><tr><td colspan='3'><font color='red'>$num records</font></td><td>Show <a href='nondpr_users.php'>all</a></td></tr>";

	$header="<tr>";
	foreach($fieldNames as $k=>$v)
		{
		$v=str_replace("_"," ",$v);
		$header.="<th>$v</th>";
		}
	$header.="</tr>";

	echo "$header";
	echo "<form method='POST'><tr>";
		$noAdd=array("listid");
	foreach($fieldNames as $k=>$v){
		if(in_array("$v",$noAdd)){$ro="READONLY";}else{$ro="";}
			echo "<td><input type='text' name='$v' value='' size='10'$ro></td>";
			}
	echo "<td><input type='submit' name='submit' value='Add'></td></tr></form>";

	$editFlds=$fieldNames;

	$j=0;
	if(!isset($update)){$update="";}
	foreach($ARRAY as $index=>$array)
		{// each row
	
		if(fmod($j,20)==0 AND $j>0)
			{echo "$header";}
		$f1="";$f2="";$j++;
		if(fmod($j,2)!=0){$tr=" bgcolor='aliceblue'";}else{$tr="";}
	
	
			
		echo "<tr>";
		
	foreach($fieldNames as $temp=>$fld)
			{
			$value=$array[$fld];
			if(in_array($fld,$excludeFields)){$ro="readonly";}else{$ro="";}
			if($fld=="listid")
				{
				$value="<a href='nondpr_users.php?edit=$value&submit=Submit'>$value</a>";
				}
			echo "<td>$value</td>";
			}
			
		
		echo "</tr>";
		}

	echo "<tr>";
	foreach($fieldNames as $k=>$v)
		{
	//	echo "<th>$total[$v]</th>";
		}
	echo "</tr>";

	echo "</table></body></html>";
	}
?>