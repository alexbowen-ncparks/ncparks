<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../include/authBUDGET.inc");
include("../../../include/activity.php");
extract($_REQUEST);

include("../../../include/parkcodesDiv.inc");
//echo "<pre>";
//print_r($_REQUEST);
//print_r($_POST);
//print_r($_SESSION);
//echo "</pre>";//exit;

if($del!=""){
$sql="DELETE from equipment_request_3 where er_num='$del' and division_approved !='y'";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
}


// Construct Query to be passed to Excel Export
foreach($_REQUEST as $k => $v){
if($v and $k!="PHPSESSID" and $k!="del"){$varQuery.=$k."=".$v."&";}
}
$passQuery=$varQuery;
   $varQuery.="rep=excel";    

$level=$_SESSION['budget']['level'];
$thisUser=$_SESSION['budget']['tempID'];

if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=park_equip_request.xls');
}

// Make f_year
if(!$f_year){include("../~f_year.php");}

if($rep==""){include_once("../menu.php");

if($showSQL==1){$p="method='POST'";}
echo "<hr><table align='center'><form action='dist_equip_request.php' $p>";
}


if($level==2){
switch ($_SESSION['budget']['select']) {
		case "SODI":
			$w="and district='south'";
			if($category=="VEHICLE-(TRUCK)"){$w="";}
			$pu="and (district='south')";
			break;	
		case "NODI":
			$w="and district='north'";
			$pu="and (district='north')";
			break;	
		case "EADI":
			$w="and district='east'";
			$pu="and (district='east')";
			break;	
		case "WEDI":
			$w="and district='west'";
			$pu="and (district='west')";
			break;	
	}// end switch
	
// ****** District menus ******

if($rep==""){
 echo "<table><tr>";
 
echo "<td align='center'>ER Number<br><input type='text' name='er_num' value='$er_num' size='5'></td>";

// Menu f_year
$sql="select distinct f_year
from equipment_request_3
where 1
order by f_year desc;
";
$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysql_fetch_array($result)){
$menuArray[]=$row['f_year'];}

echo "<td align='center'>Fiscal Year<br><select name=\"f_year\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++){
if($f_year==$menuArray[$n]){$s="selected";}else{$s="value";}
$con=$menuArray[$n];
		if($con!=""){echo "<option $s='$con'>$menuArray[$n]</option>\n";}
       }
   echo "</select></td>";

// Menu Park Code
   unset($menuArray);
$sql="select distinct(center_code) as center_codeMenu from equipment_request_3 where 1 $w
order by center_code";
$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysql_fetch_array($result)){
$menuArray[]=$row['center_codeMenu'];}

echo "<td align='center'>Park Code<br><select name=\"center_code\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++){
if($center_code==$menuArray[$n] and $center_code!=""){$s="selected";}else{$s="value";}
$con=$menuArray[$n];
		if($con!=""){echo "<option $s='$con'>$menuArray[$n]</option>\n";}
       }
   echo "</select></td>";
   
// Menu Pay Center
   unset($menuArray);
$sql="select distinct(pay_center) as centerMenu from equipment_request_3 where 1 and pay_center!='' $w
order by pay_center";
$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysql_fetch_array($result)){
$menuArray[]=$row['centerMenu'];}

echo "<td align='center'>Pay Center<br><select name=\"pay_center\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++){
if($pay_center==$menuArray[$n] and $pay_center!=""){$s="selected";}else{$s="value";}
$con=$menuArray[$n];
		echo "<option $s='$con'>$menuArray[$n]</option>\n";
       }
   echo "</select></td>";
   
// Menu Purchaser
   unset($menuArray);
$sql="select distinct purchaser
from equipment_request_3
where 1
$w
order by purchaser;
";
$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysql_fetch_array($result)){
$menuArray[]=$row['purchaser'];}

echo "<td align='center'>Purchaser<br><select name=\"purchaser\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++){
if($purchaser==$menuArray[$n] and $purchaser!=""){$s="selected";}else{$s="value";}
$con=$menuArray[$n];
		echo "<option $s='$con'>$menuArray[$n]</option>\n";
       }
   echo "</select></td>";
   
// Menu User_ID
   unset($menuArray);
$sql="select distinct user_id
from equipment_request_3
where 1
$w
order by user_id;
";
$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysql_fetch_array($result)){
$menuArray[]=$row['user_id'];}

echo "<td align='center'>User_ID<br><select name=\"user_id\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++){
if($user_id==$menuArray[$n] and $user_id!=""){$s="selected";}else{$s="value";}
$con=$menuArray[$n];
		echo "<option $s='$con'>$menuArray[$n]</option>\n";
       }
   echo "</select></td>";
   
/*
unset($menuArray);
// Menu Funding Source
$sql="select distinct(funding_source) as funding_sourceMenu from equipment_request_3 where 1 and funding_source!='' $w
and f_year='$f_year'
order by funding_source";
$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysql_fetch_array($result)){
$menuArray[]=$row['funding_sourceMenu'];}

echo "<td align='center'>Funding Source<br><select name=\"funding_source\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++){
if($funding_source==$menuArray[$n] and $funding_source!=""){$s="selected";}else{$s="value";}
$con=$menuArray[$n];
		echo "<option $s='$con'>$menuArray[$n]</option>\n";
       }
   echo "</select></td>";
*/

   // Menu Category
   unset($menuArray);
 //  if($change=="Change"||$edit==1){$whereCat="";}
$sql="Select distinct(category) as cat_menu from equipment_request_3
where 1 $w $whereCat and f_year='$f_year'
order by category";
//echo "$sql";//exit;

$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysql_fetch_array($result)){
$menuArray[]=$row['cat_menu'];}
echo "<td align='center'>Category<br><select name=\"category\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++){
if($category==$menuArray[$n]){$s="selected";}else{$s="value";}
$con=$menuArray[$n];
		echo "<option $s='$con'>$menuArray[$n]</option>\n";
       }
   echo "</select></td>";
      
   
   unset($menuArray);
$menuArray=array("y","n","u");
// Menu District Approved
echo "<td align='center'>District Approved<br><select name=\"district_approved\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++){
if($district_approved==$menuArray[$n]){$s="selected";}else{$s="value";}
$con=$menuArray[$n];
		echo "<option $s='$con'>$menuArray[$n]</option>\n";
       }
   echo "</select></td>";
   
// Menu Division Approved
   unset($menuArray);
$menuArray=array("y","n","u");
echo "<td align='center'>Division Approved<br><select name=\"division_approved\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++){
if($division_approved==$menuArray[$n]){$s="selected";}else{$s="value";}
$con=$menuArray[$n];
		echo "<option $s='$con'>$menuArray[$n]</option>\n";
       }
   echo "</select></td>";
   
   unset($menuArray);
// Menu District Rank

$sql="select distinct(disu_ranking) as districtRank from equipment_request_3 where 1 $w and f_year='$f_year'
order by district";
$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysql_fetch_array($result)){
$menuArray[]=$row['districtRank'];}
//echo "$sql";
echo "<td align='center'>District Rank<br><select name=\"disu_ranking\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++){
if($disu_ranking==$menuArray[$n] and $district!=""){$s="selected";}else{$s="value";}
$con=$menuArray[$n];
	if($con!=""){echo "<option $s='$con'>$menuArray[$n]</option>\n";}
       }
   echo "</select></td></tr>";
   
   echo "<tr><td colspan='7' align='right'><input type='submit' name='submit' value='Submit'>";
echo "</form></td><form><td colspan='3' align='left'><input type='submit' name='reset' value='Reset'></td></form></tr></table>";
}

}// end level=2




if($submit!="Submit"){exit;}

// ********* Body Queries ***************
//$pay_center=$_SESSION[budget][centerSess];
//$pay_center=$center;

if($approv=="y"){$whilePlus=" and division_approved='y'";}

$whereFilter="where 1";

if($er_num){$whereFilter.=" and equipment_request_3.er_num='$er_num'";}
if($pay_center){$whereFilter.=" and equipment_request_3.pay_center='$pay_center'";}
if($purchaser){$whereFilter.=" and equipment_request_3.purchaser='$purchaser'";}
if($user_id){$whereFilter.=" and equipment_request_3.user_id='$user_id'";}
if($center_code){$whereFilter.=" and equipment_request_3.center_code='$center_code'";}
if($category){$whereFilter.=" and equipment_request_3.category='$category'";}
if($district_approved){$whereFilter.=" and equipment_request_3.district_approved='$district_approved'";}
if($division_approved){$whereFilter.=" and equipment_request_3.division_approved='$division_approved'";}
if($disu_ranking){$whereFilter.=" and equipment_request_3.disu_ranking='$disu_ranking'";}
if($funding_source){$whereFilter.=" and equipment_request_3.funding_source='$funding_source'";}



/*select query for center budgets*/

//funding_source, 
$sql="select er_num, f_year, parkcode, pay_center, purchaser, user_id, system_entry_date,category, equipment_description,ncas_account, unit_quantity, unit_cost, sum(unit_quantity*unit_cost) as 'requested_amount', justification, pasu_ranking, district_approved, disu_ranking, division_approved, bo_comments from equipment_request_3 left join center on equipment_request_3.pay_center=center.center
$whereFilter
and f_year='$f_year' and status='active' and center like '1280%'
$w
$whilePlus
group by er_num
order by parkcode,pasu_ranking";

//if($rep==""){echo "$sql<br>";}//exit;

if($showSQL=="1"){echo "$sql<br>";}

$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
$num=mysql_num_rows($result);

echo "<table border='1' cellpadding='2'>";
if($rep==""){echo "<tr bgcolor='lightgray'><th colspan='3'><font color='red'>Existing Requests</font> <a href='dist_equip_request.php?$varQuery'>Excel</a></th><th>$num records</th><form ID=\"equip_request_1\" NAME=\"equip_request_1\" action='dist_equip_request_update.php' method='POST'>$goBack";}

//"funding_source",
$headerArray=array("er_num","f_year","parkcode","pay_center","purchaser", "user_id","system_entry_date","category","equipment_description","ncas_account","unit_quantity","unit_cost","requested_amount","justification","pasu_ranking","district_approved","disu_ranking","division_approved","bo_comments");

$count=count($headerArray);
for($i=0;$i<$count;$i++){
$h=$headerArray[$i];
$h=str_replace("_"," ",$h);
if($h=="justification"){$addSpace="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";}else{$addSpace="";}
$header.="<th>".$addSpace.$h.$addSpace."</th>";}

if($rep==""){echo "<td colspan='$count'>&nbsp;</td></tr>";}

echo "<tr>$header</tr>";

while($row=mysql_fetch_array($result)){
$b[]=$row;
}// end while
//echo "<pre>";print_r($b);echo "</pre>";exit;

$radioFlds=array("district_approved");

$textFlds=array("justification");

$decimalFlds=array("requested_amount","approved_amount","ordered_amount", "unordered_amount","surplus_deficit","unit_cost");

if($rep=="") {
$editFlds=array("unit_quantity","unit_cost","justification","district_approved","disu_ranking");}

$x=2;
$yy=5;

	for($i=0;$i<count($b);$i++){
	$r=fmod($i,$x);if($r==0){$bc=" bgcolor='aliceblue'";}else{$bc="";}
	
if($i!=0 and fmod($i,$yy)==0 and $rep==""){echo "<tr>$header</tr>";}

echo "<tr$bc>";

	for($j=0;$j<count($headerArray);$j++){

	$var=$b[$i][$headerArray[$j]];
	if($headerArray[$j]=="pasu_ranking" and $var=="0"){$var="";}
	
$fieldName=$headerArray[$j];

	if($fieldName=="er_num"){$er=$var;}

	//if($fieldName=="user_id"){$var=substr($var,0,-2);}
	//if($fieldName=="status" and $var=="inactive"){$bc=" bgcolor='yellow'";}
	if($fieldName=="order_complete" and $var=="n"){$bc=" bgcolor='red'";}
	if($fieldName=="receive_complete" and $var=="n"){$bc=" bgcolor='orange'";}
	if($fieldName=="paid_in_full" and $var=="n"){$bc=" bgcolor='yellow'";}
	
	if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}
	
	if(in_array($headerArray[$j],$decimalFlds)){
	$a="<td align='right'$bc>";
	$totArray[$headerArray[$j]]+=$var;
	$var=numFormat($var);}
	
		else{$a="<td$bc>";}
		
			if(in_array($headerArray[$j],$editFlds)){

				if(in_array($headerArray[$j],$radioFlds)){
						if($fieldName=="district_approved"){if($var=="y"){
						$ckDAy="checked";$ckDAu="";
						$ckDAn="";}else{$ckDAn="checked";$ckDAy="";$ckDAu="";}
						if($var=="u"){$ckDAn="";$ckDAy="";$ckDAu="checked";}
						}
echo "<td align='center'>
<font color='green'>Y</font>
<input type='radio' name='$headerArray[$j][$er]' value='y' $ckDAy>
 <font color='red'>N</font>
 <input type='radio' name='$headerArray[$j][$er]' value='n' $ckDAn>
 <font color='blue'>U</font>
 <input type='radio' name='$headerArray[$j][$er]' value='u' $ckDAu>
 </td>";}			
	else
		{	$value="";$ro="";$js="";
$cs=10;
if($headerArray[$j]=="justification"){echo "<td $bc align='center'><textarea name='$headerArray[$j][$er]' cols='30' rows='4'>$var</textarea></td>";}
			else
			{echo "<td $bc align='center'><input type='text' name='$headerArray[$j][$er]' value='$var' size='$cs'$js></td>";}
				}
			}else{echo "$a$f1$var$f2</td>";}
	}
	
echo "</tr>";
	}

echo "<tr>";
	for($j=0;$j<count($headerArray);$j++){
	if($totArray[$headerArray[$j]] and $headerArray[$j]!="unit_cost"){
	$var=$totArray[$headerArray[$j]];
	if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}
	$v=numFormat($var);$xx=2;
	echo "<td align='right'><b>$v</b></td>";}else{echo "<td></td>";}
}


if(($level<3 and $_SESSION['budget']['centerSess']==$pay_center) OR $level==2){$edit=1;}

if($edit==1||$level>2){
if($location){$pay_center=$center;}
echo "</tr>
<tr><td colspan='2'>$num item(s)</td><td colspan='11' align='right'>
<input type='hidden' name='f_year' value='$f_year'>
<input type='hidden' name='passQuery' value='$passQuery'>
<input type='submit' name='submit' value='Update'>
</td></tr>";
}
echo "</form>";

if($rep==""){$footer="<tr><td colspan='4' align='center'>Equipment Budget <a href='popupex.html' onclick=\"return popitup('explain_search.php?subject=equipment')\">Terminology</a></td><td colspan='4'> Email Tony Bass with any problems you encounter. Email comments to <a href='mailto:tony.p.bass@ncmail.net?subject=Comments to Administrator-Equipment Budget Tool'>Administrator</a></td></tr>";}

echo "$footer</table>";

echo "</body></html>";

function numFormat($nf){
$nf=number_format($nf,2);
return $nf;}
?>



