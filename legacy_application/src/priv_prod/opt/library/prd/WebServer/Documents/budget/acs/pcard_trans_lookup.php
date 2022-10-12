<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

include("../../../include/authBUDGET.inc");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");

// echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";//exit;
$tempID=$_SESSION['budget']['tempID'];
$file="pcard_trans_lookup.php";
$fileMenu="pcard_trans_lookup_menu.php";
$varQuery=$_SERVER[QUERY_STRING]."&m=$m";
// ECHO "v=$varQuery";//exit;
// ECHO "$_SERVER[QUERY_STRING]";//exit;
//$reportHeader=explode("&",$_SERVER[QUERY_STRING]);
//print_r($reportHeader);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//$level=$_SESSION[budget][level];// now set in authBUDGET.inc

extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
if($admin_num){$parkcode=$admin_num;}// *************

$distPark=strtoupper($parkcode);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

// ******** Edit/Update Status ***********
if($submit=="Update"){
//echo "<pre>";print_r($arrayLocation);print_r($arrayTransID);
//print_r($_REQUEST);echo "</pre>";exit;
$today=date("Y-m-d");

for($i=0;$i<count($arrayTransID);$i++){
$id=$arrayTransID[$i];
if($item_purchased[$id]!="" AND $ncasnum[$id]!="" AND $center[$id]!="")
{$updatepark_recondate=", park_recondate='$today'";}else{$updatepark_recondate=", park_recondate=''";}

if(!$budget_ok[$id]){$updateBudget_OK="";}
else{$updateBudget_OK=",budget_ok='$budget_ok[$id]'";
if($budget_ok[$id]=="Y"){$updateBudget_OK.=",budget2controllers='$today'";}
else{$updateBudget_OK.=",budget2controllers=''";}
}

if($arrayLocation[$i]=="1629"||$arrayLocation[$i]=="1669"){
$testCenter="center_".$id;$testProjNum="projnum_".$id;
$center[$id]=$_REQUEST[$testCenter];
$projnum[$id]=$_REQUEST[$testProjNum];
if($center[$id]!="" AND $projnum[$id]!="")
{$updatepark_recondate=",park_recondate='$today'";}else{$updatepark_recondate=", park_recondate=''";}
}
else{
$check1616Center=substr($center[$id],0,4);
if($check1616Center!="1280"){$center[$id]="INCORRECT";$m=1;}
}

// format a correct NCAS number
$ck_ncasnum=$ncasnum[$id];
$ck_ncasnum=str_replace("-","",$ck_ncasnum);
if(strlen($ck_ncasnum)==4 || strlen($ck_ncasnum)==7){$ck_ncasnum="53".$ck_ncasnum;}

$query="UPDATE `pcard_unreconciled` 
set ncas_description='',item_purchased='$item_purchased[$id]', ncasnum='$ck_ncasnum', center='$center[$id]', projnum='$projnum[$id]', equipnum='$equipnum[$id]'
$updatepark_recondate $updateBudget_OK
WHERE transid_new='$arrayTransID[$i]'";
//echo "$query<br>";//exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 0. $query");
}// end for

$query="update pcard_unreconciled,coa
 set pcard_unreconciled.ncas_description=coa.park_acct_desc
 where pcard_unreconciled.ncasnum=coa.ncasnum";
//echo "$query<br>";//exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 0. $query");
 
// ECHO "v=$varQuery";exit;
header("Location: pcard_recon.php?$varQuery"); exit;
}

// **************  Show Results ***************
/*
// Get most recent date from Exp_Rev
$sql="SELECT DATE_FORMAT(max(datenew),'Report Date: <font color=\'red\'>%Y-%m-%d</font>') as maxDate FROM `partf_payments` WHERE 1";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 0. $sql");
$row=mysqli_fetch_array($result);
extract($row);
//echo "m=$maxDate";exit;
*/

if($rep=="excel"){
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=pcard_reconcile.xls');
$reportHeader=explode("&",$_SERVER[QUERY_STRING]);
$showReportHeader="<tr><td>&nbsp;</td><td>$reportHeader[0]</td><td>$reportHeader[1]</td><td>$reportHeader[2]</td><td>$reportHeader[3]</td></tr>";
}
if($_SESSION[budget][beacon_num]=='60032892'){$level=4;} //core/eadi Cashier bonita meeks
if($_SESSION[budget][beacon_num]=='60032912'){$level=4;} //core/eadi Manager 20210719-currently vacant, temp/acting Sarah Kendrick [beacon_num]=='60032843'
if($_SESSION[budget][beacon_num]=='60033093'){$level=4;} //pire/sodi Cashier valerie mitchener
if($_SESSION[budget][beacon_num]=='60033019'){$level=4;} //pire/sodi Manager jay greenwood
if($_SESSION[budget][beacon_num]=='60032931'){$level=4;} //more/wedi Cashier annette hall
if($_SESSION[budget][beacon_num]=='60032913'){$level=4;} //more/wedi Manager sean mcelhone
if($_SESSION[budget][beacon_num]=='65030652'){$level=4;} // nodi Manager kristen woodruff
if($_SESSION[budget][beacon_num]=='60032920'){$level=4;} // nodi Cashier Aimee McGuinness

// Determine access
if($level>2)
{$WHERE.=" where pcard_unreconciled.admin_num='$parkcode'";}

//echo "line 112: level=$level";
if($level==2){
include_once("../../../include/parkcodesDiv.inc");
$parkList=$_SESSION[budget][select];// Get district
if(!$parkcode){$parkcode=$parkList;}
$da=${"array".$parkList}; //print_r($da);exit;
if(in_array($parkList,$da)){
$parkcode=strtoupper($parkcode);
if(in_array($parkcode,$da)){
$WHERE.=" where pcard_unreconciled.admin_num='$parkcode'";}else{echo "<br>No access for $parkcode";exit;}
}else{echo "<br><br>You do not have access privileges for this database [$db] report at $level $posTitle. Contact DPR Database support group at database.support@ncparks.gov, if you wish to gain access.<br>park_project_balances.php<br>budget.php<br>dist=$parkList $distPark";exit;}
}

if($level==1){
$parkcode=strtoupper($parkcode);
$parkSession=$_SESSION[budget][select];
$WHERE.=" where pcard_unreconciled.admin_num='$parkSession'";
//Workaround for NERI/MOJE
if($_SESSION[budget][select]=="NERI" and ($parkcode=="NERI" or $parkcode=="MOJE")){
$WHERE.=" where pcard_unreconciled.admin_num='$parkcode'";}
}

if($WHERE=="")
{
$rep=$_SESSION[budget][report];echo "You do not have access privileges for this database [$db] report at level $level $posTitle. Contact DPR Database support group at database.support@ncparks.gov, if you wish to gain access.<br><br>budget.php<br>";print_r($a);print_r($_SESSION[budget][report]);exit;}



// ******** Show Results ***********

if($rep==""){
$varQuery=$_SERVER[QUERY_STRING];
include("$fileMenu");
/*
if($varQuery){
echo "<a href='$file?$varQuery&rep=excel'>Excel Export</a>";
echo "&nbsp;&nbsp;&nbsp;<a href='$file?$varQuery&rep=excel'>Excel Report 1656</a>";
echo "&nbsp;&nbsp;&nbsp;<a href='$file?$varQuery&rep=excel'>Excel Report 1669</a>";}
*/
}

if($admin_num!="" and $submit=="Find"){// another name for parkcode

if($cardholder){$WHERE.=" AND pcard_unreconciled.cardholder='$cardholder'";
$passCardholder="$cardholder";}

if($vendor_name){$WHERE.=" and pcard_unreconciled.vendor_name LIKE '%$vendor_name%'";$passCardholder="$cardholder";}

if($amount){$WHERE.=" and pcard_unreconciled.amount='$amount'";$passCardholder="$cardholder";}

if($transdate_start AND $transdate_end){$WHERE.=" and transdate_new >= '$transdate_start'  and transdate_new <= '$transdate_end'
";}

echo "<html><body><form action='$file' name='pcardForm' method='POST'>
<table border='1' cellpadding='3' align='center'>";

if($level>1 and $cardholder.$vendor_name.$amount==""){exit;}
 $query = "SELECT pcard_unreconciled.admin_num,
pcard_unreconciled.cardholder,
pcard_unreconciled.pcard_num,
pcard_unreconciled.location,
pcard_unreconciled.transid_new AS 'transid',
pcard_unreconciled.transdate_new AS 'transdate',
pcard_unreconciled.vendor_name,
pcard_unreconciled.amount,
pcard_unreconciled.item_purchased,
pcard_unreconciled.company,
pcard_unreconciled.ncasnum,
pcard_unreconciled.ncas_description,
pcard_unreconciled.center,
pcard_unreconciled.projnum,
pcard_unreconciled.equipnum,
pcard_unreconciled.xtnd_rundate_new,
pcard_unreconciled.report_date,
pcard_unreconciled.park_recondate,
pcard_unreconciled.budget_ok,
pcard_unreconciled.budget2controllers,
pcard_unreconciled.reconcilement_date,
pcard_unreconciled.center as pc_center,
pcard_unreconciled.post2ncas
FROM pcard_unreconciled
$WHERE 
order by admin_num,cardholder,amount";
//$result = @mysqli_query($connection, $query,$connection);
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 0. $query"); 
//echo "<br />query=$query<br />";
if($showSQL==1){echo "$query<br>";}

$num=mysqli_num_rows($result);
$numHeader="<font color='purple'>$num</font> records.";

if($showReportHeader){echo "$showReportHeader";}

if($m==1){echo "<tr><td colspan='16' align='center'><blink><font color='magenta'>An incorrect Center was entered. Please make the correction.</font></blink></td></tr>";}
$pcard_report_type="pcard_lookup";
echo "<br />pcard_report_type=$pcard_report_type<br />";

if($report_type==""){
if($level<3){$header="<tr><th>admin #</th><th>card<br>holder</th><th>pcard number</th><th>location</th><th>transid<br />transdate</th>
<th>vendor&nbsp;name</th><th>amount</th><th>item purchased</th><th>ncasnum</th><th>ncas_description</th><th>&nbsp;&nbsp;&nbsp;center&nbsp;&nbsp;&nbsp;</th><th>projnum</th><th>equipnum</th><th>park_recondate</th></tr>";
echo "$numHeader $header";

include("pcard_recon_L1.php");}

if($level>2){$header="<tr><th>admin #</th><th>card<br>holder</th><th>pcard number</th><th>location</th><th>transid<br />transdate</th>
<th>vendor&nbsp;name</th><th>amount</th><th>item purchased</th><th>ncasnum</th><th>ncas_description</th><th>&nbsp;&nbsp;&nbsp;center&nbsp;&nbsp;&nbsp;</th><th>projnum</th><th>equipnum</th><th>&nbsp;&nbsp;xtnd_date&nbsp;</th><th>report_date</th><th>park_recondate</th><th>budget_ok</th><th>budget<br>2controllers</th><th>post2ncas</th></tr>";
echo "$numHeader $header";
include("pcard_recon_L3.php");}
}// end display Form

echo "</div></body></html>";
}
?>