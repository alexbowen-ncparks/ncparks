<?php
ini_set('display_errors',1);
extract($_REQUEST);
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  //exit;

	include_once("_base_top.php");// includes session_start();

$level=@$_SESSION['eeid']['level'];
//if($level<1){echo "You do not have access to this database. Contact Tom Howard for more info. tom.howard@embarqmail.com"; exit;}

$db="eeid";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database)       or die ("Couldn't select database");

$sql="SELECT distinct park_code
FROM `programs` as t1
where 1 order by park_code";  
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$park_array[]=$row['park_code'];
		}
	echo "<table><tr><td><form>Select park: <select name='park_code' onchange=\"this.form.submit()\"><option selected=''></option>\n";
	foreach($park_array as $k=>$v)
		{
		if(empty($v)){continue;}
		echo "<option value='$v'>$v</option>\n";
		}
	echo "</select></form></td></tr></table>";

if(empty($park_code))
	{
	exit;
	}
$ARRAY=array();	
$sql="SELECT t1.*, concat(park_code,id) as park_id 
FROM `programs` as t1
where 1 and park_code='$park_code'";  //echo "$sql";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}

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
		$fld_trip_summary=$ARRAY[$index]['field_trip_summary'];
		$title="<font color='blue'>$value</font>";
		if($level>1)
			{
// 			$value=$title." - <a href='add_field_trip.php?edit=$id'>edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='field_trip_pdf.php?edit=$id' target='_blank'>pdf</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='field_trip_del.php?del=$id' onclick=\"return confirm('Are you sure you want this Field Trip?')\">Delete</a>";


			$value=$title." - <a href='edit_program.php?id=$id'>edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='field_trip_pdf.php?edit=$id' target='_blank'>pdf</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href='field_trip_del.php?del=$id' onclick=\"return confirm('Are you sure you want this Field Trip?')\">Delete</a>";
			}
			else
			{
			$value=$title." - <a href='field_trip_pdf.php?edit=$id' target='_blank'>pdf</a>";
			}
		}
	if($fld=="field_trip_summary")
		{
		if(!empty($value))
			{
			$value.=" <a href='field_trip.php?park_code=$park_code'>View/
			Edit Field Trip</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
// 			$value="View
// 			 <a onclick=\"toggleDisplay('photo[$index]');\" href=\"javascript:void('')\">  Photo</a>
// 			 <div id=\"photo[$index]\" style=\"display: none\"><img src='$value'></div>   ";
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
	echo "<tr><th align='left'>$fld</th><td>$value</td></tr>";}
echo "</table><hr />";
	}
		
echo "</body></html>";
mysqli_close($connection);
?>