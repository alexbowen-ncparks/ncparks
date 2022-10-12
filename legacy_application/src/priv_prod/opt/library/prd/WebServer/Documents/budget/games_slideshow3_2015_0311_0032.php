<?php
/*
session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: https://10.35.152.9/login_form.php?db=budget");
header("location: https://10.35.152.9/login_form.php?db=budget");
}
*/
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}




extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level=='5' and $tempID !='Dodd3454')
//echo "pcode=$pcode";
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database 


//include("../../budget/menu1314.php");
$query1="select gid from games where headline='y' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysql_fetch_array($result1);
extract($row1);



$query4="select gid,game_name,overview,author,status,image_location
         from games
		 where 1
		 and status='show'
		 and gid='$gid'
         order by games.game_name asc ";
		 
		 
//echo "query4=$query4<br />";		 
		 
$result4 = mysql_query($query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysql_num_rows($result4);


while ($row4=mysql_fetch_array($result4))
	{
	//$thumb[]=$row4['photo_location'];
	$MySlides[]=$row4['game_name'];
	$picture[]=$row4['image_location'];
	$Overview[]=$row4['overview'];
	$Gid[]=$row4['gid'];
	//$MyComments[]=$row4['comments2'];
	//$label[]=$row4['label'];
	//$id[]=$row4['id'];
	}	
//echo "<pre>"; print_r($MySlides); echo "</pre>";  //exit;
//echo "<pre>"; print_r($MyComments); echo "</pre>";  //exit;
//echo "<pre>"; print_r($picture); echo "</pre>";  //exit;

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
//echo "<td align='center'><img src='$MySlides[$j]'  width='200' height='200' /></td>";
echo "<th align='center'>$MySlides[$j]</th>";
echo "</tr>";

echo "<tr><td><img src='$picture[$j]' width='200'></td></tr>";

echo "<tr>";
//echo "<p align='center'><img src='$photo_location[$j]'  width='200' height='200' /><p>";
echo "<td align='center'>$Overview[$j]</td>";
echo "</tr>";
//echo "<td align='center'><a href='games.php?gid2=$Gid[$j]&gidS=none'>Play Gid$Gid[$j]</a></td>";
echo "<tr>";
echo "<td align='center' onMouseOver=\"this.bgColor='lightgreen'\" onMouseOut=\"this.bgColor='lightcyan'\"><a href='/budget/games/multiple_choice/games.php?gid2=$Gid[$j]&gidS=none'>Play</a></td>";
echo "</tr>";
echo "</table>";


//echo "line 105: j=$j<br />";


//exit;









