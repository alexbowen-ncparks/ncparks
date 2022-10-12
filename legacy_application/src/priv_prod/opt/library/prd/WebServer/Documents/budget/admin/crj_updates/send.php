<?php
session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);"</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//Check if message is empty and send the error code
if(strlen($message) < 1){
   echo 3;
}
//Check if message is too long
else if(strlen($message) > 255){
   echo 4;
}
//Check if name is empty
else if(strlen($name) < 1){
   echo 5;
}
//Check if name is too long
else if(strlen($name) > 29){
   echo 6;
}
//Check if the name is used by somebody else
else if(mysqli_num_rows(mysqli_query($connection, "select * from chat where name = '" . $name . "' and ip != '" . @$REMOTE_ADDR . "'")) != 0){
   echo 7;
}
//If everything is fine
else{
   //This array contains the characters what will be removed from the message and name, because else somebody could send redirection script or links
   $search = array("<",">",">","<");
   //Insert a new row in the chat table
   mysqli_query($connection, "insert into chat values ('" . time() . "', '" . str_replace($search,"",$name) . "', '" . @$REMOTE_ADDR . "', '" . str_replace($search,"",$message) . "')") or die(8);
}
?>
