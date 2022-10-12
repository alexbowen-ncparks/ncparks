<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="hr";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
//include("../../include/get_parkcodes_i.php"); // database connection parameters
mysqli_select_db($connection,"hr"); // database
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

echo "<html><head></head><body>";

echo "<table align='center'><tr><th>
<h2><font color='purple'>NC DPR Seasonal Employee Tracking Database</font></h2></th></tr>
<tr><td><a href='start.php'>Return to Home Page</a></td></tr>
</table>";

if(!empty($_POST))
	{
	extract($_POST);
$query="SELECT * from hr_forms where tempID like '$last_name%'";
if(!empty($parkcode))
	{$query.=" and parkcode = '$parkcode'";}
if(!empty($upload_date))
	{$query.=" and upload_date like '$upload_date%'";}
if(!empty($beacon_num))
	{$query.=" and beacon_num = '$beacon_num'";}

$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
if(!empty($ARRAY))
	{
	$c=count($ARRAY);
	echo "<table><tr><td cellspan='2'>$c documents</td></tr>";
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
			if($fld=="file_link")
				{
				$loc="https://10.35.152.9/hr194/".$value;
				$loc="https://10.35.152.9/hr194/".$value;
				$value="<a href='$loc'>View</a>";
				}
		
			if($fld=="job_description")
				{
				$exp=explode("-",$value);
				$value=$exp[0];}
		
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
	}
	else
	{echo "No one was found."; }
}
echo "<form method='POST' action='hiring_documents.php'><table>
<tr><td>Enter last name of empoyee: <input type='text' name='last_name' value=\"\"></td>
<td>Park: <input type='text' name='parkcode' value=\"\"></td>
<td>Year: <input type='text' name='upload_date' value=\"\"></td>
<td>BEACON Position Number: <input type='text' name='beacon_num' value=\"\"></td>
</tr>
<tr><td><input type='submit' name='submit' value=\"Find\"></td></tr>
</table></form>";
echo "</body></html>";
?>