<?php
include("menu.php");
$max_no_file=1;  // Maximum number of files value to be set here
echo "<form method='POST' action='addPhoneTXT_file.php' enctype='multipart/form-data'>";
echo "<table border='0' width='400' cellspacing='0' cellpadding='0' align=center>";
$year=date('Y');
$month=date('M', mktime(0, 0, 0, date('m')-1, 1, $year));
echo "<tr><td>Year of Bill: <input type='text' name='year' value='$year'></td></tr>";
echo "<tr><td>3-letter month of bill: <input type='text' name='month' value='$month'></td></tr>";

for($i=1; $i<=$max_no_file; $i++)
	{
	echo "<tr><td>Upload File $i</td><td>
		<input type='file' name='files[]' class='bginput'></td></tr>";
	}
echo "<tr><td colspan=2 align=center><input type=submit value='Add Phone Log'></td></tr>"; 

echo "</form> </table>";

?>

</body>

</html>
