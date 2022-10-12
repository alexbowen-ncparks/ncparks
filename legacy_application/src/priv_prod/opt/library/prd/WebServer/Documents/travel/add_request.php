<?php
$database="travel";
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
date_default_timezone_set('America/New_York');

//echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  //exit;
//echo "<pre>";print_r($_FILES); echo "</pre>";  //exit;
    
       
if(@$_POST['submit']=="Submit")
       		{
// echo "14<pre>"; print_r($_POST); echo "</pre>";  //exit;
       		$skip1=array("year","month","day","submit","id");
       		$skip2=array("submit","id");
       			foreach($_POST AS $k=>$v)
       				{
				if(in_array($k,$skip1) OR $v=="")
					{continue;}
				
				$test=explode("-",$k);
				if(in_array($test[0],$skip1)){continue;}
				
				if($k=="tadpr"){$pass_tadpr=$v;}
				if($k=="category")
					{
					foreach($v as $ind1=>$val1)
						{
						@$value1.=$val1.",";
						}
					$v=rtrim($value1,",");
					$value1="";
					}
				//$v=addslashes($v);
				@$clause.=$k."='".$v."',";
				}

// menu.php has the javascript that controls calendars - calendar(x)
$date_array=array("date_from"=>'1',"date_to"=>'2',"approv_OPS"=>'3',"approv_DPR_BO"=>'4',"approv_DIR"=>'5',"to_BPA"=>'6',"approv_BPA"=>'7',"staff_notify"=>'8');
				
			foreach($_POST AS $k=>$v)
       				{
				if(in_array($k,$skip2) OR $v=="")
					{continue;}
				foreach($date_array as $k1=>$v1)
					{
					if($k=="year-field".$v1)
						{$temp=$k1."='".$v."-";}
					if($k=="month-field".$v1)
						{$temp.=$v."-";}
					if($k=="day-field".$v1)
						{$temp.=$v."',";}
						
					$clause.=@$temp; 
					$temp="";
					}
				}
				
       			$clause="set ".rtrim($clause,",");
			$sql = "INSERT INTO tal $clause";
//       echo "$sql"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql "); 
			$clause="";
       				
			$id=mysqli_insert_id($connection);
			
			// ****** uploads
			include("upload_code.php");
			//exit;
			
			header("Location: edit.php?edit=$id&submit=edit&message=1");
			exit;
       		}
 
$sql = "SELECT * FROM tal as t1 
	WHERE 1 order by tadpr desc limit 1	";	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");      		
while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}
//echo "Hello";
include("edit.php");
?>