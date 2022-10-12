<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
$database="retail";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc");// database connection parameters
include("../../include/get_parkcodes_i.php");
$database="retail";
mysqli_select_db($connection,$database);

include("/opt/library/prd/WebServer/Documents/_base_top.php");


extract($_REQUEST);

if($submit=="Delete")
	{
	$sql="DELETE from retail_images where id='$id'";
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	ECHO "Photo has been deleted. You may now close this window."; exit;
	}

if($submit=="Update")
	{
	$comments=$comments;
	$sql="UPDATE retail_images 
	set comments='$comments'
	where id='$id'";
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	}

$sql="SELECT * from retail_images where id='$id'";
$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}

$skip=array("id","retail_id","parkcode","imagesize");
echo "<form action='edit_photo.php' method='POST'>";

echo "<table>";
foreach($ARRAY AS $index=>$array)
	{
	
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="link")
			{
			$var_tn=explode("/",$value);
					$tn="ztn.".array_pop($var_tn);
					$tn=implode("/",$var_tn)."/".$tn;
					$value="<img src='$tn'>"; $fld="";
			}
		if($fld=="comments"){$value="<textarea name='$fld' rows='2' cols='88'>$value</textarea>";}
		echo "<tr><td>$fld</td><td>$value</td></tr>";
		}
	echo "<tr>
	<td align='center'><input type='hidden' name='id' value='$id'>
	<input type='submit' name='submit' value='Update'></form></td>
	<td align='right'><form action='edit_photo.php' method='POST' onclick=\"return confirm('Are you sure you want to delete this Photo?')\">
	<input type='hidden' name='id' value='$id'>
	<input type='submit' name='submit' value='Delete'></form>
	</td></tr>";
	}
echo "<tr><td colspan='2' align='center'>Close tab/window when done.</td></tr></table></form>";
	

?>