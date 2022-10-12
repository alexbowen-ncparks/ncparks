<?php

// 100319 ETG _common.php

$debug=true;
$debug=false;

if ($debug)
 {
  echo "debug mode on";
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(-1);
 }

session_start();

$docroot=$_SERVER['DOCUMENT_ROOT'];

include("../../include/biglog.php");

bl("_common.php top");

bl("_REQUEST " . print_r($_REQUEST, True));
bl("_SESSION " . print_r($_SESSION, True));

$database="job_fair";	$_SESSION['database']="job_fair";

include("../../include/iConnect.inc");
global $connection;

if (isset($_SESSION[$database]['level']))
 { $level = $_SESSION[$database]['level']; }
if (isset($_SESSION[$database]['tempID']))
 { $tempID = $_SESSION[$database]['tempID']; }
if (isset($_SESSION[$database]['emid']))
 { $emid = $_SESSION[$database]['emid']; }
if (isset($_SESSION[$database]['full_name']))
 { $full_name = $_SESSION[$database]['full_name']; }
if (isset($_SESSION[$database]['beacon_title']))
 { $beacon_title = $_SESSION[$database]['beacon_title']; }

$tempID = $_SESSION['logname']; 
$emid = $_SESSION['logemid']; 

mysqli_select_db($connection,"divper");
$sql = "
 SELECT 
   $database AS level 
  ,emplist.tempID 
  ,emplist.currPark
  ,accessPark
  ,rcc
  ,program_code
  ,concat(t3.Fname,' ',t3.Mname,' ',t3.Lname) AS full_name
  ,beacon_title
  ,t4.cart
 FROM emplist
  LEFT JOIN position ON
   position.beacon_num = emplist.beacon_num
  LEFT JOIN empinfo AS t3 ON 
   t3.tempID = emplist.tempID
  LEFT JOIN ware.cart_access AS t4 ON 
   t4.tempID = emplist.tempID
 WHERE emplist.emid = '" . @$emid . "' 
  AND emplist.tempID='" . @$tempID . "'
  ;
";
bl($sql);


$result = mysqli_query($connection,$sql)
 or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

$num = @mysqli_num_rows($result);
bl("num rows " . $num);

if($num<1)
 {
  $sql = "
  SELECT 
    $database AS level
   ,nondpr.currPark
   ,nondpr.Fname
   ,nondpr.Lname
  FROM nondpr 
  WHERE nondpr.tempID = '" . $tempID . "'
   ;
";
 bl($sql);

  $result = @mysqli_query($connection,$sql) or
   die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

  $num = @mysqli_num_rows($result);
  bl("num rows " . $num);

  if($num<1)
   {
    access_denied();
   }
 }

$row=mysqli_fetch_array($result);
extract($row);

@$_SESSION[$database]['level'] = $level;
@$_SESSION[$database]['tempID'] = $tempID;
@$_SESSION[$database]['emid'] = $emid;
@$_SESSION[$database]['full_name'] = $full_name;
@$_SESSION[$database]['beacon_title'] = $beacon_title;

if ($level <= 1)
 {
  bl("level needs to be 2 or higher to access this application");
  access_denied();
 }

mysqli_select_db($connection,$database);
date_default_timezone_set('America/New_York');


mysqli_select_db($connection,$database) or die("select_db");

mysqli_query($connection, "SET GLOBAL group_concat_max_len = 2000000;");

function mklink($href, $a, $tip, $pre="", $post="")
 {
  $str="
   " . $pre . "
   <div class=\"tooltip\">
    <a href=" . $href . ">" . $a . "</a>
     <span class=\"tooltiptext\"> 
      " . $tip . "
     </span>
    </div>
   " . $post . "
   ";
  return $str;
 }


function is_logged_in()
 {
  global $database;
  $checks=array('level','tempID','logname','emid');
  foreach ($checks as $c)
   {
    if (isset($_SESSION[$database][$c]))
     {
     } else {
      access_denied();
     }
   }
 }


function access_denied()
 {
  bl("403", 2);
  kill_vars();
  header("Location: 403.html");
  exit;
 }

function kill_vars()
 {
  global $database;
  global $connection;
  $_SESSION[$database]['level']=0;
  $_SESSION[$database]['tempID']="";
  $_SESSION[$database]['emid']="";
  $_SESSION[$database]['logname']="";
  $_SESSION[$database]['logpass']="";
  $_SESSION[$db]['loginS'] = '';
  $_SESSION['loginS'] = '';
  $_SESSION['parkS'] = '';
  $_SESSION['logname'] = '';
  $_SESSION['logemid'] = '';
 }

function log_me_out()
 {
  kill_vars();
  bl("procedure log_me_out() has been called - redirecting to main index");
  header("Location: /databases.php");
 }

if (@$_GET['logout']==1)
 { log_me_out(); }



require("_header.php");
require("_footer.php");
require("_settings.php");
require("_search.php");
require("_mktable.php");
require("_resume.php");

//require("

bl("_common.php bottom");

?>
