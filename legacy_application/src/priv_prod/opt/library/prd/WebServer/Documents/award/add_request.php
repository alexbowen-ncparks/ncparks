<?php
$database="award";
include("../../include/iConnect.inc");// database connection parameters
include("../../include/auth.inc");// database connection parameters

mysqli_select_db($connection,$database);

//echo "$database<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  exit;

//echo "<pre>";print_r($_FILES); echo "</pre>";  //exit;
    
       
if(@$_POST['submit']=="Submit")
       		{
// echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;

       		$skip1=array("submit","id","category_standard");
       		$skip2=array("submit","id");
       		if($_POST['category_standard']!="")
       			{
       			$_POST['category']=$_POST['category_standard'];
       			}
       			foreach($_POST AS $k=>$v)
       				{
				if(in_array($k,$skip1) OR $v=="")
					{continue;}
				
				$test=explode("-",$k);
				if(in_array($test[0],$skip1)){continue;}
				
				if($k=="dpr"){$pass_dpr=$v;}
				if($k=="location"){$v=strtoupper($v);}
				if($k=="PASU_approv")
					{
					foreach($v as $ind1=>$val1)
						{
						$value1.=$val1.",";
						}
					$v=rtrim($value1,",");
					$value1="";
				
					}
			//	$v=mysqli_real_escape_string($v);				
				$clause.=$k."='".$v."',";
				}


       			$clause="set ".rtrim($clause,",");
			$sql = "INSERT INTO award_list $clause";
//echo "$sql"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection)); 
			$clause="";
       				
			$id=mysqli_insert_id($connection);
			
			// ****** uploads
			include("upload_code.php");
			//exit;
			
			header("Location: edit.php?edit=$id&submit=edit&message=1");
			exit;
       		}
 
$sql = "SELECT * FROM award_list as t1 
	WHERE 1 order by dpr desc limit 1	";	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");      		
while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}
$pass_source="add";
include("edit.php");
?>