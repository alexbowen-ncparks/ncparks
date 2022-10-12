<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
include("../../../include/activity.php");
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";//exit;

$level=$_SESSION['budget']['level'];
$location=$_SESSION['budget']['select'];
if($level<4){
	// Head Nat. Res. Section - Carol Tingley
	if($_SESSION['budget']['beacon_num']!="60033160"){$test=1;}
	// Land Resources - Sue Regier
	if($_SESSION['budget']['beacon_num']!="60032790"){$test=1;}
	if($test==""){exit;}
	}
include("../css/TDnull.inc");

if($reportType=="acct"){$ck_acct="checked";$ck_bg="";}else{$ck_bg="checked";$ck_acct="";}
echo "<form action='budget_history.php' method='POST'>
<table border='1' cellpadding='5'><tr><th>Please select a Report Type:</th></tr>
<tr bgcolor='aliceblue'><td align='right'>View by Year: </td><td>Budget Group <input type='radio' name='reportType' value='bg' $ck_bg></td>
<td>Account <input type='radio' name='reportType' value='acct' $ck_acct></td><td><input type='submit' name='submit' value='Submit'></td></tr></form>";

echo "<form action='budget_3yr_history.php' method='POST'>
<tr><td align='right'>View 3 Year History: </td><td>Budget Group <input type='radio' name='reportType' value='bg' checked></td>
<td>Account <input type='radio' name='reportType' value='acct'></td><td><input type='submit' name='submit' value='Submit'></td></tr></form>";


if(!$reportType){exit;}

if($reportType=="bg"){
$rt="Budget Group";
$filterArray=array("f_year","budget_group","cash_type","center","parkcode","district","section");
$fldArray=array("f_year","budget_group","cash_type","center","parkcode","district","section","sum(amount) as 'amount'");
$headerArray=array("f_year","budget_group","cash_type","center","parkcode","district","section","amount");
$groupBy="group by f_year,budget_group,parkcode,cash_type";
$orderBy="order by f_year,budget_group,parkcode,cash_type";
}
if($reportType=="acct"){
$rt="Account";
$filterArray=array("f_year","budget_group","cash_type","center","parkcode","district","section","account");
$fldArray=array("f_year","budget_group","cash_type","account","account_description","center","parkcode","district","section","sum(amount) as 'amount'");
$headerArray=array("f_year","budget_group","cash_type","account","account_description","center","parkcode","district","section","amount");
$groupBy="group by f_year,budget_group,parkcode,cash_type,account";
$orderBy="order by f_year,budget_group,parkcode,cash_type,account";
}

//$showSQL=1;
// Get f_year
include("../~f_year.php");
$currentFY=$f_year;
if($passFY){$f_year=$passFY;}

echo "<table align='center'>";
// Menu item 0
$sql="SELECT DISTINCT f_year
FROM report_budget_history
WHERE 1 AND f_year != '' AND f_year != '9900'
ORDER BY f_year";
 $result = @mysqli_query($connection, $sql,$connection);
 while($row=mysqli_fetch_array($result)){$menuArray0[]=$row['f_year'];}

// Menu item 1
$sql="SELECT DISTINCT budget_group
FROM report_budget_history
WHERE 1 
order by budget_group;
";
 $result = @mysqli_query($connection, $sql,$connection);
 while($row=mysqli_fetch_array($result)){$menuArray1[]=$row['budget_group'];}
 
// Menu item 2
$menuArray2[]="disburse";$menuArray2[]="receipt";

// Menu item 3
// manual entry for account
 
// Menu item Center
if($level==2){$where="and `dist`='east' AND stateParkYN='y'";}
$sql="SELECT DISTINCT center
FROM center
WHERE 1 $where and actCenterYN='y'
order by center;
";
 $result = @mysqli_query($connection, $sql,$connection);
 while($row=mysqli_fetch_array($result)){$menuArray4[]=$row['center'];}
 
// Menu item Parkcode 5
if($level>1){
		if($level==2){
		$distArray=array("EADI"=>"EAST","NODI"=>"NORTH","SODI"=>"SOUTH","WEDI"=>"WEST");$where="and `dist`='$distArray[$location]' AND stateParkYN='y'";
		}
		
$sql="SELECT DISTINCT upper(parkcode) as parkcode
FROM center
WHERE 1 $where and actCenterYN='y'
order by parkcode;
";
 $result = @mysqli_query($connection, $sql,$connection);
 while($row=mysqli_fetch_array($result)){$menuArray5[]=$row['parkcode'];}
 
} //$level=1
	
if($level==1){
		if($_SESSION['budget']['accessPark']){
			$menuArray5=explode(",",$_SESSION['budget']['accessPark']);
			}
			else{$menuArray5[]=$location;}
	}
 
// Menu item District 6
if($level==2){
$where="and `district`='$distArray[$location]'";}
$sql="SELECT DISTINCT upper(district) as district
FROM report_budget_history
WHERE 1 $where
order by district;
"; //echo "$sql";
 $result = @mysqli_query($connection, $sql,$connection);
 while($row=mysqli_fetch_array($result)){$menuArray6[]=$row['district'];}

// Menu item Section 7
if($level>2){
$sql="SELECT DISTINCT section
FROM report_budget_history
WHERE 1 
order by section;
";
 $result = @mysqli_query($connection, $sql,$connection);
 while($row=mysqli_fetch_array($result)){$menuArray7[]=$row['section'];}
}

// ******** Display Menus **********
echo "<tr><td colspan='8' align='center'>
<form action='/budget/menu.php?forum=blank'><input type='submit' name='submit' value='Return to Budget Menus'></td></tr></form>";

echo "<tr><td colspan='8' align='center'>Report Type: <font color='blue'>$rt</font></td></tr>";
 
echo "<form method='POST'><tr>";

echo "<td>Fiscal Year<br /><select name=\"passFY\">";
foreach($menuArray0 as $k => $v){
	if($v==$f_year){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v\n";
       }
   echo "</select></td>";
   
echo "<td align='center'>Budget group<br /><select name=\"budget_group\"><option selected></option>";
foreach($menuArray1 as $k => $v){
	if($v==$budget_group){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v\n";
       }
   echo "</select></td>";
   
echo "<td align='center'>Cash Type<br /><select name=\"cash_type\"><option selected></option>";
foreach($menuArray2 as $k => $v){
	if($v==$cash_type){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v\n";
       }
   echo "</select></td>";


if($level>1){   
echo "<td align='center'>Center<br /><select name=\"center\"><option selected></option>";
foreach($menuArray4 as $k => $v){
	if($v==$center){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v\n";
       }
   echo "</select></td>";
 }
 
echo "<td align='center'>Parkcode<br /><select name=\"parkcode\"><option selected></option>";
foreach($menuArray5 as $k => $v){
	if($v==$parkcode){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v\n";
       }
   echo "</select></td>";


if($level>1){
echo "<td align='center'>District<br /><select name=\"district\"><option selected></option>";
foreach($menuArray6 as $k => $v){
	if($v==$district){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v\n";
       }
   echo "</select></td>";
}

if($level>2){
echo "<td align='center'>Section<br /><select name=\"section\"><option selected></option>";
foreach($menuArray7 as $k => $v){
	if($v==$section){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v\n";
       }
   echo "</select></td>";
}

if($reportType=="acct"){
echo "<td align='center'>Account<br /><input type='text' name='account' value='$account' size='9'></td>";}
   
   
echo "<td>
<input type='hidden' name='reportType' value='$reportType'>
<input type='submit' name='submit' value='Filter'></td></form>";
   
echo "<form><td>
<input type='hidden' name='reportType' value='$reportType'>
<input type='submit' name='reset' value='Reset'></td>";
echo "</form></tr>";


// ******** Query ************

if($submit!="Filter"){exit;}

/*
if($passFY==$currentFY AND $submit=="Filter"){
//$showSQL=1;
 $query = "DELETE from report_budget_history
where f_year='$passFY';";
 $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

 $query = "insert into report_budget_history
select f_year,budget_group,cash_type,acct as 'account',park_acct_desc as 'account_description',
exp_rev.center,parkcode,center.dist as 'district',sum(credit-debit) as 'amount',''
from exp_rev
left join coa on exp_rev.acct=coa.ncasnum
left join center on exp_rev.center=center.center
where 1
and exp_rev.fund like '1280%'
and f_year='$passFY'
group by f_year,budget_group,acct,exp_rev.center 
";
  $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}
}
*/

// populate SELECT fields
foreach($fldArray as $k=>$v){$fields.=$v.",";}

// populate $WHERE
if($passFY){$WHERE.="and f_year='$passFY'";}


if($level==1){
	if(!$parkcode){$parkcode=$location;}
		if($_SESSION['budget']['accessPark']){
			if(in_array($parkcode,$menuArray5)){
			$WHERE.=" and parkcode='$parkcode'";}
				else{$WHERE.=" and parkcode='$parkcode'";}
			}
			else{$WHERE.=" and parkcode='$location'";}
	}
 

$excludeThese=array("passFY","reportType","submit","PHPSESSID","reset");

//echo "<pre>";print_r($_REQUEST);echo "</pre>";
foreach($_REQUEST as $k=>$v){
if(!in_array($k,$excludeThese) AND $v!=""){$WHERE.=" and ".$k."='".$v."'";}
}

$decimalFlds=array("amount");

$fields=trim($fields,",");
 $query = "SELECT $fields
from report_budget_history
where 1
$WHERE
$groupBy
$orderBy
";

echo "$query";//exit;
  $result = @mysqli_query($connection, $query,$connection);
if($showSQL=="1"){echo "$query<br><br>";}

$num=mysqli_num_rows($result);
while($row=mysqli_fetch_array($result)){

$b[]=$row;
}// end while

//echo "<pre>";print_r($headerArray);echo "</pre>";exit;

echo "<div><table border='1' align='center'>";
echo "<tr><td colspan='8' align='center'><font color='red'>$num</font> items</td></tr>";

$count=count($headerArray);
for($i=0;$i<$count;$i++){
$h=$headerArray[$i];
if(!in_array($h,$dontShow)){
	$selectFields.=$h.",";
if($rep==""){
if(in_array($h,$replaceArray)){$h=str_replace("_","<br>",$h);}
			}
	$header.="<th>".$h."</th>";
					}
	}


$cen=$b[0][center];

if($num<1){echo "<br />No records found.";}

$x=2;
if($passYY){$yy=$passYY;}else{$yy=15;}

echo "<tr>";
	for($i=0;$i<count($b);$i++){
	$r=fmod($i,$x);if($r==0){$bc=" bgcolor='AliceBlue'";}else{$bc="";}
	
if(fmod($i,$yy)==0 and $rep==""){echo "<tr bgcolor='#698B69'>$header</tr>";}

echo "<tr$bc>";
	for($j=0;$j<count($headerArray);$j++){

	$var=$b[$i][$headerArray[$j]];
	$fieldName=$headerArray[$j];
	
	if($fieldName=="er_num"){$er=$var;}
	
	if(in_array($fieldName,$decimalFlds)){
	$a="<td align='right'>";$totArray[$fieldName]+=$var;
	$var=numFormat($var);}else{$a="<td>";}
			if(in_array($fieldName,$editFlds)){
			if(in_array($fieldName,$radioFlds)){
	if($var=="y")
{$ckY="checked";$ckN="";}else{$ckN="checked";$ckY="";}

echo "<td align='right'>
<font color='green' size='-1'>Y</font><input type='radio' name='$headerArray[$j][$er]' value='y'$ckY><font color='red' size='-1'>N</font><input type='radio' name='$headerArray[$j][$er]' value='n'$ckN></td>";}
else
			
			{echo "<td bgcolor='beige' align='center'><input type='text' name='$headerArray[$j][$er]' value='$var' size='10'></td>";}
			
			
			}else{echo "$a$var</td>";}
	}
	
echo "</tr>";
	}
echo "<tr>";
	for($j=0;$j<count($headerArray);$j++){
	if($totArray[$headerArray[$j]]){
	$var=$totArray[$headerArray[$j]];
	if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}
	$v=numFormat($var);$xx=2;
	echo "<td align='right'><b>$v</b></td>";}else{echo "<td></td>";}
}

/*
$footer="<tr><td colspan='8' align='center'>Equipment Budget <a href='popupex.html' onclick=\"return popitup('explain_search.php?subject=equipment')\">Terminology</a></td></tr>";
*/

$footer="<tr><td colspan='9' align='center'><font color='red'>Click Button at top of screen to return to menus.</font></td></tr>";

echo "$footer</table></div></body></html>";

function numFormat($nf){
$nf=number_format($nf,2);
return $nf;}
?>



