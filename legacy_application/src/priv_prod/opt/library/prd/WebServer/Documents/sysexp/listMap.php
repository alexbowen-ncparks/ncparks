<?phpextract($_GET);// called from edit.php//include("../../include/authSYSEXP.inc");include("../../include/connectROOT.inc");mysql_select_db($database, $connection); // database mysql_select_db("sysexp", $connection); // database $sql = "SELECT * FROM map WHERE sid = '$sid'";$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());echo "<html><head><title></title></head><body><table border='1' cellpadding='3'>";while ($row = mysql_fetch_array($result)){extract($row);if($link){$showMap="<a href='$link'>$mapname</a>";$delMap="<a href='delMap.php?del=y&mid=$mid'>Delete</a> this map.";}echo "<tr><td>Map: </td><td>$showMap</td><td>$delMap</td></tr>";}// end whileecho "</table><hr><a href='edit.php?sid=$sid&v=e'>Return</a></body></html>";?>