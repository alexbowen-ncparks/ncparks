<?php

// database 'pac' is ONLY used for login
$database="pac";
// data tables are located in 'divper'

include("../../include/auth.inc");// database connection parameters
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
$title="PAC"; 
include("/opt/library/prd/WebServer/Documents/pac/_base_top_pac.php");

echo "<table align='center' cellpadding='10'><tr><td colspan='2'><h2>Park Advisory Committee Website</h2></td></tr>";

$path="/pac/";

$menu_array['Guidelines/Instructions']="/find/forum.php?forumID=450&submit=Go";
$menu_array['Guidelines/Instructions']="/find/forum.php?forumID=450&submit=Go";
$menu_array['Current PAC members']=$path."current_pac.php";

$menu_array['All PAC Nominations']=$path."all_nomin.php";

$menu_array['Nominate a new PAC Member']=$path."add_new.php";

$menu_array['Renomination for an additional term']=$path."add_old.php";

$menu_array['PAC Meeting Calendar']=$path."cal.php";

$menu_array['Former PAC']=$path."former_pac.php";

$menu_array['Search PAC']=$path."search.php";


$menu_color=array("#EE82EE","#E9967A","#009900","#FFE4C4","#DAA520","#48D1CC","#C6E2FF","#FFB6C1","#FFFF66","#7FFFD4");

if($level>1)
	{
	}
	
if($level>3)
	{
	$menu_array['PAC Meeting Calendar']=$path."cal.php";
	
	$menu_array['PAC Summary']=$path."pac_summary.php";
	
	$menu_array['Change CURRENT member status to FORMER']=$path."change_current_pac.php";

	$menu_array['Change CURRENT member status to PAC_nominee']=$path."change_current_pac.php";

	$menu_array['Lake Phelps Advisory Committee']=$path."laph.php";

	//$menu_array['Admin Functions']=$path."admin.php";
	}
//echo "<table cellpadding='10' align='center'>";
$i=0;
foreach($menu_array as $k=>$v)
	{
	
		$color=$menu_color[$i]; $i++;
		if($k=="Guidelines/Instructions" || $k=="Instructions")
			{
			$v=htmlentities($v);
			echo "<tr><td align='left'><FORM method='POST' action=\"$v\" target=\"_blank\">
	<INPUT type=submit value=\"$k\" style=\"background-color:$color; font-size:larger\"></FORM></td></tr>";
			}
		else
		{
		$target="";
		echo "<tr><td align='left'>
		<form action='$v' $target>
		<input type='submit' name='submit' value='$k'  style=\"background-color:$color; font-size:larger\"></form>
		</td>";
		if($k=="Nominate a new PAC Member")
			{echo "<td align='left'>Normally this will be for a 1-year term.</td>";}
		if($k=="Renomination for an additional term")
			{echo "<td>Normally this will be for a 3-year term.</td>";}
		echo "</tr>";
		}
	}
	

	echo "</table><table><tr><td colspan='2'><h2>Contact Derrick Evans or Tom Howard if you need to change a CURRENT member to FORMER PAC member status or to PAC_nominee status.</h2></td></tr>";
	
echo "</table>";
echo "</body></html>";
?>