<?php
ini_set('display_errors',1);
$database="lo_fo";
include("../../include/auth.inc");

include("../../include/iConnect.inc");

mysqli_select_db($connection,$database);

include("../_base_top.php");
echo "<style>
.head {
font-size: 22px;
color: #999900;
}
</style>";
echo "<div>";
echo "<table>";
echo "<tr><td class='head'>Welcome to the DPR Photo Archive.</td></tr>";
echo "<tr><td>Information on the purpose and use of this site can go here.</td></tr>";
echo "<tr><td></td></tr>";

echo "</table>";
echo "</div>";
?>