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



/*
if($report_type=='form'){$report_form="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($report_type=='reports'){$report_reports="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

echo "<style>
td {
    padding: 10px;
}

th {
    padding: 10px;
}



</style>";



echo "<br /><table align='center' border='1' align='left'><tr><th><font color='brown'>$project_name</font></th><th><a href='step_group.php?fyear=$fyear&report_type=reports'>Reports</a><br />$report_reports </th><th><a href='step_group.php?fyear=$fyear&report_type=form&reset=y'>Form</a><br />$report_form</th></tr></table>";

echo "<br />";
*/



//echo "<table border='1'><tr>";
echo "<table border='0'><tr>";
//echo "<th><img height='50' width='50' src='/budget/infotrack/icon_photos/property_photos_45.png' alt='picture of blue light bulb'></img></th></tr></table>";
//echo "<th><img height='100' width='200' src='/budget/infotrack/icon_photos/fives_on_red1.jpg' alt='picture of blue light bulb'></img></th></tr></table>";






$query4="select *
         from mission_icon_sounds_cc
		 where 1
         order by mission_icon_sounds_cc.id desc ";
		 
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
            //echo "<a href='home2.php?id=$id[$a]'><img src='$thumb[$a]' width='100'></a>";
            //echo "<a href='home2.php?id=$id[$a]'><img src='$thumb[$a]' width='100'></a>";
           // echo "<img src='$thumb[$a]' width='100'>";
		
			//echo "<audio controls><source src='$file_location[$a]' type='audio/mp3' /></audio>";
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
			echo "<tr><td>id: </td><td>$id[$b]</td></tr>";
			echo "<tr><td>file_location: </td><td>$file_location[$b]</td></tr>";
			echo "<tr><td>audio_type: </td><td>$audio_type[$b]</td></tr>";
			echo "<tr><td>source_name: </td><td>$source_name[$b]</td></tr>";
			echo "<tr><td>source_link: </td><td>$source_link[$b]</td></tr>";
			echo "<tr><td>author_name: </td><td>$author_name[$b]</td></tr>";
			echo "<tr><td>author_link: </td><td>$author_link[$b]</td></tr>";
			echo "<tr><td>license: </td><td>$license[$b]</td></tr>";
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
