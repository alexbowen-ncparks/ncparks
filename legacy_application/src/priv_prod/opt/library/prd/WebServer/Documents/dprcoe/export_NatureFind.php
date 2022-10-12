<?php
$database="dprcoe";
include("../../include/connectROOT.inc");
include("../../include/get_parkcodes.php");
date_default_timezone_set('America/New_York');

$today=date("Y-m-d");
$where="where dateE>='$today'";
$content="";

mysql_select_db($database,$connection); 
	$sql2 = "SELECT park, dateE as event_date, title, start_time, start_location, content as program_description
 FROM event $where
	order by dateE,park";
	$result = @mysql_query($sql2, $connection) or die("Error #". mysql_errno() . ":  $sql2" . mysql_error());
	//    echo "$sql2";exit;
	$numrow = mysql_num_rows($result);
if($numrow>0)
	{
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=NC_State_Parks_Events.xls');
	while($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	}
echo "<table>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			echo "<td>$fld</t>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if($fld=="park"){$value=$parkCodeName[$value];}
		$value=str_replace("<br />"," ",$value);
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";

?>