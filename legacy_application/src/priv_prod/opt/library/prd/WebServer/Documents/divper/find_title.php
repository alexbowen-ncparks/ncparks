<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users

$test=$_SESSION['logname'];

$level=$_SESSION['divper']['level'];
$parkcode=$_SESSION['divper']['select'];
$ckPosition=strtolower($_SESSION['position']);

// also in position_desc.php
$committee=array("Howard6319","Mitchener8455","Oneal1133","Quinn0398","Bunn8227","McElhone8290","Williams5894","Howerton3639","Dowdy5456","Evans2660","Fullwood1940","Greenwood3841","Whitaker5705","Dodd3454");

if(!in_array($test,$committee)){echo "You do not have access to this file."; exit;}

$edit_position=array("howard6319","williams5894","blue7128","isley4624");

// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

include("../../include/get_parkcodes_reg.php"); 

mysqli_select_db($connection,'divper'); // database

// extract($_REQUEST);

if($level<5)
	{
	include("menu_position_desc.php"); 
	}
else
	{
	include("menu.php"); 
	}


// Get any already uploaded position description base template files
$sql="SELECT * from position_desc_forms where beacon_title='$beacon_title'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while ($row=mysqli_fetch_assoc($result))
		{
		$uploads[$row['form_name']]=$row['file_link'];
		}
//echo "$sql<pre>"; print_r($uploads); echo "</pre>"; //exit;

/*
// no longer needed since a single blank form works for all positions
// Get any already uploaded ADA file for position
$sql="SELECT * from position_ada_forms where 1";
$result = mysqli_query($sql) or die ("Couldn't execute query. $sql");
while ($row=mysqli_fetch_assoc($result))
		{
		$ada_form[$row['form_name']]=$row['file_link'];
		}
//echo "$sql<pre>"; print_r($uploads); echo "</pre>"; //exit;
*/


$sql="SELECT * from position_desc_assoc where beacon_title='$beacon_title'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while ($row=mysqli_fetch_assoc($result))
		{
		$list[$row['title_grade']]=$row['beacon_title'];
		}

if($level>4)
{
// Show all possible position desc template files
echo "<table border='1' cellpadding='3'>";
if(isset($list))
	{
	foreach($list as $k=>$v)
		{
		if($v==$beacon_title){$array[]=$k;}
		}
	echo "<tr><td colspan='6'><h2>Step 1</h2> Upload <font color='red'>Position Descripton</font> Template (in Word) for $beacon_title</td></tr>";
	}
	else
	{
	echo "<tr><th colspan='6'><font color='red'>The Template for $beacon_title has not been added to the database.</font> Contact Tom Howard.</th></tr>";
	}
//echo "<pre>"; print_r($array); echo "</pre>";
if(isset($array))
	{
	foreach($array as $k=>$v)
		{
		echo "<tr><form method='post' action='position_desc_template_upload.php' enctype='multipart/form-data'>
		<td><font color='purple'>$v</font></td>
		<td>Click to select your file. 
		<input type='file' name='file_upload'  size='40'> Then click this button. 
		<input type='hidden' name='beacon_title' value='$beacon_title'>
		<input type='hidden' name='form_name' value='$v'>
		<input type='submit' name='submit' value='Add File'>
		</form></td>";
		if(@array_key_exists($v,$uploads))
			{
			$link=$uploads[$v];
			echo "<td>Get <a href='$link'>file</a></td>";
			}
		echo "</tr>";
		 }
	echo "</table><hr />";
	}
}

if(isset($sort))
	{
	if($sort=="sg"){$order="order by t1.salary_grade";}
	if($sort=="code"){$order="order by t1.code";}
	if($sort=="region"){$order="order by t4.region, t1.code";}
	if($sort=="name"){$order="order by t3.Lname, t3.Fname";}
	}
	else
	{
	$order="order by t1.code";
	}


$where="where t1.beacon_title='$beacon_title'";
if($level==2)
	{
	if(strtolower($test)!="bunn8227" and strtolower($test)!="jackson5451")
		{
		$where="where t1.beacon_title='$beacon_title' and (";
		$a="array";$b="$_SESSION[parkR]";
		$distArray=${$a.$b};
		foreach($distArray as $index=>$parkcode)
			{
			$where.="code='$parkcode' OR ";
			}
		$where=rtrim($where," OR ").")";
		}
	}

$sql="SELECT t4.region, t1.*, concat(t3.Fname,' ', t3.Lname) as name
FROM `position` as t1
LEFT JOIN emplist as t2 on t2.beacon_num=t1.beacon_num
LEFT JOIN empinfo as t3 on t2.tempID=t3.tempID
LEFT JOIN dpr_system.parkcode_names_region as t4 on t4.park_code=t1.park_reg
$where $order";  
// echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
$count=mysqli_num_rows($result);
if($count<1){echo "No positions found using $where";exit;}
while ($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
//$count=count($ARRAY);
//echo "<pre>"; print_r($ARRAY); echo "</pre>";
$skip=array("seid","posNum","rcc","park","fund","fund_source","current_salary","previous_salary","exempt","markDel","reason","posType","posMod","o_chart","toggle");

echo "<table border='1' cellpadding='3'><tr><th colspan='9'>$count Positions with beacon_title = $beacon_title</th></tr>";		
foreach($ARRAY as $index=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="beacon_num")
			{
			if(in_array(strtolower($test),$edit_position))
				{
				$value="<a href='edit_position.php?beacon_num=$value' target='_blank'>$value</a>";
				}
			}
		if($fld=="name")
			{
			if(empty($value)){$value="vacant";}
			$value="<a href='position_files.php?beacon_num=$array[beacon_num]' target='_blank'>$value</a>";
			}
		if($index==0)
			{
			if($fld=="salary_grade")
				{
				$fld="<a href='find_title.php?beacon_title=$beacon_title&sort=sg'>$fld</a>";
				}
			if($fld=="code")
				{
				$fld="<a href='find_title.php?beacon_title=$beacon_title&sort=code'>$fld</a>";
				}
			if($fld=="region")
				{
				$fld="<a href='find_title.php?beacon_title=$beacon_title&sort=region'>$fld</a>";
				}
			if($fld=="name")
				{
				$fld="<a href='find_title.php?beacon_title=$beacon_title&sort=name'>$fld</a>";
				}
			echo "<td valign='top'><b>$fld</b><br />$value</td>";
			}
		else
			{
			echo "<td>$value</td>";
			}
		}
	echo "</tr>";
	}
echo "</table><hr />";

$sql="SELECT * from position_desc_forms where beacon_title='$beacon_title'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while ($row=mysqli_fetch_assoc($result))
		{
		$uploads[$row['form_name']]=$row['file_link'];
		}



?>