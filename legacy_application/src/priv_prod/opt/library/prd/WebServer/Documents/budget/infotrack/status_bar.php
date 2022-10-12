<?php
/*
session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: /login_form.php?db=budget");
}
*/
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

$file = "articles_menu.php";
$lines = count(file($file));


$table="infotrack_projects";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];
$pcode=$_SESSION['budget']['select'];



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
//echo "f_year=$f_year";

$query_ws1="truncate table infotrack_projects_community_ws";

$result_ws1=mysqli_query($connection, $query_ws1) or die ("Couldn't execute query_ws1. $query_ws1");


$query_ws2="insert into infotrack_projects_community_ws(project_note_id,finished)
select project_note_id,count(comment_id)
from infotrack_projects_community_com2
where status='fi'
group by project_note_id";

$result_ws2=mysqli_query($connection, $query_ws2) or die ("Couldn't execute query_ws2. $query_ws2");


$query_ws3="insert into infotrack_projects_community_ws(project_note_id,total)
select project_note_id,count(comment_id)
from infotrack_projects_community_com2
where 1
group by project_note_id";

$result_ws3=mysqli_query($connection, $query_ws3) or die ("Couldn't execute query_ws3. $query_ws3");


$query_ws4="truncate table infotrack_projects_community_ws2";

$result_ws4=mysqli_query($connection, $query_ws4) or die ("Couldn't execute query_ws4. $query_ws4");


$query_ws5="insert into infotrack_projects_community_ws2(project_note_id,finished,total)
select project_note_id,sum(finished),sum(total)
from infotrack_projects_community_ws
where 1
group by project_note_id";

$result_ws5=mysqli_query($connection, $query_ws5) or die ("Couldn't execute query_ws5. $query_ws5");

$query_ws6="update infotrack_projects_community,infotrack_projects_community_ws2
set infotrack_projects_community.complete=infotrack_projects_community_ws2.finished,
infotrack_projects_community.total=infotrack_projects_community_ws2.total
where infotrack_projects_community.project_note_id=infotrack_projects_community_ws2.project_note_id";

$result_ws6=mysqli_query($connection, $query_ws6) or die ("Couldn't execute query_ws6. $query_ws6");

$query_ws7="update infotrack_projects_community
set percomp=complete/total*100
where 1";

$result_ws7=mysqli_query($connection, $query_ws7) or die ("Couldn't execute query_ws7. $query_ws7");



$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from infotrack_customformat
WHERE 1 and user_id='$tempID'
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

$query11="SELECT filegroup,report_name
from infotrack_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);



//echo "<br />";
//include ("report_header3.php");
//include ("report_header2.php");

//echo "</head>";
//include("report_header1.php");
//echo "<br />";

//include("../../budget/menu1314.php");

$query4="select * from infotrack_projects_community where 1 order by project_note_id desc";

//echo $query4;exit;		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);

$total_alerts=$closed+$open;
$perc_comp=round(($closed/($closed+$open)*100));
//echo $perc_comp;

$width=200;
//$perc_comp=80;
//$color="lightgreen";
//$background="lightpink";

?>

<script language="javascript"> 
  // drawPercentBar()
  // Written by Matthew Harvey (matt AT unlikelywords DOT com)
  // (http://www.unlikelywords.com/html-morsels/)
  // Distributed under the Creative Commons 
  // "Attribution-NonCommercial-ShareAlike 2.0" License
  // (http://creativecommons.org/licenses/by-nc-sa/2.0/)
  function drawPercentBar(width, percent, color, background) 
  { 
    var pixels = width * (percent / 100); 
    
	
    if (!background) { background = "none"; }
 
    document.write("<div style=\"position: relative; line-height: 1em; background-color: " +                
	background + "; border: 1px solid black; width: "
                	+ width + "px\"  > "); 
				   
			   
				   
    document.write("<div style=\"height: 1.5em; width: " + pixels + "px; background-color: "
                   + color + ";\"></div>"); 
				   
				   
    document.write("<div style=\"position: absolute; text-align: center; padding-top: .25em; width:" 
                   + pixels + "px; top: 0; left: 0\">" + percent + "%</div>"); 
				   

    document.write("</div>"); 
  } 
  

</script>


<?php
//if($level=='5' and $submit=='add')

//echo $location;

echo "<table border=1>";
//echo "<br />";
echo "<tr>";
//echo "<th><font color='brown'>Location</font></th>";
echo "<th><font color='brown'>Location</font></th>";
echo "<th><font color='brown'>Project</font></th>";
echo "<th><font color='brown'>Tasks Complete</font></th>";
echo "<th><font color='brown'>Percent Complete</font></th>";
echo "</tr>";

//echo "<table border=1>";

//echo "<tr><td><font color='brown'>WebPages:</font><font color='red'> $num4 </font></td></tr>";


while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);
$countid=number_format($countid,0);
$rank=$rank+1;
$rank2="(".$rank.")";
$percomp=round($percomp);
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($percomp=="100.00"){$bgc="lightgreen";} else {$bgc="lightpink";}

echo 

"<tr bgcolor='$bgc'>"; 
//echo "<td>$rank2</td>";  
//echo "<td>$location</td>";
//echo "<td><a href='$weblink' target='_blank'>$project_note</a></td>";
//echo "<td></td><td></td>"; 

echo "<td>$location</td><td><a href='project1_menu_web.php?comment=y&add_comment=y&folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group&project_note_id=$project_note_id&location=$location'>$project_note</a></td>"; 
echo "<td>$complete of $total</td>";
?>
<?php
echo "<td>";?>

<script language="javascript">drawPercentBar(<?php echo $width ?>, <?php echo $percomp ?>, 'lightgreen','red'); </script> 
<?php
echo "</td>";	          
echo "</tr>";

}

 echo "</table>";
 echo "</body>";
 echo "</html>";
 
 

 ?>
 