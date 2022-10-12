<?php
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

include("header.php");
echo "<hr />
<form method='POST' enctype='multipart/form-data'>";
//$c=count($ARRAY);
$d=$pass_edit;
$skip=array("eid","dateToday","dist","enterBy","event_type");
$enlarge=array("content","comment");
if(!isset($message)){$message="";}
echo "<table border='1' align='center'><tr><th colspan='2'><h2>100th Anniversay Event Entry for $d</h2> $message</th></tr>";

if(!empty($eid))
	{$act="If necessary, make any changges and click \"Update\".";}
	else
	{$act="Complete the form and click \"Submit\" to add an event.";}
echo "<tr><th colspan='2'>$act</th></tr>";
foreach($ARRAY AS $index=>$array)
	{
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="ann_100")
			{
			$fld_title="Add to 100th Calendar";
			if($array['ann_100']=="x"){$ck100y="checked";$ck100n="";}else{$ck100y="";$ck100n="checked";}
			echo "<tr><td>$fld_title</td><td><input type='radio' name='ann_100' value='x' $ck100y>Yes <input type='radio' name='ann_100' value='' $ck100n>No
			";
			
			echo "</td></tr>";
			continue;
			}
		$req="required";
		if($fld=="dateE")
			{
			$fld_title="date of event";
			$dateE=$d;
			echo "<tr><td>$fld_title</td><td><input type='text' name='$fld' value='$d' size='14'>";
			
			echo "</td></tr>";
			continue;
			}
		if($fld=="park")
			{
			$park=$value;
			$park_array=array();
			if($level==1)
				{
				if(empty($accessPark))
					{$parkCode=array($session_park);}
					else
					{
					$exp=explode(",",$accessPark);
					$park_array=$exp;
					$parkCode=$exp;
					}
				}
			if($level==2)
				{
				$a="array";$b=$_SESSION['parkS'];
				$parkCode=${$a.$b};
				array_unshift($parkCode,"STWD");
				}
			if($level>2)
				{
				array_unshift($parkCode,"STWD");
				}
			echo "<tr><td>$fld</td><td><select name='$fld' $req><option selected=''></option>\n";
			foreach($parkCode as $k=>$v)
				{
				if($v==$value){$s="selected";}else{$s="";}
				echo "<option value='$v' $s>$v</option>\n";
				}
			echo "</select></td></tr>";
			continue;
			}
		$col=85; $row=1;
		if(in_array($fld, $enlarge)){$row=6;}
		
		$fld_title=$fld;
		if($fld=="content")
			{$fld_title="describe the event (seen by public)";}
		
		if($fld=="comment")
			{
			$fld_title="comment for internal use<br />(not seen by public)";
			 $req="";
			 }
		echo "<tr><td>$fld_title</td><td><textarea name='$fld' cols='$col' rows='$row' $req>$value</textarea></td></tr>";
		}
	}
echo "</table>";

include("upload_doc.php");

if(!empty($eid))
	{
	$action="Update";
	$exp=explode("-",$dateE);
	$month=$exp[1];
	$year=$exp[0];
	$success="<tr><td bgcolor='aliceblue' align='center'>The event was successfully entered.
	<form action='cal.php'>
	<input type='hidden' name='month' value='$month'>
	<input type='hidden' name='year' value='$year'>
	<input type='submit' name='submit' value='Return to Calendar'>
	</form></td></tr>";
	}
	else
	{
	$action="Submit";
	$success="";
	}
//echo "<pre>"; print_r($park_array); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
//if(($level <2 and $park==$session_park) or $level > 1 or in_array($park,$park_array))
if($_SESSION['dprcoe']['level'] >0)
	{
	echo "<table border='1' align='center'><tr><td colspan='3' align='center' bgcolor='green'>";
	if(!empty($eid)){echo "<input type='hidden' name='eid' value='$eid'>";}
	echo "<input type='submit' name='submit' value='$action'>
	</td></tr></form>
	$success";
	echo "
	<tr><td>&nbsp;</td></tr>
	<tr><td colspan='3' align='center' bgcolor='red'>
	<form method='POST' action='edit.php'>
	<input type='hidden' name='park' value='$park'>";
	if(!empty($eid)){echo "<input type='hidden' name='eid' value='$eid'>";}
	echo "<input type='submit' name='Submit' value='Delete' onclick=\"return confirm('Are you sure you want to delete?')\"></form></td></tr>";
	}
echo "</table>";
echo "</body></html>";
?>