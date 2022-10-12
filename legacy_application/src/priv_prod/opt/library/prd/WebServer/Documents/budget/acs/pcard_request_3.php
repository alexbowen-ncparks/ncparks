<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}

include ("pcard_request_fyear_module.php");
//$score='10';
//echo "<table><tr><th align='center' colspan='2'><font size='5' color='brown' ><b>Score<br /> $score</b></font></th></tr></table><br />";
include ("park_request_4.php");
//include ("cash_imprest_count2_report_test.php");




?>



	














