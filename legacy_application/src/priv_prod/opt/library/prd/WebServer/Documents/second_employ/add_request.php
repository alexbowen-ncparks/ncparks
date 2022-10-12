<?php
$database="second_employ";
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
       
//echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  //exit;
//echo "<pre>";print_r($_FILES); echo "</pre>";  //exit;


 // Create record and produce PDF request
if(@$_POST['submit']=="Create Request Form")
       		{
// echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
       		$skip1=array("year","month","day","submit","id");
       		$skip2=array("submit","id");
       			foreach($_POST AS $k=>$v)
       				{
				if(in_array($k,$skip1) OR $v=="")
					{continue;}
				
				$test=explode("-",$k);
				if(in_array($test[0],$skip1)){continue;}
				
				if($k=="se_dpr"){$pass_se_dpr=$v;}
				
				@$clause.=$k."='".$v."',";
				}
		
		// menu.php has the javascript that controls calendars - calendar(x)
		$date_array=array("notify_supervisor"=>'1',"supervisor_approval"=>'2',"PASU_approval"=>'3',"DISU_approval"=>'4',"CHOP_approval"=>'5',"HR_approval"=>'6',"Director_approval"=>'7',"staff_notify"=>'8');
				
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
						
					@$clause.=$temp; $temp="";
					}
				}
				
       			$clause="set ".rtrim($clause,",");
			$sql = "INSERT INTO se_list $clause";
//echo "$sql"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql"); 
			$clause="";
       				
			$id=mysqli_insert_id($connection);
			
			// ****** uploads
			//include("upload_code.php");
			//exit;
			
			header("Location: pre_pdf.php?id=$id&submit=edit&message=1");
			exit;
       		}
       		
       		
       		

// Upload signed request and update dates      
if(@$_POST['submit']=="Submit")
       		{
// echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
       		$skip1=array("year","month","day","submit","id");
       		$skip2=array("submit","id");
       			foreach($_POST AS $k=>$v)
       				{
				if(in_array($k,$skip1) OR $v=="")
					{continue;}
				
				$test=explode("-",$k);
				if(in_array($test[0],$skip1)){continue;}
				
				if($k=="se_dpr"){$pass_se_dpr=$v;}
				
				$clause.=$k."='".$v."',";
				}

// menu.php has the javascript that controls calendars - calendar(x)
$date_array=array("notify_supervisor"=>'1',"supervisor_approval"=>'2',"PASU_approval"=>'3',"DISU_approval"=>'4',"CHOP_approval"=>'5',"HR_approval"=>'6',"Director_approval"=>'7',"staff_notify"=>'8');
				
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
						
					$clause.=$temp; $temp="";
					}
				}
				
       			$clause="set ".rtrim($clause,",");
			$sql = "REPLACE INTO se_list $clause";
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
 
$sql = "SELECT * FROM se_list as t1 
	WHERE 1 order by se_dpr desc limit 1	";	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");      		
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
$ARRAY[0]['request']="";
include("edit.php");
?>