<?php//These are placed outside of the webserver directory for security$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // databasesession_start();$level=$_SESSION[budget][level];extract($_REQUEST);$ckCenter=explode("-",$center);if($ckCenter[2]!=""){$center=$ckCenter[2];}else{if($center=="" and $level>2){$center=$ncas_center;}}// Construct Query to be passed to Excel Export$varQuery="submit=Submit&m=trans_unpost&ncas_center=$center&ncas_number=$ncas_number";//print_r($_SESSION);//EXIT;//print_r($_REQUEST);//EXIT;$level=$_SESSION[budget][level];$m="trans_unpost";if($rep==""){include("../menu.php");}if($level<2){$center=$_SESSION[budget][centerSess];}if($rep==""){// Display Formecho "<html><header></header<title></title><body><table align='center'><form method='POST' name='pcard_unposted.php'>";if($level>1 and $ncas_center==""){echo "<tr><td colspan='3'>";$sql="SELECT section,parkcode,center as varCenter from center where fund='1280' order by section,parkcode,center";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");while ($row=mysqli_fetch_array($result)){extract($row);$pc[]=$parkcode;$c[]=$varCenter;$sec[]=$section;}//echo "$sql";echo "<select name=\"center\"><option selected>Select Center</option>";for ($n=0;$n<count($c);$n++){$show=$sec[$n]."-".$pc[$n]."-".$c[$n];if($center==$c[$n]||$center==$show){$s="selected";}else{$s="value";}$con=$c[$n];		echo "<option $s='$con'>$show</option>\n";       }   echo "</select></td>";echo "<td>Show SQL <input type='checkbox' name='showSQL' value='x'></td>";//echo "<pre>";print_r($bg);echo "</pre>";EXIT;echo "<td>$addCenter<input type='submit' name='submit' value='Submit'></form></td></tr>";}else{$submit="submit";}if($submit){if($center==""||$center=="Select Center"){echo "<font color='red'>You must select a Center.</font>";exit;}echo "<tr><td><a href='pcard_unposted.php?$varQuery&rep=excel'>Excel Export</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$menuArray2[$scopeKey]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";//if($level<2){echo "Last Update: <font color='red'>$maxDate</font></td></tr>";}}// if submitecho "</table>";}if($submit!=""){$sql="SELECT center, admin_num, ncasnum, ncas_description, cardholder, pcard_num,transdate_new, vendor_name, amountFROM pcard_unreconciledWHERE post2ncas =  '' AND center =  '$center' and ncasnum='$ncas_number'order by center,ncasnum,cardholder";if($showSQL){echo "$sql<br><br>";//exit;}//echo "$sql<br><br>";exit;$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");$num=mysqli_num_rows($result);if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');header('Content-Disposition: attachment; filename=pcard_unposted.xls');$an="admin_num";}else{$an="admin<br>num";}// Display Resultsecho "<html><header></header><title>PCARD Unposted</title><body><table border='1' align='center'><tr><td colspan='6' align='center'><font color='blue'>$num</font> records returned</td></tr><tr><th>center</th><th>$an</th><th>ncasnum</th><th>description</th><th>cardholder</th><th>pcard_num</th><th>transdate</th><th>vendor_name</th><th>amount</th></tr>";while($row=mysqli_fetch_array($result)){extract($row); $amtTotal+=$amount;$amount=number_format($amount,2);if($rep=="excel"){$pcard_num="`".$pcard_num;}echo "<tr><td>$center</td><td>$admin_num</td><td>$ncasnum</td><td>$ncas_description</td><td>$cardholder</td><td>$pcard_num</td><td>$transdate_new</td><td>$vendor_name</td><td align='right'>$amount</td></tr>";}$amtTotal=number_format($amtTotal,2);echo "<tr><td colspan='9' align='right'>$amtTotal</td></tr>";echo "</table></body></html>";}?>