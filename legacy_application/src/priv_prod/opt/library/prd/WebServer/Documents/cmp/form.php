<?php
$database="cmp";
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
       
//echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  exit;
//echo "<pre>";print_r($_FILES); echo "</pre>";  //exit;
    
       
if(@$_POST['submit']=="Submit")
       		{
// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
       		$skip1=array("submit","id");
       			foreach($_POST AS $k=>$v)
       				{
				if(in_array($k,$skip1))
					{continue;}
				$v=addslashes($v);
				@$clause.=$k."='".$v."',";
				}
				
       			$clause="set ".rtrim($clause,",");
			$sql = "REPLACE form $clause";
//echo "$sql"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql"); 
			$clause="";
       				
			$id=mysqli_insert_id($connection);
			
			// ****** uploads
//			include("upload_code.php");
			//exit;
			
			header("Location: form.php?edit=$id&submit=edit&message=1");
			exit;
       		}
 
$sql = "SHOW COLUMNS FROM form
	WHERE 1";	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");      		
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[$row['Field']]="";
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";
include("edit.php");
?>