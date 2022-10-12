<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}
include("menu1314.php");
echo "
<div class='column1of4'>
   <ul>
      <li>CID
         <ul>
		    <li><a href='/budget/menu.php?forum=blank' target='_blank'>Budget Home</a></li>
		    <li><a href='/budget/menu1314.php' target='_blank'><font color=red>New Menus (in process)</font></a></li>
		    <li><a href='/budget/forum.php?m=1' target='_blank'>Budget Forum</a></li>
			
			
            <li><a href='/budget/concessions/reports_all_centers_summary_by_division.php?report=cent&amp;accounts=all&amp;section=all&amp;history=3yr&amp;period=fyear' target='_blank'>MoneyTracker Matrix</a></li>
            <li><a href='/budget/concessions/bank_deposits_menu_cc_test.php?step=1' target='_blank'>CRJ-Credit Card</a></li>
            
            
            <li><a href='/budget/coa.php' target='_blank'>Chart of Accounts</a></li>
            <li><a href='/budget/concessions/vendor_fees_menu.php' target='_blank'>Concessionaire Receipts</a></li>           
            <li><a href='/budget/concessions/documents_personal_search.php' target='_blank'>Concessionaire Documents</a></li>
            <li><a href='http://www.dpr.ncparks.gov/databases.php' target='_blank'>DPR Databases</a></li> 
            
            <li><a href='/budget/acs/fixed_assets_doc_lookup.php' target='_blank'>Equip Invoices Lookup</a></li>
            <li><a href='/budget/acs/acsFind.php?m=invoices' target='_blank'>Invoices-Find</a></li>
            <li><a href='/budget/acs/editVendor.php?m=invoices' target='_blank'>Invoices-Vendor Update</a></li>
            <li><a href='/budget/acs/acs.php?m=invoices' target='_blank'>Invoices-Pay</a></li>
            <li><a href='/budget/acs/acsReports.php?m=invoices' target='_blank'>Invoices-Reports</a></li>
            
           
            <li><a href='/budget/acs/pcard_recon_menu.php?m=pcard' target='_blank'>PCARD-Reconcilements</a></li>
            <li><a href='/budget/acs/editPcardHolders.php?m=pcard' target='_blank'>PCARD-CardHolders</a></li>
            <li><a href='/budget/acs/pcard_trans_lookup.php?m=pcard' target='_blank'>PCARD Transactions</a></li>
            <li><a href='/budget/acs/cardholder_documents.php?submit=search' target='_blank'>PCARD-Documents</a></li>
            <li><a href='/budget/aDiv/park_purchase_request_menu.php?submit=Submit' target='_blank'>Purchase Pre-approval</a></li>
            
            
            
            <li><a href='/budget/c/XTND_po_encumbrances.php?center=$center&submit=Find' target='_blank'>Purchase Orders</a></li>
           
            <li><a href='/budget/service_contracts/service_contracts.php' target='_blank'>Service Contracts</a></li>			
            <li><a href='/budget/exp_rev_query.php?m=trans_post' target='_blank'>Transactions Posted</a></li>
            <li><a href='/budget/c/transactions_unposted.php?m=trans_unpost' target='_blank'>Transactions Unposted</a></li>
            <li><a href='/budget/portal.php?dbTable=xtnd_vendor_payments' target='_blank'>Vendor Payments</a></li>
         </ul>
      </li>
        
	  
	  
	  
  </ul>
</div>";


?>