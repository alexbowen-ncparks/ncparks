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
		 
		 
echo "query4=$query4<br />";		 
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);


while ($row4=mysqli_fetch_array($result4))
	{
	//$thumb[]=$row4['photo_location'];
	$MySlides[]=$row4['photo_location'];
	$id[]=$row4['id'];
	}	
echo "<pre>"; print_r($MySlides); echo "</pre>";  //exit;
?>
	
<script language="Javascript">
var MySlides = <?php echo json_encode($MySlides) ?>;
Slide=0
function ShowSlides(SlideNumber){

{Slide=Slide+SlideNumber
if (Slide>MySlides.length-1){
Slide=0
}
if (Slide<0) {
Slide=MySlides.length-1
}
document.DisplaySlide.src=MySlides[Slide]
}
}
</script>
	
<body>
<p align="center"><img src="MySlides[1]" name="DisplaySlide" width="600" height="420" /><p>

	

<center>
<table border=0>
<tr>
<td align="center">
<input type="button"” value="Back" onclick="ShowSlides(-1)">
<input type="button" value="Forward" onclick="ShowSlides(1)">

</td>
</tr>
</table>
</center>


</body>
</html>




