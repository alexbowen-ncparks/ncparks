<?php
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;

extract($_REQUEST);
$getPHP=explode("PHP/",$_SERVER['SERVER_SOFTWARE']);
$php=$getPHP[1];

include("../../include/connect.php");
//echo $username; 


// Get list of databases on server
$result = mysql_list_dbs( $connection );
while($row=mysqli_fetch_assoc($result))
	{
		$database_array[]=$row['Database'];
	}


echo "<form method='POST'>
Database Name: <select name='database'><option></option>";
	foreach($database_array as $k=>$v)
			{
				echo "<option value='$v'>$v</option>";
			}
						
echo "</select>

Table Name: <input type='text' name='new_table' value='$new_table' size='35'>
<br />
<textarea name='list' cols='140' rows='30'>$list</textarea>
<input type='submit' name='submit' value='submit'></form>";

	
if($submit==""){exit;}

$var=explode("\n",$list);

$count=count(explode("\t",$var[0])); // number of fields
echo "<a href='rename_cols.php?database=$database&new_table=$new_table'>Rename</a> columns. Make sure the first row contains column names.<br /><br />";
	

  $db = mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");
// ******* Create new blank table

//echo "<pre>c=$count"; print_r($_POST); echo "</pre>";  exit;

include("create_new_table.php");  //echo "$sql";exit;
$result = @mysqli_query($connection, $sql) or die(mysqli_error());


$sql="SHOW columns from $new_table";
$result = @mysqli_query($connection, $sql) or die(mysqli_error());
while($row=mysqli_fetch_array($result)){$fld_array[]=$row['Field'];}

//echo "<pre>"; print_r($list); echo "</pre>";  exit;


foreach($var as $k=>$v){
		$values[]=explode("\t",$v);
		}


$sql="truncate $new_table";
$result = @mysqli_query($connection, $sql) or die(mysqli_error());

foreach($values as $row=>$array){
			$clause="";
		foreach($array as $num=>$val){
			$val=trim(addslashes($val));
			
			$val=trim($val);
				$fld=$fld_array[$num];
			if($val){$clause.="`".$fld."`='".$val."',";}
			}
			$clause=rtrim($clause,",");
			if($clause==""){continue;}
			$sql="INSERT INTO $new_table set $clause"; 
		//	echo "<br>$sql"; exit;
			$result = @mysqli_query($connection, $sql) or die(mysqli_error());
		}

?>