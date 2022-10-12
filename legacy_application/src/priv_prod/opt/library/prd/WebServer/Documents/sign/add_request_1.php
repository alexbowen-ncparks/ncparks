<?php
date_default_timezone_set('America/New_York');

$database="sign";
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
session_start();    
//echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  exit;
//echo "<pre>";print_r($_FILES); echo "</pre>";  //exit;
//echo "<pre>";print_r($_SESSION); echo "</pre>";  //exit;

if($_POST)
	{
$db = mysqli_select_db($connection,"divper")
       or die ("Couldn't select database $database");
$tempID=$_SESSION['sign']['tempID'];
$park_code=$_SESSION['sign']['select'];
$sql = "SELECT email, phone as phone1, work_cell FROM empinfo
	WHERE tempID='$tempID'
	";  //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	$row=mysqli_fetch_assoc($result);
extract($row);
$phone=$phone1." ".@$work_cel;

$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
//echo "<pre>";print_r($_POST); echo "</pre>";  //exit;
extract($_POST);
	if($category=="1" AND $cr_form=="")
		{
		include("menu.php");
		echo "You cannot request a Park Entrance Sign without first obtaining a Construction Renovation permit.";exit;
		}
	if($category=="")
		{
		include("menu.php");
		echo "<font color='red'>You CANNOT submit a request without specifing a Category. Click your browser's back button.</font>";exit;
		}
	$sql = "SELECT dpr FROM sign_list_1
	WHERE 1 order by id desc limit 1
	";  //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	$row=mysqli_fetch_assoc($result);
	$value=$row['dpr'];
		if($value==""){$value="000";}
		
		$pad=str_pad((substr($value,-3)+1),4,0,STR_PAD_LEFT); 
		$test=substr($value,-3);
//		echo "v=$value t=$test p=$pad<br />"; //exit;
		if($pad=="0000"){$pad="0001";}
		$value="SR_".date('Y')."_";
		$value.=$pad;
		// A workaround because the numbering system failed to rollover to 001 when going from
		// 2012 to 2013   Will try to correct on rollover from 2013 to 2014
		if($value=="SR_2013_1000")
			{$value="SR_2013_1001";}
		
		$date=date('Y-m-d');
		if($category==1){$sign_type="Road-side";}
		if(!isset($cr_form)){$cr_form="";}
		if(!isset($cat1)){$cat1="";}
	if(!isset($sign_type)){$sign_type="";}
	$sql = "INSERT INTO sign_list_1 set dpr='$value', date_of_request='$date', category='$category', cr_form='$cr_form', sign_type='$sign_type', phone='$phone', email='$email', location='$park_code'";
//	echo "$sql"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql  ".mysqli_error($connection));
				$id=mysqli_insert_id($connection);
			
			if($category[0]==3)
				{
				$var=explode("3.",$category); 
				$category=3;
				$cat1="&category=".$var[1];
				}
			$file="edit_".$category.".php";
//exit;				
		header("Location: $file?id=$id$cat1");
	}
 
include("menu.php");

	$sql = "SELECT * FROM category as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No categories have been entered."; exit;}
		while($row=mysqli_fetch_assoc($result))
		{
		$category_array[$row['name']]=$row['id'];
		}
//	print_r($category_array);
$flip=array_flip($category_array);

$sql = "SELECT * FROM standard as t1 
	WHERE  1 order by sign_title";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No categories have been entered."; exit;}
		while($row=mysqli_fetch_assoc($result))
		{
		if($row['sign_title']=="*See TEXT description below "){continue;}
		if($row['sign_title']=="DUPLICATE SIGN" AND $level<4){continue;}
		$standard_sign_array[$row['sign_title']]=strtoupper($row['sign_title']);
		}
		
echo "<form action='add_request_1.php' method='POST'>
<table border='1' cellpadding='3'>
<tr><td colspan='2' valign='top'><h3><font color='purple'>Step 1 - Pick the Type of Sign</font></h3></td></tr>

<tr><td colspan='2' valign='top'><font color='blue'>A.</font> <input type='radio' name='category' value='1'>$flip[1]<br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' name='cr_form' value='x'><font color='brown'> I have obtained a Construction Renovation permit for the Park Entrance Sign.</font></td>
</tr>

<tr>
<td colspan='2' valign='top'><font color='blue'>B.</font> <input type='radio' name='category' value='2'>$flip[2]</td>
</tr>

<tr><td><font color='blue'>C.</font> $flip[3]</td>
<td><table>";
foreach($standard_sign_array as $k=>$v)
	{
	echo "<tr><td><input type='radio' name='category' value='3.$v'>$v</td></tr>";
	}
echo "</table></td>
</tr>

<tr><td><font color='blue'>D.</font> $flip[5]<br />(DISU approval Required)</td>
<td><input type='radio' name='category' value='5'>$flip[5]</td>
</tr>


<tr><td colspan='2' valign='top' align='center'><input type='submit' name='submit' value='Submit'></td>
</tr>
</table></form></body></html>";
?>