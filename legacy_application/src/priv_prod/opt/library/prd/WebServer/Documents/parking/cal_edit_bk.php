<?php
unset($ARRAY);

if(!empty($_POST))
	{
	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	$sql="UPDAE dates 
	SET 
	where date_id like '$pass_edit'"; //echo "$sql";
	//$result = @mysql_query($sql, $connection) or die(mysql_error());
	}

if((isset($month) AND isset($year)) OR $pass_edit=="")
	{
	exit;
	}

$sql="SELECT * from dates where date_id like '$pass_edit'"; //echo "$sql";
$result = @mysql_query($sql, $connection) or die(mysql_error());
while($row=mysql_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

if(empty($ARRAY) AND isset($pass_edit))
	{
	echo "Add p=$pass_edit"; exit;
	}

$edit_array=array("am_slot","pm_slot","all_day");
echo "<hr />
<form method='POST'>
<table align='center' border='1'>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if($fld=="tempID"){$fld="name";}
			if($fld=="am_slot"){$fld.="<br />5am to 12 noon";}
			if($fld=="pm_slot"){$fld.="<br />12 noon to 8pm";}
			if($fld=="all_day"){$fld.="<br />5am to 8pm";}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		$input=$value;
		if(in_array($fld,$edit_array))
			{
			if(!empty($value)){$ck="checked";}else{$ck="";}
			$fld=$fld.$array['space'];
			$input="<input type='checkbox' name='$fld' value='$value' $ck>";
			}
		echo "<td align='center'>$input</td>";
		}
	echo "</tr>";
	}
echo "<tr><td colspan='6' align='center' bgcolor='green'>
<input type='hidden' name='pass_edit' value='$pass_edit'>
<input type='submit' name='submit' value='Submit'>
</td></tr>";
echo "</table></form>";
?>