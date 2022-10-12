<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

echo "<pre>";print_r($_REQUEST);"</pre>";exit;
//header("location: bank_deposits_menu_division_final2.php?menu_id=a&menu_selected=y");



?>



