<?php
/*
session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}
*/
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}


$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$tempid1=substr($tempid,0,-2);

extract($_REQUEST);
$database="photos";
$db="photos";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../include/activity.php");



//include ("favorite_colors.php");




//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;





//include("../../budget/menu1314.php");


/*

$query4="select photo_location,comments,comments2
         from mission_icon_photos
		 where 1
		 and label='slideshow2'
         order by id asc ";
	
*/	
	

$query4="select park,photoname,link,pid
         from images
         where park='haro'
         and cat like '%scenic%' ";   //14720


		 
//echo "query4=$query4<br />";  //exit;		 
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);


while ($row4=mysqli_fetch_array($result4))
	{
	//$thumb[]=$row4['photo_location'];
	$Photo_location[]=$row4['link'];
	$Comments[]=$row4['photoname'];
	$Comments2[]=$row4['park'];
	//$Gid[]=$row4['gid'];
	//$MyComments[]=$row4['comments2'];
	//$label[]=$row4['label'];
	//$id[]=$row4['id'];
	}	
//echo "<pre>"; print_r($MySlides); echo "</pre>";  //exit;
//echo "<pre>"; print_r($MyComments); echo "</pre>";  //exit;

$slideshow_records=count($Photo_location);



//echo "line 89: slideshow_records=$slideshow_records<br />";

//$slideshow_records_m1=$slideshow_records-1;	

//echo "line 91: slideshow_records_m1=$slideshow_records_m1<br />";

//echo "line 92: j=$j<br />";
if($j==''){$j=0;}
//echo "line 94: j=$j<br />";
echo "<html xmlns='http://www.w3.org/1999/xhtml' lang='en' xml:lang='en'>
 <head>";
//}
  
echo "<title>MoneyTracker</title>";

/*
if($beacnum!='60032793')
	{
	//echo "<link rel='stylesheet' type='text/css' href='/budget/menu1314.css' />";
	include ("menu1314_tony.html");
	}
	if($beacnum=='60032793')
	{
	include ("menu1314_tony.html");
	}
*/
if($bgcolor=='Black'){$color='white';} else {$color='black';}
?>

<style>
body {
    background-color: <?php echo $bgcolor;?>;
	color: <?php echo $color;?>;
}


</style>



<?php

echo "<body>";
if($submit=='Next'){$j++ ;}
if($submit=='Previous'){$j-- ;}
//echo "line 98: j=$j<br />";
if($j > $slideshow_records-1){$j=$j-1;}
if($j < 0){$j=0;}
$j=rand(0,$slideshow_records);
$photo_src='/photos/'.$Photo_location[$j] ;
echo "photo_src=$photo_src <br />";

echo "<table align='center'><th>Park Photos</th></tr></table>";
echo "<table align='center'>";
echo "<tr>";
//echo "<th align='center'><img src='/budget/infotrack/icon_photos/green_checkmark1.png'  width='750' height='500' title='$Comments2[$j]' /><br />$Comments[$j]</th>";
echo "<th align='center'><img src='$photo_src'  size='800' title='$Comments2[$j]' /><br />$Photo_location[$j]<br />$Comments[$j]</th>";
//echo "<th align='center'>$Qid[$j]</th>";
echo "</tr>";
//echo "<tr>";
//echo "<p align='center'><img src='$photo_location[$j]'  width='200' height='200' /><p>";
//echo "<td align='center'>$Question[$j]</td>";
//echo "</tr>";




//echo "<td align='center'><a href='games.php?gid2=$Gid[$j]&gidS=none'>Play Gid$Gid[$j]</a></td>";
echo "<tr>";
//echo "<td align='center' onMouseOver=\"this.bgColor='lightgreen'\" onMouseOut=\"this.bgColor='lightcyan'\"><a href='games.php?gid2=$Gid[$j]&gidS=none'>Play</a></td>";
echo "</tr>";
echo "</table>";


//echo "line 105: j=$j<br />";





echo "<table border=0 align='center'><tr>";

echo "<td>
<form method='post' action='slideshow_20150321b_haro.php'>";
echo "<input type='submit' name='submit' value='Previous'>";
//echo "<input type='image' src='/budget/infotrack/icon_photos/mission_icon_photos_190.png' width='90' height='30' name='submit' value='Previous'>";

echo "<input type='hidden' name='j' value='$j'>
</form>
</td>";


//echo "<th align='center'><input type='image' src='/budget/infotrack/icon_photos/mission_icon_photos_188.png'  width='90' height='30' /></th>";
/*
echo "<td align='center' onMouseOver=\"this.bgColor='lightgreen'\" onMouseOut=\"this.bgColor='lightcyan'\">
<form method='post' action='slideshow1a.php'>";
*/
$k=$j+1;

echo "<td>$k of $slideshow_records</td>";


echo "<td>
<form method='post' action='slideshow_20150321b_haro.php'>";

echo "<input type='submit' name='submit' value='Next'>";
//echo "<input type='image' src='/budget/infotrack/icon_photos/mission_icon_photos_188.png' width='90' height='30' name='submit' value='Next'>";
echo "<input type='hidden' name='j' value='$j'>
</form>
</td>";


/*
echo "</tr></table>";
echo "<table align='center'>";
echo "<tr>";

echo "<td>";
echo "<br />";
include("poll_form_6.php");
echo "</td>";


echo "</tr>";
echo "</table>";
*/
echo "</body>";

echo "</html>";



