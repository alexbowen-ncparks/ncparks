<?php
//echo "<pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>"; // exit;
ini_set('display_errors',1);
$title="DPR IT Inventory";
include("../inc/_base_top_dpr.php");
$database="fixed_assets";

$target=$_REQUEST['action'];

echo "<form method='POST' action='import_text.php' enctype='multipart/form-data'>
<table><tr>
<td>
<h2>Select the TXT file for $target</h2>
</td></tr>
<tr><td>
<input type='hidden' name='action' value='$target'>
<input type='file' name='type' value=''>
<input type='submit' value='Upload File'></td></tr>
</table></form>";

if(empty($_FILES['type']['tmp_name'])){exit;}

if(empty($connection))
	{
	$database="fixed_assets";
	include("../../include/iConnect.inc");// database connection parameters
	
	$db = mysqli_select_db($connection,$database)
	   or die ("Couldn't select database");
	}
   
$folder="warehouse";
$csv_file=$target.".txt";	

$file_path=$folder."/".$csv_file;
//echo "t=$target";exit;
move_uploaded_file($_FILES['type']['tmp_name'], $file_path);

//echo "<br />filepath=$file_path";  exit;	
	

//open the csv file for reading  
$handle = fopen($file_path, 'r');  

//turn off autocommit and delete the product table  
mysqli_query($connection,"SET AUTOCOMMIT=0");  
mysqli_query($connection,"BEGIN");
if($target=="warehouse")
	{
//	ECHO "hello";
	$table="warehouse";
	mysqli_query($connection,"TRUNCATE TABLE $table") or die(mysqli_error($connection));
	}


$skip=array("equipment_tracking_and_delivery_sheet_'10_desktops/laptops","park","picked_up_from");
$rename=array("rec'd_by"=>"receive","&_date"=>"receive_date","equipment"=>"equipment","brand"=>"brand","model_#"=>"model","serial_#"=>"serial_num","fas_#"=>"fas_num","po_#"=>"po_num","unit"=>"park_code","from_w/h_by:"=>"pick_up_by","date"=>"pick_up_date");

$del="";

if (($handle = fopen($file_path, "r")) !== FALSE)
{
    while (($data = fgetcsv($handle, 10000, "\t")) !== FALSE)
		{
		
//	echo "<pre>"; print_r($data); echo "</pre>";  exit;
		foreach($data as $k=>$v)
			{
			if(empty($v) and empty($del))
				{
				unset($data[$k]);
				continue;
				}
			
			$v=trim($v);
			$v=strtolower($v);
			$v=str_replace(" ","_",$v);
			$v=str_replace("-","_",$v);
			$v=str_replace(".","_",$v);
			if($v=="date"){$del=1;}
			if(in_array($v,$skip))
				{
				unset($data[$k]);
				continue;
				}
			if(array_key_exists($v,$rename))
				{
				$fields[]=$rename[$v];
				unset($data[$k]);
				}
			}
			
	//	echo "<pre>"; print_r($fields); echo "</pre>"; //exit;
	//	echo "<pre>"; print_r($data); echo "</pre>"; exit;

		$i=1;
		$j=1;
		foreach($data as $k1=>$v2)
			{
			$new_data[$i][$j]=$v2;
			$j++;
			if($j==12)
				{
				$i++;
				$j=1;
				}
			}
//		echo "<pre>"; print_r($new_data); echo "</pre>"; // exit;
		
		foreach($new_data as $index=>$array)
			{
				if(empty($array[6])){continue;}
				$clause="";
			foreach($array as $k=>$v3)
				{
				$v3=str_replace("\"","",$v3);
				$v3=addslashes($v3);
// 				$v3=html_entity_decode(htmlspecialchars_decode($v3));
				$clause.=$fields[$k-1]."='".$v3."',";
				}
				$clause=rtrim($clause,",");
			//	echo "c=$clause<br />";  //exit;
				$sql ="INSERT INTO warehouse set $clause";

			//	echo "<br /><br />i=$i $sql";exit;
				mysqli_query($connection,$sql) or (mysqli_query($connection,"ROLLBACK") and die(mysqli_error($connection) . " - $sql"));
				}
			}
    fclose($handle);
}
//commit the data to the database  
mysqli_query($connection,"COMMIT");  
mysqli_query($connection,"SET AUTOCOMMIT=1");  

//exit;
		
	$sql ="SELECT * FROM warehouse where 1";
	$result=mysqli_query($connection,$sql) or (mysqli_query($connection,$sql) and die(mysqli_error($connection) . " - $sql"));
	$num=mysqli_num_rows($result);
	echo "Success! There were $num records uploaded to the warehouse table.";
	
	echo " Check the records to make sure the upload is correct.";
	echo "<h2><font color='red'>If it is NOT correct, contact Tom Howard.</font></h2>";
	
	echo "<h2><font color='green'>If it is correct, move the items to the New IT Inventory table for assignment to the parks by Carl and Bin.</font></h2>";
	echo "<a href='move_it_items.php'>Move to New IT Inventory</a><br /><br />";
	
while($row=mysqli_fetch_assoc($result))
	{$ARRAY[]=$row;}
	$c=count($ARRAY);
echo "<table border='1'>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
?>