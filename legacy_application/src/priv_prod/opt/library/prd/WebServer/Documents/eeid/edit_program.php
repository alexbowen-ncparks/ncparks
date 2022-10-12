<?php
// echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
ini_set('display_errors',1);
extract($_REQUEST);
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;

	include_once("_base_top.php");// includes session_start();

$level=@$_SESSION['eeid']['level'];
if($level<1){echo "You do not have access to this database. Contact Tom Howard or John Carter for more info."; exit;}

$db="eeid";
include("../../include/get_parkcodes_reg.php"); // database connection parameters

$database="dpr_system";
mysqli_select_db($connection,$database)       or die ("Couldn't select database");
$sql="SELECT county FROM county_codes"; //echo "d=$database $sql";
$result = @MYSQLI_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$county_array[]=$row['county'];
	}

$db="eeid";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database)       or die ("Couldn't select database");

// Process Delete
if (!empty($del))
	{
	if(!empty($id))
		{
		$sql="DELETE FROM programs  where id='$id'"; //echo "$sql";
		$result = @MYSQLI_QUERY($connection,$sql);
		}
	
	include_once("_base_top.php");// includes session_start();
	echo "&nbsp;Record has been deleted. You can close this tab.";
	exit;
	}
// Process update
$skip_update=array("id","submit_form");
if(!empty($_POST['submit_form']))
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
	unset($temp);
	foreach($_POST as $fld=>$value)
		{
		if(in_array($fld, $skip_update)){continue;}
		$temp[]="$fld='$value'";
		}
	$clause=implode(",",$temp);
	$sql="UPDATE programs set $clause where id='$id'"; //echo "$sql";
	$result = @MYSQLI_QUERY($connection,$sql);
	if($result){$message="<font color='green'>Update was successful. Close tab.</font>";}else{$message="<font color='red'>Update was not successful.</font>";}
	}
	
	
	
// also in add_program.php
$grade_array=array("pk"=>"Pre-K","k"=>"K","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11","12"=>"mixed ages elementary","13"=>"mixed ages middle","14"=>"mixed ages high");

$sql="SELECT *  FROM category_descriptions"; //echo "d=$database $sql";
$result = @MYSQLI_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$category_array[$row['cat_code']]=array($row['cat_name'],$row['cat_description']);
	}
	
$sql="SELECT *  FROM programs where id='$id'"; //echo "d=$database $sql";
$result = @MYSQLI_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}

$skip=array("id");
$text=array("more_program_details","field_trip_summary");
$c=count($ARRAY);
echo "<form method='POST' action='edit_program.php'>
<table><tr><th colspan='2'>Edit Form</th></tr>";
if(!empty($message)){echo "<tr><td colspan='2'>$message</td></tr>";}
foreach($ARRAY AS $index=>$array)
	{
	extract($array);
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		echo "<tr><td>$fld</td><td>";
		$display="<input type='text' name='$fld' value=\"$value\">";
		if(in_array($fld,$text))
			{
			$display="<textarea name='$fld' rows='3' cols='85'>$value</textarea>";
			}
		if($fld=="date_program")
			{
			$display="<input id='datepicker2' type='text' name='$fld' value=\"$value\" size='10'>";
			}
		if($fld=="category")
			{
			$display="<select name='$fld' required><option selected=''></option>\n";
			foreach($category_array as $key_cat=>$array)
				{
				if($value==$key_cat){$s="selected";}else{$s="value";}
				$display.="<option value='$key_cat' $s>$array[0]</option>\n";
				}
			$display.="</select><br />";
			}
		if($fld=="age_group")
			{
			$age_group_array=array("School-age","Mixed Ages","Adults");
			$display="";		
			foreach($age_group_array as $var_k=>$var_v)
				{
				$ck="";
				if($value==$var_v){$ck="checked";}
				$display.="<input type='radio' name='$fld' value=\"$var_v\" $ck required>$var_v";
				}
			$display.="</td></tr>";
			}	
		if($fld=="location")
			{
			$display="";
			$value=="Park"?$ckp="checked":$ckp="";
			$display.="<input type='radio' name='$fld' value=\"Park\" $ckp required>Park";
			$value=="Outreach"?$cko="checked":$cko="";
			$display.="<input type='radio' name='$fld' value=\"Outreach\" $cko required>Outreach
			</td></tr>";
			}		
		if($fld=="grade")
			{
			$display="<select name='grade'><option selected=''></option>\n";
			foreach($grade_array as $kg=>$vg)
				{
				if($value==$kg){$s="selected";}else{$s="value";}
				$display.="<option $s='$kg'>$vg</option>\n";
				}
			$display.="</select>";
			}
		if($fld=="school_county")
			{
			array_unshift($county_array, "not applicable");
			$display="<select name='school_county'><option selected=''></option>\n";
			foreach($county_array as $key_county=>$value_county)
				{
				if($value==$value_county){$s="selected";}else{$s="value";}
				$display.="<option value='$value_county' $s>$value_county</option>\n";
				}
			$display.="</select>";
			}
			
			
		echo "$display";
		echo "</td></tr>";
		}
	}
echo "<tr><th colspan='2'>
<input type='hidden' name='id' value=\"$id\">
<input type='submit' name='submit_form' value=\"Update\">
</th>
<th><a href='/eeid/edit_program.php?del=1&id=$id' class=\"button\" onclick=\"return confirm('Are you sure you want to delete this Record?')\">Delete</a></th>
</tr></table></form></html>";

?>