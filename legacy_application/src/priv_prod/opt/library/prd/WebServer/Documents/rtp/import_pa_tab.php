<?php
if(empty($_SESSION)){session_start();}
$level=$_SESSION['rtp']['level'];
if($level<5){exit;}

	date_default_timezone_set('America/New_York');
	$database="rtp"; 
	$dbName="rtp";

	include("../../include/iConnect.inc");
	$var_table=$_POST['var'];	
	mysqli_select_db($connection,$dbName);
	
//"document_verification_pa",	
$pa_table_array=array("account_info_pa","applicant_info_pa","authorization_pa", "environmental_info_pa","project_budget_pa","project_description_pa", "project_funding_pa","project_info_pa","project_location_pa");

foreach($pa_table_array as $index=>$v)
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
echo "<table class='table' border='1' cellpadding='10'>";
echo "<tr><th colspan='4'>Import <font color='magenta'>Pre-Applicaton</font> data from CSV file into:</th></tr>";
echo "<tr><td>Table</td><td>Number of records</td></tr>";
foreach($pa_table_array as $k=>$v)
	{
	$row_num=$table_rows[$v];
	echo "<form method='POST' action='import_pa.php' enctype='multipart/form-data'>
	<tr>
	<td>$v</td><td>$row_num</td>
	<td>
	<input type='file' name='csv_file'>
	<input type='hidden' name='var' value=\"$v\">
	<input type='submit' name='submit_form' value=\"Import\">
	</td></tr>
	</form>";
	}
echo "</table>";

// echo "<pre>"; print_r($_FILES); echo "</pre>"; // exit;
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

if(!empty($_POST['var']))
	{
	$bk_table=$var_table."_".time();
	$sql="CREATE TABLE `$bk_table` SELECT * FROM `$var_table`";
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	

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
        while (($data = fgetcsv($handle, 10000, '\t')) !== FALSE)
			{
	  
				//Access field data in $data array ex.  
				$exp=explode("\t",$data[0]);
				if($i==0)
					{
	//			echo "<pre>"; print_r($exp); echo "</pre>"; // exit;
				unset($temp_fld);
					foreach($exp as $index=>$fld)
						{
						$temp_fld[]="`".$fld."`";
						}
					$fld_names="(".implode(",",$temp_fld).")";
					}
					else
					{
	//		  echo "<pre>"; print_r($exp); echo "</pre>";  //exit;
					unset($temp_val);
					foreach($exp as $index=>$value)
						{
						$value=str_replace("_x000D_","",$value);
						$temp_val[]="'".mysqli_real_escape_string($connection,$value)."'";
						}
					$fld_values="(".implode(",",$temp_val).")";
				
				//Use data to insert into db  
				$sql = "INSERT INTO $var_table $fld_names VALUES $fld_values"; 
	//		 	echo "$sql"; exit;
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
echo "<table><tr><td colspan='10'>$c - Review then <a href='import_pa.php'>refresh page</a>.</td></tr>";
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