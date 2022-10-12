<?php
echo "<html>";
extract($_REQUEST);



//echo "<table border='1'>";
// echo "<form action='project_reports_matrix2.php'>";
echo "<table border='1'><tr><td>
<form method='POST' action='project_reports_matrix2.php'>
Maintenance History<br />for spo_number: <input type='text' name='spo_number' size='10'>
<input type='hidden' name='report' value='$report'>
<input type='submit' name='submit' value='Find'>
</form>
</td>
</tr>";
echo "</table>";


	
echo "</html>";
?>