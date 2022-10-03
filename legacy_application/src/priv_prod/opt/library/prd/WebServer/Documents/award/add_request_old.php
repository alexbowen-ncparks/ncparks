<?php
$database="award";
include("../../include/connectROOT.inc");// database connection parameters
include("../../include/auth.inc");// database connection parameters

mysql_select_db($database,$connection);

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
				$v=mysql_real_escape_string($v);				
				$clause.=$k."='".$v."',";
				}

// menu.php has the javascript that controls calendars - calendar(x)
/*
$date_array=array("date_needed"=>'2',"approv_PASU"=>'3',"approv_DISU"=>'4',"approv_PIO"=>'5',"approv_CHOP_DIR"=>'6',"approv_BPA"=>'7',"staff_notify"=>'8');

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
*/

       			$clause="set ".rtrim($clause,",");
			$sql = "INSERT INTO award_list $clause";
//echo "$sql"; exit;
			$result = mysql_query($sql) or die ("Couldn't execute query. $sql ".mysql_error()); 
			$clause="";
       				
			$id=mysql_insert_id();
			
			// ****** uploads
			include("upload_code.php");
			//exit;
			
			header("Location: edit.php?edit=$id&submit=edit&message=1");
			exit;
       		}
 
$sql = "SELECT * FROM award_list as t1 
	WHERE 1 order by dpr desc limit 1	";	
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");

$result = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");      		
while($row=mysql_fetch_assoc($result)){$ARRAY[]=$row;}
$pass_source="add";
include("edit.php");
?>