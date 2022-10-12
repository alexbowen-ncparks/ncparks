<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users

$test=$_SESSION['logname'];

$committee=array("Howard6319","Mitchener8455","Oneal1133","Quinn0398","Bunn8227","Dowdy5456");

if(!in_array($test,$committee)){echo "You do not have access to this file."; exit;}

include("../../include/iConnect.inc"); 
mysqli_select_db($connection,'divper'); // database


extract($_REQUEST);

if(@$submit=="Update")
	{
	$sql="UPDATE target_positions set title='$new_title' where title='$title'";   //echo "<pre>"; print_r($_REQUEST); echo "</pre>";
//	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	echo "<font color='green'><b>Update completed.</b></font>";
	$beacon_title=$new_title;
	}
include("menu.php"); 

$level=$_SESSION['divper']['level'];
$ckPosition=strtolower($_SESSION['position']);

$sql="SELECT * from target_positions where title='$beacon_title'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_assoc($result);

if(mysqli_num_rows($result)<1){echo "$sql"; exit;}
$edit=array("title");

echo "<form action='position_edit_target.php' method='POST'>";
echo "<table border='1' cellpadding='5'>
<tr><td>This updates the target_positions table. This table contains the positions ID by CHOP in need of position descriptions. These must agree with the same \"beacon_title\" in the position table</td></tr>
<tr>";
foreach($row as $fld=>$value)
	{
	if(in_array($fld,$edit))
		{
		echo "<input type='text' name='new_title' value='$value' size='50'>";
		}
		else
		{
		echo "$value";
		}
	echo "</td>";
	}
echo "</tr>";

echo "<tr><td colspan='8' align='center'>
<input type='hidden' name='title' value='$beacon_title'>
<input type='submit' name='submit' value='Update'>
</td></tr>";
echo "</table></form>";

?>