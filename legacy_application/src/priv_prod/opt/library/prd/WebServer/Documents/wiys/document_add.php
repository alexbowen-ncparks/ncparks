<?php
extract($_REQUEST);

$park_code=htmlentities($park_code);
echo "<html>";
echo "<head> <title>document_add</title></head>";
echo "<body>";
echo "<h3><font color='blue'>Park Code: $park_code</font></h3>";
echo "<h3><font color='red'>Please upload the CURRENT work schedule.</font></h2>";

echo "<form enctype='multipart/form-data' method='post' action='document_add2.php'>";
echo "<input type='hidden' name='MAX_FILE_SIZE' value='20000000'>";
echo "<input type='file' id='document' name='document'>";
echo "<input type='hidden' name='park_code' value='$park_code'>";
echo "<br /> <br />";
echo "<input type='submit' name='schedule' value='Upload'>";
echo "</form>";
echo "</body>";
echo "</html>";

?>