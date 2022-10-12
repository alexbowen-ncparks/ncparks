<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
ini_set('display_errors',1);
extract($_REQUEST);

	include_once("_base_top.php");// includes session_start();
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$level=@$_SESSION['eeid']['level'];
$tempID=$_SESSION['eeid']['tempID'];
$db="eeid";
if($level<1){echo "You do not have access to this database. Contact Tom Howard or John Carter for more info."; exit;}
$access_park_array=array($_SESSION['eeid']['select']);
// also in add_program.php
if($tempID=="Sanford5534")
	{
	$_SESSION[$db]['accessPark']="DISW,MEMI,SACR";
	}
if(!empty($_SESSION['eeid']['accessPark']))
	{
	$access_park_array=explode(",",$_SESSION['eeid']['accessPark']);
	}
// echo "<pre>"; print_r($access_park_array); echo "</pre>";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database)       or die ("Couldn't select database");


$TABLE="programs";
$sql="SHOW COLUMNS FROM  $TABLE"; //echo "d=$database $sql";
$result = @MYSQLI_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$allFields[]=$row['Field'];
	$allTypes[]=$row['Type'];
	if(strpos($row['Type'],"decimal")>-1){
		$decimalFields[]=$row['Field'];
		$tempVar=explode(",",$row['Type']);
		$decPoint[$row['Field']]=trim($tempVar[1],")");
		}
	if(strpos($row['Type'],"char")>-1 || strpos($row['Type'],"varchar")>-1){
		$charFields[]=$row['Field'];
		$tempVar=explode("(",$row['Type']);
		$charNum[$row['Field']]=trim($tempVar[1],")");
		}
	if(strpos($row['Type'],"text")>-1){
		$textFields[]=$row['Field'];
		}
	}
// Get program cagegories
$sql="SELECT *  FROM category_descriptions"; //echo "d=$database $sql";
$result = @MYSQLI_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$category_array[$row['cat_code']]=array($row['cat_name'],$row['cat_description']);
	}
// echo "<pre>"; print_r($category_array); echo "</pre>"; // exit;
// ******** Show Form here **********
// echo "<pre>";print_r($allFields);echo "</pre>";

// also in add_program.php
$grade_array=array("pk"=>"Pre-K","k"=>"K","1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10","11"=>"11","12"=>"mixed ages elementary","13"=>"mixed ages middle","14"=>"mixed ages high");

$sql="SELECT distinct park_code
FROM `programs` as t1
where 1 order by park_code";  
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$park_array[]=$row['park_code'];
		}
$sql="SELECT distinct grade
FROM `programs` as t1
where 1 order by grade";  
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$grade_value_array[]=$row['grade'];
		}
$sql="SELECT distinct category
FROM `programs` as t1
where 1 order by category";  
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$category_value_array[]=$row['category'];
		}
// echo "<pre>"; print_r($grade_value_array); echo "</pre>"; // exit;

$sql="SELECT distinct age_group
FROM `programs` as t1
where 1 order by age_group";  
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$age_group_value_array[]=$row['age_group'];
		}

$sql="SELECT distinct year(date_program) as year
FROM `programs` as t1
where 1 ";  
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$year_value_array[]=$row['year'];
		}
$sql="SELECT distinct substring(date_program from 6 for 2) as month, monthname(date_program) as month_name
FROM `programs` as t1
where 1 ";  
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$month_value_array[$row['month']]=$row['month_name'];
		}
// echo "<pre>"; print_r($month_value_array); echo "</pre>"; // exit;
		
$sql="SELECT distinct location
FROM `programs` as t1
where 1 order by location";  
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$location_value_array[]=$row['location'];
		}
		
$sql="SELECT *
FROM `category_descriptions`
order by cat_code";  
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$category_array[$row['cat_code']]=$row['cat_name'];
		}
				
echo "<form method='POST' ACTION='search_programs_database.php'><table><tr><td>Park:<br /><select name='park_code'><option selected=''></option>\n";
foreach($park_array as $k=>$v)
	{
// 	if($park_code==$v){$s="selected";}else{$s="";}
	$s="";
	echo "<option value='$v' $s>$v</option>\n";
	}
echo "</select></td>";

echo "<td>Category:<br /><select name='category'><option selected=''></option>\n";
foreach($category_value_array as $k=>$v)
	{
// 	if(@$category==$v){$s="selected";}else{$s="";}
	$s="";
	$vv=$category_array[$v];
	echo "<option value='$v' $s>$vv</option>\n";
	}
echo "</select></td>";

echo "<td>Location:<br /><select name='location'><option selected=''></option>\n";
foreach($location_value_array as $k=>$v)
	{
// 	if($location==$v){$s="selected";}else{$s="";}
	$s="";
	echo "<option value='$v' $s>$v</option>\n";
	}
echo "</select></td>";

echo "<td>Grade:<br /><select name='grade'><option selected=''></option>\n";
foreach($grade_value_array as $k=>$v)
	{
// 	if($grade==$v){$s="selected";}else{$s="";}
	$s="";
	$val=$grade_array[$v];
	echo "<option value='$v' $s>$val</option>\n";
	}
echo "</select></td>";

echo "<td>Age Group:<br /><select name='age_group'><option selected=''></option>\n";
foreach($age_group_value_array as $k=>$v)
	{
// 	if($age_group==$v){$s="selected";}else{$s="";}
	$s="";
	echo "<option value='$v' $s>$v</option>\n";
	}
echo "</select></td></tr>";

$auto_fill=array("presenter","program_title","school","school_county");
// $auto_fill=array("program_title");

echo "<tr>";
foreach($auto_fill as $k=>$v)
	{
	unset($temp_array);
	$sql="SELECT distinct $v
	FROM `programs`
	order by $v";  
	$result = mysqli_query($connection,$sql);
	while($row=mysqli_fetch_assoc($result))
			{
			$temp_array[]=$row[$v];
			}
	${"source_".$v}="";

	foreach($temp_array as $k1=>$v1)
		{
		$v1=trim($v1);
		$test_array[]=$v1;
		${"source_".$v}.="\"".$v1."\",";
		}
	$source=${"source_".$v};
		echo "
	<script>
		$(function()
			{
			$( \"#$v\" ).autocomplete({
			source: [ $source ]
				});
			});
		</script>";
	echo "<td>$v:<br /><input id='$v' type='text' name='$v' value=\"\"></td>";
	}
// echo "$source"; // exit;	
// echo "<pre>"; print_r($test_array); echo "</pre>";  exit;
echo "</tr><tr>";

// $group_array=array("park"=>"park_code","category"=>"category");
$group_array=array("park"=>"park_code");

echo "<td colspan='2'>Date Range: <br />
begin <input id=\"datepicker1\" type='text' name='date_start' value=\"\"><br />
end &nbsp;&nbsp;<input id=\"datepicker2\" type='text' name='date_end' value=\"\"></td>";

echo "<td colspan='2'>more_program_details<input type='text' name='more_program_details' value=\"\"></td>";
echo "<td><input type='checkbox' name='limit' value=\"x\"> No Limit</td>";
if($level>0)
	{
	echo "<td>Group by: <select name='group_by'><option value=\"\"></option>\n";
	foreach($group_array as $k=>$v)
		{
		echo "<option value=\"$v\">$k</option>\n";
		}
	echo "</select></td>";
	}
echo "</tr>";
echo "<tr><th colspan='5'>
<input type='submit' name='submit' value='Search' style='color:green; font-size: 150%'>
</th>";
echo "</tr>";


echo "</table></form><hr />";

if(empty($_POST))
	{
	exit;
	}
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
$skip=array("submit","limit","group_by");
$like=array("program_title","presenter",'more_program_details');
$pass_start="";
$pass_end="";
foreach($_POST as $fld=>$value)
	{
	if(in_array($fld, $skip)){continue;}
	if(in_array($fld, $like) AND !EMPTY($value))
		{
		$temp[]="$fld like '%$value%'";
		continue;
		}
	if(!empty($value))
		{
		if($fld=="date_start" or $fld=="date_end")
			{
			if($fld=="date_start")
				{			
				$temp[]="`date_program` >= '$value%'";
				$pass_start="`date_program` >= '$value%'";
				if(empty($_POST['date_end']))
					{
					$temp[]="`date_program` = '$value'";
					}
				}
			if($fld=="date_end")
				{
				$pass_end="`date_program` <= '$value%'";
				$temp[]="`date_program` <= '$value%'";
				}
			}
		else
			{
			$temp[]="$fld='$value'";
			}
		}
	}
if(empty($temp)){exit;}
$clause=implode(" and ",$temp);


if(empty($limit))
	{
	$limit="limit 250";
	}
	else
	{$limit="";}

$order_by="date_program desc, park_code";
if(!empty($group_by))
	{
	$order_by="$group_by";
	$group_by="group by $group_by";
	$sql="SELECT t1.id, t1.park_code,  concat(t1.park_code, t1.id) as park_id, count(t1.id) as num,
	group_concat(distinct program_title separator ', ') as 'Program Title(s)'
	FROM `programs` as t1 
	where 1 and $clause
	group by park_code 
	order by park_code";
	}
	else
	{
	$group_by="";
	$sql="SELECT t1.*, concat(t1.park_code, t1.id) as park_id 
	FROM `programs` as t1
	where 1 and $clause
	$group_by
	order by $order_by
$limit"; 
	}
// echo "$sql";
$result = mysqli_query($connection,$sql);
if($result)
	{
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	}
//echo "<pre>"; print_r($correlation_array); echo "</pre>"; // exit;
		
$skip=array("id","park_id");

if(empty($ARRAY))
	{echo "Nothing found."; exit;}

$c=count($ARRAY);
$total_time_givens=0;
$total_total_attendance=0;
echo "<table border='1' bgcolor='beige'>
<tr><td colspan='2'>$c entries</td>";

if(!empty($pass_start)){echo "<td>$pass_start $pass_end</td>";}
if(!empty($category)){echo "<td>Category=".$category_array[$category]."</td>";}

echo "</tr>";
if($c==250){echo "<tr><td colspan='6'>Only the first 250 entries returned.</td></tr>";}
foreach($ARRAY AS $index=>$array)
	{
	if(empty($group_by))
		{
		$total_time_givens+=$ARRAY[$index]['times_given'];
		$total_total_attendance+=$ARRAY[$index]['total_attendance'];
		}
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$var_f=str_replace("_", " " ,$fld);
			echo "<th style='vertical-align: text-top;'>$var_f</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		$display="<td style='vertical-align: text-top;'>$value</td>";
		if($fld=="category")
			{
			$val=$category_array[$value];
			$display="<td style='vertical-align: text-top;'>$val</td>";
			}
		if($fld=="more_program_details")
			{
			$val=substr($value,0,85);
			if(strlen($value)>85){$val.="...";}
			$display="<td style='vertical-align: text-top;'>$val</td>";
			}
		if($fld=="park_code")
			{
			$id=$array['id'];
			$val="<a href='edit_program.php?id=$id' target='_blank'>$value</a>";
			$display="<td style='vertical-align: text-top;'>$val</td>";
			if($level<2 and !in_array($value,$access_park_array))
				{
				$display="<td style='vertical-align: text-top;'>$value</td>";
				}
			}
		echo "$display";
		}
	echo "</tr>";
	}
if(empty($group_by))
	{
	$total_total_attendance=number_format($total_total_attendance, 0);
	}
echo "<tr><th>Totals</th><th colspan='5' style='text-align: right'>$total_time_givens</th><th>$total_total_attendance</th></tr>";
		
echo "</body></html>";
mysqli_close($connection);
?>