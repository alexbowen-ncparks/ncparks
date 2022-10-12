<?php

ini_set('display_errors',1);
$title="PARTF";
include("../inc/_base_top_dpr.php");
$database="partf";

$target=$_REQUEST['csv'];

echo "<form method='POST' action='import_csv.php' enctype='multipart/form-data'>
<table><tr>
<td>
Select the CSV file for $target
</td></tr>
<tr><td>
<input type='hidden' name='csv' value='$target'>
<input type='file' name='type' value=''>
<input type='submit' value='Upload File'></td></tr>
</table></form>";

if(empty($_FILES['type']['tmp_name'])){exit;}

if(empty($connection))
	{
	$database="partf";
	include("../../include/iConnect.inc");// database connection parameters
	
	$db = mysqli_select_db($connection,$database)
	   or die ("Couldn't select database");
	}
   
$folder="files";
$csv_file=$target.".csv";	

$file_path=$folder."/".$csv_file;
// echo "<pre>"; print_r($_FILES); echo "</pre>"; // exit;
// echo "t=$target";exit;
move_uploaded_file($_FILES['type']['tmp_name'], $file_path);

//echo "<br />filepath=$target";  exit;	
	

//open the csv file for reading  
ini_set('auto_detect_line_endings',TRUE); // used to allow Mac created \r files to parse properly
$handle = fopen($file_path, 'r');  

//turn off autocommit and delete the product table  
mysqli_query($connection,"SET AUTOCOMMIT=0");  
mysqli_query($connection,"BEGIN");
if($target=="inspections")
	{
	$table="inspections";
	mysqli_query($connection,"TRUNCATE TABLE $table") or die(mysqli_error($connection));
	}

if($target=="grants")
	{
//	echo "Has not been tested.";exit;
//	$table="temp_grant";
	$table="grants";
	mysqli_query($connection,"TRUNCATE TABLE $table") or die(mysqli_error($connection));
	}
	
$i=0;
while (($data = fgetcsv($handle, 1000, ',')) !== FALSE)
	{
	if($i==0)
		{
		foreach($data as $k=>$v)
			{
			$v=rtrim($v," ");
			$v=str_replace(" ","_",$v);
			$fields[]=strtolower($v);
			}
		}
// echo "<pre>"; print_r($fields); echo "</pre>"; exit;
	//Access field data in $data array ex. 
	$clause="";
	foreach($data as $k1=>$v2)
		{
		$v2=str_replace("\"","",$v2);
		$v2=str_replace(",","",$v2);
		$v2=addslashes($v2);
		if($k1==0)
			{
			$clause.="id='".$v2."',";
			}
			else
			{
			$clause.=$fields[$k1]."='".$v2."',";
			}
		
		}
$clause=rtrim($clause,",");

//if($i>0){echo "c=$clause";exit;}	
	
	$clause=rtrim($clause,",");
	//Use data to insert into db 
	// check to make sure the csv is saved in Windows \r\n format or UNIX \n
	if($i!=0)
		{
		$sql ="INSERT INTO $table set $clause";
// 	echo "i=$i $sql";exit;
		mysqli_query($connection,$sql) or (mysqli_query($connection,"ROLLBACK") and die(mysqli_error($connection) . "97 - $sql". mysqli_error($connection)));
		$i++;
		}
		else
		{
		$i++;
		}
		
	
	}  

//commit the data to the database  
mysqli_query($connection,"COMMIT");  
mysqli_query($connection,"SET AUTOCOMMIT=1");  

$go=$target.".php";
header("Location: $go");
?>	