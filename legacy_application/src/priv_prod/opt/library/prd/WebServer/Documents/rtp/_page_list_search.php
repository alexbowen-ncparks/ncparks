<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="rtp"; 
$dbName="rtp";

include_once("_base_top.php");
//$pass_park_code=@$_SESSION[$database]['select'];

// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
include("../../include/iConnect.inc");

$sql="SELECT distinct t1.rts_cnty1
from city_county as t1
WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_region[]=$row['rts_cnty1'];
	}
// echo "<pre>"; print_r($ARRAY_region); echo "</pre>"; // exit;


$ARRAY_use=array("ohv_use","paddle_use","equine_use","hike_use","mtb_use");
	
	
echo "<style>
h3 {
font-size: 22px;
color: #999900;
}
 
.head {
font-size: 22px;
color: #999900;
}
.ui-datepicker {
  font-size: 80%;
}
</style>";

echo "<div>";
echo "<table>
<tr><td colspan='5'><h3>Search Projects</h3></td></tr>
<tr>
<th>Region:<form method='POST' action='search_action.php'>";
foreach($ARRAY_region as $index=>$value)
	{
	echo "<input type='radio' name='region' value=\"$value\" onclick=\"this.form.submit()\">$value";
	}
echo "</form></th>";
echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;| &nbsp;&nbsp;</td>";
echo "<th>Use:<form method='POST'>";
foreach($ARRAY_use as $index=>$value)
	{
	echo "<input type='radio' name='use' value=\"$value\" onclick=\"this.form.submit()\">$value";
	}
echo "</form></th>
</tr>";
if(empty($var))
	{echo "<tr><th colspan='10'>Select an item to view.</th></tr>";}

echo "</table>";
echo "</div>";



?>