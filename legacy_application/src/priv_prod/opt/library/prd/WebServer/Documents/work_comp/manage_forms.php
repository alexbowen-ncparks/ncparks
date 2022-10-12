<?php
ini_set('display_errors',1);
$database="work_comp";
include("../_base_top.php");

if($_SESSION['work_comp']['level'] <1)
	{
	echo "<br /><br />This application is still being developed."; exit;
	}
	
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

// Process Update
if(!empty($_POST))
	{
// echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
	if(!empty($_POST['form_name']))
		{
		foreach($_POST['form_name'] AS $id=>$value)
			{
			$sort_order=$_POST['sort_order'][$id]; 
			$form_name=$_POST['form_name'][$id];
			$clause="UPDATE link_to_find_db set ";
			$clause.="sort_order='".$sort_order."', form_name='".$form_name."'";
			$sql=$clause."where id='$id'";
// 		echo "<br />$sql"; exit;
				$result = mysqli_query($connection,$sql);
			}
			
		}
	echo "<font color='green'>Update completed.</font>";
	}

echo "<table align='center'><tr><th>
<h2><font color='purple'>NC DPR Worker Compensation Tracking Application</font></h2></th></tr></table>";


mysqli_select_db($connection, "find"); // database 

echo "<hr /><table align='center' cellpadding='5'><tr>
<td>
<table border='1'  align='center' cellpadding='5'><tr></tr>";

echo "<tr><th colspan='5'><h4><font color='blue'>Workers' Comp Forms</font></h4></th></tr></table>";

if(!empty($_POST['pull_from_FIND']))
	{
	
	$sql="SELECT * from map where 1 and forumID='511'";
	$result = mysqli_query($connection,$sql);
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_temp[]=$row;
		}

	// echo "<pre>"; print_r($ARRAY_temp); echo "</pre>";  exit;

	$add_array=array("mid","forumID","filename","link");
	mysqli_select_db($connection, $database); // database 
	$sql="TRUNCATE link_to_find_db";
// 	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql);
	foreach($ARRAY_temp AS $index=>$array)
		{
		unset($temp);
		foreach($array as $fld=>$val)
			{
			if(!in_array($fld,$add_array)){continue;}
			if(empty($val)){continue;}
			$val=mysqli_real_escape_string($connection, $val);
			$temp[]="$fld='$val'";
			}
		
	// 	echo "<pre>"; print_r($temp); echo "</pre>";  exit;
		$clause=implode(",",$temp);
		$sql="INSERT INTO link_to_find_db set $clause";
		$result = mysqli_query($connection,$sql) or die($sql ."<br />".mysqli_error($connection));
		}
	
	}


mysqli_select_db($connection, $database); // database 
$sql="SELECT * from link_to_find_db order by sort_order";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_forms[]=$row;
	}
$skip=array("id","mid");
$c=count($ARRAY_forms);
if($level>3)
	{
	echo "<form method='POST' action='manage_forms.php'>";
	}
// echo "<pre>"; print_r($ARRAY_forms); echo "</pre>"; // exit;
echo "<table><tr><td>$c forms</td></tr>";
foreach($ARRAY_forms AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY_forms[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		$display="<td>$value</td>";
		if($fld=="forumID")
			{
			$display="<td></td>";
			if($index==0)
				{
				$value="<a href='https://10.35.152.9/find/forum.php?forumID=$value&submit=Go' target='_blank'>$value</a>";
				$value="<a href='https://10.35.152.9/find/forum.php?forumID=$value&submit=Go' target='_blank'>$value</a>";
				$display="<td>$value</td>";
				}
			}
		if($fld=="sort_order")
			{
			$name=$fld."[".$array['id']."]";
			if(empty($value))
				{$value=$array['id'];}
			$display="<td><input type='text' name='$name' value=\"$value\" size='3'></td>";
			}
		if($fld=="link")
			{
			$value="https://10.35.152.9/find/".$value;
			$value="https://10.35.152.9/find/".$value;
			$display="<td><a href='$value' target='_blank'>Get&nbsp;file</a></td>";
			}
		if($fld=="form_name")
			{
			$name=$fld."[".$array['id']."]";
			if(empty($value))
				{
				$value=$array['filename'];
				}
			$display="<td><input type='text' name='$name' value=\"$value\" size='50'></td>";
			}
		echo "$display";
		}
	echo "</tr>";
	}
if($level>3)
	{
	echo "<tr>
	<td><input type='submit' name='submit_form' value=\"Update\"></td>
	</tr>";
	}
echo "</table>";

if($level>3)
	{
	echo "</form>";
	
	echo "<form method='POST' action='manage_forms.php'><table align='center'><tr>
	<td>
	<input type='hidden' name='pull_from_FIND' value=\"x\">
	<input type='submit' name='submit_form' value=\"Replace All Forms\" style='color:red' onclick=\"return confirm('Are you sure you want to replace this set of forms with those uploaded to the FIND?')\">
	</td>
	</tr>
	<tr><td>Clicking this will link to the forms stored in the FIND #511</td></tr>
	<tr><td>Before replacing the forms, make a screenshot so that you know the order and form names.</td></tr>
	<tr><td>If forms change, click on the 511 link in upper left. Make changes there. Then come back here and replace.</td></tr>
	<tr><td>After changing the forms you will need to order them correctly and give them a form name.</td></tr>
	";
echo "</table>";
	}

	
?>
