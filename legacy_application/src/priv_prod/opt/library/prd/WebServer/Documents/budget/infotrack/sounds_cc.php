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


include("../../budget/menu1314.php");
echo "<br />";
include("menu_add_sounds_cc.php"); // connection parameters
//echo "Line 61"; exit;

echo "<table border='0'><tr>";



$query4="select *
         from mission_icon_sounds_cc
		 where 1
         order by mission_icon_sounds_cc.id desc ";
		 
echo "<br />query4=$query4<br />";		 
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);




while ($row4=mysqli_fetch_array($result4))
	{
	$id[]=$row4['id'];
	$file_location[]=$row4['file_location'];
	$audio_type[]=$row4['audio_type'];
	$source_name[]=$row4['source_name'];
	$source_link[]=$row4['source_link'];
	$author_name[]=$row4['author_name'];
	$author_link[]=$row4['author_link'];
	$license[]=$row4['license'];
		}	

echo "<table cellpadding = '10' border = '1' align='center'>
 
<tr>
<th colspan='5'>Sounds</th>
</tr>";
  
$a=$b=$k=0;
$items=3;
$row_num=100;
 
//j<8 because we want to create 8 rows in this table
for ($j=0;$j<$row_num;$j++){
 
//creating the row of <span class="IL_AD" id="IL_AD8">picture</span> thumbnails
    if(($k%2)==0){     
        echo "<tr bgcolor='pink'>";
        for ($i=0;$i<$items;$i++)
        {
            echo "<td>";
            
		
			echo "<audio controls><source src='$file_location[$a]' type='audio/$audio_type[$a]' /></audio>";
			//echo "<video controls><source src='sounds/small.ogv' type='video/ogg' /></audio>";
			
			
            echo "</td>";
            $a++;
        }
        echo "</tr>";
         
   }//if end
    
 //Creating Row for Picture Description
   else{
       echo "<tr bgcolor=''>";
        for ($i=0;$i<$items;$i++)
        {
            echo "<td>";
			echo "<table>";
			echo "<tr>";
			echo "<td>";
			echo "<font color='red'>TableID:</font>$id[$b]";
			echo "</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>";
            echo "<font color='red'>AudioType:</font>$audio_type[$b]";
			echo "</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>";
            echo "<font color='red'>Title:</font><font color='blue'>$source_name[$b]</font>";
			echo "</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>";
			echo "<font color='red'>Author:</font>$author_name[$b]";
			echo "</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>";
			echo "<font color='red'>AuthorLink:</font>$author_link[$b]";
			echo "</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>";
			echo "<font color='red'>SourceLink:</font>$source_link[$b]";
			echo "</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>";
			echo "<font color='red'>License:</font>$license[$b]";
			echo "</td>";
			echo "</tr>";			
			echo "</table>";			
            echo "</td>";
            $b++;
        }
        echo "</tr>"; 
        
   }//else end
    
 $k++;
}//outer for
 echo "</table>";

?>	
