<?php

date_default_timezone_set('America/New_York');
$database="dpr_land"; 
$dbName="dpr_land";

include("../_base_top.php");
echo "<style>
.head {
font-size: 22px;
color: #999900;
}
</style>";
$pass_park_code=@$_SESSION[$database]['select'];

include("../../include/get_parkcodes_dist.php");// include iConnect.inc with includes no_inject.php

mysqli_select_db($connection,$dbName);
if(@$_POST["submit_form"]=="Submit")
	{
	$sql = "SELECT land_leases_id, complexname from $target_table";
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
// 		$var=str_replace("PRKS ", "", $row['complexname']);
// 		$var=str_replace("PRKS-", "", $var);
// 		$var=str_replace("-LEASED", "", $var);
// 		$var=str_replace(" - LEASED", "", $var);
// 		$var=str_replace("LEASED", "", $var);
// 		$var=str_replace("DNCR - ", "", $var);
// 		$var=str_replace("DNCR ", "", $var);
// 		$var=str_replace("WRC ", "", $var);
		
		$ARRAY[$row['land_leases_id']]=$row['complexname'];
		
// 		if(in_array($var, $parkCodeName))
// 			{
// 			$key=array_search($var, $parkCodeName);
// 			echo "k=$key $var<br />";
// 			}
		}
	echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
	}


echo "<pre>"; print_r($parkCodeName); echo "</pre>"; // exit;
echo "<div>";
echo "<table>";
echo "<tr><td class='head'>Welcome to the DPR Land website.</td></tr>";
echo "<tr><td>Form to add the 4 char park code to table containing just the park name.</td></tr>";

echo "<tr><td>
<form method='post' action='park_code_populate.php'>
<tr>
<td>Target table: <input type='text' name='target_table' value=\"\"></td>

</tr>
<tr><td><input type='submit' name='submit_form' value=\"Submit\"></td></tr>
</form>
</td>";

echo "</tr>";
echo "</table>";
echo "</div>";


?>