<?php
$database="inspect";
include("pm_menu_new.php");

$level=$_SESSION[$database]['level'];
$parkcode=$_SESSION[$database]['select'];
//echo "<pre>"; print_r($_SESSION); echo "</pre>";// exit;
//These are placed outside of the webserver directory for security
if($level==""){echo "You do not have authorization for this database."; exit;} // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);


// *********** Display ***********

echo "<html><table colspan='3'><tr><td align='center'><h2><font color='blue'><a href='home.php'>Safety Activities and Resources</a></font></h2></td></tr></table>

<table align='center'><tr>

<td align='center'><a href='suggestion.php' target='_blank'><img src='box.jpeg' height='100'></a></td>
</tr></table>

<table><tr><td colspan='3'>Contact <a href='mailto:keith.bilger@ncparks.gov?subject=New Safety Activity'>Keith Bilger</a> if additional activities need to be added.</td></tr></table>";

$dir = "safety_policy";
	$dh = opendir($dir);
	 while (false !== ($filename = readdir($dh)))
		 {
		 $path_parts=pathinfo($filename);
//  	echo "<pre>"; print_r($path_parts); echo "</pre>";  //exit;
			if($filename!="."&&$filename!=".."&&$filename!=".DS_Store")
				{
				$name=$path_parts['filename'];
				$files[$name]=$dir."/".$filename;
				}
		 }
 
asort($files);
Echo "<table align='center' cellpadding='10'><tr><th>Policies and Procedures</th></tr>";
foreach($files as $k=>$v)
	{
	echo "<tr><td><a href='$v'>$k</td></tr>";
	}
echo "</body></html>";

?>