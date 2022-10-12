<?php
session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
//These are placed outside of the webserver directory for security
$database="publications";   // use publications to authenticate
include("../../include/auth.inc"); // used to authenticate users
$level=$_SESSION['publications']['level'];

include("pm_menu.php");
include("../../include/iConnect.inc"); // database connection parameters
$database="publications"; 
mysqli_select_db($connection,$database);

if(@$tempLevel<2 AND $level <4){echo "You do not have access.";exit;}
//print_r($_POST);

if(@$submit=="Add"){
$sql="INSERT INTO `subunits` set parkcode='$passPark',subunit='$newSubunit';";
//echo "$sql";exit;
 $result = @mysqli_QUERY($connection,$sql);
}

if(@$id){
$sql="DELETE FROM `subunits` WHERE `id`='$id';";
 $result = @mysqli_QUERY($connection,$sql);
}

// ******** Enter your SELECT statement here **********
if(isset($passPark))
	{
	$sql="SELECT parkcode,subunit,id 
	FROM subunits
	where parkcode='$passPark'
	order by parkcode,subunit"; //echo "$sql";
	 $result = @mysqli_QUERY($connection,$sql) or die("Error 1: $sql".mysqli_error($connection));
	$num=mysqli_num_rows($result);
	}
//$numFields=count($allFields);
//$fieldNames=array_values(array_keys($ARRAY[0]));

echo "<html><table border='1' cellpadding='2'><tr><td colspan='3' align='center'><font color='red'>Publication Inventory</font></td></tr>";

echo "<tr>";
echo "<td colspan='3' align='right'><form><select name=\"add_park\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Pick Park</option>";$s="value";
foreach($parkCode as $k=>$v)
	{
//	if(!in_array($v,@$trackPark) AND $v!="")
//		{
		echo "<option $s='/publications/modify.php?passPark=$v'>$v\n";
//		}
	}

echo "</form></td></tr>";

if(!@$passPark){exit;}

echo "<form>";
while($row=mysqli_fetch_array($result)){
extract($row);
$del="<a href='modify.php?id=$id&passPark=$passPark'>delete</a>";
echo "<tr><th>$parkcode</th><th>$subunit</th><th>$del</th></tr>";
}

echo "<tr><td>$passPark</td><td><input type='text' name='newSubunit' value='' size='35'></td></tr>";
echo "<tr>
<td><input type='hidden' name='passPark' value='$passPark'></td>
<td><input type='submit' name='submit' value='Add'> a publication Type.</td>
</tr>";

echo "</form></table>";


echo "<table>";

echo "</table></body></html>";

?>