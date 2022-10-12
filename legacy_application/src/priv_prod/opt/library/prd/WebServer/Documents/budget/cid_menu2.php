<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}
include("menu1314.php");
echo "<br />";
echo "<table align='center'>";
echo "<tr>";
echo "<td>";
echo "<table>";
echo "<tr>";
echo "<td>";
echo "<li><img height='50' width='50' src='/budget/infotrack/icon_photos/cid_menu1.png' alt='cid menu icon' title='CID Menu'></img><font color='brown' size='4'><b></b></font>
         <ul>
		    <li><a href='/budget/coa.php'>Chart of Accounts</a></li>
			<li><a href='/budget/concessions/vendor_fees_menu.php' >Concession Contracts</a></li>
			<li><a href='/budget/acs/fixed_assets_doc_lookup.php' >Equipment Invoices Lookup</a></li>
			<li><a href='/budget/aDiv/park_equip_request.php?m=1&submit=Submit' >Equipment Requests</a></li>			
		    <li><a href='/budget/acs/acsFind.php?m=invoices'>Invoices-Find</a></li>            
            <li><a href='/budget/acs/acs.php?m=invoices'>Invoices-Pay</a></li>";
			//echo "<li><a href='/budget/acs/acsReports.php?m=invoices'>Invoices-Reports</a></li>";
			echo "<li><a href='/budget/acs/editVendor.php?m=invoices'>Invoices-Vendor Update</a></li>
            <li><a href='/budget/b/park_project_balances.php?m=1'>Park Projects</a></li>
			<li><a href='/budget/acs/pcard_recon_menu.php?m=pcard' >PCARD</a></li>
			<li><a href='/budget/aDiv/preapproval_yearly.php?menu_new=MAppr' ><font color='red'>Pre-approval for Purchases (New)</font></a></li>
			<li><a href='/budget/infotrack/position_reports.php?menu=1&purchasing_guidelines=y'>Purchasing Guidelines</a></li>";
			//echo "<li><a href='/budget/c/XTND_po_encumbrances.php?center=12802862&submit=Find' >Purchase Orders</a></li>";
			/*
			echo "<li><a href='/budget/exp_rev_query.php?m=trans_post'>Transactions Posted</a></li>
            <li><a href='/budget/c/transactions_unposted.php?m=trans_unpost' >Transactions UnPosted</a></li>            
            <li><a href='/budget/portal.php?dbTable=xtnd_vendor_payments' >Vendor Payments</a></li>";
			*/
			echo "<li><a href='/budget/concessions/reports_all_centers_summary_by_division.php?report=cent&accounts=all&section=operations&history=3yr&period=fyear' >MoneyTracker Matrix</a></li>";
			//echo "<li><a href='/budget/service_contracts/service_contracts.php' >Service Contracts</a></li>";
			echo "</ul>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</td>";
echo "<td>";
echo "<table>";
echo "<tr>";
echo "<td>";
echo "<li>District
         <ul>
            <li><a href='/budget/aDiv/dist_equip_request.php'>Equipment Approval</a></li>	
            <li><a href='/budget/a/current_year_budget_div.php?budget_group_menu=opex-utilities&submit=Submit'>Park Budgets</a></li>			 		
            <li><a href='/budget/b/prtf_center_budget.php' >Project Budgets</a></li>";
			//echo "<li><a href='/budget/aDiv/budget_3yr_history.php' >3 Year Budget History</a></li>";
			echo "</ul>";         
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";

?>