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

echo "<table border='1'><tr>";
echo "<th><img height='50' width='50' src='/budget/wake_tech/images/wheelhouse.png' alt='picture of wheelhouse'></img></th></tr></table>";


$query4="select property.id,property.id_label,property_photos.label,property_photos.comments,
         property_photos.photo_location
         from property_photos
		 left join property on property_photos.id_property=property.id
         where 1 and property_photos.label='full_view'
         order by property_photos.id desc ";
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);


while ($row4=mysqli_fetch_array($result4))
	{
	$thumb[]=$row4['photo_location'];
	$description[]=$row4['id_label'];
	$id[]=$row4['id'];
	}	



 
echo "<table cellpadding = '10' border = '1' align='center'>
 
<tr>
<th colspan='5'> Icons</th>
</tr>";
 

 
$a=$b=$k=0;
$items=4;
$row_num=6;
 
//j<8 because we want to create 8 rows in this table
for ($j=0;$j<$row_num;$j++){
 
//creating the row of <span class="IL_AD" id="IL_AD8">picture</span> thumbnails
    if(($k%2)==0){     
        echo "<tr bgcolor='pink'>";
        for ($i=0;$i<$items;$i++)
        {
            echo "<td>";
            echo "<a href='home2.php?id=$id[$a]'><img src='$thumb[$a]' width='100'></a>";
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
            echo "{$description[$b]}";
            echo "</td>";
            $b++;
        }
        echo "</tr>";
        
   }//else end
    
 $k++;
}//outer for
 echo "</table>";
?>	
