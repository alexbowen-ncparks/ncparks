<?php
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
extract($_REQUEST);

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$level=$_SESSION['budget']['level'];
$thisUser=$_SESSION['budget']['tempID'];
if($level<2 AND !$center){

$pay_center=$_SESSION['budget']['centerSess'];
$center=$pay_center;}

// Construct Query to be passed to Excel Export
foreach($_REQUEST as $k => $v){
if($v and $k!="PHPSESSID" and $k!="del"){$varQuery.=$k."=".$v."&";}
}
$passQuery=$varQuery;
   $varQuery.="rep=excel";    


if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=park_purchase_request.xls');
}

// Get f_year
include("../~f_year.php");

if($rep==""){include_once("../menu.php");

if($level==2){
switch ($_SESSION['budget']['select']) {
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


$where="where 1";

$where1="where 1 and dist='$distCode' and section='operations' and fund='1280'";

if($rep==""){
$sql="SELECT section,parkcode,center as varCenter from center $where1 order by section,parkcode,center";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$pc[]=$parkcode;$c[]=$varCenter;$sec[]=$section;}

/*
echo "<table align='center'><form><tr>";

echo "<td><select name=\"center\"><option selected>Select Center</option>";
for ($n=0;$n<count($c);$n++){
$con=$c[$n];
if($center==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$sec[$n]-$pc[$n]-$c[$n]\n";
       }
   echo "</select>  FY <input type='text' name='f_year' value='$f_year' size='5' READONLY> <input type='submit' name='submit' value='Submit'></td></form></tr></table>";
*/
 
 }

}// end level=2


}

if($showSQL==1){$p="method='POST'";}

if($submit!="Submit"){exit;}

// ********* Body Queries ***************

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

if($level==1){$where="where 1 and pay_center='$pay_center'";}

if($report_date==""){$where = "where 1";}


/*select query for center budgets*/
$sql="select
pa_number,
section,
district,
center_code,
pay_center,
user_id,
system_entry_date,
purchase_description,
ncas_account,
sum(unit_quantity*unit_cost) as 'requested_amount',
purchase_type,
purchase_date,
justification,
district_approved,
disu_comments,
section_approved,
division_approved,
bo_comments
from purchase_request_3
$where
and report_date='$report_date'
group by pa_number
order by section,district,center_code
";

//if($level>4 and $rep==""){echo "$sql<br>";}//exit;

if($showSQL=="1"){echo "$sql<br>";}

$headerArray=array("pa_number","user_id","system_entry_date","f_year","purchaser","location","pay_center","purchase_description","ncas_account","unit_quantity","unit_cost","requested_amount","purchase_type","purchase_date","justification","district_approved","disu_comments","section_approved","division_approved","bo_comments");
//,"status","pasu_priority","disu_priority","pasu_ranking"
//"funding_source","category",

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


echo "<table border='1'>";
if($rep=="" AND $report_date!=""){
echo "<tr bgcolor='lightgray'><th colspan='3'><font color='red'>Existing Requests</font></th><td colspan='2'> Excel <a href='park_purchase_request.php?$varQuery'>Export</a></td></tr>";

echo "
<form ID=\"equip_request_1\" NAME=\"equip_request_1\" action='park_purchase_request_update.php' method='POST'>
";}
else{
	if($report_date!=""){echo "<tr>$header</tr>";}
	}

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query main SELECT. $sql");
$num=mysqli_num_rows($result);

while($row=mysqli_fetch_array($result)){
$b[]=$row;
}// end while
//echo "<pre>";print_r($b);echo "</pre>";exit;

$pullDownFlds=array("purchase_type","category","purchaser","location","funding_source","pasu_priority");
//,"status"

$decimalFlds=array("requested_amount","approved_amount","ordered_amount", "unordered_amount","surplus_deficit","unit_cost");

// *************** Non-excel *************
if(@$rep=="")
	{
	$level5fld=array("district_approved","disu_comments","section_approved","division_approved");
	
	if($level>1){
	$editFlds=array("purchase_date","purchase_type","purchaser","location","pay_center","funding_source","category","purchase_description","ncas_account","unit_quantity","unit_cost","requested_amount","justification");}
	//,"pasu_priority","disu_priority","status"
	else{
	$editFlds=array("purchase_date","purchase_type","purchaser","location","pay_center","funding_source","category","purchase_description","ncas_account","unit_quantity","unit_cost","requested_amount","justification","pasu_ranking");}
	//,"pasu_priority","status"
	}

if(@$rep=="")
	{
	
	if($report_date!=""){
	$x=2;
	$yy=10;
	
		for($i=0;$i<count($b);$i++){
		$r=fmod($i,$x);if($r==0){$bc=" bgcolor='aliceblue'";}else{$bc="";}
		
	if(fmod($i,$yy)==0 and $rep==""){echo "<tr>$header</tr>";}
	
	echo "<tr$bc>";
		for($j=0;$j<count($headerArray);$j++){
	
		$var=$b[$i][$headerArray[$j]];
		
	$fieldName=$headerArray[$j];
	
		if($fieldName=="pa_number"){
		$pa=$var;
		
		$checkDist=$b[$i]['district_approved'];
		$checkSect=$b[$i]['section_approved'];
		$checkDiv=$b[$i]['division_approved'];
		if($checkDist=="u" and $checkSect=="u" and $checkDiv=="u"){$var=$pa." <a href='park_purchase_request.php?del=$pa&center=$center&m=1&submit=Submit' onClick='return confirmLink()'><img src='button_drop.png'></a>";}else{$var=$pa;}
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
		if(in_array($headerArray[$j],$editFlds) AND ($checkDist=="u" and $checkDiv=="u" and $checkSect=="u")){
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
	
	if($headerArray[$j]=="purchase_type"){$menuArray=array("purchase4resale"=>"purchase4resale","mission_critical"=>"mission_critical","emergency"=>"emergency");}
	
	if($headerArray[$j]=="funding_source"){
		
	if($level<5 and $row['end_date']<date('Y-m-d')){
	$menuArray=array("opex_transfer");}
	else
	{$menuArray=array("approp","opreserve","opex_transfer");}
	
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
	$menuArray[$row[code]]=$row['code'];
	}// end while
	}
	
	if($headerArray[$j]=="location"){
	$sql="select distinct(location) as loc from purchase_request_3 where 1 order by location";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_array($result)){
	$menuArray[$row[loc]]=strtoupper($row['loc']);}// end while
	}
	
	// Make Pull-downs
	echo "<select name='$headerArray[$j][$pa]'>";
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
	if($headerArray[$j]=="justification"||$headerArray[$j]=="purchase_description"){$cs=30;$rs=4;}
	
	if($headerArray[$j]=="unit_quantity"||$headerArray[$j]=="pasu_ranking"){$cs=5;$rs=1;}
				
				if($headerArray[$j]=="disu_comments" AND $level<2){$ro="READONLY";}	
				echo "<td align='center'><textarea name='$headerArray[$j][$pa]' cols='$cs' rows='$rs' $ro>$var</textarea></td>";												
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
	
	
	$unit=$_SESSION['budget']['select'];
	IF($unit=="NERI" || $unit=="MOJE"){
	// MOJE=12802857   NERI=12802859
	if($center=="12802857" OR $center=="12802859"){$edit=1;}
	}
	
	if(($edit==1||$level>2) and $trackEdit){
	if($location){$pay_center=$center;}
	echo "</tr>
	<tr><td colspan='2'>$num item(s)</td><td colspan='11' align='right'>
	<input type='hidden' name='f_year' value='$f_year'>
	<input type='hidden' name='passQuery' value='$passQuery'>
	<input type='submit' name='submit' value='Update'>
	</td></tr></table>";
	}
	echo "</form>";
	
	}
	
	//  ************** Add New Record Form ********
	include("../../../include/parkcodesDiv.inc");
	
	echo "<form ID=\"equip_request_2\" NAME=\"equip_request_2\" action='park_purchase_request_update.php' method='POST'>
	
	<table border='1'><tr bgcolor='lightgray'><th colspan='6'><font color='blue'>New Purchase Request</font></th>";
	
	$today=date("Y-m-d");
	$sql="Select start_date,end_date
	 from budget_request_acceptable_dates
	 where budget_group='equipment'
	 order by budget_group";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	if($today>=$start_date and $today<=$end_date){}else{$menuList=1;}
	
	if($level>1){
	$editFlds=array("purchase_date","purchase_type","user_id","f_year","purchaser","location","pay_center","funding_source","category","purchase_description","ncas_account","unit_quantity","unit_cost","requested_amount","justification");}
	//,"pasu_priority","disu_priority","status"
	else{
	$editFlds=array("purchase_date","purchase_type","user_id","f_year","purchaser","location","pay_center","funding_source","category","purchase_description","ncas_account","unit_quantity","unit_cost","requested_amount","justification");}
	//,"pasu_priority","status"
	
	if($level>4){$editFlds[]="bo_comments";}
	
	$pullDownFlds=array("purchase_type","category","purchaser","location","funding_source");
	//,"pasu_priority","disu_priority","status"
	
	if($level>1){$pullDownFlds[]="pay_center";}
	
	$textFlds=array("purchase_description","disu_comments","justification","bo_comments");
	
	$decimalFlds=array("requested_amount","unit_cost");
	
	//echo "<td>$headerArray[$j]</td><td colspan='$j'>&nbsp;</td></tr><tr>";
	
		for($j=0;$j<count($headerArray);$j++){
		$headerMod=str_replace("_"," ",$headerArray[$j]);
		//echo "<td align='right'><b>$headerMod</b></td>";
		}
	//echo "</tr>";
	
	
	for($j=0;$j<count($headerArray);$j++){
		
		if(in_array($headerArray[$j],$decimalFlds)){
		$a="<tr><td align='right'>";
				}else{$a="<tr><td>";}
				if((in_array($headerArray[$j],$editFlds)) OR in_array($headerArray[$j],$level5fld) ){
				$cs="8";
		
		if(in_array($headerArray[$j],$pullDownFlds)){
		
	echo "<tr><td>$headerArray[$j]</td><td align='left'>";
	if($headerArray[$j]=="category"){
	$sql="SELECT concat( category, '=', ncas_account ) as concatMenu
	FROM purchasing_products
	WHERE 1
	ORDER BY category";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$menuArray[]="";
	while($row=mysqli_fetch_array($result)){
	$menuArray[$row['concatMenu']]=strtoupper($row['concatMenu']);}// end while
	}
	
	if($headerArray[$j]=="purchase_type"){$menuArray=array("purchase4resale"=>"purchase4resale","mission_critical"=>"mission_critical","emergency"=>"emergency");}
	
	if($headerArray[$j]=="funding_source"){
	$sql="select * from equipment_funding_deadlines where source='approp'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	
	if($menuList==1 and $level<5 and $row['end_date']<date('Y-m-d')){$menuArray=array("opex_transfer");}
	else
	{$menuArray=array("approp","opreserve","opex_transfer");}
	
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
	while($row=mysqli_fetch_array($result)){
	$menuArray[$row[code]]=strtoupper($row[pur]);}// end while
	}
	
	if($headerArray[$j]=="location"){
	$parkCodeName['ASRO']="Asheville Regional Office";
	$parkCodeName['WARO']="Washington Regional Office";
	$parkCodeName['WSRO']="Winston-Salem Regional Office";
	$menuArray=$parkCodeName;
	asort($menuArray);
	}
	//echo "<pre>"; print_r($menuArray); echo "</pre>"; // exit;
	if($headerArray[$j]=="pay_center"){
	$sql="SELECT section,parkcode,center as varCenter from center where (fund='1280'  OR fund='2803') order by section,parkcode,center";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
	$menuArray[]="";
	while ($row=mysqli_fetch_array($result)){
	$menuArray[$row['varCenter']]=strtoupper($row['parkcode'])."-".$row['varCenter']."-".$row['section'];}
	}
	
	echo "<select name='$headerArray[$j]'>";
	
	foreach($menuArray as $k=>$v){
	
	
	if($headerArray[$j]=="purchaser"||$headerArray[$j]=="pay_center"||$headerArray[$j]=="location"){
			$kv=$k;
			$var=$_SESSION['budget']['select'];
			if($headerArray[$j]=="pay_center"){$var=$_SESSION['budget']['centerSess'];}
			if($var=="EADI"){$var="EADO";}
			if($var=="NODI"){$var="NODO";}
			if($var=="SODI"){$var="SODO";}
			if($var=="WEDI"){$var="WEDO";}
			}
			
		else{$kv=$v;}
	
	//if($var==$kv){$s="selected";}else{$s="value";}
	$s="value";
	echo "<option $s='$kv'>$v</option>\n";}
	echo "</select></td></tr>";
	unset($menuArray);}// end Pull-downs
	else{
				$ro="";
				if(in_array($headerArray[$j],$textFlds)){
				if($headerArray[$j]=="disu_comments" AND $level<2){$ro="READONLY";}	
				echo "<tr><td>$headerArray[$j]</td><td align='left'><textarea name='$headerArray[$j]' cols='50' rows='4' $ro></textarea></td></tr>";}
			else{
				$value="";$ro="";$js="";
				if($headerArray[$j]=="user_id"){$value=substr($thisUser,0,-2);$ro="READONLY";}
				if($headerArray[$j]=="f_year"){$value=$f_year;$ro="READONLY";}
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
				
				if($headerArray[$j]=="section_approved"){
				$value="u";
				if($level<3){$ro="READONLY";}
				}
				
				if($headerArray[$j]=="district_approved"){
				$value="u";
				if($level<2){$ro="READONLY";}
				}
				
				if($headerArray[$j]=="disu_comments"){
				$value="";
				if($level<2){$ro="READONLY";}
				}
				
				$text0="";$text1="";$text2="";
				if($headerArray[$j]=="purchase_date"){
				$text0="<font color='red'>m/d/yy</font>";
				$text1="Required for"; $text2="<font color='red'>emergency</font>";}
				
				if($headerArray[$j]=="unit_quantity" OR $headerArray[$j]=="unit_cost" OR $headerArray[$j]=="ncas_account"){
				if($headerArray[$j]=="unit_quantity"){$value=1;}
				$text1="<font color='green'>Required =></font>";}
				
				echo "<tr><td>$headerArray[$j] $text0</td><td align='left'>$text1<input type='text' name='$headerArray[$j]' size='$cs' value='$value'$ro$js>$text2</td></tr>";}
					}// end edit non-Pull_downs
				}// end editFlds
				else{
			
	if($headerArray[$j]=="system_entry_date"){$value=date("Y-m-d");}else{$value="";}	
				echo "<tr><td>$headerArray[$j]</td><td>$value</td></tr>";}	
		}
		
	// ************ 	
	
	//if($today>=$start_date and $today<=$end_date){}else{$upDate=1;}
	
	//if(!$upDate || $level>3){
	//if($level>1){
	$cs=$j-2;
	echo "
	<tr><td colspan='$cs' align='right'>
	<input type='hidden' name='f_year' value='$f_year'>
	<input type='hidden' name='passQuery' value='$passQuery'>
	<input type='submit' name='submit' value='Add'></td></form></tr>";
	//}
	//else
	//{echo "</tr><tr><td colspan='5'><font color='red'>The time period [$start_date to $end_date] for adding equipment has passed.</font></td></tr>";}
	
	$footer="<tr><td colspan='7'> Email Tony Bass with any problems you encounter. Email comments to <a href='mailto:tony.p.bass@ncmail.net?subject=Comments to Administrator-Equipment Budget Tool'>Administrator</a></td></tr>";
	//<td colspan='4' align='left'>Equipment Budget <a href='popupex.html' onclick=\"return popitup('explain_search.php?subject=equipment')\">Terminology</a></td>
	
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



