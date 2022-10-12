<?php
echo "<table>
<tr><td align=\"center\"></td></tr>
<tr><td align=\"center\">
  <a href=\"/$database/vendors.php\">Vendor Info</a>
  <a href=\"/$database/items.php\">Items for Sale</a>
  <a href=\"/$database/form.php\">Retail Outlets</a>";
  
  if($level>4)
	{
	echo "<a href=\"/$database/admin.php?source=photos\">Admin Functions</a>";
	}
echo "</td></tr>
</table>";

?>