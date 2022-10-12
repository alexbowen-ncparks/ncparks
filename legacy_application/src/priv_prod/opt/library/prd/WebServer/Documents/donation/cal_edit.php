<?php
ini_set('display_errors',1);
$database="donation";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 
include("../../include/get_parkcodes_i.php");


mysqli_select_db($connection,$database); // database

date_default_timezone_set('America/New_York');
extract($_REQUEST);
// **********************************************
if((isset($month) AND isset($year)) OR $id=="")
	{
	echo "No date specified.";
	exit;
	}

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;

if(isset($submit) AND !empty($id))
	{
	if($submit=="Delete Item")
		{
		$sql="DELETE FROM calendar where id='$id'"; //ECHO "$sql"; exit; 
		$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
		header("Location: new_entry.php?pass_edit=$pass_edit");
		exit;
		}
	}
	
IF(!empty($_POST['id']))
	{
//	echo "<pre>"; print_r($_REQUEST);  print_r($_FILES); echo "</pre>";  exit;
	$skip_post=array("id","submit","attachment_num","link","original_name");
	$id=$_POST['id'];
	foreach($_POST AS $fld=>$val)
		{
		if(in_array($fld,$skip_post)){continue;}
		
		@$clause.=$fld."='".$val."',";
		}
		$clause=rtrim($clause,",");
	$sql="UPDATE calendar set $clause where id='$id'"; //ECHO "$sql"; exit; 
	$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
	
	include("upload_files.php");
	
	}


$sql="SELECT distinct t1.* from calendar as t1
where t1.id = '$id'"; //echo "$sql";
$result = @mysqli_query($connection,$sql) or die("$sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
//echo "$sql<pre>"; print_r($ARRAY); echo "</pre>";  exit;

if(empty($ARRAY) AND isset($id))
	{
	echo "NOTHING found for that date"; exit;
	}

include("header.php");
echo "<body>";
//$c=count($ARRAY);
$d=$ARRAY[0]['date'];
$skip=array("date","id");
$enlarge=array("activity","comments");

	list($year,$month,$day)=explode("-",$d);
echo "<table border='1' align='center'><tr><td colspan='2' bgcolor='beige'>
<form action='cal.php'>
	<input type='hidden' name='month' value='$month'>
	<input type='hidden' name='year' value='$year'>
	<input type='submit' name='submit' value='Return to $d'></form><h2>Entry for $d</h2></td>
	</tr>
<form method='POST' action='cal_edit.php' enctype='multipart/form-data'>";
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
				if($v==$array['park']){$s="selected";}else{$s="value";}
				echo "<option $s='$v'>$v</option>\n";
				}
			echo "</select></tr></tr>";
			continue;
			}
		$col=85; $row=1;
		if(in_array($fld, $enlarge)){$row=10;}
		echo "<tr><td>$fld</td><td><textarea name='$fld' cols='$col' rows='$row'>$value</textarea></td></tr>";
		}
	}
echo "<table>";

include("upload_doc.php");

echo "<table border='1' align='center'><tr><td colspan='3' align='center' bgcolor='green'>
<input type='hidden' name='id' value='$id'>
<input type='submit' name='submit' value='Update'></form>
</td>

<td bgcolor='red'><form action='cal_edit.php'>
	<input type='hidden' name='pass_edit' value='$d'>
	<input type='hidden' name='id' value='$id'>
	<input type='submit' name='submit' value='Delete Item' onClick=\"return confirmLink()\"></form></td></tr>";
echo "</table></body></html>";
?>