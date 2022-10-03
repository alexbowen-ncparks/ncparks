<?php
$database="photos";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
   or die ("Couldn't select database $database");

ini_set('display_errors',1);
include("../no_inject_i.php");

extract($_REQUEST);

if(empty($rep))
	{
	$title="DCR Archive";
	include("_base_top.php");
	}

$clause="";
$skip=array("id","submit");
$arrays=array("subjects");
// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
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
	$sql="INSERT INTO dcr_archive set $clause"; echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	$new_id=mysqli_insert_id($connection);
	}

mysqli_select_db($connection, "dpr_system");
$sql="SELECT * FROM parkcode_names"; 
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
	$ARRAY_parks[]['place']=$row['park_name'].";".$var.";";
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
	
$sql="SELECT * FROM dcr_archive limit 1"; 
IF(!empty($new_id)){$sql="SELECT * FROM dcr_archive where id='$new_id'"; }
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
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

$default_array=array("creator","date","place","physical_characteristics","metadata_creator");
$text_array=array("title_","digital_creator","general_comments_by_dpr_team","maria,_program_manager_comment_column");

echo "<form action='archive_insert.php' method='POST'>";
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
				$rep_fld=$fld;
				if($fld=="title_"){$rep_fld="title";}
				echo "<tr>";
			
					$var_0=$ARRAY_notes[0][$fld];
					$var_1=$ARRAY_notes[1][$fld];
					$var=$var_0."***".$var_1;
					echo "<th><a onclick=\"toggleDisplay('$fld');\" href=\"javascript:void('')\">$rep_fld</a>
		<div id=\"$fld\" style=\"display: none\">$var</div></th><td>";
			
				if($fld=="subjects")
					{
					echo " <select name='subjects[]' multiple size='20'><option value='' selected></option>\n";
					  foreach($ARRAY_subjects as $k1=>$v1)
							{
							$v1=str_replace(";","",$v1);
							echo "<option value='$v1'>$v1</option>\n";
							}
						echo "</select>";
					continue;
					}
					
					
				if(!in_array($fld,$default_array))
					{
					if($fld=="local_call_no"){$value=$ARRAY[0]['object_file_name'];}
					if($fld=="digital_creation_date"){$input_id="id=\"datepicker1\"";}else{$input_id="";}
					if(in_array($fld,$text_array))
						{
						echo "<textarea name='$fld' cols='77' rows='2'></textarea>";
						}
						else
						{
						echo "<input $input_id type='text' name='$fld' value=\"\" size='33'>";
						}
					}
					else
					{
					$select_array=array();
					$field_defaults=$ARRAY_defaults;
					if($fld=="place"){$field_defaults=$ARRAY_parks;}
					foreach($field_defaults as $k=>$v)
						{
						if(array_key_exists($fld,$v)){$select_array[]=$v[$fld];}
						}
					
					if(!empty($select_array))
						{
						echo "<select name='$fld'><option value=''></option>\n";
						foreach($select_array as $k1=>$v1)
							{
							echo "<option value='$v1'>$v1</option>\n";
							}
						echo "</select>";
					}
				}
				
				
				echo "</td></tr>";			
				}
			}	
		}
	}
echo "<tr>
<td colspan='2' align='center'><input type='submit' name='submit' value=\"Add\"></td>
</tr>";
echo "</table>";
echo "</form>";
?>