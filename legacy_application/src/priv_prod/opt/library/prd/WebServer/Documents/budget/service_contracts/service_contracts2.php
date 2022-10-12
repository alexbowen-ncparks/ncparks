<?php
//if($level=="5" and $tempid !="Dodd3454"){echo "<pre>";print_r($_REQUEST);echo "</pre>";}//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
$level=$_SESSION['budget']['level'];
$tempID=$_SESSION['budget']['tempID'];
$posTitle=$_SESSION['budget']['position'];
$beacon_num=$_SESSION['budget']['beacon_num'];
$beacnum=$_SESSION['budget']['beacon_num'];
$pcode=$_SESSION['budget']['select'];
$centerSess=$_SESSION['budget']['centerSess'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

extract($_REQUEST);

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection,$database); // database
include("../../../include/activity_new.php");// database connection parameters
include("../../budget/~f_year.php");

echo "<html>";
include("head1.php");
include ("../../budget/menu1415_v1_new.php");
echo "<br />";
$menu_sc='search_results';
include("service_contracts_menu.php");
//include("service_contracts_menu4.php");
echo "<br />";
//if($active==''){$active='y';}
echo "active=$active";
if($active==''){$active='y';}
if($park != ''){$where1=" and park='$park' ";}
$query5="SELECT * FROM `budget_service_contracts`.`contracts` WHERE 1 $where1 and active='$active' order by park,vendor";


echo "Line 112: query5=$query5"; 


$result5 = mysqli_query($connection,$query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);

if($num5==0){echo "<br /><table><tr><td><font class=cartRow>No records </font></td></tr></table>";}
if($num5==1){echo "<br /><table><tr><td><font class=cartRow>$num5 record </font></td></tr></table>";}
if($num5>1){echo "<br /><table><tr><td><font class=cartRow>$num5 records </font></td></tr></table>";}

if($num5>0)
{
echo "<table border=1>";
echo "<tr>";
echo "<th align=center><font color=brown>ID</font></th>";
echo "<th align=center><font color=brown>Active</font></th>";
echo "<th align=center><font color=brown>Record Complete</font></th>";
echo "<th align=center><font color=brown>Park</font></th>";
echo "<th align=center><font color=brown>Contract Admin<br />UserID</font></th>";
echo "<th align=center><font color=brown>Contract Type</font></th>";
echo "<th align=center><font color=brown>Service Type</font></th>";
echo "<th align=center><font color=brown>Contractor Name</font></th>";
echo "<th align=center><font color=brown>Contract Num</font></th>";
echo "<th align=center><font color=brown>PO Num</font></th>";	   
echo "<th align=center><font color=brown>PO Original Total</font></th>";	   
echo "<th align=center><font color=brown>Buy Entity</font></th>";	   
echo "<th align=center><font color=brown>NCAS<br />Center</font></th>";	   
echo "<th align=center><font color=brown>NCAS<br />Account</font></th>";	   
echo "<th align=center><font color=brown>NCAS<br />Company</font></th>";	   
echo "<th align=center><font color=brown>Remit Address</font></th>";	   
echo "<th align=center><font color=brown>FID#</font></th>";	   
echo "<th align=center><font color=brown>Group#</font></th>";	   
echo "<th align=center><font color=brown>Monthly Cost</font></th>"; 
echo "<th align=center><font color=brown>Yearly Cost</font></th>";
echo "<th align=center><font color=brown>Invoices</font></th>";
echo "<th align=center><font color=brown>Original Contract<br />Start Date</font></th>";
echo "<th align=center><font color=brown>Original Contract<br />End Date</font></th>";
echo "<th align=center><font color=brown>Comments</font></th>";
echo "<th align=center><font color=brown>Original Contract</font></th>";
echo "<th align=center><font color=brown>Renewal Letter</font></th>";              
echo "</tr>";

while ($row=mysqli_fetch_array($result5)){

extract($row);

if($document_location != ""){$document="yes";} else {$document="";}
if($document_renewal != ""){$doc_renewal="yes";} else {$doc_renewal="";}

$deposit_amount=number_format($deposit_amount,2);
$fee_amount=number_format($fee_amount,2);
$other_amount=number_format($other_amount,2);
$system_entry_date=date('m-d-y', strtotime($system_entry_date));

/*
if($ncas_post_date != '0000-00-00')
{$ncas_post_date=date('m-d-y', strtotime($ncas_post_date));}
else
{$ncas_post_date="";}
*/

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}


/*
if($edit_id != '' and $id==$edit_id)
{$image_verify=" <img src='/budget/infotrack/icon_photos/green_checkmark1.png' height='40' width='40'>";}
else {$image_verify="";}
$pending_approval_icon = '';
if($level==1 and $pending_park_approval=='y'){$pending_approval_icon=" <img src='/budget/infotrack/icon_photos/info1.png' height='40' width='40'>";}
if($level!=1 and $pending_budget_approval=='y'){$pending_approval_icon=" <img src='/budget/infotrack/icon_photos/info1.png' height='40' width='40'>";}
*/

if($record_complete=='y'){$bgc="lightgreen";} //else {$bgc="lightpink";}
if($record_complete=='n'){$bgc="lightpink";}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo"<tr bgcolor='$bgc'>";

if($active=='y')
{
echo "<td>";

       echo "<table>";echo "<tr>";echo "<td>";	     
	   echo "<form action=service_contracts1_update.php>";
	   echo "<input type='hidden' name='id' value='$id'>";
	   echo "<input type='submit' name='submit' value='Edit'>";
	   echo "</form>";	 
	   //echo "$id";
       echo "</td></tr></table>";
	   
	   echo "<table>";echo "<tr>";echo "<td>";	     
	   echo "<form action=po_invoice_add.php>";
	   echo "<input type='hidden' name='id' value='$id'>";
	   echo "<input type='submit' name='submit' value='Pay_Invoice'>";
	   echo "</form>";	 
	   //echo "$id";
       echo "</td></tr></table>";
	   
	   echo "<table>";echo "<tr>";echo "<td>";	     
	   echo "<form action=po_lines.php>";
	   echo "<input type='hidden' name='scid' value='$id'>";
	   echo "<input type='submit' name='submit' value='PO_Lines'>";
	   echo "</form>";	 
	   //echo "$id";
       echo "</td></tr></table>";	   
	   
echo "</td>";
}


if($active=='n')
{
echo "<td>";

       echo "<table>";echo "<tr>";echo "<td>";	     
	   echo "<form action=service_contracts1_update.php>";
	   echo "<input type='hidden' name='id' value='$id'>";
	   echo "<input type='submit' name='submit' value='Edit'>";
	   echo "</form>";	 
	   //echo "$id";
       echo "</td></tr></table>";
	   
	   
echo "</td>";
}


echo "<td align='center'>$active</td>";
echo "<td align='center'>$record_complete</td>";
echo "<td>$park</td>";
echo "<td>$contract_admin_tempid</td>";
echo "<td>$contract_type</td>";
echo "<td>$service_type</td>";
echo "<td><font color='brown'>$vendor</font></td>";
echo "<td>$contract_num</td>";
echo "<td>$po_num</td>";      
echo "<td>$po_original_total</td>";      
echo "<td>$buy_entity</td>";      
echo "<td>$center</td>";      
echo "<td>$ncas_account</td>";      
echo "<td>$company</td>";      
echo "<td>$remit_address</td>";      
echo "<td>$fid_num</td>";      
echo "<td>$group_num</td>";      
echo "<td>$monthly_cost</td>";
echo "<td>$yearly_cost</td>";
echo "<td><a href='service_contracts1_invoice_search.php?menu_sc=invoice_search&parkS=$park&id=$id' target='_blank'>View</a></td>";
echo "<td>$original_contract_start_date</td>";
echo "<td>$original_contract_end_date</td>";
echo "<td>$comments</td>";

	   
if($document=="yes" and $record_complete!="y"){echo "<td><a href='$document_location' target='_blank'>View</a><br /><br /><a href='service_contract_document_add.php?source_id=$id'>Reload</a></td>";}

if($doc_renewal=="yes" and $record_complete!="y"){echo "<td><a href='$document_renewal' target='_blank'>View</a><br /><br /><a href='sc_doc_renewal_add.php?source_id=$id'>Reload</a></td>";}

if($document=="yes" and $record_complete=="y"){echo "<td><a href='$document_location' target='_blank'>View</a><br /><br /><a href='service_contract_document_add.php?source_id=$id'>Reload</a></td>";}

if($doc_renewal=="yes" and $record_complete=="y"){echo "<td><a href='$document_renewal' target='_blank'>View</a><br /><br /><a href='sc_doc_renewal_add.php?source_id=$id'>Reload</a></td>";}

if($document!="yes"){echo "<td><a href='service_contract_document_add.php?source_id=$id'>Upload</a></td>";} 

if($doc_renewal!="yes"){echo "<td><a href='sc_doc_renewal_add.php?source_id=$id'>Upload</a></td>";} 

echo"<td><a href='delete_record_service_contracts_verify.php?&id=$id'>delete</a></td>";              
           
echo "</tr>";



}
echo "</table>";


}

echo "</html>";
?>