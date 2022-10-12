<?php
if(empty($_SESSION)){session_start();}
$level=$_SESSION['rtp']['level'];
if($level<4){exit;}
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

	date_default_timezone_set('America/New_York');
	$database="rtp"; 
	$dbName="rtp";

	include("../../include/iConnect.inc");
	$var_table=$_POST['var'];	
	mysqli_select_db($connection,$dbName);

	$sql="SELECT distinct left(`project_file_name`,4) as year
	from applicant_info
	WHERE 1"; //ECHO "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_year[]=$row['year'];
		}	

$fa_table_array=array("account_info","applicant_info","authorization", "environmental_info", "document_verification", "project_budget","project_description", "project_funding","project_info","project_location");

foreach($fa_table_array as $index=>$v)
	{
	$sql="Select  count(*) as num FROM `$v`";
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$table_rows[$v]=$row['num'];
		}
	}
include("_base_top.php");

?>
<style>
td
	{
	vertical-align: text-top;
	}
</style>

<?php

echo "<FORM method='POST'><table><tr><td width='40%'><h3>Project Summaries for $set_year</h3></td></tr>
<tr><td>
Year: <select name='set_year' onchange=\"this.form.submit();\"><option value=\"\" selected></option>\n";


foreach($ARRAY_year as $k=>$v)
	{
	if($set_year==$v){$s="selected";}else{$s="";}
	echo "<option value='$v' $s>$v</option>\n";
	}
echo "</select>";

echo "</td></tr></table></FORM>";

if(empty($_POST['set_year']))
	{exit;}
$set_year=$_POST['set_year'];

echo "<table class='table' border='1' cellpadding='10'>";
echo "<tr><th colspan='4'>Import <font color='magenta'>Final Applicaton</font> data from CSV file into:</th></tr>";
echo "<tr><td>Table</td><td>Number of records</td></tr>";
foreach($fa_table_array as $k=>$v)
	{
	$row_num=$table_rows[$v];
	echo "<form method='POST' action='import_fa.php' enctype='multipart/form-data'>
	<tr>
	<td>$v</td><td>$row_num</td>
	<td>
	<input type='file' name='csv_file'>
	<input type='hidden' name='set_year' value=\"$set_year\">
	<input type='hidden' name='var' value=\"$v\">
	<input type='submit' name='submit_form' value=\"Import\">
	</td></tr>
	</form>";
	}
echo "</table>";

 //echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;
// echo "$set_year <pre>"; print_r($_POST); echo "</pre>";  //exit;

if(!empty($_POST['var']))
	{
	$bk_table=$var_table."_".time();
	$sql="CREATE TABLE `$bk_table` SELECT * FROM `$var_table`";
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
	$pfn=$set_year."_";
	$sql="DELETE FROM `$var_table` where  `project_file_name` like '$pfn%'";
//	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	
// 	$sql="TRUNCATE TABLE `$var_table`";
// 	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	

	$csv_file=$_FILES['csv_file']['name'];	
//echo "<br />csv_file=$csv_file"; exit;

$target="temp_csv/".$csv_file;
move_uploaded_file($_FILES['csv_file']['tmp_name'], $target);
//echo "<br />upload_successful";//exit;
$file_path=$target;
//echo "<br />filepath=$file_path";//exit;	
	

        //open the csv file for reading  
        $handle = fopen($file_path, 'r');  
      
        //turn off autocommit and delete the product table  
        mysqli_query($connection,"SET AUTOCOMMIT=0");  
        mysqli_query($connection,"BEGIN");  
      
      $i=0;
    //    while (($data = fgetcsv($handle, 10000, '\t')) !== FALSE)
        while (($data = fgetcsv($handle, 10000, ',')) !== FALSE)
			{
	  
			//	echo "<pre>"; print_r($data); echo "</pre>";  exit;
				//Access field data in $data array ex.  
			//	$exp=explode(",",$data[0]);
				if($i==0)
					{
			//	echo "<pre>"; print_r($exp); echo "</pre>";  exit;
				unset($temp_fld);
					foreach($data as $index=>$fld)
						{
						$temp_fld[]="`".$fld."`";
						}
					$fld_names="(".implode(",",$temp_fld).")";
					}
					else
					{
	//		  echo "<pre>"; print_r($exp); echo "</pre>";  //exit;
					unset($temp_val);
					foreach($data as $index=>$value)
						{
						$value=str_replace("_x000D_","",$value);
						$temp_val[]="'".mysqli_real_escape_string($connection,$value)."'";
						}
					$fld_values="(".implode(",",$temp_val).")";
				
				//Use data to insert into db  
				$sql = "INSERT INTO $var_table $fld_names VALUES $fld_values"; 
			// 	echo "$sql"; exit;
			   mysqli_query($connection,$sql) or (mysqli_query($connection,"ROLLBACK") and die(mysqli_error($connection) . " - $sql"));  
					}
			 $i++;
			}  
      
        //commit the data to the database  
        mysqli_query($connection,"COMMIT");  
        mysqli_query($connection,"SET AUTOCOMMIT=1");  
    
    $sql="SELECT * FROM `$var_table`";
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	$skip=array();
$c=count($ARRAY);
echo "<table><tr><td colspan='10'>$c - Review then <a href='import_fa.php'>refresh page</a>.</td></tr>";
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
		echo "</tr>";
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
	}
?>