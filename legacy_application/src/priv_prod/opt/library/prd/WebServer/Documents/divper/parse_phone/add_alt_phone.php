<?php 
	
$database="divper";
include("../../../include/connectROOT.inc"); //echo "c=$connection";

extract($_REQUEST);
if($park=="")
	{
	$sql="SELECT park_codes
		FROM phone_bill.phone_bill as t1
		where 1 limit 1"; //echo "$sql";
		 $result = MYSQL_QUERY($sql,$connection);
		$row=mysql_fetch_assoc($result);
		$park_array=explode(",",$row['park_codes']);
	echo "<form action='add_alt_phone.php' method='POST'>
	<table align='center' cellpadding='7'>

	<tr><td>Pick a Park: 
	<select name='park'><option selected=''></option>";
	
	foreach($park_array as $k=>$v)
		{
		echo "<option value='$v'>$v</option>";
		}
	
	echo "</select></td></tr>
	
	<tr><td><input type='submit' name='submit' value='Submit'></td></tr>
	</table></form>";
	exit;
	}
	
if($_POST['alt_lines']!="")
	{
	if($_POST['location']=="" OR $_POST['park']=="" )
		{
		echo "You did not specify a BOTH  a park and a location. Click your browser's back button";exit;
		}
		
	//	echo "<pre>";print_r($_POST);echo "</pre>";
		
		$alt_lines=$_POST['alt_lines'];
		$park=$_POST['park'];
		$location=$park." ".$_POST['location'];
		
		$sql="INSERT INTO phone_bill.alt_lines 
		set alt_lines='$alt_lines', location='$location'"; //echo "$sql";
		//exit;
		 $result = MYSQL_QUERY($sql,$connection);
	
		header("Location: /divper/parse_phone/add_alt_phone.php?park=$park");
		exit;
	}
	
$sql="SELECT *
	FROM phone_bill.alt_lines as t1
	where location like '%$park%'"; //echo "$sql";
	 $result = MYSQL_QUERY($sql,$connection);
	 echo "Existing $park alternate phone numbers and Use.<br /><br />";
	while($row=mysql_fetch_assoc($result))
		{
		extract($row);
		echo "$alt_lines => $location<br />";
		}
		
		
$sql="SELECT park_codes
	FROM phone_bill.phone_bill as t1
	where 1 limit 1"; //echo "$sql";
	 $result = MYSQL_QUERY($sql,$connection);
	$row=mysql_fetch_assoc($result);
	$park_array=explode(",",$row['park_codes']);
		
echo "<form action='add_alt_phone.php' method='POST'><table align='center' cellpadding='7'>

<tr><td align='right'>This number is assigned to BOTH a <font color='blue'>park</font> AND a <font color='red'>use</font>. It is NOT assigned to a person.</td></tr>

<tr><td>Park: 
<select name='park'><option selected=''></option>";

foreach($park_array as $k=>$v)
	{
	if($park==$v){$s="selected";}else{$s="value";}
	echo "<option $s='$v'>$v</option>";
	}

echo "</select></td></tr>
<tr><td>Phone Number (nnn-nnn-nnnn format): 
<input type='text' name='alt_lines' value='' size='40'></td></tr>


<tr><td>Use at park (e.g., closing ranger, unassigned land line): <input type='text' name='location' value='' size='40'></td></tr>
<tr><td>
<input type='submit' name='submit' value='Submit'></td></tr>
</table></form>";

?>