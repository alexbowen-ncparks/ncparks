<?php
$database="annual_report";
include("../../include/iConnect.inc");// database connection parameters


mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
       
//echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  exit;
//echo "<pre>";print_r($_FILES); echo "</pre>";  //exit;
    
       
if(@$_POST['submit']=="Submit")
       		{
 //echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
       		$skip1=array("year","month","day","submit","id");
       			foreach($_POST AS $k=>$v)
       				{
				if(in_array($k,$skip1))
					{continue;}
			
				$clause.=$k."='".$v."',";
				}
				
       			$clause="set ".rtrim($clause,",");
			$sql = "REPLACE task $clause";
//echo "$sql"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql "); 
			$clause="";
       				
			$id=mysqli_insert_id();
			
			// ****** uploads
//			include("upload_code.php");
			//exit;
			
			header("Location: edit.php?edit=$id&submit=edit&message=1");
			exit;
       		}
 
$sql = "SHOW COLUMNS FROM task
	WHERE 1";	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");      		
while($row=mysqli_fetch_assoc($result)){$ARRAY[$row['Field']]="";}
include("edit.php");
?>