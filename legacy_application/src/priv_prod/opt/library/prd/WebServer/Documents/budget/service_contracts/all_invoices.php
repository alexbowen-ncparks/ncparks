<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}


$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
extract($_REQUEST);

$scid=$id;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//$project_category='ITS';
//$project_name='wex_bill';
//$step_group='B';


$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
mysqli_select_db($connection,$database); // database
//include("../../../include/activity.php");// database connection parameters
include("../../../include/activity_new.php");// database connection parameters
echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" href=\"/js/jquery_1.10.3/jquery-ui.css\" />
<script src=\"/js/jquery_1.10.3/jquery-1.9.1.js\"></script>
<script src=\"/js/jquery_1.10.3/jquery-ui.js\"></script>
<link rel=\"stylesheet\" href=\"/resources/demos/style.css\" />";
//echo "<link rel=\"stylesheet\" href=\"test_style_1657.css\" />";
echo "<link rel='stylesheet' type='text/css' href='1533d.css' />";

echo "
<script>
$(function() {
$( \"#datepicker\" ).datepicker({dateFormat: 'yy-mm-dd'});
});
</script>";
echo "</head>";


$query1="SELECT highlight_color from infotrack_customformat
         where user_id='$tempid' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection,$query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);


//include("../../budget/menu1314.php");

//include ("../../budget/menu1415_v1.php");
include ("../../budget/menu1415_v1_new.php");

//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";
echo "<br />";
$menu_sc='SC5';
include("service_contracts_menu3.php");

include ("approver_credentials_1a.php");


//RETURNS number of Invoices Entered for PO Line#

$query2a="select count(id) as 'invoice_count' from service_contracts_invoices where scid='$id' ";	

//echo "query2a=$query2a<br />";//exit;		  

$result2a = mysqli_query($connection,$query2a) or die ("Couldn't execute query 2a.  $query2a");
		  
$row2a=mysqli_fetch_array($result2a);

extract($row2a);

//echo "invoice_count=$invoice_count<br />";


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



$query10="SELECT park as 'contract_park',vendor as 'contractor',contract_num,po_num,line_num,line_num_beg_bal as 'begin_balance'
from service_contracts
WHERE 1
and id='$scid'
";


$result10 = mysqli_query($connection,$query10) or die ("Couldn't execute query10.  $query10");
$num10=mysqli_num_rows($result10);
$row10=mysqli_fetch_array($result10);
extract($row10);

$contract_park=strtoupper($contract_park);

//echo "query10=$query10<br />";

/*
$query10a="SELECT max(id) as 'last_pay_id'
from service_contracts_invoices
WHERE 1
and scid='$scid'
";


$result10a = mysqli_query($query10a) or die ("Couldn't execute query10a.  $query10a");
$num10a=mysqli_num_rows($result10a);
$row10a=mysqli_fetch_array($result10a);
extract($row10a);

echo "last_pay_id=$last_pay_id<br />";

echo "query10a=$query10a<br />";
*/
/*
$query10b="SELECT sum(cummulative_amount_paid) as 'total_paid'
from service_contracts_invoices
WHERE 1
and id='$last_pay_id'
";
*/

$query10b="SELECT sum(invoice_amount) as 'total_paid'
from service_contracts_invoices
WHERE 1
and scid='$scid'
";


echo "query10b=$query10b<br />";






$result10b = mysqli_query($connection,$query10b) or die ("Couldn't execute query10b.  $query10b");
$num10b=mysqli_num_rows($result10b);
$row10b=mysqli_fetch_array($result10b);
extract($row10b);

//echo "total_paid=$total_paid<br />";

//echo "query10b=$query10b<br />";

$end_balance=$begin_balance-$total_paid;
if($end_balance <= 0)
{
$end_balance_message=" <img height='50' width='50' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of green check mark'></img>";
}
else
{
$end_balance_message=" <img height='50' width='50' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";


}
//echo "end_balance=$end_balance<br />";
$begin_balance=number_format($begin_balance,2);
$total_paid=number_format($total_paid,2);
$end_balance2=number_format($end_balance,2);

/*
echo "<br /><table border='1' align='center'><tr><th><a href='/budget/service_contracts/service_contracts.php'><img height='75' width='75' src='dumpster1.jpg' alt='picture of fuel tank'></img></a><font color='brown'><b>Service Contract Invoices</font></th><th><a href='all_invoices.php?fyear=$fyear&report_type=reports&id=$id'>View<br />ALL <br />Invoices</a><br />$report_reports </th>";
//echo "<th><a href='payment_form.php?fyear=$fyear&report_type=form&id=$id'>Create <br />NEW<br />Invoice</a><br />$report_form</th>";
echo "</tr></table>";
*/

//echo "<br /><table border='1' align='center'><tr><th><b>Service Contract Invoices</font></th><th><a href='all_invoices.php?fyear=$fyear&report_type=reports&id=$id'>View<br />ALL <br />Invoices</a><br />$report_reports </th>";
//echo "<br /><table border='1' align='center'><tr><th><b>Service Contract Invoices</font></th>";


//echo "<th><a href='payment_form.php?fyear=$fyear&report_type=form&id=$id'>Create <br />NEW<br />Invoice</a><br />$report_form</th>";
echo "</tr></table>";







echo "<br />";

echo "<br />";
//echo "<table align='center'><tr><td><font color='brown'>$contract_vendor($contract_park)</font></td><td>PO# <font color='red'>$contract_ponum</font></td></tr></table>";
/*
$query11="SELECT park as 'contract_park',center,invoice_num,invoice_date,service_period,cashier,cashier_date,cashier_approved,manager,manager_date,puof,puof_date,buof,buof_date,sum(invoice_amount) as 'current_amount',sum(line_num_beg_bal) as 'begin_balance',sum(previous_amount_paid) as 'previous_amount',sum(line_num_beg_bal-previous_amount_paid) as 'avail_before_invoice',id,invoice_old_method 
from service_contracts_invoices
WHERE 1
and scid='$scid'
group by id
order by invoice_date desc ";
*/

if($scid != '')
{	
$query11="SELECT center,invoice_num,invoice_date,service_period,cashier,cashier_date,cashier_approved,manager,manager_date,puof,puof_date,buof,buof_date,sum(invoice_amount) as 'current_amount',id from service_contracts_invoices WHERE 1 and scid='$scid' group by id order by invoice_date desc";
}


if($scid == '')
{
/*	
$query11="SELECT service_contracts.park as 'contract_park',service_contracts.vendor as 'contract_vendor',service_contracts.po_num as 'contract_ponum',service_contracts_invoices.center,invoice_num,invoice_date,service_period,cashier,cashier_date,cashier_approved,manager,manager_date,puof,puof_date,buof,buof_date,
         sum(invoice_amount) as 'current_amount',service_contracts_invoices.id 
         from service_contracts_invoices
         left join service_contracts on service_contracts_invoices.scid=service_contracts.id
		 WHERE 1  order by service_contracts_invoices.id desc";
*/	

$query11="SELECT service_contracts.park as 'contract_park',service_contracts.vendor as 'contract_vendor',service_contracts.po_num as 'contract_ponum',service_contracts.center as 'contract_center',
 
          service_contracts_invoices.po_line_num as 'contract_po_line_num',service_contracts_invoices.invoice_num,service_contracts_invoices.invoice_date,service_contracts_invoices.service_period,
		  service_contracts_invoices.cashier,service_contracts_invoices.cashier_date,service_contracts_invoices.cashier_approved,service_contracts_invoices.manager,service_contracts_invoices.manager_date,
		  service_contracts_invoices.puof,service_contracts_invoices.puof_date,service_contracts_invoices.buof,service_contracts_invoices.buof_date,
		  sum(service_contracts_invoices.invoice_amount) as 'current_amount',service_contracts_invoices.id 
          from service_contracts_invoices
          left join service_contracts on service_contracts_invoices.scid=service_contracts.id
		  WHERE 1  order by service_contracts_invoices.park_approved desc,service_contracts.park asc";

	
		 
		 
}

//



$result11 = mysqli_query($connection,$query11) or die ("Couldn't execute query 11.  $query11 ");
$num11=mysqli_num_rows($result11);		
echo "query11=$query11<br />";
/*
echo "<table align='center'><tr>
<td><font color='brown'>Contractor:</font> $contractor</td>
<td><font color='brown'>Contract#:</font> $contract_num</td>
<td><font color='brown'>PO#:</font> $po_num</td><td><font color='brown'>Line#:</font> $line_num</td>
</tr>";
if($invoice_count == 0)
{echo "<tr><td><font color='brown'><img height='40' width='40' src='/budget/infotrack/icon_photos/info2.png' alt='picture of green check mark'></img>NO Invoices entered for this Contract</font></td></tr></table>"; exit; }

if($invoice_count > 0)
{
echo "<tr>
<td><font color='brown'>Begin Balance:</font> $begin_balance</td>";
echo "<td><font color='brown'>Invoices Paid:</font> $total_paid</td>
<td><font color='brown' size='6'>Available:</font> $end_balance2 $end_balance_message</td>";
echo "</tr></table>";
}
*/

echo "<br />";
echo "<table align='center'>";

echo 

"<tr>"; 
       echo "<th align=left><font color=brown>Park</font></th>";
       echo "<th align=left><font color=brown>Contract</font></th>";
      

       echo "<th align=left><font color=brown>Invoice</font></th>";
	
	   echo "<th align=left><font color=brown>Cashier</font></th>
	   <th align=left><font color=brown>Manager</font></th>
	   <th align=left><font color=brown>PUOF</font></th>
	   <th align=left><font color=brown>BUOF</font></th>";
	   
	   echo "<th align=left><font color=brown>DNCR Form</font></th>";
	              
echo "</tr>";

while ($row11=mysqli_fetch_array($result11)){


extract($row11);
$cashier3=substr($cashier,0,-2);
$manager3=substr($manager,0,-2);
$puof3=substr($puof,0,-2);
$buof3=substr($buof,0,-2);
$avail_before_invoice2=number_format($avail_before_invoice,2);
$avail_after_invoice=$avail_before_invoice-$current_amount;
$avail_after_invoice2=number_format($avail_after_invoice,2);
$total_amount=$previous_amount+$current_amount;
$previous_amount=number_format($previous_amount,2);
$current_amount=number_format($current_amount,2);
$total_amount=number_format($total_amount,2);

if($cashier_date=='0000-00-00')
{$cashier_date_dow='';}
else
{$cashier_date_dow=date('l',strtotime($cashier_date));}


if($manager_date=='0000-00-00')
{$manager_date_dow='';}
else
{$manager_date_dow=date('l',strtotime($manager_date));}

if($puof_date=='0000-00-00')
{$puof_date_dow='';}
else
{$puof_date_dow=date('l',strtotime($puof_date));}

if($buof_date=='0000-00-00')
{$buof_date_dow='';}
else
{$buof_date_dow=date('l',strtotime($buof_date));}





$cashier_date2=date('m-d-y', strtotime($cashier_date));
$manager_date2=date('m-d-y', strtotime($manager_date));
$puof_date2=date('m-d-y', strtotime($puof_date));
$buof_date2=date('m-d-y', strtotime($buof_date));
$invoice_date2=date('m-d-y', strtotime($invoice_date));
if($invoice_old_method=='y'){$invoice_date2='unknown';}

if($record_complete == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}
echo 

"<tr$t>";
		   echo "<td bgcolor='lightgreen'>$contract_park<br />$contract_center</td>";  
		   echo "<td bgcolor='lightgreen'>$contract_vendor<br />PO#: <font color='brown'>$contract_ponum </font> Line# <font color='brown'>$contract_po_line_num</font></td>";  
		    echo "<td bgcolor='lightgreen'><font color='brown'>Invoice#: $invoice_num<br />Invoice date: $invoice_date2<br /><font color='black'>Amount: $current_amount</font><br /><font color='brown'>Period: $service_period</font></td>";
			
		   if($cashier_approved=='n' and $cashier_count==1)
			{
		   echo "<td bgcolor='lightpink'><a href='dncr_form.php?scid=$scid&id=$id' >Update</a></td>";
		   }  
		   //if 1)TABLE fuel_tank_usage.cashier is blank and 2)tempid is not a Cashier in cash_handling_roles.role
		   if($cashier_approved=='n' and $cashier_count != 1)
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }
		   if($cashier_approved=='y')
		   {
		  
		   
		   echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		   
		 
		   echo "<br />$cashier3<br />$cashier_date2<br />$cashier_date_dow</td>";	
	       }
		
		   if($manager=='' and $manager_count==1 and $cashier_approved=='y')//(manager_count == 1)
			{		   
		   echo "<td bgcolor='lightpink'><a href='dncr_form.php?scid=$scid&id=$id' >Update</a></td>";
		   } 
		   
		   if($manager=='' and $manager_count == 1 and $cashier_approved=='n')
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   } 		   	   
		   
		   
		   if($manager=='' and $manager_count != 1)
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   } 		   	   
		   
		   if($manager != '')
		   {
		  echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";		 
		  
		  echo "<br />$manager3<br />$manager_date2<br />$manager_date_dow</td>";
	       }     
		 

           if($puof=='' and $cashier != '' and $manager != '' and $puof_count==1)//(manager_count == 1)
			{		   
		   echo "<td bgcolor='lightpink'><a href='dncr_form.php?scid=$scid&id=$id' >Update</a></td>";
		   } 
		   
		    if(($puof=='' and $puof_count==1) and ($cashier=='' or $manager==''))//(manager_count == 1)
			{		   
		  echo "<td bgcolor='lightpink'></td>";
		   } 
		   
		   
		   if($puof=='' and $puof_count != 1)
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   } 		   	   
		   
		   if($puof != '')
		   {
		  echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";		 
		  
		  echo "<br />$puof3<br />$puof_date2<br />$puof_date_dow</td>";
	       }     

		   
		   if($buof=='' and $cashier != '' and $manager != '' and $puof != '' and $buof_count==1)//(manager_count == 1)
			{		   
		   echo "<td bgcolor='lightpink'><a href='dncr_form.php?scid=$scid&id=$id' >Update</a></td>";
		   } 
		   
		    if(($buof=='' and $buof_count==1) and ($cashier=='' or $manager=='' or $puof==''))//(manager_count == 1)
			{		   
		  echo "<td bgcolor='lightpink'></td>";
		   } 
		   
		   
		   if($buof=='' and $buof_count != 1)
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   } 		   	   
		   
		   if($buof != '')
		   {
		  echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";		 
		  
		  echo "<br />$buof3<br />$buof_date2<br />$buof_date_dow</td>";
	       }     

		    
		   
		   
          /*
		   if($buof=='' and $buof_count==1)//(manager_count == 1)
			{		   
		   echo "<td bgcolor='lightpink'><a href='dncr_form.php?scid=$scid&id=$id' >Update</a></td>";
		   } 
		   
		   if($buof=='' and $buof_count != 1)
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   } 		   	   
		   
		   if($buof != '')
		   {
		  echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";		 
		  
		  echo "<br />$buof3<br />$buof_date2<br />$buof_date_dow</td>";
	       }       

      */
	  if($buof_count != 1)
	  {
        if($buof == '')
        {		
		echo "<td><a href='dncr_final.php?id=$id'>View</a></td>";
        }		


		if($buof != '')
        {		
		echo "<td bgcolor='lightgreen'><a href='dncr_final.php?id=$id'>View</a></td>";
        }		
       }
	

	if($buof_count == 1)
	  {
        if($buof == '')
        {		
		echo "<td><a href='dncr_final.php?id=$id'>View</a><br /><br /><a href='current_invoice.php?step=2&report_type=form&id=$scid&eid=$id'>Edit</a></td>";
        }		


		if($buof != '')
        {		
		echo "<td bgcolor='lightgreen'><a href='dncr_final.php?id=$id'>View</a><br /><br /><a href='current_invoice.php?step=2&report_type=form&id=$scid&eid=$id'>Edit</a></td>";
        }		
       }
	
	
	
	
	
	
	
	
	
	
        //echo "<td><a href='dncr_final.php?id=$id'>View</a></td>";








	
           
echo "</tr>";

}

 echo "</table>";

echo "</body></html>";

?>