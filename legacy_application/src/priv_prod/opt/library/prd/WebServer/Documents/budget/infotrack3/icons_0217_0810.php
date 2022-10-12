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

echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js'></script>
<script type='text/javascript' src='slideshow.js'></script>
<link rel='stylesheet' href='slideshow.css' />";


echo "</head>";



$query4="select *
         from mission_icon_photos
		 where 1
         order by mission_icon_photos.id desc ";
		 
		 
echo "query4=$query4<br />";		 
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);


while ($row4=mysqli_fetch_array($result4))
	{
	//$thumb[]=$row4['photo_location'];
	$description[]=$row4['photo_location'];
	$id[]=$row4['id'];
	}	

echo "<body>";
echo "<p id='slideshow'>";
echo "div id='container'>";
echo "<ul>";

 
 
//$a=$b=$k=0;
//$items=3;
//$row_num=48;
 
//j<8 because we want to create 8 rows in this table
for ($j=0;$j<$num4;$j++){
 
//creating the row of <span class="IL_AD" id="IL_AD8">picture</span> thumbnails
    //if(($k%2)==0){     
        //echo "<tr bgcolor='pink'>";
        //for ($i=0;$i<$items;$i++)
        //{
            //echo "<td>";
            //echo "<a href='home2.php?id=$id[$a]'><img src='$thumb[$a]' width='100'></a>";
            //echo "<a href='home2.php?id=$id[$a]'><img src='$thumb[$a]' width='100'></a>";
           // echo "<img src='$thumb[$a]' width='100'>";
			 //"<br />";
			echo "<li>$description[$j]<br /><img height='320' width='620' src='$description[$j]' /><a class='next blue' href='#slideshow'></a><a class='previous blue' href='#slideshow'></a></li>";
			//echo "<li><img height='320' width='620' src='$description[$j]' /><a class='next blue' href=='$description[$j]#slideshow'>next</a><a class='previous blue' href='#slideshow'>prev</a></li>";
			/*
			echo "<audio controls><source src='sounds/all_about_bass.ogg' type='audio/ogg' /></audio>";
			echo "<video controls><source src='sounds/small.ogv' type='video/ogg' /></audio>";
			*/
			
           // echo "</td>";
           // $a++;
       // }
       // echo "</tr>";
         
   }//if end
        
 //$k++;
//}//outer for
 echo "</ul>";
 echo "</body>";
 echo "</html>";
?>	
