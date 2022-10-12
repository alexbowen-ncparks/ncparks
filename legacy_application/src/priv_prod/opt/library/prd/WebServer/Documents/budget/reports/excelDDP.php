<?php
/*
echo "$sql<br>test<pre>";
//print_r($projFundIn);
print_r($projFundOut);
echo "</pre>";//exit;
*/

makeReportHeader($reportMonth,@$rep);

while(list($key,$val)=each($arrayAllCredits))
	{
	
	$projNum=$key;
	makeReport($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$fullname,$projName,$arrayActive,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$res_proj,$partfyn,$femayn,$fema_proj_num,$mult_proj,$arrayPartfid,$amt,$credit,$ce,$arrayAllPayments,$arrayAllCredits,$arraySomePayments, $arrayYearFundC,$arrayCenter,$arraybudgCode,$arraycomp,$arrayproj_man,$arrayYearFundF,$arraypark,$arraydist,$arraycounty,$arrayprojName,$arraystartDate,$arrayendDate,$arraystatusDesign,$arraystatusConstruct,$arraystatusPer,$arraycomments,$projFundIn,$projFundOut,$displaySQL,$arrayshowPA,$projFundOutMonth,$arrayTrackEndDate);
	}

//echo "$sql<pre>";print_r($_SERVER);echo "</pre>";exit;
//echo "$sql<pre>";print_r($projFundIn);print_r($projFundOut);echo "</pre>";exit;

if(@$rep=="")
	{
	$a_menu=array("pdf_dpr","pdf_pa","pdf_all");
	$sql=$_SERVER['QUERY_STRING'];
	echo "<br><a href='ReportPARTF.php?$sql&rep=excel'>Excel Export</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<form><select name=\"contract\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select PDF file</option>";$s="value";
	for ($n=0;$n<count($a_menu);$n++){
	$con=urlencode($a_menu[$n]);
	$item=strtoupper($a_menu[$n]);
			echo "<option $s='ReportPARTF.php?$sql&rep=pdf&f=$con'>$item\n";
		   }
	   echo "</select></form>";
	   }

//echo "$sql"; exit;

// ***************** FUNCTIONS **************

function sortCol($fld0,$fld1,$fld2){
global $displaySQL;
if($fld0==""){
$sort=$fld1; if($fld2){$sort=$sort.",".$fld2;}
$varName="Sort";$BR="<br>";
if($sort=="YearFundCD"){$varName="D";}
if($sort=="YearFundC"){$varName="A";$BR=" - ";}
if($sort=="design"){$sort="design";$varName="D=DESIGN";}
if($sort=="construction"){$sort="construction";$varName="C=CONST";}
echo "<a href='ReportPARTF.php?$displaySQL&s1=$sort'>$varName</a>$BR";}
}

function sumCol($fld0,$fld1){
if($fld0==""){
echo "<a href='ReportPARTF.php?g=$fld'>Group<br></a>";}
}


function formatMoney($fm){
$value=number_format($fm,2);
return $value;
}

// Header
function makeReportHeader($reportMonth,$rep)
	{
	global $month,$year,$passLimit;
	$editFunds="<a href='editFunds.php'>FUNDS</a>";
	if(@$rep=="excel")
		{
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=DDPreport.xls');
		$editFunds="";
		}
	
	echo "<table border='1'>";
	if($passLimit){echo "<tr><td>Projects for: </td>";
	foreach($passLimit as $k=>$v){
	if($v=="CI"){$v="capital improvements";}
	if($v=="DE"){$v="demolitions";}
	if($v=="EN"){$v="exhibits new";}
	if($v=="ER"){$v="exhibits repair";}
	if($v=="LA"){$v="land acquistions";}
	if($v=="MI"){$v="miscellaneous";}
	if($v=="MM"){$v="major maintenance";}
	if($v=="TM"){$v="trail maintenance";}
	echo "<td>$v</td>";}
	echo "</tr>";}
	echo "<tr>
	<th>ShowDPR</th>
	<th>ShowPA</th>
	<th>PROJ_NUMBER</th>
	<th>CAL_YEAR_OF_INITIAL_FUNDING</th>
	<th>CURR_CNTR</th>
	<th>CODE</th>
	<th>COMP</th>
	<th>MGR</th>
	
	<th>FISCAL_YR_OF_FUNDING</th>
	<th>PARK</th>
	<th>PARK_DISTRICT_COUNTY</th>
	<th>PROJECT NAME</th>";
	if($reportMonth){
	
	$shortMonth=date("M", mktime(0,0,0,$month,1,$year));
	$shortYear=date("y", mktime(0,0,0,$month,1,$year));
	echo "
	<th>Current_Month_Funds_$shortMonth-$shortYear</th>
	<th>Current_Month_Expenses_$shortMonth-$shortYear</th>";
	}
	echo "<th>TOTAL POSTED_FUNDS</th>
	<th>TOTAL POSTED_EXPENSES</th>
	<th>TOTAL POSTED_ENDING_BALANCE</th>
	<th>ESTIMATED_CONSTRUCTION_START_DATE</th>
	<th>ESTIMATED_CONSTRUCTION_END_DATE</th>
	<th>PHASE-% COMPLETE</th>
	<th>STATUS</th>
	</tr>";}


function makeReport($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$fullname,$projName,$arrayActive,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$res_proj,$partfyn,$femayn,$fema_proj_num,$mult_proj,$arrayPartfid,$amt,$credit,$ce,$arrayAllPayments,$arrayAllCredits,$arraySomePayments, $arrayYearFundC,$arrayCenter,$arraybudgCode,$arraycomp,$arrayproj_man,$arrayYearFundF,$arraypark,$arraydist,$arraycounty,$arrayprojName,$arraystartDate,$arrayendDate,$arraystatusDesign,$arraystatusConstruct,$arraystatusPer,$arraycomments,$projFundIn,$projFundOut,$displaySQL,$arrayshowPA,$projFundOutMonth,$arrayTrackEndDate)
{
global $reportMonth,$creditTot,$ceTot,$rep, $total_post_funds, $reportMonthFundsTot,$total_post_expenses,$totMonthIn, $totMonthOut;

$cumAmount=@$arrayAllPayments[$projNum];
$credit=@$arrayAllCredits[$projNum];
$amt=@$arraySomePayments[$projNum];
$fundMonth=@$projFundOutMonth[$projNum];


$creditTot=$creditTot+$credit;
$amtTot=@$amtTot+$amt;

$active=@$arrayActive[$projNum];
$showPA=@$arrayshowPA[$projNum];

$partfid=$arrayPartfid[$projNum];
$YearFundC=$arrayYearFundC[$projNum];
$Center=strtoupper($arrayCenter[$projNum]);
$budgCode=$arraybudgCode[$projNum];
$comp=$arraycomp[$projNum];
$proj_man=$arrayproj_man[$projNum];
$YearFundF=$arrayYearFundF[$projNum];
$fullname=$arraypark[$projNum];
$dist=$arraydist[$projNum];
$county1=$arraycounty[$projNum];
$projName=$arrayprojName[$projNum];
$startDate=$arraystartDate[$projNum];
$endDate=$arrayendDate[$projNum];

// Track changed value for:
// New Proj Num, EndDate
$newProj="";
$varEndDateN=$arrayendDate[$projNum];
$varEndDateO=$arrayTrackEndDate[$projNum];
// Check for a date change
if($varEndDateN!=$varEndDateO){$endDateDisplayO="1";$hiliteDisplay="x";
// Check for New Project Number
if($varEndDateO==""){$newProj="y";}
}
else{$endDateDisplayO="";$hiliteDisplay="";}


$design1=$arraystatusDesign[$projNum];
$construct1=$arraystatusConstruct[$projNum];


$construct1=$construct1+0;$design1=$design1+0;
if($construct1==""){
$statusDC="D-".$design1;}
else
{
$statusDC="C-".$construct1;}

$statusPer=$arraystatusPer[$projNum];
switch ($statusPer) {
		case "NS":
			$status = "NS";
			break;	
		case "IP":
			$status = "IP";
			break;	
		case "OH":
			$status = "OH";
			break;	
		case "FI":
			$status = "FI";
			break;	
	}
	
$comments=$arraycomments[$projNum];

//$statusPer=$arraystatusPer[$projNum];

//$dif=($credit-$amt);   5
$dif=($credit-$cumAmount);

if($dif<0){$tb="<font color='red'>";$te="</font>";}else{$tb="";$te="";}
$dif=formatMoney($dif);
if($dif==0){$dif="-&nbsp;&nbsp;&nbsp;&nbsp;";}

$total_post_expenses=$total_post_expenses+$cumAmount;
$cumAmount=formatMoney($cumAmount);
if($cumAmount==0){$cumAmount="-&nbsp;&nbsp;&nbsp;&nbsp;";}

$ceTot=$ceTot+$amt;
if($amt<0){
// testing $amtNeg=$amt;if($projNum=="1041"){echo "a=$amt";exit;}
$amt="<font color='red'>".formatMoney($amt)."</font>";
}else{$amt=formatMoney($amt);}

if($amt=="0.00"){$amt="-&nbsp;&nbsp;&nbsp;&nbsp;";}

// Decide whether to make links or not
if(@$rep==""){
if($projFundOut[$projNum]){$fundOut=$projFundOut[$projNum];}
if($projFundIn[$projNum]){$fundIn=$projFundIn[$projNum];}
$projNumLink="<a href='partf_payments.php?proj_num=$projNum&submit=Find'>$projNum</a>";
$CenterLink="<a href='partf_payments.php?center=$Center&submit=Find'>$Center</a>";
$postLink=formatMoney($credit,2);
$varFundIn=formatMoney($credit,2);
$postLink="<a href='editFunds.php?proj_in=$projNum&post=1&find=Find'>$varFundIn</a>";
$total_post_funds=$total_post_funds+$credit;
}
else
{
$Center="<font color='white'>`</font>".strtoupper($Center);// for Excel
if(@$projFundOut[$projNum]){$fundOut=$projFundOut[$projNum];}
if(@$projFundIn[$projNum]){$fundIn=$projFundIn[$projNum];}
$projNumLink=$projNum;
$CenterLink=$Center;
$postLink=formatMoney($credit,2);

$total_post_funds=$total_post_funds+$credit;
}

// This kludge is necessary to get "4e72" to not display in sci. notation in Excel
$Center="<font color='white'>`</font>".strtoupper($Center);

// This kludge is necessary to get "04/05" to not display in sci. notation in Excel
$YearFundF="<font color='white'>`</font>".$YearFundF;

$fullname=strtoupper($fullname);
$dist=strtoupper($dist);$county1=strtoupper($county1);
if($county1=="NA"){$county1="";}else{$county1=", ".$county1;}
if($dist=="STWD"){$dist="STATEWIDE";}else{$county="";}
$projName=strtoupper($projName);

// This is necessary because IE doesn't respond to the checkbox alone
$browser=$_SERVER['HTTP_USER_AGENT'];$pos = strpos($browser,'MSIE');
$active=strtoupper($active);
if($pos>0){$IEdpr=$active;}
if($active=="Y"){$checkedDPR="checked";
@$showDPR="<a href='ReportPARTF.php?display=1&partfid=$partfid&submit=Update&displaySQL=$displaySQL&active=N'><input type='checkbox' name='active' value='N' $checkedDPR>$IEdpr</a>";}
else
{
@$showDPR="<a href='ReportPARTF.php?display=1&partfid=$partfid&submit=Update&displaySQL=$displaySQL&active=Y'><input type='checkbox' name='active' value='Y' $checkedDPR>$IEdpr</a>";}

$showPA=strtoupper($showPA);
if($pos>0){$IEpa=$showPA;}
if($showPA=="Y"){$checkedPA="checked";
@$showPAcheck="<a href='ReportPARTF.php?display=2&partfid=$partfid&submit=Update&displaySQL=$displaySQL&showPA=N'><input type='checkbox' name='showPA' value='N' $checkedPA>$IEpa</a>";}
else
{
@$showPAcheck="<a href='ReportPARTF.php?display=2&partfid=$partfid&submit=Update&displaySQL=$displaySQL&showPA=Y'><input type='checkbox' name='showPA' value='Y' $checkedPA>$IEpa</a>";}

if(@$rep=="excel"){$showDPR=$active;$showPAcheck=$showPA;}
echo "<tr>
<td align='center'>$showDPR</td>
<td align='center'>$showPAcheck</td>";
if($hiliteDisplay){$b1="<b>";$b2="</b>";}else{$b1="";$b2="";}
echo "<td align='center'>$b1$projNumLink$b2</td>
<td align='center'>$YearFundC</td>
<td align='center'>$CenterLink</td>
<td align='center'>$budgCode</td>
<td align='center'>$comp</td>
<td align='center'>$proj_man</td>
<td align='center'>$YearFundF</td>
<td align='center'>$fullname</td>
<td align='center'>$dist$county1</td>
<td>$projName</td>";

// 1 Monthly Funds  IN or OUT
if($reportMonth)
	{
	if(@$projFundOut[$projNum])
	{$fundOut=@$projFundOut[$projNum];}
	else{$fundOut="";}
	
	if(@$projFundIn[$projNum])
	{$fundIn=@$projFundIn[$projNum];}
	else{$fundIn="";}
	
	if(@$projFundOut[$projNum] || @$projFundIn[$projNum])
	{
	$reportMonthFundsTot=$reportMonthFundsTot+($fundIn-$fundOut);
	
	$fundInOut=formatMoney($fundIn-$fundMonth);}
	
	else{$fundInOut="-&nbsp;&nbsp;&nbsp;";}
	$totMonthIn=$totMonthIn+$fundIn;
	$totMonthOut=$totMonthOut+$fundOut;
	
	if($fundInOut<0)
	{$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}
	if($fundInOut=="0.00"){$fundInOut="-&nbsp;&nbsp;&nbsp;";}
	echo "<td align='right'>$f1$fundInOut$f2</td>";
	}
// 2 Monthly Expense
if($ce){
// testing if($projNum=="1041"){$zzz=$amtNeg;}else{$zzz="";}
echo "<td align='right'>$amt</td>";}

// 3 Total Posted Funds
echo "<td align='right'>$postLink</td>";

// 4 Total Posted Expenses
echo "<td align='right'>$cumAmount</td>";

// 5 Total Ending Balance
echo "<td align='right'>$tb$dif$te</td>";

if($startDate=="na"||$startDate=="NA"||$startDate==""){}else
{$startDate=substr($startDate,4,2)."/".substr($startDate,6,2)."/".substr($startDate,0,4);
$endDate=substr($endDate,4,2)."/".substr($endDate,6,2)."/".substr($endDate,0,4);}
echo "<td align='center'>$startDate</td>";

if($endDateDisplayO!=""){$d1="<b>";$d2="</b>";}
else{$d1="";$d2="";}

if(!isset($status)){$status="";}
echo "<td align='center'>$d1$endDate$d2</td>
<td align='center'>$statusDC</td>
<td align='center'>$status</td>
</tr>";
}

// $cumAmountTot from line 202 of ReportPARTF.php
$difTot=$totalFund-$cumAmountTot;
$creditTot=number_format($creditTot,2);
$cumAmountTot=number_format($cumAmountTot,2);
$difTot=number_format($difTot,2);
$ceTot=number_format($ceTot,2);
$reportMonthFundsTot=number_format($reportMonthFundsTot,2);

$total_post_end_bal=$total_post_funds-$total_post_expenses;
$total_post_end_bal=number_format($total_post_end_bal,2);
$total_post_funds=number_format($total_post_funds,2);
$total_post_expenses=number_format($total_post_expenses,2);

$start=substr($start,4,2)."/".substr($start,6,2)."/".substr($start,0,4);
$end=substr($end,4,2)."/".substr($end,6,2)."/".substr($end,0,4);

$totMonthIn=number_format($totMonthIn,2);
$totMonthOut=number_format($totMonthOut,2);

if($allRecords=="all"){}else{
$dm="<tr><td colspan='3'>&nbsp;</td><td>Posted from $start to $end </td><td align='right'>Funds: (In $totMonthIn) - (Out $totMonthOut) = <b>$reportMonthFundsTot</b> </td>
<td align='right'>Expenses: <b>$ceTot</b></td></tr>";}

$totalFund=number_format($totalFund,2);
echo "</table><div align='center'>
<table border='1' cellpadding='5'>
$dm
<tr><td colspan='3'>&nbsp;</td><td align='right'>(table) Posted thru $end </td>
<td>Total Funds <b>$totalFund</b></td>";
echo "<td>Total Expenses: <b>$cumAmountTot</b></td>";
echo "<td>Ending Balance: <b>$difTot</b></td>
</tr>
<tr><td colspan='3'>&nbsp;</td><td align='right'>(display) Posted thru $end </td>
<td>Total Funds <b>$total_post_funds</b></td>";
echo "<td>Total Expenses: <b>$total_post_expenses</b></td>";
echo "<td>Ending Balance: <b>$total_post_end_bal</b></td>

</tr>";
echo "</table></div></body></html>";
?>