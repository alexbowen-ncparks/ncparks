<?php

mysqli_select_db($connection,$dbName);
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
$skip=array("submit_form");
$equal_array=array("park_code","disposition","category","sub_cat");
FOREACH($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	if(empty($value)){continue;}
	if(in_array($fld,$equal_array))
		{$temp[]=$fld."='".$value."'";}
		else
		{$temp[]=$fld." like '%".$value."%'";}
	
	}
if(empty($temp))
	{$clause="1";}
	else
	{$clause=implode(" and ",$temp);}

$sql="SELECT t1.*, t2.link 
from permit as t1
left join file_upload as t2 on t1.id=t2.track_id
 WHERE $clause"; //ECHO "$sql"; exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
if(mysqli_num_rows($result)>0)
	{
	$skip=array();
	$c=count($ARRAY);
	echo "<table border='1'><tr><td>$c</td></tr>";
	foreach($ARRAY AS $index=>$array)
		{
		$id=$array['id'];
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			if($fld=="link" and !empty($value))
				{$value="<a href='$value' target='_blank'>photo</a>";}
			if($fld=="id")
				{$value="<a href='edit_form.php?id=$id'>Edit</a>";}
			if($fld=="comments" and strlen($value)>100)
				{$value=substr($value,0,100)."...";}
				
				
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
		echo "</table>";
}
else
{
$c=0;
echo "No item was found using $clause";
}
	
?>