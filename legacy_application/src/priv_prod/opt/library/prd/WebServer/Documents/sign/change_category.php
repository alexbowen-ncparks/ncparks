<?php
$database="sign";
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

date_default_timezone_set('America/New_York');
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  //exit;

extract($_REQUEST);

$sql = "SELECT * FROM category
	WHERE 1"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));		
	while($row_cat=mysqli_fetch_assoc($result))
		{
		$name_cat[$row_cat['id']]=$row_cat['name'];
		}
$sql = "SELECT * FROM standard
	WHERE 1 order by sign_title"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));		
	while($row_stan=mysqli_fetch_assoc($result))
		{
		$st="standard_".$row_stan['id'];
		$standard[$st]="3.".$row_stan['sign_title'];
		}
$cat_array=$name_cat + $standard;
//echo "<pre>"; print_r($cat_array); echo "</pre>"; // exit;

	
if(!empty($submit))
{
$sql = "UPDATE sign_list_1
	SET category='$category'
		WHERE id='$id'"; 
		
	//	echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
$strpos=$category[0];
$page="edit_".$strpos.".php?edit=".$id."&submit=edit";
//echo "<br /><br />$page";exit;
header("Location: $page");
exit;
}


if(!empty($id))
	{

	$sql = "SELECT * FROM sign_list_1
		WHERE id='$id'"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql c=$connection");
		$row=mysqli_fetch_assoc($result);
			
include("menu.php");
//echo "<pre>"; print_r($name_cat); echo "</pre>"; // exit;
if($level<4){exit;}

$cat=$row['category'];
$name=$name_cat[$cat];
echo "<table><tr>
<td colspan='2'>Form to change a Sign Request Category<br />
<font color='green'>from [$cat - $name]</font><br />
to<br />
<form><select name='category' action='category.php'>";
foreach($name_cat as $fld=>$value)
	{
	if($fld==3)
		{
		foreach($standard as $k1=>$v1)
			{		
			if($v1==$cat){$s="selected";}else{$s="value";}
			echo "<option $s='$v1'>$k1 $v1</option>";
			}
		continue;
		}
	if($fld==$cat){$s="selected";}else{$s="value";}
	echo "<option $s='$fld'>$fld $value</option>";
	}
echo "</select>
<input type='hidden' name='id' value='$id'>
<input type='submit' name='submit' value='Change'>
</form></td>
 </tr>";

$show=array("dpr","status","purpose","comments","location","new_replace","outside_vendor_details","response","email");
	
	foreach($row as $fld=>$value)
		{
		if(!in_array($fld,$show)){continue;}
		echo "<tr><td>$fld</td><td>$value</td></tr>";
		}
echo "</table></body></html>";
	}

?>