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
if($beacnum=='60032793')
{
echo "<pre>";print_r($_REQUEST); //exit;
echo "<pre>";print_r($_SESSION); //exit;
echo "beacnum=$beacnum";  exit;
}
*/
//print_r($_SESSION);
//echo "</pre>";exit;
extract($_REQUEST);

if($submit=="Add")
	{
	$sql="SELECT new_center as center,parkCode,dist from center";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
	while($row=mysqli_fetch_array($result))
	{
	$centerArray[$row['center']]=$row['dist'];
	$parkArray[$row['center']]=$row['parkCode'];
	}
	
	$ignore=array("PHPSESSID","passQuery","__utma","__utmz","__utmb","__utmc","submit");
	$clause="INSERT into equipment_request_3 set ";
	 foreach ($_REQUEST as $key => $value) {
		if($key!="submit" AND $key!="PHPSESSID" AND $key!="passQuery"){
		
			if(in_array($key,$ignore)){continue;} 
		if($key=="category"){$exp=explode("=",$value);
		$clause.="category='".$exp[0]."',";
		$key="ncas_account";$value=$exp[1];}
		
		if($key=="category"){$exp=explode("=",$value);
		$clause.="category='".$exp[0]."',";
		$key="ncas_account";$value=$exp[1];}
		
		if($key=="unit_cost"){$un=str_replace(",","",$value);$value=$un;}
		if($key=="unit_quantity"){$uq=$value;}
		if($key=="requested_amount"){$value=$un*$uq;}
		
		if($key=="pay_center")
			{
			$dist=$centerArray[$value];
			$cc=$parkArray[$value];
			}
		
 		$val=htmlspecialchars_decode($value);
		$val=$value;
	$clause.=$key."='".$val."',";}
	}
	
	$sql="SELECT max(er_num) as er_num from equipment_request_3";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
	$row=mysqli_fetch_array($result);$n=$row[er_num]+1;
	//echo "<br />er_num=$n<br />"; //exit;
	
	$clause.="district='".$dist."',center_code='".$cc."'";
	
	//echo "$clause Contact Tom."; //exit;
	
	$result = mysqli_query($connection, $clause) or die ("Couldn't execute query 1. $clause");
	
	
	//$newID=mysqli_insert_id();
	
	$sql="SELECT max(id) as last_id from equipment_request_3";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
	$row=mysqli_fetch_array($result); $newID=$row[last_id];
	
	
	
	//echo "<br />newID=$newID<br />"; //exit;
	
	$newDate=date('Ymd');
	$sql="UPDATE `equipment_request_3` set er_num='$n',system_entry_date='$newDate' WHERE id='$newID'";
	
	//echo "$sql Contact Tom."; exit;
	
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 2. $sql");
	
	$sql="update equipment_request_3,center
      set equipment_request_3.pay_center=center.new_center
	  where equipment_request_3.pay_center like '1280%'
	  and equipment_request_3.pay_center=center.center
	  and equipment_request_3.system_entry_date >= '20160701' ";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 3. $sql");

/*
$sql="update equipment_request_3,center
set equipment_request_3.section=center.section
where equipment_request_3.pay_center=center.new_center
and equipment_request_3.section=''";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 3. $sql");
*/


$sql="update equipment_request_3,center
set equipment_request_3.district=center.dist
where equipment_request_3.pay_center=center.new_center
and equipment_request_3.district=''";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 3. $sql");


$sql="update equipment_request_3,center
set equipment_request_3.center_code=center.parkcode
where equipment_request_3.pay_center=center.new_center
and equipment_request_3.center_code=''";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 3. $sql");
	
	 header("Location: /budget/aDiv/park_equip_request.php?$passQuery");
	exit;
	}


if($submit=="Update"){
 foreach ($_REQUEST as $key => $value) {
	if($key!="submit" AND $key!="PHPSESSID" AND $key!="f_year" AND $key!="center" AND $key!="passQuery"){
 foreach ($value as $er_num => $val){//rearrange by er_num
	$newKey[$er_num][$key]=$val;}
	}
 }
//echo "<pre>";print_r($newKey);echo "</pre>";//exit;
 
 foreach ($newKey as $key => $value) {
 $clause="UPDATE equipment_request_3 SET ";
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
	
	$val=htmlspecialchars_decode($val);
 $clause.=$fld."='".$val."',";
	}
	
//remove trailing comma
$clause=trim($clause,",");
//	echo "$clause<br><br>";exit;
	
// Rename some fields and remove trailing comma
	$clause.="where er_num='".$key."'";
//		$n=",where";$w=" where";
//	$clause=str_replace($n,$w,$clause);

	
	$sql="$clause";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
 }
// exit;

$sql="update equipment_request_3
set requested_amount=ordered_amount
where order_complete='y'";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 2. $sql");
/*
if($beacnum=='60032793')
{
echo "<br />Line 128<br />"; exit;
}
*/
$sql="update equipment_request_3,center
      set equipment_request_3.pay_center=center.new_center
	  where equipment_request_3.pay_center like '1280%'
	  and equipment_request_3.pay_center=center.center
	  and equipment_request_3.system_entry_date >= '20160701' ";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 3. $sql");

/*
$sql="update equipment_request_3,center
set equipment_request_3.section=center.section
where equipment_request_3.pay_center=center.new_center
and equipment_request_3.section=''";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 3. $sql");
*/

$sql="update equipment_request_3,center
set equipment_request_3.district=center.dist
where equipment_request_3.pay_center=center.new_center
and equipment_request_3.district=''";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 3. $sql");


$sql="update equipment_request_3,center
set equipment_request_3.center_code=center.parkcode
where equipment_request_3.pay_center=center.new_center
and equipment_request_3.center_code=''";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 3. $sql");


extract($_REQUEST);
 header("Location: /budget/aDiv/park_equip_request.php?$passQuery");
 }
?>