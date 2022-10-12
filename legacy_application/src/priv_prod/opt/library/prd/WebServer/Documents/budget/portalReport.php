<?php
//These are placed outside of the webserver directory for security
//include("../../include/authBUDGET.inc"); // used to authenticate users


session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
session_start();
include("../../include/activity.php");
//echo "Your Query is being processed....<br>";
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;

extract($_REQUEST);
$sql="OPTIMIZE  TABLE  `exp_rev`,`inc_dec`";
$result = mysqli_query($connection, $sql);

// Creates the last 4 Fiscal Years - Used in queries
if($f_year==""){
$testMonth=date(j);
if($testMonth >0 and $testMonth<8){$year2=date(Y)-1;}
if($testMonth >7){$year2=date(Y);}

$yearNext=$year2+1;$yx=substr($year2,2,2);
$year3=$yearNext;$yy=substr($year3,2,2);
$f_year=$yx.$yy;
}
else
{
$yx=substr($f_year,0,2);
$year2="20".$yx;$year3=$year2+1;}

$y0=substr($year2-3,2,4);
$y1=substr($year2-2,2,4);$py3=$y0.$y1;
$y2=substr($year2-1,2,4);$py2=$y1.$y2;
$y3=substr($year2,2,4);$py1=$y2.$y3;
$y4=substr($year3,2,4);$cy=$y3.$y4;

//echo "py3=$py3 py2=$py2 py1=$py1 cy=$cy <br><br>f_year=$f_year y2=$year2 y3=$year3 y4=$y4 y3=$y3 y2=$y2 y1=$y1<br><br>today=$today compare=$compare testMonth=$testMonth";//exit;

if($form){  // if form is blank script flows past the switch
switch ($form){
case "1":
$center=$_SESSION[budget][centerSess];
$dbReport="Center";$submit="Submit";$rccYN="Y";
break;
case "2":
header("Location: a/budget_total.php");exit;
break;
case "3":
header("Location: a/budget_equip_detail.php");exit;
break;
case "4":
header("Location: a/budget_equip_div.php");exit;
break;
case "5":
header("Location: a/purchase4resale_detail.php");exit;
break;
case "6":
header("Location: a/budget_rev_detail.php");exit;
break;
case "7":
$dbReport="Center";$submit="Submit";$resale="Y";$groupAcct="Y";
include("portalReports/a/expWresale.php");exit;
break;
case "8":
header("Location: a/warehouse.php");exit;
exit;
break;
case "9":
$center=$_SESSION[budget][centerSess];
$dbReport="Center";$submit="Submit";$center=$center;$groupAcct="Y";
include("portalReports/a/travel.php");
exit;
break;
case "10":
$center=$_SESSION[budget][centerSess];
$dbReport="Center";$submit="Submit";$center=$center;$groupAcct="Y";
include("projNumEditMenu.php");
exit;
break;
case "11":
header("Location: /budgeta/auth_budget.php");
exit;
break;
case "12":
header("Location: /budget/a/center_level_budgets.php");
exit;
break;
case "13":
$center=$_SESSION[budget][centerSess];
$dbReport="Center";$submit="Submit";$center=$center;$groupAcct="Y";
include("portalReports/a/warehouse0506.php");
exit;
break;
case "14":
header("Location: /budget/a/center_level_budgets.php");
exit;
break;
}// end Switch
}
// if form was blank script continues from here

if($export=="Excel"){
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=Center.xls');
}
else
{include("menu.php");
echo "
<script language='JavaScript'>
function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this record?')
 return (bConfirm);
}
</script>";

//echo "<form action=\"portalReport.php\" method=\"post\">";
echo "<form action=\"portalReport.php\">";

echo "<table><tr><td colspan='3'>You are working with CID Report <font color=\"blue\">$dbReport</font>$rangeOfDates</td></tr><tr>";

// ********** CHECK User Level
if($_SESSION[budget][level]==1){
// Kludge to allow NERI to also work with MOJE
if($_SESSION[budget][centerSess]=="12802859"){

$daCode=array("NERI","MOJE"); //print_r($daCode);exit;
$daCenter=array("12802859","12802857"); //print_r($daCenter);exit;

echo "<tr><td><form><select name=\"center\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select Center</option>";$s="value";
for ($n=0;$n<count($daCode);$n++){
$con=$daCode[$n];
		echo "<option $s='portalReport.php?rccYN=Y&dbReport=Center&px=$con&submit=Submit'>$daCode[$n]-$daCenter[$n]\n";
       }
   echo "</select></form></td></tr>";

$pc=$_SESSION[budget][select];$reportLevel=1;
$sql="SELECT center from center where parkCode='$px'";
//echo "$sql";exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$dbReport="Center";$center=$center;$submit="yes";}

} // end NERI workaround
else{
$pc=$_SESSION[budget][select];$reportLevel=1;
$sql="SELECT center from center where parkCode='$pc'";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$dbReport="Center";$center=$center;$submit="yes";}
}// end NERI else
}// end level = 1

if($_SESSION[budget][level]==2){
$reportLevel=2;
include_once("../../include/parkRCC.inc");
$scope="dist";
$distCode=$_SESSION[budget][select];
$parkList=$_SESSION[budget][select];
$da=${"array".$parkList}; //print_r($da);exit;
while (list($key,$val)=each($da)){
$parkList=$parkList.",".$val;}
$where="where FIND_IN_SET(center.parkCode,'$parkList')>''";
$order=" ORDER BY exp_rev.center";

$sql="SELECT section,parkcode as p,center as varCenter from center $where order by section,parkcode,center";
//echo "1 $sql";//exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$ar1[]=$p;$ar2[]=$varCenter;$ar3[]=$section;
}
// Menu 1
echo "<tr><td><form><select name=\"center\"><option selected>Select Center</option>";$s="value";
for ($n=0;$n<count($ar2);$n++){
$con=$ar2[$n];
		echo "<option $s='$con'>$ar3[$n]-$ar1[$n]-$ar2[$n]\n";
       }
   echo "<option value='$distCode'>All $distCode (Takes > 30 sec.)</select></td>";

// Menu 2
$sql2="SELECT ncasNum as n2,park_acct_desc as p2 from coa where track_rcc='Y' and ncasNum not like '534%' order by ncasNum";
//echo "$sql2";//exit;
$result2 = mysqli_query($connection, $sql2) or die ("Couldn't execute query 2. $sql2");
while ($row2=mysqli_fetch_array($result2)){
extract($row2);$ar4[]=$n2;$ar5[]=$p2;
}
echo "<td><select name=\"acct\"><option selected>Select NCAS Number</option>";$s="value";
for ($n=0;$n<count($ar5);$n++){
$con2=$ar4[$n];
		echo "<option $s='$con2'>$ar4[$n]-$ar5[$n]\n";
       }
   echo "</select></td>";
   
if(!isset($varInflation)){$varInflation=10;}
echo "<td>% Inc to flag:<input type='text' name='varInflation' value='$varInflation' size='3'></td>";

if(isset($pc)||isset($px)){
$pc=$_SESSION[budget][select];$reportLevel=2;
if($px){$pc=$px;}
$sql="SELECT center from center where parkCode='$pc'";
//echo "<br><br>$sql";exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$dbReport="Center";$center=$center;$submit="yes";}
}//end if pc or px

$formType="Submit";
if($dbReport=="warehouse_billings_0405"){$form=8;}
echo "<td><input type='hidden' name='dbReport' value='$dbReport'>
<input type='hidden' name='rccYN' value='Y'>
<input type='hidden' name='form' value='$form'>
<input type='submit' name='submit' value='$formType'></form></td></tr></table>";
} // end level = 2

if($_SESSION[budget][level]>2){
$scope="division";
$reportLevel=2;
$sql="SELECT section,parkcode,center as varCenter from center where fund='1280' order by section,parkcode,center";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$pc[]=$parkcode;$c[]=$varCenter;$sec[]=$section;}

$menuArray1=array("Y","N","EADI-Y","NODI-Y","SODI-Y","WEDI-Y");
$menuArray2=array("Center-rcc->Y","Division-rcc->N","EADI","NODI","SODI","WEDI");
// Menu 1
echo "<td>Scope: <select name=\"rccYN\">";$s="value";
for ($n=0;$n<count($menuArray2);$n++){
$con=$menuArray1[$n];
		echo "<option $s='$con'>$menuArray2[$n]\n";
       }
   echo "</select></td>";

// Menu 2
echo "<td><select name=\"center\"><option selected>Select Center</option>";$s="value";
for ($n=0;$n<count($c);$n++){
$con=$c[$n];
		echo "<option $s='$con'>$sec[$n]-$pc[$n]-$c[$n]\n";
       }
   echo "</select></td>";
   
// Menu 3
$sql2="SELECT ncasNum as n2,park_acct_desc as p2 from coa where track_rcc='Y' and ncasNum not like '534%' order by ncasNum";
//echo "2 $sql2";exit;
$result2 = mysqli_query($connection, $sql2) or die ("Couldn't execute query 2. $sql2");
while ($row2=mysqli_fetch_array($result2)){
extract($row2);$ar4[]=$n2;$ar5[]=$p2;
}
echo "<td><select name=\"acct\"><option selected>Select NCAS Number</option>";$s="value";
for ($n=0;$n<count($ar5);$n++){
$con2=$ar4[$n];
		echo "<option $s='$con2'>$ar4[$n]-$ar5[$n]\n";
       }
   echo "</select></td>";

if(!isset($varInflation)){$varInflation=10;}
echo "<td>% Inc to flag:<input type='text' name='varInflation' value='$varInflation' size='3'></td>";
echo "<td><input type='checkbox' name='export' value='Excel'>Excel Export</td>";
echo "<td><input type='checkbox' name='showSQL' value='sql'>Show Queries</td>";
echo "</tr></table>";

$formType="Submit";
if($dbReport=="warehouse_billings_0405"){$form=8;}
if($dbReport=="warehouse_billings_0506"){$form=13;}
echo "<table><tr>
<td><input type='hidden' name='dbReport' value='$dbReport'>
<input type='hidden' name='scope' value='$scope'>
<input type='hidden' name='lastFld' value='$lastFld'>
<input type='hidden' name='form' value='$form'>
<input type='submit' name='submit' value='$formType'></form><td>
<form><td><input type='hidden' name='dbReport' value='$dbReport'><input type='submit' name='' value='Reset'></form></td></tr></table>";
} // end level > 2
}// end if NOT EXCEL export

//********** CREATE SQL for Queries 1, 2 and 3 **********
if($dbReport=="Center"){
$pos=substr("1280",$center);
if($pos==0){$printDISU="y";}

// ********** This set variables AND displays the result **********
// use limit for testing
//$limit="LIMIT 50";

include_once("a/budget_request_center.php");
}


if($showSQL){echo "$sql1<br>$sql2<br>$sql3<br>";}
//echo "<pre>";print_r($spent_2_array);echo "</pre>";exit;

if($sql3){

echo "<font color='green'>$num $z </font>Summaries for [Center Account] excluding 534 series. $comment<hr>";


// Make Header	
portalHeader($passSQL,$colHeaders);


//echo "$sq3<pre>";print_r($spent_3_array);echo "</pre>";exit;

// previous queries made in a/budget_request_center.php


$fromSQL4="CONCAT(section,exp_rev.acct,center.center) AS sacKey,section,parkcode, center.center, exp_rev.acct, coa.park_acct_desc,
park_req,park_just,disu_app,disu_req,disu_just,susp_app,susp_req,susp_just,dire_app,dire_req,dire_just,cert_budg,inc_decid FROM exp_rev";
// Version 1 had only park_req
$where4=$where;
//$where4="WHERE 1 AND coa.track_rcc = 'Y' AND exp_rev.fund = '1280'";
// need join3 - park request inc-dec

$sql4 = "SELECT $fromSQL4 $join1 $join2 $join3 $where4 $g $limit";

//echo "$sql4";
//exit;
$result4 = mysqli_query($connection, $sql4) or die ("Couldn't execute query 4. $sql4");
$num4=mysqli_num_rows($result4);
while ($row4=mysqli_fetch_array($result4))
{//extract($row4);
$array4[]=$row4;
}

for($u=0;$u<count($array4);$u++){
list($key,$section,$parkcode,$center,$acct, $park_acct_desc,$park_req,
$park_just,$disu_app,$disu_req,$disu_just,$susp_app,$susp_req,$susp_just, $dire_app,$dire_req,$dire_just,$cert_budg,$inc_decid)=$array4[$u];

$ckAcct[]=$acct;
$nowAcct=$ckAcct[$u];
$uuAcct=$u-1;
$prevAcct=$ckAcct[$uuAcct];

$ck[]=$section.$acct;
$now=$ck[$u];
$uu=$u-1;
$prev=$ck[$uu];

$park_acct_descArray[]=$park_acct_desc;
$park_acct_descPrev=$park_acct_descArray[$uu];

$spent1=-$spent_1_array[$key];
$spent2=-$spent_2_array[$key];
$spent3=-$spent_3_array[$key];

if($disu_app=="1"){$disu_display=$disu_req." X";$mark="";}else{
$mark=" bgcolor='white'";
$disu_display=$park_req;}

/*
$totAcct3=$spent3+$totAcct3;
$totReqSub=$park_req+$totReqSub;
IF($disu_app=="1"){$totDISUSub=$disu_req+$totDISUSub;}
IF($susp_app=="1"){$totSUSPSub=$susp_req+$totSUSPSub;}
IF($dire_app=="1"){$totDIRESub=$dire_req+$totDIRESub;}
*/

$spent1Form=number_format($spent1,2);
$spent2Form=number_format($spent2,2);
$spent3Form=number_format($spent3,2);

// don't think we need these
//$subDISUForm=number_format($sub_disu_req,2);
//$subSUSPForm=number_format($sub_susp_req,2);
//$subDIREForm=number_format($sub_dire_req,2);

if($reportLevel>1 and $prev and ($now!=$prev)){

if($printDISU!="y"){
$totParkReqform="<b>Last Year's Expenditure: ".$tot3Form."</b>";
$totDISUform=number_format($tot_disu_req,2);
$totSUSPform=number_format($tot_susp_req,2);
$totDIREform=number_format($tot_dire_req,2);
}
echo "<tr bgcolor='#CCCCCC'>
<td align='right' colspan='5'>$prev $park_acct_descPrev SubSubTotal:</td>
<td align='right'><b>$tot1Form</b></td>
<td align='right'><b>$tot2Form</b></td>
<td align='right'><b>$tot3Form</b></td>
<td align='right'><b>$tot_park_reqSubSub</b></td>
<td align='right'>$totParkReqform</td>
<td align='right'><b>$totDISUform</b></td>
<td align='right'><b>$totSUSPform</b></td>
<td align='right'><b>$totDIREform</b></td>";
echo "<td align='right'><b>$tot_cert_budgSubSub</b></td></tr>";

$totDISUSub=$tot_disu_req+$totDISUSub;
//$totSUSPSub=$tot_susp_req+$totSUSPSub;
//$totDIRESub=$tot_dire_req+$totDIRESub;

$tot1="";$tot2="";$tot3="";$sub_park_req="";  //$sub_req_amt="";

$tot_disu_req="";$tot_susp_req="";$tot_dire_req="";

$sub_dire_req="";$subsub_cert_budg="";$totParkReqform="";

}

// Print SubTotal line (see below for last Acct found in query)
IF($prevAcct AND $nowAcct!=$prevAcct){
$totAcct1Form=number_format($totAcct1,2);
$totAcct2Form=number_format($totAcct2,2);
$totAcct3Form=number_format($totAcct3,2);
$totReqSubForm=number_format($totReqSub,2);
$totDISUSubForm=number_format($totDISUSub,2);
$totSUSPSubForm=number_format($totSUSPSub,2);
$totDIRESubForm=number_format($totDIRESub,2);
$totCERT_BUDGSubForm=number_format($sub_cert_budg,2);

echo "<tr bgcolor='#CCCCCC'>
<td align='right' colspan='5'><b>$prevAcct $park_acct_descPrev SubTotal: </b></td>
<td align='right'><b>$totAcct1Form</b></td>
<td align='right'><b>$totAcct2Form</b></td>
<td align='right'><b>$totAcct3Form</b></td>
<td align='right'><b>$totReqSubForm</b></td>
<td align='right'><b>$totAcct3Form</b></td>
<td align='right'><b>$totDISUSubForm</b></td>
<td align='right'><b>$totSUSPSubForm</b></td>
<td align='right'><b>$totDIRESubForm</b></td>
<td align='right'><b>$totCERT_BUDGSubForm</b></td>
</tr>";
$totAcct1="";$totAcct2="";$totAcct3="";$totReqSub="";$totDISUSub="";$totSUSPSub="";$totDIRESub="";
$sub_cert_budg="";}// end IF

$tot1=$spent1+$tot1;
$tot2=$spent2+$tot2;
$tot3=$spent3+$tot3;
//$tot3=$tot3+$total;

$totAcct1=$spent1+$totAcct1;
$totAcct2=$spent2+$totAcct2;
$totAcct3=$spent3+$totAcct3;
$totReqSub=$park_req+$totReqSub;
//IF($disu_app=="1"){$totDISUSub=$disu_req+$totDISUSub;}
//IF($susp_app=="1"){$totSUSPSub=$susp_req+$totSUSPSub;}
//IF($dire_app=="1"){$totDIRESub=$dire_req+$totDIRESub;}
//$totDISUSub=$tot_disu_req+$totDISUSub;
//$totSUSPSub=$susp_req+$totSUSPSub;
//$totDIRESub=$dire_req+$totDIRESub;


$tot1Form=number_format($tot1,2);
$tot2Form=number_format($tot2,2);
$tot3Form=number_format($tot3,2);

//$varInflation=3;
$percentInc=round(($park_req/$spent3)*100);
if($percentInc >= $varInflation){$flag="<font color='red'>".$percentInc."%</font>";}else{$flag="";}

if($spent3==0.00 and $park_req>0){$new="<font color='purple'>new expense</font>";}else{$new="";}

$req_amt=$spent3+$park_req; // 1st draft before adding disu,susp,dire

// 2nd draft after adding disu,susp,dire
$cert_budg=$req_amt;

// Upper level approval
if($disu_app=="1"){$cert_budg=$spent3+$disu_req;
$disu_req_passtoSUSP=$disu_req;
$tot_disu_req=$tot_disu_req+$disu_req;
}else{$disu_req="";
$disu_req_passtoSUSP=$park_req;
$tot_disu_req=$tot_disu_req+$park_req;
}

if($susp_app=="1"){$cert_budg=$spent3+$susp_req;
$susp_req_passtoDIRE=$susp_req;
$tot_susp_req=$tot_susp_req+$susp_req;
}else{$susp_req="";
$susp_req_passtoDIRE=$disu_req_passtoSUSP;
$tot_susp_req=$tot_susp_req+$disu_req_passtoSUSP;
}

if($dire_app=="1"){$cert_budg=$spent3+$dire_req;
$tot_dire_req=$tot_dire_req+$dire_req;
}else{$dire_req="";
$tot_dire_req=$tot_dire_req+$susp_req_passtoDIRE;
}

$sub_req_amt=$sub_req_amt+$req_amt; // 1st draft before adding disu,susp,dire
$subsub_cert_budg=$subsub_cert_budg+$cert_budg; // 2nd draft including disu,susp,dire

$sub_cert_budg=$sub_cert_budg+$cert_budg;

$sub_park_req=$sub_park_req+$park_req;

$tot_spent1=$tot_spent1+$spent1;
$tot_spent2=$tot_spent2+$spent2;
$tot_spent3=$tot_spent3+$spent3;
$tot_park_req=$tot_park_req+$park_req;
$tot_req_amt=$tot_req_amt+$req_amt; // 1st draft before adding disu,susp,dire

$tot_cert_budg=$tot_cert_budg+$cert_budg; // 2nd draft including disu,susp,dire

$tot_req_amtSub=number_format($sub_req_amt,2); // 1st draft before adding disu,susp,dire
$tot_cert_budgSubSub=number_format($subsub_cert_budg,2); // 2nd draft


$tot_park_reqSubSub=number_format($sub_park_req,2);
$req_amt=number_format($req_amt,2);
$park_req=number_format($park_req,2);

$link1="dbTable=inc_dec&center=$center&ncas_acct=$acct&addRecord=Add+a+Record&ly=$spent3&desc=$park_acct_desc&fy_req=$fy3&lastFld=inc_decid&var=$inc_decid&px=$parkcode&scope=$scope";
$rcc=substr($center,4,4);
$varURL1="<a href='/budget/a/inc_dec.php?$link1'>$park_req</a>";

if($_SESSION[budget][level]>1){
$link2="dbTable=vendor_payments&account=$acct&rcc=$rcc&like[12]=Range&datenew=20040701*20050630&passAmt=$spent3";
$varURL2="<a href='/budget/a/portal_ven_pay.php?$link2' target='_blank'>vp</a>";}

$link3="dbTable=exp_rev&acct=$acct&center=$center&f_year=0405";
$varURL3="<a href='/budget/a/portal_ven_pay.php?$link3' target='_blank'>re</a>";

$cert_budg=number_format($cert_budg,2);

// Print individual lines
echo "
<tr><td valign='top'>$section</td><td valign='top'>$parkcode</td><td valign='top'>$center</td><td valign='top'>$acct</td> <td valign='top'>$park_acct_desc</td><td align='right' valign='top'>$spent1Form</td>
<td align='right' valign='top'>$spent2Form</td>
<td align='right' valign='top'>$spent3Form $varURL2 $varURL3</td>
<td align='right' valign='top'>$varURL1</td>";
if(isset($park_just)){$arrow=" -->";}else{$arrow="";}
echo "<td valign='top' valign='top'><font color='green'>$req_amt</font>$arrow $flag $new $park_just</td>";

//<td align='right' valign='top'>$disu_req</td>
echo "<td align='right' valign='top'$mark>$disu_display</td>
<td align='right' valign='top'>$susp_req</td>
<td align='right' valign='top'>$dire_req</td>
<td align='right' valign='top'>$cert_budg</td>
</tr>";
$disu_display="";
}

if($reportLevel>1){
if($printDISU!="y"){
$totParkReqform="<b>Last Year's Expenditure: ".$tot3Form."</b>";
$totDISUform=number_format($tot_disu_req,2);
}
echo "<tr bgcolor='#CCCCCC'><td align='right' colspan='5'>$now $park_acct_desc SubSubTotal:</td><td align='right'><b>$tot1Form</b></td><td align='right'><b>$tot2Form</b></td>
<td align='right'><b>$tot3Form</b></td>
<td align='right'><b>$tot_park_reqSubSub</b></td>
<td align='right'><b>$totParkReqform</b></td>
<td align='right'><b>$totDISUform</b></td>
<td align='right'><b>$tot_susp_reqSub</b></td>
<td align='right'><b>$tot_dire_reqSub</b></td>";
// <td align='right'><b>$tot_req_amtSub</b></td>  // 1st draft
echo "<td align='right'><b>$tot_cert_budgSubSub</b></td>
</tr>";
$tot1="";$tot2="";$tot3="";
$tot_disu_req="";$tot_susp_req="";$tot_dire_req="";
$sub_park_req="";$sub_req_amt="";$subsub_cert_budg="";
}

$tot_spent1=number_format($tot_spent1,2);
$tot_spent2=number_format($tot_spent2,2);
$tot_spent3=number_format($tot_spent3,2);
$tot_park_req=number_format($tot_park_req,2);
$tot_req_amt=number_format($tot_req_amt,2);
$tot_cert_budg=number_format($tot_cert_budg,2);

// This prints a SubTotal for the last Acct in a query
$totAcct1Form=number_format($totAcct1,2);
$totAcct2Form=number_format($totAcct2,2);
$totAcct3Form=number_format($totAcct3,2);
$totReqSubForm=number_format($totReqSub,2);
$totDISUSubForm=number_format($totDISUSub,2);
$totSUSPSubForm=number_format($totSUSPSub,2);
$totDIRESubForm=number_format($totDIRESub,2);
$totCERT_BUDGSubForm=number_format($sub_cert_budg,2);

echo "<tr bgcolor='#CCCCCC'>
<td align='right' colspan='5'><b>$prevAcct $park_acct_descPrev SubTotal: </b></td>
<td align='right'><b>$totAcct1Form</b></td>
<td align='right'><b>$totAcct2Form</b></td>
<td align='right'><b>$totAcct3Form</b></td>
<td align='right'><b>$totReqSubForm</b></td>
<td align='right'><b>$totAcct3Form</b></td>
<td align='right'><b>$totDISUSubForm</b></td>
<td align='right'><b>$totSUSPSubForm</b></td>
<td align='right'><b>$totDIRESubForm</b></td>
<td align='right'><b>$totCERT_BUDGSubForm</b></td>
</tr>

<tr><td></td><td></td><td></td><td></td><td align='right'><b>Grand Totals:</b></td><td align='right'>$tot_spent1</td>
<td align='right'>$tot_spent2</td>
<td align='right'>$tot_spent3</td>
<td align='right'>$tot_park_req</td>
<td align='right'><font color='green'>$tot_req_amt</font></td>
<td></td>
<td></td>
<td></td>
<td>$tot_cert_budg</td>
</tr>";

echo "</table></body></html>";
}

?>