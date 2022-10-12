<?php

echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>

  <head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' /> 
    <title>HOME</title>
	
    <link rel='stylesheet' type='text/css' href='/budget/menus3.css' />
  </head> 
  <body id='home'>
        <div id='page'>		
        </div>";
/*		
echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>

  <head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' /> 
    <title>MoneyCounts</title>
	
    <link rel='stylesheet' type='text/css' href='/budget/menus3.css' />
  </head> 
  <body id='home'>
        <div id='page'>		
        <div id='header'>
		<a href='/budget/home.php'>
		<img width='50%' height='50%' src='nrid_logo.jpg' alt='roaring gap photos'></img>
		</a>
		</div>";		
		
*/		
		
		
include("../../include/salt.inc"); // salt phrase
$ck_budS=md5($salt);
//if($level=='5' and $tempID !='Dodd3454'){include ("navigation_1.php");}		
//if($level=='5'){include ("menus3_navigation.php");}	


include("../budget/menu1314.php");

echo "<br />";

if($beacnum=='60032793'){include("menus3_navigation.php");} //accounting specialist I-Tony Bass
if($beacnum=='60032781'){include("menus3_navigation.php");} //Administrative Officer III-Tammy Dodd
if($beacnum=='65032850'){include("menus3_navigation.php");} //budget analyst I-mahnaz rouhani
if($beacnum=='60032779'){include("menus3_navigation.php");} //Business Officer III-Don Reuter
if($beacnum=='60033012'){include("menus3_navigation.php");} //Facility MaintManager I-Jerry Howerton
if($beacnum=='60033202'){include("menus3_navigation.php");} //deputy director-Carol Tingley
if($beacnum=='60033162'){include("menus3_navigation.php");} //concessions mgr-Tara Gallagher
if($beacnum=='60032920'){include("menus3_navigation.php");} //formerly Chop Admin Assistant-Derrick Evans; now NODI OA
if($beacnum=='60033148'){include("menus3_navigation.php");} // Deputy Director of Operations OA/AA
if($beacnum=='65027688'){include("menus3_navigation.php");} //FAMA Admin Assistant-Matthew Davis
if($beacnum=='60032877'){include("menus3_navigation.php");} //Curator of Exhibits Design-Siobhan ONeal
if($beacnum=='60032786'){include("menus3_navigation.php");} //Warehouse Manager Kelly Chandler
if($beacnum=='60033009'){include("menus3_navigation.php");} //Warehouse OfficeAssistant Jessie Summers
if($beacnum=='60033018'){include("menus3_navigation.php");} //CHOP Mike Lambert
//if($beacnum=='60033137'){include("menus3_navigation.php");} //Budget Office Accounting-Rachel Gooding
if($beacnum=='60032997'){include("menus3_navigation.php");} //Budget Office Accounting-Rachel Gooding
if($beacnum=='60033242'){include("menus3_navigation.php");} //Budget Office Accounting-Rebecca Owen
if($beacnum=='60032791'){include("menus3_navigation.php");} //Budget Office-Joanne Barbour
if($beacnum=='60036015'){include("menus3_navigation.php");} //Budget Office-Rod Bridges
if($beacnum=='65032827'){include("menus3_navigation.php");} //budget office-cameron williams
if($beacnum=='60032787'){include("menus3_navigation.php");} //Design&Development-Jennifer Goss
if($beacnum=='60032833'){include("menus3_navigation.php");} //Design&Development-Erin Lawrence
if($beacnum=='60032789'){include("menus3_navigation.php");} //Design&Development-Neil Patae
if($beacnum=='60032790'){include("menus3_navigation.php");} //Land-Sue Regier
if($beacnum=='60032778'){include("menus3_navigation.php");} //Director-Mike Murphy
if($beacnum=='60032828'){include("menus3_navigation.php");} //Jon Blanchard
if($beacnum=='60033160'){include("menus3_navigation.php");} //Brian Strong
if($beacnum=='60032780'){include("menus3_navigation.php");} //sean higgins
if($beacnum=='60032945'){include("menus3_navigation.php");} //carl jeeter
if($beacnum=='60033189'){include("menus3_navigation.php");} //keith bilger
if($beacnum=='60092637'){include("menus3_navigation.php");} //martin kane
if($beacnum=='60033165'){include("menus3_navigation.php");} //bryan dowdy
if($beacnum=='60092634'){include("menus3_navigation.php");} //jan trask
if($beacnum=='60033136'){include("menus3_navigation.php");} //rosilyn mcnair
if($beacnum=='60032785'){include("menus3_navigation.php");} //teresa mccall
if($beacnum=='60033138'){include("menus3_navigation.php");} //steve livingstone
if($beacnum=='60032784'){include("menus3_navigation.php");} //adrienne eikinas
if($beacnum=='60095522'){include("menus3_navigation.php");} //vincent newman-brooks
if($beacnum=='60032788'){include("menus3_navigation.php");} //charlie peek
if($beacnum=='60032942'){include("menus3_navigation.php");} //darrell mcbane
if($beacnum=='60033137'){include("menus3_navigation.php");} //catherine locke
if($beacnum=='60033199'){include("menus3_navigation.php");} //cara hadfield
if($beacnum=='60033176'){include("menus3_navigation.php");} //pete colwell
if($beacnum=='65020599'){include("menus3_navigation.php");} //Jody Reavis
if($beacnum=='65020598'){include("menus3_navigation.php");} //Dwayne Parker
if($beacnum=='60032794'){include("menus3_navigation.php");} //Natural Resources Temporary Accounting Clerk Laura Fuller
if($beacnum=='65027687'){include("menus3_navigation.php");} //Mark Lyons
//if($beacnum=='60092633'){include("menus3_navigation.php");} //Justin Williams (Environmental Specialist)
if($beacnum=='60032830'){include("menus3_navigation.php");} //Justin Williamson
if($beacnum=='60092636'){include("menus3_navigation.php");} //Daron Blount (Facility Engineering Specialist)
if($tempID=='Howard6319'){include("menus3_navigation.php");} //Tom Howard
//if($tempID=='Grunder0429'){include("menus3_navigation.php");} //Erech Grunder
if($tempID=='Cucurullo1234'){include("menus3_navigation.php");} //Maria Cucurullo
//if($tempID=='Brodie2030'){include("menus3_navigation.php");} //Talivia Brodie
if($tempID=='money'){include("menus3_navigation.php");} //Tom Howard
if($tempID=='debragga1235'){include("menus3_navigation.php");} //Tom Howard
if($beacnum=='65027689'){include("menus3_navigation.php");} //John Carter
//exit;

if($beacnum=='60032793'){include("player_view_menu.php");} //accounting specialist I-Tony Bass
if($beacnum=='60032793'){include("player_view_temp_menu.php");} //accounting specialist I-Tony Bass

//if($beacnum=='60032793'){include("player_view_menu2.php");} //accounting specialist I-Tony Bass
//if($beacnum=='60032793'){include("tag_view_menu.php");} //accounting specialist I-Tony Bass

if($beacnum=='60032781'){include("player_view_menu.php");} //Administrative Officer III-Tammy Dodd
if($beacnum=='60032781'){include("player_view_temp_menu.php");} //Admin Officer III-Tammy Dodd

/* 2022-02-22: CCOOPER - changed Rebecca Owen to Angela Boggus and added these 2 lines     for Carmen Williams
               **** Holding off until we determine if they need the power ***  */
//if($beacnum=='60033242'){include("player_view_menu.php");} // Angela Boggus
//if($beacnum=='60033242'){include("player_view_temp_menu.php");} // Angela Boggus

//if($beacnum=='65032827'){include("player_view_menu.php");} // Carmen Williams
//if($beacnum=='65032827'){include("player_view_temp_menu.php");} // Carmen Williams
/* 2022-02-22: END CCOOPER */

if($beacnum=='65027689'){include("player_view_menu.php");} //John Carter
if($beacnum=='65027689'){include("player_view_temp_menu.php");} //John Carter

/*
if($beacnum=='60032791'){include("player_view_menu.php");} //Purchasing Officer-JoAnne Hunt
if($beacnum=='60032791'){include("player_view_temp_menu.php");} //Purchasing Officer-JoAnne Hunt


if($beacnum=='60033162'){include("player_view_menu.php");} //concessions mgr-Tara Gallagher

if($beacnum=='60032920'){include("player_view_menu.php");} //Chop Admin Assistant-Denise Williams
if($beacnum=='60032920'){include("player_view_temp_menu.php");} //Chop AA-Denise Williams
*/
if($beacnum=='60036015'){include("player_view_menu.php");} //heide rumble
if($beacnum=='60036015'){include("player_view_temp_menu.php");} //heide rumble
/*
if($beacnum=='60032778'){include("player_view_menu.php");} //Mike Murphy
if($beacnum=='60032778'){include("player_view_temp_menu.php");} //Mike Murphy
*/

if($tempID=='Howard6319'){include("player_view_menu.php");} //Tom Howard
if($tempID=='Howard6319'){include("player_view_temp_menu.php");} //Tom Howard
/*
if($tempID=='Grunder0429'){include("player_view_menu.php");} //Erech Grunder
if($tempID=='Grunder0429'){include("player_view_temp_menu.php");} //Erech Grunder
*/



//if($tempID=='money'){include("player_view_menu.php");} //Tom Howard
//if($beacnum=='60032779'){include("player_view_menu.php");} //Business Officer III-Don Reuter
//if($beacnum=='60033202'){include("player_view_menu.php");} //deputy director-Carol Tingley

if($beacnum=='60032997'){include("player_view_menu.php");} //Budget Office Accounting-Rachel 
if($beacnum=='60032997'){include("player_view_temp_menu.php");} //Budget Office Accounting-Rachel 


//if($beacnum=='60033018'){include("player_view_menu.php");} //CHOP Mike Lambert
if($beacnum=='60033012'){include("player_view_menu.php");} //Chief of Maintenance-Jody Reavis
//if($beacnum=='60032787'){include("player_view_menu.php");} //Jennifer Goss



/*
$database2="divper";
////mysql_connect($host,$username,$password);
@mysql_select_db($database2) or die( "Unable to select database");
echo "Connection made";
*/
/*
$query1="create database $db_backup";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
*/
/*
$query5="SELECT emplist.tempID as 'player'
FROM emplist
where 1 and budget > '0'
ORDER BY emplist.tempID";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");
while ($row5=mysqli_fetch_array($result5))
	{
	$tnArray[]=$row5['player'];
	}

//echo "<table align='center'><form action=\"current_year_budget_div1.php\">";
echo "<table><form action='player_view.php' method='post' target='_blank'>";
echo "<tr>";
// Menu 000
echo "<td>Player: <select name=\"player\">"; 
for ($n=0;$n<count($tnArray);$n++){
$con=$tnArray[$n];
if($player_view_menu==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$tnArray[$n]\n";
       }
   echo "</select></td>";   
  echo "<td><input type='submit' name='submit' value='Submit'></td>";
  echo "</tr>";
  echo "<input type='hidden' name='ck_budS' value='$ck_budS'>"; 
  
  
  echo "</form>"; 
 
echo "</table>"; 
*/
     
?>	   
	   