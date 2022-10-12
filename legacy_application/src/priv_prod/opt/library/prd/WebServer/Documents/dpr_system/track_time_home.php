<?php
if(empty($_SESSION)){session_start();}
$database="dpr_system";
$level=$_SESSION[$database]['level'];
include("_base_top.php");
echo "Welcome to DPR Ticket Tracking for database support.";
?>