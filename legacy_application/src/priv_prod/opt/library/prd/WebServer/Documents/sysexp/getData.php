<?phpinclude("../../include/authSYSEXP.inc");include("../../include/connectSYSEXP.inc");if($pid){$where="pid=$pid";}    @mysql_select_db("sysexp");$query = "select * from sysexp.photos where $where";// echo "$query"; exit;    $result = @MYSQL_QUERY($query);$number = @mysql_num_rows($result);    $name = @MYSQL_RESULT($result,0,"name");    $filename = @MYSQL_RESULT($result,0,"filename");    $photographer = @MYSQL_RESULT($result,0,"photographer");    $comment = @MYSQL_RESULT($result,0,"comment");    $date = @MYSQL_RESULT($result,0,"date");    $phototitle = @MYSQL_RESULT($result,0,"phototitle");    $discus = @MYSQL_RESULT($result,0,"discus");    $pid = @MYSQL_RESULT($result,0,"pid");    $sql2 = "SELECT photos.pid as pid2 FROM photos WHERE photos.sid = '$sid' and photos.mark !='x'";$result2 = @mysql_query($sql2, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());$numrow2 = mysql_num_rows($result2);Header( "Content-type: text/html");    echo "<HTML><HEAD><TITLE>SYSEXP Photo</TITLE></HEAD><BODY><body bgcolor='beige'><script language='JavaScript'>function confirmLink(){bConfirm=confirm('Are you sure you want to delete this Photo?') return (bConfirm);}</script>";    echo "<table><tr><td><b>$name</b></td></tr><tr><td>$phototitle</td></tr>";if($photographer){echo "<tr><td>Photographer: $photographer</td>";}if($date != "0000-00-00"){echo "<td>Date: $date </td>";}echo "</tr></table>";if($comment){echo "Comment: $comment";}// Works with either photo stored in db or as a fileif(!$location){echo "<br><img src='getPhoto.php?pid=$pid'>";}else{echo "<br><img src='$location'>";}	$NSname = urlencode($name);// needed for Netscape ver. 4.x $NSphotog = urlencode($photog);$NScomment = urlencode($comment);$NSdiscus = urlencode($discus);if ($del == "y"){$link = "<a href='deletePh.php?pid=$pid&del=y' onClick='return confirmLink()'>Really, really Delete this Photo</a>";} else {$link = "<a href='deletePh.php?pid=$pid&name=$name' onClick='return confirmLink()'>Delete this Photo</a>";}echo "$link<br>";echo "<form action='siteAV.php' method='POST'>";echo "<td><input type='hidden' name='sciName' value='$NSsciName'>";echo "<input type='hidden' name='pid' value='$pid'>";echo "<input type='hidden' name='photographer' value='$photographer'>";echo "<input type='hidden' name='date' value='$date'>";echo "<input type='hidden' name='name' value='$name'>";echo "<input type='hidden' name='phototitle' value='$phototitle'>";echo "<input type='hidden' name='comment' value='$NScomment'>";echo "<input type='submit' name='submit' value='Edit the Photo Info'></td></tr></form>";$name = urldecode($name);$pidTest = $pid;$sql2 = "SELECT * FROM photos WHERE photos.name = '$name' and photos.mark !='x'";$result2 = @mysql_query($sql2, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());$numrow2 = mysql_num_rows($result2);//echo "n = $numrow2";$testNum = $numrow2;if ($numrow2 > 1) 	{ $i = 1; //$num=2; echo "<table>"; while ($row2 = mysql_fetch_array($result2))		{extract($row2);if($photog != ""){$photog = " $photog";}else{$photog = "by ?";}$link = "<a href='getData.php?pid=$pid&name=$name&sid=$sid&v=e'>Photo $i</a>";$j = $i -1;if($pid != $pidTest){if($comment != ''){$comment = "- ".$comment;}echo "<tr><td width='250'>$phototitle </td><td width='50'> $link</td><td> $comment</td></tr>";}$i++;	}if($numrow2 > 2){$Pnum = "Other Photos";}else{$Pnum = "Another Photo";}  echo "$Pnum from $name</table>";	}echo "<br><FORM><INPUT TYPE='button' value='Return to $name' onClick=\"location='edit.php?sid=$sid&v=e'\"></FORM></div></body></html>";?>