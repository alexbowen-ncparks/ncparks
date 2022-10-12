<?php
ini_set('display_errors',1);
$database="dpr_land";
include("../../include/auth.inc");
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
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
echo "<tr><td class='head'>Welcome to the DPR Land website.</td></tr>";
echo "<tr><td>Introductory text can go here.</td></tr>";

echo "<tr><td></td>";
include("renew_lease.php");
echo "</tr>";
echo "</table>";
echo "</div>";
?>