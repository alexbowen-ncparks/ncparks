<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
$pre_split_total=str_replace(",","",$pre_split_total);  
$post_split_records=count($amount);

$post_split_total=array_sum($amount); 

$pre_split_total=number_format($pre_split_total,2);
$post_split_total=number_format($post_split_total,2);
	
if($pre_split_total != $post_split_total)
{echo "<font color='brown' size='5'>Oops:Total amount on form submitted is $post_split_total. Total Amount should be $pre_split_total<br /><br />Click the BACK button on your Browser to Re-enter Amounts</font><br />";exit;}

//echo "array_total = array_sum($array[amount])";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;


$query0="update vmc_posted7_v2
         set parent_record='y'
		 where id='$id' ";

$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0 ");



$query1="select park,center,f_year,month,invoice,description,acct,day,acctdate,cvip_id,pcu_transid,cvip_comments,pcu_item_purchased,vmc_comments
from vmc_posted7_v2
where id='$id'
";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1 ");
$row1=mysqli_fetch_array($result1);

extract($row1);


//exit;

$query2="insert into vmc_posted7_v2 SET";
for($j=0;$j<$post_split_records;$j++)
	{	
	if($amount[$j] ==""){continue;}
	$query3=$query2;
		$query3.=" amount='$amount[$j]',";
		$query3.=" license_tag='$tag_num[$j]',";
		$query3.=" park='$park',";	
		$query3.=" center='$center',";	
		$query3.=" f_year='$f_year',";	
		$query3.=" month='$month',";	
		$query3.=" invoice='$invoice',";	
		$query3.=" description='$description',";	
		$query3.=" acct='$acct',";	
		$query3.=" day='$day',";	
		$query3.=" acctdate='$acctdate',";	
		$query3.=" cvip_id='$cvip_id',";	
		$query3.=" pcu_transid='$pcu_transid',";	
		$query3.=" cvip_comments='$cvip_comments',";	
		$query3.=" pcu_item_purchased='$pcu_item_purchased',";	
		$query3.=" vmc_comments='$vmc_comments',";	
		$query3.=" player='$tempid',";	
		$query3.=" parent_id='$id'";	
		
			
	
	$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query 3. $query3");
	}	
	
	
$query4="update vmc_posted7_v2
set record_complete='n'
where license_tag = ''
or license_tag='multiple' ";

$result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");	
	
	
	
	
$query5="update vmc_posted7_v2
set record_complete='y'
where license_tag != ''
and license_tag != 'multiple' ";

$result5=mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

if($submit2=='Update')
{
header("location: vm_costs_center_daily.php?f_year=$f_year&park=$park&center=$center");
}

 ?>




















