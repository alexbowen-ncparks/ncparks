<?php             include("include/connectWar.inc");if ($section == ""){$section = "zzz";}if ($dist == ""){$dist = "zzz";}if ($park == ""){$park = "zzz";}if ($date == ""){$date = "zzz";}if ($weekFind == ""){$weekfind = "zzz";}$sql = "SELECT * FROM reportWHERE (section = '$section') OR(dist = '$dist') OR(park = '$park') OR(week = '$weekFind')ORDER BY section, dist";$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());$total_found = @mysql_num_rows($total_result);if ($total_found <1){echo "Results of search:  <b>$total_found records for WEEK '$week'</b><br><br>";echo "No record(s) found.";exit;}$spacer = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";$tempSection = "";$tempDist = "";$counter0 = "";while ($row = mysql_fetch_array($total_result)){ extract($row);                      include("section.inc");                      include("distLong.inc");if ($counter0 == ""){echo "<div align='center'><h3>North Carolina Division of Parks & Recreation<br>Weekly Activity Report</h3>for the week ending $week</div>";$counter0 = 1;echo "<table cellspacing='1'>";}$xyz= nl2br($body);$section = strtoupper ($section);$dist = strtoupper ($dist);     echo "<tr valign='top'>";if ($tempSection != $section){$counter1 = 0; echo "<tr><td><h4>$sectLong</h4></td></tr></table><table><tr>"; /*echo "<tr><td></td><td></td><td></td><td></td><td align='left'><h4>$sectLong</h4></td></tr></table><table><tr>";*/if ($tempDist != $dist or $dist == "" or $dist == " "){// ****Family and SciName on different line$counter1++;if ($dist == ""){$dist = $spacer;}echo "<td></td><td>$dist</td></tr>"; echo  "<tr valign='top'><td></td><td></td><td>$park&nbsp;&nbsp;</td><td align='top'>$counter1&nbsp;- &nbsp; </td><td><b><u>$title</b></u><br>$xyz</td>";}else{$counter1++; echo  "<td></td><td>$park&nbsp;&nbsp;</td><td align='top'>$counter1&nbsp;- &nbsp; </td><td><b><u>$title</b></u><br>$xyz</td>";}$tempDist = "";$counter1 = 0;echo "</tr>";  }elseif ($tempDist != $dist){$counter1++;// ****Family and SciName on different line echo "<td></td><td>$dist</td></tr>"; echo  "<tr valign='top'><td></td><td></td><td>$park&nbsp;&nbsp;</td><td align='top'>$counter1&nbsp;- &nbsp; </td><td><b><u>$title</b></u><br>$xyz</td>";}else{$counter1++; echo  "<td></td><td></td><td>$park&nbsp;&nbsp;</td><td align='top'>$counter1&nbsp;- &nbsp; </td><td><b><u>$title</b></u><br>$xyz</td>";}        $tempDist ="$dist"; // test$tempSection = $section;echo "</tr>";//}echo "</table>";?>