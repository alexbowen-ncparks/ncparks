<?php
ini_set('display_errors',1);
$database="dpr_tests";
include("../../include/auth_i.inc");

$database="dpr_tests"; 
$dbName="dpr_tests";
include("_base_top.php");


ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);

$sql="INSERT into scores (`test_id`, `tempID`, `question_order`,  `test_date`)
SELECT `test_id`, `tempID`, `question_order`,  `test_date`
from completed_tests 
where tempID='$tempID' and test_date='$test_date' and test_id='$test_id'
";
// echo "$sql"; exit;
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));


// include("_base_top.php");
// unset($_SESSION[$database]);
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;


echo "<style>
.head {
font-size: 22px;
color: #999900;
}
</style>";
echo "<div>";
echo "<table>";
echo "<tr><td class='head'>The DPR Testing website.</td></tr>";
echo "<tr><td><p><font color='#99cc00' size='+1'>You have successfully completed the test.</p></font></p></td></tr>";
echo "</table>";
echo "</div>";
?>