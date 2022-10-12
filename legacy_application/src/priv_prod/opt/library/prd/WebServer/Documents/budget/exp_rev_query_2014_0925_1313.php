<?php
//These are placed outside of the webserver directory for security

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

//ini_set('display_errors',1);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database

//session_start();
include("../../include/activity.php");
extract($_REQUEST);
if(@$centerOverride){$center=$centerOverride;}

// Construct Query to be passed to Excel Export
if(!isset($center)){$center="";}
if(!isset($fourth_field)){$fourth_field="";}
if(!isset($fifth_field)){$fifth_field="";}
$varQuery="submit=Submit&center=$center&fourth_field=$fourth_field&fifth_field=$fifth_field";
if(!isset($third_field)){$third_field="";}
if(@$first_field){$varQuery.="&first_field=$first_field&third_field=$third_field";}

//print_r($_SESSION);//EXIT;
//print_r($_REQUEST);//EXIT;
$level=$_SESSION['budget']['level'];
$m="trans_post";
if(@$rep==""){include("menu.php");}


if($level<2){
$S=$_SESSION['budget']['centerSess'];
$daCenter=array("12802859","12802857");
$daCode=array("NERI","MOJE"); 
	if(in_array($S,$daCenter)){
	include("multi_park.php");
	}
		else{$center=$_SESSION['budget']['centerSess'];}
}

$sql="select max(acctdate) as maxDate from exp_rev where 1";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
$row=mysql_fetch_array($result);extract($row);

if(@$rep==""){

// ********************  Display Form
echo "<html><header></header<title></title><body>
<table align='center'><form method='POST' name='exp_rev_query_form'>";

if($level>1){
echo "<tr><th colspan='3'>";
$sql="SELECT section,parkcode,center as varCenter from center where fund='1280' order by section,parkcode,center";
$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysql_fetch_array($result)){
extract($row);$pc[]=$parkcode;$c[]=$varCenter;$sec[]=$section;}

echo "<select name=\"center\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select Center</option>";
for ($n=0;$n<count($c);$n++){
if($centerOverride){$c[$n]=$centerOverride;}
$show=$sec[$n]."-".$pc[$n]."-".$c[$n];
if($center==$c[$n]||$center==$show){$s="selected";}else{$s="value";}
$con="exp_rev_query.php?center=".$c[$n];
		echo "<option $s='$con'>$show</option>\n";
       }
       if($centerOverride){$center=$centerOverride;}
   echo "</select>&nbsp;&nbsp;&nbsp;Show SQL <input type='checkbox' name='showSQL' value='x'> Report Date: <font color='red'>$maxDate</font></td></tr><tr><th colspan='3'>Center Override: <input type='text' name='centerOverride' size='15' value='$center'></th></tr>";}


echo "<tr><td>View: transactions where ";

// ******** Budget Groups *************
$menuArray0=array("Account_Number"=>"Account_Number","Amount"=>"amount","Budget_Group"=>"Budget_Group","Invoice_Number"=>"Invoice_Number","Vendor_Name"=>"Vendor_Name");

if(@$centerOverride){$center=$centerOverride;}

$file="/budget/exp_rev_query.php?center=$center&first_field=";
echo "<select name=\"first_field\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected></option>";
foreach($menuArray0 as $k => $v){
if(@$first_field==$v || @$first_field==$k){$s="selected";}else{$s="value";}
		echo "<option $s='$file$v'>$k\n";
       }
   echo "</select></td>";
   
echo "<td>is ";

if(@$first_field){
if($first_field=="Invoice_Number"||$first_field=="Vendor_Name"){echo "like";} else{echo "equal to";}

if($first_field=="Budget_Group"){//$third_field="operating_expenses";
$sql="Select distinct(budget_group) as budgetGroup
from coa where 1";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
 $menuArray0="";
while($row=mysql_fetch_array($result)){
extract($row);
$menuArray0[]=$budgetGroup;}

echo " <select name=\"third_field\">";
for($i=0;$i<count($menuArray0);$i++){
if($third_field==$menuArray0[$i]){$s="selected";}else{$s="value";}
		echo "<option $s='$menuArray0[$i]'>$menuArray0[$i]\n";
       }
   echo "</select> and </td>";

}
}


if(@$first_field=="Account_Number"){
// ******** Account Number *************
$label="<input type=\"button\" value=\"View Account Numbers\" onClick=\"return popitup('portalAcctNum.php?source=exp_rev_query')\">";
}

if(@$first_field!="Account_Group" and @$first_field!="Account_Category" and @$first_field!="Budget_Group")
	{
	if(!isset($third_field)){$third_field="";}
	echo " <input type='text' name='third_field' size='15' value='$third_field'> and";
	}

// ******** Dates *************
$menuArray0=array("month/year"=>"month/year","daterange"=>"daterange");

echo "<td><select name=\"fourth_field\"><option selected>fiscal_year</option>";
foreach($menuArray0 as $k => $v){
if($fourth_field==$v){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$k\n";
       }

//$varQuery.="&fourth_field=$fourth_field";
// ********* Get Current FY
if(!$fifth_field){
include("~f_year.php");
$fifth_field=$f_year;
}
//$varQuery.="&fifth_field=$fifth_field";

   echo "</select> is equal to <input type='text' name='fifth_field' size='20' value='$fifth_field'>";

$q="Select max(acctdate) as maxDate from exp_rev where 1";
$result = mysql_query($q) or die ("Couldn't execute query. $q");
$row=mysql_fetch_array($result);extract($row);

if($center){$addCenter="<input type='hidden' name='center' value='$center'>";}

if(@$centerOverride){$addCenter.="<input type='hidden' name='centerOverride' value='$centerOverride'>";}

if(!isset($addCenter)){$addCenter="";}
echo "</tr><tr><td colspan='3' align='center'>$addCenter<input type='submit' name='submit' value='Submit'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='http://www.dpr.ncparks.gov/budget/exp_rev_query.php?m=trans_post'>Reset</a></td></form></tr>";

if(@$label){echo "<tr><td></td><td></td><td>$label</td></tr>";}

if(!isset($f_year)){$f_year="";}
echo "<tr>
<td colspan='6' align='right'>Enter <font color='blue'>$f_year</font> for fiscal year <font color='blue'>$f_year</font><br>";
// $yx from ~f_year.php
if(!isset($yx)){$yx="";}
if(!isset($year2)){$year2="";}
echo "Enter <font color='blue'>10/$yx</font> for month/year=<font color='blue'>october $year2</font><br>
Enter <font color='blue'>7/1/$yx*9/30/$yx</font> for daterange=<font color='blue'>July-September $year2</font></td></tr>";

// *******************
if(@$submit){
$pass_menu=@$menuArray2[$scopeKey];
echo "<tr><td><a href='exp_rev_query.php?$varQuery&rep=excel'>Excel Export</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$pass_menu&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
if($level<2){echo "Last Update: <font color='red'>$maxDate</font></td></tr>";}
}// if submit
echo "</table>";
}

if(@$submit!=""){
$find="-";
$testStr=strpos($center,$find);
if($testStr>0){
$cen=explode("-",$center);
$center=$cen[2];
}
if(@$centerOverride){$center=$centerOverride;}

if($center!="Select Center"){$addCenter="where 1 and center='$center'";}
else{$addCenter="where 1";}

$sql="SELECT exp_rev.center,
exp_rev.description as 'vendor',
invoice,
pcard_transid,
sum(debit-credit) as 'amount',
park_acct_desc as 'description',
acct as 'account',
acctdate as 'postdate',
f_year,
budget_group,
track_rcc as 'track',
sys
FROM exp_rev
LEFT JOIN coa ON exp_rev.acct = coa.ncasnum
$addCenter";

//$orderBy="order by acct_cat,budget_group,acct_group,acct asc,acctdate desc";
$orderBy="order by acctdate desc";

if($first_field=="Invoice_Number"){
$sql.=" and exp_rev.invoice LIKE '%$third_field%'";}

if($first_field=="Vendor_Name"){
$sql.=" and exp_rev.description LIKE '%$third_field%'";}

if($first_field=="Account_Number"){
$sql.=" and ncasnum='$third_field'";}

if($first_field=="Account_Category"){
if($third_field=="Expenses"){$ac="exp";}
if($third_field=="Revenues"){$ac="rev";}
if($third_field=="Funding"){$ac="fun";}
$sql.=" and coa.acct_cat='$ac'";}

if($first_field=="Account_Group"){
$sql.=" and acct_group='$third_field'";}

if($first_field=="Budget_Group"){
$sql.=" and budget_group='$third_field'";}

if($first_field=="Amount"){
$sql.=" and (debit='$third_field' or credit='$third_field')";}

//if($fourth_field=="fiscal_year"){
$field4="f_year='$fifth_field'";
//}

if($fourth_field=="month/year"){$my=explode("/",$fifth_field);
$my0=str_pad($my[0],2,"0",STR_PAD_LEFT);$my1=str_pad($my[1],4,"20",STR_PAD_LEFT);
$field4="exp_rev.month='$my0' and exp_rev.calyear='$my1'";}

if($fourth_field=="daterange"){$dr=explode("*",$fifth_field);
$sd=explode("/",$dr[0]);$ed=explode("/",$dr[1]);
$sd0=str_pad($sd[0],2,"0",STR_PAD_LEFT);$sd1=str_pad($sd[1],2,"0",STR_PAD_LEFT);$sd2=str_pad($sd[2],4,"20",STR_PAD_LEFT);

$ed0=str_pad($ed[0],2,"0",STR_PAD_LEFT);$ed1=str_pad($ed[1],2,"0",STR_PAD_LEFT);$ed2=str_pad($ed[2],4,"20",STR_PAD_LEFT);
$field4="exp_rev.acctdate>='$sd2$sd0$sd1' and acctdate <= '$ed2$ed0$ed1'";}

$sql.=" and $field4";

$sql.=" group by whid
$orderBy";

if(@$showSQL){
echo "$sql<br><br>";//exit;
}

$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
$num=mysql_num_rows($result);

if(@$rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=Exp_Rev_Query.xls');
}

// Display Results
//<th>budget_group</th><th>track</th>
//<td>$budget_group</td><td>$track</td>

echo "<html><header></header><title>Exp_Rev_Query</title><body>
<table border='1' align='center'><tr><td colspan='10' align='center'><font color='blue'>$num</font> records returned</td></tr>
<tr><th>center</th><th>vendor</th><th>invoice</th><th>pcard_transid</th><th>amount</th><th>description</th><th>account</th><th>postdate</th><th>f_year</th><th>sys</th></tr>";
while($row=mysql_fetch_array($result)){
extract($row); 
@$amtTotal+=$amount;
$amount=number_format($amount,2);
//tbass Rows-alternating color 2/1/14
if($table_bg2==''){$table_bg2='cornsilk';}
if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}
echo "<tr$t><td>$center</td><td>$vendor</td><td>$invoice</td><td>$pcard_transid</td><td align='right'>$amount</td><td>$description</td><td>$account</td><td>$postdate</td><td>$f_year</td><td>$sys</td></tr>";
}
$amtTotal=number_format($amtTotal,2);
echo "<tr><td colspan='5' align='right'>$amtTotal</td></tr>";
echo "</table></body></html>";
}
?>