<?php
extract($_REQUEST);
 session_start();
 if($name=="logout"){
$_SESSION[$db]['loginS'] = '';$_SESSION['loginS'] = '';$_SESSION['parkS'] = '';
echo "Logout successful.";

//echo "<pre>";print_r($_REQUEST); print_r($_SESSION); echo "</pre>";
exit;}
?>
