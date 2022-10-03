<?php
$database="photos";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
   or die ("Couldn't select database $database");

ini_set('display_errors',1);
include("../no_inject_i.php");

extract($_REQUEST);

if(empty($rep))
	{
	$title="DCR Archive";
	include("_base_top.php");
	}

if(!empty($_POST))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	extract($_POST);
	if(!empty($update))
		{
		$sql="UPDATE dcr_characteristics set `characteristic`='$characteristic' where id='$id'"; 
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
		echo "Update successful.";
		}
	if(!empty($submit))
		{
		$sql="INSERT INTO dcr_characteristics set `characteristic`='$characteristic'"; //echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
		echo "Addition successful.";
		$id="";
		}
	if(!empty($delete))
		{
		$sql="DELETE FROM dcr_characteristics where id='$id'"; 
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
		echo "Deletion successful.";
		$id="";
		}
	}
	
if(empty($rep))
	{
	//include("archive_menu.php");
	echo "<font color='magenta'>Close tab when done.</font>";
	}

if(!empty($id))
	{
	$sql="SELECT * from dcr_characteristics where id='$id'"; 
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	$row=mysqli_fetch_assoc($result); extract($row);
	echo "<form method='POST' action='archive_characteristics.php'><table>";
	echo "<tr><td>characteristic;</td></tr>";
	echo "<tr><td><textarea name='characteristic' cols='77' rows='1'>$characteristic</textarea></td></tr>";
	echo "<tr><td colspan='2' align='center'>
	<input type='hidden' name='id' value=\"$id\">
	<input type='submit' name='update' value=\"Update\">
	</td>
	<td><input type='submit' name='delete' value=\"Delete\"></td>
	</tr>";
	echo "</form>";
	exit;
	}

$sql="SELECT * FROM dcr_characteristics order by characteristic"; 
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
	

echo "<table>";
$default_array=array("characteristic","date","place","physical_characteristics","metadata_characteristic");
$text_array=array("title_","digital_characteristic","general_comments_by_dpr_team","maria,_program_manager_comment_column");
if(!empty($ARRAY))
	{
	$c=count($ARRAY);
echo "<form action='archive_characteristics.php' method='POST'>";
echo "<table><tr>";
echo "<td>characteristic<br /><input type='text' name='characteristic' value=\"\" size='55'></td>";
echo "</td>";
echo "
<td  align='center'><input type='submit' name='submit' value=\"Add\"></td>
</tr>";
echo "</table>";
echo "</form>";
echo "<table>";
	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if($fld=="id")
				{
				$value="[<a href='archive_characteristics.php?id=$value'> $value </a>]";
				}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
	}

echo "</table>";
?>