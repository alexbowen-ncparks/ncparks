<?php
ini_set('display_errors',1);

include("../../include/get_parkcodes_i.php");
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
$file="find";
include("inventory.php");
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

if(@$_REQUEST['location']!="")
	{
	date_default_timezone_set('America/New_York');
	$today=date("Y-m-d");
	$sql="UPDATE surplus_track
	set bo_date='$today'
	where chop_date !='0000-00-00' and location='$_REQUEST[location]' and ts='$_REQUEST[ts]'
	";
//	echo "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	}
	
	
	$sql="SELECT id, ts, location, center, fas_num, serial_num, model_num, qty, description, `condition`, chop_date, photo_upload
	from surplus_track
	where chop_date !='0000-00-00' and bo_date='0000-00-00'
	order by location
	";
//	echo "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	while ($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

if(empty($ARRAY)){echo "There are no items needing to be surplused at this time."; exit;}
$c=count($ARRAY);

echo "<form>";
echo "<table><table border='1' cellpadding='5'><tr><td colspan='9'></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if($fld=="photo_upload" and !empty($value))
			{
			$value="<a href='$value' target='_blank'>view</a>";
			}
		echo "<td>$value</td>";
		if($fld=="photo_upload" and (@$ARRAY[$index]['location']!=@$ARRAY[$index+1]['location']) and $c!=1 )
			{
			$loc=@$ARRAY[$index-1]['location'];
			$curr_loc=@$ARRAY[$index]['location'];
			$curr_ts=$ARRAY[$index]['ts'];
			echo "<tr>
			<td colspan='4' bgcolor='cyan'>Print Surplus Form for <a href='pdf_surplus.php?location=$curr_loc'>$curr_loc</a></td>";
			if($_SESSION['fixed_assets']['original_level']>3)
				{
				echo "<td bgcolor='allceblue'>Mark as complete: 
			<input type='hidden' name='ts' value=\"$curr_ts\">
			<input type='checkbox' name='location' value='$curr_loc' onchange=\"this.form.submit()\"></td>";
				}
			echo "</tr>";
			}
		}
	echo "</tr>";
	}
if($c==1)
	{
	$curr_loc=$ARRAY[$index]['location'];
	echo "<tr>
			<td colspan='4' bgcolor='cyan'>Print Surplus Form for <a href='pdf_surplus.php?location=$curr_loc'>$curr_loc</a></td>
			<td bgcolor='allceblue'>Mark as complete: <input type='checkbox' name='location' value='$curr_loc' onchange=\"this.form.submit()\"></td>
			</tr>";
	}	
echo "</table></form>"; 
 
 ?>