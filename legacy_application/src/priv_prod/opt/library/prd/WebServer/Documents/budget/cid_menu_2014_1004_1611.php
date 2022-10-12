<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}
include("menu1314.php");
//include("menu3.css"); 
echo "
<div class='column1of4'>
   <ul>
      <table><tr><td>
      <li><img height='50' width='50' src='/budget/infotrack/icon_photos/cid_menu1.png' alt='cid menu icon' title='CID Menu'></img><font color='brown' size='4'><b>(UNDER Construction 8/22/14)</b></font>
         <ul>
		    <li><a href='/budget/coa.php'>Chart of Accounts</a></li>
			<li><a href='/budget/concessions/vendor_fees_menu.php' >Concession Contracts</a></li>
			<li><a href='/budget/acs/fixed_assets_doc_lookup.php' >Equipment Invoices Lookup</a></li>
		    <li><a href='/budget/acs/acsFind.php?m=invoices'>Invoices-Find</a></li>            
            <li><a href='/budget/acs/acs.php?m=invoices'>Invoices-Pay</a></li>
            <li><a href='/budget/acs/acsReports.php?m=invoices'>Invoices-Reports</a></li>
			<li><a href='/budget/acs/editVendor.php?m=invoices'>Invoices-Vendor Update</a></li>
            <li><a href='/budget/a/current_year_budget.php?budget_group_menu=operating_expenses&submit=x'>Park Budgets</a></li>			
            <li><a href='/budget/b/park_project_balances.php?m=1'>Park Projects</a></li>
			<li><a href='/budget/acs/pcard_recon_menu.php?m=pcard' >PCARD</a></li>
			<li><a href='/budget/aDiv/park_purchase_request_menu.php?submit=Submit' >Pre-approval for Purchases</a></li>
            <li><a href='/budget/c/XTND_po_encumbrances.php?center=12802862&submit=Find' >Purchase Orders</a></li>
            <li><a href='/budget/exp_rev_query.php?m=trans_post'>Transactions Posted</a></li>
            <li><a href='/budget/c/transactions_unposted.php?m=trans_unpost' >Transactions UnPosted</a></li>            
            <li><a href='/budget/portal.php?dbTable=xtnd_vendor_payments' >Vendor Payments</a></li>
            <li><a href='/budget/concessions/reports_all_centers_summary_by_division.php?report=cent&accounts=all&section=operations&history=3yr&period=fyear' >MoneyTracker Matrix</a></li>
            <li><a href='/budget/service_contracts/service_contracts.php' >Service Contracts</a></li>
			</td></tr></table>
            
         </ul>
      </li>
        
	  
	  
	  
  </ul>
</div>";


?>