<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$project_category='xtnd';
$project_name='dncr_down';
$step_group='B';


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
$queryCS_total="select sum(ncas_invoice_amount) as 'code_sheet_total' from cid_vendor_invoice_payments
where ncas_center='$new_center'
and post2ncas='n' ";

$result_cs_total = mysqli_query($connection, $queryCS_total) or die ("Couldn't execute queryCS_total.  $queryCS_total");

$row_cs_total=mysqli_fetch_array($result_cs_total);
extract($row_cs_total);

//echo "code_sheet_total=$code_sheet_total<br /><br />";


$queryPC_total="select sum(amount) as 'pcard_total'
from pcard_unreconciled
where center='$new_center'
and ncas_yn='n' ";

$result_pc_total = mysqli_query($connection, $queryPC_total) or die ("Couldn't execute queryPC_total.  $queryPC_total");

$row_pc_total=mysqli_fetch_array($result_pc_total);
extract($row_pc_total);

//echo "pcard_total=$pcard_total<br /><br />";

$unposted_total=$code_sheet_total+$pcard_total;

//echo "unposted_total=$unposted_total<br /><br />";


$query3="select ncas_center,project_number,vendor_name,ncas_invoice_number,ncas_invoice_amount,system_entry_date from cid_vendor_invoice_payments
where ncas_center='$new_center'
and post2ncas='n'
order by ncas_center,project_number ";


//echo "query3=$query3<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);



$query4="select center,projnum,vendor_name,transid_new,amount,postdate_new
from pcard_unreconciled
where center='$new_center'
and ncas_yn='n'
order by center,projnum
 ";


//echo "query4=$query4<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);

$code_sheet_total2=number_format($code_sheet_total,2);
$pcard_total2=number_format($pcard_total,2);
$unposted_total2=number_format($unposted_total,2);


echo "<table align='center' border=1><tr><td><font size='5'>Center $new_center: Total Unposted:  $unposted_total2</font></td></tr></table>";
echo "<br />";


echo "<table align='center' border=1><tr><td><font size='5'>Code Sheet Unposted: $num3 Records totalling: $code_sheet_total2</font></td></tr></table>";


echo "<table align='center' border=1>";
 
echo 

"<tr> 
       
       <td align='center'><font color='brown'>Center</font></td>
       <td align='center'><font color='brown'>Project#</font></td>
       <td align='center'><font color=brown>Vendor</font></td>
       <td align='center'><font color=brown>Invoice#</font></td>
       <td align='center'><font color=brown>Invoice Amount</font></td>
       <td align='center'><font color=brown>Entry Date</font></td>";
   
                 
       
 

echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row3=mysqli_fetch_array($result3))
	{	
	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	//$rank=@$rank+1;
	extract($row3);
	//$rank=$rank+1;
	
	
	
	
	echo 
		
	"<tr$t>";	
	echo "<td>$ncas_center</td>";
	echo "<td>$project_number</td>";
	echo "<td>$vendor_name</td>";
	echo "<td>$ncas_invoice_number</td>";
	echo "<td>$ncas_invoice_amount</td>";
	echo "<td>$system_entry_date</td>";
		   
		
				  
						 
	echo "</tr>";
	
	
	
	}

echo "</table>";


echo "<br />";

echo "<table align='center' border=1><tr><td><font size='5'>PCARD Unposted: $num4 Records totalling: $pcard_total2</font></td></tr></table>";


echo "<table align='center' border=1>";
 
echo 

"<tr> 
       
       <td align='center'><font color='brown'>Center</font></td>
       <td align='center'><font color='brown'>Project#</font></td>
       <td align='center'><font color=brown>Vendor</font></td>
       <td align='center'><font color=brown>Invoice#</font></td>
       <td align='center'><font color=brown>Invoice Amount</font></td>
       <td align='center'><font color=brown>Entry Date</font></td>";
   
                 
       
 

echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row4=mysqli_fetch_array($result4))
	{	
	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	//$rank=@$rank+1;
	extract($row4);
	//$rank=$rank+1;
	
	
	
	
	echo 
		
	"<tr$t>";	
	echo "<td>$center</td>";
	echo "<td>$projnum</td>";
	echo "<td>$vendor_name</td>";
	echo "<td>$transid_new</td>";
	echo "<td>$amount</td>";
	echo "<td>$postdate_new</td>";
		   
		
				  
						 
	echo "</tr>";
	
	
	
	}

echo "</table>";




echo "</body></html>";

?>

























