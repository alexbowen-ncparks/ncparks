<?php
extract($_REQUEST);
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

include("../../../include/activity.php");

//print_r($_REQUEST);
//print_r($_SESSION);
//echo "<pre>";print_r($_SERVER);echo "</pre>";
$parkcodeACS=$_SESSION['budget']['select'];
$level=$_SESSION['budget']['level'];
if($level&&$level<2){$_REQUEST[parkcode]=$parkcodeACS;}
//else{$parkcodeACS=$parkcode;}

if(empty($message)){$message="Reports";}

function makeQuery(&$item1,$key){
global $query,$fields;
$tempArray=array("pcard_holder","vendor_name");
	if($item1 !="both" AND in_array($key,$fields)){
	if($key=="posted" and $item1=="n"){$item1="";}
	if(in_array($key,$tempArray)){$query.=" and ".$key." like '%".$item1."%'";}
else
	{
		if($key=="project_number" and $item1=="x"){$query.=" and ".$key." != ''";}else{
	$query.=" and ".$key."='".$item1."'";}
	}
	}
}

function passQuery(&$item1,$key){
global $passQuery,$fields,$i;
	if($item1 !="both" AND in_array($key,$fields)){
	$passQuery.="&".$key."=".$item1;
	}
}

if(@$submit=="Find")
	{
	
	include("../../../include/connectBUDGET.inc");// database connection parameters
	/*
	// Automatically update posted status when given a check_num
	$sql = "UPDATE cid_vendor_invoice_payments set posted='x' where check_num!=''";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	*/
	
	$sql = "SHOW COLUMNS from cid_vendor_invoice_payments";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_array($result)){
	$fields[]=$row[0];
	}
	
	$findArray=$_REQUEST;
	$i=0;
	array_walk($findArray, 'makeQuery');
	$WHERE="Where 1 ".$query;
	
	$passQuery="submit=Find";
	array_walk($findArray, 'passQuery');
	$passQ=$passQuery;
	unset($findArray);
	//print_r($findArray);
	//echo "<br><br>$passQ";
	// ***********  Time Period ****************
	if($dateScope||$bDate){
	
	if($dateScope=="cm"){
	$b=date("Ym01");
	$e=date();
	$bDate=date("Ymd",strtotime($b));
	$eDate=date("Ymd",strtotime($e));
	$WHERE.=" and dateSQL>='$bDate' and dateSQL<='$eDate'";
	if($dateScope=="cm"){$cmCk="checked";}
	}
	
	if($dateScope=="lm"){
	$testMonth=date(n);
	if($testMonth >0 and $testMonth<7){$b=date(Y)-1;}
	if($testMonth >6){$b=date(Y);}
	$mo=($testMonth-1);
	if($mo==0){$mo=12;}
	$ld=date("t",mktime(0,0,0,$mo,1,$b));
	$b.=str_pad($mo,2,"0",str_pad_left);
	$e=$b.$ld;
	$b.="01";
	//echo "mo $mo ld $ld e $e"; exit;
	$bDate=date("Ymd",strtotime($b));
	$eDate=date("Ymd",strtotime($e));
	$WHERE.=" and dateSQL>='$bDate' and dateSQL<='$eDate'";
	if($dateScope=="lm"){$lmCk="checked";}
	}
	
	if($dateScope=="om"){
	$bDate=date("Ymd",strtotime($bDate));
	$eDate=date("Ymd",strtotime($eDate));
	$WHERE.=" and dateSQL>='$bDate' and dateSQL<='$eDate'";
	if($dateScope=="om"){$omCk="checked";}
	}
	
	if($parkcode){$passQuery.="&bDate=$bDate&eDate=$eDate";}
	else{$passQuery.="submit=Find&bDate=$bDate&eDate=$eDate";}
	
	$select="SELECT *";
	$orderby="order by dateSQL desc";
	if($s=="vn"){$passS="vn";$orderby="order by vendor_name";}
	if($s=="na"){
	$select="SELECT *,coa.description";
	$joinTable="Left Join coa on coa.ncasNum=cid_vendor_invoice_payments.ncas_account";
	$passS="na";$orderby="order by ncas_account";}
	
	$displayReport="month";
	}// end dateScope
	
	$sql = "$select
	From cid_vendor_invoice_payments
	$joinTable
	$WHERE $orderby";
	
	if($level>4){echo "<br><br>$sql";}//EXIT;
	
	
	$resultReport = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$num=mysqli_num_rows($resultReport); //echo "n=$num";
	
	}// end Find

if(empty($dateScope)){$lmCk="checked";}

include("../menu.php");
//session_start();
//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";//EXIT;

$userName=$_SESSION['budget']['acsName'];
if(!$userName)
	{
	$userID=$_SESSION['budget']['tempID'];
	$sql = "SELECT Nname,Fname,Lname From divper.empinfo where tempID='$userID'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	if($Nname){$Fname=$Nname;}
	$userName=$Fname." ".$Lname;
	$_SESSION['budget']['acsName']=$userName;
	}

include("/budget/parkRCC.inc");
$parkcodeACS=$_SESSION['budget']['select'];
if(!$parkcodeACS){$parkcodeACS=$parkcode;}

if($level&&$level<2){$_REQUEST['parkcode']=$parkcodeACS;}
//else{$parkcodeACS=$parkcode;}

echo "<table cellpadding='1'><tr><td> </td><td><font color='green' size='+1'>$message</font></td></tr></table><hr>";

// *************  Report Entry Forms ******************
// ******** Account and Vendor by date(s)

if($level>2){$parkcodeACS=$parkcode;}
echo "<table><form name=\"formReport1\" action='acsReports.php' method='POST'>
<tr>
<td align='right'><font color='purple'>Totals by Account or Vendor</font> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td>parkcode:<input type='text' name='parkcode' value='$parkcodeACS' size='5'></td>
<td>[Last Month<input type='radio' name='dateScope' value='lm' $lmCk>]
[Current Month<input type='radio' name='dateScope' value='cm' $cmCk>]
[Other time period:<input type='radio' name='dateScope' value='om' $omCk> enter a start and end date below.]</td></tr></table>";

switch($posted){
case "x":
$px="checked";
break;
case "n":
$pn="checked";
break;
case "both":
$pb="checked";
break;
default:
$pb="checked";
}

if($project_number=="x"){$pnCk="checked";}else{$pnCk="";}

echo "<table border='1'><tr><td align='right'>Beginning Date [m/d/y or yyyymmdd]</td><td><input type='text' name='bDate' value='$bDate' size='11' maxlength='10'> Ending Date</td>
<td><input type='text' name='eDate' value='$eDate' size='11' maxlength='10'>
Posted: Yes<input type='radio' name='posted' value='x' $px>
No<input type='radio' name='posted' value='n' $pn>
Both<input type='radio' name='posted' value='both' $pb></td>
<td>Projects<input type='checkbox' name='project_number' value='x'$pnCk>
<input type='hidden' name='m' value='invoices'>
<input type='hidden' name='s' value=''>
<input type='submit' name='submit' value='Find'></td></tr>
</form></table>";

// ********* Next Report **************


// ********* Select Display file **************
switch($displayReport){
	case "month":
	include("rExpenseDates.php");
	break;
}
echo "</body></html>";
?>