<?php
ini_set('display_errors',1);
extract($_REQUEST);
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  //exit;

	include_once("_base_top.php");// includes session_start();

$level=@$_SESSION['eeid']['level'];
//if($level<1){echo "You do not have access to this database. Contact Tom Howard for more info. tom.howard@embarqmail.com"; exit;}


$db="eeid";
include("../../include/connect_i_ROOT.inc"); // database connection parameters
$db = mysqli_select_db($connection,$database)       or die ("Couldn't select database");

$sql="SELECT distinct park_code
FROM `field_trip` as t1
where 1 order by park_code";  
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$park_array[]=$row['park_code'];
		}
	echo "<table><tr><td><form>Select park: <select name='park_code' onchange=\"this.form.submit()\"><option selected=''></option>\n";
	foreach($park_array as $k=>$v)
		{
		echo "<option value='$v'>$v</option>\n";
		}
	echo "</select></form></td></tr></table>";

if(empty($park_code))
	{
	exit;
	}
	
$sql="SELECT t1.*, concat(park_code,id) as park_id 
FROM `field_trip` as t1
where 1 and park_code='$park_code'";  //echo "$sql";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		$park_id=$row['park_id'];
		$sql="SELECT t1.* , t2.nc_standard, t2.description
		FROM `field_trip_scos` as t1
		LEFT JOIN scos as t2 on t1.correlation=t2.id
		where 1 and park_id='$park_id'
		order by t2.grade, t2.id";  //echo "$sql";
		$result1 = mysqli_query($connection,$sql);
		while($row1=mysqli_fetch_assoc($result1))
			{
			$correlation_array[$park_id][$row1['nc_standard']]=$row1['description'];
			}
		}
//echo "<pre>"; print_r($correlation_array); echo "</pre>"; // exit;
		
$skip=array("id");

foreach($ARRAY AS $index=>$array)
	{
echo "<table>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
	if($fld=="program_title")
		{
		$id=$ARRAY[$index]['id'];
		$title="<font color='blue'>$value</font>";
		if($level>1)
			{
			$value=$title." - <a href='add_field_trip.php?edit=$id'>edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='field_trip_pdf.php?edit=$id' target='_blank'>pdf</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='field_trip_del.php?del=$id' onclick=\"return confirm('Are you sure you want this Field Trip?')\">Delete</a>";
			}
			else
			{
			$value=$title." - <a href='field_trip_pdf.php?edit=$id' target='_blank'>pdf</a>";
			}
		}
	if($fld=="photo_link")
		{
		if(!empty($value))
			{
			$value="View
			 <a onclick=\"toggleDisplay('photo[$index]');\" href=\"javascript:void('')\">  Photo</a>
			 <div id=\"photo[$index]\" style=\"display: none\"><img src='$value'></div>   ";
			}
		
		}
	if($fld=="park_id")
		{
		$fld="correlation";
		$park_id=$value;
		$value="";
		if(!empty($correlation_array[$park_id]))
			{
			foreach($correlation_array[$park_id] as $c_k=>$c_v)
				{
				$value.="<b>".$c_k."</b> - ".$c_v."<br />";
				}
			}
		}
	echo "<tr><th valign='top'>$fld</th><td>$value</td></tr>";}
echo "</table><hr />";
	}
		
echo "</body></html>";
mysqli_close($connection);
?>