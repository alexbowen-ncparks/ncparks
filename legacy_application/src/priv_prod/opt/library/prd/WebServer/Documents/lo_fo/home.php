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
echo "<tr><td class='head'>Welcome to the DPR Lost and Found website.</td></tr>";
echo "<tr><td>You will be able to log all items which have been found at your park and track their disposition.</td></tr>";
echo "<tr><td>To add an item, click on the \"Add Item\" tab to the left.</td></tr>";
echo "<tr><td></td></tr>";
echo "<tr><td>If you haven't already done so, it is a good idea to familiarize yourself with the Policy Statement for dealing with lost and found items (click tab to the left).</td></tr>";
echo "</table>";
echo "</div>";
?>