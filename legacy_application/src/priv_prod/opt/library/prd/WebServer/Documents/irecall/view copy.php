<html><head><title>Faces & Places</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head><body bgcolor="#F5F1B1"><div align="center"><?php include("header.php"); include("footer.php"); include_once("../../include/connectIRECALL.inc");extract($_REQUEST);echo "<table width='660'>";$type="tradition"; returnNum($type);echo "<tr><th>Traditions: $numrow $view";$type="person"; returnNum($type);echo "<th>Special People: $numrow $view";$type="change1"; returnNum($type);echo "<th>Changes: $numrow $view";$type="photos"; returnNum($type);echo "<th>Photos: $numrow $view";$type="sound"; returnNum($type);echo "<th>Audio/Video: $numrow $view</tr><table>";echo "<div align='center'><table>";// *********** Search Form ***************echo "<form action='search.php'><tr><td><input type='text' name='search' size='15'><input type='submit' name='submit' value='Search'></form></td></tr></table><form></td></tr></table></div>";if($var){$sql="SELECT * FROM irecall.$var where mark='' order by date DESC";//echo "s=$sql";exit;$result = @mysql_query($sql, $connection) or die("$sql Error 2#". mysql_errno() . ": " . mysql_error());echo "<hr><table>";while($row = mysql_fetch_array($result)){extract($row);if($var=="person"){$sql1="SELECT count(type) as num FROM irecall.comment where type='$var' and typeid='$personid'";$result1 = @mysql_query($sql1, $connection) or die("$sql Error 2#". mysql_errno() . ": " . mysql_error());$row1 = mysql_fetch_array($result1);extract($row1);if($num>0){$com="<td>Comments: $num</td>";}else{$com="";}$subtext=substr($persontext,0,50);$line="<tr><td><b>$personname</b></td><td><a href='show.php?var=$var&personid=$personid'>Read</a></td><td>$subtext...</td><td>submitted by: $authorname</td>$com</tr>";}if($var=="tradition"){$sql1="SELECT count(type) as num FROM irecall.comment where type='$var' and typeid='$traditionid'";$result1 = @mysql_query($sql1, $connection) or die("$sql Error 2#". mysql_errno() . ": " . mysql_error());$row1 = mysql_fetch_array($result1);extract($row1);if($num>0){$com="<td>Comments: $num</td>";}else{$com="";}$subtext=substr($tradtext,0,50);$line="<tr><td><b>$title</b></td><td><a href='show.php?var=$var&traditionid=$traditionid'>Read</a></td><td>$subtext...</td><td>submitted by: $authorname</td>$com</tr>";}if($var=="change1"){$subtext=substr($changetext,0,50);$line="<tr><td><b>$changename</b></td><td><a href='show.php?var=$var&change1id=$change1id'>Read</a></td><td>$subtext...</td><td>submitted by: $authorname</td></tr>";}if($var=="photos"){$sql1="SELECT count(type) as num FROM irecall.comment where type='$var' and typeid='$pid'";$result1 = @mysql_query($sql1, $connection) or die("$sql Error 2#". mysql_errno() . ": " . mysql_error());$row1 = mysql_fetch_array($result1);extract($row1);if($num>0){$com="<td>Comments: $num</td>";}else{$com="";}$fs=round($filesize/1024);$base="photos/ztn."; $photoLink=$base.$pid.$filename;$subtext=substr($caption,0,50);$line="<tr><td align='center'><a href='getData.php?pid=$pid&location=$link&size=640'><img src='$photoLink'></a></td><td><b>$phototitle</b></td><td>$subtext...</td><td>submitted by: $submitter</td><td>($fs kb)</td>$com</tr>";}echo "$line";}// end whileecho "</table>";}// end iffunction returnNum($type){global $numrow,$connection,$view;$sql="SELECT * FROM irecall.$type";$result = @mysql_query($sql, $connection) or die("$sql Error 2#". mysql_errno() . ": " . mysql_error());$numrow = mysql_num_rows($result);if($numrow>0){$view="<br><a href='view.php?var=$type'>List</a></th>";}else{$view="<br>&nbsp;";}}?></div></body></html>