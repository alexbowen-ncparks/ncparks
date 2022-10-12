<?php
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
$clause="";
$skip_update=array("submit","id","proj_type","review_code","how_done","proj_id","VAR");
foreach($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip_update)){continue;}
//	$value=mysqli_real_escape_string($connection,$value);
// 	values escaped in no_inject_i.php
	if($fld=="next_comment")
		{
		if(!empty($value))
			{
			$temp=substr($_SESSION['dpr_rema']['tempID'],0, -4)."@".date("Y-m-d H:i");
			$clause.="`proj_comments`=concat(`proj_comments`, '$value', ' -- ', '$temp', '\n\n'), ";
			}
		continue;
		}
	if($fld=="edits")
		{
		$temp=substr($_SESSION['dpr_rema']['tempID'],0, -4)."@".date("Y-m-d H:i");
		$clause.="`edits`=concat('$temp', ' -- ', edits), ";
		}
		else
		{
		if($fld=="park_code")
			{
			$value=str_replace(" ","",strtoupper($value));
			}
		if($fld=="proj_type")
			{
			$value=str_replace(" ","",strtoupper($value));
			}
		$clause.=$fld."='$value', ";
		}
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
//$clause=rtrim($clause,",")."'";
	
if(!empty($_POST['review_code']) and $_POST['review_code']!="Admin")
	{
	$clause.=", ".$_POST['review_code']."_date='".date('Y-m-d')."'";
	}
	
$id=$_POST['id'];
$clause.=" WHERE id='$id'";
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
$sql="UPDATE project set $clause";  //echo "$sql"; exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));

$sql="SELECT * from project where id='$id'";  //echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
$row=mysqli_fetch_assoc($result);
extract($row);
?>