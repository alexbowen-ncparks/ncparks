<?phpinclude("../../include/authSYSEXP.inc");include("../../include/connectSYSEXP.inc");if($t=="c"){$db="ownerCP";$x="Current";}else{$db="ownerPP";$x="Potential";}$sql = "SELECT * FROM $db";$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());  // echo "$sql"; exit;  $result = mysql_query($sql)               or die("Couldn't execute query 1.");echo "<html><head><title>Edit Unit</title></head>        <head><title>Owner Codes</title></head>        <body>List of $x Owner Codes:<br>";while ($row = mysql_fetch_array($result)){extract($row);echo "$current - $fullName<br>";}echo "</body></html>";?> 