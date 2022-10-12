<?php

$database="ware";
$title="Warehouse";
include("../_base_top.php");
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");
       
$level=$_SESSION['ware']['level'];
if($level<4)
	{exit;}

if(!empty($_POST))
	{
	extract($_POST);
// 	$notice=mysqli_real_escape_string($connection, $notice);
	$sql="INSERT INTO notice set notice='$notice'";
	$result=mysqli_query($connection, $sql);
	}

$notice="";
$sql="SELECT notice FROM notice order by id desc";
$result=mysqli_query($connection, $sql);
if($result)
	{
	$row=mysqli_fetch_assoc($result);
	extract($row);
	}


echo "<style>
a:link {
    text-decoration: none;
}
h2 {
    color: green;
    text-align: center;
	vertical-align: top;
}
p {
    font-family: \"Verdana\";
    font-size: 16px;
    font-weight: bold;
}
ul {
    font-family: \"Verdana\";
    font-size: 14px;
}
ol {
    font-family: \"Verdana\";
    font-size: 14px;
}
</style>";


echo "<table><tr><td><img src='https://10.35.130.17/photos/photos/WARE_2015/08/640.35698' width='150px'>&nbsp;&nbsp;</td><td><h2>Welcome to the DPR Warehouse database!</h2></td><td><img src='2013-DPR-logo-small-web.png'></td></tr></table>";

echo "<table><tr><td>
<form name='notice' action='welcome_edit.php' method='POST'>
<font color='red'>Important Notice:</font> <textarea name='notice' rows='3' cols='55'>$notice</textarea>
<input type='submit' name='submit' value=\"Submit\"><br />Submit a blank notice to remove any notice from the Welcome page.
</form></td></tr></table>";

include("welcome_text.php");
?>