<?php
//echo "<td><a href='$chp_link'><font class='cartRow'>Cash<br />Handling <br />Plan</font></a><br /></td>";
if($menu=='RCard'){$shade_RCard="class='cartRow'";}
if($menu_new=='RPurc'){$shade_RPurc="class='cartRow'";}
if($menu=='VCard'){$shade_VCard="class='cartRow'";}
if($menu=='VDocu'){$shade_VDocu="class='cartRow'";}
if($menu_new=='LTran'){$shade_LTran="class='cartRow'";}
if($menu_new=='MAppr'){$shade_MAppr="class='cartRow'";}
if($menu_new=='weekly_reports'){$shade_weekly_reports="class='cartRow'";}
echo "<table align='center' cellspacing='5' >";



$query8a="select text_code from svg_graphics where id='14'  ";
		 
//echo "query8a=$query8a<br />";		 

$result8a = mysqli_query($connection, $query8a) or die ("Couldn't execute query 8a.  $query8a");

$row8a=mysqli_fetch_array($result8a);
extract($row8a);	





	
echo "<tr>";

echo "<th>$text_code</th>";
echo "</tr>";
echo "<tr>";
/*
echo "<th><a href='/budget/acs/pcard_request4.php?menu=RCard'><font $shade_RCard>Card<br />Request<br/></font></a></th>";
echo "<th><a href='/budget/acs/editPcardHolders.php?m=pcard&menu=VCard' ><font $shade_VCard>View<br />Cardholders<br/></font></a></th>";
echo "<th><a href='/budget/acs/cardholder_documents.php?submit=search&menu=VDocu'><font $shade_VDocu>View<br />Documents<br/></font></a></th>";
echo "<th><a href='/budget/acs/pcard_trans_lookup.php?m=pcard&menu_new=LTran'><font $shade_LTran>Lookup<br />Transactions<br/></font></a></th>";
echo "<th><a href='/budget/acs/pcard_recon_menu.php?m=pcard&menu_new=RPurc' ><font $shade_RPurc>Reconcile<br />Purchases<br/></font></a></th>";
*/

//echo "<th><a href='/budget/aDiv/preapproval_yearly.php?m=pcard&menu_new=MAppr' ><font $shade_MAppr>Weekly<br />Approvals<br/></font></a></th>";
//echo "<th><a href='/budget/aDiv/preapproval_yearly.php?menu_new=MAppr' ><font $shade_MAppr>Weekly<br />Approvals<br/></font></a></th>";






echo "</tr>";	
	
	
	
echo "</table>";
//if($beacnum=='60032833'){$park='DEDE';} //erin lawrence
//echo "park=$park";

?>