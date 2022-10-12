<?php
ini_set('display_errors',1);
$database="dpr_land";
include("../../include/auth.inc");
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
include("../../include/iConnect.inc");

mysqli_select_db($connection,$database);

include("../_base_top.php");
echo "<style>
.head {
font-size: 22px;
color: #999900;
}
</style>";


$path_to_dir="/opt/library/prd/WebServer/Documents/dpr_land/reports";
$files = glob($path_to_dir.'/*'); // get all file names
// 	echo "<pre>"; print_r($files); echo "</pre>";  //exit;
echo "<div>";
echo "<table>";
echo "<tr><td class='head'>DPR Land Reports</td></tr>";

	foreach($files as $k=>$v)
		{
		if(is_file($v))
			{
			$exp=explode("/",$v);
			$file=array_pop($exp);
			$link="/dpr_land/reports/".$file;
			echo "<tr><td></td><td><a href='$link'>$file</a></td></tr>";
			}
		
		}
		
echo "<tr><td></td></tr>";
echo "</table>";
echo "</div>";
?>