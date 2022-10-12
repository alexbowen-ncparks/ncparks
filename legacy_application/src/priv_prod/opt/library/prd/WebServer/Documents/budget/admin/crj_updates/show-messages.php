<?php
session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}

//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters


//Get the first 10 messages ordered by time
$result = mysqli_query($connection, "select * from chat order by time desc limit 0,10");
$messages = array();
//Loop and get in an array all the rows until there are not more to get
while($row = mysqli_fetch_array($result)){
   //Put the messages in divs and then in an array
   $messages[] = "<div class='message'><div class='messagehead'>" . $row[name] . " - " . date('g:i A M, d Y',$row[time]) . "</div><div class='messagecontent'>" . $row[message] . "</div></div>";
   //The last posts date
   $old = $row[time];
}
//Display the messages in an ascending order, so the newest message will be at the bottom
for($i=9;$i>=0;$i--){
   echo $messages[$i];
}
//This is the more important line, this deletes each message older then the 10th message ordered by time, so the table will never have to store more than 10 messages.
mysqli_query($connection, "delete from chat where time < " . $old);
?>


