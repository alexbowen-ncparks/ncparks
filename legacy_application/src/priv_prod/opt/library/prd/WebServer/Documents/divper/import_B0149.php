<?php
// echo "<pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>";  //exit;
ini_set('display_errors',1);
$title="DPR Import Personnel Text";
include("../inc/_base_top_dpr.php");
include("menu.php");
$target="B0149";
date_default_timezone_set('America/New_York');
$year=date("Y");
$month=date("M");

echo "<form method='POST' action='import_B0149.php' enctype='multipart/form-data'>
<table><tr>
<td colspan='2'>
<h2>Select the TXT file for $target</h2>
</td></tr>
<tr><td><input type='text' name='year' value=\"$year\" size='4'><br />
<input type='text' name='month' value=\"$month\" size='4'></td><td>
<input type='hidden' name='csv' value='$target'>
<input type='file' name='type' value=''>
<input type='submit' value='Upload File'></td></tr>
</table></form>";

// if(empty($_FILES['type']['tmp_name'])){exit;}

// echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;


// if(empty($_FILES['type']['tmp_name'])){exit;}

if(empty($connection))
	{
	$database="divper";
	include("../../include/iConnect.inc");// database connection parameters
	mysqli_select_db($connection,$database)
	   or die ("Couldn't select database");
	}
   
$folder="B0149";
$table="B0149";


if(!empty($_FILES['type']['tmp_name']))
	{
	
$exp=explode(".",$_FILES['type']['name']);
$ext=array_pop($exp);
if(strtolower($ext)!="txt")
	{echo "The $target file must be a text file. It cannot be an Excel spreadsheet."; exit;}
	
$csv_file=$target.".txt";	

$file_path=$folder."/".$csv_file;
// echo "t=$file_path";exit;
move_uploaded_file($_FILES['type']['tmp_name'], $file_path);

//open the csv file for reading  
$handle = fopen($file_path, 'r');  

//turn off autocommit
mysqli_query($connection,"SET AUTOCOMMIT=0");  
mysqli_query($connection,"BEGIN");
if($target=="B0149")
	{
	mysqli_query($connection,"TRUNCATE TABLE $table") or die(mysqli_error($connection));
	}
$skip=array("year","month");
$sql ="SHOW columns from $table ";
$result=mysqli_query($connection,$sql) or die(mysqli_error($connection) . " - $sql");
while($row=mysqli_fetch_assoc($result))
	{
	if(in_array($row['Field'],$skip)){continue;}
	if($row['Field']=="Fund %"){$row['Field']=="Fund Percent";}
	if($row['Field']=="Difference Budget Amt & Salary Amt")
		{$row['Field']=="Difference Budget Amt and Salary Amt";}
	$fields[]=$row['Field'];
	}

$temp=$month." 1 ".$year;
$new_month=date('m', strtotime($temp));

$i = 0;
if (($handle = fopen($file_path, "r")) !== FALSE)
	{
	while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
		{
// 		if($i==0)
// 			{
// 			$exp=explode(":",$data[$i]);
// 			if($exp[0]!="B0149"){echo "This doesn't appear to be the B0149 text file."; exit;}
// 			}
// 		if($i==2)
// 			{
// 			$exp=explode(":",$data[$i]);
// 			echo "<pre>"; print_r($exp); print_r($data); echo "</pre>"; // exit;
// 			$exp1=explode("/",$exp[0]);
// // 			if($exp[0]!="B0149"){echo "This doesn't appear to be the B0149 text file."; exit;}
// 			echo "<pre>"; print_r($exp1); echo "</pre>";  exit;
// 			}
		$i++;
		if($i<6){continue;}

		$clause="`year`='$year', `month`='$new_month',";
		foreach($data as $k1=>$v2)
			{
			$v2=str_replace("\"","",$v2);
			$v2=addslashes($v2);
			$clause.="`".$fields[$k1]."`='".$v2."',";
			}
// 	$clause=rtrim($clause,",")." WHERE `year`='$year' and `month`='$new_month'";
	$clause=rtrim($clause,",");
//	echo "c=$clause<br />";  //exit;
	$sql ="INSERT IGNORE INTO $table set $clause";
// 	$sql ="REPLACE INTO $table set $clause";
// 		echo "<br /><br />i=$i $sql";exit;
	mysqli_query($connection,$sql) or (mysqli_query($connection,"ROLLBACK") and die(mysqli_error($connection) . " - $sql"));
		}
	fclose($handle);
	}

$sql ="DELETE FROM $table where org_unit_desc=''";
mysqli_query($connection,$sql) or (mysqli_query($connection,$sql) and die(mysqli_error($connection) . " - $sql"));
$sql ="DELETE FROM $table where position=''";
mysqli_query($connection,$sql) or (mysqli_query($connection,$sql) and die(mysqli_error($connection) . " - $sql"));

$sql ="SELECT * FROM $table where 1";
$result=mysqli_query($connection,$sql) or (mysqli_query($connection,$sql) and die(mysqli_error($connection) . " - $sql"));
$num=mysqli_num_rows($result);
echo "Success! There were $num records uploaded to the divper.$table table.";

	}
	
$sql ="SELECT year, month, count(funding_source) as num_positions, funding_source FROM $table where 1 group by funding_source";
$result=mysqli_query($connection,$sql) or (mysqli_query($connection,$sql) and die(mysqli_error($connection) . " - $sql"));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
	
$sql ="SELECT count(position_desc) as num_position_desc, position_desc FROM $table where 1 
and `year`='' and `month`=''
group by position_desc
order by num_position_desc desc";
$result=mysqli_query($connection,$sql) or (mysqli_query($connection,$sql) and die(mysqli_error($connection) . " - $sql"));
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_1[]=$row;
		}
	}
	else
	{$ARRAY_1[]=array();}
	
$skip=array();
$c=count($ARRAY);
echo "<table><tr><td></td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<th>$fld</th>";
			}
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="funding_source")
			{
			$temp="<a href='B0149_funding_source.php?fs=$value' target='_blank'>$value</a>";
			$temp.="</td><td><a href='B0149_funding_source.php?fs=$value&ft=perm' target='_blank'>Permanent</a>";
			$temp.="</td><td><a href='B0149_funding_source.php?fs=$value&ft=sea' target='_blank'>Seasonal</a>";
			$value=$temp;
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";

$skip=array();
$c=count($ARRAY_1);
echo "<table><tr><td></td></tr>";
foreach($ARRAY_1 AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY_1[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<th>$fld</th>";
			}
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
echo "<br /><br />Permanent v. Seasonal is based on whether the Position Desc field contains or doesn't contain an *. If this isn't correct, let me know the best method to separate.<br /><br />Do all Seasonal positions beging with 6009 ?";

//commit the data to the database  
mysqli_query($connection,"COMMIT");  
mysqli_query($connection,"SET AUTOCOMMIT=1");  

mysqli_close($connection);
?>	