<?php
/*
if($level < '3')

{echo "<table border='1'><tr>";

echo "<th>
<a href='/budget/menu.php?forum=blank'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/home1.png' alt='picture of home' title='Home'></img>	</a>
</th>";

echo "<th>
<a href='/budget/infotrack/missions.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/wheelhouse1.png' alt='picture of wheelhouse' title='Wheelhouse'></img>	</a>
</th>";

echo "<th>
<a href='/budget/admin/crj_updates/park_posted_deposits_drilldown1_v2.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/bank1.jpg' alt='picture of bank' title='Bank Deposits'></img></a>
</th>";

echo "<th>
<a href='/budget/loss_prevent/roles.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/money_safe_copper1.png' alt='picture of money safe' title='Money Safety'></img></a>
</th>";

echo "<th>
<a href='/budget/infotrack/notes.php?project_note=note_tracker'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/message_green1.png' alt='message icon' title='Messages'></img></a>
</th>";

echo "<th>
<a href='/budget/games/multiple_choice/games.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/checkers_board1.png' alt='games icon' title='Games'></img></a>
</th>";

echo "<th>
<a href='/budget/infotrack/position_reports.php?menu=1'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/reports1.png' alt='reports icon' title='MyReports'></img></a>
</th>";



echo "</tr></table>";
}

else
*/
//echo "concession_location=$concession_location<br />";
if($concession_location=='ADM'){$concession_location='ADMI';}
//echo "beacnum=$beacnum<br />";
if($beacnum=='60033138'){$concession_location='ADMI';}
if($beacnum=='60032787'){$concession_location='DEDE';}
if($beacnum=='60032794'){$concession_location='NARA';}
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

//echo "query1b=$query1b<br /><br />";		  
		  
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);
//echo "Manager Count=$manager_count<br /><br />";

if($beacnum=='60032833'){$manager_count=1;} //erin lawrence
if($beacnum=='60033160'){$manager_count=1;} //brian strong





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















/*
if($beacnum=='60033211')
{
	
echo "query1c=$query1c<br /><br />";			
	
echo "<br />concessions_count=$concessions_count<br />";
echo "<br />cashier_count=$cashier_count<br />";


 exit;
}
*/



$query0="select myreports_only from cash_handling_roles where tempid='$tempid'";
$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
if($row0)
	{
extract($row0);//brings back max (end_date) as $end_date
}

if(empty($myreports_only)){$myreports_only="";}

//echo "myreports_only=$myreports_only<br />";
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


if($level < '3' or $beacnum=='60032780' or $beacnum=='60032945' or $beacnum=='60092637' or $beacnum=='60033189' )
{
echo "<th>
<a href='/budget/menu.php?forum=blank'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/home1.png' alt='picture of home' title='Home'></img>	<br /><font color='brown'>Home</font>
</a></th>";
}
else
{
echo "<th>
<a href='/budget/menu1314.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/home1.png' alt='picture of home' title='Home'></img>	<br /><font color='brown'>Home</font>
</a></th>";
}
//10-25-14
/*
{
echo "<th>
<a href='/budget/home.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/home1.png' alt='picture of home' title='Home'></img>	<br /><font color='brown'>Home</font>
</a></th>";
}

*/



/*
if($beacnum=='60032866' or $beacnum=='60033016' or $beacnum=='60032932' or $beacnum=='60032931' or $beacnum=='60032984' or $level=='1')
*/

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

// (60036015 Accounting Clerk  Rod Bridges)   (60032781 Budget Officer Tammy Dodd)   (60096024 Seasonal Maria Cucurullo)
//  (60032997 Accounting Clerk Rachel Gooding)  (60033242 Budget Office Rebecca Ownen)

if($beacnum=='60036015' or $beacnum=='60032781' or $beacnum=='60096024' or $tempid=='debragga1235' or $beacnum=='60032997' or $beacnum=='60033242')
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










if($cashier_count==1 or $manager_count==1 or $beacnum=='60032781' or $beacnum=='60032997')  //cashiers,managers,tammy dodd,rachel gooding
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

echo "<th>
<a href='/budget/infotrack/notes.php?project_note=note_tracker'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/message_green1.png' alt='message icon' title='Messages'></img><br /><font color='brown'>Messages</font>
</a></th>";
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
if($level==1)
{
echo "<th>
<a href='/budget/infotrack/procedures.php?folder=community&menu=1'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/compass_blue1.png' alt='compass icon' title='Directions/Procedures'></img><br /><font color='brown'>Procedures</font>
</a></th>";
}
/*
echo "<th>
<a href='/budget/infotrack/bright_idea2.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/light_bulb1.png' alt='light bulb icon' title='Bright Ideas'></img><br /><font color='brown'>Bright<br />Ideas</font>
</a></th>";
*/
if($level==1 or $beacnum=='60032793')
{
echo "<th>
<a href='/budget/energy/energy_reporting.php?f_year=1516&egroup=electricity&report=accounts'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/energy1.png' alt='energy icon' title='Energy'></img><br /><font color='brown'>Energy<br />Tracker</font>
</a></th>";
}

if($level==1)
{
echo "<th>
<a href='/budget/games/surveys/games.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/feedback1.png' alt='feedback icon' title='Surveys'></img><br /><font color='brown'>Surveys</font>
</a></th>";
}


if($level==1)
{
echo "<th>
<a href='/budget/infotrack/vm_costs_center_daily.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/vehicle_repair1.png' alt='vehicle repair icon' title='Vehicle Repair Costs'></img><br /><font color='brown'>Vehicle<br />Repair<br />Costs</font>
</a></th>";
}



if($level==5 or $beacnum=='60032778')
{
echo "<th>
<a href='/budget/admin/user_activity/user_activity_matrix.php?period=today&report=user'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/runner1.png' alt='runner icon' title='Players'></img><br /><font color='brown'>Players</font>
</a></th>";
}

if($beacnum=='60036015' or $beacnum=='60032793' or $beacnum=='65016281' or $beacnum=='60032781' or $beacnum=='60032997' or $beacnum=='60032791')
{
echo "<th>
<a href='/budget/infotrack/bright_idea2.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/light_bulb1.png' alt='light bulb icon' title='Bright Ideas'></img><br /><font color='brown'>Bright<br />Ideas</font>
</a></th>";
}



if($beacnum=='60032793' or $beacnum=='60036015' or $beacnum=='60032997' or $beacnum=='60032791' or $beacnum=='60032781')
{
echo "<th>
<a href='/budget/infotrack3/projects_menu.php?folder=community&project_category=budget office&category_selected=y&add_record=y'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/mission_icon_photos_219.jpg' alt='conference' title='Teleconference'></img><br /><font color='brown'>Conference</font>
</a></th>";
}

/*

if($beacnum=='60032793' or $beacnum=='60036015' or $beacnum=='60032997' or $beacnum=='60032791' or $beacnum=='60032781')
{
echo "<th>
<a href='/budget/infotrack3/projects_menu4.php?folder=community&project_category=budget office&category_selected=y&add_record=y'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/mission_icon_photos_219.jpg' alt='teleconference' title='Teleconference'></img><br /><font color='brown'>Tele<br />Conference</font>
</a></th>";
}


*/





$tempid2=substr($tempid,0,-2);
if($concession_location=='ADM'){$concession_location2='ADMI';} else {$concession_location2=$concession_location;}
echo "<th>
<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br /><font color='green'>$concession_location2 $cashier_image $manager_image<br /> $tempid2</font>
</th>";


echo "</tr></table>";

//echo "header_logo_apple2 line 272<br />";
}

?>