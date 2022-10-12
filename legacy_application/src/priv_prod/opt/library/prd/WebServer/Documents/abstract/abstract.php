<?php
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;

$database="abstract_import";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database 

extract($_REQUEST);
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

// Get list of databases on server
$skip=array("information_schema","lost+found");
$sql="SELECT schema_name FROM information_schema.schemata";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result))
	{
	if(in_array($row['schema_name'],$skip)){continue;}
		$database_array[]=$row['schema_name'];
	}
	

if(isset($new_table) and empty($new_table)){echo "You must name a table."; exit;}
if(!isset($list)){$list="";}
echo "<form method='POST'>
Database Name: <select name='database'><option></option>";
	foreach($database_array as $k=>$v)
			{
			if($database==$v){$s="selected";}else{$s="value";}
			echo "<option $s='$v'>$v</option>";
			}
echo "</select> <font color='red'>Use abstract_import</font>

Table Name: <input type='text' name='new_table' value='$new_table' size='35'>
<font color='red'>intermediate</font>
<br />
<textarea name='list' cols='140' rows='30'>$list</textarea>
<input type='submit' name='submit' value='submit'></form>";

	
if(@$submit==""){exit;}
//echo "$list<br />";

$var=explode("\\r\\n",$list);
if(count($var)<2)
	{
	$var=explode("\\n",$list);
	}
//echo "<pre>"; print_r($var); echo "</pre>";  exit;

$count=count(explode("\t",$var[0])); // number of fields
echo "<a href='/abstract/rename_cols.php?database=$database&new_table=$new_table'>Rename</a> columns. Make sure the first row contains column names.<br /><br />
If importing into NRID do NOT rename fields.";
	

mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
// ******* Create new blank table

//echo "<pre>c=$count"; print_r($_POST); echo "</pre>";  exit;

include("create_new_table.php");  //echo "$sql";exit;
$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));


$sql="SHOW columns from $new_table";
$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_array($result))
	{$fld_array[]=$row['Field'];}

//echo "<pre>"; print_r($list); echo "</pre>";  //exit;


foreach($var as $k=>$v){
		$values[]=explode("\t",$v);
		}

//echo "<pre>"; print_r($values); echo "</pre>";  //exit;

$sql="truncate $new_table";
$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));

mysqli_query("set names utf8;");  // deals with multibyte characters such as ü
foreach($values as $row=>$array){
			$clause="";
		foreach($array as $num=>$val)
			{
		//	$val=trim(addslashes($val));
			$val=trim($val);
		//	$val=rtrim($val);
				$fld=$fld_array[$num];
			if($val){$clause.="`".$fld."`='".$val."',";}
			}
		$clause=rtrim($clause,",");
		if($clause==""){continue;}
		$sql="INSERT INTO $new_table set $clause"; 
// 		echo "<br>$sql"; //exit;
		$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
// 		exit;
		}
$sql="SELECT `a` from $new_table LIMIT 1";
$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_array($result))
	{
	if($row['a']=="Park Code")
		{
		$sql="DELETE from $new_table WHERE `a` = 'Park Code'";
// 		$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
		}
	}
$sql="SELECT * from $new_table";
$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
$num_record=mysqli_num_rows($result);
echo "<br /><br />$num_record records added.";
?>
