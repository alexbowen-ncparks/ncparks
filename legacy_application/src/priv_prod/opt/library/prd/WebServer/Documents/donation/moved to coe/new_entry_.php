<?php
ini_set('display_errors',1);
$database="donation";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/connectROOT.inc"); 
include("../../include/get_parkcodes.php"); // used to authenticate users
mysql_select_db($database, $connection); // database

date_default_timezone_set('America/New_York');
extract($_REQUEST);
// **********************************************
if(empty($pass_edit))
	{
	echo "No date specified.";
	exit;
	}

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

IF(!empty($_POST['submit']))
	{
//	echo "<pre>"; print_r($_POST); print_r($_FILES);echo "</pre>";  exit;
	$skip_post=array("submit","attachment_num");
	foreach($_POST AS $fld=>$val)
		{
		if(in_array($fld,$skip_post)){continue;}
		$val=mysql_real_escape_string($val);
		@$clause.=$fld."='".$val."',";
		}
		$clause=rtrim($clause,",");
	$sql="INSERT INTO calendar set $clause "; //ECHO "$sql"; exit; 
	$result = @mysql_query($sql, $connection) or die(mysql_error());
	$id=mysql_insert_id();
	
	include("upload_files.php");
	}

list($year,$month, $day)=explode("-",$pass_edit);
$newdate2016="2016-".$month."-".$day;
$sql="SELECT * from dprcoe.year_2016 where dateE='$newdate2016' and year16_100='x'"; //echo "$sql";
$result = @mysql_query($sql, $connection) or die(mysql_error());
$yr_2016_array=array();
while($row=mysql_fetch_assoc($result))
	{
	$yr_2016_array[]=$row['eid'];
	}


if(empty($placeholder))
	{
	$sql="SELECT '100th', 'x',  t1.park, t1.date,t1.title,id, activity, t1.start_time
	from donation.calendar as t1 
	where t1.date = '$pass_edit'
	union
	select 'dprcoe', t2.ann_100, t2. park, t2.dateE,t2.title, eid, content, t2.start_time
	from dprcoe.event as t2

	where t2.dateE = '$pass_edit'
	order by 100th, park
	"; //echo "$sql";
	}
	else
	{
	$sql="SELECT '100th', 'x',  t1.park, t1.date,t1.title,id, activity, t1.start_time
	from donation.calendar as t1 
	where t1.date = '$pass_edit'
	union
	select 'placeholder', t2.year16_100, t2. park, t2.dateE,t2.title, eid, content, t2.start_time
	from dprcoe.year_2016 as t2

	where t2.dateE = '$pass_edit'
	order by 100th, park
	"; //echo "$sql";
	}
	
//	echo "$sql"; //exit;
$result = @mysql_query($sql, $connection) or die(mysql_error());
while($row=mysql_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
//echo "$sql<pre>"; print_r($ARRAY); echo "</pre>";  exit;

if(@$submit=="Add an Item")
	{
	$ARRAY="";
	$message="Add an item.";
	}
	else
	{$message="NOTHING found for this date.";}
if(empty($ARRAY))
	{
	list($year,$month,$day)=explode("-",$pass_edit);
	echo "<table border='1' cellpadding='5'>
	<tr>
	<td colspan='4' bgcolor='green'>
	<form action='cal.php'>";
	if(!empty($placeholder)){echo "<input type='hidden' name='placeholder' value='1'>";}
	echo "<input type='hidden' name='month' value='$month'>
	<input type='hidden' name='year' value='$year'>
	<input type='submit' name='submit' value='Return to $pass_edit'></form>
	</td></tr></table>";

	$sql="SHOW COLUMNS from calendar";
	$result = @mysql_query($sql, $connection) or die(mysql_error());
	while($row=mysql_fetch_assoc($result))
		{
		$ARRAY[][$row['Field']]="";
		}
	}
	else
	{
	$c=count($ARRAY);
	list($year,$month,$day)=explode("-",$pass_edit);
	echo "<table border='1' cellpadding='5'><tr>
	<td colspan='3' bgcolor='green'>
	<form action='cal.php'>";
	if(!empty($placeholder)){echo "<input type='hidden' name='placeholder' value='1'>";}
	echo "<input type='hidden' name='month' value='$month'>
	<input type='hidden' name='year' value='$year'>
	<input type='submit' name='submit' value='Return to $pass_edit'></form>
	</td>
	<td><form action='new_entry.php'>";
	
	echo "<input type='hidden' name='pass_edit' value='$pass_edit'>
	<input type='hidden' name='new' value='1'>
	<input type='submit' name='submit' value='Add an Item'></form></td></tr></table>";

//echo "<pre>"; print_r($ARRAY); print_r($yr_2016_array); echo "</pre>"; // exit;	

$skip=array("id");
echo "<form method='POST' action='update_coe.php'><table border='1'>";
	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				if($fld=="donation"){$fld="database";}
				if($fld=="x"){$fld="calendar";}
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			if($fld=="100th")
				{
				$test_value=$value;
					$id=$array['id']; // target='_blank'
					$value="<a href='/dprcoe/edit.php?eid=$id'>".$value."</a><br />";
				if($test_value=="100th")
					{
					$value="<a href='cal_edit.php?id=$id''>".$test_value."</a><br />";
					}
				if($test_value=="placeholder")
					{
					$value="<a href='placeholder2date.php?pass_edit=$pass_edit&id=$id''>".$test_value."</a><br />";
					}
				$value="<a href=''>$value</a>";
				}
				
				$td="";
				if($fld=="x")
					{
					$id=$array['id'];
					$ck="";$ck16="";
					if($array['100th']=="100th")
						{
						$td=" bgcolor='yellow'";
						if($value=="x"){$ck="checked";}
						$value="Event on Calendar";
						}
					if($array['100th']=="dprcoe")
						{
						if($value=="x"){$ck="checked";}$value="<input type='checkbox' name='ann_100[$id]' value='x' $ck>$year<br />";
						}
					
					
					if($array['100th']!="100th")
						{
						if(in_array($id,$yr_2016_array)){$ck16="checked";}
						$value.="<input type='checkbox' name='year_2016[$id]' value='x' $ck16>Holder";
						}
					
					}
			echo "<td$td>$value</td>";
			}
		echo "</tr>";
		}
	echo "<tr><td colspan='3' align='center'>
	<input type='hidden' name='pass_edit' value='$pass_edit'>
	<input type='submit' name='submit' value='Update Event Calendar'>
	</td></tr>";
	echo "</table>";
	echo "</form>";
	exit;
	}
	
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

include("header.php");
echo "<body><hr />
<form method='POST' enctype='multipart/form-data'>";
//$c=count($ARRAY);
$d=$pass_edit;
$skip=array("date","id");
$enlarge=array("activity","comments");
echo "<table border='1' align='center'><tr><th colspan='2'><h2>100th Anniversay Event Entry for $d</h2> $message</th></tr>";
foreach($ARRAY AS $index=>$array)
	{
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="park")
			{
			array_unshift($parkCode,"STWD");
			echo "<tr><td>$fld</td><td><select name='$fld'><option selected=''></option>\n";
			foreach($parkCode as $k=>$v)
				{
				echo "<option value='$v'>$v</option>\n";
				}
			echo "</select></td></tr>";
			continue;
			}
		$col=85; $row=1;
		if(in_array($fld, $enlarge)){$row=10;}
		echo "<tr><td>$fld</td><td><textarea name='$fld' cols='$col' rows='$row'>$value</textarea></td></tr>";
		}
	}
echo "</table>";

include("upload_doc.php");

echo "<table border='1' align='center'><tr><td colspan='3' align='center' bgcolor='green'>
<input type='hidden' name='date' value='$pass_edit'>
<input type='submit' name='submit' value='Submit'>
</td></tr>";
echo "</table>";
echo "</form></body></html>";
?>