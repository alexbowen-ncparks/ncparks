<?php
//echo "concession_location=$concession_location<br />";
//echo "active_file=$active_file<br />";


//7/30/22-TB-START  Specify the MoneyCounts module associated with the File  (see New TABLE=mc_modules)
$mc_module='7';
//7/30/22-TB-END



if($active_file=='/budget/admin/crj_updates/bank_deposits_menu_division_final.php'){$shade_compliance_crj="class='cartRow'";}
if($active_file=='/budget/admin/crj_updates/bank_deposits.php'){$shade_bank_deposits="class='cartRow'";}
if($active_file=='/budget/admin/crj_updates/park_posted_deposits_monthly_v2.php'){$shade_ncas="class='cartRow'";}
if($active_file=='/budget/admin/crj_updates/crs_tdrr_undeposited.php'){$shade_undeposited_funds="class='cartRow'";}


echo "<table align='center'>";
echo "<tr>";


echo "<td><img height='75' width='125' src='/budget/infotrack/icon_photos/bank1.jpg' alt='picture of bank' title='Bank Deposits'></img><br /><font color='brown'>Cash<br />Handling</td>";
echo "<td><a href='/budget/admin/crj_updates/cash_plans.php' target='_blank'>Cash<br />Handling<br />Plans</a><br /></td>";
echo "<td><a href='/budget/admin/crj_updates/bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y'><font $shade_compliance_crj>Cash<br />Receipt<br />Journals</a><br /></td>";
echo "<td><a href='/budget/admin/crj_updates/crs_tdrr_undeposited.php'><font $shade_undeposited_funds>Cash<br />Undeposited<br />Funds</a><br /></td>";

/*
echo "<td><a href='/budget/admin/crj_updates/bank_deposits.php?add_your_own=y'><font $shade_bank_deposits>Cash<br />Receipt<br />Journals<br />Other</font></a><br /></td>";

if($active_file='/budget/admin/crj_updates/park_posted_deposits_monthly_v2.php' or $active_file='/budget/admin/crj_updates/park_posted_deposits_drilldown1_v2.php')
{
echo "<td><a href='/budget/admin/crj_updates/park_posted_deposits_monthly_v2.php'><font $shade_ncas>Cash<br />Receipts<br />NCAS</font></a><br /></td>";
}
*/
echo "<td><a href='/budget/cash_sales/page2_form.php?edit=y&menu_check=search'>Check<br />Search</font></a><br /></td>";
echo "<td><a href='/budget/admin/daily_updates/step_group.php?project_category=fms&project_name=daily_updates&step_group=c' target='_blank'>CRS<br />Daily<br />Upload</font></a><br /></td>";
echo "<td><a href='/budget/admin/crj_updates/crs_revenue_mapping.xlsx' target='_blank'>CRS<br />Revenue<br />Mapping</font></a><br /></td>";
echo "<td><a href='/budget/admin/crj_updates/sales_tax_update.php' target='_blank'>Sales Tax<br />Rates</font></a><br /></td>";
echo "<td><a href='/budget/infotrack/org_group_docs.php?module_id=$mc_module' target='_blank'>Help<br />Documents</font></a><br /></td>";



echo "</tr>";
echo "</table>";
 
/*
if($level < '3')
{
echo "<td><font size='5' color='brown'>$concession_location</font></td>";
}
else
{
echo "<td><font size='5' color='brown'>$posTitle</font></td>";
}
*/



echo "</tr>";

echo "</table>";







?>







