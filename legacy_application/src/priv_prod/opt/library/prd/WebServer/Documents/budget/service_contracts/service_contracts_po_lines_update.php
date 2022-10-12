<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

$system_entry_date=date("Ymd");
// New PO Lines Added
if($submit2=='Update')
{
//echo "<br />lines2add=$lines2add<br />"; //exit;
//$query1="insert into service_contracts_po_lines SET";
$query1="insert into `budget_service_contracts`.`po_lines` SET";
for($j=0;$j<$lines2add;$j++){
$query2=$query1;

$po_line_num_beg_bal2=$po_line_num_beg_bal[$j];
$po_line_num_beg_bal2=str_replace(",","",$po_line_num_beg_bal2);
$po_line_num_beg_bal2=str_replace("$","",$po_line_num_beg_bal2);
if($po_line_num_beg_bal2==''){continue;}

	$query2.=" `scid`='$scid',";
	$query2.=" `po_line_num`='$po_line_num[$j]',";
	$query2.=" `po_line_num_beg_bal`='$po_line_num_beg_bal2'";
		
//echo "<br />query2=$query2<br />";
$result2=mysqli_query($connection,$query2) or die ("Couldn't execute query 2. $query2");

//$query2a="insert into service_contracts_invoices_paylines set scid='$scid',payline_num='$po_line_num[$j]' ";
//if($beacnum != '60032781'){$query2a="insert into `budget_service_contracts`.`pay_lines` set `scid`='$scid',`payline_num`='$po_line_num[$j]',`preDB`='y',`cashier_approved`='y' ";}
//if($beacnum == '60032781'){$query2a="insert into `budget_service_contracts`.`pay_lines` set `scid`='$scid',`payline_num`='$po_line_num[$j]',`preDB`='y',`cashier_approved`='y',`manager_approved`='y' ";}
$query2a="insert into `budget_service_contracts`.`pay_lines` set `scid`='$scid',`payline_num`='$po_line_num[$j]',`preDB`='y',`cashier_approved`='y',`manager_approved`='y' ";

$result2a=mysqli_query($connection,$query2a) or die ("Couldn't execute query 2a. $query2a ");       



}	

//echo "<br />New PO Lines added<br />"; //exit;
}

// Update Existing PO Lines
if($submit3=='Update')
{
//echo "<br />lines2edit=$lines2edit<br />"; //exit;
//$query1="update service_contracts_po_lines SET";
$query1="update `budget_service_contracts`.`po_lines` SET";
for($j=0;$j<$lines2edit;$j++){
$query2=$query1;

$po_line_num_beg_bal2=$po_line_num_beg_bal[$j];
$po_line_num_beg_bal2=str_replace(",","",$po_line_num_beg_bal2);
$po_line_num_beg_bal2=str_replace("$","",$po_line_num_beg_bal2);
if($po_line_num_beg_bal2==''){continue;}
/*
	$query2.=" `po_line_num`='$po_line_num[$j]',";
	$query2.=" `po_line_num_beg_bal`='$po_line_num_beg_bal2'";
	$query2.=" where `id`='$id[$j]' ";
*/
	$query2.=" `po_line_num_beg_bal`='$po_line_num_beg_bal2'";
	$query2.=" where `po_line_num`='$po_line_num[$j]' and scid='$scid' ";
	
//echo "<br />query2=$query2<br />";
$result2=mysqli_query($connection,$query2) or die ("Couldn't execute query 2. $query2");
}	

if($po_line_num_new != '' and $po_line_num_beg_bal_new != '')
{	

$query3="insert into `budget_service_contracts`.`po_lines`
        set `scid`='$scid',`po_line_num`='$po_line_num_new',`po_line_num_beg_bal`='$po_line_num_beg_bal_new' ";


$result3=mysqli_query($connection,$query3) or die ("Couldn't execute query 3. $query3 ");  

$query3a="insert into `budget_service_contracts`.`pay_lines` set `scid`='$scid',`payline_num`='$po_line_num_new',`preDB`='y',`cashier_approved`='y',`manager_approved`='y' ";

$result3a=mysqli_query($connection,$query3a) or die ("Couldn't execute query 3a. $query3a "); 

}





//echo "<br />Existing PO Lines updated<br />"; //exit;
}



 
 ?>