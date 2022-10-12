<?php
ini_set('display_errors',1);
$database="hr";
include("../../include/auth.inc"); // database connection parameters

include("../../include/connectROOT.inc"); // database connection parameters
mysql_select_db($database,$connection);

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
extract($_REQUEST);

if(@$submit=="Update")
	{
	foreach($_POST as $k=>$v)
		{
		if($k!="submit"){
		if($k=="Fname"){$v=ucfirst($v);}
		if($k=="M_initial"){$v=ucfirst($v);}
		@$string.="$k='".$v."', ";
		}
	}
//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	$string=rtrim($string,", ");
	
	$query="UPDATE sea_employee SET $string WHERE id='$id'";
		//echo "$query";exit;
			$result = mysql_query($query) or die ("Couldn't execute query Update. $query");
			header("Location: new_hire.php?Lname=$Lname&submit=Find");
			
		exit;
	}

//session_start();
$level=$_SESSION['hr']['level'];
if($level<1){exit;}

if(@$del=="y")
	{
	// First check to make sure no process number issued
	$sql="SELECT tempID, beacon_num, process_num FROM employ_position WHERE id='$id'";
	$result = @MYSQL_QUERY($sql,$connection);
	$row=mysql_fetch_array($result);
	extract($row);
	if($process_num!="" AND $level<3)
		{
		echo "Once a process_num has been issued you will not be able to remove the person from this position.<br /><br />Please submit a separation request for this employee to remove them from the position. Contact your HR Rep and request removal of $tempID from BEACON position number $beacon_num.";exit;
		}
	
	$query="DELETE FROM employ_position WHERE id='$id'";
		//echo "$query";exit;
			$result = mysql_query($query) or die ("Couldn't execute query Update. $query");
	if(!isset($Lname)){$Lname="";}
		header("Location: new_hire.php?Lname=$Lname&submit=Find");
			
		exit;
	}


if(@$submit=="Remove")
	{
	$query="DELETE FROM sea_employee WHERE id='$id'";
		//echo "$query";exit;
			$result = mysql_query($query) or die ("Couldn't execute query Update. $query");
		header("Location: new_hire.php?Lname=$Lname&submit=Find");
			
		exit;
	}

include("../css/TDnull.php");

echo "<html><head></head><body>";
echo "<form method='POST'><table align='center' border='1' cellpadding='5'>";

$edit=array("Fname","M_initial","driver_license","beaconID","e_verify","track");
//if($level>2){$edit[]="e_verify";}
$passVar=array("tempID","beacon_num");

$sql="Select t1.*, t2.beacon_num
From `sea_employee` as t1
LEFT JOIN employ_position as t2 on t2.tempID=t1.tempID
where t1.id='$id'";
 $result = @MYSQL_QUERY($sql,$connection);
		// echo "$sql";
$row=mysql_fetch_assoc($result); 
foreach($row as $k=>$v)
	{
	if(in_array($k,$passVar)){@${$k};}
	if(in_array($k,$edit))
		{
		$ro="";
		if($k=="track")
			{
			$v=$_SESSION['logname'];
			$ro="readonly";
			}
		$v="<input type='text' name='$k' value='$v' $ro>";
		}
	echo "<tr><td align='right'>$k</td><td>$v</td></tr>";
	}
	
echo "<tr><td align='right'>Personal Info =></td><td align='center'>
<input type='hidden' name='Lname' value=\"$Lname\">
<input type='hidden' name='id' value='$id'>
";
echo "<input type='submit' name='submit' value='Update'></td></tr></form>";


if($row['beacon_num']=="")
	{
	echo "<form><tr><td>
	<input type='hidden' name='Lname' value='$Lname'>
	<input type='hidden' name='id' value='$id'>";
	echo "<input type='submit' name='submit' value='Remove'> Completely remove person.</td></tr>";
	}
	else
	{
	if(!isset($tempID)){$tempID="";}
	if(!isset($beacon_num)){$beacon_num="";}
	echo "<tr><td colspan='2'>To delete this person, you must first <a href='new_hire.php?id=$id&tempID=$tempID&beacon_num=$beacon_num&submit=Find'>remove</a> them from the BEACON position listed above.</td></tr>";
	}

echo "</table></form></body></html>";
?>
