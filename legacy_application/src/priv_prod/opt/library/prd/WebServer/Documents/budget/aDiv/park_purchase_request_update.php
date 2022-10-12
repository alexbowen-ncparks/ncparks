<?php
//ini_set('display_errors',1);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/auth.inc");
$beacnum=$_SESSION['budget']['beacon_num'];
//echo "<pre>";print_r($_REQUEST); exit;
/*
if($beacnum=='60032988')
{
echo "<pre>";print_r($_REQUEST);
}
*/
//print_r($_SESSION);
//echo "</pre>";exit;
extract($_REQUEST);
//ini_set('display_errors',1);
date_default_timezone_set('America/New_York');

//echo "<pre>";print_r($_REQUEST); exit;

//$beacnum=$_SESSION['budget']['beacon_num'];
/*
if($beacnum=='60032988')
{
//echo "<pre>";print_r($_REQUEST);

//$purchase_description_Edit=str_replace('"'," ",$purchase_description);
//$purchase_description_Edit=stripslashes($purchase_description_Edit);
//echo "purchase_description=$purchase_description<br />"; exit;
$purchase_description_Edit=$purchase_description;
$purchase_description_Edit=urlencode($purchase_description_Edit);

echo "<form method='post' action='park_purchase_request.php'>";
echo "<input type='hidden' name='purchase_description_Edit' value='$purchase_description_Edit'>";
echo "<input type='hidden' name='justification_Edit' value='$justification'>";
echo "<input type='submit' name='submit' value='Submit'>";
echo "</form>";

echo "Line 15 (Testing-Tbass)<br />"; echo "purchase_description_Edit=$purchase_description_Edit<br />"; exit;


 }
 */
if($submit=="Add"){

$dateSQL=date("Ymd",strtotime($purchase_date));
//echo "date=$dateSQL<br><br>"; //exit;


$pay_center=$_REQUEST['pay_center'];
if($pay_center=="0"){


$purchase_description_Edit=$purchase_description;
$purchase_description_Edit=urlencode($purchase_description_Edit);

$justification_Edit=$justification;
$justification_Edit=urlencode($justification_Edit);

//echo "justification_Edit=$justification_Edit<br />";



echo "You MUST specify a 'pay_center'. Click Button below to Return to Form";

echo "<form method='post' action='park_purchase_request.php'>";
echo "<input type='hidden' name='purchase_description_Edit' value='$purchase_description_Edit'>";
echo "<input type='hidden' name='justification_Edit' value='$justification_Edit'>";
echo "<input type='hidden' name='submit' value='Submit'>";
echo "<input type='submit' name='submit2' value='Return to Form'>";
echo "</form>";

//echo "Line 15 (Testing-Tbass)<br />"; echo "purchase_description_Edit=$purchase_description_Edit<br />"; exit;
exit;
}
		
$purchaser=$_REQUEST['purchaser'];
if($purchaser=="0")

{

$purchase_description_Edit=$purchase_description;
$purchase_description_Edit=urlencode($purchase_description_Edit);


$justification_Edit=$justification;
$justification_Edit=urlencode($justification_Edit);


echo "You MUST specify a 'purchaser'. Click Button below to Return to Form";

echo "<form method='post' action='park_purchase_request.php'>";
echo "<input type='hidden' name='purchase_description_Edit' value='$purchase_description_Edit'>";
echo "<input type='hidden' name='justification_Edit' value='$justification_Edit'>";
echo "<input type='hidden' name='submit' value='Submit'>";
echo "<input type='submit' name='submit2' value='Return to Form'>";
echo "</form>";

//echo "Line 15 (Testing-Tbass)<br />"; echo "purchase_description_Edit=$purchase_description_Edit<br />"; exit;
exit;
}


		
$location=$_REQUEST['location'];
if($location=="0")
{

$purchase_description_Edit=$purchase_description;
$purchase_description_Edit=urlencode($purchase_description_Edit);


$justification_Edit=$justification;
$justification_Edit=urlencode($justification_Edit);


echo "You MUST specify a 'location'. Click Button below to Return to Form";

echo "<form method='post' action='park_purchase_request.php'>";
echo "<input type='hidden' name='purchase_description_Edit' value='$purchase_description_Edit'>";
echo "<input type='hidden' name='justification_Edit' value='$justification_Edit'>";
echo "<input type='hidden' name='submit' value='Submit'>";
echo "<input type='submit' name='submit2' value='Return to Form'>";
echo "</form>";

//echo "Line 15 (Testing-Tbass)<br />"; echo "purchase_description_Edit=$purchase_description_Edit<br />"; exit;
exit;
}		
		
		
		

if($_REQUEST['purchase_type']=="emergency"){
	if($_REQUEST['purchase_date']==""){
	
$purchase_description_Edit=$purchase_description;
$purchase_description_Edit=urlencode($purchase_description_Edit);


$justification_Edit=$justification;
$justification_Edit=urlencode($justification_Edit);
	
	
echo "When making an emergency purchase, you MUST specify a 'purchase date'. Click Button below to Return to Form"; 
		
		
echo "<form method='post' action='park_purchase_request.php'>";
echo "<input type='hidden' name='purchase_description_Edit' value='$purchase_description_Edit'>";
echo "<input type='hidden' name='justification_Edit' value='$justification_Edit'>";
echo "<input type='hidden' name='submit' value='Submit'>";
echo "<input type='submit' name='submit2' value='Return to Form'>";
echo "</form>";

//echo "Line 15 (Testing-Tbass)<br />"; echo "purchase_description_Edit=$purchase_description_Edit<br />"; exit;
exit;	
		
		
		
		
		
		}
	}

$purchase_type=$_REQUEST['purchase_type'];
if($purchase_type=="")

{
	
$purchase_description_Edit=$purchase_description;
$purchase_description_Edit=urlencode($purchase_description_Edit);


$justification_Edit=$justification;
$justification_Edit=urlencode($justification_Edit);
	
	
echo "You MUST specify a 'purchase type'. Click Button below to Return to Form";
		
		
echo "<form method='post' action='park_purchase_request.php'>";
echo "<input type='hidden' name='purchase_description_Edit' value='$purchase_description_Edit'>";
echo "<input type='hidden' name='justification_Edit' value='$justification_Edit'>";
echo "<input type='hidden' name='submit' value='Submit'>";
echo "<input type='submit' name='submit2' value='Return to Form'>";
echo "</form>";

//echo "Line 15 (Testing-Tbass)<br />"; echo "purchase_description_Edit=$purchase_description_Edit<br />"; exit;
exit;	
	
		}






/*		
$ncas_account=$_REQUEST['ncas_account'];
if($ncas_account==""){
		echo "You MUST specify a valid 'ncas account' number."; 
		
	echo "<form method='post' action='park_purchase_request.php'>";
echo "<input type='hidden' name='purchase_description_Edit' value='$purchase_description_Edit'>";
echo "<input type='hidden' name='justification_Edit' value='$justification_Edit'>";
echo "<input type='hidden' name='submit' value='Submit'>";
echo "<input type='submit' name='submit2' value='Return to Form'>";
echo "</form>";

//echo "Line 15 (Testing-Tbass)<br />"; echo "purchase_description_Edit=$purchase_description_Edit<br />"; exit;
exit;		
		
		
		
		}
		
ELSE
{
$sql = "SELECT coaid FROM `coa` WHERE ncasNum ='$ncas_account' and valid_div='y'";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
		if($num<1){echo "$ncas_account is NOT a valid 'ncas account' number. You MUST specify a valid 'ncas account' number. Please click you browser's BACK button and resubmit."; 
		echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
		exit;
		}

$row=mysqli_fetch_assoc($result);$coaid=$row['coaid'];
	$sql = "SELECT park_acct_desc FROM `coa` WHERE coaid='$coaid'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
		$row=mysqli_fetch_assoc($result);
			$park_acct_desc=$row['park_acct_desc'];
			
}
*/
$sql="SELECT center,parkCode,dist from center";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_array($result))
{$centerArray[$row['center']]=$row['dist'];
$parkArray[$row['center']]=$row['parkCode'];}

$ignore=array("PHPSESSID","passQuery","__utma","__utmz","__utmb","__utmc","submit");
$clause="INSERT into purchase_request_3 set ";
 foreach ($_REQUEST as $key => $value) {
        if(in_array($key,$ignore)){continue;} 
	if($key!="submit" AND $key!="PHPSESSID" AND $key!="passQuery"){
	
	if($key=="category"){$exp=explode("=",$value);
	$clause.="category='".$exp[0]."',";
	$key="ncas_account";$value=$exp[1];}
	
	if($key=="category"){$exp=explode("=",$value);
	$clause.="category='".$exp[0]."',";
	$key="ncas_account";$value=$exp[1];}
	
	if($key=="unit_cost"){$un=str_replace(",","",$value);$value=$un;}
	if($key=="unit_quantity"){$uq=$value;}
	if($key=="requested_amount"){$value=$un*$uq;}
	
	if($key=="purchase_date"){
		if($value==""){$value="";}else{$value=$dateSQL;}
	}
	
	if($key=="pay_center"){
	$dist=$centerArray[$value];
	$cc=$parkArray[$value];
	}
	
//	$val=addslashes($value);
	$val=$value;
$clause.=$key."='".$val."',";}
}

// Get most recent pa_number PRIOR to adding a new request
$sql="SELECT max(pa_number) as pa_number from purchase_request_3";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
$row=mysqli_fetch_array($result);$n=$row['pa_number']+1;

$clause.="district='".$dist."',center_code='".$cc."'";

$clause.=",account_description='".$park_acct_desc."'";
//echo "$clause  <br /><br />Sorry if you are trying to enter a request. I'm working on a change Tony requested. Contact Tom.";exit;

// Actullay run INSERT query
$result = mysqli_query($connection, $clause) or die ("Couldn't execute query 1. $clause");
//$newID=mysql_insert_id();
//$newID=mysqli_insert_id();
$query1="SELECT max(id) as 'newID' from purchase_request_3 where 1 ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);
$newDate=date('Ymd');
$sql="UPDATE `purchase_request_3` set pa_number='$n',system_entry_date='$newDate' WHERE id='$newID'";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 2. $sql");

$sql="update purchase_request_3, purchase_approval_report_dates
set purchase_request_3.report_date=purchase_approval_report_dates.report_date
where purchase_request_3.system_entry_date >= purchase_approval_report_dates.system_start
and purchase_request_3.system_entry_date <= purchase_approval_report_dates.system_end
and purchase_request_3.report_date='0000-00-00';
";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 3. $sql");

$sql="SELECT report_date from purchase_request_3 where id='$newID'";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
$row=mysqli_fetch_array($result);extract($row);

/*
$sql="update equipment_request_3,center
      set equipment_request_3.pay_center=center.new_center
	  where equipment_request_3.pay_center like '1280%'
	  and equipment_request_3.pay_center=center.center
	  and equipment_request_3.system_entry_date >= '20160701' ";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 3. $sql");
*/

$sql="update purchase_request_3,center
set purchase_request_3.section=center.section
where purchase_request_3.pay_center=center.new_center
and purchase_request_3.section=''";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 3. $sql");


$sql="update purchase_request_3,center
set purchase_request_3.district=center.dist
where purchase_request_3.pay_center=center.new_center
and purchase_request_3.district=''";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 3. $sql");


$sql="update purchase_request_3,center
set purchase_request_3.center_code=center.parkcode
where purchase_request_3.pay_center=center.new_center
and purchase_request_3.center_code=''";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 3. $sql");






header("Location: /budget/aDiv/park_purchase_request_view.php?view=all&report_date=$report_date&submit=Submit");
exit;
} // end Add


if($submit=="Update"){
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  


 foreach ($_REQUEST as $key => $value) {
	if($key!="submit" AND $key!="PHPSESSID" AND $key!="f_year" AND $key!="center" AND $key!="passQuery"){
 foreach ($value as $pa_number => $val){//rearrange by pa_number
	$newKey[$pa_number][$key]=$val;}
	}
 }
//echo "<pre>";print_r($newKey);echo "</pre>";//exit;
 
 foreach ($newKey as $key => $value) {
 $clause="UPDATE purchase_request_3 SET ";
 foreach ($value as $fld => $val){
	if($fld=="unit_cost" || $fld=="requested_amount"){
	$val=str_replace(",","",$val);}// remove any commas 1,000 => 1000
	
	if(($fld=="order_complete"||$fld=="receive_complete"||$fld=="paid_in_full")  and $newKey[$key]['ordered_amount']=="0.00"){$val="n";}// never allow y 

if($fld=="ordered_amount" and $newKey[$key]['order_complete']=="n")
{$val="0.00";}// never allow > 0


	if($fld=="category"){$exp=explode("=",$val);
	$clause.="category='".$exp[0]."',";
	$fld="ncas_account";$val=$exp[1];}
	
	if($fld=="unit_cost"){$un=$val;}
	if($fld=="unit_quantity"){$uq=$val;}
	if($fld=="requested_amount"){$val=$un*$uq;}
	if($fld=="purchase_date"){
		if($newKey[$key]['purchase_date']!=""){$dateSQL=date("Ymd",strtotime($newKey[$key]['purchase_date']));} else {$dateSQL="";}
		
		$val=$dateSQL;}
	
 $clause.=$fld."='".$val."',";
	}
	
//remove trailing comma
$clause=trim($clause,",");
//	echo "$clause<br><br>";exit;
	
// Rename some fields and remove trailing comma
	$clause.="where pa_number='".$key."'";
//		$n=",where";$w=" where";
//	$clause=str_replace($n,$w,$clause);

	
	$sql="$clause";
//echo "$sql";exit;
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
 }


$sql="update purchase_request_3
set requested_amount=ordered_amount
where order_complete='y'";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 2. $sql");

$sql="update purchase_request_3,center
set purchase_request_3.section=center.section
where purchase_request_3.pay_center=center.center
and purchase_request_3.section=''";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 3. $sql");

extract($_REQUEST);

 header("Location: /budget/aDiv/park_purchase_request.php?$passQuery");
 }
?>