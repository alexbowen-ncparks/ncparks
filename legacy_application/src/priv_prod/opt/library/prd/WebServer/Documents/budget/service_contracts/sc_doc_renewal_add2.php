<?php
session_start();
$beacnum=$_SESSION['budget']['beacon_num'];
date_default_timezone_set('America/New_York');
$date=date("Ymd");
$date2=time();

extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);print_r($_FILES);echo "</pre>";  //EXIT;
//echo "Under Construction as of 9/11/13";exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;

//$project_note_id=$_POST['project_note_id'];

define('PROJECTS_UPLOADPATH','documents2/');
$document=$_FILES['document']['name'];
$doc_mod=$document;
//$document=$myusername."_".$date."_".$message_note_id;
//echo $document;exit;
//$document="service_contracts_".$source_id;
$document="contracts_".$source_id;
//echo "<br />";
//echo $document;
$ext=explode(".",$doc_mod);
$num=count($ext)-1;
$ext1=$ext[$num];
$document.=".".$ext1;


//$document=str_replace(" ","_",$document);
//$document=str_replace("%20","_",$document);
//echo $document;
$target=PROJECTS_UPLOADPATH.$document;

move_uploaded_file($_FILES['document']['tmp_name'], $target);
chmod($target, 0775);

//echo "$target"; exit;
// echo "upload_successful";
//include("../../../include/connectBUDGET.inc");
$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
mysqli_select_db($connection,$database); // database
//$table="service_contracts";
$table="contracts";

/*
$query="update $table set document_renewal='$target' where id='$source_id' ";
mysqli_query($connection,$query) or die ("Error updating Database $query");
*/

$query="update `budget_service_contracts`.`contracts` set `document_renewal`='$target' where `id`='$source_id' ";
mysqli_query($connection,$query) or die ("Error updating Database $query");

$query11="SELECT `park`,`active` from `budget_service_contracts`.`contracts` WHERE `id`='$source_id' ";

$result11=mysqli_query($connection,$query11) or die ("Couldn't execute query 11. $query11");

//echo "query11=$query11";echo "<br />";

$row11=mysqli_fetch_array($result11);

extract($row11);

/*
echo "id=$id";echo "<br />";
echo "vendor_name=$vendor_name";echo "<br />";
echo "f_year=$f_year";echo "<br />";
echo "park=$park";echo "<br />";
echo "ncas_center=$ncas_center";echo "<br />";
*/

echo "<html>";
echo "<head>
<style>
body { background-color: darkseagreen; 
       color: brown;
	   font-family: Arial; font-size: 15pt;
	   text-align:left;
}

th {background-color: lightcyan; 
       color: brown;
	   font-family: Arial; font-size: 15pt;
	   text-align:left;
}

td {
       
       color: brown;
	   font-family: Arial; font-size: 15pt;
	  
}



</style>

</head>
<body>";
//echo "<table><tr><th>Successful! Click on Fox to go home</th></tr></table>";
echo "<br />";
echo "<table>
<tr>
<th>
<i>Thanks for Upload! 
</i>
</th>
</tr>
</table>

<table>
<tr>
<td>
<a href='service_contracts2.php?park=$park&active=$active'>
<img width='40%' height='40%' src='nrid_logo.jpg' alt='roaring gap photos' title='Home' />
</a>
</td>
</tr>

</table>";	
	
echo "</body>";
echo "</html>";

?>