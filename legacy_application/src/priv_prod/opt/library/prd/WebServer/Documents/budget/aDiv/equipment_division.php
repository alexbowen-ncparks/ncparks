<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
//include("../../../include/activity.php");
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";
//print_r($_SESSION);echo "</pre>";
// Construct Query to be passed to Excel Export
$beacnum=$_SESSION['budget']['beacon_num'];
//echo "beacnum=$beacnum<br />";
if($beacnum=='60033093'){$level=4;} // South District OA (Val Mitchener)  Also, added to line 49  TBass 2/16/15
//echo "line 22 level=$level<br />";

foreach($_REQUEST as $k => $v){
if($v and $k!="PHPSESSID"){
	@$varQuery.=$k."=".$v."&";
	if($k!="passYY" and $k!="submit" and $k!="category" and $k!="showSQL")
		{
		@$whereCat.=" and ".$k."='".$v."'";}
		}

}
//echo "line 33 level=$level<br />";

//echo "<pre>";print_r($_REQUEST);"</pre>";
//echo "varquery=$varQuery";exit;
$passQuery=$varQuery;
//echo "varquery as $varQuery";exit;
   $varQuery.="rep=excel";    
//echo "varquery as $varQuery";exit;
$level=$_SESSION['budget']['level'];
if($level==1){$cen=$_SESSION['budget']['centerSess'];}

// Allow level>1 to see same report as level 1 and 2 when arriving at this page
// using the same menus as level 1 users
if($level>1 and $passLevel==1){
$original_level=$level;// preserved for use at line 570
$level=1;}
if($beacnum=='60033093'){$level=4;}
//echo "line 50 level=$level<br />";


if(@$rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=equipment_division.xls');
//if($level>2){include("equipment_division_header.php");}
}

if($level==2){
switch ($_SESSION['budget']['select']) {
		case "SODI":
			$w="and district='south'";
			//$pu="and (district='south' OR purchaser='sodo')";
			$pu="and (district='south')";
			break;	
		case "NODI":
			$w="and district='north'";
			//$pu="and (district='north' OR purchaser='nodo')";
			$pu="and (district='north')";
			break;	
		case "EADI":
			$w="and district='east'";
			//$pu="and (district='east' OR purchaser='eado')";
			$pu="and (district='east')";
			break;	
		case "WEDI":
			$w="and district='west'";
			//$pu="and (district='west' OR purchaser='wedo')";
			$pu="and (district='west')";
			break;	
	}// end switch
}// end level=2

// *********** Level > 2 ************
if($level>2){//print_r($_REQUEST);EXIT;
//echo "line85=$line85<br />";
if($rep==""){
include_once("../menu.php");
if($level>2){include("equipment_division_header.php");}

// Get f_year
//include("../~f_year.php");

if($showSQL==1){$p="method='POST'";}
echo "<hr><table align='center'><form action='equipment_division.php' $p>";


// Menu 1
echo "<tr><td align='center'>ER Number<br><input type='text' name='er_num' value='$er_num' size='5'></td>";

// Menu 2
$sql="select distinct(f_year) as fyMenu from equipment_request_3 where 1 $w
order by f_year";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$menuArray[]=$fyMenu;}
//echo "<pre>";print_r($menuArray);echo "</pre>";exit;
echo "<td align='center'>Fiscal Year<br><select name=\"f_year\">";
for ($n=0;$n<count($menuArray);$n++){
if($f_year==$menuArray[$n]){$s="selected";}else{$s="value";}
$con=$menuArray[$n];
		echo "<option $s='$con'>$menuArray[$n]</option>\n";
       }
   echo "</select></td>";
// echo "<pre>";print_r($_menuArray);echo "</pre>";exit;  
unset($menuArray);
// Menu 3
$sql="select distinct(purchaser) as purchaserMenu from equipment_request_3 where 1 and purchaser!='' $w
order by purchaser";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
$countRecords=mysqli_num_rows($result);
while ($row=mysqli_fetch_array($result)){
extract($row);$menuArray[]=$purchaserMenu;}

echo "<td align='center'>Purchaser<br><select name=\"purchaser\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++)
	{
	if(@$purchaser==$menuArray[$n] and @$purchaser!="")
		{$s="selected";}else{$s="value";}
	$con=$menuArray[$n];
	echo "<option $s='$con'>$menuArray[$n]</option>\n";
	}
   echo "</select></td>";

unset($menuArray);
// Menu 4
$sql="select distinct(location) as locationMenu from equipment_request_3 where 1  and location!='' $w
order by location";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$menuArray[]=$locationMenu;}

echo "<td align='center'>Location<br><select name=\"location\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++)
	{
	if(@$location==$menuArray[$n])
		{$s="selected";}else{$s="value";}
	$con=$menuArray[$n];
	echo "<option $s='$con'>$menuArray[$n]</option>\n";
	}
   echo "</select></td>";

unset($menuArray);
// Menu 5
$sql="select distinct(ncas_account) as acctMenu from equipment_request_3 where 1 and ncas_account!='' $w
order by ncas_account";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$menuArray[]=$acctMenu;}

echo "<td align='center'>Account<br><select name=\"ncas_account\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++)
	{
	if(@$ncas_account==$menuArray[$n] and $ncas_account!="")
		{$s="selected";}else{$s="value";}
	$con=$menuArray[$n];
	echo "<option $s='$con'>$menuArray[$n]</option>\n";
	}
   echo "</select></td>";
 
unset($menuArray);
// Menu 6
$sql="select distinct(funding_source) as funding_sourceMenu from equipment_request_3 where 1 and funding_source!='' $w
order by funding_source";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$menuArray[]=$funding_sourceMenu;}

echo "<td align='center'>Funding Source<br><select name=\"funding_source\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++)
	{
	if(@$funding_source==$menuArray[$n] and $funding_source!="")
		{$s="selected";}else{$s="value";}
	$con=$menuArray[$n];
	echo "<option $s='$con'>$menuArray[$n]</option>\n";
	}
   echo "</select></td>";
   
   unset($menuArray);
// Menu 7
$sql="select distinct(pay_center) as centerMenu from equipment_request_3 where 1 and pay_center!='' $w
order by pay_center";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$menuArray[]=$centerMenu;}

echo "<td align='center'>Pay Center<br><select name=\"pay_center\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++)
	{
	if(@$pay_center==$menuArray[$n] and $pay_center!="")
		{$s="selected";}else{$s="value";}
	$con=$menuArray[$n];
	echo "<option $s='$con'>$menuArray[$n]</option>\n";
	}
   echo "</select></td>";
   
   
$menuArray=array("active","inactive");
// Menu 17.5
echo "<td align='center'>Status<br><select name=\"status\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++)
	{
	if(@$status==$menuArray[$n])
		{$s="selected";}else{$s="value";}
	$con=$menuArray[$n];
	echo "<option $s='$con'>$menuArray[$n]</option>\n";
	}
   echo "</select></td>";
   
   $ud="<td align='center'><input type='checkbox' name='edit' value='1'>Edit Fields</td><td align='center'><input type='checkbox' name='showSQL' value='1'>Show SQL</td>";
//

//if($level>3){echo "$ud";}
if($_SESSION['budget']['posNum']=="09518" and $purchaser=="pacr"){echo "$ud";}


   // ************ New Row **************
   unset($menuArray);
// Menu 8
$sql="select distinct(center_code) as center_codeMenu from equipment_request_3 where 1 $w
order by center_code";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$menuArray[]=$center_codeMenu;}

echo "<tr><td align='center'>Center Code<br><select name=\"center_code\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++)
	{
	if(@$center_code==$menuArray[$n] and $center_code!="")
		{$s="selected";}else{$s="value";}
	$con=$menuArray[$n];
	if($con!=""){echo "<option $s='$con'>$menuArray[$n]</option>\n";}
	}
   echo "</select></td>";
   
   unset($menuArray);
// Menu 9
//if($level==2){$district="south";}
$sql="select distinct(district) as districtMenu from equipment_request_3 where 1 $w
order by district";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$menuArray[]=$districtMenu;}
//echo "$sql";
echo "<td align='center'>District<br><select name=\"district\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++)
	{
	if(@$district==$menuArray[$n] and $district!="")
		{$s="selected";}else{$s="value";}
	$con=$menuArray[$n];
	if($con!=""){echo "<option $s='$con'>$menuArray[$n]</option>\n";}
	}
   echo "</select></td>";
   
$menuArray=array("y","n","u");
// Menu 10
echo "<td align='center'>District Approved<br><select name=\"district_approved\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++)
	{
	if(@$district_approved==$menuArray[$n])
		{$s="selected";}else{$s="value";}
	$con=$menuArray[$n];
	echo "<option $s='$con'>$menuArray[$n]</option>\n";
	}
   echo "</select></td>";
   
// Menu 11a
   unset($menuArray);
$menuArray=array("y","n","u");
echo "<td align='center'>Division Approved<br><select name=\"division_approved\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++)
	{
	if(@$division_approved==$menuArray[$n])
		{$s="selected";}else{$s="value";}
	$con=$menuArray[$n];
	echo "<option $s='$con'>$menuArray[$n]</option>\n";
	}
   echo "</select></td>";
   
// Menu 11b
   unset($menuArray);
   if($change=="Change"||$edit==1){$whereCat="";}
   
 //echo "wherecat=$wherecat";exit;  
$sql="Select distinct(category) as cat_menu from equipment_request_3
where 1 $whereCat
order by category";
//echo "$sql";//exit;

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$menuArray[]=$cat_menu;}
echo "<td align='center'>Category<br><select name=\"category\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++)
	{
	if(@$category==$menuArray[$n])
		{$s="selected";}else{$s="value";}
	$con=$menuArray[$n];
	echo "<option $s='$con'>$menuArray[$n]</option>\n";
	}
   echo "</select></td>";
   
$menuArray=array("y","n");
// Menu 11c
echo "<td align='center'>Ordered<br><select name=\"order_complete\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++)
	{
	if(@$order_complete==$menuArray[$n])
		{$s="selected";}else{$s="value";}
	$con=$menuArray[$n];
	echo "<option $s='$con'>$menuArray[$n]</option>\n";
	}
   echo "</select></td>";
   
// Menu 12
echo "<td align='center'>Received<br><select name=\"receive_complete\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++)
	{
	if(@$receive_complete==$menuArray[$n])
		{$s="selected";}else{$s="value";}
	$con=$menuArray[$n];
	echo "<option $s='$con'>$menuArray[$n]</option>\n";
	}
   echo "</select></td>";
   
// Menu 13
echo "<td align='center'>Paid_in_Full<br><select name=\"paid_in_full\"><option selected></option>";
for ($n=0;$n<count($menuArray);$n++)
	{
	if(@$paid_in_full==$menuArray[$n])
		{$s="selected";}else{$s="value";}
	$con=$menuArray[$n];
	echo "<option $s='$con'>$menuArray[$n]</option>\n";
	}
   echo "</select></td>";
   
// Menu 14
if($submit and $level>3){echo "<td align='center'>View Equipment<br><a href='/budget/aDiv/equip_center_totals.php?f_year=$f_year'>Totals by Center</a></td>";}
   if($passYY){$val=$passYY;}else{$val=10;}
   echo "<td><input type='text' name='passYY' value='$val' size='3'> rows</td></tr>";
echo "<tr>";

if($level>3){echo "$ud";}
echo "<td>
<input type='submit' name='submit' value='Submit'>";
echo "</form></td><form><td><input type='submit' name='reset' value='Reset'></td></form></tr></table>";
}
}// end Level > 2

if($submit!="Submit"){exit;}
//$showSQL=1;
if(!isset($showSQL)){$showSQL="";}
// ********* Body Queries ***************
 $query = "update equipment_request_3,center set equipment_request_3.center_code=center.parkcode where equipment_request_3.pay_center=center.center;";
    $result = @mysqli_query($connection, $query);
if($showSQL=="1"){echo "$query<br><br>";}

 $query = "update equipment_request_3,center set equipment_request_3.district=center.dist where equipment_request_3.pay_center=center.center;";
 $result = @mysqli_query($connection, $query);
if($showSQL=="1"){echo "$query<br><br>";}

 $query = "truncate table equipment_division_totals;";
  $result = @mysqli_query($connection, $query);
if($showSQL=="1"){echo "$query<br><br>";}

$query = "insert into equipment_division_totals(er_num,requested_amount,approved_amount,expenses,ordered_amount,unordered_amount) select er_num,sum(unit_quantity*unit_cost),'','','','' from equipment_request_3 where 1 and equipment_description != 'budget' group by er_num;";
 $result = @mysqli_query($connection, $query);
if($showSQL=="1"){echo "$query<br><br>";}

$query = "insert into equipment_division_totals(er_num,requested_amount,approved_amount,expenses,ordered_amount,unordered_amount) select er_num,'',sum(unit_quantity*unit_cost),'','','' from equipment_request_3 where 1 and equipment_description != 'budget' and division_approved='y'
group by er_num;";
 $result = @mysqli_query($connection, $query);
if($showSQL=="1"){echo "$query<br><br>";}

$query = "insert into equipment_division_totals(er_num,requested_amount,approved_amount,expenses,ordered_amount,unordered_amount) select er_num,'','','',sum(ordered_amount),'' from equipment_request_3 where 1 and order_complete='y' group by er_num;";
 $result = @mysqli_query($connection, $query);
if($showSQL=="1"){echo "$query<br><br>";}

$query = "insert into equipment_division_totals(er_num,requested_amount,approved_amount,expenses,ordered_amount,unordered_amount) select er_num,'','','','',sum(unit_quantity*unit_cost) from equipment_request_3 where 1 and order_complete='n' and equipment_description != 'budget' and division_approved='y'
group by er_num;";
 $result = @mysqli_query($connection, $query);
if($showSQL=="1"){echo "$query<br><br>";}

if($level<4)
	{
	if($level<2)
	/*
		{
		if(@$passLevel==1){$pay_center=$pay_center;}else{
		$pay_center=$_SESSION['budget']['centerSess'];}
		}
		*/
		
// changed on 2/4/16

       {
		if(@$passLevel==1){$pay_center=$pay_center;}else{
		$pay_center=$_SESSION['budget']['centerSess_new'];}
		}

		
	$whereFilter="where 1 
	and equipment_request_3.f_year='$f_year'
	and equipment_request_3.pay_center='$pay_center'";
	
	//"funding_source",
	$headerArray=array("er_num", "user_id", "system_entry_date", "status","f_year","purchaser","location","category","equipment_description","ncas_account","pay_center", "center_code","approved_amount","ordered_amount","surplus_deficit","order_complete","receive_complete","paid_in_full");
	
	//print_r($headerArray); // for Level<4
	$count=count($headerArray);
	for($i=0;$i<$count;$i++)
		{
		$h=$headerArray[$i];
		@$header.="<th>".$h."</th>";
		}
	
	}// end Level < 4


if($level>1){
//"funding_source",
$headerArray=array("er_num", "user_id", "system_entry_date","status","f_year","purchaser","location","category","equipment_description","ncas_account","pay_center", "center_code","district","unit_quantity","unit_cost","requested_amount","justification","pasu_ranking","disu_ranking","district_approved","division_approved","bo_comments","approved_amount","ordered_amount","unordered_amount","surplus_deficit","order_complete","receive_complete","paid_in_full");

$whereFilter="where 1";
if($er_num){$whereFilter.=" and equipment_request_3.er_num='$er_num'";}

if($f_year){$whereFilter.=" and equipment_request_3.f_year='$f_year'";}
if($purchaser){$whereFilter.=" and equipment_request_3.purchaser='$purchaser'";}
if($location){$whereFilter.=" and equipment_request_3.location='$location'";}
if($ncas_account){$whereFilter.=" and equipment_request_3.ncas_account='$ncas_account'";}
if($funding_source){$whereFilter.=" and equipment_request_3.funding_source='$funding_source'";}
if($pay_center){$whereFilter.=" and equipment_request_3.pay_center='$pay_center'";}
if($status){$whereFilter.=" and equipment_request_3.status='$status'";}

if($center_code){$whereFilter.=" and equipment_request_3.center_code='$center_code'";}

//if($district and ($level==2 and $rep=="excel")){$whereFilter.=" and equipment_request_3.district='$district'";}

if($district){$whereFilter.=" and equipment_request_3.district='$district'";}

if($district_approved){$whereFilter.=" and equipment_request_3.district_approved='$district_approved'";}
if($division_approved){$whereFilter.=" and equipment_request_3.division_approved='$division_approved'";}
if($order_complete){$whereFilter.=" and equipment_request_3.order_complete='$order_complete'";}
if($receive_complete){$whereFilter.=" and equipment_request_3.receive_complete='$receive_complete'";}
if($paid_in_full){$whereFilter.=" and equipment_request_3.paid_in_full='$paid_in_full'";}
if($category){$whereFilter.=" and equipment_request_3.category='$category'";}
}

if($level<2){$da="and division_approved='y'";}

/*select query for center budgets*/

//equipment_request_3.funding_source, 
if(!isset($pu)){$pu="";}
$sql="select equipment_request_3.er_num, equipment_request_3.user_id, equipment_request_3.system_entry_date, equipment_request_3.f_year, equipment_request_3.purchaser, equipment_request_3.location, equipment_request_3.category, equipment_request_3.equipment_description, equipment_request_3.ncas_account,equipment_request_3.pay_center, equipment_request_3.center_code, equipment_request_3.unit_quantity
, equipment_request_3.unit_cost, equipment_request_3.district, sum(equipment_division_totals.requested_amount) as 'requested_amount', equipment_request_3.justification, equipment_request_3.district_approved, equipment_request_3.division_approved, sum(equipment_division_totals.approved_amount) as 'approved_amount', sum(equipment_division_totals.ordered_amount) as 'ordered_amount', sum(equipment_division_totals.unordered_amount) as 'unordered_amount', sum(equipment_division_totals.approved_amount-equipment_division_totals.ordered_amount-equipment_division_totals.unordered_amount) as 'surplus_deficit', equipment_request_3.order_complete, equipment_request_3.receive_complete, equipment_request_3.paid_in_full, equipment_request_3.status, equipment_request_3.pasu_ranking, equipment_request_3.disu_ranking, equipment_request_3.bo_comments
FROM equipment_division_totals 
left join equipment_request_3 on equipment_division_totals.er_num=equipment_request_3.er_num
$whereFilter $pu $da
group by equipment_division_totals.er_num
order by equipment_request_3.location,er_num";

//echo "$sql<br>";//exit;

if($showSQL=="1"){echo "$sql<br>";}

if(@$rep==""){
$goBack="<tr><td colspan='10' align='center'><font size='+1'><a href='/budget/a/current_year_budget.php?center=$pay_center&budget_group_menu=equipment'>Return</a></font> to <font color='green'>Park Budget</font></td><td><a href='equipment_division.php?$varQuery'>Excel</a></td></tr>";}

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);

echo "<html><head>";
if(@$rep==""){echo "<script language='JavaScript'>function popitup(url)
{   newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=800,width=800,menubar=1,toolbar=1');
        if (window.focus) {newwindow.focus()}
        return false;
}";

echo "//-->
</script>";}

echo "</head>";
echo "<table border='1'>$goBack";

if($level>3){$count=count($headerArray);
$header="<tr>";
for($i=0;$i<$count;$i++){
$h=$headerArray[$i];
$header.="<th>".$h."</th>";}
$header.="</tr>";
}
else
{
unset($header);

//"funding_source",
$headerArray=array("er_num", "user_id", "system_entry_date","status","f_year","purchaser","location","category","equipment_description","ncas_account","pay_center", "center_code","district","unit_quantity","unit_cost","approved_amount","ordered_amount","surplus_deficit","order_complete","receive_complete","paid_in_full");

If(!is_array($dontShow)){$dontShow=array();}

$count=count($headerArray);
for($i=0;$i<$count;$i++)
	{
	$h=$headerArray[$i];
	if(!in_array($h,$dontShow))
		{
		$selectFields.=$h.",";
		if(@$rep=="")
			{
			if($h!=="order_complete" and $h!="receive_complete" and $h!="paid_in_full")
				{$h=str_replace("_","<br>",$h);}
			}
		@$header.="<th>".$h."</th>";
		} 
	}
}



while($row=mysqli_fetch_array($result)){
$b[]=$row;
}// end while
//echo "<pre>";print_r($b);echo "</pre>";//exit;
//$cen=$b[0][pay_center];

if($rep==""){echo "<tr><td colspan='$count'>&nbsp;&nbsp;&nbsp;<font color='red' size='+1'>$num requests</font> &nbsp;&nbsp;&nbsp;";
if($pay_center){
echo "<a href='er_all_pay.php?center=$pay_center&parkcode=$passParkcode'>All</a> Payments for pay_center=$pay_center</td></tr>";}
}

if($rep=="excel"){echo "$header";}


if($level>3){

$radioFlds=array("district_approved","division_approved","order_complete","receive_complete","paid_in_full");

$decimalFlds=array("unit_quantity","requested_amount","approved_amount","ordered_amount", "unordered_amount","surplus_deficit");

if($edit){$editFlds=array("status","f_year","purchaser","location","equipment_description","ncas_account","funding_source","pay_center","requested_amount","status","justification","district_approved","division_approved","bo_comments","ordered_amount","order_complete","receive_complete","paid_in_full","pasu_ranking","disu_ranking","unit_quantity","unit_cost");}

$x=2;
if($passYY){$yy=$passYY;}else{$yy=10;}

$header=str_replace("_"," ",$header);

echo "<form action='equipment_division_update.php' method='POST'>";
	for($i=0;$i<count($b);$i++){
	$r=fmod($i,$x);if($r==0){$bc=" bgcolor='aliceblue'";}else{$bc="";}
	
if(fmod($i,$yy)==0 and $rep==""){echo "<tr>$header</tr>";}

echo "<tr$bc>";

	for($j=0;$j<count($headerArray);$j++){
	$var=$b[$i][$headerArray[$j]];
	$fieldName=$headerArray[$j];
	
	if($headerArray[$j]=="er_num" and $rep==""){$er=$var;
	$var="<a href='popupex.html' onclick=\"return popitup('er_display.php?er_num=$er')\">$er</a>";}
//	else{$var=$er;}
	
	if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}
	if(in_array($headerArray[$j],$decimalFlds)){
	$totArray[$headerArray[$j]]+=$var;
	if($headerArray[$j]!="unit_quantity"){$var=numFormat($var);
	$a="<td align='right'$bc>";}
	else{$a="<td align='center'$bc>";}
			}else{$a="<td$bc>";}
			if(in_array($headerArray[$j],$editFlds)){
			$cs="7";
	if($headerArray[$j]=="equipment_description" || $headerArray[$j]=="justification"){$cs="25";}else{
if($headerArray[$j]=="ncas_account" || $headerArray[$j]=="pay_center"){$cs="10";}
}
			if(in_array($headerArray[$j],$radioFlds)){
			$ckY="";$ckN="";
	if($var=="y"){$ckY="checked";$ckN="";}
	if($var=="n"){$ckN="checked";$ckY="";}

echo "<td align='center'$bc>
<font color='green' size='-1'>Y</font><input type='radio' name='$headerArray[$j][$er]' value='y'$ckY><font color='red' size='-1'>N</font><input type='radio' name='$headerArray[$j][$er]' value='n'$ckN></td>";}
else
			
			{
			if($fieldName=="requested_amount"){$ro="READONLY";}else{$ro="";}
			echo "<td align='center'$bc><input type='text' name='$headerArray[$j][$er]' value='$var' size='$cs'$ro></td>";}
			
			}else{echo "$a$f1$var$f2</td>";}	
	}
	
echo "</tr>";
	}
}// end if level > 3
else{

$radioFlds=array("order_complete","receive_complete","paid_in_full");

$decimalFlds=array("requested_amount","approved_amount","ordered_amount", "unordered_amount","surplus_deficit");

if(@$rep=="") {$editFlds=array("ordered_amount", "order_complete","receive_complete","paid_in_full");}

$x=2;
if($passYY){$yy=$passYY;}else{$yy=10;}

echo "<form action='equipment_division_update.php' method='POST'><tr>";
	for($i=0;$i<count($b);$i++){
	$r=fmod($i,$x);if($r==0){$bc=" bgcolor='aliceblue'";}else{$bc="";}
	
if(fmod($i,$yy)==0 and $rep==""){echo "<tr>$header</tr>";}

echo "<tr$bc>";
	for($j=0;$j<count($headerArray);$j++){

	$var=$b[$i][$headerArray[$j]];
	$fieldName=$headerArray[$j];
	
	if($fieldName=="er_num" and $rep==""){$er=$var;
	$var="<a href='popupex.html' onclick=\"return popitup('er_display.php?er_num=$var')\">$er</a>";}
	
	
	if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}
	if(in_array($headerArray[$j],$decimalFlds)){
	$a="<td align='right'$bc>";$totArray[$headerArray[$j]]+=$var;
	$var=numFormat($var);}else{$a="<td$bc>";}
			if(in_array($headerArray[$j],$editFlds)){
			if(in_array($headerArray[$j],$radioFlds)){
	if($var=="y")
{$ckY="checked";$ckN="";}else{$ckN="checked";$ckY="";}

echo "<td align='right'$bc>
<font color='green' size='-1'>Y</font><input type='radio' name='$headerArray[$j][$er]' value='y'$ckY><font color='red' size='-1'>N</font><input type='radio' name='$headerArray[$j][$er]' value='n'$ckN></td>";}
else
			
			{echo "<td bgcolor='beige' align='center'><input type='text' name='$headerArray[$j][$er]' value='$var' size='10'></td>";}
			
			
			}else{echo "$a$f1$var$f2</td>";}
	}
	
echo "</tr>";
	}
}/// level < 3

if(@$rep==""){
echo "<tr>";for($j=0;$j<count($headerArray);$j++){
	if($totArray[$headerArray[$j]]){
	$var=$totArray[$headerArray[$j]];
	if($var<0){$f1="<font color='red'>";$f2="</font>";}else{$f1="";$f2="";}
	if($headerArray[$j]=="unit_quantity"){$v=$var;}else{$v=numFormat($var);}$xx=2;
	echo "<td align='right'><b>$v</b></td>";}else{echo "<td></td>";}
}

if(($level==1 and $_SESSION['budget']['centerSess']==$pay_center) OR $original_level>1){$edit=1;}

$edit=1;

if($edit==1){
if($location){$pay_center=$center;}
echo "</tr>
<tr><td colspan='2'>$num item(s)</td><td colspan='14' align='right'>
<input type='hidden' name='f_year' value='$f_year'>
<input type='hidden' name='passQuery' value='$passQuery'>
<input type='submit' name='submit' value='Update'>
</td>
</form>";
}

}

if(@$rep==""){$footer="<tr><td colspan='8' align='center'>Equipment Budget <a href='popupex.html' onclick=\"return popitup('explain_search.php?subject=equipment')\">Terminology</a></td></tr>";}

echo "$footer</table></body></html>";

function numFormat($nf){
$nf=number_format($nf,2);
return $nf;}
?>



