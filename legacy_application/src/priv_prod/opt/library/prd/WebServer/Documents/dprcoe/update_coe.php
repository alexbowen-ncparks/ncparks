<?php
ini_set('display_errors',1);
$database="dprcoe";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/connectROOT.inc"); 

date_default_timezone_set('America/New_York');

// **********************************************

//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
$pass_edit=$_POST['pass_edit'];
	
mysql_select_db('dprcoe', $connection); // database
// zero out all ann_100 for that date
$sql="UPDATE event set `ann_100`='' where dateE='$pass_edit'"; ECHO "$sql"; exit; 
$result = @mysql_query($sql, $connection) or die(mysql_error());

// zero out all year16_100 for that date
list($year,$month,$day)=explode("-",$pass_edit);
$new_date="2016-".$month."-".$day;
$sql="UPDATE year_2016 set `year16_100`='' where dateE='$new_date'"; ECHO "$sql"; exit; 
$result = @mysql_query($sql, $connection) or die(mysql_error());

IF(!empty($_POST['actual']))
	{
	foreach($_POST['actual'] AS $id=>$val)
		{
		$sql="UPDATE event set `ann_100`='x' where eid='$id'"; //ECHO "$sql"; exit; 
		$result = @mysql_query($sql, $connection) or die(mysql_error());
		}
	}
	
IF(!empty($_POST['ann_100']))
	{
	foreach($_POST['ann_100'] AS $id=>$val)
		{
		$sql="UPDATE event set `ann_100`='x' where eid='$id'"; //ECHO "$sql"; exit; 
		$result = @mysql_query($sql, $connection) or die(mysql_error());
		}
	}
	
IF(!empty($_POST['year_2016']))
	{
	foreach($_POST['year_2016'] AS $eid=>$val)
		{
		$sql="SELECT * FROM event where eid='$eid'"; //ECHO "$sql"; exit; 
		$result = @mysql_query($sql, $connection) or die(mysql_error());
		$row=mysql_fetch_array($result);
		extract($row);
		
		list($year,$month, $day)=explode("-",$dateE);
			$newdate2016="2016-".$month."-".$day;
			$title=addslashes($title);
			$content=addslashes($content);
			$enterBy=addslashes($enterBy);
			$comment=addslashes($comment);
			$query = "REPLACE year_2016 SET title='$title', content='$content', dateE='$newdate2016', comment='$comment', start_time='$start_time', start_location='$start_location', enterBy='$enterBy', year16_100='$val', eid='$eid', park='$park'
			 ";    //echo "$query"; exit;
			$result = mysql_query($query) or die ("Couldn't execute query. $query");
		}
	}
	
header("Location: new_entry.php?pass_edit=$pass_edit");
?>