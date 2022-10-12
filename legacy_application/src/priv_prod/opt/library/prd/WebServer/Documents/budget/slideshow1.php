<?php
/*
session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");
}
*/
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}




extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 


//include("../../budget/menu1314.php");




$query4="select photo_location,comments2
         from mission_icon_photos
		 where 1
		 and label='slideshow1'
		 and comments2='wewo'
         order by comments2 asc ";
		 
		 
//echo "query4=$query4<br />";  //exit;		 
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);


while ($row4=mysqli_fetch_array($result4))
	{
	//$thumb[]=$row4['photo_location'];
	$Photo_location[]=$row4['photo_location'];
	$Comments2[]=$row4['comments2'];
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
echo "<body>";
if($submit=='Forward'){$j++ ;}
if($submit=='Back'){$j-- ;}
//echo "line 98: j=$j<br />";
if($j > $slideshow_records-1){$j=$j-1;}
if($j < 0){$j=0;}
echo "<table align='center'>";
echo "<tr><th>Slideshow</th></tr>";
echo "<tr>";
/*
echo "<td align='center'><img src='$Photo_location[$j]'  width='202' height='135' /><br /><a href='slideshow1a.php' target='_blank'>$Comments2[$j]</a></td>";
*/
echo "<td align='center'><img src='$Photo_location[$j]'  width='202' height='135' title='weymouth woods' /><br /><a href='slideshow1a.php' target='_blank'><br />Play</a></td>";



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




/*
echo "<table border=0 align='center'><tr>";

echo "<td align='center' onMouseOver=\"this.bgColor='lightgreen'\" onMouseOut=\"this.bgColor='lightcyan'\">
<form method='post' action='slideshow1.php'>
<input type='submit' name='submit' value='Back'>
<input type='hidden' name='j' value='$j'>
</form>
</td>";


echo "<td align='center'>
<form method='post' action='slideshow1.php'>
<input type='submit' name='submit' value='Forward'>
<input type='hidden' name='j' value='$j'>
</form>
</td>";



echo "</tr></table>";
*/





