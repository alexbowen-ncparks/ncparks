<?php



//echo "concession_location=$concession_location<br />";
if($concession_location=='ADM'){$concession_location='ADMI';}
//echo "beacnum=$beacnum<br />";
if($beacnum=='60033138'){$concession_location='ADMI';} //steve livingstone
if($beacnum=='60032787'){$concession_location='DEDE';} //jennifer goss
if($beacnum=='60032794'){$concession_location='NARA';} //fuller
//echo "concession_location=$concession_location<br />";

$query1a="select count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	 
/*
if($beacnum=='60033104')
{		  
echo "query1a=$query1a<br /><br />";
}	
*/	  
	
//echo "query1a=$query1a<br /><br />";

	
$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);
/*
if($beacnum=='60033104')
{		
echo "Cashier Count=$cashier_count<br /><br />";
}
*/

$query1b="select count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempid' ";	 

//if($beacnum=='60032862')
//{
//echo "query1b=$query1b<br /><br />";	
//}	  
  
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);
//echo "Manager Count=$manager_count<br /><br />";

if($beacnum=='60032833'){$manager_count=1;} //erin lawrence
if($beacnum=='60033160'){$manager_count=1;} //brian strong
if($beacnum=='60032942'){$manager_count=1;} //scott crocker

if($cashier_count==1){$cashier_image="-Cashier";}

if($manager_count==1){$manager_image="-Manager";}



$query1c="SELECT count(id) as 'concessions_count'  FROM `center_taxes` WHERE parkcode='$concession_location' and  (`crs` LIKE 'y' or third_party_vendors='y') ";	 

//echo "query1b=$query1b<br /><br />";		  
		  
$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");
		  
$row1c=mysqli_fetch_array($result1c);

extract($row1c);



$query1d="SELECT crs as 'crs_valid',third_party_vendors as 'third_party_valid' FROM `center_taxes` WHERE parkcode='$concession_location'  ";	 

//echo "query1b=$query1b<br /><br />";		  
		  
$result1d = mysqli_query($connection, $query1d) or die ("Couldn't execute query 1d.  $query1d");
		  
$row1d=mysqli_fetch_array($result1d);

extract($row1d);




$query0="select myreports_only from cash_handling_roles where tempid='$tempid'";
$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
if($row0)
	{
extract($row0);//brings back max (end_date) as $end_date
}

if(empty($myreports_only)){$myreports_only="";}

//echo "myreports_only=$myreports_only<br />";


$query0a="select count(myreports_only) as 'regular_user' from cash_handling_roles where tempid='$tempid' and myreports_only='n' ";
//echo "<br />query0a=$query0a<br />";
$result0a = mysqli_query($connection, $query0a) or die ("Couldn't execute query 0a.  $query0a");

$row0a=mysqli_fetch_array($result0a);
extract($row0a);

//echo "<br />regular_user=$regular_user<br />";


if($regular_user > 0){$myreports_only='n';}




if($myreports_only=='y')
{

$tempid2=substr($tempid,0,-2);
if($concession_location=='ADM'){$concession_location2='ADMI';} else {$concession_location2=$concession_location;}


echo "<table align='center'><tr><th>
<a href='/budget/infotrack/position_reports.php?menu=1'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/reports1.png' alt='reports icon' title='MyReports'></img><br /><font color='brown'>My<br />Reports</font>
</a></th>";

echo "<th>
<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br /><font color='green'>$concession_location2<br /> $tempid2</font>
</th>";
echo "</tr></table>";
}
else
{
$query1="select orms from center_taxes where parkcode='$concession_location'";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
if($row1)
	{
extract($row1);//brings back max (end_date) as $end_date
}

if($level==1)
{
if($orms=='y'){$crj_location="/budget/admin/crj_updates/compliance_crj.php";}

if($orms=='n'){$crj_location="/budget/admin/crj_updates/bank_deposits.php?add_your_own=y";}


}
if($level > 1){$crj_location="/budget/admin/crj_updates/compliance_crj.php";}
echo "
<table border='1' align='center'>
<tr>";


echo "<th>
<a href='/budget/menu1314.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/home1.png' alt='picture of home' title='Home'></img>	<br /><font color='brown'>Home</font>
</a></th>";



if($level=='1')

{
echo "<th>
<a href='/budget/cid_menu.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/cid_menu1.png' alt='cid menu icon' title='CID Menu'></img></a>
</th>";
}

if($level=='2')

{
echo "<th>
<a href='/budget/cid_menu2.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/cid_menu1.png' alt='cid menu icon' title='CID Menu'></img></a>
</th>";
}


if($level>'2')

{
echo "<th>
<a href='/budget/home.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/cid_menu1.png' alt='cid menu icon' title='CID Menu'></img></a>
</th>";
}

/* 2022-03-14: CCOOPER - Add documentation to code block for clarity
//Vernon Price (60032791) // Tammy Dodd (60032781)
  Mahnaz Rouhani (65032850), Angela Boggus (60033242)
//Tony Bass' position (60032793)
  Heidi Rumble (60036015), Rachel Gooding (60032997), Carmen Williams (65032827)
*/
if($beacnum=='60032791' or 
   $beacnum=='60032781' or 
   $beacnum=='65032850' or 
   $beacnum=='60033242' or 
   $beacnum=='60032793' or 
   $beacnum=='60036015' or 
   $beacnum=='60032997' or 
   $beacnum=='65032827')
/*   2022-03-14: End CCOOPER*/
{
echo "<th>
<a href='/budget/service_contracts/service_contracts1_invoice_search.php?menu_sc=invoice_search'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/mission_icon_photos_224.jpg' alt='picture of dumpster' title='Service Contracts'></img><br /><font color='brown'>Service<br />Contracts
</font></a>
</th>";
}



/*
if($level==1)
{
echo "<th>
<a href='/budget/infotrack/missions.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/wheelhouse1.png' alt='picture of wheelhouse' title='Wheelhouse'></img><br /><font color='brown'>Wheel<br />house
</font></a></th>";
}
*/
//if($beacnum != '60032913' and $beacnum != '60033019' and $beacnum != '60032912' and $beacnum != '60033104')
if($level==1)
{
echo "<th>
<a href='$crj_location'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/bank1.jpg' alt='picture of bank' title='Bank Deposits'></img><br /><font color='brown'>Cash<br />Handling
</font></a></th>";
}

/* 2022-03-14: CCOOPER - Adding comments for clarity  
// (60036015 Accounting Clerk  Rod Bridges)   (60032781 Budget Officer Tammy Dodd)
   BUOFF - Mahnaz Rouhani (65032850) //   (60096024 Seasonal Maria Cucurullo)
//  (60032997 Accounting Clerk Rachel Gooding)  
//  (60033242 Budget Office Angel Boggus {was Rebecca Owen})   
// (60032793 Budget Office Tony Bass)
   BUOFF - Carmen Williams (65032827)
   Heidi Rumble (60036015)

*/
if($beacnum=='60036015' or 
   $beacnum=='60032781' or 
   $beacnum=='65032850' or 
   $beacnum=='60096024' or 
   $tempid=='debragga1235' or 
   $beacnum=='60032997' or 
   $beacnum=='60033242' or 
   $beacnum=='60032793' or 
   $beacnum=='65032827' or
   $beacnum=='60036015')
/* 2022-03-14: End CCOOPER  */
{
echo "<th>
<a href='/budget/admin/crj_updates/bank_deposits_menu_division_final.php?menu_id=a&menu_selected=y'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/bank1.jpg' alt='picture of bank' title='Bank Deposits'></img><br /><font color='brown'>Cash<br />Handling
</font></a></th>";
}

//if($cashier_count==1 or $manager_count==1 or $beacnum=='60032781' or $beacnum=='60033162')
//if($beacnum=='60032988' or $beacnum=='60032842')  //testing pam dillard,chris helms
if(($cashier_count==1 or $manager_count==1) and ($concessions_count==1) and ($crs_valid=='y')) 
{
echo "<th>
<a href='/budget/concessions/concessions_pci_report.php?menu=pci'>
<img height='60' width='60' src='/budget/infotrack/icon_photos/mission_icon_photos_250.gif' alt='picture of Money' title='Concessions'></img><br /><font color='brown'>Concession<br />Contracts
</font></a></th>";
}


if(($cashier_count==1 or $manager_count==1) and ($concessions_count==1) and ($crs_valid=='n') and ($third_party_valid=='y')) 
{
echo "<th>
<a href='/budget/concessions/vendor_fees_menu.php'>
<img height='60' width='60' src='/budget/infotrack/icon_photos/mission_icon_photos_250.gif' alt='picture of Money' title='Concessions'></img><br /><font color='brown'>Concession<br />Contracts
</font></a></th>";
}






if($beacnum=='60033162')  //tara gallagher
{
echo "<th>
<a href='/budget/concessions/concessions_pci_admin.php?menu=pci'>
<img height='60' width='60' src='/budget/infotrack/icon_photos/mission_icon_photos_250.gif' alt='picture of Money' title='Concessions'></img><br /><font color='brown'>Concession<br />Contracts
</font></a></th>";
}










if($cashier_count==1 or $manager_count==1 or $beacnum=='60032781' or $beacnum=='60032997' or $beacnum=='60033242' or $beacnum=='65032827' or $beacnum=='60032793' or $beacnum=='65032850' or $beacnum=='60036015' or $beacnum=='65032827')  //cashiers,managers,tammy dodd,rachel gooding,becky owen,tony bass
{
echo "<th>
<a href='/budget/acs/pcard_recon_menu.php?m=pcard&menu_new=RPurc'>
<img height='60' width='60' src='/budget/infotrack/icon_photos/mission_icon_photos_244.jpg' alt='picture of Credit Card' title='PCARD'></img><br /><font color='brown'>PCard
</font></a></th>";
}








/*
echo "<th>
<a href='/budget/loss_prevent/roles.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/money_safe_copper1.png' alt='picture of money safe' title='Money Safety'></img></a>
</th>";
*/
/*
echo "<th>
<a href='/budget/infotrack/notes.php?project_note=note_tracker'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/message_green1.png' alt='message icon' title='Messages'></img><br /><font color='brown'>Messages</font>
</a></th>";
*/
echo "<th>
<a href='/budget/games/multiple_choice/games.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/checkers_board1.png' alt='games icon' title='Training Games'></img><br /><font color='brown'>Learning<br />Games</font>
</a></th>";

echo "<th>
<a href='/budget/infotrack/position_reports.php?menu=1'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/reports1.png' alt='reports icon' title='MyReports'></img><br /><font color='brown'>My<br />Reports</font>
</a></th>";

/*
if($level < '3' or $beacnum=='60032787' or $beacnum=='60032780' or $beacnum=='60032945' or $beacnum=='60092637' or $beacnum=='60033189' or $beacnum=='60033242' )
{
echo "<th>
<a href='/budget/menu.php?forum=blank'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/target_dart1.png' alt='dartboard bullseye' title='Budget Targets'></img></a>
</th>";
}
else
{
echo "<th>
<a href='/budget/home.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/target_dart1.png' alt='dartboard bullseye' title='Budget Targets'></img></a>
</th>";
}
*/
/*
if($level==1)
{
echo "<th>
<a href='/budget/infotrack/procedures.php?folder=community&menu=1'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/compass_blue1.png' alt='compass icon' title='Directions/Procedures'></img><br /><font color='brown'>Procedures</font>
</a></th>";
}
*/
/*
echo "<th>
<a href='/budget/infotrack/bright_idea2.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/light_bulb1.png' alt='light bulb icon' title='Bright Ideas'></img><br /><font color='brown'>Bright<br />Ideas</font>
</a></th>";
*/
if($level==1 or $beacnum=='60032793' or $beacnum=='60032781' or $beacnum=='65032850')
{
echo "<th>
<a href='/budget/energy/energy_reporting.php?egroup=electricity&report=accounts'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/energy1.png' alt='energy icon' title='Energy'></img><br /><font color='brown'>Energy<br />Tracker</font>
</a></th>";
}




/* 2022-03-31 CCOOPER - adding comments: Bass (60032793), Dodd (60032781), Rouhani (65032850), Rumble (60036015), Boggus (60033242), and Williams (65032827)
*/
if($beacnum=='60032793' or $beacnum=='60032781' or $beacnum=='65032850' or $beacnum=='60036015' or $beacnum=='60033242' or $beacnum=='65032827')
{
echo "<th>
<a href='/budget/admin/compliance/step_group.php?report_type=form'><img height='50' width='50' src='/budget/infotrack/icon_photos/finger_red_ribbon1.jpg' alt='reminder image' title='compliance deadlines'></img><br /><font color='brown'>DB-Admin<br />Deadlines</font>
</a></th>";
}





echo "<th>";
//if($beacnum=='60032910')
	

$parkList=explode(",",@$_SESSION['budget']['accessPark']);// set in budget.php from db divper.emplist
//echo "<table>";
//echo "<tr>";
//echo "<th>";
//print_r($parkList);
if($parkList[0]!=""){$multipark_access='y';} else {$multipark_access='n';}

//echo "Line552: multipark_access=$multipark_access";

//if($beacnum=='60032910') //joe shimel
if($multipark_access=='y')
{
include("multiple_access.php");
}

echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />";


if($concession_location=='ADM'){$concession_location2='ADMI';} else {$concession_location2=$concession_location;}
$tempid2=substr($tempid,0,-2);
$tempid_player2=substr($tempid_player,0,-2);
$tempid_original2=substr($tempid_original,0,-2);


if($tempid_player2==''){echo "<font color='green'>$concession_location2 $cashier_image $manager_image<br /> $tempid2</font></th>";}
if($tempid_player2!=''){echo "<font color='green'>Player View: $tempid_player2 ($concession_location2 $cashier_image $manager_image)<br />User ID: $tempid_original2</font></th>";}
//if($tempid_player2!=''){echo "<font color='green'>Player View: $tempid_player2 ($concession_location2 $cashier_image $manager_image)</font></th>";}


echo "</tr></table>";


}

?>