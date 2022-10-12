<?php
extract($_REQUEST);

include("menu.php");  // includes connection and db select

include("../../include/iConnect.inc");
mysqli_select_db($connection, "photo_point");

$table="photo_point";
$file=$_SERVER['PHP_SELF'];

$sql="SHOW COLUMNS from photo_point";
//echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;	
	}
//echo "test<pre>"; print_r($ARRAY); echo "</pre>"; //exit;

if(EMPTY($_POST['submit']))
	{
	$sql="SELECT * from photo_point order by park_code";
	//echo "$sql";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_pp[]=$row;	
		$park_code_array[]=$row['park_code'];
		$pp_code_array[]=$row['pp_code'];
		$category_array[]=$row['category'];
		$burn_unit_array[]=$row['park_code']."_".$row['burn_unit'];
		$pp_name_array[]=$row['park_code']."_".$row['pp_name'];
		$year_array[]=$row['year'];
		$season_array[]=$row['season'];
		}
	}
//echo "<pre>"; print_r($ARRAY_pp); echo "</pre>"; // exit;
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

echo "<div align='center'>";

echo "<form method='post' action='search.php'>";

$skip=array("unit_id");

echo "<table cellpadding='10'>";
	//echo "<tr>";
foreach($ARRAY AS $index=>$array)
	{
	$f=fmod($index,4);
	if($f==0){echo "<tr>";}
	foreach($array as $fld=>$value)
		{
		if($fld=="Field")
			{
			$input="<td>$value<br />";
			$input.="<input type='text' name='$value'></td>";
			
			if($value=="park_code")
				{
				$input="<td>$value<br /><select name='$value'><option value='' selected></option>\n";
				$var_array=array_unique(${$value."_array"});
				foreach($var_array as $k=>$v)
					{
					$input.="<option value='$v'>$v</option>\n";
					}
				$input.="</select>";
				}
			if($value=="pp_code")
				{
				$input="<td>$value<br /><select name='$value'><option value='' selected></option>\n";
				$var_array=array_unique(${$value."_array"});
				foreach($var_array as $k=>$v)
					{
					$input.="<option value='$v'>$v</option>\n";
					}
				$input.="</select>";
				}
			if($value=="category")
				{
				$input="<td>$value<br /><select name='$value'><option value='' selected></option>\n";
				$var_array=array_unique(${$value."_array"});
				foreach($var_array as $k=>$v)
					{
					if(empty($v)){continue;}
					$input.="<option value='$v'>$v</option>\n";
					}
				$input.="</select>";
				}
			if($value=="burn_unit")
				{
				$input="<td>$value<br /><select name='$value'><option value='' selected></option>\n";
				$var_array=array_unique(${$value."_array"});
				foreach($var_array as $k=>$v)
					{
					if(empty($v)){continue;}
					$input.="<option value='$v'>$v</option>\n";
					}
				$input.="</select>";
				}
			if($value=="pp_name")
				{
				$input="<td>$value<br /><select name='$value'><option value='' selected></option>\n";
				$var_array=array_unique(${$value."_array"});
				foreach($var_array as $k=>$v)
					{
					if(empty($v)){continue;}
					$input.="<option value='$v'>$v</option>\n";
					}
				$input.="</select>";
				}
			if($value=="year")
				{
				$input="<td>$value<br /><select name='$value'><option value='' selected></option>\n";
				$var_array=array_unique(${$value."_array"});
				foreach($var_array as $k=>$v)
					{
					if(empty($v)){continue;}
					$input.="<option value='$v'>$v</option>\n";
					}
				$input.="</select>";
				}
			if($value=="season")
				{
				$input="<td>$value<br /><select name='$value'><option value='' selected></option>\n";
				$var_array=array_unique(${$value."_array"});
				foreach($var_array as $k=>$v)
					{
					if(empty($v)){continue;}
					$input.="<option value='$v'>$v</option>\n";
					}
				$input.="</select>";
				}
				
			echo "$input";
			}
			else
			{}
		}
	if($f==3){echo "</tr>";}
	}
	
echo "<tr><td>
<input type='submit' name='submit' value='Search'>
</td></tr>";
echo "</table>";

echo "</form>";

echo "</div>";
?>