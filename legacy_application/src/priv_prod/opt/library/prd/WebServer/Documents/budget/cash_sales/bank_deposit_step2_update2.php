<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;

echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;


$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];


if($concession_location=='ADM'){$concession_location='ADMI';}

echo "concession_location=$concession_location<br /><br />";

//echo "tempid=$tempid<br /><br />";
//echo "level=$level<br /><br />";
//echo "concession_center=$concession_center<br /><br />";
//echo "concession_location=$concession_location<br /><br />"; exit;


//echo "hello<br /><br />";

//echo $tempid;
extract($_REQUEST);
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
echo "num14=$num14<br /><br />";
echo "<pre>";print_r($_REQUEST);"</pre>"; exit;



$system_entry_date=date("Ymd");


/*

$query1="update crs_deposit_counts SET";
for($j=0;$j<$num14;$j++){
$query2=$query1;


$total_amount2=$total_amount[$j];
$total_amount2=str_replace(",","",$total_amount2);
$total_amount2=str_replace("$","",$total_amount2);
//if($total_amount2=='0.00'){continue;}



$cash_amount2=$cash_amount[$j];
$cash_amount2=str_replace(",","",$cash_amount2);
$cash_amount2=str_replace("$","",$cash_amount2);
//if($cash_amount2=='0.00'){continue;}


$check_amount2=$check_amount[$j];
$check_amount2=str_replace(",","",$check_amount2);
$check_amount2=str_replace("$","",$check_amount2);
//if($cash_amount2=='0.00'){continue;}

$grand_total=$cash_amount2+$check_amount2;

$adjustment=$grand_total-$total_amount2;

$sales_location2=$sales_location[$j];

	//$query2.=" payment_type='$payment_type2',";
	$query2.=" sales_total='$total_amount2',";
	//$query2.=" account_name='$account_name2',";
	$query2.=" cash_total='$cash_amount2',";
	$query2.=" check_total='$check_amount2', ";
	$query2.=" grand_total='$grand_total', ";
	$query2.=" adjustment='$adjustment' ";
	$query2.=" where manual_deposit_id='$manual_deposit_id' and sales_location='$sales_location2'";
	
		
	
//echo "query2=$query2<br /><br />";		

$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
}	



echo "end of page: line 91<br /><br />";
*/
//header("location: page2_form.php?step=2&edit=y&update1=y");



 
 ?>




















