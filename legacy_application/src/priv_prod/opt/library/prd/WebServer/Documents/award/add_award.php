<?php
$database="award";
include("../../include/iConnect.inc");// database connection parameters
include("../../include/auth.inc");// database connection parameters

mysqli_select_db($connection,$database);

//echo "$database<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";
//exit;

//echo "<pre>";print_r($_FILES); echo "</pre>";  //exit;
    
       
if(@$_POST['submit']=="Submit")
       		{
// echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
       		$skip1=array("submit","id");
       	
       			foreach($_POST AS $k=>$v)
       				{
				if(in_array($k,$skip1) OR $v=="")
					{continue;}
				
				$test=explode("-",$k);
				if(in_array($test[0],$skip1)){continue;}
				
				//$v=mysqli_real_escape_string($v);				
				@$clause.=$k."='".$v."',";
				}

       			$clause="set ".rtrim($clause,",");
			$sql = "INSERT INTO award_given $clause";
//echo "$sql"; //exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql"); 
			$clause="";
       				
			$id=mysqli_insert_id($connection);
			
			// ****** uploads
			include("upload_code_given.php");
	//		exit;
			
			header("Location: edit_award_given.php?edit=$id&submit=edit&message=1");
			exit;
       		}
 
$sql = "SELECT * FROM award_given as t1 
	WHERE 1 order by id desc limit 1	";	
	$result = mysqli_query($sql) or die ("Couldn't execute query. $sql c=$connection");

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");      		
while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}
include("edit_award_given.php");
?>