<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

$dbTable="partf_payments";
$file="reconcile.php";
$fileMenu="reconcile_menu.php";
if(!$fromTable){$fromTable="exp_rev";}

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;

// Construct Query to be passed to Excel Export
foreach($_REQUEST as $k => $v){
if($v and $k!="PHPSESSID"){$varQuery.=$k."=".$v."&";}
}
$passQuery=$varQuery;
   $varQuery.="rep=excel";
echo "varQuery=$varQuery";//exit;   
extract($_REQUEST);

if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=reconcile.xls');
//include("../../../include/connectBUDGET.inc");// database connection paramete
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
}

if($rep==""){include("$fileMenu");}
//include("../../../include/activity.php");

// ******** Show Results ***********
// FIELD NAMES are stored in $fieldArray
// FIELD TYPES and SIZES are stored in $fieldType

$fieldName=array("fund","cab_dpr","bd725_dpr","cab_bd725_total",
"exp_rev", "oob");

//print_r($fieldName);
if($fy!=""){
echo "<table border='1' cellpadding='3' align='center'><tr>";

for($i=0;$i<count($fieldName);$i++){
echo "<th>$fieldName[$i]</th>";
}
echo "</tr>";
$sql="truncate table reconcilement_dpr";
    $result = @MYSQL_QUERY($sql,$connection);
if($showSQL=="1"){echo "$sql<br><br>";}
    
$sql="insert into reconcilement_dpr(fund,cab_dpr,bd725_dpr,exp_rev)
select fund,sum(disburse_amt-receipt_amt),'',''
from cab_dpr
where 1 and f_year='$fy'
and dpr_valid='y'
group by cab_dpr.fund";
    $result = @MYSQL_QUERY($sql,$connection);
if($showSQL=="1"){echo "$sql<br><br>";}

$sql="insert into reconcilement_dpr(fund,cab_dpr,bd725_dpr,exp_rev)
select fund,'',sum(disburse_amt-receipt_amt),''
from bd725_dpr
where 1 and f_year='$fy'
group by bd725_dpr.fund";
    $result = @MYSQL_QUERY($sql,$connection);
if($showSQL=="1"){echo "$sql<br><br>";}

$sql="insert into reconcilement_dpr(fund,cab_dpr,bd725_dpr,exp_rev)
select fund,'','',sum(debit-credit)
from $fromTable
where 1 and f_year='$fy'
group by $fromTable.fund";
    $result = @MYSQL_QUERY($sql,$connection);
if($showSQL=="1"){echo "$sql<br><br>";}

$sql="select fund,cab_dpr,bd725_dpr,sum(cab_dpr+bd725_dpr) as 'cab_bd725_total',
sum(exp_rev) as 'exp_rev', sum(cab_dpr+bd725_dpr-exp_rev) as 'oob'
from reconcilement_dpr
where 1
group by fund";

    $result = @MYSQL_QUERY($sql,$connection);
if($showSQL=="1"){echo "$sql<br><br>";}

//echo "<pre>";print_r($row);echo "</pre>";
// extract($row); 
while($row = mysql_fetch_array($result)){
echo "<tr>";
for($i=0;$i<count($fieldName);$i++){
$t=$row[$i];
$vk=$fieldName[$i];
if($vk=="cab_dpr"){$cab_dpr_tot+=$t;}
if($vk=="bd725_dpr"){$bd725_dpr_tot+=$t;}
if($vk=="cab_bd725_total"){$cab_bd725_total_tot+=$t;}
if($vk=="exp_rev"){$exp_rev_tot+=$t;}
if($vk=="oob"){$oob_tot+=$t;}


if($vk!="fund"){
$tn=number_format($t,2);
$tf="<td align='right'>$tn</td>";}
else
{$tf="<td>$t</td>";}

echo "$tf";
}
echo "</tr>";
}// end while
$cab_dpr_tot=number_format($cab_dpr_tot,2);
$bd725_dpr_tot=number_format($bd725_dpr_tot,2);
$cab_bd725_total_tot=number_format($cab_bd725_total_tot,2);
$exp_rev_tot=number_format($exp_rev_tot,2);
$oob_tot=number_format($oob_tot,2);
echo "<tr>
<td colspan='2' align='right'><b>$cab_dpr_tot</b></td>
<td align='right'><b>$bd725_dpr_tot</b></td>
<td align='right'><b>$cab_bd725_total_tot</b></td>
<td align='right'><b>$exp_rev_tot</b></td>
<td align='right'><b>$oob_tot</b></td>
</tr>";

echo "<tr>";
for($i=0;$i<count($fieldName);$i++){
echo "<th>$fieldName[$i]</th>";
}
echo "</tr>
<tr><td colspan='6' align='right'><a href='/budget/infotrack3/dncr_down/step_group.php?report_type=form&fiscal_year=$fy'>Return Home</a></td></tr>


</table>";

}// end if

echo "</div></body></html>";
?>