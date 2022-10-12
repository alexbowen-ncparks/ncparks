<?php

echo "<td align='center'>
<form action='grants.php' method='POST'>
<input type='submit' name='submit' value='Grants'>
</form></td>";

echo "<td align='center'>
<form action='inspections.php' method='POST'>
<input type='submit' name='submit' value='Inspections'>
</form></td>";

if($level>3)
	{
	echo "<td align='center'>
	<form action='replace_data.php' method='POST'>
	<input type='submit' name='submit' value='Replace Data'>
	</form></td>";
	}
echo "</tr>";

?>