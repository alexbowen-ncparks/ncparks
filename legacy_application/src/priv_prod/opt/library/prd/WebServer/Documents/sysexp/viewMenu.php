<?php// called from menu.html// include("../../include/authSYSEXP.inc");$database="sysexp";include("../../include/iConnect.inc");extract ($_SERVER);extract ($_REQUEST);$thisFile = $_SERVER['PHP_SELF'];$thisFile=explode("/",$thisFile);$thisFile=$thisFile[2];switch ($status) {		case "":			$where=" WHERE execSum<'3'";$statusP="This is the combined list of Published and Tracked Units.";			break;			case "1":			$where=" WHERE execSum='1'";$statusP="This is the Published List of Units.";			break;		case "2":			$where=" WHERE execSum='2'";$statusP="These Units are Tracked but not publicly listed.";			break;		case "3":			$where=" WHERE execSum='3'";$statusP="These Units were on the original list of 75, but not selected for list inclusion.";			break;		case "4":			$where=" WHERE execSum='4'";$statusP="These Units have been removed from the list for various reasons.";			break;		case "5":			$where=" WHERE execSum='5'";$statusP="These Units have been added to the System.";			break;	}	if($sort==""){$sort="name";}else{$sort="type DESC, name";} $display_number = 65; // used to force into two columns$sql = "SELECT type,count(type) as ct from site $where group by type";// get number of unit types$result = @mysqli_query($connection,$sql) or die("Error #2". mysqli_errno($connection) . ": " . mysqli_error($connection));while ($row=mysqli_fetch_array($result)){$unitArray[$row[0]]=$row[1];// array with type as key & num as value}// end while// print_r($unitArray);$sql = "SELECT name,sid,typefrom site $whereorder by $sort";	// Calculate the number of pages required.$result = @mysqli_query($connection,$sql) or die("Error #2". mysqli_errno($connection) . ": " . mysqli_error($connection));// echo "$sql"; exit;$total_found = @mysqli_num_rows($result);$medianC=ceil ($total_found/2);$t=$total_found;	if ($total_found > $display_number) {		$num_pages = ceil ($total_found/$display_number);	} elseif ($total_found > 0) {		$num_pages = 1;	} else {		echo 'No Units found in the database; there must be a problem.';	}		$start = 0; // Currently at item 0.		// Split display on this unit.// $median = ceil($display_number/2);$median = ceil($medianC);echo "<!doctype html public '-//w3c//dtd html 4.0 transitional//en'><html><head><! Modified by Tom Howard from review.html><! Originally from Cornell Laboratory of Ornithology><title>Checklist</title><STYLE TYPE=\"text/css\"><!--body{font-family:sans-serif;background:beige}td{font-size:75%;background:beige}th{font-size:85%;background:beige}--> </STYLE> </head><body> <table>"; ?><script language="JavaScript"><!--function MM_jumpMenu(selObj,restore){ //v3.0eval("parent.frames['mainFrame']"+".location='"+selObj.options[selObj.selectedIndex].value+"'");  if (restore) selObj.selectedIndex=0;}//--></script><form> <select name="menu1" onChange="MM_jumpMenu(this,0)">          <option selected>Status Filter</option><?phpecho "          <option value=\"$thisFile?status=\">Published & Tracked</option>          <option value=\"$thisFile?status=1\">Just Published</option>          <option value=\"$thisFile?status=2\">Just Tracked</option>          <option value=\"$thisFile?status=4\">Removed</option>          <option value=\"$thisFile?status=5\">Added</option>        </select>      </form></td></tr></table><table align='center'><tr><td>$statusP</td></tr></table><table align='center'> <tr><td colspan='2' valign='top'>   <table border>    <tr><th align='center' valign='bottom'>Sort by <a href='editMenu.php?status=$status'>Name</a> <a href='editMenu.php?sort=1&status=$status'>Type</a></th>      </tr>";$counter = 1;// adjust font size//$f = 8;//if($f < 7){$f=7;}//if($f > 10){$f=10;}$na="NA=".$unitArray["Natural Area"];$sp="SP=".$unitArray["State Park"];$sra="SRA=".$unitArray["State Rec. Area"];$sr="SRA=".$unitArray["State River"];$st="SRA=".$unitArray["State Trail"];while ($row = mysqli_fetch_array($result)){extract($row);$displayName="<a href='edit.php?sid=$sid'>$name</a> - ".$type;if($counter <= $median){echo "<tr><td nowrap>&nbsp;$displayName&nbsp;</td></tr>";}  if($counter == $median){  echo" </table></td><td width=2>&nbsp;</td>  <td colspan='2' valign='top'>  <table border><tr>     <th align='center' valign='bottom'>$total_found Units ($na $sp $sra)</th>   </tr>";}    if($counter > $median){   echo "<tr><td nowrap>&nbsp;$displayName&nbsp;</td></tr>";}    $counter++;}echo "</table>  </td> </tr></table><table align='center'>";if ($num_pages > 1) {	echo "<tr align='center'>		<td align='center' colspan='2'>";			// Determine what page the script is on.		if ($start == 0) {		$current_page = 1;} else {		$current_page = ($start/$display_number) + 1;	}		// If it's not the first page, make a Previous button.	if ($start != 0) {		echo '<a href="checklistFind.php?start=' . ($start - $display_number) . '&num_pages=' . $num_pages . '&t=' . $t . '&park=' . $park . '&majorGroup=' . $majorGroupX . '&display=' . $display . '&sort=' . $sortX . '&num_page=' . $num_page . '&f=' . $f . '">Previous</a> ';	}	// Make all the numbered pages.	for ($i = 1; $i <= $num_pages; $i++) {		$next_start = $start + $display_number;		if ($i != $current_page) { // Don't link the current page.			echo '<a href="checklistFind.php?start=' . (($display_number * ($i - 1))) . '&num_pages=' . $num_pages  . '&t=' . $t . '&park=' . $park . '&majorGroup=' . $majorGroupX . '&display=' . $display . '&sort=' . $sortX . '&num_page=' . $num_page . '&f=' . $f . '">' . $i . '</a> ';		} else {			echo $i . ' ';		}	}		// If it's not the last page, make a Next button.	if ($current_page != $num_pages) {		echo '<a href="checklistFind.php?start=' . ($start + $display_number) . '&num_pages=' . $num_pages . '&t=' . $t . '&park=' . $park . '&majorGroup=' . $majorGroupX . '&display=' . $display . '&sort=' . $sortX . '&num_page=' . $num_page . '&f=' . $f . '">Next</a> ';	}		echo '</td>	</tr>';}echo "</table></body></html>";?>