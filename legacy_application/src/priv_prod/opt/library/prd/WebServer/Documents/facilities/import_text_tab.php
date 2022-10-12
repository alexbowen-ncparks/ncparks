<?php
//echo "<pre>"; print_r($_REQUEST); print_r($_FILES); echo "</pre>"; // exit;
ini_set('display_errors',1);
$title="DPR Import Text";
include("../inc/_base_top_dpr.php");

$target="rent";

echo "<form method='POST' action='import_text.php' enctype='multipart/form-data'>
<table><tr>
<td>
<h2>Select the TXT file for $target</h2>
</td></tr>
<tr><td>
<input type='hidden' name='csv' value='$target'>
<input type='file' name='type' value=''>
<input type='submit' value='Upload File'></td></tr>
</table></form>";

if(empty($_FILES['type']['tmp_name'])){exit;}

// echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;

$exp=explode(".",$_FILES['type']['name']);
$ext=array_pop($exp);
if(strtolower($ext)!="txt")
	{echo "The rent file must be a text file. It cannot be an Excel spreadsheet."; exit;}

if(empty($_FILES['type']['tmp_name'])){exit;}

if(empty($connection))
	{
	$database="facilities";
	include("../../include/iConnect.inc");// database connection parameters
	
	mysqli_select_db($connection,$database)
	   or die ("Couldn't select database");
	}
   
$folder="housing";
$csv_file=$target.".txt";	

$file_path=$folder."/".$csv_file;
// echo "t=$file_path";exit;
move_uploaded_file($_FILES['type']['tmp_name'], $file_path);

//echo "<br />filepath=$file_path";  exit;	
	

//open the csv file for reading  
$handle = fopen($file_path, 'r');  

//turn off autocommit
mysqli_query($connection,"SET AUTOCOMMIT=0");  
mysqli_query($connection,"BEGIN");
if($target=="rent")
	{
//	ECHO "hello";
	$table="rent";
	mysqli_query($connection,"TRUNCATE TABLE $table") or die(mysqli_error($connection));
	}

$i = 1;
if (($handle = fopen($file_path, "r")) !== FALSE)
{
    while (($data = fgetcsv($handle, 1000, "\t")) !== FALSE)
		{
// 		echo "<pre>"; print_r($data); echo "</pre>";  //exit;
// 		array_shift($data);
	//	echo "<pre>"; print_r($data); echo "</pre>";  //exit;
// 		array_pop($data);
	//	echo "<pre>"; print_r($data); echo "</pre>";  exit;
		$num = count($data);
// 		if($num<12){continue;}
		if($i==1)
			{
//  	echo "<pre>"; print_r($data); echo "</pre>";  exit;
	// $exp=explode(",",$data[0]);
// 	echo "<pre>"; print_r($data); echo "</pre>";  exit;
			foreach($data as $k=>$v)
				{
				if(empty($v)){continue;}
				$v=trim($v);
				$v=str_replace(" ","_",$v);
				$v=str_replace("-","_",$v);
				$v=str_replace(".","_",$v);
				if($v=="Number")
					{
					 // header was changed from "Number of" to "Number" in April 2015 export
					 // changes in headers might occur again
					$v="number_of";
					}
				$fields[]=strtolower($v);
				}
			}
//		echo "<pre>"; print_r($fields); echo "</pre>"; exit;

		$i++;
		$clause="";
		foreach($data as $k1=>$v2)
			{
			$v2=str_replace("\"","",$v2);
			$v2=addslashes($v2);
			$clause.="`".$fields[$k1]."`='".$v2."',";
			}
	$clause=rtrim($clause,",");
//	echo "c=$clause<br />";  //exit;
	$sql ="INSERT IGNORE INTO rent set $clause";
// 		echo "<br /><br />i=$i $sql";exit;
		mysqli_query($connection,$sql) or (mysqli_query($connection,"ROLLBACK") and die(mysqli_error($connection) . " - $sql"));
		}
    fclose($handle);
}

	$sql ="DELETE FROM rent where account_number_with_text='Account Number with Text'";
	mysqli_query($connection,$sql) or (mysqli_query($connection,$sql) and die(mysqli_error($connection) . " - $sql"));
	// $sql ="DELETE FROM rent where pa=''";
// 	mysqli_query($connection,$sql) or (mysqli_query($connection,$sql) and die(mysqli_error($connection) . " - $sql"));
		
	$sql ="SELECT * FROM rent where 1";
	$result=mysqli_query($connection,$sql) or (mysqli_query($connection,$sql) and die(mysqli_error($connection) . " - $sql"));
	$num=mysqli_num_rows($result);
	echo "Success! There were $num records uploaded to the rent table.";

echo "<br /><br />Return to <a href='find.php?fac_type=Park%20Residence&submit_label=Go%20to%20Find'>Housing Website</a>";

//commit the data to the database  
mysqli_query($connection,"COMMIT");  
mysqli_query($connection,"SET AUTOCOMMIT=1");  
// 
// INSERT IGNORE INTO rent set `account_number_with_text`='Account Number with Text',`personnel_number`='Personnel Number',`name_of_employee_or_applicant`='Name of employee or applicant',`wage_type_long_text`='Wage Type Long Text',`debit_amount`='Debit Amount',`credit_amount`='Credit Amount',`amount`='Amount',`fund`='Fund',`cost_center`='Cost Center',`order`='Order',`internal_order_text`='Internal Order Text',`description`='Description',`for_period_start_date`='FOR period start date',`for_period_end_date`='For-period end date',`number_of_posting_run`='Number of Posting Run'

?>	