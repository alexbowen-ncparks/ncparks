<?php
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
include("../../include/get_parkcodes_i.php");
mysqli_select_db($connection, "dpr_proj");
$clause="";
$skip_add=array("submit","proj_type","proj_status","how_done");
foreach($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip_add)){continue;}
	if(is_array($value)){echo "$fld<pre>"; print_r($value); echo "</pre>";  exit;}
//	$value=mysqli_real_escape_string($connection,$value);
// 	values escaped in no_inject_i.php
		if($fld=="park_code")
			{
			$value=str_replace(" ","",strtoupper($value));
			$exp=explode(",",$value);
			foreach($exp as $k=>$v)
				{
				if(!in_array($v,$parkCode)){echo "The park code $v does not exist. Contact Tom Howard."; exit;}
				}
			}
	$clause.=$fld."='$value', ";
	}
$clause=rtrim($clause,", ");

if(!empty($_POST['proj_type'][0]))
	{
	$clause.=", proj_type='";
	foreach($_POST['proj_type'] as $k=>$v)
		{
		$clause.="$v,";
		}
	$clause=rtrim($clause,",")."'";
	}
	
$clause.=", how_done='";
foreach($_POST['how_done'] as $k=>$v)
	{
	if(!empty($v))
		{
		$temp_v=$how_done_array[$k];
		$clause.="$temp_v*".$v.",";
		}
		else
		{$clause.=",";}
	}
$clause.="'";
$this_y=date("y");

$pn=$_POST['proj_name'];
$sql="SELECT proj_number from project order by id desc limit 1";  //echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. ".mysqli_error($connection));
$row=mysqli_fetch_assoc($result);
$temp_pn=$row['proj_number'];
$exp=explode("_",$temp_pn);
$year=$exp[0]; @$prev_pm=$exp[1];  //echo "1=$this_y  2=$year<br />";
if($this_y==$year)
	{
	$var=$year."_".str_pad(($prev_pm+1),3, "0",STR_PAD_LEFT);
	}
	else
	{
	$var=$this_y."_".str_pad((1),3, "0",STR_PAD_LEFT);
	}
$sd=date("Y-m-d");
$sql="INSERT INTO project set $clause, proj_number='$var', submitted_date='$sd'";  //echo "$sql"; exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. ".mysqli_error($connection)." - Project Name, Submitted by and Submitted Date.");
$id=mysqli_insert_id($connection);

$sql="SELECT * from project where id='$id'";  //echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. ".mysqli_error($connection));
$row=mysqli_fetch_assoc($result);
extract($row);
?>