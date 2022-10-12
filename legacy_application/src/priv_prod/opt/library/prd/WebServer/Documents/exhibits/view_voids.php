<?php
ini_set('display_errors', 1);
extract($_REQUEST);
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;
	// check for malicious redirect
		$findThis="http:";
		$testThis=strtolower($_SERVER['REQUEST_URI']);
		$ip_address=strtolower($_SERVER['REMOTE_ADDR']);
	$pos=strpos($testThis,$findThis);
		if($pos>-1){
		header("Location: http://www.fbi.gov");
		exit;}

if(empty($connection))
	{
	$db="mns";
	include("../../include/connectNATURE123.inc"); // database connection parameters
	$db = mysql_select_db($database,$connection)       or die ("Couldn't select database");
	}

include("_base_top.php");

$sql="select * from void_request where 1 order by work_order_id desc";
//	echo "$sql";
$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql<br>c=$connection to $db");
while($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
//	echo "<pre>"; print_r($ARRAY); echo "</pre>";
if(empty($ARRAY))
	{
	echo "<font color='purple'>No request was found matching the above criterion/criteria.</font><br />";
	}
	else
	{
	echo "<table border='1'>";
	foreach($ARRAY as $index=>$array)
		{
		if($index==0)
		{
		echo "<tr><td colspan='3'>These requests are not active.</td></tr>";
		echo "<tr>";
		foreach($ARRAY[0] as $fld=>$val)
			{echo "<th>$fld</th>";}
		echo "</tr>";
		}
		echo "<tr>";
		foreach($array as $fld=>$val)
			{
			if($fld=="work_order_id")
				{
			//	$val="<a href='work_order_form.php?pass_id=$val'>Edit/View</a>";
				}
			echo "<td>$val</td>";
			}
		}
	echo "</tr>";
	}
	echo "</table>";


echo "</div>
</div></body></html>";

?>