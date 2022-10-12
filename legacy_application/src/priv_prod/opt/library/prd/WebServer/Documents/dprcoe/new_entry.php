<?php

$database="dprcoe";
include("../../include/auth.inc"); // used to authenticate users
$level=$_SESSION[$database]['level'];
if($level>3)
	{ini_set('display_errors',1);}

include("../../include/connectROOT.inc"); 
include("../../include/get_parkcodes.php"); // used to authenticate users
mysql_select_db($database, $connection); // database

date_default_timezone_set('America/New_York');
extract($_REQUEST);
// **********************************************
if(empty($eid))
	{
	if(empty($pass_edit))
		{
		echo "No date specified.";
		exit;
		}
	}

$level=$_SESSION['dprcoe']['level'];
$session_park=$_SESSION['dprcoe']['park'];
$accessPark=$_SESSION['dprcoe']['accessPark'];

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

IF(!empty($_POST['submit']))
	{
//	echo "<pre>"; print_r($_POST); print_r($_FILES);echo "</pre>";  exit;
	$skip_post=array("submit","attachment_num","eid");
	foreach($_POST AS $fld=>$val)
		{
		if(in_array($fld,$skip_post)){continue;}
		$val=mysql_real_escape_string($val);
		@$clause.=$fld."='".$val."',";
		}
		$clause=rtrim($clause,",");
	if($submit=="Update")
		{
		$sql="update event set $clause where eid='$eid'"; //ECHO "$sql"; exit; 
		}
		else
		{
		$sql="INSERT INTO event set $clause "; //ECHO "$sql"; exit;
		 }
	$result = @mysql_query($sql, $connection) or die(mysql_error());
	if(empty($eid))
		{$eid=mysql_insert_id();}
	
	
	include("upload_file.php");
//	exit;
	}

if(!empty($eid))
	{
	$sql="SELECT *
	from dprcoe.event
	where eid = '$eid'
	";
	//	echo "$sql"; //exit;
	$result = @mysql_query($sql, $connection) or die(mysql_error());
	while($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	$pass_edit=$ARRAY[0]['dateE'];
	include("new_entry_form.php");
	exit;
	}
	else
	{
list($year,$month, $day)=explode("-",$pass_edit);
$newdate2016="2016-".$month."-".$day;


$sql="SELECT *
from dprcoe.event
where dateE = '$pass_edit' and ann_100='x'
order by dateE, park
"; 
//echo "$sql";
$result = @mysql_query($sql, $connection) or die(mysql_error());
	while($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
//	echo "$sql<pre>"; print_r($ARRAY); echo "</pre>";  exit;
	}
	



if(@$submit=="Add an Event")
	{
	$ARRAY="";
	$message="Add an Event.";
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


	$sql="SHOW COLUMNS from event";
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

	echo "<input type='hidden' name='month' value='$month'>
	<input type='hidden' name='year' value='$year'>
	<input type='submit' name='submit' value='Return to $pass_edit'>
	</form>
	</td>
	<td bgcolor='cyan'><form action='new_entry.php'>";
	
	echo "<input type='hidden' name='pass_edit' value='$pass_edit'>
	<input type='hidden' name='new' value='1'>
	<input type='submit' name='submit' value='Add an Event'></form></td></tr></table>";

//echo "<pre>"; print_r($ARRAY); print_r($yr_2016_array); echo "</pre>"; // exit;	

$skip=array("eid");
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
			if($fld=="ann_100")
				{
				$test_value=$value;
					$eid=$array['eid']; // target='_blank'
				//	$value="<a href='/dprcoe/edit.php?eid=$eid'>Yes</a><br />";
					$value="<a href='/dprcoe/new_entry.php?eid=$eid'>Edit</a>";
				if($test_value=="100th")
					{
					$value="<a href='cal_edit.php?eid=$eid''>".$test_value."</a><br />";
					}
				if($test_value=="placeholder")
					{
					$value="<a href='placeholder2date.php?pass_edit=$pass_edit&eid=$eid''>".$test_value."</a><br />";
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
	
	echo "</table>";
	echo "</form>";
	exit;
	}
	
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

include("new_entry_form.php");

?>