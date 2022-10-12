<?php

$database="divper";
include("../../include/iConnect.inc"); 
include("../../include/get_parkcodes_reg.php");
mysqli_select_db($connection,'divper'); // database

// extract($_REQUEST);

include("menu.php");
$level=$_SESSION['divper']['level'];

//print_r($_POST);
//print_r($_REQUEST);exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";

// ************ Process input
@$val = strpos($submit, "Update");
if($val > -1){  // strpos returns 0 if Update starts as first character

$database="rates";
extract($_POST);
extract($_REQUEST);

$feeVal1=$feeVal;

while (list($key, $val) = each($feeVal)) {
$query="UPDATE rates SET fee='$val' where id='$key'";
//echo "$query <br><br>";//exit;
$result = mysqli_query($connection,$query);

}// end while



// *********  Also Update table on UNC for use by the website ******
include ("../../include/connectUNC.inc");
//echo "un=$connection";exit;
//print_r($park_use1);//exit;

while (list($key, $val) = each($feeVal1))
	{
	$query="UPDATE rates SET fee='$val' where id='$key'";
	$result = mysqli_query($connection,$query);
	
	}// end while

header("Location: /divper/fac_rates.php");
exit;
} // end Update

//  ************Start input form*************
$file="fac_rates.php";
$fileMenu="../menu.php";

extract($_REQUEST);
@$passPark=$parkcode;

extract($_REQUEST);

//print_r($listArray);//exit;
// Get appropriate Fields for the Park
$sql = "SELECT * from `rates` 
where 1
order by `name`,`type`, `fee`";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");

while ($row=mysqli_fetch_array($result))
	{
	$nameArray[]=$row['name'];
	$typeArray[]=$row['type']; 
	$feeArray[]=$row['fee'];
	$idArray[]=$row['id'];
	}


echo "<div align='center'><form method='POST'><table>";
echo "<tr><th>Division of Parks and Recreation</th></tr>
<tr><th>List of Fees.</th></tr>";

echo "</table>";


echo "<table border='1'>";
echo "<tr><th>Facility</th><th align='right'>Fee</th><th>Type</th></tr>";

for($z=0;$z<count($idArray);$z++){

echo "<tr><td>$nameArray[$z]</td>";

$idPass=$idArray[$z];
echo "<td align='right'><input type='text' name='feeVal[$idPass]' value='$feeArray[$z]' size='5'></td>";

echo "</td><td width='500'>$typeArray[$z]</td></tr>";
}// end while

echo "</table>";

echo "<table><tr><td>
<input type='submit' name='submit' value='Update'></td></tr>";
echo "</form></table></div></body></html>";

?>