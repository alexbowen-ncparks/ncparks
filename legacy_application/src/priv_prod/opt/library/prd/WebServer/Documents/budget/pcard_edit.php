<?php//These are placed outside of the webserver directory for security$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // databasesession_start();extract($_REQUEST);//print_r($_SESSION);//EXIT;?><script language="JavaScript"><!--function MM_jumpMenu(targ,selObj,restore){ //v3.0  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");  if (restore) selObj.selectedIndex=0;}function confirmLink(){ bConfirm=confirm('Are you sure you want to delete this record?') return (bConfirm);}//--></script><?phpinclude("menu.php");// Update Recordif($submit=="Update"){$lastname=addslashes($lastname);$vendor=addslashes($vendor);$query="UPDATE pcard set card='$card',lastname='$lastname',vendor='$vendor',postdate='$postdate', transid='$transid',transdate='$transdate',company='$company',acct='$acct',center='$center',amt='$amt',descrip='$descrip',payst='$payst'where pcardid='$pcardid'";$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");header("Location: pcard_edit.php?pcardid=$pcardid&m=1");exit;}// Display Formecho "<html><header></header<title></title><body><table><form action='pcard_edit.php'>";$sql1 = "SELECT * from pcard where pcardid='$pcardid'";$result = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");$row=mysqli_fetch_array($result);extract($row);$amt_f=number_format($amt,2);if($m==1){echo "<tr><td>Update Successful.</td></tr>";}if($m==2){echo "<tr><td>Record Successfully Added.</td></tr>";}echo "<tr><td><font color='teal'><b>PURCHASING CARDS</b></font></td></tr><tr><td>Post Date:  <input type='text' name='postdate' size='15' value='$postdate'></td></tr><tr><td>Company:  <input type='text' name='company' size='5' value='$company'></td><td>Acct:  <input type='text' name='acct' size='10' value='$acct'></td><td>Card:  <input type='text' name='card' size='10' value='$card'></td></tr><tr><td>Last Name:  <input type='text' name='lastname' size='10' value='$lastname'></td><td>Vendor:  <input type='text' name='vendor' size='30' value='$vendor'></td><td>Transid:  <input type='text' name='transid' size='12' value='$transid'> </td></tr><tr><td>Transdate:  <input type='text' name='transdate' size='12' value='$transdate'></td><td>Center:  <input type='text' name='center' size='5' value='$center'></td><td>Amount:  <input type='text' name='amt' size='15' value='$amt'>$amt_f</td></tr><tr><td>Description:  <input type='text' name='descrip' size='30' value='$descrip'></td><td>Payst:  <input type='text' name='payst' size='6' value='$payst'></td><td></tr><tr><td><input type='hidden' name='pcardid' value='$pcardid'><input type='submit' name='submit' value='Update'></form></td><form action='pcard.php'><td><input type='submit' name='submit' value='Find'></td></form></tr></table></body></html>";?>