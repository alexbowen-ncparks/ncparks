<?php$dbTable="stats";$file="form.php";$fileMenu="menu.php";include("../../../include/connectATTEND.inc");// database connection parametersextract($_REQUEST);include("$fileMenu");// necessary to place this AFTER update script// ******** Show Form ***********// FIELD NAMES are stored in $fieldName// FIELD TYPES and SIZES are stored in $fieldType$sql = "SHOW COLUMNS FROM $dbTable";//echo "$sql";$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");while ($row=mysql_fetch_assoc($result)){extract($row);$fieldName[]=$row[Field];}$sql="SELECT max(id) as id from stats where park='cabe'";$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");$row=mysql_fetch_array($result);extract($row); $sql="SELECT traf_counter,inventory,occupied from stats where id='$id'";$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");$row=mysql_fetch_array($result);extract($row); //echo "m=$mtc";echo "<form action='insert.php' method='post'><table border='1'><tr>";echo "<th>Week</th>";for($i=3;$i<count($fieldName);$i++){// ignore id,park,date$fn=str_replace("_","<br>",$fieldName[$i]);if($fieldName[$i]=="traf_counter"){$val="<br>".$traf_counter;}else{$val="";}echo "<th>$fn$val</th>";} $y=date(Y);$m=date(m);$d=date(d);$test2 = weeknumber($y, $m, $d);$test = datefromweek($y, $test2, $o);$day=$test[day];// day 1 of week $test2for($z=0;$z<7;$z++){// make days of week starting at $day$v=getdate(mktime(0,0,0,$m,$day,$y));$mon=str_pad($v[mon],2,"0",STR_PAD_LEFT);$newday=str_pad($v[mday],2,"0",STR_PAD_LEFT);$newDate[]=$v[year].$mon.$newday;$sy[]=strftime("%a-%b %e",strtotime($newDate[$z]));$day=$day+1;}// Bring forward values$previous=array("inventory","occupied");for($k=1;$k<8;$k++){$l=$k-1;echo "</tr><tr><td align='center'>$sy[$l]<input type='hidden' name='newDate[]' value='$newDate[$l]'></td>";for($i=3;$i<count($fieldName);$i++){// ignore id,park,date$key=$fieldName[$i]; $j=$i-4;$check=$previous[$j];if($key==$check){$val=${$check};}else{$val="";}$key=$key."[$k][]";$fn="<input type='text' name='$key' value='$val' size='6'>";echo "<td>$fn</td>";}}$parkPass="CABE";echo "</tr>";echo "<tr><td><input type='hidden' name='parkPass' value='$parkPass'><input type='submit' name='submit' value='Enter'></td></tr>";echo "</form></table></div></body></html>"; /*� w e e k n u m b e r� -------------------------------------- // weeknumber returns a week number from a given date (>1970, <2030) Wed, 2003-01-01 is in week 1 Mon, 2003-01-06 is in week 2 Wed, 2003-12-31 is in week 53, next years first week Be careful, there are years with 53 weeks. // ------------------------------------------------------------ */  function weeknumber ($y, $m, $d) {  $wn = strftime("%W",mktime(0,0,0,$m,$d,$y));  $wn += 0; # wn might be a string value  $firstdayofyear = getdate(mktime(0,0,0,1,1,$y));  if ($firstdayofyear["wday"] != 1)  # if 1/1 is not a Monday, add 1    $wn += 1;  return ($wn); }  # function weeknumber /* d a t e f r o m w e e k ---------------------------------- // From a weeknumber, calculates the corresponding date Input: Year, weeknumber and day offset Output: Exact date in an associative (named) array 2003, 12, 0: 2003-03-17 (a Monday) 1995, 53, 2: 1995-12-xx ... // ------------------------------------------------------------ */  function datefromweek ($y, $w, $o) {  $days = ($w - 1) * 7 + $o;  $firstdayofyear = getdate(mktime(0,0,0,1,1,$y));  if ($firstdayofyear["wday"] == 0) $firstdayofyear["wday"] += 7;  # in getdate, Sunday is 0 instead of 7  $firstmonday = getdate(mktime(0,0,0,1,1-$firstdayofyear["wday"]+1,$y));  $calcdate = getdate(mktime(0,0,0,$firstmonday["mon"], $firstmonday["mday"]+$days,$firstmonday["year"]));  $date["year"] = $calcdate["year"];  $date["month"] = $calcdate["mon"];  $date["day"] = $calcdate["mday"];  return ($date); }  # function datefromweek ?>