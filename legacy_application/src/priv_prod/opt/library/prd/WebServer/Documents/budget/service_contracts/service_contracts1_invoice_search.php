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
//echo "<pre>";print_r($_REQUEST); echo "</pre>"; //exit;



$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
mysqli_select_db($connection,$database); // database
//include("../../../include/activity.php");// database connection parameters
include("../../../include/activity_new.php");// database connection parameters
echo "<html>";

//include("head1.php");
include ("../../budget/menu1415_v1_new.php");
if($delrec=='y')
{
//echo "<br />write query to delete record<br />";	
$scid_change=$id.'00000';
//echo "<br />scid_change=$scid_change<br />";

$query0="update `budget_service_contracts`.`invoices`
         set del_record='y',`scid`='$scid_change'
		 where `scid`='$id'
		 and `invoice_num`='$invoice_num' ";
       	
//echo "<br />query0=$query0<br />";	

$result0 = mysqli_query($connection,$query0) or die ("Couldn't execute query 0.  $query0");


$query0a="update `budget_service_contracts`.`invoices_paylines`
         set del_record='y',`scid`='$scid_change'
		 where `scid`='$id'
		 and `invoice_num`='$invoice_num' ";
       	
//echo "<br />query0a=$query0a<br />";

$result0a = mysqli_query($connection,$query0a) or die ("Couldn't execute query 0a.  $query0a");




$query0b="update `budget_service_contracts`.`pay_lines`
         set del_record='y',`scid`='$scid_change'
		 where `scid`='$id'
		 and `invoice_num`='$invoice_num' ";
       	
//echo "<br />query0b=$query0b<br />";

$result0b = mysqli_query($connection,$query0b) or die ("Couldn't execute query 0b.  $query0b");


	
}
echo "<br />";
$menu_sc='invoice_search';
include("service_contracts_menu.php");
$query1="SELECT highlight_color from infotrack_customformat
         where user_id='$tempid' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection,$query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);



echo "<br />";
$menu_sc='SC5';


include ("approver_credentials_1a_new.php");


echo "</tr></table>";


echo "<br />";

echo "<br />";


//if($scid == '')
//{
//echo "SELECT t2.`park`, t2.`vendor`, t2.`po_num`, t2.`center`, t2.`id` as 'scid' from `budget_service_contracts`.`contracts` as t2 WHERE 1 order by t2.`park` asc";
/*
echo "SELECT
`budget_service_contracts`.`invoices`.`park`,
`budget_service_contracts`.`contracts`.`vendor`,
`budget_service_contracts`.`contracts`.`po_num`,
`budget_service_contracts`.`invoices`.`center`,
`budget_service_contracts`.`invoices`.`id`,
`budget_service_contracts`.`invoices`.`center`,
`budget_service_contracts`.`invoices`.`invoice_num`,
`budget_service_contracts`.`invoices`.`center`,
`budget_service_contracts`.`invoices`.`invoice_amount`

from `budget_service_contracts`.`invoices` 
left join `budget_service_contracts`.`contracts`
       on `budget_service_contracts`.`invoices`.`scid`=`budget_service_contracts`.`contracts`.`id`
WHERE 1";
*/

if($parkS!=''){$where2=" and `budget_service_contracts`.`invoices`.`park`='$parkS' and `budget_service_contracts`.`invoices`.`scid`='$id' ";}

$query11=
"SELECT
`budget_service_contracts`.`invoices`.`park` as 'contract_park',
`budget_service_contracts`.`contracts`.`vendor` as 'contract_vendor',
`budget_service_contracts`.`contracts`.`po_num` as 'contract_ponum',
`budget_service_contracts`.`invoices`.`center` as 'contract_center',
`budget_service_contracts`.`invoices`.`invoice_num`,
`budget_service_contracts`.`invoices`.`invoice_amount` as 'current_amount',
`budget_service_contracts`.`invoices`.`invoice_date`,
`budget_service_contracts`.`invoices`.`last_invoice`,
`budget_service_contracts`.`invoices`.`service_period`,

`budget_service_contracts`.`invoices`.`contract_administrator_approved`,
`budget_service_contracts`.`invoices`.`contract_administrator`,
`budget_service_contracts`.`invoices`.`contract_administrator_date`,

`budget_service_contracts`.`invoices`.`cashier_approved`,
`budget_service_contracts`.`invoices`.`cashier`,
`budget_service_contracts`.`invoices`.`cashier_date`,





`budget_service_contracts`.`invoices`.`manager_approved`,
`budget_service_contracts`.`invoices`.`manager`,
`budget_service_contracts`.`invoices`.`manager_date`,

`budget_service_contracts`.`invoices`.`service_period`,
`budget_service_contracts`.`invoices`.`id`,
`budget_service_contracts`.`contracts`.`id` as 'scid' 

from `budget_service_contracts`.`invoices` 
left join `budget_service_contracts`.`contracts`
       on `budget_service_contracts`.`invoices`.`scid`=`budget_service_contracts`.`contracts`.`id`
WHERE 1 $where2 order by `budget_service_contracts`.`invoices`.`id` desc";



 
	
		 
		 
//}

//

//echo "query11=$query11<br />";

$result11 = mysqli_query($connection,$query11) or die ("Couldn't execute query 11.  $query11 ");
$num11=mysqli_num_rows($result11);		
//echo "query11=$query11<br />";


echo "<br />";
echo "<table align='center'>";

echo 

"<tr>"; 
       echo "<th align=left><font color=brown>Park</font></th>";
       echo "<th align=left><font color=brown>Contract</font></th>";
      

       echo "<th align=left><font color=brown>Invoice</font></th>";
	
	   echo "<th align=left><font color=brown>Administrator</font></th>";
	   echo "<th align=left><font color=brown>Cashier</font></th>
	   <th align=left><font color=brown>Manager</font></th>";
	  	   
	   echo "<th align=left><font color=brown>DNCR Form</font></th>";
	              
echo "</tr>";

while ($row11=mysqli_fetch_array($result11)){


extract($row11);
$cashier3=substr($cashier,0,-2);
$manager3=substr($manager,0,-2);
$contract_administrator3=substr($contract_administrator,0,-2);
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


if($contract_administrator_date=='0000-00-00')
{$contract_administrator_date_dow='';}
else
{$contract_administrator_date_dow=date('l',strtotime($contract_administrator_date));}




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
$contract_administrator_date2=date('m-d-y', strtotime($contract_administrator_date));
$puof_date2=date('m-d-y', strtotime($puof_date));
$buof_date2=date('m-d-y', strtotime($buof_date));
$invoice_date2=date('m-d-y', strtotime($invoice_date));
if($invoice_old_method=='y'){$invoice_date2='unknown';}

if($record_complete == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}
echo 

"<tr$t>";
		   echo "<td bgcolor='lightgreen'>$contract_park<br />$contract_center</td>";  
		   echo "<td bgcolor='lightgreen'>$contract_vendor<br />PO#: <font color='brown'>$contract_ponum </font> </td>";  
		    echo "<td bgcolor='lightgreen'><font color='brown'>Invoice#: $invoice_num<br />Invoice date: $invoice_date2<br /><font color='black'>Amount: $current_amount</font><br /><font color='brown'>Period: $service_period</font></td>";
			
			
			
		if($contract_administrator_approved=='y')
		   {
		  
		   
		   echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		   
		 
		   echo "<br />$contract_administrator3<br />$contract_administrator_date2<br />$contract_administrator_date_dow</td>";	
	       }	
			
			
			
			
			
			
			
			
			
/*			
		   if($cashier_approved=='n' and $cashier_count==1)
			{
		   echo "<td bgcolor='lightpink'><a href='dncr_form.php?scid=$scid&id=$id' >Update</a></td>";
		   }  
		   //if 1)TABLE fuel_tank_usage.cashier is blank and 2)tempid is not a Cashier in cash_handling_roles.role
		   if($cashier_approved=='n' and $cashier_count != 1)
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }
		   
*/		   
		   
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
		 

          


		
echo "<td bgcolor='lightgreen'><a href='dncr_final.php?id=$id'>View</a><br />contract_id=$scid<br />invoice_num=$invoice_num<br />invoice_id=$id";
//if($last_invoice=='y' and $beacnum=='60032781')
if($beacnum=='60032781')
{
echo "<form action='po_invoice_update.php' method='post'>";
echo "<input type='hidden' name='scid' value='$scid'>";
echo "<input type='hidden' name='invoice_num' value='$invoice_num'>";
echo "<input type='hidden' name='eid' value='$id'>";
echo "<input type='hidden' name='reset' value='y'>";
echo "<input type='submit' name='submit' value='EDIT'>";
echo "</form>";
if($manager3=='')
{
echo "<table align='right'><tr><td><a href=service_contracts1_invoice_search.php?menu_sc=invoice_search&parkS=$parkS&delrec=y&invoice_num=$invoice_num&id=$scid><img height='15' width='15' src='/budget/infotrack/icon_photos/mission_icon_photos_263.png' alt='red trash can' title='delete'></img></a></td></tr></table>";
}
}

echo "</td>";
       
	
	
           
echo "</tr>";

}

 echo "</table>";

echo "</body></html>";

?>