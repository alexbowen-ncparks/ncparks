<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
include("../../../include/activity.php");
extract($_REQUEST);
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$level=$_SESSION['budget']['level'];
$beacnum=$_SESSION['budget']['beacon_num'];
$thisUser=$_SESSION['budget']['tempID'];
if($level<2 AND !$center){

// $pay_center=$_SESSION['budget']['centerSess'];
if($_SESSION['budget']['centerSess']=='12802857')
{$pay_center='1680547';}
else
{$pay_center=$_SESSION['budget']['centerSess_new'];}
$center=$pay_center;
}

//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";//exit;

if($del!=""){
$sql="DELETE from equipment_request_3 where er_num='$del' and division_approved !='y'";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$sql="OPTIMIZE  TABLE  `equipment_request_3`";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
}


// Construct Query to be passed to Excel Export
foreach($_REQUEST as $k => $v){
if($v and $k!="PHPSESSID" and $k!="del"){$varQuery.=$k."=".$v."&";}
}
$passQuery=$varQuery;
   $varQuery.="rep=excel";    


if(@$rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=park_equip_request.xls');
}

// Get f_year
include("../~f_year.php");

if(@$rep==""){include_once("../menu.php");
//$f_year='1920';


$query32="select fyear as 'f_year' from budget_request_acceptable_dates where budget_group='equipment'  " ;
		  
//echo "<br />query32=$query32<br />";	

	  
$result32 = mysqli_query($connection, $query32) or die ("Couldn't execute query32. $query32");
$row32=mysqli_fetch_array($result32);
extract($row32);


echo "<br />f_year=$f_year<br />";
if($level==2)
	{
	switch ($_SESSION['budget']['select'])
		{
				case "SODI":
					$w="and district='south'";
					$pu="and (district='south')";
		$distCode="south";
					break;	
				case "NODI":
					$w="and district='north'";
					$pu="and (district='north')";
		$distCode="north";
					break;	
				case "EADI":
					$w="and district='east'";
					$pu="and (district='east')";
		$distCode="east";
					break;	
				case "WEDI":
					$w="and district='west'";
					$pu="and (district='west')";
		$distCode="west";
					break;	
		}// end switch
		
	$D=$distCode."-NCAS";
	$DP=$distCode."-PARK";
	
	$array1=array($D,$DP);
	
	//$where="where dist='$distCode' and section='operations' and fund='1280' or fund='1932' ";
	   $where="where dist='$distCode' and section='operations' and new_fund='1680' ";
	
	
	if(@$rep==""){
	$sql="SELECT section,parkcode,new_center as varCenter from center $where order by section,parkcode,new_center";
	
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result)){
	extract($row);$pc[]=$parkcode;$c[]=$varCenter;$sec[]=$section;}
	
	echo "<table align='center'><form><tr>";
	
	echo "<td><select name=\"center\"><option selected>Select Center</option>";
	for ($n=0;$n<count($c);$n++){
	$con=$c[$n];
	if($center==$con){$s="selected";}else{$s="value";}
			echo "<option $s='$con'>$sec[$n]-$pc[$n]-$c[$n]\n";
		   }
	   echo "</select>  FY <input type='text' name='f_year' value='$f_year' size='5' READONLY> <input type='submit' name='submit' value='Submit'></td></form></tr></table>";}
	}// end level=2

/*
$S=$_SESSION['budget']['centerSess'];
// Kludge to allow NERI to also work with MOJE
if($S=="12802859"||$S=="12802857"){
$file0=$_SERVER[PHP_SELF];
$file=$file0."?center=$center&m=1&submit=Submit&parkcode=";

$daCode=array("NERI","MOJE"); //print_r($daCode);exit;
$daCenter=array("12802859","12802857"); //print_r($daCenter);exit;

	if($parkcode=="MOJE"){$center="12802857";
	$_SESSION[budget][centerSess]="12802857";
	}
	else
	{$center="12802859";$_SESSION[budget][centerSess]="12802859";}

echo "<tr><td><form><select name=\"center\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select Center</option>";$s="value";
for ($n=0;$n<count($daCode);$n++){
$con1=$file.$daCode[$n];
		echo "<option $s='$con1'>$daCode[$n]-$daCenter[$n]\n";
       }
   echo "</select></td>";}
   
// Kludge to allow a Superintendent to have access to two parks
// Used when someone is promoted to a new park but still needs old park
if($S=="12802808"||$S=="12802860"){// FOFI  and   PIMO
$file0=$_SERVER[PHP_SELF];
$file=$file0."?center=$center&m=1&submit=Submit&parkcode=";

$daCode=array("FOFI","PIMO"); //print_r($daCode);exit;
$daCenter=array("12802808","12802860"); //print_r($daCenter);exit;

	if($parkcode=="FOFI"){$center="12802808";
	$_SESSION[budget][centerSess]="12802808";
	}
	else
	{$center="12802860";$_SESSION[budget][centerSess]="12802860";}

echo "<tr><td><form><select name=\"center\" onChange=\"MM_jumpMenu('parent',this,0)\"><option selected>Select Center</option>";$s="value";
for ($n=0;$n<count($daCode);$n++){
$con1=$file.$daCode[$n];
		echo "<option $s='$con1'>$daCode[$n]-$daCenter[$n]\n";
       }
   echo "</select></td>";}
*/
}

if(@$showSQL==1){$p="method='POST'";}

if($submit!="Submit"){exit;}

// ********* Body Queries ***************
date_default_timezone_set('America/New_York');

$today=date("Y-m-d");
$sql="Select start_date,end_date
 from budget_request_acceptable_dates
 where budget_group='equipment'
 order by budget_group";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);
extract($row);
if($today>=$start_date and $today<=$end_date){}else{$menuList=1;}


$pay_center=$_SESSION['budget']['centerSess'];
if($center){$pay_center=$center;}// override


/*select query for center budgets*/

//funding_source,
$sql="select 
er_num,
user_id,
system_entry_date,
status,
f_year,
purchaser,
location,
pay_center,
category,
equipment_description,
ncas_account,
unit_quantity,
unit_cost,
(unit_quantity*unit_cost) as requested_amount,
funding_source,
equipment_type,
justification,
pasu_ranking,
pasu_priority,
disu_priority,
district_approved,
division_approved,
status,
bo_comments
from equipment_request_3
where 1
and pay_center='$pay_center'
and f_year='$f_year'";

if($level>4 and @$rep==""){echo "$sql<br>";}//exit;

if(@$showSQL=="1"){echo "$sql<br>";}

//"funding_source",
if($level<5)
$headerArray=array("er_num","user_id","system_entry_date","f_year","purchaser","location","pay_center","category","equipment_description","ncas_account","unit_quantity","unit_cost","requested_amount","funding_source","equipment_type","justification","pasu_ranking","district_approved","division_approved","bo_comments");
if($level==5)
$headerArray=array("er_num","user_id","system_entry_date","f_year","purchaser","location","pay_center","category","equipment_description","ncas_account","unit_quantity","unit_cost","requested_amount","funding_source","equipment_type","justification","pasu_ranking","district_approved","division_approved","bo_comments");

//,"status","pasu_priority","disu_priority"

$count=count($headerArray);
for($i=0;$i<$count;$i++){
$h=$headerArray[$i];
$header.="<th>".$h."</th>";
$header=str_replace("_"," ",$header);}

$sql2="Select start_date,end_date
 from budget_request_acceptable_dates
 where budget_group='equipment'
 order by budget_group";
$result2 = mysqli_query($connection, $sql2) or die ("Couldn't execute query. $sql2");
$row2=mysqli_fetch_array($result2);
extract($row2);
$today=date("Y-m-d");
if($level==1){$s=$start_date;$f=$end_date;}
if($level==2){$s=$start_date;$f=$end_date;}
if($level<3){$t="All requests MUST be made from <font color='red'>$s to $f</font>.";}

echo "<table><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Report Date: <font color='red'>$today</font>
&nbsp;&nbsp;&nbsp; $t

</td>";
if($level==1)
{
echo "<td></td><td><a href='/budget/aDiv/equipment_requests_prior_years.php' target='_blank' ><font class='cartRow'>View Previous Years Equipment Requests</font></a></td>";
}
echo "</tr></table>";

echo "<table border='1'>";
if(@$rep==""){
echo "<tr bgcolor='lightgray'><th colspan='3'><font color='red'>Existing Requests</font></th><td colspan='2'> Excel <a href='park_equip_request.php?$varQuery'>Export</a></td></tr>";

echo "
<form ID=\"equip_request_1\" NAME=\"equip_request_1\" action='park_equip_request_update.php' method='POST'>
";}
else{echo "<tr>$header</tr>";}

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);

while($row=mysqli_fetch_array($result)){
$b[]=$row;
}// end while
//echo "<pre>";print_r($b);echo "</pre>";exit;

$pullDownFlds=array("equipment_type","category","purchaser","location","funding_source","pasu_priority");
//,"status"

$decimalFlds=array("requested_amount","approved_amount","ordered_amount", "unordered_amount","surplus_deficit","unit_cost");

// *************** Non-excel *************
if(@$rep=="") {
$level5fld=array("district_approved","division_approved");

if($level>2){
$editFlds=array("equipment_type","purchaser","location","pay_center","funding_source","category","equipment_description","unit_quantity","unit_cost","requested_amount","justification");}
//,"pasu_priority","disu_priority","status"
else{
$editFlds=array("equipment_type","purchaser","location","pay_center","category","equipment_description","unit_quantity","unit_cost","requested_amount","justification","pasu_ranking");}
//,"pasu_priority","status"
//"funding_source",
}

if(@$rep==""){
$x=2;
$yy=10;

	for($i=0;$i<count($b);$i++){
	$r=fmod($i,$x);if($r==0){$bc=" bgcolor='aliceblue'";}else{$bc="";}
	
if(fmod($i,$yy)==0 and @$rep==""){echo "<tr>$header</tr>";}

echo "<tr$bc>";
	for($j=0;$j<count($headerArray);$j++){

	$var=$b[$i][$headerArray[$j]];
	
$fieldName=$headerArray[$j];

	if($fieldName=="er_num"){
	$er=$var;
	
	$checkDist=$b[$i][district_approved];
	$checkDiv=$b[$i][division_approved];
	if($checkDist=="u" and $checkDiv=="u"){$var=$er." <a href='park_equip_request.php?del=$er&center=$center&m=1&submit=Submit' onClick='return confirmLink()'><img src='button_drop.png'></a>";}else{$var=$er;}
	}
	
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

// **********
	if(in_array($headerArray[$j],$editFlds) AND ($checkDist=="u" and $checkDiv=="u")){
			$trackEdit++;//used to determine whether to all Update
	if(in_array($headerArray[$j],$pullDownFlds)){
	
echo "<td align='center'>";


if($headerArray[$j]=="category"){
$sql="SELECT concat( category, '=', ncas_account ) as concatMenu,category,ncas_account
FROM purchasing_products
WHERE 1
ORDER BY category";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$menuArray[]="";
while($row=mysqli_fetch_array($result)){
$menuArray[$row[category]]=strtoupper($row[concatMenu]);
$menuNCAS[$row[category]]=$row[ncas_account];
}// end while
//print_r($menuNCAS);
}

if($headerArray[$j]=="equipment_type"){$menuArray=array("new"=>"new","replacement"=>"replacement");}

if($headerArray[$j]=="funding_source"){
	
//if($level<5){
//$menuArray=array("opex_transfer");}
//else
//{
//$menuArray=array("equipment","opex_transfer");
//$menuArray=array("equipment");
//Updated per Tammy Dodd's request Aug 02, 2021
$menuArray=array("Equipment_RegularFunds","Equipment_OpexTransfer","Equipment_OpexReserve","Equipment_CarryForward","Equipment_SpecialFunds","Equipment_LapseSalary","Equipment_DefRevenue");
//}

//$menuArray=array("approp"=>"approp","opreserve"=>"opreserve","opex_transfer"=>"opex_transfer"

	}
//
if($headerArray[$j]=="purchaser"){//,fullname as pur
$sql="SELECT code
FROM `purchasing_purchasers`
WHERE 1
ORDER BY code ASC
";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$menuArray[]="";
while($row=mysqli_fetch_array($result)){
//$menuArray[$row[code]]=strtoupper($row[pur]);
$menuArray[$row[code]]=$row[code];
}// end while
}

if($headerArray[$j]=="location"){
$sql="select distinct(location) as loc from equipment_request_3 where 1 order by location";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result)){
$menuArray[$row[loc]]=strtoupper($row[loc]);}// end while
}

// Make Pull-downs
echo "<select name='$headerArray[$j][$er]'>";
//if($headerArray[$j]=="category"){$ncas_acctMenu=$menuNCAS;}
//if($headerArray[$j]=="purchaser"){$ncas_purMenu=$menuArray;}

foreach($menuArray as $k=>$v){
if($headerArray[$j]=="category"){$v=$k;$vv=$k;$v=strtoupper($v);$k=strtolower($menuArray[$k]);}
if($headerArray[$j]=="purchaser"){$v=$k;$vv=$menuArray[$k];$v=strtoupper($v);}

if(strtoupper($var)==strtoupper($v)){$s="selected";}else{$s="value";}

if($headerArray[$j]=="category"){$v=$v."=".$menuNCAS[$vv];}
if($headerArray[$j]=="purchaser"){$v=$vv;}

echo "<option $s='$k'>$v</option>\n";}
echo "</select></td>";
unset($menuArray);
}// end Pull-down
else
			
			{
			$value="";$ro="";$js="";
$cs=10;
if($headerArray[$j]=="justification"||$headerArray[$j]=="equipment_description"){$cs=30;$rs=4;}

if($headerArray[$j]=="unit_quantity"||$headerArray[$j]=="pasu_ranking"){$cs=5;$rs=1;}
			
		//	echo "<td $bc align='center'><input type='text' name='$headerArray[$j][$er]' value='$var' size='$cs'$js></td>";
			echo "<td align='center'><textarea name='$headerArray[$j][$er]' cols='$cs' rows='$rs'>$var</textarea></td>";												
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


if(($level<3 and $_SESSION['budget']['centerSess_new']==$pay_center) OR $level==2){$edit=1;}


$unit=$_SESSION['budget']['select'];
IF($unit=="NERI" || $unit=="MOJE"){
// MOJE=12802857   NERI=12802859
if($center=="12802857" OR $center=="12802859" or $center=="1680549" or $center=="1680547"){$edit=1;}
}

if(($edit==1 || $level>2) and @$trackEdit){
if($location){$pay_center=$center;}
echo "</tr>
<tr><td colspan='2'>$num item(s)</td><td colspan='11' align='right'>
<input type='hidden' name='f_year' value='$f_year'>
<input type='hidden' name='passQuery' value='$passQuery'>
<input type='submit' name='submit' value='Update'>
</td></tr>";
}
echo "</form>";

//  ************** Add New Record Form ********
include("../../../include/get_parkcodes.php");

mysqli_select_db($connection, $database);
echo "<tr bgcolor='lightgray'><th colspan='3'><font color='blue'>New Request</font></th><form ID=\"equip_request_2\" NAME=\"equip_request_2\" action='park_equip_request_update.php' method='POST'>";

$today=date("Y-m-d");
$sql="Select start_date,end_date
 from budget_request_acceptable_dates
 where budget_group='equipment'
 order by budget_group";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);
extract($row);
if($today>=$start_date and $today<=$end_date){}else{$menuList=1;}

if($level>1)
	{	$editFlds=array("equipment_type","user_id","f_year","purchaser","location","pay_center","funding_source","category","equipment_description","unit_quantity","unit_cost","requested_amount","justification");
	}
//,"pasu_priority","disu_priority","status"
else{
$editFlds=array("equipment_type","user_id","f_year","purchaser","location","pay_center","funding_source","category","equipment_description","unit_quantity","unit_cost","requested_amount","justification");}
//,"pasu_priority","status"

if($level>4){$editFlds[]="bo_comments";}

$pullDownFlds=array("equipment_type","category","purchaser","location","funding_source");
//,"pasu_priority","disu_priority","status"

if($level>2){$pullDownFlds[]="pay_center";}

$textFlds=array("equipment_description","justification","bo_comments");

$decimalFlds=array("requested_amount","unit_cost");

$skip=array("ncas_account");

echo "<td colspan='$j'>&nbsp;</td></tr><tr>";

	for($j=0;$j<count($headerArray);$j++){
	if(in_array($headerArray[$j],$skip)){continue;}
	$headerMod=str_replace("_"," ",$headerArray[$j]);
	echo "<td align='right'><b>$headerMod</b></td>";}
echo "</tr><tr>";


for($j=0;$j<count($headerArray);$j++){
	
	if(in_array($headerArray[$j],$skip)){continue;}
	
	
	if(in_array($headerArray[$j],$decimalFlds)){
	$a="<td align='right'>";
			}else{$a="<td>";}
			if((in_array($headerArray[$j],$editFlds)) OR in_array($headerArray[$j],$level5fld) ){
			$cs="8";
	
	if(in_array($headerArray[$j],$pullDownFlds)){
	
echo "<td align='center'>";
if($headerArray[$j]=="category"){
$sql="SELECT concat( category, '=', ncas_account ) as concatMenu
FROM purchasing_products
WHERE 1
ORDER BY category";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$menuArray[]="";
while($row=mysqli_fetch_array($result))
	{
	$menuArray[$row['concatMenu']]=strtoupper($row['concatMenu']);}// end while
	}

if($headerArray[$j]=="equipment_type"){$menuArray=array("new","replacement");}

if($headerArray[$j]=="funding_source"){
//$sql="select * from equipment_funding_deadlines where source='approp'";
//$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
//$row=mysqli_fetch_array($result);

//if($level<5){$menuArray=array("opex_transfer");}
//else
//{
//$menuArray=array("equipment","opex_transfer");
//$menuArray=array("equipment");
//Updated per Tammy Dodd's request to the below from the above, Aug 02, 2021
$menuArray=array("Equipment_RegularFunds","Equipment_OpexTransfer","Equipment_OpexReserve","Equipment_CarryForward","Equipment_SpecialFunds","Equipment_LapseSalary","Equipment_DefRevenue");
//}

//$menuArray=array("approp","opreserve","opex_transfer");
}

if($headerArray[$j]=="purchaser"){
$sql="SELECT code,fullname as pur
FROM `purchasing_purchasers`
WHERE 1
ORDER BY code ASC
";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$menuArray[]="";
while($row=mysqli_fetch_array($result))
	{
	$menuArray[$row['code']]=strtoupper($row['pur']);}// end while
}

if($headerArray[$j]=="location"){
$parkCodeName['ARCH']="Archdale";
$parkCodeName[]="";
$parkCodeName['ASRO']="Asheville Regional Office";
$parkCodeName['WARO']="Washington Regional Office";
$parkCodeName['WSRO']="Winston-Salem Regional Office";
$menuArray=$parkCodeName;
asort($menuArray);
}
//echo "<pre>"; print_r($menuArray); echo "</pre>"; // exit;
if($headerArray[$j]=="pay_center")
	{
	$sql="SELECT section,parkcode,center as varCenter from center where (fund='1280'  or fund='1932') order by section,parkcode,center";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
	$menuArray[]="";
	while ($row=mysqli_fetch_array($result))
		{	$menuArray[$row['varCenter']]=$row['parkcode']."-".$row['varCenter']."-".$row['section'];
		}
	}

echo "<select name='$headerArray[$j]'>";

foreach($menuArray as $k=>$v)
	{
	if(@$var==$v){$s="selected";}else{$s="value";}
	
	if($headerArray[$j]=="purchaser"||$headerArray[$j]=="pay_center"||$headerArray[$j]=="location")
	{
	$kv=$k;
	}
	else
	{
	$kv=$v;
	}
	if($headerArray[$j]=="purchaser" || $headerArray[$j]=="location")
		{
	//	if($_SESSION['budget']['select']==$kv){$s="selected";}else{$s="value";}
		}
$s="value";  // if park auto set then full name sent NOT the park code
	echo "<option $s='$kv'>$v</option>\n";}
echo "</select></td>";
unset($menuArray);}// end Pull-downs
else{
			if(in_array($headerArray[$j],$textFlds)){echo "<td align='center'><textarea name='$headerArray[$j]' cols='30' rows='4'></textarea></td>";}
		else{
			$value="";$ro="";$js="";
			if($headerArray[$j]=="user_id"){$value=substr($thisUser,0,-2);$ro="READONLY";}
			if($headerArray[$j]=="f_year")
			{
			if($beacnum != '60032781')
			{				
				$value=$f_year;$ro="READONLY";
			}
			
		    if($beacnum == '60032781')
			{
                $value=$f_year;$ro="READONLY";
			}
		
		    }
			if($headerArray[$j]=="pay_center"){$value=$center;
			if($level<2){$ro="READONLY";}
			}
			
			
			if($headerArray[$j]=="unit_quantity"){$js=" onKeyUp=\"calc_add()\"";}
			if($headerArray[$j]=="unit_cost"){$js=" onKeyUp=\"calc_add()\"";}
			
			if($headerArray[$j]=="requested_amount"){$ro="READONLY";}
			
			if($headerArray[$j]=="division_approved"){
			$value="u";
			if($level<5){$ro="READONLY";}
			}
			
			if($headerArray[$j]=="district_approved"){
			$value="u";
			if($level<2){$ro="READONLY";}
			}
			echo "<td align='center'><input type='text' name='$headerArray[$j]' size='$cs' value='$value'$ro$js></td>";}
				}// end edit non-Pull_downs
			}// end editFlds
			else{
		
if($headerArray[$j]=="system_entry_date"){$value=date("Y-m-d");}else{$value="";}	
			echo "<td>$value</td>";}	
	}
	
// ************ 	

if($today>=$start_date and $today<=$end_date){}else{$upDate=1;}
//echo "upDate=$upDate";
//if(!$upDate || $level>3){
//if($level>4){
$cs=$j-2;
if(!$upDate or $level>4){
echo "</tr>
<tr><td colspan='$cs' align='right'>
<input type='hidden' name='f_year' value='$f_year'>
<input type='hidden' name='passQuery' value='$passQuery'>
<input type='submit' name='submit' value='Add'></td></form></tr>";
}
else
{echo "</tr><tr><td colspan='5'><font color='red'>Equipment Requests must be made during period: $start_date thru $end_date.</font></td></tr>";}

$footer="<tr><td colspan='4' align='center'>Equipment Budget <a href='popupex.html' onclick=\"return popitup('explain_search.php?subject=equipment')\">Terminology</a></td><td colspan='4'> Email Tony Bass with any problems you encounter. Email comments to <a href='mailto:database.support@ncparks.gov?subject=Comments to Administrator-Equipment Budget Tool'>Administrator</a></td></tr>";

echo "$footer</table>";

//echo "<pre>";print_r($ncas_purMenu);echo "</pre>";

echo "</body></html>";
}

// *********** Excel Export ************
if(@$rep=="excel")
{
	for($i=0;$i<count($b);$i++){
	
echo "<tr>";
	for($j=0;$j<count($headerArray);$j++){

	$var=$b[$i][$headerArray[$j]];
	
$fieldName=$headerArray[$j];

	if($fieldName=="f_year"){$var="'".$var;}
	
	
	if(in_array($headerArray[$j],$decimalFlds)){
	$a="<td align='right'>";
	$totArray[$headerArray[$j]]+=$var;
	$var=numFormat($var);}
		else{$a="<td>";}
		
		echo "$a$var</td>";
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


echo "</tr></table>";

//echo "<pre>";print_r($ncas_purMenu);echo "</pre>";

echo "</body></html>";
}// Excel export

function numFormat($nf){
$nf=number_format($nf,2);
return $nf;}
?>



