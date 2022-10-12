<?php

mysqli_select_db($connection,$dbName);
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
$skip=array("submit_form","select_table");
$equal_array=array("park_code","disposition","category","sub_cat");
FOREACH($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	if(empty($value)){continue;}
	if(in_array($fld,$equal_array))
		{$temp[]=$fld."='".$value."'";}
		else
	//	{$temp[]=$fld." like '%".$value."%'";}
		{$temp[]=$fld."='".$value."'";}
	
	}
if(empty($temp))
	{$clause="1";}
	else
	{$clause=implode(" and ",$temp);}


// , t2.link 
// left join file_upload as t2 on t1.id=t2.track_id
$sql="SELECT t1.*
from $select_table as t1
 WHERE $clause"; ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
if(mysqli_num_rows($result)>0)
	{
	$skip=array();
	$c=count($ARRAY);
	echo "<table border='1'><tr><td>$c</td></tr>";
	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				if(substr($fld,-3,3)=="_id" and empty($table_id))
					{$table_id=$fld;}
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
			if($fld==$table_id)
				{$value="<a href='view_form.php?select_table=$select_table&$table_id=$value'>View</a> $value";}
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
echo "<br /><font color='magenta'>No item was found using $clause</font>";
}
	
?>