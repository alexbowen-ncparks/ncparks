<?php
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
//echo "<pre>";print_r($_REQUEST);
//print_r($_SESSION);
//echo "</pre>";
//exit;

extract($_REQUEST);

if($submit=="Update")
	{
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
		$val=str_replace(",","",$val);// remove any commas 1,000 => 1000
		//$val=mysqli_real_escape_string($val);
		$val=mysqli_real_escape_string($connection, $val);
		if(($fld=="order_complete"||$fld=="receive_complete"||$fld=="paid_in_full")  and $newKey[$key][ordered_amount]=="0.00"){$val="n";}// never allow y 

		if($fld=="unit_cost"){$un=$val;}
		if($fld=="unit_quantity"){$uq=$val;}
		//if($fld=="requested_amount"){$val=$un*$uq;}
	
	 $clause.=$fld."='".$val."',";
		}
		$reqAmt=$un*$uq; // set the correct requested_amount
	
	
	// Rename some fields and remove trailing comma
		$clause.="requested_amount='$reqAmt' where er_num='".$key."'";
			$n=",where";$w=" where";
		$clause=str_replace($n,$w,$clause);
		echo "$clause<br><br>"; //exit;
		$sql="$clause";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
	 }
	 //exit;

	extract($_REQUEST);
	 header("Location: /budget/aDiv/dist_equip_request.php");
	 }
?>