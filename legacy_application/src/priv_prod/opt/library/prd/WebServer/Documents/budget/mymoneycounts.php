<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

extract($_REQUEST);



//echo $concession_location;

//if($level=='5' and $tempID !='Dodd3454')
//{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
//}
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../budget/~f_year.php");


//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}
/*
if($level=='5' and $tempID !='Dodd3454')
{

echo "beacon_number:$beacnum";
echo "<br />";
echo "concession_location:$concession_location";
echo "<br />";
echo "concession_center:$concession_center";
echo "<br />";
}
*/
$table="energy_reports";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;
/*
if($level=='5' and $tempID !='Dodd3454')
{
echo "body_bg:$body_bg";
echo "<br />";
echo "table_bg:$table_bg";
echo "<br />";
echo "table_bg2:$table_bg2";
}
*/

/*
$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
*/
echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>
<title>MyMoneyCounts</title>";

include ("test_style.php");
//include ("test_style.php");

echo "</head>";
echo "<body id='home'>
        <div id='page'>		
        <div id='header'>
		<a href='/budget/home.php'>
		<img width='50%' height='20%' src='nrid_logo.jpg' alt='roaring gap photos'></img>
		</a>
		</div>";

//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";




$query4="SELECT distinct postitle
         FROM activity_1213_summary
         WHERE tempid='$tempid'
		 ";	
	
//echo "query5=$query5";
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
//$num4=mysqli_num_rows($result4);
$row4=mysqli_fetch_array($result4);
extract($row4);


$query5="SELECT application,filename,postitle,sum(filecount) as 'filecount'
         FROM activity_1213_summary
         WHERE tempid='$tempid'
		 group by application,filename
	     order by filecount desc ";	
	
//echo "query5=$query5";
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);


$query5_total="SELECT sum(filecount) as 'total_count'
	           FROM activity_1213_summary
	           WHERE tempid='$tempid' ";

$result5_total = mysqli_query($connection, $query5_total) or die ("Couldn't execute query 5.  $query5");

	


echo "<table border=5 cellspacing=5>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

//echo "<th align=left><A href='articles_community_edit.php'>Download from Community</A></th><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th>";
//echo "<tr><th align=left><A href='articles_community_edit.php'>Community</A></th></tr>";
//echo "<tr><th><A href='document_add.php?&project_category=$project_category&add_your_own=y'>Add your own</A></th></tr>";	
$player=substr($tempid,0,-4);
 	  
echo "</table>";
echo "<h2 ALIGN=left><font color=brown class=cartRow>$concession_location-$player-Level$level-$postitle</font></h2>";
echo "<h2 ALIGN=left><font color=brown class=cartRow>Applications:$num5</font></h2>";

echo "<table border=1>";

echo 

"<tr>"; 
echo "<th align=left><font color=brown>Applications</font></th>";
echo "<th align=left><font color=brown>Filename</font></th>";
echo "<th align=left><font color=brown>Filecount</font></th>";
              
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row5=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row5);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

echo "<td>$application</td>";
echo "<td><a href='$filename'>$filename</a></td>";
echo "<td>$filecount</td>";                
      
           
              
           
echo "</tr>";




}


while ($row5_total=mysqli_fetch_array($result5_total)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row5_total);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>

           
           <td></td>
           <td></td>
           <td>$total_count</td>
                    
      
           
              
           
</tr>";


}

 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
echo "</div>";
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
//echo "</html>";

?>



















	














