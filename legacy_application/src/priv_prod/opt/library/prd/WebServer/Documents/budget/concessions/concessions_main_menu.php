<?php
//echo "<td><a href='$chp_link'><font class='cartRow'>Cash<br />Handling <br />Plan</font></a><br /></td>";
if($menu=='receipts'){$shade_receipts="class='cartRow'";}
if($menu=='documents'){$shade_documents="class='cartRow'";}
if($menu=='pci'){$shade_pci="class='cartRow'";}

echo "<table align='center' border='1'>";

	
echo "<tr>";
//echo "<th><img height='75' width='125' src='bundle.gif' alt='picture of cash'></img><br />Concession Contracts</th>";
echo "<th><img height='50' width='125' src='bundle.gif' alt='picture of cash'></img><br />Concession<br /> Contracts</th>";
//echo "<th><a href='pcard_request1.php?step=1&edit=y&report_type=form'>Request Form<br />$report_form</a></th>";
//echo "<th><a href='pcard_request1.php?step=1&edit=y&report_type=reports'>Request Status<br/>$report_reports</a></th>";
echo "<th><a href='vendor_fees_menu.php?menu=receipts' target='_blank'><font $shade_receipts>Receipts</font></a></th>";
if($beacnum=='60033162')
{
echo "<th><a href='documents_personal_search.php?menu=documents' target='_blank' ><font $shade_documents>Documents<br/></font></a></th>";
}

if($beacnum!='60033162')
{
echo "<th><a href='documents_personal_search.php?menu=documents&category3=$concession_location' target='_blank' ><font $shade_documents>Documents<br/></font></a></th>";
}



echo "<th><a href='concessions1.php?menu=pci'><font $shade_pci>CRS PCI<br/>Compliance</font></a></th>";

/*
if($beacnum=='60032997' or $beacon_num=='60032997')
{
echo "<th><a href='/budget/aDiv/pcard_weekly_reports.php' target='_blank' >Weekly<br />Reports<br/></font></a></th>";	
echo "<th><a href='/budget/admin/pcard_updates/stepL3e.php?project_category=fms&project_name=pcard_updates&step_group=L&step_num=3e' target='_blank' >Weekly<br />Download<br/></font></a></th>";		
}	
*/


echo "</tr>";	
	
	
	
echo "</table>";

?>