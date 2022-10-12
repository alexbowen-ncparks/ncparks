<?php
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/get_parkcodes_reg.php");
// include("../../include/iConnect.inc"); // database connection parameters

mysqli_select_db($connection,$database);
// include("../../include/dist.inc");

if($_SESSION['divper']['loginS']=="DIST"){header("Location: distMenu.php");exit;}

if($_SESSION['divper']['loginS']!="ADMIN" AND $_SESSION['divper']['loginS']!="SUPERADMIN"){echo "Access denied.<br>Administrative Login Required.<br><a href='login_form.php'>Login</a> ";exit;}


//  ************Start Menu form*************
if(!$admin){
menuStuff();
echo "</body></html>";
exit;
}// end if !$admin

//  ************Start Input form for Park Selection ************
if($admin=="park"){
menuStuff();if($park){$_SESSION['parkS']=$park;
echo "<font color='blue'>$park</font> has been selected.<br>You can now select desired action for this park from the left side navigation bar.<br>Latter, return to the Admin page to select a different park.";}
echo "<form method='post' action='adminMenu.php'><select name='park'>";         
        for ($n=1;$n<=$numParkCode;$n++)  
       {$scode=$parkCode[$n];if($scode==$park){$s="selected";}else{$s="value";}
		echo "<option $s='$scode'>$scode\n";
       }
echo "</select><input type='hidden' name='admin' value='park'>
<input type='submit' name='submit' value='Select Park'></form>
<hr></body></html>";exit;
}


// *************** Display Menu FUNCTION **************
function menuStuff(){
$align="align='center'";
echo "<html><head><title>Admin Menu</title>
<STYLE TYPE=\"text/css\">
<!--
body
{font-family:sans-serif;background:beige}
td
{font-size:90%;background:beige}
th
{font-size:95%; vertical-align: bottom}
--> 
</STYLE></head>
<body><font size='4' color='004400'>NC State Parks System Personnel Database</font>
<br><font size='5' color='blue'>Administrative Function Menu
</font><hr><table>
<tr><td colspan='2' width='300'><b>Choose Action:</b>
	<table>
		<tr><td width='25'></td><td $align><FORM>
<INPUT TYPE='button' value='Choose park' onClick=\"location='adminMenu.php?admin=park'\">
</FORM></td></tr>";

if($_SESSION['divper']['loginS']=="SUPERADMIN"){
		echo "<tr><td width='25'></td><td $align><FORM>
<INPUT TYPE='button' value='SuperAdmin' onClick=\"location='adminSuperMenu.php'\">
</FORM></td></tr>";}

echo "</table></td>
<td colspan='2' width='300'><b>&nbsp;</b>
	<table>
		<tr><td $align><FORM>
<INPUT TYPE='button' value='List Vacant Positions' onClick=\"location='findVacant.php'\">
</FORM></td></tr>

<tr><td $align><FORM>
<INPUT TYPE='button' value='Assign Someone to a Position' onClick=\"location='assignPosition.php?admin=traPos'\">
</FORM></td></tr>";
/*
		<tr><td $align><FORM>
<INPUT TYPE='button' value='Track a Vacant Position' onClick=\"location='trackPosition.php'\">
</FORM></td></tr>";
*/

echo "<tr><td>&nbsp;</td></tr>
		<tr><td $align><FORM>
<INPUT TYPE='button' value='Edit an Employee' onClick=\"location='formEmpInfo.php?parkS=&submit='\">
</FORM></td><td $align><FORM>
<INPUT TYPE='button' value='Add an Employee' onClick=\"location='formEmpInfo.php?submit=New'\">
</FORM></td></tr>";

	echo "<tr><td>&nbsp;</td></tr>
		</table></td></tr>
</table><hr>";
}
?>