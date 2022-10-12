<?php
$database="hr_perm";
if(!isset($_SESSION))
	{
	session_start();
	}
	$level=$_SESSION[$database]['level'];
	if($level<1){echo "You do not have access to this database.";exit;
	}
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	ini_set('display_errors',1);


include("../../include/iConnect.inc"); // includes no_inject.php
mysqli_select_db($connection,$database);

$sql="SELECT * from manage_menu order by sort_order"; //echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die();
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
?>