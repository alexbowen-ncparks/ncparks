<?php
ini_set('display_errors',1);
$database="dpr_tests";
include("../../include/auth_i.inc");
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
include("../../include/iConnect.inc");

mysqli_select_db($connection,$database);

include("_base_top.php");
echo "<style>
.head {
font-size: 22px;
color: #999900;
}
</style>";
echo "<div>";
echo "<table>";
echo "<tr><td class='head'>Welcome to the DPR Testing website.</td></tr>";
echo "<tr><td><p><font color='#99cc00' size='+1'>DPR Testing Website</font></p>
<p>You may utilize any references made available during course presentation to answer the questions.</p>
<p>Once started you will need to <b>complete the entire test or it will not be accepted</b>. You cannot come back to it once you leave it. If you are not positive you have the time to complete the test, please do not start. It is estimated to take around 30 minutes to complete.
</p>
</td></tr>";
echo "<tr><td></td></tr>";
echo "</table>";
echo "</div>";
?>