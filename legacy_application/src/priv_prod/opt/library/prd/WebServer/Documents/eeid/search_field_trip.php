<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
ini_set('display_errors',1);
extract($_REQUEST);
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;

	include_once("_base_top.php");// includes session_start();

$level=@$_SESSION['eeid']['level'];
//if($level<1){echo "You do not have access to this database. Contact Tom Howard for more info. tom.howard@embarqmail.com"; exit;}


$db="eeid";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database)       or die ("Couldn't select database");

$sql="SELECT distinct park_code
FROM `field_trip` as t1
where 1 order by park_code";  
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$park_array[]=$row['park_code'];
		}
$sql="SELECT distinct grades
FROM `field_trip` as t1
where 1 order by grades";  
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$grade_array[]=$row['grades'];
		}
$sql="SELECT distinct id,nc_standard
FROM `scos` as t1
where 1 order by nc_standard";  
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$scos_array[$row['id']]=$row['nc_standard'];
		}
		
	echo "<form><table><tr><td>Select park: <select name='park_code'><option selected=''></option>\n";
	foreach($park_array as $k=>$v)
		{
		if($park_code==$v){$s="selected";}else{$s="";}
		echo "<option value='$v' $s>$v</option>\n";
		}
	echo "</select></td>";
	
	echo "<td>Select grade: <select name='grade'><option selected=''></option>\n";
	foreach($grade_array as $k=>$v)
		{
		if($grade==$v){$s="selected";}else{$s="";}
		echo "<option value='$v' $s>$v</option>\n";
		}
	echo "</select></td>";
	
	echo "<td>Select Curriculum Standard: <select name='scos'><option selected=''></option>\n";
	foreach($scos_array as $k=>$v)
		{
		if(@$scos==$k){$s="selected";}else{$s="";}
		echo "<option value='$k' $s>$v</option>\n";
		}
	echo "</select></td>";
	
	echo "<td>
	<input type='submit' name='submit' value='Search'>
	</td>";
	echo "</tr></table></form><hr />";

if(empty($park_code) and empty($grade) and empty($scos))
	{
	exit;
	}

$clause="";
if(!empty($park_code))
	{$clause.="and t1.park_code='$park_code'";}
if(!empty($grade))
	{$clause.=" and t1.grades='$grade'";}
$join1="";
if(!empty($scos))
	{
	$join1="LEFT JOIN field_trip_scos as t2 on concat(t1.park_code, t1.id)=t2.park_id";
	$clause.=" and t2.correlation='$scos'";
	}	
	
$sql="SELECT t1.*, concat(t1.park_code, t1.id) as park_id 
FROM `field_trip` as t1
$join1
where 1 $clause
order by t1.park_code"; // echo "$sql";
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

if(empty($ARRAY))
	{echo "Nothing found."; exit;}
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
		$value=$title." - <a href='add_field_trip.php?edit=$id'>edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='field_trip_pdf.php?edit=$id' target='_blank'>pdf</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='field_trip_del.php?del=$id' onclick=\"return confirm('Are you sure you want this Field Trip?')\">Delete</a>";
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
		$value="<a onclick=\"toggleDisplay('$park_id');\" href=\"javascript:void('')\">view &nbsp;&raquo;&nbsp</a>
		<div id=\"$park_id\" style=\"display: none\">";
		if(!empty($correlation_array[$park_id]))
			{
			foreach($correlation_array[$park_id] as $c_k=>$c_v)
				{
				$value.="<b>".$c_k."</b> - ".$c_v."<br />";
				}
			$value.="</div>";
			}
		}
	echo "<tr><th valign='top'>$fld</th><td>$value</td></tr>";}
echo "</table><hr />";
	}
		
echo "</body></html>";
mysqli_close($connection);
?>