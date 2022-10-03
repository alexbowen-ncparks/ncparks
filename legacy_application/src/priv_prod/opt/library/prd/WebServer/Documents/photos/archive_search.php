<?php
$database="photos";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
   or die ("Couldn't select database $database");
	
ini_set('display_errors',1);

mysqli_select_db($connection, $database);
$sql="SELECT distinct place
FROM dcr_archive
where 1
order by place"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
// 	if($row['place']=="North Carolina, United States"){continue;}
	if($row['place']==""){continue;}
	$ARRAY_place[]=$row['place'];
	}
// echo "<pre>"; print_r($ARRAY_place); echo "</pre>"; // exit;
if(empty($rep))
	{
	$title="DCR Archive";
	include("_base_top.php");
	}

unset($_SESSION['photos']['clause']);

$sql="SELECT * FROM dcr_archive limit 1"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}

if(empty($rep))
	{
	if(empty($rep))
		{
		include("archive_menu.php");
		}
	}

$allow_array=array("object_file_name","title_","subjects","place");
$help_array=array("object_file_name"=>"<br />Park acronym(CABE) OR UNKN (unknown location) -- numbers after the acronym are metadata filing index numbers for archival section staff file use only","title_"=>"<br />Searches will be simple such as visitor(s), mountain, bird","subjects"=>"<br />searches will be simple Library of Congress approved subjects like (animals, plants,water, rivers, etc.)","place"=>"<br />Will be the full Park Name and Address");

echo "<form action='archive.php' method='POST'>";
echo "<table>";
if(!empty($ARRAY))
	{
	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			foreach($ARRAY[0] AS $fld=>$value)
				{
				if($level<3)
					{
					if(!in_array($fld,$allow_array)){continue;}
					}
				$rep_fld=$fld;
				if($fld=="title_"){$rep_fld="title";}
				if($fld=="place")
					{
					echo "<tr><th>$fld</th><td><select name='$fld'><option value=\"\"></option>\n";
					foreach($ARRAY_place as $k=>$v)
						{
						echo "<option value='$v'>$v</option>\n";
						}
					echo "</select></td></tr>";
					continue;
					}
				if(array_key_exists($fld,$help_array))
					{
					$var_help=$help_array[$fld];
					}
					else
					{$var_help="";}
				echo "<tr><th>$rep_fld</th><td><input type='text' name='$fld' value=\"\"> $var_help</td></tr>";			
				}
			}	
		}
	}
echo "<tr>
<td colspan='2' align='center'><input type='submit' name='submit' value=\"Find\"></td>
</tr>";
echo "<tr><td>Tips</td></tr>
<tr><td colspan='2'>1. Click on the image and you may format it to print any image in the database.  This image is not for public or website use.  A park may choose to use the image for retail sales items and if you need a larger format contact denise.williams@ncparks.gov with the object file name. 
</td></tr>
<tr><td colspan='2'>2.  Expand the title and description columns to read more metadata about the image and also scroll across the screen for more image metadata.
</td></tr>
<tr><td colspan='2'>3.  If you see an image that does not belong with your park or if you see an UNKN (unKnown location) image you recognize contact database.support@ncparks.gov with the complete object file name.
</td></tr>
";
echo "</table>";

?>