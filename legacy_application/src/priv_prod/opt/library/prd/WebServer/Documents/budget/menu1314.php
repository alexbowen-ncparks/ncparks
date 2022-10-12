<?php

/*   *** INCLUDE file inventory ***
include("/opt/library/prd/WebServer/include/iConnect.inc")
include("../../include/activity.php")
include("menu1314_tony.html")
include("header_logo_apple2.php")
include("robot1.php")

[$level < '2' AND $active_file == '/budget/menu1314.php']
  include("budget_summary.php")
  include("concessions/gmp_revenues.php")
*/


if (empty($_SESSION))
{
     session_start();
}

if (!$_SESSION["budget"]["tempID"])
{
     echo "Access denied";
     exit;
}

/*
     echo "<pre>";
          print_r($_SESSION);
     echo "</pre>";

     //exit;
*/ 

$active_file = $_SERVER['SCRIPT_NAME'];

$level = $_SESSION['budget']['level'];
$posTitle = $_SESSION['budget']['position'];
$tempid = $_SESSION['budget']['tempID'];
$tempid_player = $_SESSION['budget']['tempID_player'];
$tempid_original = $_SESSION['budget']['tempID_original'];
$beacnum = $_SESSION['budget']['beacon_num'];
$concession_location = $_SESSION['budget']['select'];
$concession_center = $_SESSION['budget']['centerSess'];
$concession_center_new = $_SESSION['budget']['centerSess_new'];

$tempid1 = substr($tempid,0,-2);

// CCOOPER
/* if($tempid=='Rumble2030' or $tempid=='Rumble9889'){
   //if($tempid=='Jones6793' or $tempid=='Windsor1234'){ 
echo "<br />tempid=$tempid<br />";
echo "<br />tempid_player=$tempid_player<br />";
echo "<br />tempid_original=$tempid_original<br />";
echo "concession_location=$concession_location"; 
echo "concession_center=$concession_location";   
echo "concession_location=$concession_location";
echo "<pre>";print_r($_SESSION);echo "</pre>";
exit;
} */
// end CCOOPER

//if($tempid=='Wilder3282' and $concession_location=='momi')
if($tempid=='Wilder3282')
{
     if ($concession_location=='momi')
     {
          $_SESSION[$db]['position'] = "park superintendent";
          $posTitle = 'park superintendent';
          //echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
     }
     if ($concession_location == 'elkn')
     {
          $_SESSION[$db]['position'] = "park ranger";
          $posTitle = 'park ranger';
          //echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
     }
} // end if($tempid=='Wilder3282')

 /* 
if($beacnum=='65027688' OR $beacnum=='60033242' OR $beacnum=='60036015')
{
echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
}
if($tempid=='Biddix1484')
{
echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
}
if($beacnum=='60033242')
{echo "<table align='center'><tr><th>Hello Rebecca and Welcome to NC State Parks</th></tr><tr><tr><th>ALL Features are now working.<br /> Tony P Bass (February 3, 2014)</th></tr></table>";
}
*/

$database = "budget";
$db = "budget";

if (empty($connection))
{
     include("/opt/library/prd/WebServer/include/iConnect.inc");
}
// connection parameters
mysqli_select_db($connection, $database); // database
include("../../include/activity.php");

//if($tempid=='Bass3278' or $tempid=='Owen1111')
//7/27/21

/* CCOOPER
echo "tempid: $tempid <br/>";
echo "tempid_orig: $tempid_original <br/>";
echo "tempid_player: $tempid_player <br/>";
echo "player_view: $player_view <br/>";

 end CCOOPER */

if ($tempid_original=='')
{
     $query_pv_reset1 = "DELETE FROM cash_handling_roles
                         WHERE tempid = '$tempid'
                              AND player_view = 'y'
                         ";
     //echo "<br />Line 98: query_pv_reset1=$query_pv_reset1<br />";
     $result_pv_reset1 = mysqli_query($connection, $query_pv_reset1)
                         OR DIE ("In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query_pv_reset1:<br />  $query_pv_reset1");
}
//7/27/21
if ($tempid_original != '')
{     
     $query_pv_reset2 = "DELETE FROM cash_handling_roles
                         WHERE tempid = '$tempid_original'
                              AND player_view = 'y'
                         ";
     //echo "<br />Line 116: query_pv_reset2=$query_pv_reset2<br />";
     $result_pv_reset2 = mysqli_query($connection, $query_pv_reset2)
                         OR DIE ("In File:" . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query_pv_reset2:<br />  $query_pv_reset2");        
     if ($tempid_original != $tempid_player)
     {
          $query_pv_reset3 = "SELECT first_name AS 'tempid_original_first',
                                   last_name AS 'tempid_original_last'
                              FROM cash_handling_roles
                              WHERE tempid = '$tempid_original'
                                   AND player_view = 'n' ";
          //echo "<br />Line 135: query_pv_reset3=$query_pv_reset3<br />";
          $result_pv_reset3 = mysqli_query($connection, $query_pv_reset3)
                              OR DIE ("In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query_pv_reset3:<br />  $query_pv_reset3");
          $row_pv_reset3 = mysqli_fetch_array($result_pv_reset3);
          extract($row_pv_reset3);

          $query_pv_reset4 = "INSERT IGNORE INTO cash_handling_roles(park,
                                                                      tempid,
                                                                      role,
                                                                      lead_superintendent,
                                                                      first_name,
                                                                      last_name,
                                                                      player_view,
                                                                      player_name
                                                                      )
                              SELECT park,
                                   '$tempid_original',
                                   role,
                                   lead_superintendent,
                                   '$tempid_original_first',
                                   '$tempid_original_last',
                                   'y',
                                   '$tempid_player'
                              FROM cash_handling_roles
                              WHERE tempid = '$tempid_player'
                              ";
     
          //if($tempid_original=='Howerton3639'){echo "<br />Line 147: query_pv_reset4=$query_pv_reset4<br />";}
          $result_pv_reset4 = mysqli_query($connection, $query_pv_reset4)
                              OR DIE ("In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Couldn't execute query_pv_reset4:<br />  $query_pv_reset4");
     }
}

extract($_REQUEST);

   /*echo "<pre>";
   print_r($_REQUEST);
   echo "</pre>";
    exit;  */

//include("../../../include/activity.php");// database connection parameters
//if(!$_SESSION["budget"]["tempID"]){
//header("location: /login_form.php?db=budget");
//header("location: /login_form.php?db=budget");
//}
//$bgcolor='blue';
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitionalt//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
/*
if(
($active_file=='/budget/menu1314.php')
and
(
$beacnum=='60032779' or
$beacnum=='60033202' or
$beacnum=='60033162' or
$beacnum=='60032920' or
$beacnum=='60032781' or
$beacnum=='60033012' or
$beacnum=='60032793' or
$beacnum=='60033009' or
$beacnum=='60033018' or
$beacnum=='60032997' or
$beacnum=='60032791' or
$beacnum=='60036015' or
$beacnum=='60032787' or
$tempid=='Howard6319' or
$tempid=='Cucurullo1234'
)
)
*/
//{
echo "<html xmlns='http://www.w3.org/1999/xhtml' lang='en' xml:lang='en'>
          <head>
               <title>
                    MoneyTracker
               </title>
     ";

if ($beacnum != '60032793')        // Tony Bass' BeacPosNum before 2021-09-01; [creator of Money Counts]
{
     // echo "<link rel='stylesheet' type='text/css' href='/budget/menu1314.css' />";
     include("menu1314_tony.html");
}

if ($beacnum == '60032793')
{
     include("menu1314_tony.html");
}
?>
     
<link type="text/css" href="/css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />    
<script type="text/javascript" src="/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui-1.8.23.custom.min.js"></script>
</head> 
     <body id="home">

<?php

// include ("header_logo.php");
include("header_logo_apple2.php");

$active_file = $_SERVER['SCRIPT_NAME'];
// echo "active_file=$active_file";

if ($level < '3' AND $active_file == '/budget/menu.php')
{
     include("robot1.php");
}

//pam dillard
//if($level < '3' and $beacnum=='60032988' and $active_file=='/budget/menu1314.php')
if ($level < '2' AND $active_file == '/budget/menu1314.php')
{
     include("robot1.php");
     // Budget Summary
     include("budget_summary.php");
     include("concessions/gmp_revenues.php");
}
//echo "<br />active file=$active_file<br />"

if ($level > '1' AND $active_file == '/budget/menu1314.php')
// if($level < '2' AND $active_file == '/budget/menu1314.php')
{
     include("robot1.php");
     
     // echo "<br />beacnum=$beacnum<br />";
     
     // region managers and OA's
     if ($beacnum == '60032912'              // EARE RESU; formerly John Fullwood prior to 2021-06; remained/currently empty as of 2021-11-30 by jgcarter
          OR $beacnum == '60032892'          // EARE OA; Bonita Meeks
          OR $beacnum == '60033019'          // SORE   RESU; Jay Greenwood
          OR $beacnum == '60033093'          // SORE OA; Val Mitchener
          OR $beacnum == '60032913'          // WERE RESU; Sean McElhone
          OR $beacnum == '60032931'          // WERE OA; Annette Hall
          OR $beacnum == '65030652'          // NORE RESU; Kristen Woodruff
          or $beacnum == '60032920'          // NORE OA; Aimee McGuiness
          )
     {
          include("budget_summary.php");
     }  

     // CHOP, Budget Officer, Reuter, and Tingley
     if ($beacnum == '60033018'         // DD of Ops; Cathy Capps
          OR $beacnum == '60032781'     // Budget Officer; Tammy Dodd
          OR $beacnum == '65032850'     // Budget Officer; Mahnaz Rouhani; added 2021-11-30 by jgcarter
          OR $beacnum == '60032778'     // DPR Director; Dwayne Patterson
          OR $beacnum == '60033202'     // DD of Admin; Eric Estes; formerly Carol Tingley prior to 2021-01
          // or $beacnum == '60032779'   // HRrep-Danielle Kensey (jgcarter added 2021-11-30) ; DD - ; formerly Don Reuter (should probably be removed now that the position is an HR position)
          )
     {
          include("budget_summary.php");
     }

     // Budget Officer
     // if($beacnum == '60032781')
     //include("budget_summary.php");
     
}

/*
     if($level == '3' AND $active_file == '/budget/menu.php')
     {
          include ("robot1.php");
     }
     //tammy dodd
     if($beacnum == '60032781' AND $active_file == '/budget/menu1314.php')
     {
          include ("robot1.php");
     }
     //tony bass
     if($beacnum == '60032793' AND $active_file == '/budget/menu1314.php')
     {
          include ("robot1.php");
     }
     //rod bridges
     if($beacnum    ==   '60036015' AND $active_file == '/budget/menu1314.php')
     {
          include ("robot1.php");
     }
     //denise williams
     if($beacnum=='60032920' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //mike lambert
     if($beacnum=='60033018' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //mike murphy
     if($beacnum=='60032778' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //carol tingley
     if($beacnum=='60033202' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //joanne barbour
     if($beacnum=='60032791' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //jennifer goss
     if($beacnum=='60032787' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //don reuter
     if($beacnum=='60032779' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //brian strong
     if($beacnum=='60033160' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //sue regier
     if($beacnum=='60032790' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //tara gallagher
     if($beacnum=='60033162' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //jerry howerton
     if($beacnum=='60033012' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //siobhan oneal
     if($beacnum=='60032877' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //kelly chandler
     if($beacnum=='60032786' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //jessie summers (warehouse oa). Added on 10/25/17
     if($beacnum=='60033009' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //rachel gooding
     if($beacnum=='60032997' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //sean higgins
     if($beacnum=='60032780' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //carl jeeter
     if($beacnum=='60032945' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //keith bilger
     if($beacnum=='60033189' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //martin kane
     if($beacnum=='60092637' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //erin lawrence
     if($beacnum=='60032833' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //jon blanchard
     if($beacnum=='60032828' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //bryan dowdy
     if($beacnum=='60033165' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //jan trask
     if($beacnum=='60092634' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //rosilyn mcnair
     if($beacnum=='60033136' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //teresa mccall
     if($beacnum=='60032785' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //steve livingstone
     if($beacnum=='60033138' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //adrienne eikinas
     if($beacnum=='60032784' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //vincent newman-brooks
     if($beacnum=='60095522' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //charlie peek
     if($beacnum=='60032788' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //darrell mcbane
     if($beacnum=='60032942' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //catherine locke
     if($beacnum=='60033137' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //cara hadfield
     if($beacnum=='60033199' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //processing assistant rebecca  owen
     if($beacnum=='60033242' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //Natural Resources Temporary Accounting Clerk  Laura Fuller
     if($beacnum=='60032794' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     //echo "tempID=$tempID<br />";
     if(@$tempid== 'Howard6319' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     if(@$tempid== 'Cucurullo1234' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
     if(@$tempid== 'debragga1235' and $active_file=='/budget/menu1314.php')
     {
     include ("robot1.php");
     }
include ("games_js.php");
*/
?>  