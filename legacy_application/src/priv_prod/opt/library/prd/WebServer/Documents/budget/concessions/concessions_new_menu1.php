<?php
//echo "<td><a href='$chp_link'><font class='cartRow'>Cash<br />Handling <br />Plan</font></a><br /></td>";
if($menu=='RCard'){$shade_RCard="class='cartRow'";}
if($menu_new=='RPurc'){$shade_RPurc="class='cartRow'";}
if($menu=='VCard'){$shade_VCard="class='cartRow'";}
if($menu=='VDocu'){$shade_VDocu="class='cartRow'";}
if($menu_new=='LTran'){$shade_LTran="class='cartRow'";}
echo "<table align='center' border='1'>";

	
echo "<tr>";
echo "<th><img height='75' width='125' src='bundle.gif' alt='picture of cash'></img><br />Concessionaire Fees</th>";
//echo "<th><a href='pcard_request1.php?step=1&edit=y&report_type=form'>Request Form<br />$report_form</a></th>";
//echo "<th><a href='pcard_request1.php?step=1&edit=y&report_type=reports'>Request Status<br/>$report_reports</a></th>";
echo "<th><a href='pcard_request4.php?menu=RCard'><font $shade_RCard>Card<br />Request<br/></font></a></th>";
echo "<th><a href='editPcardHolders.php?m=pcard&menu=VCard' ><font $shade_VCard>View<br />Cardholders<br/></font></a></th>";
echo "<th><a href='/budget/acs/cardholder_documents.php?submit=search&menu=VDocu'><font $shade_VDocu>View<br />Documents<br/></font></a></th>";
echo "<th><a href='/budget/acs/pcard_trans_lookup.php?m=pcard&menu_new=LTran'><font $shade_LTran>Lookup<br />Transactions<br/></font></a></th>";
echo "<th><a href='/budget/acs/pcard_recon_menu.php?m=pcard&menu_new=RPurc' target='_blank'><font $shade_RPurc>Reconcile<br />Purchases<br/></font></a></th>";

if($beacnum=='60032997' or $beacon_num=='60032997')
{
echo "<th><a href='/budget/aDiv/pcard_weekly_reports.php' target='_blank' >Weekly<br />Reports<br/></font></a></th>";	
echo "<th><a href='/budget/admin/pcard_updates/stepL3e.php?project_category=fms&project_name=pcard_updates&step_group=L&step_num=3e' target='_blank' >Weekly<br />Download<br/></font></a></th>";		
}	



echo "</tr>";	
	
	
	
echo "</table>";

?>