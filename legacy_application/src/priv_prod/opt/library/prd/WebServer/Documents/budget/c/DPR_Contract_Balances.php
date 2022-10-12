<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}



//These are placed outside of the webserver directory for security
include("../../../include/authBUDGET.inc"); // used to authenticate users
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");
//print_r($_SESSION);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
extract($_REQUEST);
//include_once("../menu.php");
if(!isset($showSQL)){$showSQL="";}
if(!isset($rep)){$rep="";}

$level=$_SESSION['budget']['level'];

if($level<3){
$reports=$_SESSION['budget']['report'];
$check=$reports[1];
	if($check!="DPR_Contract_Balances"){
	$p=$_SESSION[budget][select];
	$sql0 = "SELECT dpr_contract_number,dpr_project_number,dpr_contract_type,dpr_contractor_name,dpr_contract_administrator,projname
FROM  cid_contract_vitals
LEFT JOIN `partf_projects` ON cid_contract_vitals.dpr_project_number=partf_projects.projnum
WHERE partf_projects.park='$p'";
//echo "$sql0";
$result0 = mysqli_query($connection, $sql0) or die ("Couldn't execute query. $sql0");
$num=mysqli_num_rows($result0);
while($row=mysqli_fetch_array($result0)){
extract($row);
echo "Project Name = $projname<br> Contract Number = $dpr_contract_number<br> Project Number = $dpr_project_number<br>Contract Type = $dpr_contract_type<br> Contractor Name = $dpr_contractor_name<br> Contract Administrator = $dpr_contract_administrator<br><br><br>";}
exit;}
else{$man=$_SESSION['budget']['manager'];
if($man=="fac_con_eng"){$whereMan="";}else{$whereMan="and contract_administrator='$man'";}
}
}

if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=DPR_Contract_Balances.xls');
}

// ************** Start Display **************
$sql0 = "Select DATE_FORMAT(max(datenew),'<font color=\'red\'>%Y-%m-%e') as maxDate from partf_payments";
$result0 = mysqli_query($connection, $sql0) or die ("Couldn't execute query. $sql0");
$row=mysqli_fetch_array($result0);extract($row);

$sql1 = "truncate table cid_contract_balances";
$result1 = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");

$sql2 = "INSERT into cid_contract_balances( project_num,park,projname,contract_administrator,contract_num,contractor,center,total_contract_amt,total_payments,ending_balance,po_number,denr_contract) SELECT cid_contract_vitals.dpr_project_number AS 'project#', partf_projects.park AS 'park', partf_projects.projname AS 'projname',cid_contract_vitals.dpr_contract_administrator,cid_contract_vitals.dpr_contract_number AS 'contract#', cid_contract_vitals.dpr_contractor_name AS 'contractor', cid_contract_vitals.ncas_center_encumbered AS 'center', sum( cid_contract_transactions.dpr_contract_transaction_amount ) AS 'Total_Contract_Amt','','',cid_contract_vitals.po_number,cid_contract_vitals.denr_contract_number
FROM cid_contract_vitals
LEFT JOIN cid_contract_transactions ON cid_contract_vitals.dpr_contract_number = cid_contract_transactions.dpr_contract_number
LEFT JOIN partf_projects ON cid_contract_vitals.dpr_project_number = partf_projects.projnum
WHERE 1 GROUP BY cid_contract_vitals.dpr_contract_number
ORDER BY `cid_contract_vitals`.`dpr_project_number` ASC
";
$result2 = mysqli_query($connection, $sql2) or die ("Couldn't execute query. $sql2");

/*   // old $sql2a
$sql2a = "INSERT into cid_contract_balances(project_num,park,projname,contract_administrator,contract_num,contractor,center,total_contract_amt,total_payments,ending_balance,
po_number,xtnd_remaining_encumbrance,cid_contract_balances.xtnd_balance_date)
select '','','','',cid_contract_vitals.dpr_contract_number,'','','','','','',
sum(xtnd_po_encumbrances.po_remaining_encumbrance),xtnd_po_encumbrances.balance_date
from cid_contract_vitals
left join xtnd_po_encumbrances on cid_contract_vitals.po_number=xtnd_po_encumbrances.po_number
where 1
group by cid_contract_vitals.dpr_contract_number";
$result2a = mysqli_query($connection, $sql2a) or die ("Couldn't execute query. $sql2a");
*/

// new $sql2a
$sql2a = "INSERT into cid_contract_balances(project_num,park,projname,contract_administrator,contract_num,contractor,center,total_contract_amt,total_payments,ending_balance, po_number,xtnd_remaining_encumbrance,cid_contract_balances.xtnd_balance_date) select '','','','',cid_contract_vitals.dpr_contract_number,'','','','','','', sum(xtnd_po_encumbrances.po_remaining_encumbrance),xtnd_po_encumbrances.balance_date from cid_contract_vitals left join xtnd_po_encumbrances on cid_contract_vitals.po_number=xtnd_po_encumbrances.po_number and cid_contract_vitals.ncas_center_encumbered =xtnd_po_encumbrances.center where 1 group by cid_contract_vitals.dpr_contract_number
";
$result2a = mysqli_query($connection, $sql2a) or die ("Couldn't execute query. $sql2a");

$sql3 = "INSERT into cid_contract_balances(project_num,park,projname,contract_administrator,contract_num,contractor,center,total_contract_amt,total_payments)
SELECT '','','','',contract_num, '','','',sum( contract_amt ) 
FROM  `partf_payments` 
WHERE 1 
GROUP  BY contract_num";
$result3 = mysqli_query($connection, $sql3) or die ("Couldn't execute query. $sql3");

$sql3a = "UPDATE cid_contract_balances,cid_contract_vitals SET cid_contract_balances.project_num= cid_contract_vitals.dpr_project_number,
cid_contract_balances.contract_administrator= cid_contract_vitals.DPR_contract_administrator,
cid_contract_balances.contractor= cid_contract_vitals.DPR_contractor_name,
cid_contract_balances.center= cid_contract_vitals.NCAS_center_encumbered,
cid_contract_balances.DPR_comments= cid_contract_vitals.DPR_comments,
cid_contract_balances.bo_comments= cid_contract_vitals.bo_comments
WHERE cid_contract_vitals.dpr_contract_number= cid_contract_balances.contract_num";
$result3a = mysqli_query($connection, $sql3a) or die ("Couldn't execute query. $sql3a");

$WHERE="WHERE 1";
if($proj_num_find!=""){$WHERE .=" AND project_num='$proj_num_find'";}

if($contract_administrator!="" AND $whereMan==""){$WHERE .=" AND contract_administrator='$contract_administrator'";}

if($contractor!=""){$WHERE .=" AND contractor='$contractor'";}
if($center_encumber!=""){$WHERE .=" AND center='$center_encumber'";}

$sql4 = "SELECT project_num as 'DPR_projnum', park, projname as 'DPR_Projname', contract_administrator,contract_num as 'DPR_Contractnum', contractor, center as 'center_encumber', sum( `Total_Contract_Amt` ) AS 'Total_Contract', sum( `Total_Payments` ) AS 'Total_Payments', sum( Total_Contract_Amt - Total_Payments ) AS 'Balance',cid_contract_balances.denr_contract,cid_contract_balances.PO_number,cid_contract_balances.DPR_comments,sum(XTND_remaining_encumbrance) as 'XTND_encumbrance_amt',
max(cid_contract_balances.XTND_balance_date) as 'XTND_balance_date',
sum( total_contract_amt - total_payments ) - sum( xtnd_remaining_encumbrance ) AS 'oob',cid_contract_balances.bo_comments
FROM `cid_contract_balances`
$WHERE $whereMan
GROUP  BY contract_num";
$result4 = mysqli_query($connection, $sql4) or die ("Couldn't execute query. $sql4");
$num=mysqli_num_rows($result4);
//echo "$sql4";

if($showSQL=="1"){
$sql5="$sql2;<br><br>$sql2a;<br><br>$sql3;<br><br>$sql3a;<br><br>$sql4";
echo "$sql5<br>";//exit;
}
$varQuery=$_SERVER['QUERY_STRING'];
//echo "<pre>";print_r($_SERVER);echo "</pre>";

if($rep==""){
$sql="SELECT  DISTINCT  contract_administrator as conAdminMenu  FROM  `cid_contract_balances`";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){extract($row);
$con_admin[]=$conAdminMenu;
}

$sql="SELECT  DISTINCT  contractor as contractorMenu  FROM  `cid_contract_balances` order by contractor";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){extract($row);
$contractor_Menu[]=$contractorMenu;
}

$sql="SELECT  DISTINCT  center as centerMenu  FROM  `cid_contract_balances` order by center";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){extract($row);
$center_Menu[]=$centerMenu;
}

include_once("../menu.php");

echo "<div align='center'><font color='green'>DPR_Contract_Balances</font></div>";

echo "<table><tr><td><a href='DPR_Contract_Balances.php?$varQuery&rep=excel'>Excel Export</a></td><form action='DPR_Contract_Balances.php'>
<td> Proj. # <input type='input' name='proj_num_find' value='$proj_num_find'size='5'></td>";

if(!isset($contract_administrator)){$contract_administrator="";}
echo "<td>Contract Administrator: <select name=\"contract_administrator\">";
for ($n=0;$n<count($con_admin);$n++){
$con=$con_admin[$n];
if($con==$contract_administrator){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$con_admin[$n]\n";
       }
   echo "</select></td>";

if(!isset($contractor)){$contractor="";}
echo "<td>Contractor: <select name=\"contractor\">";
for ($n=0;$n<count($contractor_Menu);$n++){
$con=$contractor_Menu[$n];
if($con==$contractor){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$contractor_Menu[$n]\n";
       }
   echo "</select></td>";
   
if(!isset($center_encumber)){$center_encumber="";}
echo "<td>Center: <select name=\"center_encumber\">";
echo "<option selected=''></option>";
for ($n=0;$n<count($center_Menu);$n++){
$con=$center_Menu[$n];
if($con==$center_encumber){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$center_Menu[$n]\n";
       }
   echo "</select></td>";
   
echo "<td><input type='checkbox' name='showSQL' value='1'>Show SQL</td>
<td><input type='submit' name='submit' value='Find'></td></form>

</tr></table>";}

if(!$submit){exit;}

echo "<table border='1'><tr><td colspan='13'>DPR_Contract_Balances Payments posted thru $maxDate</td></tr><tr>";

$titleArray=array("DPR_projnum","park","DPR_Projname","contract_administrator","DPR_Contract_num","contractor","center_encumber","Total_Contract","Total_Payments","Balance","DENR_contract","PO_number","DPR_Comments","XTND_encumber","XTND_balance_date","out_balance","OOB_comments");

for($i=0;$i<count($titleArray);$i++){
$t=strtoupper(str_replace("_","<br>",$titleArray[$i]));
echo "
<th>$t</th>";
}
echo "</tr>";

while ($row=mysqli_fetch_array($result4))
{extract($row);

@$totContract += $Total_Contract;
@$totPayments += $Total_Payments;
@$totBalance += $Balance;
@$totXTND += $XTND_encumbrance_amt;

$Total_Contract=number_format($Total_Contract,2);
$Total_Payments=number_format($Total_Payments,2);

if($Balance<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}
$Balance=number_format($Balance,2);
$XTND_encumbrance=number_format($XTND_encumbrance_amt,2);

$link_TP="<A HREF=\"javascript:void(0)\"onclick=\"window.open('dd_Total_Payments.php?contract_num=$DPR_Contractnum','linkname','scrollbars=yes')\">$Total_Payments</a>";

$link_TT="<A HREF=\"javascript:void(0)\"onclick=\"window.open('dd_Contract_Transactions.php?contract_num=$DPR_Contractnum','linkname','scrollbars=yes')\">$Total_Contract</a>";

echo "<tr>
<td align='center'>$DPR_projnum</td>
<td align='center'>$park</td>
<td>$DPR_Projname</td>
<td>$contract_administrator</td>
<td align='center'>$DPR_Contractnum</td>
<td>$contractor</td>
<td align='center'>$center_encumber</td>
<td align='right'>$link_TT</td>
<td align='right'>$link_TP</td>
<td align='right'>$f1$Balance$f2</td>
<td align='center'>$denr_contract</td>
<td align='center'>$PO_number</td>
<td>$DPR_comments</td>
<td align='right'>$XTND_encumbrance</td>
<td align='center'>$XTND_balance_date</td>
<td align='center'>$oob</td>
<td align='center'>$bo_comments</td>
</tr>";
}// end while

$totContract=number_format($totContract,2);
$totPayments=number_format($totPayments,2);
$totBalance=number_format($totBalance,2);
$totXTND=number_format($totXTND,2);

echo "<tr><td colspan='8' align='right'><b>$totContract</b></td>
<td align='right'><b>$totPayments</b></td>
<td align='right'><b>$totBalance</b></td>
<td colspan='4' align='right'><b>$totXTND</b></td><td></td></tr>";

if($num>30){echo "<tr>";
for($i=0;$i<count($titleArray);$i++){
$t=strtoupper(str_replace("_","<br>",$titleArray[$i]));
echo "
<th>$t</th>";
}// end for
echo "</tr>";
}// end if
echo "</table></body></html>";

?>