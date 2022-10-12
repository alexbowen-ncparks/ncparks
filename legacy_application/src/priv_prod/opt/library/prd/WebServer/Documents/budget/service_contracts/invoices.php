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
//$project_category='ITS';
//$project_name='wex_bill';
//$step_group='B';


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters




$query1="SELECT highlight_color from infotrack_customformat
         where user_id='$tempid' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);


include("../../budget/menu1314.php");

echo "<table align='center'>";
echo "<tr>";




echo "</tr>";
echo "</table>";




//echo "<html>";

echo "<head>";

echo "</head>";


if($report_type=='form'){$report_form="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($report_type=='reports'){$report_reports="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

echo "<style>
td {
    padding: 10px;
}

th {
    padding: 10px;
}



</style>";



echo "<br /><table align='center' border='1' align='left'><tr><th><a href='invoices.php?fyear=$fyear&report_type=form&reset=y'>Payment Form</a><br />$report_form</th><th><font color='brown'>Service Contract<br />Invoices</font></th><th><a href='invoices.php?fyear=$fyear&report_type=reports'>Payment History</a><br />$report_reports </th></tr></table>";

echo "<br />";

if($report_type=='form')
{


echo "<br />";

$query3="SELECT * from service_contracts where id='$id' ";


//echo "query3=$query3<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);

$row3=mysqli_fetch_array($result3);

extract($row3);

echo "<table align='center' border=1>";
 
echo "<tr><th align='center'><font color='brown'>Service Month</font></th><td>$service_month</td></tr>";
echo "<tr><th align='center'><font color='brown'>Park</font></th><td>$park</td></tr>";
echo "<tr><th align='center'><font color='brown'>Contract#</font></th><td>$contract_num</td></tr>";
echo "<tr><th align='center'><font color='brown'>Contractor</font></th><td>$vendor</td></tr>";
echo "<tr><th align='center'><font color='brown'>FID#</font></th><td>$fid_num</td></tr>";
echo "<tr><th align='center'><font color='brown'>Group#</font></th><td>$group_num</td></tr>";
echo "<tr><th align='center'><font color='brown'>Remit to Address</font></th><td>$remit_address</td></tr>";
echo "<tr><th align='center'><font color='brown'>Purpose</font></th><td>$purpose</td></tr>";
echo "<tr><th align='center'><font color='brown'>Purchase Order#</font></th><td>$po_num</td></tr>";
echo "<tr><th align='center'><font color='brown'>PO Line#</font></th><td>$line_num</td></tr>";
echo "<tr><th align='center'><font color='brown'>Buy EntityPO Line#</font></th><td>$line_num</td></tr>";
echo "<tr><th align='center'><font color='brown'>Invoice Number</font></th><td>$invoice_num</td></tr>";
echo "<tr><th align='center'><font color='brown'>Invoice Date</font></th><td>$invoice_date</td></tr>";
echo "<tr><th align='center'><font color='brown'>Company</font></th><td>$company</td></tr>";
echo "<tr><th align='center'><font color='brown'>Account</font></th><td>$ncas_account</td></tr>";
echo "<tr><th align='center'><font color='brown'>Center</font></th><td>$center</td></tr>";
echo "<tr><th align='center'><font color='brown'>Contract Administrator</font></th><td>$contract_administrator</td></tr>";

      
                 
       
 

echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time


echo "</table>";

if($report=='y')

{echo "<table><tr><th>Pending</th></tr></table>" ;}
/*
{




echo "<br />";


$query4="select center,center_code,invoice_number,invoice_date,ncas_account,sum(amount) as 'amount',sum(rebate_adjust) as 'rebate_adjust',sum(amount-rebate_adjust) as 'adjusted_amount'
          from wex_report where valid='n'
         group by center,ncas_account
         order by center,ncas_account		 ";

//echo "query4=$query4<br />";
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4 ");		 
		 
		 
		 
$query4_total="SELECT sum(amount) as 'total_amount1',sum(rebate_adjust) as 'rebate_adjust_total',sum(amount-rebate_adjust) as 'adjusted_amount_total'
          from wex_report
		  where valid='n' ";



		  
//echo "query4_total=$query4_total<br />";		  
		 
$result4_total = mysqli_query($connection, $query4_total) or die ("Couldn't execute query 4 total.  $query4_total ");		
$row4_total=mysqli_fetch_array($result4_total);

extract($row4_total);


$rebate_adjust_total=number_format($rebate_adjust_total,2);
$adjusted_amount_total=number_format($adjusted_amount_total,2);


$total_amount1=number_format($total_amount1,2);
echo "total_amount1=$total_amount1 <br />";



echo "<table align='center' border='1'>";
echo "<tr><td align='center'><font color='brown'>line#</font></td><td align='center'><font color='brown'>invoice date</font></td><td align='center'><font color='brown'>invoice#</font></td><td align='center'><font color='brown'>center</font></td><td align='center'><font color='brown'>center_code</font></td><td align='center'><font color='brown'>account</font></td><td align='center'><font color='brown'>purchase </font></td><td align='center'><font color='brown'>rebate</font></td><td align='center'><font color='brown'>owed</font></td></tr>";
                 
       
 while ($row4=mysqli_fetch_array($result4))
	{	
	
extract($row4);	
$rank=@$rank+1;
$amount=number_format($amount,2);

//if($account=='532819' and $center_change != 'y'){$t=" bgcolor='salmon' ";}else{$t=" bgcolor='lightgreen' ";}

$table_bg2="cornsilk";

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}



echo "<tr$t>";
echo "<td>$rank</td>";
echo "<td>$invoice_date</td>";
echo "<td>$invoice_number</td>";
echo "<td>$center</td>";
echo "<td>$center_code</td>";
echo "<td>$ncas_account</td>";
echo "<td>$amount</td>";
echo "<td>$rebate_adjust</td>";
echo "<td>$adjusted_amount</td>";

echo "</tr>";

}
echo "<tr><td></td><td></td><td></td><td></td><td></td><td>Total</td><td>$total_amount1</td><td>$rebate_adjust_total</td><td>$adjusted_amount_total</td></tr>";
}
*/
}

if($report_type=='reports')
{

echo "<table><tr><th>Pending</th></tr></table>";
//include("fyear_head_wex_bill.php");// database connection parameters
/*
echo "<br />";
$report_listing="SELECT system_entry_date,user_id,ncas_invoice_number,month,calyear,sum(ncas_invoice_amount) as 'monthly_bill_total'
                  from wex_report
		          where 1 and fyear='$fyear'
				  and active='y'
		          group by ncas_invoice_number
		          order by system_entry_date desc   ";

	
//echo "report_listing=$report_listing <br />";
	
$result_report_listing = mysqli_query($connection, $report_listing) or die ("Couldn't execute report listing.  $report_listing");
$num_report_listing=mysqli_num_rows($result_report_listing);  
				  
echo "<table align='center' border='1' padding='5'>";
echo "<tr><th>Invoice<br />Number</th><th>Total<br />Amount</th><th>Entered<br />by</th></tr>";				  
			  
				  
 while ($row_report_listing=mysqli_fetch_array($result_report_listing))
	{	
	
extract($row_report_listing);	

$monthly_bill_total2=number_format($monthly_bill_total,2);
if($table_bg2==''){$table_bg2='cornsilk';}
if($color==''){$t=" bgcolor='$table_bg2' ";$color=1;}else{$t='';$color='';}

echo "<tr$t>";
echo "<td><font color='brown'>$ncas_invoice_number</font> <a href='/budget/acs/acsFind.php?ncas_invoice_number=$ncas_invoice_number&submit_acs=Find' target='_blank'><img height='40' width='40' src='/budget/infotrack/icon_photos/magnify.png' alt='picture of home'></img></a><br />$month-$calyear</td>";
echo "<td>$monthly_bill_total2</td>";
echo "<td>$user_id</td>";
//echo "<td><a href='/budget/acs/acsFind.php?ncas_invoice_number=$ncas_invoice_number&submit_acs=Find' target='_blank'>CDCS</a></td>";

	
	
	
echo "</tr>";				  
}

echo "</table>";	
}


*/

}
echo "</body></html>";

?>

























