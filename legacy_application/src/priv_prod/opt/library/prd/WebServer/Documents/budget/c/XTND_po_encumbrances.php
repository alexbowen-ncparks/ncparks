<?php
//These are placed outside of the webserver directory for security

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

include("../../../include/authBUDGET.inc"); // used to authenticate users
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");
$cr=count($_REQUEST);
//echo "cr=$cr<pre>";print_r($_REQUEST);echo "</pre>";//exit;
extract($_REQUEST);

//if($center.$po_number_find.$vendor_short_name==""){echo "No values were entered. Click your browser's Back button.";exit;}

if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=XTND_po_encumbrances.xls');
}

// ************** Start Display **************
$WHERE="WHERE 1";
if($center!=""){$WHERE .=" AND center LIKE '$center%'";}
if($po_number_find!=""){$WHERE .=" AND po_number='$po_number_find'";}
if($vendor_short_name!=""){$WHERE .=" AND vendor_short_name='$vendor_short_name'";}

if($center.$po_number_find.$vendor_short_name!=""){
$sql4 = "SELECT  `center` ,  `buying_entity` ,  `po_number` ,  `blanket_release_number` ,  `po_line_number` , po_line_entered_date,  `vendor_short_name` ,  `first_line_item_description` ,  `PO_remaining_encumbrance` ,  `balance_date` ,`acct`
FROM  `xtnd_po_encumbrances` 
$WHERE
ORDER  BY po_number, po_line_number";
$result4 = mysqli_query($connection, $sql4) or die ("Couldn't execute query. $sql4");
$num=mysqli_num_rows($result4);

if($showSQL=="1"){echo "$sql4<br>";//exit;
}
$varQuery=$_SERVER[QUERY_STRING];
//echo "<pre>";print_r($_SERVER);echo "</pre>";
}

if($rep==""){

$sql="SELECT  DISTINCT  vendor_short_name as VSN  FROM  `xtnd_po_encumbrances` order by vendor_short_name";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){extract($row);
$vendor_short_Menu[]=$VSN;
}


$sql="Select DATE_FORMAT(max(datenew),'Report Date: <font color=\'red\'>%c/%e/%y') as maxDate from xtnd_po_encumbrances";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){extract($row);
}


$func="XTND_po_encumbrances";
include_once("../menu.php");
echo "<div align='center'><font color='green'>XTND_PO_Encumbrances</font> &nbsp;&nbsp;&nbsp;&nbsp;$maxDate";

if($num>0){$rc="Record count: <font color='blue'><b>$num</b></font>&nbsp;&nbsp;&nbsp;&nbsp;";}

echo "<table><tr>
<td>$rc <a href='XTND_po_encumbrances.php?$varQuery&rep=excel'>Excel Export</a></td>
<form action='XTND_po_encumbrances.php' name=\"portalForm\">
<td> PO # <input type='input' name='po_number_find' value='$po_number_find'size='15'></td>";
   
echo "<td>Vendor: <select name=\"vendor_short_name\">";
echo "<option selected=''>\n";
for ($n=0;$n<count($vendor_short_Menu);$n++){
$con=$vendor_short_Menu[$n];
if($con==$vendor_short_name){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$vendor_short_Menu[$n]\n";
       }
   echo "</select></td>";
   
$label="<input type=\"button\" value=\"View Centers\" onClick=\"return popitup('/budget/portalCenterLookup.php?f=xtnd_po')\">";

echo "<td> Center: <input type='input' name='center' value='$center'size='9'>$label";
echo "</td><td><input type='checkbox' name='showSQL' value='1'>Show SQL</td>
<td><input type='submit' name='submit' value='Find'></form></td>
<td><form action='XTND_po_encumbrances.php'><input type='submit' name='reset' value='Reset'></form></td>

</tr></table>";}

if($cr==1||$reset=="Reset"){exit;}
if($submit==""){exit;}

echo "<table border='1'><tr>";

$titleArray=array("center","buying_entity","po_number","blanket_release_number","po_line_number","po_line_entered_date","vendor_short_name","first line item_description","PO_remaining_encumbrance","balance_date","NCAS_Account");

for($i=0;$i<count($titleArray);$i++){
$t=strtoupper(str_replace("_","<br>",$titleArray[$i]));
echo "
<th>$t</th>";
}
echo "</tr>";

while ($row=mysqli_fetch_array($result4))
{extract($row);

$totRE += $PO_remaining_encumbrance;

if($PO_remaining_encumbrance<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}

$PO_remaining_encumbrance=number_format($PO_remaining_encumbrance,2);

$link_TT="<A HREF=\"javascript:void(0)\"onclick=\"window.open('dd_Contract_Transactions.php?contract_num=$DPR_Contractnum','linkname','height=600, width=1024,scrollbars=yes')\">$Total_Contract</a>";

echo "<tr>
<td align='center'>$center</td>
<td align='center'>$buying_entity</td>
<td>$po_number</td>
<td>$blanket_release_number</td>
<td align='center'>$po_line_number</td>
<td>$po_line_entered_date</td>
<td>$vendor_short_name</td>
<td>$first_line_item_description</td>
<td align='right'>$f1$PO_remaining_encumbrance$f2</td>
<td align='center'>$balance_date</td>
<td align='center'>$acct</td>
</tr>";
}// end while

$totRE=number_format($totRE,2);

echo "<tr><td colspan='9' align='right'><b>$totRE</b></td>
<td align='right'><b>$totPayments</b></td>
</tr>";

if($num>30){echo "<tr>";
for($i=0;$i<count($titleArray);$i++){
$t=strtoupper(str_replace("_","<br>",$titleArray[$i]));
echo "
<th>$t</th>";
}// end for
echo "</tr>";
}// end if
echo "</table></div></body></html>";

?>