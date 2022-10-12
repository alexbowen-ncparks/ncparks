<?php
$database="program_share";
$title="I&E Mind Meld";
include("../_base_top.php");
echo "Welcome to the <b>I&E Mind Meld</b>. A place to find and share programming ideas.

	<br /><br />I&E connects visitors to our parks and natural resources, in enjoyable ways, so that they care.  Use these successful and creative ideas.  Add your own program ideas too!
	";

$db="program_share";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database)       or die ("Couldn't select database");

$sql="SELECT * from resource";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection)."<br />$sql");
while($row=mysqli_fetch_assoc($result))
	{
	$resource_array[$row['resource_id']]=$row['resource_name'];
	}
	
$sql="SELECT t1.item_id, t1.resource_id, t3.subject, t3.topic, t1.program_title, t1.description, t1.submitter, group_concat(t4.thumb_link) as thumbnail
FROM item as t1
left join subject as t3 on t1.subject_id=t3.subject_id
left join item_upload_thumb as t4 on t1.item_id=t4.item_id
where 1 
group by t1.item_id
order by t1.item_id desc limit 10
"; 
//		echo "$sql";

$result = mysqli_query($connection,$sql) or die(mysqli_error($connection)."<br />$sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
if(empty($ARRAY)){echo "Nothing found."; exit;}

$skip=array("method","date_c","enter_by","");
foreach($ARRAY AS $index=>$array)
	{
	if($index>1000 and empty($rep)){break;}
	if($index==0)
		{
		echo "<table><tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$new_fld=str_replace("_"," ",$fld);
			if($fld=="item_id")
				{$new_fld="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}
			echo "<th valign='bottom'>$new_fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="item_id")
			{
			$value="<a href='program.php?item_id=$value'>[ View ]</a>";
			}
		if($fld=="resource_id")
			{
			$var="";
			$exp=explode(",",$value);
			foreach($exp as $k=>$v)
				{$var.="[".$resource_array[$v]."] ";}
			$value=$var;	
			} 
		if($fld=="thumbnail")
			{
			$exp0=explode(",", $value);
			foreach($exp0 as $index=>$value)
				{
				$exp=explode("/",$value);
				$temp=array_pop($exp);
				$thumb=implode("/",$exp)."/tn_".$temp;
				if(!empty($value))
					{$value="<img src='$thumb'><br />";}		
				}
			} 
		echo "<td valign='top'>$value</td>";
		}
	echo "</tr>
	<tr><td colspan='3'>_________________________________</td></tr>";
	}
echo "</table>";
?>