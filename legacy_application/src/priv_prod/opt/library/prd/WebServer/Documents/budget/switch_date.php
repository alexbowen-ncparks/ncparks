<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}


$today_date=date("Ymd");
$switch_date='20131231';
if($today_date >= $switch_date){$menu_switch="yes";} else {$menu_switch="no";}
echo "menu_switch=$menu_switch";
?>