<?php
//echo "<td><a href='$chp_link'><font class='cartRow'>Cash<br />Handling <br />Plan</font></a><br /></td>";
if($menu=='receipts'){$shade_receipts="class='cartRow'";}
if($menu=='documents'){$shade_documents="class='cartRow'";}
if($menu=='pci'){$shade_pci="class='cartRow'";}



$query1c="SELECT crs as 'crs_valid',third_party_vendors as 'third_party_valid' FROM `center_taxes` WHERE parkcode='$concession_location'  ";	 

//echo "query1b=$query1b<br /><br />";		  
		  
$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");
		  
$row1c=mysqli_fetch_array($result1c);

extract($row1c);
/*
if($beacnum=='60032988')
{
echo "query1c=$query1c<br /><br />";		 	
echo "<br />crs_valid=$crs_valid<br />";
echo "<br />third_party_valid=$third_party_valid<br />";
}
*/


echo "<table align='center' border='1'>";

	
echo "<tr>";
//echo "<th><img height='75' width='125' src='bundle.gif' alt='picture of cash'></img><br />Concession Contracts</th>";
echo "<th><img height='50' width='125' src='bundle.gif' alt='picture of cash'></img><br />Concession<br /> Contracts</th>";
//echo "<th><a href='pcard_request1.php?step=1&edit=y&report_type=form'>Request Form<br />$report_form</a></th>";
//echo "<th><a href='pcard_request1.php?step=1&edit=y&report_type=reports'>Request Status<br/>$report_reports</a></th>";

if($beacnum=='60033162') //tara gallagher
{
echo "<th><a href='vendor_fees_menu.php?menu=receipts' target='_blank'><font $shade_receipts>Receipts</font></a></th>";
}

if($beacnum!='60033162' and $third_party_valid=='y') 
{
echo "<th><a href='vendor_fees_menu.php?menu=receipts' target='_blank'><font $shade_receipts>Receipts</font></a></th>";
}



if($beacnum=='60033162') //tara gallagher
{
echo "<th><a href='documents_personal_search.php?menu=documents' target='_blank' ><font $shade_documents>Documents<br/></font></a></th>";
}

if($beacnum!='60033162' and $third_party_valid=='y')
{
echo "<th><a href='documents_personal_search.php?menu=documents&category3=$concession_location' target='_blank' ><font $shade_documents>Documents<br/></font></a></th>";
}


if($beacnum=='60033162')  //tara gallagher
{
echo "<th><a href='concessions_pci_admin.php?menu=pci'><font $shade_pci>CRS PCI<br/>Compliance</font></a></th>";
}



if($beacnum!='60033162' and $crs_valid=='y')
{
echo "<th><a href='concessions_pci_report.php?menu=pci'><font $shade_pci>CRS PCI<br/>Compliance</font></a></th>";
}

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