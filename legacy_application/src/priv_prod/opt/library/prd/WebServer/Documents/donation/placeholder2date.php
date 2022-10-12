<?php
ini_set('display_errors',1);
$database="donation";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 
include("../../include/get_parkcodes_i.php"); // used to authenticate users
mysqli_select_db($connection,$database); // database

date_default_timezone_set('America/New_York');
extract($_REQUEST);
// **********************************************
if(empty($id))
	{
	echo "No record specified.";
	exit;
	}

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;

IF(!empty($_POST['submit']))
	{
//	echo "This hasn't been implemented yet. Unsure of potential duplication. Call Tom with any suggestion.<br /><br />Click your back button.<pre>"; 
	
echo "<pre>";print_r($_POST); print_r($_FILES);echo "</pre>";  //exit;
	$skip_post=array("submit","attachment_num","id");
	$id=$_POST['id'];
	foreach($_POST AS $fld=>$val)
		{
		if(in_array($fld,$skip_post)){continue;}
		
		@$clause.=$fld."='".$val."',";
		}
		$clause=rtrim($clause,",");
	$sql="UPDATE dprcoe.year_2016 set $clause where id='$id'"; 
	
	ECHO "$sql"; exit; 
	$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
	$id=mysqli_insert_id($connection);
	
	include("upload_files.php");
	}

$sql="SELECT * from dprcoe.year_2016 where eid='$id'"; //echo "$sql";
$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));

while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
include("header.php");
echo "<body>";
$pass_edit=$_REQUEST['pass_edit'];
echo "<table border='1' cellpadding='5'>
	<tr>
	<td colspan='4' bgcolor='green'>
	<form action='new_entry.php'>";
	echo "<input type='hidden' name='placeholder' value='1'>";
	echo "
	<input type='hidden' name='pass_edit' value='$pass_edit'>
	<input type='submit' name='return' value='Return to Placeholder $pass_edit'></form>
	</td></tr></table>";

echo "<hr />
<form method='POST' enctype='multipart/form-data'>";

$skip=array("date","eid","dist","enterBy","dateToday","year16_100");
$enlarge=array("content","comment");
echo "<table border='1' align='center'><tr><th colspan='2'><h2>Entry for 2016 Calendar</h2></th></tr>";
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
				if($value==$v){$s="selected";}else{$s="";}
				echo "<option $s='$v'>$v</option>\n";
				}
			echo "</select></td></tr>";
			continue;
			}
		if($fld=="dateE")
			{
			echo "<tr><td>Date:</td><td><input id='datepicker1' type='text' value='$value'/></td></tr>";
			continue;
			}
		$col=85; $row=1;
		if(in_array($fld, $enlarge)){$row=5;}
		echo "<tr><td>$fld</td><td><textarea name='$fld' cols='$col' rows='$row'>$value</textarea></td></tr>";
		}
	}
echo "</table>";

include("upload_doc.php");

echo "<table border='1' align='center'><tr><td colspan='3' align='center' bgcolor='green'>
<input type='hidden' name='id' value='$id'>
<input type='submit' name='submit' value='Submit'>
</td></tr>";
echo "</table>";
echo "</form></body></html>";
?>