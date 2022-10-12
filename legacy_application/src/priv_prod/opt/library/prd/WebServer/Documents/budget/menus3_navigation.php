<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$tempid1=substr($tempid,0,-2);
if($concession_location=='ADM'){$concession_location='ADMI';}
if($beacnum=='60033138'){$concession_location='ADMI';}
if($beacnum=='60032787'){$concession_location='DEDE';}
if($beacnum=='60032794'){$concession_location='NARA';}
$query1a="select count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	 

//echo "query1a=$query1a<br /><br />";		  
		  
$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);
//echo "Cashier Count=$cashier_count";
/*
if($beacnum=='60032828')
{
echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;

}
*/
if($concession_location=='ADM'){$concession_location2='ADMI';} else {$concession_location2=$concession_location;}

//if($beacnum=='60032828'){$concession_location2='REMA';}

//include("infotrack/scrolling_headline.php");
/*
echo "<table><tr><th>
<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></th><th><font color='green'>MoneyCounts ($concession_location2-$tempid1)</th>
</tr></table>";
*/
echo "
<div class='column1of4'>
   <ul>
      <li>CID
         <ul>";
		  //echo "<li><a href='/budget/menu.php?forum=blank' target='_blank'>Budget Home</a></li>";
		 //echo "<li><a href='/budget/menu1314.php' target='_blank'><font color=red>New Menus (in process)</font></a></li>";
		 echo "<li><a href='/budget/forum.php?m=1' target='_blank'>Budget Forum</a></li>
			
			
            <li><a href='/budget/concessions/reports_all_centers_summary_by_division.php?report=cent&amp;accounts=all&amp;section=all&amp;history=3yr&amp;period=fyear' target='_blank'>MoneyTracker Matrix</a></li>
            <li><a href='/budget/concessions/bank_deposits_menu_cc_test.php?step=1' target='_blank'>CRJ-Credit Card</a></li>
            
            
            <li><a href='/budget/coa.php' target='_blank'>Chart of Accounts</a></li>
            <li><a href='/budget/concessions/vendor_fees_menu.php' target='_blank'>Concessionaire Receipts</a></li>           
            <li><a href='/budget/concessions/documents_personal_search.php' target='_blank'>Concessionaire Documents</a></li>
            <li><a href='/databases.php' target='_blank'>DPR Databases</a></li> 
            <li><a href='/databases.php' target='_blank'>DPR Databases</a></li> 
            
            <li><a href='/budget/acs/fixed_assets1.php' target='_blank'>Fixed Assets</a></li>
            <li><a href='/budget/acs/acsFind.php?m=invoices' target='_blank'>Invoices-Find</a></li>
            <li><a href='/budget/acs/editVendor.php?m=invoices' target='_blank'>Invoices-Vendor Update</a></li>
            <li><a href='/budget/acs/acs.php?m=invoices' target='_blank'>Invoices-Pay</a></li>
            <li><a href='/budget/acs/acsReports.php?m=invoices' target='_blank'>Invoices-Reports</a></li>
            
           
            <li><a href='/budget/acs/pcard_recon_menu.php?m=pcard' target='_blank'>PCARD-Reconcilements</a></li>
            <li><a href='/budget/acs/editPcardHolders.php?m=pcard' target='_blank'>PCARD-CardHolders</a></li>
            <li><a href='/budget/acs/pcard_trans_lookup.php?m=pcard' target='_blank'>PCARD Transactions</a></li>
            <li><a href='/budget/acs/cardholder_documents.php?submit=search' target='_blank'>PCARD-Documents</a></li>";
			if($cashier_count==1 or $beacnum=='60032997')
      {echo "<li><a href='/budget/acs/pcard_request4.php?menu=RCard' target='_blank'>PCARD-New Card Request</a></li>";}
      echo "<li><a href='/budget/aDiv/preapproval_yearly.php?menu_new=MAppr' ><font color='red'>Pre-approval for Purchases (New)</font></a></li>
	        <li><a href='/budget/infotrack/position_reports.php?menu=1&purchasing_guidelines=y'>Purchasing Guidelines</a></li>
            <li><a href='/budget/c/XTND_po_encumbrances.php?center=$center&submit=Find' target='_blank'>Purchase Orders</a></li>           
            <li><a href='/budget/service_contracts/service_contracts.php' target='_blank'>Service Contracts</a></li>			
            <li><a href='/budget/exp_rev_query.php?m=trans_post' target='_blank'>Transactions Posted</a></li>
            <li><a href='/budget/c/transactions_unposted.php?m=trans_unpost' target='_blank'>Transactions Unposted</a></li>
            <li><a href='/budget/portal.php?dbTable=xtnd_vendor_payments' target='_blank'>Vendor Payments</a></li>
         </ul>
      </li>
        
	  
	  
	  
  </ul>
</div>";

echo "
<div class='column2of4'>
   <ul>
      <li>District
         <ul>
            <li><a href='/budget/aDiv/dist_equip_request.php?division_approved=y' target='_blank'>Approved Equipment Budget</a></li>
            <li><a href='/budget/aDiv/budget_history.php' target='_blank'>Budget History</a></li>
            <li><a href='/budget/a/current_year_budget_div.php?budget_group_menu=opex-utilities&submit=Submit' target='_blank'>Budgets by Center</a></li>
            <li><a href='/budget/b/prtf_center_budget.php' target='_blank'>Project Budgets</a></li>
            <li><a href='/budget/aDiv/dist_equip_request.php' target='_blank'>Equipment Requests</a></li>
         </ul>
      </li>
	  
      <li>Division
         <ul>
            <li><a href='/budget/admin/crj_updates/bank_deposits.php?add_your_own=y'>Bank Deposits</a></li>
            <li><a href='/budget/aDiv/denr_report.php' target='_blank'>DENR Report</a></li>
            <li><a href='/budget/aDiv/park_equip_request.php?submit=Submit' target='_blank'>Equipment Request</a></li>
            
            
            
            <li><a href='/budget/aDiv/equipment_division.php' target='_blank'>Equipment</a></li>
            <li><a href='/budget/aDiv/manual_transfer.php' target='_blank'>Manual Allocations</a></li>
            <li><a href='/budget/aDiv/pcard_weekly_reports.php' target='_blank'>pcard_weekly_reports</a></li>
            <li><a href='/budget/admin/fixed_asset_updates/report_view.php' target='_blank'>fixed_asset_weekly</a></li>            
            <li><a href='/budget/aDiv/pcard_weekly_reports_DENR.php' target='_blank'>pcard weekly-DENR BPA</a></li>
            <li><a href='/budget/b/park_project_balances.php?m=1' target='_blank'>Projects by Park</a></li>
            <li><a href='/budget/b/park_project_balances_by_center.php?m=1' target='_blank'>Projects by Center</a></li>
            
            
         </ul>
      </li>
	  
	 
	  
	  
  </ul>
</div>";

echo "
<div class='column3of4'>
   <ul>
      
      <li>Design Development
         <ul>
            <li><a href='/budget/admin.php' target='_blank'>Administrator Page</a></li>
            <li><a href='/budget/c/DPR_Contract_Balances.php' target='_blank'>DPR Contract Balances</a></li>
            <li><a href='/budget/c/contract_vital.php?dbTable=cid_contract_vitals' target='_blank'>DPR Contract Vitals</a></li>
            <li><a href='/budget/c/contract_transactions.php?dbTable=cid_contract_transactions' target='_blank'>DPR Contract Trans</a></li>
            <li><a href='/budget/partf_payments.php' target='_blank'>PARTF-Payments</a></li>
            <li><a href='/budget/partf.php?l=p' target='_blank'>PARTF-Park</a></li>
            <li><a href='/budget/editFunds.php' target='_blank'>PARTF-Funds</a></li>
			<li><a href='/budget/b/prtf_center_budget.php' target='_blank'>Project Budgets</a></li>
         </ul>
      </li>
	  
	  
	  
  </ul>
</div>";
?>