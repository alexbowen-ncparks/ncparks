<?php
//These are placed outside of the webserver directory for security

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

include("../../../include/authBUDGET.inc"); // used to authenticate users
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");

extract($_REQUEST);
$sql = "select vendor_short_name as 'vendor',first_line_item_description as 'purchase_description',po_number,po_line_number as 'po_line',sum(po_remaining_encumbrance) as 'unpaid_amount'
from xtnd_po_encumbrances
where 1
and center='$center'
and acct='$acct'
group by center,acct,po_number,po_line_number;
";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
session_start();

if($_SESSION[budget][level]>4){echo "$sql<br />";}

echo "<html><body><table border='1'>";

echo "<tr><th>Vendor</th><th>Purchase_description</th><th>po_number</th><th>po_line</th><th>unpaid_amount</th></tr>";

while ($row=mysqli_fetch_array($result))
{extract($row);
$totUA+=$unpaid_amount;
echo "<tr><td>$vendor</td><td>$purchase_description</td><td>$po_number</td><td>$po_line</td><td align='right'>$unpaid_amount</td></tr>";
}// end while
$totUA=number_format($totUA,2);
echo "<tr><td colspan='5' align='right'>$totUA</td></tr>";
echo "</table></body></html>";

?>