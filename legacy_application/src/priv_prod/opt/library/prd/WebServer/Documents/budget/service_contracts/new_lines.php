<?php
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

echo "<pre>";print_r($_REQUEST);"</pre>";//exit;



echo "<table>";
echo "<form action='new_lines.php' name='new_lines'>";
for($j=0;$j<5;$j++)
{
echo "<tr><th><font color='brown'>PO Number</font></th><td><input name='po_num[]' type='text' size='25' value='$po_num' id='po_num'></td>";
	   
}
echo "<tr><td colspan='1' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "</table>";
?>