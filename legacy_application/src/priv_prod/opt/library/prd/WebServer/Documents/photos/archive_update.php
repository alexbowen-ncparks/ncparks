<?php
$database="photos";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
   or die ("Couldn't select database $database");

ini_set('display_errors',1);

extract($_REQUEST);

if(empty($rep))
	{
	$title="DCR Archive";
	include("_base_top.php");
	$tempID=$_SESSION['photos']['tempID'];
	}
if(@$_POST['submit']=="Delete")
	{
	$sql="DELETE FROM dcr_archive where id='$id'"; 
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	include("archive_menu.php");
	echo "Record deleted";
	exit;
	}
	
	
$sql="SELECT * FROM dcr_periods order by period"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_periods[]=$row;
	}
// echo "<pre>"; print_r($ARRAY_periods); echo "</pre>"; // exit;

$clause="";
$skip=array("id","submit","local_call_no","clemson");
$arrays=array("subjects");
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
if(!empty($_POST))
	{
	date_default_timezone_set('America/New_York');
//  	echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  //exit;
	if(isset($_POST['clemson']))
		{
		if(strpos($_POST['description'],"This item was digitized by Clemson University")>-1)
			{}
			else
			{
			$clause.="`clemson`='x',";
			$_POST['description'].=" This item was digitized by Clemson University Libraries for the Open Parks Network. This project was made possible in part by the Institute for Museum and Library Services [LG-05-10-0117-10].";
			$_POST['digital_creator'].="This item was digitized by Clemson University Libraries for the Open Parks Network. This project was made possible in part by the Institute for Museum and Library Services [LG-05-10-0117-10].";
			}
		}
		else
		{
		$clause.="`clemson`='',";
		$pd_replace=str_replace(" This item was digitized by Clemson University Libraries for the Open Parks Network. This project was made possible in part by the Institute for Museum and Library Services [LG-05-10-0117-10].","",$_POST['description']);
		$dc_replace=str_replace("This item was digitized by Clemson University Libraries for the Open Parks Network. This project was made possible in part by the Institute for Museum and Library Services [LG-05-10-0117-10].","",$_POST['digital_creator']);
		$_POST['description']=$pd_replace;
		$_POST['digital_creator']=$dc_replace;
		}
	
	if(!empty($_POST['date']))
		{
// 		echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
			$var_year=substr($_POST['date'],0,4);
// 			echo "t=$var_year<pre>"; print_r($ARRAY_periods); echo "</pre>"; // exit;
			foreach($ARRAY_periods as $k2=>$array2)
				{
				if($var_year>=$array2['range_start'] and $var_year<=$array2['range_end'])
					{$_var['period'][]=mysqli_real_escape_string($connection,$array2['period']);}
				}
			$t=array_unique($_var); 
			$temp=implode(";", $t['period']);	
			$_POST['period']=$temp;
// 				echo "$temp<pre>"; print_r($_POST['period']); echo "</pre>"; // exit;
		}
		
	if(!empty($_POST['period']) and empty($_POST['date']))
		{
// 		echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
// 		echo "<pre>"; print_r($ARRAY_periods); echo "</pre>";  exit;
			foreach($ARRAY_periods as $k2=>$array2)
				{
				if(in_array($array2['period'], $_POST['period']))
					{$_var['period'][]=mysqli_real_escape_string($connection,$array2['period']);}
				}
			$t=array_unique($_var); 
			$temp=implode(";", $t['period']);	
			$_POST['period']=$temp;
//  				echo "$temp<pre>"; print_r($_POST['period']); echo "</pre>";  exit;
		}

	foreach($_POST AS $k=>$v)
		{
		if(in_array($k,$skip)){continue;}
		if(in_array($k,$arrays))
			{
			$clause.="`".$k."`='";
			foreach($v as $k1=>$v1)
				{
				$clause.=$v1.";";
				}
			$clause.="',";
			continue;
			}
		$clause.="`".$k."`='".$v."',";
		}
	$clause=rtrim($clause,",");
	
	if(!empty($clause))
		{
		$sql="UPDATE dcr_archive set $clause where id='$id'"; 
	// 	if($tempID=="Howard6319")
// 			{
// 	 		echo "$sql"; exit;
// 			}
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
		}
	
	if($_FILES['file']['size']>0)
		{
// 		echo "<pre>"; print_r($_FILES); echo "</pre>"; // exit;
		$temp_name=$_FILES['file']['tmp_name'];
		if($temp_name==""){continue;}
		$exp=explode(".",$_FILES['file']['name']);
		$time=time();
		$file_name=$time.".".array_pop($exp);
		$year=date("Y");
		$uploaddir = "archive_images/".$year; // make sure www has r/w permissions on this folder
		if (!file_exists($uploaddir)) {mkdir ($uploaddir, 0777);}
		$month=date("m");
		$uploaddir = "archive_images/".$year."/".$month; // make sure www has r/w permissions on this folder
		if (!file_exists($uploaddir)) {mkdir ($uploaddir, 0777);}
		$uploadfile = $uploaddir."/".$file_name;
		move_uploaded_file($temp_name,$uploadfile);// create file on server
		chmod($uploadfile,0777);
		$sql="REPLACE dcr_archive_images (archive_id,link) "."VALUES ('$id','$uploadfile')";
		$result = @mysqli_query($connection,$sql) or die("$sql<br />Error #" . mysql_error($connection));
		
		$image = new Imagick($uploadfile); 
		$image->thumbnailImage(150, 0); 
		//echo $image;
		$thumb=$uploaddir."/ztn.".$file_name;
		$image->writeImage($thumb);
		$image->destroy();
		}
	}
mysqli_select_db($connection, "dpr_system");
$sql="SELECT t1.* , t2.city
FROM parkcode_names_region as t1
left join dprunit as t2 on t1.park_code=t2.parkcode"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$exp=explode(",",$row['county']);
	$temp=array();
	foreach($exp as $k=>$v)
		{
		$a=explode(";",$v);
		$temp[]=trim($a[0])." County";
		}
	$var=implode(";",$temp);
	if(!empty($row['city']))
		{$ARRAY_parks[]['place']=$row['park_name'].";".$var."; ".$row['city'].", North Carolina, United States";}
		else
		{$ARRAY_parks[]['place']=$row['park_name'].";".$var."; North Carolina, United States";}
	}
$ARRAY_parks[]['place']="North Carolina, United States";
$ARRAY_parks[]['place']="North Carolina, United States";
$ARRAY_parks[]['place']="Boone’s Cave State Natural Area;Davidson County;Lexington, North Carolina, United States";
$ARRAY_parks[]['place']="Waynesborough State Park;Wayne County;Goldsboro, North Carolina, United States";
//echo "<pre>"; print_r($ARRAY_parks); echo "</pre>";  exit;

mysqli_select_db($connection, $database);

//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
$sql="SELECT * FROM dcr_archive_notes"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_notes[]=$row;
	}

$sql="SELECT * FROM dcr_characteristics order by characteristic"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_physical_characteristics[]['physical_characteristics']=$row['characteristic'];
	}
// echo "<pre>"; print_r($ARRAY_physical_characteristics); echo "</pre>"; // exit;
	
$sql="SELECT * FROM dcr_subjects order by subject"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_subjects[]=$row['subject'];
	}
$count_subjects=count($ARRAY_subjects);
 
 
//  $ARRAY_periods created above
 
$sql="SELECT * FROM dcr_creators order by creator"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_creators[]['creator']=$row['creator'];
	}
	
$sql="SELECT * FROM dcr_archive where id='$id'"; 
IF(!empty($new_id)){$sql="SELECT * FROM dcr_archive where id='$new_id'"; }
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
	
$sql="SELECT * FROM dcr_archive_images where archive_id='$id'"; 
IF(!empty($new_id)){$sql="SELECT * FROM dcr_archive where id='$new_id'"; }
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_images=$row;
	}
	
$sql="SELECT * FROM dcr_archive_defaults"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_defaults[][$row['dcr_field']]=$row['dcr_item'];
	}
//echo "<pre>"; print_r($ARRAY_defaults); echo "</pre>"; // exit;

if(empty($rep))
	{
	include("archive_menu.php");
	}

$default_array=array("creator","period","place","physical_characteristics","metadata_creator");
$text_array=array("title_","digital_creator","general_comments_by_dpr_team","program_manager_comment","index_terms","description");
$restrict_array=array("dcr_sent");

// echo "<pre>"; print_r($ARRAY_thumbs);  print_r($ARRAY_images); echo "</pre>"; // exit;

echo "<form action='archive_update.php' method='POST' enctype='multipart/form-data'>";
echo "<table>";
if(!empty($ARRAY))
	{
	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			foreach($ARRAY[0] AS $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				$ro="";
				if(in_array($fld,$restrict_array) and $tempID!="Cucurullo1234"){$ro="READONLY";}
				$rep_fld=$fld;
				if($fld=="title_"){$rep_fld="title";}
				if($fld=="object_file_name"){$td=" align='left' colspan='3'";}else{$td="";}
				echo "<tr>";
			
					$var_0=$ARRAY_notes[0][$fld];
					$var_1=$ARRAY_notes[1][$fld];
					$var=$var_0."***".$var_1;
					echo "<th valign='top'><a onclick=\"toggleDisplay('$fld');\" href=\"javascript:void('')\">$rep_fld</a>
		<div id=\"$fld\" style=\"display: none\">$var</div>";
		
						if($fld=="description")
							{
							$ARRAY[0]['clemson']==""?$ck="":$ck="checked";
							echo "Clemson <input type='checkbox' name='clemson' value=\"x\" $ck>";
							}
		echo "</th><td$td>";
			
				if($fld=="object_file_name")
					{
					echo "<input type='text' name='$fld' value=\"$value\" size='33'>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<a href='archive_update.php?id=$id'>Refresh</a> Subjects";
					continue;
					}
				if($fld=="subjects")
					{
					if($count_subjects<10){$ms=$count_subjects;}else{$ms=$count_subjects;echo "<td rowspan='33' valign='top'>";}
					echo "
					<select name='subjects[]' multiple size='$ms'>";
					  foreach($ARRAY_subjects as $k1=>$v1)
							{
							$exp=explode(";",$value);
							$v1=str_replace(";","",$v1);
							if(in_array($v1,$exp)){$s="selected";}else{$s="";}
							$v1=str_replace(";","",$v1);
							if(empty($v1)){continue;}
							echo "<option value=\"$v1\" $s>$v1</option>\n";
							}
						echo "</select>";
					continue;
					}
			
					
				if(!in_array($fld,$default_array))
					{
					if($fld=="local_call_no"){$value=$ARRAY[0]['object_file_name'];}
					$input_id="";
					if($fld=="digital_creation_date"){$input_id="id=\"datepicker1\"";}
					if($fld=="date"){$input_id="id=\"datepicker2\"";}
					if(in_array($fld,$text_array))
						{
						echo "<textarea name='$fld' cols='66' rows='2'>$value</textarea>";
						}
						else
						{
						echo "<input $input_id type='text' name='$fld' value=\"$value\" size='55' $ro>";
						}
					}
					else
					{
					$select_array=array();
					$field_defaults=$ARRAY_defaults;
					if($fld=="place"){$field_defaults=$ARRAY_parks;}
					if($fld=="creator"){$field_defaults=$ARRAY_creators;}
					if($fld=="period")
						{
						$field_defaults=$ARRAY_periods;
						echo "auto selected if a year is entered in date<br />
						if date is blank then period can be manually selected<br />";
						}
					if($fld=="physical_characteristics"){$field_defaults=$ARRAY_physical_characteristics;}
					foreach($field_defaults as $k=>$v)
						{
						if(array_key_exists($fld,$v)){$select_array[]=$v[$fld];}
						}
					
// 			 		if($fld=="metadata_creator")
//  						{
// //  						echo "<input type='text' name='$fld' value=\"$value\" size='15'>";
//  						}
					if(!empty($select_array))
						{
// 						echo "<pre>"; print_r($select_array); echo "</pre>"; // exit;
						$var_m="";
						if($fld=="period")
							{
							$var_m="multiple size='13'";
							$fld.="[]";
							$var_period=explode(";", $value);
							}
							else
							{
							$var_period[]=$value;
							}
						echo "<select name='$fld' $var_m><option value=''></option>\n";
						foreach($select_array as $k1=>$v1)
							{
							if($fld=="metadata_creator")
								{$v1=str_replace(";","",$v1);}
							
							if(in_array($v1,$var_period)){$s="selected";}else{$s="";}
							echo "<option value=\"$v1\" $s>$v1</option>\n";
							}
						echo "</select>";
						}
				}
				
				
				echo "</td></tr>";			
				}
			
			$display="<tr><td></td><td><input type='file' name='file'></td></tr>";
			if(!empty($ARRAY_thumbs['link']))
				{
				$display="<tr><td></td><td><img src='$ARRAY_thumbs[link]'>
				<br /><input type='file' name='file'></td></tr>";
				}
			if(!empty($ARRAY_images['link']))
				{
				$temp=$ARRAY_images['link'];
				$ext=explode("/",$temp);
				$th="ztn.".array_pop($ext);
				$th=implode("/",$ext)."/".$th;
				$display="<tr><td></td><td><a href='$temp' target='_blank'><img src='$th'></a>
				<br /><input type='file' name='file'></td></tr>";
				}
				
				echo "$display";
				
			}	
		}
	}
echo "<tr>
<td colspan='2' align='center'>
<input type='hidden' name='id' value=\"$id\">
<input type='submit' name='submit' value=\"Update\">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type='submit' name='submit' value=\"Delete\"  onclick=\"return confirm('Are you sure you want this Record?')\">
</td>
</tr>";
echo "</table>";
echo "</form>";
exit;
?>