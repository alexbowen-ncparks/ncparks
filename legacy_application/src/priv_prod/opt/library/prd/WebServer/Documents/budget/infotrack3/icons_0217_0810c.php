<?php
/*
session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}
*/
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}



//$file = "articles_menu.php";
//$lines = count(file($file));


$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$playstation=$_SESSION['budget']['select'];
$playstation_center=$_SESSION['budget']['centerSess'];
//$pcode=$_SESSION['budget']['select'];



//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;


//include("../../../include/connectBUDGET.inc");// database connection parameters
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 


//include("../../budget/menu1314.php");

echo "<html>";
echo "<head>";


echo "</head>";



$query4="select *
         from mission_icon_photos
		 where 1
         order by mission_icon_photos.id asc ";
		 
		 
//echo "query4=$query4<br />";		 
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);


while ($row4=mysqli_fetch_array($result4))
	{
	//$thumb[]=$row4['photo_location'];
	$MySlides[]=$row4['photo_location'];
	$MyComments[]=$row4['comments2'];
	$label[]=$row4['label'];
	$id[]=$row4['id'];
	}	
//echo "<pre>"; print_r($MySlides); echo "</pre>";  //exit;
//echo "<pre>"; print_r($MyComments); echo "</pre>";  //exit;

$slideshow_records=count($MySlides);
//echo "line 89: slideshow_records=$slideshow_records<br />";

//$slideshow_records_m1=$slideshow_records-1;	

//echo "line 91: slideshow_records_m1=$slideshow_records_m1<br />";

//echo "line 92: j=$j<br />";
if($j==''){$j=0;}
//echo "line 94: j=$j<br />";
echo "<body>";
if($submit=='Forward'){$j++ ;}
if($submit=='Back'){$j-- ;}
//echo "line 98: j=$j<br />";
if($j > $slideshow_records-1){$j=$j-1;}
if($j < 0){$j=0;}
echo "<table align='center'>";
echo "<tr>";
//echo "<td align='center'><img src='$MySlides[$j]'  width='400' height='400' /></td>";
echo "<td align='center'><font size='15'>$label[$j]</font></td>";
echo "</tr>";
echo "<tr>";
//echo "<p align='center'><img src='$photo_location[$j]'  width='200' height='200' /><p>";
echo "<td align='center'>$label[$j]</td>";
echo "</tr>";
echo "</table>";


//echo "line 105: j=$j<br />";





echo "<table border=0 align='center'><tr>";

echo "<td align='center'>
<form method='post' action='icons_0217_0810c.php'>
<input type='submit' name='submit' value='Back'>
<input type='hidden' name='j' value='$j'>
</form>
</td>";


echo "<td align='center'>
<form method='post' action='icons_0217_0810c.php'>
<input type='submit' name='submit' value='Forward'>
<input type='hidden' name='j' value='$j'>
</form>
</td>";



echo "</tr></table>";



echo "</body></html>";




