<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users

$test=$_SESSION['logname'];

$committee=array("Howard6319","Mitchener8455","Allcox9961","Oneal1133","Quinn0398","Jackson5451","Bunn8227","Nygard9727","Cucurullo6876","Williams5894","Lambert2172","McNair0846","Dowdy5456");

if(!in_array($test,$committee)){echo "You do not have access to this file."; exit;}

include("../../include/iConnect.inc"); 
mysqli_select_db($connection,'divper'); // database


extract($_REQUEST);

if(@$submit=="Update")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;
	foreach($_POST['title_grade'] as $index=>$value)
		{
		$tg=$_POST[title_grade][$index];
		$bt=$_POST[beacon_title][$index];
		$sql="REPLACE position_desc_assoc 
		set title_grade='$tg',
		beacon_title='$bt'
		";
		//echo "$sql<br />";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		}
//	exit;
	echo "<font color='green'><b>Update completed.</b></font>";
	}
include("menu.php"); 

$level=$_SESSION['divper']['level'];
$ckPosition=strtolower($_SESSION['position']);

$sql="SELECT * from position_desc_assoc where 1";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}


echo "<form action='position_add_template.php' method='POST'>";
echo "<table border='1' cellpadding='5'>";

echo "<tr><td colspan='4'>This is used to add a position the Template table. These records determine which base position description files get uploaded.</td></tr>";
echo "<tr><td>id</td><td>Title Grade</td><td>BEACON Title</td></tr>";
foreach($ARRAY as $index=>$array)
	{
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		$fld=$fld."[]";
		echo "<td><input type='text' name='$fld' value='$value' size='40'>";	
		echo "</td>";
		}
	echo "</tr>";
	}

echo "<tr>
<td>Add new title: </td>
<td><input type='text' name='title_grade[]' value='' size='40'></td>
<td><input type='text' name='beacon_title[]' value='' size='40'></td></tr>";	
echo "<tr><td colspan='8' align='center'>
<input type='submit' name='submit' value='Update'>
</td></tr>";
echo "</table></form>";

?>