<?php//These are placed outside of the webserver directory for security//include("../../include/authBUDGET.inc"); // used to authenticate users$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // databaseinclude("menu.php");?><script language="JavaScript"><!--function MM_jumpMenu(targ,selObj,restore){ //v3.0  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");  if (restore) selObj.selectedIndex=0;}//--></script><?php//print_r($_REQUEST);extract($_REQUEST);echo "<form action='pcard.php'><table><tr><td>Post Date:  <input type='text' name='postdate' size='15' value='$postdate'></td><td>Center: <input type='text' name='center' size='10' value='$center'></td></tr><tr><td>card:  <input type='text' name='card' size='5' value='$card'></td><td>lastname:  <input type='text' name='lastname' size='10' value='$lastname'></td><td>vendor:  <input type='text' name='vendor' size='25' value='$vendor'></td></tr><tr><td>transid:  <input type='text' name='transid' size='10' value='$transid'></td><td>company:  <input type='text' name='company' size='10' value='$company'></td><td>acct:  <input type='text' name='acct' size='12' value='$acct'></td></tr><tr><td>amt: <input type='text' name='amt' size='12' value='$amt'></td><td>descrip:  <input type='text' name='descrip' size='25' value='$descrip'></td><td>payst:  <input type='text' name='payst' size='12' value='$payst'></td></tr><tr><td><input type='submit' name='submit' value='Find'></form></td><td> <form action='pcard.php'><input type='submit' name='' value='Reset'></form</td></tr></table>";  // ***** Pick display function and set sql statement$co=count($_REQUEST); //print_r($_REQUEST);//echo "c=$co";exit;$from="pcard.* From pcard";if($co>0){$where=" WHERE 1";}else{exit;}if($card!=""){$where.=" and card='$card'";}if($lastname!=""){$where.=" and lastname LIKE '%$lastname%'";}if($vendor!=""){$where.=" and vendor LIKE '%$vendor%'";}if($postdate!=""){$where.=" and postdate='$postdate'";}if($transid!=""){$where.=" and transid='$transid'";}if($company!=""){$where.=" and company='$company'";}if($acct){if(strpos($acct,'!')===0){$acct=substr($acct,1);$where.=" and acct!='$acct'";}else{$where.=" and acct='$acct'";}}if($center!=""){$where.=" and center='$center'";}if($amt!=""){$where.=" and amt='$amt'";}if($descrip!=""){$where.=" and descrip LIKE '%$descrip%'";}if($payst!=""){$where.=" and payst='$payst'";}if($groupBY!=""){$g="Group by account";}if($where==" WHERE 1"){exit;}$sql1 = "SELECT $from $where $g";echo "$sql1<br>";//exit;/*$val=array_values($_REQUEST);$fld=array_keys($_REQUEST);for($i=0;$i<$co;$i++){if($val[$i]!="" AND $val[$i]!="Find" AND $fld[$i]!="PHPSESSID"){$item.=" ".$fld[$i]."=".$val[$i];}}$item=strtoupper($item);if($sql1){$result = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");$num=mysqli_num_rows($result);}if($num>1){echo "<font color='green'>$num Items for $item</font><hr>";}   echo "</select></form></td>";   echo "</tr></table>";*/if($sql1){include_once("headerPcard.php");include_once("functionPcard.php");$result = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");$num=mysqli_num_rows($result);if($num>1){echo "$num <font color='green'>$z Items:$currPark</font><hr>";}// Access Levels are not used for this page/*// Park Level accessif($var==$park){$accessLevel="2";}else{$accessLevel="1";}// District wide accessif($_SESSION[itrak][level]=="2"){include_once("../../include/parkcodesDiv.inc");$a="array";$b="$var";$distArray=${$a.$b};if(in_array($park,$distArray)){$accessLevel="2";}else{$accessLevel="1";}}// System wide accessif($_SESSION[itrak][level]=="3"){$accessLevel="2";}*/$accessLevel=1;switch($accessLevel){	case "1":while ($row=mysqli_fetch_array($result)){extract($row);$grandTotal=$grandTotal+$amt;itemShow($card,$lastname,$vendor,$postdate,$transid,$transdate,$company,$acct,$center,$amt,$descrip,$payst,$pcardid);}	break;	case "2":while ($row=mysqli_fetch_array($result)){extract($row);itemEdit($rcc,$park,$expenseType,$budAllocate,$payPosted,$warehouse,$endBalance);}	break;	default:	echo "Access denied";exit;	}// end Switch	$grandTotal=number_format($grandTotal,2);echo "$$grandTotal</table></body></html>";}?>