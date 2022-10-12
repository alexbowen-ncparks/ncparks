<?php
$mar_db="efile";
$db = mysqli_select_db($connection,$mar_db)       or die ("Couldn't select database");

$user=$_SESSION['mar']['tempID'];

$sql="SELECT t1.*, t2.file_link
FROM documents as t1
LEFT JOIN file_links as t2 on t1.doc_id=t2.doc_id
where t1.cat_id='124'
order by t1.doc_id desc"; //echo $sql;
$result = @MYSQLI_QUERY($connection,$sql) or die (mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
$num=mysqli_num_rows($result);
// echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

if($num<1)
	{$c_family=0; }
	else
	{$c_family=$num;}
	
$exclude=array("cat_id","web_link","guideline_group","clemson_id","added_by");

echo "<div id='MAR' style='display: none'>";
	echo "<table border='1' cellpadding='3'><tr><th colspan='5'>$c_family Monthly Activity Reports</th></tr>";
if($num<1){$ARRAY=array();}

	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				if(in_array($fld,$exclude)){continue;}
				if($fld=="id")
					{echo "<td>View</td>";}
					else
					{echo "<th>$fld</th>";}
				}
			echo "</tr>";
			}
		if(fmod($index,2)==0){$tr=" bgcolor='aliceblue'";}else{$tr="";}
		echo "<tr$tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$exclude)){continue;}
			
			if($fld=="title"){$value="<b>$value</b>";}
			if($fld=="file_link")
				{
				if(!empty($value))
					{
					$link="/efile/".$value;
					$var="<a href=\"$link\" target='_blank'>download MAR</a><br />";	
					$value=$var;
					}
					else
					{$value="";}	
				}
				
			echo "<td valign='top' align='left'>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
echo "</div>";

if(!empty($ARRAY))
	{unset($ARRAY);}

?>