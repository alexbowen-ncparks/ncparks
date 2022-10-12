<?php
ini_set('display_errors',1);
session_start();
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../include/activity.php");
include("../inc/set_timezone.php");
extract($_REQUEST);
echo "<br />WELCOMES to ReportPARTF.php<br />";
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

if(isset($s1))
	{
	$sortby=$s1;}
	else
	{
	@$sortby=$s;
	}

if(($submit=="Find" AND @$rep=="")||$submit=="Update"){ // A kludge to allow editing of Active from Display
if(@$display==1){include("update.php");
updateActive($partfid,$active,$displaySQL);}
if(@$display==2){include("update.php");
updateShowPA($partfid,$showPA,$displaySQL);}
}

if(@$rep=="")
	{
	$sql = "OPTIMIZE TABLE `partf_fund_trans`,`partf_payments`,`partf_projects`";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	
	$year=date("Y");
	$month=date("m")-1;
	$fullMonth=date("F", mktime(0,0,0,$month,1,$year));
	$month=str_pad(date("m")-1,2,"0",STR_PAD_LEFT);
	if(!$start){$start=$year.$month."01";}
	
	$cont="true";$test=27;// get last day of a given month
	while(($test<=32)&&($cont)){
	$cont=checkdate($month,$test,$year);
	if(!$cont){$lastday=$test-1;} 
	$test++;}
	if(!$end){$end=$year.$month.$lastday;}
	
	include_once("menu.php");
	$ck2="checked";
	echo "
	<div align='center'><form action='ReportPARTF.php'><table><tr>
	
	<td><input type='text' name='park' value='' size='5'><b>Park</b></td>
	<td><input type='text' name='proj_man' value='' size='3'><b>MGR</b></td>
	
	<td><input type='radio' name='allRecords' value='partf' $ck2><b>PARTF Report</b></td>";
	
	$sortArray=array("Show_DPR"=>"active DESC","Show_PA"=>"showpa DESC","Proj_Number"=>"partf_projects.projNum","Center"=>"partf_projects.Center","Park"=>"fullname","Phase_Design"=>"design","Phase_Construction"=>"construction","Manager"=>"proj_man","Cal_YR_Fund"=>"YearFundC","Cal_YR_Fund_Desc"=>"YearFundC DESC","Fiscal_YR_Fund"=>"YearFundF","District"=>"dist","Start_Date"=>"startdate","End_Date"=>"enddate");
	
	echo "<td>Sort First by:<br><select name='sort1'>";
	echo "<option selected=''></option>\n";
	foreach($sortArray as $k=>$v){
	echo "<option value='$v'>$k</option>\n";}
	echo "</select></td>";
	
	echo "<td>Sort Second by:<br><select name='sort2'>";
	echo "<option selected=''></option>\n";
	foreach($sortArray as $k=>$v){
	echo "<option value='$v'>$k</option>\n";}
	echo "</select></td>";
	
	echo "<td>Sort Third by:<br><select name='sort3'>";
	echo "<option selected=''></option>\n";
	foreach($sortArray as $k=>$v){
	echo "<option value='$v'>$k</option>\n";}
	echo "</select></td>";
	
	echo "</tr><tr>
	<td align='center' colspan='3'>LIMIT report to:<br>CI:<input type='checkbox' name='limitCI' value='X'>
	DE:<input type='checkbox' name='limitDE' value='X'> EN:<input type='checkbox' name='limitEN' value='X'> ER:<input type='checkbox' name='limitER' value='X'><BR>
	LA:<input type='checkbox' name='limitLA' value='X'>
	MI:<input type='checkbox' name='limitMI' value='X'> MM:<input type='checkbox' name='limitMM' value='X'> TM:<input type='checkbox' name='limitTM' value='X'>
	</td>
	<td>Start Date (yyyymmdd):<br><input type='text' name='start' size='10' value='$start'></td>
	<td>End Date (yyyymmdd):<br><input type='text' name='end' size='10' value='$end'></td>";
	
	
	if(!$reportMonth){$reportMonth=$month.", ".$year;}
	echo "<td>Current Report Month:<br><input type='text' name='reportMonth' size='10' value='$reportMonth'>";
	
	echo "<input type='submit' name='submit' value='Find'></form></td></tr></table>
	<form></div>";}
	
if($submit=="")
	{
	exit;
	}
	else
	{
	if(!isset($displaySQL)){$displaySQL=$_SERVER['QUERY_STRING'];
	}

}
// ************ A lot happens HERE partf_fund_total.php ***********
include_once("partf_fund_total.php");

if($allRecords=="all"){
$where="where datePost!=''"; 
$fldPARTF="tempPARTF";}
else{
//echo "Y";exit;
$where="where reportDisplay='Y' and datePost!=''";
$fldPARTF="tempPARTF";}

		
// ***************default:
$orderby="ORDER BY comp,YearFundC DESC,partf_projects.Center";
IF(@$s1!=""){
//*********** SWITCH ***************
	switch ($sortby) {
		case "active":
		$orderby="ORDER BY active DESC,YearFundC DESC,partf_projects.Center";
			break;	
		case "showpa":
		$orderby="ORDER BY showpa DESC,YearFundC DESC,partf_projects.Center";
			break;	
		case "projNum":
		$orderby="ORDER BY projNum";
			break;	
		case "Center":
		$orderby="ORDER BY partf_projects.Center";
			break;	
		case "park":
		$orderby="ORDER BY fullname,partf_projects.projNum";
			break;	
		case "design":
		$orderby="ORDER BY design,construction";
			break;	
		case "construction":
		$orderby="ORDER BY construction,design";
			break;	
		case "proj_man":
		$orderby="ORDER BY proj_man,partf_projects.projNum";
			break;	
		case "YearFundC":
		$orderby="ORDER BY YearFundC,partf_projects.projNum";
			break;	
		case "YearFundCD":
		$orderby="ORDER BY YearFundC DESC,partf_projects.projNum";
			break;	
		case "YearFundF":
		$orderby="ORDER BY YearFundF,partf_projects.projNum";
			break;	
		case "dist":
		$orderby="ORDER BY dist,park,partf_projects.projNum";
			break;	
		case "startdate":
		$orderby="ORDER BY startdate,partf_projects.projNum";
			break;	
		case "enddate":
		$orderby="ORDER BY enddate,partf_projects.projNum";
			break;	
	}// end SWITCH
}// end IF $s1 not empty

ELSE  // $s1 = empty
{
if(@$sort1){$orderby="ORDER BY $sort1";}
if(@$sort2){$orderby.=",$sort2";}
if(@$sort3){$orderby.=",$sort3";}
}

// Get Info for All Account and credit

//echo "<pre>";print_r($_REQUEST);exit;
//print_r($_SESSION);echo "</pre>";

if($allRecords=="all"){
$select="partf_projects.projNum,".$fldPARTF.".credit,YearFundC,Center,budgCode,comp,proj_man,YearFundF,fullname,dist,county,projName,projCat,startDate,endDate,design,construction,statusPer,comments
From partf_projects 
LEFT JOIN $fldPARTF on partf_projects.projNum=".$fldPARTF.".projNum
GROUP BY partf_projects.projNum
$orderby";
}
else{
if(@$rep=="pdf"){

$where="where reportDisplay='Y'";
if($f=="pdf_dpr"){$where.=" and active='Y'";
if(@$park){$where.=" and park='$park'";}
if(@$proj_man){$where.=" and proj_man='$proj_man'";}
@$check_limit=$limitCI.$limitDE.$limitEN.$limitER.$limitLA.$limitMI.$limitMM.$limitTM;
IF(@$check_limit)
	{
	$where.=" AND (";
	if(@$limitCI){$where.="projcat='CI' OR ";}
	if(@$limitDE){$where.="projcat='DE' OR ";}
	if(@$limitEN){$where.="projcat='EN' OR ";}
	if(@$limitER){$where.="projcat='ER' OR ";}
	if(@$limitLA){$where.="projcat='LA' OR ";}
	if(@$limitMI){$where.="projcat='MI' OR ";}
	if(@$limitMM){$where.="projcat='MM' OR ";}
	if(@$limitTM){$where.="projcat='TM' OR ";}
	$where=trim($where," OR ");
	$where.=")";}
	}

if(@$f=="pdf_pa"){$where.=" and showpa='Y'";
if(@$park){$where.=" and park='$park'";}
if(@$proj_man){$where.=" and proj_man='$proj_man'";}
@$check_limit=$limitCI.$limitDE.$limitEN.$limitER.$limitLA.$limitMI.$limitMM.$limitTM;
IF(@$check_limit)
	{
	$where.=" AND (";
	if(@$limitCI){$where.="projcat='CI' OR ";}
	if(@$limitDE){$where.="projcat='DE' OR ";}
	if(@$limitEN){$where.="projcat='EN' OR ";}
	if(@$limitER){$where.="projcat='ER' OR ";}
	if(@$limitLA){$where.="projcat='LA' OR ";}
	if(@$limitMI){$where.="projcat='MI' OR ";}
	if(@$limitMM){$where.="projcat='MM' OR ";}
	if(@$limitTM){$where.="projcat='TM' OR ";}
	$where=trim($where," OR ");
	$where.=")";}}
if($f=="pdf_all"){
// no additional where clause
}

//echo "<pre>";print_r($_REQUEST);echo "</pre>$where";exit;
}else{
$where="where reportDisplay='Y'";
if(@$park){$where.=" and park='$park'";}
if(@$proj_man){$where.=" and proj_man='$proj_man'";}
@$check_limit=$limitCI.$limitDE.$limitEN.$limitER.$limitLA.$limitMI.$limitMM.$limitTM;
IF(@$check_limit)
	{
	$where.=" AND (";
	if(@$limitCI){$where.="projcat='CI' OR ";$passLimit[]="CI";}
	if(@$limitDE){$where.="projcat='DE' OR ";$passLimit[]="DE";}
	if(@$limitEN){$where.="projcat='EN' OR ";$passLimit[]="EN";}
	if(@$limitER){$where.="projcat='ER' OR ";$passLimit[]="ER";}
	if(@$limitLA){$where.="projcat='LA' OR ";$passLimit[]="LA";}
	if(@$limitMI){$where.="projcat='MI' OR ";$passLimit[]="MI";}
	if(@$limitMM){$where.="projcat='MM' OR ";$passLimit[]="MM";}
	if(@$limitTM){$where.="projcat='TM' OR ";$passLimit[]="TM";}
	$where=trim($where," OR ");
	$where.=")";
	}
}

$select="partf_projects.projNum,".$fldPARTF.".credit,YearFundC,Center,budgCode,comp,proj_man,YearFundF,fullname,dist,county,projName,projCat,startDate,endDate,design,construction,statusPer,comments,active,partfid,showPA,pj_timestamp,trackEndDate, trackStartDate, projCat, track_percentCom_con, track_percentCom_des, track_statusPer
From partf_projects 
LEFT JOIN $fldPARTF on partf_projects.projNum=".$fldPARTF.".projNum
$where
GROUP BY partf_projects.projNum
$orderby";
}

$sql = "SELECT $select";
//echo "$sql";exit;
$passSQL=$sql;

if(@$rep==""){
//echo "#1 $sql";//exit;
}else{
//echo "$sql";exit;
}

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
//$num=mysqli_num_rows($result);
while($row=mysqli_fetch_array($result))
	{
	extract($row);
	$arrayAllCredits[$projNum]=$credit;
	
	$tempVal=strlen($credit);// Length of name (used in PDF)
	if($tempVal>@$Creditwidth)
		{$Creditwidth=$tempVal;}
	
	$arrayYearFundC[$projNum]=$YearFundC;
	$arrayCenter[$projNum]=$Center;
	$arraybudgCode[$projNum]=$budgCode;
	$arraycomp[$projNum]=$comp;
	$arrayproj_man[$projNum]=$proj_man;
	$arrayYearFundF[$projNum]=$YearFundF;
	
	$arraypark[$projNum]=$fullname;
	$tempVal=strlen($fullname);// Length of name (used in PDF)
	if($tempVal>@$Parkwidth){$Parkwidth=$tempVal;}
	
	$arraydist[$projNum]=$dist;
	$arraycounty[$projNum]=$county;
	$tempVal=strlen($dist.", ".$county);// Length of name (used in PDF)
	if($tempVal>@$DCwidth){$DCwidth=$tempVal;}
	
	$test=strlen($projName);
	if($test>34){
	$projName=substr($projName,0,34).".";}
	$arrayprojName[$projNum]=$projName;
	$tempVal=strlen($projName);// Length of name (used in PDF)
	if($tempVal>@$PNwidth){$PNwidth=$tempVal;}
	
	$arrayprojCat[$projNum]=$projCat;
	
	$arraystartDate[$projNum]=$startDate;
	$arrayendDate[$projNum]=$endDate;
	
	$arraystatusDesign[$projNum]=$design;
	$arrayTrackDesign_complete[$projNum]=$track_percentCom_des;
	$arraystatusConstruct[$projNum]=$construction;
	$arrayTrackConstruct_complete[$projNum]=$track_percentCom_con;
	
	$arraystatusPer[$projNum]=$statusPer;
	$arrayTrackStatus[$projNum]=$track_statusPer;
	
	$arraycomments[$projNum]=$comments;
	$arrayActive[$projNum]=$active;
	$arrayshowPA[$projNum]=$showPA;
	$arrayPartfid[$projNum]=$partfid;
	$arrayPJ_TimeStamp[$projNum]=$pj_timestamp;
	$arrayTrackEndDate[$projNum]=$trackEndDate;
	$arrayTrackStartDate[$projNum]=$trackStartDate;
	}

//echo "$sql<pre>";print_r($arraystatusDesign);print_r($arraystatusConstruct);echo "</pre>";exit;

$sql = "SELECT sum( amount ) as cumAmountTot
FROM `partf_payments`
where datenew<='$end'";
//echo "<br />$sql";//exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);extract($row);

// Get ALL payments (only project numbers with payments are returned)
// Need to merge with All Accounts credit
// Added query just above which may have eliminated the need for this query?


if($end){$where=$where." and datenew<='$end' ";}

$select="partf_projects.projNum, sum(partf_payments.amount) as amt
From partf_projects 
LEFT JOIN partf_payments on partf_projects.projNum=partf_payments.charg_proj_num
$where
GROUP BY partf_projects.projNum
$orderby";

$sql = "SELECT $select";
//echo "<br><br>$sql";exit;

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
while($row=mysqli_fetch_array($result)){extract($row);
$arrayAllPayments[$projNum]=$amt;
$tempVal=strlen($amt);// Length of name (used in PDF)
if($tempVal>@$PFwidth){$PFwidth=$tempVal;}
}
//echo "$sql<pre>";print_r($arrayAllPayments);echo "</pre>";exit;

// Get SOME payments for date range (only project numbers with payments are returned)
// Need to merge with All Accounts credit

$where="where reportDisplay='Y'";
if($start){
$ce="Current Activity ($start - $end)";$where=$where." and datenew>='$start' ";}
if($end){$where=$where." and datenew<='$end' ";}

$select="partf_projects.*, sum(partf_payments.amount) as amt
From partf_projects 
LEFT JOIN partf_payments on partf_projects.projNum=partf_payments.charg_proj_num
$where
GROUP BY partf_projects.projNum
$orderby";


$sql = "SELECT $select";
if(@$rep=="")
{
//echo "<br><br>line 375 $sql<br>";//exit;
}//else{echo "<br><br>$sql<br>";exit;}
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);

if($num==0){echo "<font color='red'>Report not valid. No data available for period requested.</font>";exit;}
while($row=mysqli_fetch_array($result)){
extract($row);

$arraySomePayments[$projNum]=$amt;
$tempVal=strlen($amt);// Length of name (used in PDF)
if($tempVal>@$Expensewidth){$Expensewidth=$tempVal;}

// don't send $partf_approv_num use funds.credit instead
}// end while


$year=substr($end,0,4);$month=substr($end,4,2);$day=substr($end,6,2);
$thruDate=strtoupper(date("F d, Y",mktime("0","0","0",$month,$day,$year)));

if(@$rep=="pdf")
	{//echo "Y";exit;
	if($f=="pdf_dpr"){include("reports/DPR_pdf.php");}
	if($f=="pdf_pa"){include("reports/PA_pdf.php");}
	if($f=="pdf_all"){include("reports/DPR_pdf.php");}
	if($f==""){echo "null";exit;}
	}
else
	{
	if(@$rep=="excel")
		{// $passLimit
		include("reports/excelDDP.php");
		}
		else
		{
		include("reports/displayDDP.php");
		}
	}

?>