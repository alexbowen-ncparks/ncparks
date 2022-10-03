<?php
$database="photos";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
   or die ("Couldn't select database $database");

ini_set('display_errors',1);
include("../no_inject_i.php");

$clause="";
$skip=array("id","submit","local_call_no","clemson");
$arrays=array("subjects");
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
if(!empty($_POST))
	{
	$_POST['metadata_creator']=$_SESSION['photos']['tempID'];
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
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
		$sql="INSERT INTO dcr_archive set $clause"; 
// 		echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql<br />".mysqli_error($connection));
		$id=mysqli_insert_id($connection);
		}
	header("Location: archive_update.php?id=$id");
	exit;
	}

extract($_REQUEST);

if(empty($rep))
	{
	$title="DCR Archive";
	include("_base_top.php");
	}
 //echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
 
mysqli_select_db($connection, "dpr_system");
$sql="SELECT t1.* , t2.city
FROM parkcode_names as t1
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
		{$ARRAY_parks[]['place']=$row['park_name'].";".$var."; ".$row['city'].", North Carolina; United States";}
		else
		{$ARRAY_parks[]['place']=$row['park_name'].";".$var."; North Carolina; United States";}
	}
//echo "<pre>"; print_r($ARRAY_parks); echo "</pre>";  exit;

mysqli_select_db($connection, $database);

//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
$sql="SELECT * FROM dcr_archive_notes"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_notes[]=$row;
	}

$sql="SELECT * FROM dcr_subjects order by subject"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_subjects[]=$row['subject'];
	}
$count_subjects=count($ARRAY_subjects);

$sql="SELECT * FROM dcr_periods order by period"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_periods[]['period']=$row['period'];
	}
	
$sql="SELECT * FROM dcr_creators order by creator"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_creators[]['creator']=$row['creator'];
	}
	
$sql="SELECT * FROM dcr_archive_defaults"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_defaults[][$row['dcr_field']]=$row['dcr_item'];
	}
//echo "<pre>"; print_r($ARRAY_defaults); echo "</pre>"; // exit;

$sql="SHOW columns FROM dcr_archive "; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row['Field'];
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
if(empty($rep))
	{
	include("archive_menu.php");
	}

$default_array=array("creator","period","place","physical_characteristics");
$text_array=array("title_","digital_creator","general_comments_by_dpr_team","program_manager_comment","index_terms","description");

echo "<form action='archive_insert.php' method='POST'>";
echo "<table>";
if(!empty($ARRAY))
	{
	foreach($ARRAY AS $index=>$fld)
		{
		
		$value="";   // blank value for insert form
		$ARRAY[0]['clemson']="";
		if($fld=="metadata_creator"){$value=$_SESSION['photos']['name'];}
		if(in_array($fld,$skip)){continue;}
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
				if($fld=="place")
					{
					$field_defaults=$ARRAY_parks;
					unset($select_array);
					foreach($field_defaults as $k=>$v)
						{
						if(array_key_exists($fld,$v)){$select_array[]=$v[$fld];}
						}
			
			if(!empty($select_array))
				{
				echo "<select name='$fld'><option value=''></option>\n";
				foreach($select_array as $k1=>$v1)
					{
					if($v1==$value){$s="selected";}else{$s="";}
					echo "<option value=\"$v1\" $s>$v1</option>\n";
					}
				echo "</select>";
				}
				continue;
					}
echo "</th><td$td>";
	
		if($fld=="object_file_name")
			{
			echo "<input type='text' name='$fld' value=\"$value\" size='33'>";
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
// 					echo "<a href='archive_update.php?id=$id'>Refresh</a> Subjects";
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
				echo "<input $input_id type='text' name='$fld' value=\"$value\" size='33'>";
				}
			}
			else
			{
			$select_array=array();
			$field_defaults=$ARRAY_defaults;
			if($fld=="place"){$field_defaults=$ARRAY_parks;}
			if($fld=="creator"){$field_defaults=$ARRAY_creators;}
			if($fld=="period"){$field_defaults=$ARRAY_periods;}
			foreach($field_defaults as $k=>$v)
				{
				if(array_key_exists($fld,$v)){$select_array[]=$v[$fld];}
				}
			
			if(!empty($select_array))
				{
				echo "<select name='$fld'><option value=''></option>\n";
				foreach($select_array as $k1=>$v1)
					{
					if($v1==$value){$s="selected";}else{$s="";}
					echo "<option value=\"$v1\" $s>$v1</option>\n";
					}
				echo "</select>";
				}
		}
		
		
		echo "</td></tr>";			
		

		}
	}
echo "<tr>
<td colspan='2' align='center'>
<input type='submit' name='submit' value=\"Insert\">
</td>
</tr>";
echo "</table>";
echo "</form>";
exit;
?>