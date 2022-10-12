<?php
//echo "<td><a href='$chp_link'><font class='cartRow'>Cash<br />Handling <br />Plan</font></a><br /></td>";
if($menu=='RCard'){$shade_RCard="class='cartRow'";}
if($menu_new=='RPurc'){$shade_RPurc="class='cartRow'";}
if($menu=='VCard'){$shade_VCard="class='cartRow'";}
if($menu=='VDocu'){$shade_VDocu="class='cartRow'";}
if($menu_new=='LTran'){$shade_LTran="class='cartRow'";}
if($menu_new=='MAppr'){$shade_MAppr="class='cartRow'";}
if($menu_new=='weekly_reports'){$shade_weekly_reports="class='cartRow'";}
echo "<table align='center' cellspacing='10' >";

	
echo "<tr>";
echo "<th><img height='75' width='125' src='/budget/acs/credit_card2.jpg' alt='picture of credit card'></img><br />Procurement Card</th>";
//echo "<th><a href='pcard_request1.php?step=1&edit=y&report_type=form'>Request Form<br />$report_form</a></th>";
//echo "<th><a href='pcard_request1.php?step=1&edit=y&report_type=reports'>Request Status<br/>$report_reports</a></th>";

/* 2022-08-16: cooper Main PCard Menu items */
echo "<th><a href='/budget/acs/pcard_request4.php?menu=RCard'><font $shade_RCard>Card<br />Request<br/></font></a></th>";
echo "<th><a href='/budget/acs/editPcardHolders.php?m=pcard&menu=VCard' ><font $shade_VCard>View<br />Cardholders<br/></font></a></th>";
echo "<th><a href='/budget/acs/cardholder_documents.php?submit=search&menu=VDocu'><font $shade_VDocu>View<br />Documents<br/></font></a></th>";
echo "<th><a href='/budget/acs/pcard_trans_lookup.php?m=pcard&menu_new=LTran'><font $shade_LTran>Lookup<br />Transactions<br/></font></a></th>";
echo "<th><a href='/budget/acs/pcard_recon_menu.php?m=pcard&menu_new=RPurc' ><font $shade_RPurc>Reconcile<br />Purchases<br/></font></a></th>";
//if($beacnum=='60033087' or $beacnum=='60032994')
//if($beacnum != '60032997' and $beacnum != '60032781')	//rachel gooding,tammy dodd

/* 2022-02-23: CCOOPER - add Carmen Williamson to logic statements, so she will see the Recon menu like Gooding and Boggus. Also, changing Owen to Boggus (60033242 is Boggus)

if($beacnum != '60032997' and $beacnum != '60033242')	//rachel gooding becky owen
  2022-03-14: CCOOPER - add Rumble (60036015) and Rouhani (65032850) from BUOFF
*/
if($beacnum!='60032997' and 
   $beacnum!='60033242' and 
   $beacnum!='65032827' and
   $beacnum!='60036015' and
   $beacnum!='65032850')
/*  2022-02-23: End CCOOPER
    2022-03-14: End CCOOPER */
{
   echo "<th><a href='/budget/acs/pcard_recon_yearly.php?m=pcard&menu_new=MAppr' ><font $shade_MAppr>Weekly<br />Approvals<br/></font></a></th>";
}

/* if($beacnum=='60032997' or $beacnum=='60032781' or $beacnum=='60033242') //rachel gooding,tammy dodd,becky owen  

2022-03-14: CCOOPER - document change: Boggus is (60033242), not owen
            addition of Rumble (60036015), Williams (65032827), and Rouhani (65032850) from BUOFF
*/ 

if($beacnum=='60032997' or 
   $beacnum=='60032781' or 
   $beacnum=='60033242' or 
   $beacnum=='60036015' or
   $beacnum=='65032827' or
   $beacnum=='65032850')
/* 2022-02-23: END CCOOPER */
{
  echo "<th><a href='/budget/aDiv/pcard_weekly_reports.php' target='_blank' ><font $shade_weekly_reports>Weekly<br />Reports<br/></font></a></th>";	
/*
echo "<th><a href='/budget/admin/pcard_updates/stepL3e.php?project_category=fms&project_name=pcard_updates&step_group=L&step_num=3e' target='_blank' >Weekly<br />Download<br/></font></a></th>";
*/
/* 2022-08-16: cooper - admin menu options Missing Lookup & Admin Setup */
  echo "<th><a href='/budget/admin/pcard_updates/pcard_lookup.php' target='_blank' >Missing<br />Lookup<br/></font></a></th>";			
  echo "<th><a href=''>Administrator<br />SetUp<br/></font></a></th>";			
}	

echo "</tr>";	
	
echo "</table>";
//if($beacnum=='60032833'){$park='DEDE';} //erin lawrence
//echo "park=$park";

?>