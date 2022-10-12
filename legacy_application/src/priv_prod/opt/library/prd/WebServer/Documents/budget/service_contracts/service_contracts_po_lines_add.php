<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

$system_entry_date=date("Ymd");
echo "<br />lines2add=$lines2add<br />"; //exit;
$query1="insert into service_contracts_po_lines SET";
for($j=0;$j<$lines2add;$j++){
$query2=$query1;

$po_line_num_beg_bal2=$po_line_num_beg_bal[$j];
$po_line_num_beg_bal2=str_replace(",","",$po_line_num_beg_bal2);
$po_line_num_beg_bal2=str_replace("$","",$po_line_num_beg_bal2);
if($po_line_num_beg_bal2==''){continue;}

	$query2.=" scid='$scid',";
	$query2.=" po_line_num='$po_line_num[$j]',";
	$query2.=" po_line_num_beg_bal='$po_line_num_beg_bal2'";
		
echo "<br />query2=$query2<br />";
$result2=mysqli_query($connection,$query2) or die ("Couldn't execute query 2. $query2");
}	

echo "<br />New PO Lines added<br />"; //exit;
 
 ?>