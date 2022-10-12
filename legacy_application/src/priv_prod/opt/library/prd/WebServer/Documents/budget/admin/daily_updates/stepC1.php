<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
//echo "step=$step<br /><br />"; exit;
header("location: bank_deposits_menu_division_final2.php?menu_id=a&menu_selected=y&project_category=$project_category&project_name=$project_name&step_group=$step_group&step=$step&step_num=$step_num");



?>



