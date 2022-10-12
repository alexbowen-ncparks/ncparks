<?php
// session_start();
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; exit;
$database="ware";
$title="Warehouse";
include("../_base_top.php");

include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");
       
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
echo "<table><tr><td><img src='https://10.35.152.9/photos/photos/WARE_2015/08/640.35698.jpg' width='150px'>&nbsp;&nbsp;</td><td><h2>Welcome to the DPR Warehouse database!</h2></td><td><img src='2013-DPR-logo-small-web.png'></td></tr></table>";
// echo "<table><tr><td><img src='https://10.35.152.9/photos/photos/WARE_2015/08/640.35698.jpg' width='150px'>&nbsp;&nbsp;</td><td><h2>Welcome to the DPR Warehouse database!</h2></td><td><img src='2013-DPR-logo-small-web.png'></td></tr></table>";

if(!empty($notice))
	{
	echo "<table><tr><td><font color='red'>Important notice:</font>
	$notice</td></tr></table>";
	}

include("welcome_text.php");
?>