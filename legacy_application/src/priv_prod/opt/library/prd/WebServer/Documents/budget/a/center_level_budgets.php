<?php
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
include("../../../include/activity.php");
extract($_REQUEST);
//print_r($_REQUEST);
//print_r($_SESSION);
// Construct Query to be passed to Excel Export
$budget_group_menuEncode=urlencode($budget_group_menu);
$varQuery="submit=Submit&center=$center&track_rcc_menu=$track_rcc_menu&acct_cat_menu=$acct_cat_menu&budget_group_menu=$budget_group_menuEncode&f_year=$f_year";


// workaround to extract just the center when resubmitting form with center
// pulldown already has a selected value
// not sure why only the center is not returned
$pos=strpos($center,"-");
if($pos){$findCenter=explode("-",$center);$center=$findCenter[2];}
//echo "c=$center";
// convert track_rcc_menu
if($track_rcc_menu=="Yes"){$track_rcc_menu="y";}
if($track_rcc_menu=="No"){$track_rcc_menu="n";}
// convert acct_cat_menu
if($acct_cat_menu=="Expense"){$acct_cat_menu="exp";}
if($acct_cat_menu=="Revenue"){$acct_cat_menu="rev";}
if($acct_cat_menu=="Funding"){$acct_cat_menu="fun";}

// Creates the last 4 Fiscal Years - Used in queries
//echo "<br >Line 31: f_year=$f_year<br />";
//$f_year='';
if($f_year==""){
include("../~f_year.php");
}
	else
	{
		$yx=substr($f_year,0,2);
		$year2="20".$yx;
		$year3=$year2+1;
	}

$y0=substr($year2-3,2,4);
$y1=substr($year2-2,2,4);$py3=$y0.$y1;
$y2=substr($year2-1,2,4);$py2=$y1.$y2;
$y3=substr($year2,2,4);$py1=$y2.$y3;
$y4=substr($year3,2,4);$cy=$y3.$y4;

echo "py3=$py3 py2=$py2 py1=$py1 cy=$cy";
//echo  "<br><br>f_year=$f_year";// y2=$year2 y3=$year3 y4=$y4 y3=$y3 y2=$y2 y1=$y1
//echo "<br><br>today=$today compare=$compare testMonth=$testMonth";//exit;
//print_r($_SESSION);//EXIT;
//print_r($_REQUEST);//EXIT;

// Get most recent date from Exp_Rev
$sql="SELECT DATE_FORMAT(max(acctdate),'Report Date: %c/%e/%Y') as maxDate, DATE_FORMAT(max(acctdate),'%Y%m%d') as maxDate1 FROM `exp_rev` WHERE 1";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 0. $sql");
$row=mysqli_fetch_array($result);
extract($row);

if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=center_level_budgets.xls');
}

// Get menu values for Budget Group
$sql="SELECT  DISTINCT budget_group
FROM coa
WHERE budget_group !=  'reserves' AND budget_group !=  'funding'
ORDER  BY budget_group";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
$bgArray[]=$row[budget_group];
}

// *********** Level > 2 ************
if($_SESSION[budget][level]>2){//print_r($_REQUEST);EXIT;
$sql="SELECT  DISTINCT section FROM  `center`";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);
$sectArray1[]="sect-x-".$section;
$sectArray2[]=ucfirst($section)."(ALL)-NCAS#";
$sectArray3[]="sect-y-".$section;
$sectArray4[]=ucfirst($section)."(ALL)-ParkCode";
}

if($rep==""){
include_once("../menu.php");
echo "<table align='center'><form action=\"center_level_budgets.php\">";

// Menu 000
echo "<td>Budget Group: <select name=\"budget_group_menu\">"; 
for ($n=0;$n<count($bgArray);$n++){
$con=$bgArray[$n];
if($budget_group_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$bgArray[$n]\n";
       }
   echo "</select></td>";

// Menu 0
$array1=array("y","n");
$array2=array("Yes","No");

echo "<td>Track RCC: <select name=\"track_rcc_menu\"><option selected></option>"; 
for ($n=0;$n<count($array1);$n++){
$con=$array1[$n];
if($track_rcc_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$array2[$n]\n";
       }
   echo "</select></td>";

// Menu 1
$array1=array("exp","rev","fun");
$array2=array("Expense","Revenue","Funding");

echo "<td>Account Category: <select name=\"acct_cat_menu\"><option selected></option>"; 
for ($n=0;$n<count($array1);$n++){
$con=$array1[$n];
if($acct_cat_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$array2[$n]\n";
       }
   echo "</select></td>";


// Menu 2
$sql="SELECT section,parkcode,center as varCenter from center where fund='1280' order by section,parkcode,center";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$pc[]=$parkcode;$c[]=$varCenter;$sec[]=$section;}

echo "<td><select name=\"center\"><option selected>Select Center</option>";
for ($n=0;$n<count($c);$n++){
if($center==$c[$n]){$s="selected";}else{$s="value";}
$con=$c[$n];
		echo "<option $s='$con'>$sec[$n]-$pc[$n]-$c[$n]</option>\n";
       }
If($level<4){$roFY="READONLY";}
 
   echo "</select> FY <input type='text' name='f_year' value='$f_year' size='5'$roFY>
<input type='hidden' name='m' value='$m'>
<input type='hidden' name='report' value='$report'>
<input type='submit' name='submit' value='Submit'>";
if($level==5){echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' name='showSQL' value='1'>Show SQL";}
echo "</form></td></tr></table>";
}
if($center==""){exit;}
}// end Level > 2


// ************* Level 2 *****************
if($_SESSION[budget][level] == 2){
//print_r($_REQUEST);EXIT;
if($rep==""){
include_once("../menu.php");
include_once("../../../include/parkRCC.inc");

$distCode=$_SESSION[budget][select];
echo "<table align='center'><form action=\"center_level_budgets.php\">";
switch($distCode){
case "EADI":
$distCode="east";
break;
case "NODI":
$distCode="north";
break;
case "SODI":
$distCode="south";
break;
case "WEDI":
$distCode="west";
break;
}
$D=$distCode."-NCAS";
$DP=$distCode."-PARK";

$array1=array($D,$DP);

$where="where dist='$distCode' and section='operations' and fund='1280'";

$sql="SELECT section,parkcode,center as varCenter from center $where order by section,parkcode,center";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$pc[]=$parkcode;$c[]=$varCenter;$sec[]=$section;}

echo "<table align='center'><form><tr>";
// Menu 000

echo "<td>Budget Group: <select name=\"budget_group_menu\">"; 
for ($n=0;$n<count($bgArray);$n++){
$con=$bgArray[$n];
if($budget_group_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$bgArray[$n]\n";
       }
   echo "</select></td>";
   
// Menu 0
$array1=array("y","n");
$array2=array("Yes","No");
echo "<td>Track RCC: <select name=\"track_rcc_menu\"><option selected></option>"; 
for ($n=0;$n<count($array1);$n++){
$con=$array1[$n];
if($track_rcc_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$array2[$n]\n";
       }
   echo "</select></td>";

// Menu 1
$array1=array("exp","rev","fun");
$array2=array("Expense","Revenue","Funding");

echo "<td>Account Category: <select name=\"acct_cat_menu\"><option selected></option>"; 
for ($n=0;$n<count($array1);$n++){
$con=$array1[$n];
if($acct_cat_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$array2[$n]\n";
       }
   echo "</select></td>";

echo "<td><select name=\"center\"><option selected>Select Center</option>";
for ($n=0;$n<count($c);$n++){
$con=$c[$n];
if($center==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$sec[$n]-$pc[$n]-$c[$n]\n";
       }
   echo "</select>  FY <input type='text' name='f_year' value='$f_year' size='5' READONLY>
<input type='hidden' name='report' value='$report'><input type='submit' name='submit' value='Submit'></td></form></tr></table>";
}

if($center==""){exit;}
}// end Level = 2


// *********** Level 1 ************
if($_SESSION[budget][level]==1){

if($rep==""){

//include_once("../menu.php");
include_once("../../../include/parkcountyRCC.inc");
//include_once("subDist.php");

$center=$_SESSION[budget][centerSess];

echo "<table align='center'><form><tr>";
// Menu 000

echo "<td>Budget Group: <select name=\"budget_group_menu\">"; 
for ($n=0;$n<count($bgArray);$n++){
$con=$bgArray[$n];
if($budget_group_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$bgArray[$n]\n";
       }
   echo "</select></td>";
   
// Menu 0
$array1=array("y","n");
$array2=array("Yes","No");

echo "<td>Track RCC: <select name=\"track_rcc_menu\"><option selected></option>"; 
for ($n=0;$n<count($array1);$n++){
$con=$array1[$n];
if($track_rcc_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$array2[$n]\n";
       }
   echo "</select></td>";

// Menu 1
$array1=array("exp","rev","fun");
$array2=array("Expense","Revenue","Funding");

echo "<td>Account Category: <select name=\"acct_cat_menu\"><option selected></option>"; 
for ($n=0;$n<count($array1);$n++){
$con=$array1[$n];
if($acct_cat_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$array2[$n]\n";
       }
   echo "</select></td>";

   echo "<td> FY <input type='text' name='f_year' value='$f_year' size='5' READONLY>
<input type='hidden' name='parkcode' value='$parkcode'>
<input type='hidden' name='report' value='$report'><input type='submit' name='submit' value='Submit'></form></td>";
}

}// end Level = 1

/* Get most recent FY from act3. This will determine whether INSERTS are needed  */
 $query = "SELECT max(f_year) as checkFY from `act3`";
 $result = @mysqli_query($connection, $query,$connection);
 $row=mysqli_fetch_array($result);extract($row);
//echo "$query<br><br>";
 
if($f_year!=$checkFY){
 $query = "truncate table `act3`";
    $result = @mysqli_query($connection, $query,$connection);
//echo "$query<br><br>";

/*inserts ACCT-CENTER amount totals from exp_rev table for PY3  */
 $query = "INSERT INTO act3( ncasnum,center,amount_PY3, amount_PY2, amount_PY1, amount_CY, allocation_amount,f_year )
SELECT acct, center, sum( debit - credit ), '', '', '', '', f_year
FROM `exp_rev`
WHERE 1 AND f_year = '$py3'
GROUP BY acct, center";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}
//echo "$query<br><br>AND fund = '1280' ";

/*inserts ACCT-CENTER amount totals from exp_rev table for PY2  */
 $query = "INSERT INTO act3( ncasnum,center,amount_PY3, amount_PY2, amount_PY1, amount_CY, allocation_amount, f_year)
SELECT acct, center, '',sum( debit - credit ),'','','', f_year
FROM `exp_rev`
WHERE 1 AND f_year = '$py2'
GROUP BY acct, center";
  $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}
//echo "$query<br><br>AND fund = '1280' ";

/*inserts ACCT-CENTER amount totals from exp_rev table for PY1  */
 $query = "INSERT INTO act3( ncasnum,center,amount_PY3, amount_PY2, amount_PY1, amount_CY, allocation_amount, f_year)
SELECT acct, center, '','',sum( debit - credit ),'','', f_year
FROM `exp_rev`
WHERE 1 AND f_year = '$py1'
GROUP BY acct, center";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}
//echo "$query<br><br>AND fund = '1280' ";

$rangeStart="20".$y2."0701";
$monthDayMax=substr($maxDate1,4,4);
$prevYearMax=substr($maxDate1,0,4)-1;
$rangeEnd=$prevYearMax.$monthDayMax;
//$y=date(Y);$m=date(m);$d=date(d); 
//$dateEnd=mktime(0,0,0,$m,$d,$y-1);
//$rangeEnd=strftime("%Y%m%d",$dateEnd);

/*inserts ACCT-CENTER amount totals from exp_rev table for LYTT  */
 $query = "INSERT INTO act3( ncasnum,center,amount_PY3, amount_PY2, amount_PY1, amount_CY, allocation_amount,authorized_budget_cy,f_year,amount_LYTT )
SELECT acct, center, '','','','','','','',sum(debit-credit)
FROM `exp_rev`
WHERE 1 AND f_year = '$py1'
and acctdate >='$rangeStart' and acctdate <= '$rangeEnd'
GROUP BY acct, center";
 $result = @mysqli_query($connection, $query,$connection);
//echo "$query<br><br>AND fund = '1280' ";

/*inserts ACCT-CENTER amount totals from exp_rev table for CY  */
 $query = "INSERT INTO act3( ncasnum,center,amount_PY3, amount_PY2, amount_PY1, amount_CY, allocation_amount, f_year)
SELECT acct , center, '','','',sum( debit - credit ),'', f_year
FROM `exp_rev`
WHERE 1  AND f_year = '$cy'
GROUP BY acct, center";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}
//echo "$query<br><br>AND exp_rev.fund = '1280' ";

/*inserts ACCT-CENTER amount totals from budget_center_allocations for CY*/
 $query = "INSERT INTO act3( ncasnum,center,amount_PY3, amount_PY2, amount_PY1, amount_CY, allocation_amount, f_year)
SELECT ncas_acct,center,'','','','',sum( allocation_amount ), fy_req
FROM `budget_center_allocations`
WHERE 1 AND fy_req='$cy'
GROUP BY ncas_acct,center";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}
}
//echo "$query<br><br>";

$whereFilter="and act3.center='$center'";

if($budget_group_menu)
{$whereFilter.="and coa.budget_group='$budget_group_menu'";}

/*select query for center budgets*/
$sql="SELECT coa.track_rcc,coa.acct_cat,act3.ncasnum, coa.park_acct_desc AS description,  center.parkcode, act3.center, sum( act3.amount_py3 )  AS amount_py3, sum( act3.amount_py2 )  AS amount_py2, sum( act3.amount_py1 )  AS amount_py1, sum( act3.amount_py1 )   + sum( act3.allocation_amount ) - sum( act3.amount_py1 )  AS inc_cy, round( ( ( sum( act3.amount_py1 )  + sum( act3.allocation_amount )  - sum( act3.amount_py1 ) )  / ( sum( act3.amount_py1 )  + sum(  ' .01'  )  )  ) *100 ) AS inc_cy_perc, sum( act3.amount_py1 )  + sum( act3.allocation_amount ) AS request_cy, sum( act3.amount_cy )  AS amount_cy, sum( act3.amount_py1 )  + sum( act3.allocation_amount ) - sum( act3.amount_cy )   AS available,  
round((sum(act3.amount_cy)/(sum(act3.amount_py1+act3.allocation_amount)+sum('.01'))*12),1) AS 'months_used',
round((sum(act3.amount_lytt)/(sum(act3.amount_py1)+sum('.01'))*12),1) AS 'months_used_py'
FROM  `act3`
LEFT  JOIN center ON act3.center = center.center
LEFT  JOIN coa ON act3.ncasnum = coa.ncasnum
WHERE 1 $whereFilter
GROUP BY act3.ncasnum, act3.center
ORDER BY act3.ncasnum";

//echo "$sql<br>";//exit;

if($showSQL=="1"){echo "$sql<br>";}

//$varQuery=$_SERVER[QUERY_STRING];

if($rep==""){
// ******** Menu 0 *************   Reports
$setQuery="pay_center=$center&f_year=$f_year";
$menuArrayDetail=array("Equipment"=>"/budget/aDiv/equipment_division.php?$setQuery&submit=Submit'");

/*
echo "<table><tr>";

$menuArrayWksheet=array("Seasonal Payroll"=>"/budget/aDiv/seasonal_payroll.php?$varQuery&f_year=$f_year","Operating Expense Budget Available"=>"/budget/c/operating_expense_available.php");

echo "<td><form><font size='-1'>Worksheet for </font> <select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected></option>";$s="value";
foreach($menuArrayWksheet as $k => $v){
		echo "<option $s='$v'>$k\n";
       }
   echo "</select></form></td>";
if($level>3){
$menuArrayRequest=array("Equipment"=>"/budget/aDiv/park_equip_request.php?center=$center&m=1&submit=Submit","Operating_Expenses_NEW"=>"/budget/a/op_exp_approval.php?m=1","Operating_Expenses_TRANSFER"=>"/budget/a/op_exp_transfer.php?center=$center&m=1");
}
else{
$menuArrayRequest=array("Equipment"=>"/budget/aDiv/park_equip_request.php?center=$center&m=1&submit=Submit","Operating_Expenses_NEW"=>"/budget/a/op_exp_approval.php?m=1","Operating_Expenses_TRANSFER"=>"/budget/a/op_exp_transfer.php?center=$center&m=1");}

echo "<td><form><font size='-1'>Request for </font> <select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected></option>";$s="value";
foreach($menuArrayRequest as $k => $v){
		echo "<option $s='$v'>$k\n";
       }
   echo "</select></form></td>";

echo "<td><form><font size='-1'>Approved: </font> <select name=\"ref\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected></option>";$s="value";
foreach($menuArrayDetail as $k => $v){
		echo "<option $s='$v'>$k\n";
       }
   echo "</select></form></td>";

echo "</tr>";
*/

if($level==5){$showSQL="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='checkbox' name='showSQL' value='1'>Show SQL";}

echo "<tr><td><a href='center_level_budgets.php?$varQuery&rep=excel'>Excel Export</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$menuArray2[$scopeKey]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <font color='red'>$maxDate</font> $showSQL

</td></tr></table>";}

echo "<table border='1'><tr>";
$header="<th>Track<br>RCC</th><th>ACCT<br>CAT</th>
<th>NCAS#</th><th>DESCRIPTION</th><th>PARK</th><th>CENTER</th>
<th>Prior<br>Year 3</th><th>Prior<br>Year 2</th>
<th>Last<br>Year</th><th>Approved<br>Changes</th>
<th>Percent<br>Inc_Dec</th><th>Current Yr.<br>Budget</th>
<th>Current Yr.<br>Actual</th><th>Current Yr.<br>Available</th><th>Months<br>Used<br>CY</th>
<th>Months<br>Used<br>PY</th>";
echo "$header</tr>";

/*
Track<br>RCC</th>// 1
<th>ACCT<br>CAT</th>// 2
<th>NCAS#</th>// 3
<th>DESCRIPTION</th>// 4
<th>PARK</th>// 5
<th>CENTER</th>// 6
<th>Prior<br>Year 3</th>// 7
<th>Prior<br>Year 2</th>// 8
<th>Last<br>Year</th>// 9
<th>Approved<br>Changes</th>// 10
<th>Percent<br>Inc_Dec</th>// 11
<th>Current Yr.<br>Budget</th>// 12
<th>Current Yr.<br>Actual</th>// 13
<th>Current Yr.<br>Available</th>// 14
<th>Months<br>Used<br>CY</th>// 15
<th>Months<br>Used<br>PY</th>// 16
*/

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
//$num=mysqli_num_rows($result);
while($row=mysqli_fetch_array($result)){
extract($row);
$a_track_rcc[]=$track_rcc;// 1
$a_acct_cat[]=$acct_cat;// 2
$a_ncasnum[]=$ncasnum;// 3
$a_description[]=$description;// 4
$a_parkcode[]=$parkcode;// 5
$a_center[]=$center;// 6
$a_prior_year_3[]=$amount_py3;// 7
$a_prior_year_2[]=$amount_py2;// 8
$a_last_year[]=$amount_py1;// 9

$a_inc_dec[]=$inc_cy;// 10
$a_percent_inc_dec[]=$inc_cy_perc;// 11

$a_cy_budget[]=$request_cy;// 12
$a_cy_actual[]=$amount_cy;// 13
$a_cy_budget_actual[]=$available;// 14

if($months_used>24||$months_used<-24){$a_cy_months_used[]="24+";}else{$a_cy_months_used[]=$months_used;}// 15

//$a_cy_months_used[]=$months_used;
$a_cy_months_used_py[]=$months_used_py;// 16

// Get Center Totals for All Accounts
if($acct_cat=="exp"){
$tot_exp_py3+=$amount_py3;
$tot_exp_py2+=$amount_py2;
$tot_exp_ly+=$amount_py1;
$tot_inc_dec+=$inc_cy;
$tot_cy_budget+=$request_cy;
$tot_cy_actual+=$amount_cy;
$tot_cy_budget_actual+=$available;
}
if($acct_cat=="rev"){
$tot_rev_py3+=-($amount_py3);
$tot_rev_py2+=-($amount_py2);
$tot_rev_ly+=-($amount_py1);
$tot_inc_dec_rev+=-($inc_cy);
$tot_cy_budget_rev+=-($request_cy);
$tot_cy_actual_rev+=-($amount_cy);
$tot_cy_budget_actual_rev+=($available);
}
if($acct_cat=="fun"){
$tot_fun_py3+=-($amount_py3);
$tot_fun_py2+=-($amount_py2);
$tot_fun_ly+=-($amount_py1);
$tot_inc_dec_fun+=-($inc_cy);
$tot_cy_budget_fun+=-($request_cy);
$tot_cy_actual_fun+=-($amount_cy);
$tot_cy_budget_actual_fun+=-($available);
}

}// end while

$x=2;
for($i=0;$i<count($a_track_rcc);$i++){
if($a_acct_cat[$i]=="rev"||$a_acct_cat[$i]=="fun"){
$year3=-($a_prior_year_3[$i]);
$year2=-($a_prior_year_2[$i]);
$year1=-($a_last_year[$i]);
$v_inc_dec=-($a_inc_dec[$i]);
$v_cy_budget=-($a_cy_budget[$i]);
$v_cy_actual=-($a_cy_actual[$i]);
$v_cy_budget_actual=($a_cy_budget_actual[$i]);
}
else{
$year3=$a_prior_year_3[$i];
$year2=$a_prior_year_2[$i];
$year1=$a_last_year[$i];
$v_inc_dec=$a_inc_dec[$i];
$v_cy_budget=$a_cy_budget[$i];
$v_cy_actual=$a_cy_actual[$i];
$v_cy_budget_actual=$a_cy_budget_actual[$i];
}

// Format for display
$year3F=number_format($year3,2);
$year2F=number_format($year2,2);
$year1F=number_format($year1,2);
if($rep==""){$linkyear1="<a href='portal_ven_pay.php?dbTable=exp_rev&acct=$a_ncasnum[$i]&center=$a_center[$i]&f_year=$py1' target='_blank'>$year1F</a>";}else{$linkyear1=$year1F;}

$v_cy_actualF=number_format($v_cy_actual,2);
if($rep==""){$linkcy="<a href='portal_ven_pay.php?dbTable=exp_rev&acct=$a_ncasnum[$i]&center=$a_center[$i]&f_year=$cy' target='_blank'>$v_cy_actualF</a>";}else{$linkcy=$v_cy_actualF;}

$inc_cyF=number_format($v_inc_dec,2);
$linkIncDec=$inc_cyF;
/*
if($rep==""){$linkIncDec="<a href='inc_dec.php?dbTable=inc_dec&center=$a_center[$i]&ncas_acct=$a_ncasnum[$i]&link_inc_dec=1&ly=$total_amount_py1&desc=$description&px=$parkcode' target='_blank'>$inc_cyF</a>";}else{$linkIncDec=$inc_cyF;}
*/

$v_cy_budgetF=number_format($v_cy_budget,2);
$v_cy_actualF=number_format($a_cy_actual[$i],2);
if($a_cy_budget_actual[$i]<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}
$v_cy_budget_actualF=$f1.number_format($a_cy_budget_actual[$i],2).$f2;

/*
if($a_acct_cat[$i]=="rev"||$a_acct_cat[$i]=="fun"){
if($a_cy_months_used[$i]>=$monthNow){$monthUsedF="<font color='green'>$a_cy_months_used[$i]</font>";}else{$monthUsedF="<font color='magenta'>$a_cy_months_used[$i]</font>";}
}
else
{if($a_cy_months_used[$i]>$monthNow){$monthUsedF="<font color='magenta'>$a_cy_months_used[$i]</font>";}else{$monthUsedF="<font color='green'>$a_cy_months_used[$i]</font>";}}
*/
$monthUsedF=$a_cy_months_used[$i];
$monthUsed_pyF=$a_cy_months_used_py[$i];

$r=fmod($i,$x);if($r==0){$bc=" bgcolor='aliceblue'";}else{$bc="";}
$body ="<tr$bc>";

$body.="<td align='center'>$a_track_rcc[$i]</td>
<td align='center'>$a_acct_cat[$i]</td>
<td align='right'>$a_ncasnum[$i]</td>
<td align='right'>$a_description[$i]</td>
<td align='center'>$a_parkcode[$i]</td>
<td align='right'>$a_center[$i]</td>

<td align='right'>$year3F</td>
<td align='right'>$year2F</td>
<td align='right'>$linkyear1</td>

<td align='right'>$linkIncDec</td>
<td align='right'>$a_percent_inc_dec[$i]</td>

<td align='right'>$v_cy_budgetF</td>
<td align='right'>$linkcy</td>
<td align='right'>$v_cy_budget_actualF</td>
<td align='right'>$monthUsedF</td>
<td align='right'>$monthUsed_pyF</td>

</tr>";

if($track_rcc_menu and !$acct_cat_menu){
if($a_track_rcc[$i]==$track_rcc_menu){echo "$body";
$selected_acct_tot_py3+=$year3;
$selected_acct_tot_py2+=$year2;
$selected_acct_tot_py1+=$year1;
$selected_acct_tot_inc_dec+=$v_inc_dec;
$selected_acct_tot_cy_budget+=$v_cy_budget;
$selected_acct_tot_cy_actual+=$v_cy_actual;
$selected_acct_tot_cy_budget_actual+=$v_cy_budget_actual;
}}

if($acct_cat_menu and !$track_rcc_menu){
if($a_acct_cat[$i]==$acct_cat_menu){echo "$body";
$selected_acct_tot_py3+=$year3;
$selected_acct_tot_py2+=$year2;
$selected_acct_tot_py1+=$year1;
$selected_acct_tot_inc_dec+=$v_inc_dec;
$selected_acct_tot_cy_budget+=$v_cy_budget;
$selected_acct_tot_cy_actual+=$v_cy_actual;
$selected_acct_tot_cy_budget_actual+=$v_cy_budget_actual;
}}

if($acct_cat_menu and $track_rcc_menu){
if($a_acct_cat[$i]==$acct_cat_menu and $a_track_rcc[$i]==$track_rcc_menu){echo "$body";
$selected_acct_tot_py3+=$year3;
$selected_acct_tot_py2+=$year2;
$selected_acct_tot_py1+=$year1;
$selected_acct_tot_inc_dec+=$v_inc_dec;
$selected_acct_tot_cy_budget+=$v_cy_budget;
$selected_acct_tot_cy_actual+=$v_cy_actual;
$selected_acct_tot_cy_budget_actual+=$v_cy_budget_actual;
}}

if(!$acct_cat_menu and !$track_rcc_menu){echo "$body";}
}// end for

if($track_rcc_menu||$acct_cat_menu){
$a1=numFormat($selected_acct_tot_py3);
$a2=numFormat($selected_acct_tot_py2);
$a3=numFormat($selected_acct_tot_py1);
$a4=numFormat($selected_acct_tot_inc_dec);
//$a5=numFormat($selected_acct_tot_py3);
$a6=numFormat($selected_acct_tot_cy_budget);
$a7=numFormat($selected_acct_tot_cy_actual);
$a8=numFormat($selected_acct_tot_cy_budget_actual);
if($selected_acct_tot_cy_budget_actual<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}
echo "<tr>
<td align='right' colspan='6'><font color='purple'><b>Selected Accounts Total</b></font>: <td align='right'><b>$a1</b></td>
<td align='right'><b>$a2</b></td>
<td align='right'><b>$a3</b></td>
<td align='right'><b>$a4</b></td>
<td align='right'><b>$subinc_cy_percgrandF</b></td>

<td align='right'><b>$a6</b></td>
<td align='right'><b>$a7</b></td>
<td align='right'><b>$f1$a8$f2</b></td>
<td align='right'><b>$subProjExcessShortagegrandF</b></td>
<td align='right'><b>$subProjExcessShortagegrandF</b></td>
</tr>";
}

// Revenues
$r1=numFormat($tot_rev_py3);
$r2=numFormat($tot_rev_py2);
$r3=numFormat($tot_rev_ly);
$r4=numFormat($tot_inc_dec_rev);
//$r5=numFormat($tot_rev_py3);
$r6=numFormat($tot_cy_budget_rev);
$r7=numFormat($tot_cy_actual_rev);
$r8=numFormat($tot_cy_budget_actual_rev);

if($r8<0){$fc1="<font color='red'>";$fc2="</font>";}
echo "<tr><td colspan='18' align='center'>&nbsp;<br><font color='blue'><b>Center $center Totals</b></font></td></tr><tr><td colspan='6' align='right'><b>operational revenues</b></td>
<td align='right'>$r1</td><td align='right'>$r2</td><td align='right'>$r3</td>
<td align='right'>$r4</td><td></td><td align='right'>$r6</td><td align='right'>$r7</td><td align='right'>$fc1$r8$fc2</td>
</tr>";

// Funding
$f1=numFormat($tot_fun_py3);
$f2=numFormat($tot_fun_py2);
$f3=numFormat($tot_fun_ly);
$f4=numFormat($tot_inc_dec_fun);
//$f5=numFormat($tot_rev_py3);
$f6=numFormat($tot_cy_budget_fun);
$f7=numFormat($tot_cy_actual_fun);
$f8=numFormat($tot_cy_budget_actual_fun);
echo "<tr><td colspan='6' align='right'><b>funding revenues</b></td>
<td align='right'>$f1</td><td align='right'>$f2</td><td align='right'>$f3</td>
<td align='right'>$f4</td><td></td><td align='right'>$f6</td><td align='right'>$f7</td><td align='right'>$f8</td>
</tr>";

// Expenses
$e1=numFormat($tot_exp_py3);
$e2=numFormat($tot_exp_py2);
$e3=numFormat($tot_exp_ly);
$e4=numFormat($tot_inc_dec);
//$e5=numFormat($tot_rev_py3);
$e6=numFormat($tot_cy_budget);
$e7=numFormat($tot_cy_actual);
$e8=numFormat($tot_cy_budget_actual);
echo "<tr><td colspan='6' align='right'><b>expenses (direct & warehouse)</b></td>
<td align='right'>$e1</td><td align='right'>$e2</td><td align='right'>$e3</td>";
if($e4<0){$fc1="<font color='red'>";$fc2="</font>";}else{$fc1="";$fc2="";}
echo "<td align='right'>$fc1$e4$fc2</td>";
echo "<td></td><td align='right'>$e6</td><td align='right'>$e7</td><td align='right'>$e8</td>
</tr>";

// Revenues - Expenses
$re1=numFormat($tot_rev_py3+$tot_fun_py3-$tot_exp_py3);
$re2=numFormat($tot_rev_py2+$tot_fun_py2-$tot_exp_py2);
$re3=numFormat($tot_rev_ly+$tot_fun_ly-$tot_exp_ly);

$re4=numFormat($tot_inc_dec_rev+$tot_inc_dec_fun-$tot_inc_dec);
//$re5=numFormat($tot_rev_py3);
$re6=numFormat($tot_cy_budget_rev+$tot_cy_budget_fun-$tot_cy_budget);
$re7=numFormat($tot_cy_actual_rev+$tot_cy_actual_fun-$tot_cy_actual);
$re8=numFormat($tot_cy_budget_actual_rev+$tot_cy_budget_actual_fun-$tot_cy_budget_actual);
$fc1="<font color='red'>";$fc2="</font>";
echo "<tr><td colspan='6' align='right'><b>revenues - expenses</b></td>
<td align='right'>$fc1$re1$fc2</td><td align='right'>$fc1$re2$fc2</td><td align='right'>$fc1$re3$fc2</td>";
if($re4>0){$fc1="";$fc2="";}
echo "<td align='right'>$fc1$re4$fc2</td>";
$fc1="<font color='red'>";$fc2="</font>";
echo "<td></td><td align='right'>$fc1$re6$fc2</td><td align='right'>$fc1$re7$fc2</td><td align='right'>$fc1$re8$fc2</td>
</tr>";


// Appropriated
$ap1=numFormat(-($tot_rev_py3+$tot_fun_py3-$tot_exp_py3));
$ap2=numFormat(-($tot_rev_py2+$tot_fun_py2-$tot_exp_py2));
$ap3=numFormat(-($tot_rev_ly+$tot_fun_ly-$tot_exp_ly));

$ap4=numFormat(-($tot_inc_dec_rev+$tot_inc_dec_fun-$tot_inc_dec));
//$ap5=numFormat($tot_rev_py3));
$ap6=numFormat(-($tot_cy_budget_rev+$tot_cy_budget_fun-$tot_cy_budget));
$ap7=numFormat(-($tot_cy_actual_rev+$tot_cy_actual_fun-$tot_cy_actual));
$ap8=numFormat(-($tot_cy_budget_actual_rev+$tot_cy_budget_actual_fun-$tot_cy_budget_actual));
$fc1="";$fc2="";
echo "<tr><td colspan='6' align='right'><b>appropriated funds</b></td>
<td align='right'>$fc1$ap1$fc2</td><td align='right'>$fc1$ap2$fc2</td><td align='right'>$fc1$ap3$fc2</td>";
if($ap4<0){$fc1="<font color='red'>";$fc2="</font>";}
echo "<td align='right'>$fc1$ap4$fc2</td>";
$fc1="";$fc2="";
echo "<td></td><td align='right'>$fc1$ap6$fc2</td><td align='right'>$fc1$ap7$fc2</td><td align='right'>$fc1$ap8$fc2</td>
</tr>";

//echo "<tr>$header</tr>";
echo "</table></body></html>";

function numFormat($nf){
$nf=number_format($nf,2);
return $nf;}
?>



