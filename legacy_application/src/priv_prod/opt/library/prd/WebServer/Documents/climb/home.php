<?php
ini_set('display_errors',1);
$database="climb";
include("../../include/auth.inc");

// include("../../include/iConnect.inc");
// 
// mysqli_select_db($connection,$database);

include("../_base_top.php");
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
echo "<style>
.head {
font-size: 22px;
color: #999900;
}
</style>";
echo "<div>";
echo "<table>";
echo "<tr><td class='head'>DPR Group Climbing Permits</td></tr>";
echo "<tr><td>You will be able to manage the Group Climbing Permits issued by the Division.</td></tr>";
echo "<tr><td>
<p>• To create a permit, click on the \"Issue Permit\" tab to the left.</p>

<p>• If you haven't already done so, it is a good idea to familiarize yourself with the Guideline for Group Climbing in NC State Parks.</p>


<p>• If you need a blank Permit Form, click on the Permit Form tab.</p>

</td></tr>";
echo "</table>";
echo "</div>";
?>