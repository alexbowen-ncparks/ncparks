<?php
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,'divper');

if(isset($ARRAY)){unset($ARRAY);}
$sql="SELECT t2.* , t3.established, t3.reclassified, t3.transfer_w_in_div, t3.transfer_out_div, t3.fund_shift, t3.abolished, t3.comment
FROM position_090901 as t2
LEFT JOIN position as t1 ON t2.beacon_num = t1.beacon_num
LEFT JOIN position_history as t3 ON t3.beacon_num = t2.beacon_num
WHERE t1.beacon_num IS NULL
order by t2.park"; //echo "$sql";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");

while ($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
$count=count($ARRAY);

$skip=array("seid","previous_salary","markDel","code","toggle","o_chart","fund_source_GRF","posMod","salary_grade","current_salary","reason");
echo "<table><tr><td colspan='10'><b>$count</b> Positions present on 2009-09-01 (table `divper.position_090901`) but NOT present on 2010-07-01 (`diverp.position` table on that date)</td></tr>";

	echo "<tr>";
	foreach($ARRAY[0] as $fld=>$val)
		{
		if(in_array($fld,$skip)){continue;}
		echo "<td>$fld</td>";
		}
	echo "</tr>";
	
foreach($ARRAY as $index=>$array)
	{
	echo "<tr>";
	foreach($array as $k=>$v)
		{
		if(in_array($k,$skip)){continue;}
		if($k=="posNum")
			{
			$a="4309000000".$v;
			$v="<a href='position_history_update.php?pmis=$a&submit=submit' target='_blank'>$a</a>";}
		echo "<td>$v</td>";
		}
	echo "</tr>";
	}
echo "</table>";
?>