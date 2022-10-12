<?php

$database="divper";
include("../../include/iConnect.inc"); 
include("../../include/get_parkcodes_reg.php");
mysqli_select_db($connection,'divper'); // database

// extract($_REQUEST);

include("menu.php");
$level=$_SESSION['divper']['level'];
// extract($_REQUEST);

// ************ Process input
IF(@$del=="y")
	{
	$query="DELETE FROM `use` where id='$id'";
	$result = mysqli_query($connection,$query);
	
	// *********  Also Update table on UNC for use by the website ******
// 	include ("../../include/connectUNC.inc");
// 	$query="DELETE FROM `use` where id='$id'";
// 	$result = mysqli_query($connection,$query);
	header("Location: /divper/pub_use_cat.php");
	exit;
	}

@$val = strpos($submit, "Update");
if($val > -1){  // strpos returns 0 if Update starts as first character

$id1=$id;// necessary to replicate array for second Update
// the first while eliminates $id

//database="divper";
extract($_POST);

while (list($key, $val) = each($id))
	{
	$query="UPDATE `use` SET category='$category[$key]', subcategory='$subcategory[$key]', `name`='$name[$key]' where id='$id[$key]'";
	//echo "$query <br><br>";exit;
	$result = mysqli_query($connection,$query);
	
	}// end while



// *********  Also Update table on UNC for use by the website ******
include ("../../include/connectUNC.inc");

while (list($key, $val) = each($id1)) {
$query="UPDATE `use` SET category='$category[$key]', subcategory='$subcategory[$key]', `name`='$name[$key]' where id='$id[$key]'";
//echo "q=$query <br><br>";exit;
$result = mysqli_query($connection,$query);

}// end while

header("Location: /divper/pub_use_cat.php");
exit;
} // end Update

//  ************Start input form*************

$file="pub_use_cat.php";
$fileMenu="../menu.php";

@$passPark=$parkcode;


$level=$_SESSION['divper']['level'];
if($level==1){$parkcode=$_SESSION['divper']['select'];
$parkCode=array("","",$parkcode);}

if($level==2){
$distCode=$_SESSION['divper']['select'];
$menuList="array".$distCode; $parkCode=${$menuList};
sort($parkCode);
}

//print_r($parkCode);
// Workaround for ENRI and OCMO
if($_SESSION['divper']['select']=="ENRI"||$_SESSION['divper']['select']=="OCMO")
	{
	$parkCode=array("ENRI","OCMO");
	$parkcode=$passPark;
	}
// Workaround for MOJE and NERI
if($_SESSION['divper']['select']=="NERI"||$_SESSION['divper']['select']=="MOJE")
	{
	$parkCode=array("MOJE","NERI");
	$parkcode=$passPark;
	}


$sql = "SELECT `use`.*
FROM `use`
where 1
order by `use`.`category`,`use`.`subcategory`";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");

while ($row=mysqli_fetch_array($result))
	{
	$idArray[]=$row['id'];
	$catArray[]=$row['category'];
	$subcatArray[]=$row['subcategory'];
	$nameArray[]=$row['name'];
	}


echo "<div align='center'><form method='POST'><table>";
echo "<tr><th>Division of Parks and Recreation</th></tr>
<tr><th>List of Facilities/Amenities Categories and Subcategories.</th></tr>";

echo "</table>";

echo "<table border='1'>";
echo "<tr><td></td><th>Category</th><th>Subcategory</th><th>Name</th></tr>";

for($z=0;$z<count($nameArray);$z++){

echo "<tr><td><a href='pub_use_cat.php?del=y&id=$idArray[$z]' onClick='return confirmLink()'><img src='../button_drop.png'></a><input type='hidden' name='id[$z]' value='$idArray[$z]'></td>";


echo "<td  align='center'><input type='text' name='category[$z]' value='$catArray[$z]' size='25'></td>";

echo "<td align='center'><input type='text' name='subcategory[$z]' value='$subcatArray[$z]' size='55'></td>";

echo "<td align='center'><input type='text' name='name[$z]' value='$nameArray[$z]' size='25'></td></tr>";
}// end while

echo "</table>";

echo "<table><tr><td>
<input type='submit' name='submit' value='Update'></td></tr>";
echo "</form></table></div></body></html>";

?>