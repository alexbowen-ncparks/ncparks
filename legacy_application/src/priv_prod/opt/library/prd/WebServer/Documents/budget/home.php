<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
//header("location: /login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

extract($_REQUEST);
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("~f_year.php");
include("../../include/salt.inc"); // salt phrase
/*
$emid="204";
$ck=md5($salt.$emid);
header("Location: budget.php?emid=$emid&ck=$ck&forum=blank");
*/
//echo "$salt";exit;
//if($level=='5' and $tempID !='Dodd3454'){include("menus3.php");}

if($beacnum=='60032793'){include("menus3.php");} //accounting specialist I-Tony Bass
if($beacnum=='60032781'){include("menus3.php");} //Administrative Officer III-Tammy Dodd
if($beacnum=='65032850'){include("menus3.php");} // budet analyst I-mahnaz rouhani
if($beacnum=='60032779'){include("menus3.php");} //Business Officer III-Don Reuter
if($beacnum=='60033012'){include("menus3.php");} //Facility MaintManager I-Jerry Howerton
if($beacnum=='60033202'){include("menus3.php");} //deputy director-Carol Tingley
if($beacnum=='60033162'){include("menus3.php");} //concessions mgr-Tara Gallagher
if($beacnum=='60032920'){include("menus3.php");} //was Chop Administrative Assistant-Derrick Evans; now NODI OA
if($beacnum=='60033148'){include("menus3.php");} //DDOPs' OA - Pacita Grimes
if($beacnum=='65027688'){include("menus3.php");} //FAMA Administrative Assistant-Matthew Davis
if($beacnum=='60032877'){include("menus3.php");} //Curator of Exhibits Design-Siobhan ONeal
if($beacnum=='60032786'){include("menus3.php");} //Warehouse Manager- Kelly chandler
if($beacnum=='60033009'){include("menus3.php");} //Warehouse Office Assistant 5- jessie summers
if($beacnum=='60033018'){include("menus3.php");} //Chief of Operations-Mike Lambert
//if($beacnum=='60033137'){include("menus3.php");} //Budget Office Accounting-Rachel Gooding
if($beacnum=='60032997'){include("menus3.php");} //Budget Office Accounting-Rachel Gooding
if($beacnum=='60033242'){include("menus3.php");} //Budget Office Accounting-Angela Boggus (chg by CCOOPER 02/22/22)
if($beacnum=='60032791'){include("menus3.php");} //Budget Office-Joanne Barbour
if($beacnum=='60036015'){include("menus3.php");} //Budget Office-Rod Bridges
if($beacnum=='65032827'){include("menus3.php");} //Budget Office-Carmen Williams (chg by CCOOPER 02/22/22 - was typed "Cameron")
if($beacnum=='60032787'){include("menus3.php");} //Design and Development-Jennifer Goss
if($beacnum=='60032833'){include("menus3.php");} //Design and Development-Erin Lawrence
if($beacnum=='60032789'){include("menus3.php");} //Design and Development-Neal Pate
if($beacnum=='60032790'){include("menus3.php");} //Land-Sue Regier
if($beacnum=='60032778'){include("menus3.php");} //Director-Mike Murphy
if($beacnum=='60032828'){include("menus3.php");} //Jon Blanchard
if($beacnum=='65027686'){$_SESSION['budget']['level'] = 2; include("menus3.php");} //Jimmy Dodson
if($beacnum=='65027685'){$_SESSION['budget']['level'] = 2; include("menus3.php");} //Thomas Crate
if($beacnum=='60033160'){include("menus3.php");} //Brian Strong
if($beacnum=='60032780'){include("menus3.php");} //sean higgins
if($beacnum=='60032945'){include("menus3.php");} //carl jeeter
if($beacnum=='60033189'){include("menus3.php");} //keith bilger
if($beacnum=='60092637'){include("menus3.php");} //martin kane
if($beacnum=='60033165'){include("menus3.php");} //bryan dowdy
if($beacnum=='60092634'){include("menus3.php");} //jan trask
if($beacnum=='60033136'){include("menus3.php");} //rosily mcnair
if($beacnum=='60032785'){include("menus3.php");} //teresa mccall
if($beacnum=='60033138'){include("menus3.php");} //steve livingstone
if($beacnum=='60032784'){include("menus3.php");} //adrienne eikinas
if($beacnum=='60095522'){include("menus3.php");} //vincent newman-brooks
if($beacnum=='60032788'){include("menus3.php");} //charlie peek
if($beacnum=='60032942'){include("menus3.php");} //darrell mcbane
if($beacnum=='60033137'){include("menus3.php");} //catherine locke
if($beacnum=='60033199'){include("menus3.php");} //cara hadfield
if($beacnum=='60033176'){include("menus3.php");} //pete colwell
if($beacnum=='60032794'){include("menus3.php");} //Natural Resources Temporary Accounting Clerk Laura Fuller
if($beacnum=='65020599'){include("menus3.php");} //Jody Reavis
if($beacnum=='65020598'){include("menus3.php");} //Dwayne Parker
if($beacnum=='65027687'){include("menus3.php");} //Mark Lyons
//if($beacnum=='60092633'){include("menus3.php");} //Justin Williams (Environmental Specialist)
if($beacnum=='60032830'){include("menus3.php");} //Justin Williamson
if($beacnum=='60092636'){include("menus3.php");} //Daron Blount (Facility Engineering Specialist)
if($beacnum=='65027689'){include("menus3.php");} //John Carter
//if($beacnum=='60032790'){include("menus3.php");} //Sue Regier
if($tempID=='Howard6319'){include("menus3.php");} //Tom Howard
//if($tempID=='Grunder0429'){include("menus3.php");} //Erech Grunder
if($tempID=='Cucurullo1234'){include("menus3.php");} //Tom Howard
//if($tempID=='Brodie2030'){include("menus3.php");} //Tom Howard
if($tempID=='debragga1235'){include("menus3.php");} //Tom Howard
//if($tempID=='money'){include("menus3.php");} //Tom Howard

//echo "<h1>Home Page: Fiscal Year:$f_year</h1></div></body></html>";

//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;       
?>	   
	   