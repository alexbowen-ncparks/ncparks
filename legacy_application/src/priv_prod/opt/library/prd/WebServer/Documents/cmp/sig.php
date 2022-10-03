<?php
ini_set('display_errors',1);
$database="cmp";
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

//echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  exit;
//echo "<pre>";print_r($_FILES); echo "</pre>";  //exit;
    
       
if(@$_POST['submit']=="Submit")
       		{
		if(empty($_POST['prime_beacon_num']) AND empty($_POST['sec_beacon_num']))
		{
		echo "You must list either a primary OR secondary approver before proceeding. Click your browser's back button.";
		exit;
		}

 //echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
       		$skip1=array("submit","id");
       			foreach($_POST AS $k=>$v)
       				{
				if(in_array($k,$skip1))
					{continue;}
				$v=addslashes($v);
				@$clause.=$k."='".$v."',";
				}
				
       			$clause="set ".rtrim($clause,",");
			$sql = "REPLACE sig $clause";
//echo "$sql"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql "); 
			$clause="";
       				
			$id=mysqli_insert_id($connection);
			
			// ****** uploads
//			include("upload_code.php");
			//exit;
			
			header("Location: sig.php?edit=$id&submit=edit&message=1");
			exit;
       		}
 
$sql = "SHOW COLUMNS FROM sig
	WHERE 1";	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");      		
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[$row['Field']]="";
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; exit;

include("edit_sig.php");
?>