<html><head><title>NC DPR Remembering The Past</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><?phpecho "<STYLE TYPE=\"text/css\"><!--body{font-family:sans-serif;background:beige}td{font-size:90%;background:beige; text-align: center}th{font-size:90%; vertical-align: bottom}--> </STYLE>";?></head><div align="center">NC DPR Celebrates The Past<table border="1" cellpadding="5"><tr><td align="center">Honoring those that came before...</font></td><td align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><a href="search.php">Search</a></font></td><td><font face="Verdana, Arial, Helvetica, sans-serif"><a href="av.php">Add to Collection</a></font></td>   <!--<td><font face="Verdana, Arial, Helvetica, sans-serif" color="green"><a href="admin.php">Admin</a></font></td>--><td><font face="Verdana, Arial, Helvetica, sans-serif" color="green"><a href="logout.php">Logout</a></font></td><td>...through pictures, words and sounds.</td></tr></table><hr><img src="logoTrans.png" width="640"></div><?phpecho "<table><tr><td>Added in the past 7 days:</td></tr>";include("../../include/connectIRECALL.inc");$week = date("Ymd", mktime(0,0,0, date(m), date(d)-7,date(Y)));  $sql = "SELECT count(pid) as num FROM photos where dateM>'$week'";$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());$row=mysql_fetch_array($result);extract($row);if($num==1){$p="photo";}else{$p="photos";}echo "<tr><td align='right'>$num $p</td></tr>";  $sql = "SELECT count(stid) as sto FROM story where date>'$week'";$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());$row=mysql_fetch_array($result);if($sto==1){$s="story";}else{$s="stories";}extract($row);echo "<tr><td align='right'>$sto $s</td></tr></table></body></html>";?>