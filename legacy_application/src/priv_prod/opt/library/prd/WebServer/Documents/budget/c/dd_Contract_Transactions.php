<?php
//These are placed outside of the webserver directory for security
include("../../../include/authBUDGET.inc"); // used to authenticate users
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
extract($_REQUEST);
//include_once("../menu.php");

if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=DPR_Contract_Transactions.xls');
}

$WHERE = "WHERE 1  AND cid_contract_transactions.dpr_contract_number =  '$contract_num'";
/*
, sc_change_order_required AS  'SC_CO_req', sc_change_order_approved AS  'SC_CO_app', DENR_form_2700_required AS  'form_2700_req', Denr_form_2700_approved AS  'form_2700_app', Denr_form_6000_required AS  'form_6000_req', Denr_form_6000_approved AS  'form_6000_app', denr_form_6100_required AS  'form_6100_req', denr_form_6100_approved AS  'form_6100_app'
*/

$sql="SELECT cid_contract_transactions.dpr_project_number AS  'DPR_projnum', partf_projects.park, partf_projects.projname as DPR_projname, cid_contract_transactions.dpr_contract_number AS  'DPR_contractnum', cid_contract_transactions.dpr_contractor_name AS  'contractor', cid_contract_vitals.ncas_center_encumbered AS  'center_encumber', dpr_contract_transaction_type AS  'transaction_type', dpr_change_order_number AS  'DPR_CO_num', dpr_table_entry_date AS  'entry_date', dpr_contract_transaction_amount AS  'transaction_amt'
FROM  `cid_contract_transactions` 
LEFT  JOIN partf_projects ON cid_contract_transactions.dpr_project_number = partf_projects.projnum
LEFT  JOIN cid_contract_vitals ON cid_contract_transactions.dpr_contract_number = cid_contract_vitals.dpr_contract_number
$WHERE
ORDER  BY  `dpr_change_order_number`  ASC";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);

if($showSQL=="1"){
echo "$sql<br>";//exit;
}
$varQuery=$_SERVER[QUERY_STRING];

//include_once("../menu.php");
echo "<div align='center'><font color='green'>DPR_Contract_Transactions</font> for Contract Number $contract_num";

if($rep==""){
echo "<table border='1'><tr><td><a href='dd_Contract_Transactions.php?$varQuery&rep=excel'>Excel Export</a></td><td><A HREF=\"javascript:window.print()\">Click to Print This Page</A></td></tr><table>";
}

echo "<table border='1'>";

$titleArray=array("DPR_projnum","park","DPR_Projname","DPR_Contract_num","contractor","center_encumber","transaction_type","DPR_CO_num","entry_date","transaction_amt","SC_CO_req","SC_CO_app","form_2700_req","form_2700_app","form_6000_req","form_6000_app","form_6100_req","form_6100_app");

for($i=0;$i<count($titleArray);$i++){
$t=strtoupper(str_replace("_","<br>",$titleArray[$i]));
echo "
<th>$t</th>";
}

while ($row=mysqli_fetch_array($result))
{extract($row);
@$totTransaction += $transaction_amt;

$transaction_amt=number_format($transaction_amt,2);

if(!isset($SC_CO_req)){$SC_CO_req="";}
if(!isset($SC_CO_app)){$SC_CO_app="";}
if(!isset($form_2700_req)){$form_2700_req="";}
if(!isset($form_2700_app)){$form_2700_app="";}
if(!isset($form_6000_req)){$form_6000_req="";}
if(!isset($form_6000_app)){$form_6000_app="";}
if(!isset($form_6100_req)){$form_6100_req="";}
if(!isset($form_6100_app)){$form_6100_app="";}
echo "<tr>
<td align='center'>$DPR_projnum</td>
<td align='center'>$park</td>
<td>$DPR_projname</td>
<td align='center'>$DPR_contractnum</td>
<td>$contractor</td>
<td align='center'>$center_encumber</td>
<td align='center'>$transaction_type</td>
<td align='center'>$DPR_CO_num</td>
<td align='right'>$entry_date</td>
<td align='right'>$transaction_amt</td>
<td align='center'>$SC_CO_req</td>
<td align='center'>$SC_CO_app</td>
<td align='center'>$form_2700_req</td>
<td align='center'>$form_2700_app</td>
<td align='center'>$form_6000_req</td>
<td align='center'>$form_6000_app</td>
<td align='center'>$form_6100_req</td>
<td align='center'>$form_6100_app</td>
</tr>";
}

$totTransaction=number_format($totTransaction,2);

echo "<tr><td colspan='10' align='right'><b>$totTransaction</b></td>
<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
</tr>";

echo "</table></div></body></html>";

?>