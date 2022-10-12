<?php
/*
session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: https://10.35.152.9/login_form.php?db=budget");
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
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database 
//echo "f_year=$f_year";

$query_ws1="truncate table missions_ws";

$result_ws1=mysql_query($query_ws1) or die ("Couldn't execute query_ws1. $query_ws1");


$query_ws2="insert into missions_ws(mission_id,finished)
select mission_id,count(comment_id)
from missions2
where status='fi'
group by mission_id";

$result_ws2=mysql_query($query_ws2) or die ("Couldn't execute query_ws2. $query_ws2");


$query_ws3="insert into missions_ws(mission_id,total)
select mission_id,count(comment_id)
from missions2
where 1
group by mission_id";

$result_ws3=mysql_query($query_ws3) or die ("Couldn't execute query_ws3. $query_ws3");


$query_ws4="truncate table missions_ws2";

$result_ws4=mysql_query($query_ws4) or die ("Couldn't execute query_ws4. $query_ws4");


$query_ws5="insert into missions_ws2(mission_id,finished,total)
select mission_id,sum(finished),sum(total)
from missions_ws
where 1
group by mission_id";

$result_ws5=mysql_query($query_ws5) or die ("Couldn't execute query_ws5. $query_ws5");

$query_ws6="update missions,missions_ws2
set missions.complete=missions_ws2.finished,
missions.total=missions_ws2.total
where missions.mission_id=missions_ws2.mission_id";

$result_ws6=mysql_query($query_ws6) or die ("Couldn't execute query_ws6. $query_ws6");

$query_ws7="update missions
set percomp=complete/total*100
where 1";

$result_ws7=mysql_query($query_ws7) or die ("Couldn't execute query_ws7. $query_ws7");



$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from infotrack_customformat
WHERE 1 and user_id='$tempID'
";

$result10=mysql_query($query10) or die ("Couldn't execute query 10. $query10");

$row10=mysql_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

$query11="SELECT filegroup,report_name
from infotrack_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysql_query($query11) or die ("Couldn't execute query 11. $query11");

$row11=mysql_fetch_array($result11);

extract($row11);



//echo "<br />";
//include ("report_header3.php");
//include ("report_header2.php");

//echo "</head>";
//include("report_header1.php");
//echo "<br />";

include("../../budget/menu1314.php");


echo "<table><tr><th>$pcode Missions</th></tr><tr><th>Under Construction</th></tr></table>";
if($level < '5' and $beacnum != '60032984' ) {exit;}


//echo"<html><head><title>Missions</title>";
//include ("report_header4.php");
//include ("test_style.php");
//include ("percent_bar.js");


if($comment=='')
{

//if($folder=='community')
//{


if($level<'3'){$location=$pcode;} 


if($location != ""){$where2=" and location = '$location' ";}
if(!isset($where2)){$where2="";}






$query4="select * from missions where 1 $where2 order by mission_id desc";

//echo $query4;exit;		 
$result4 = mysql_query($query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysql_num_rows($result4);
//echo "query4=$query4";exit;


		  
//echo "query3h=$query3h<br />";		  
		  
		  

//echo "open=$open";

//}

//echo "<html>";






echo "</head>

<body>
<!--
<div style='position:relative;width:100%;height:100%; margin-top:0px;margin-bottom:0px;background-color:darkseagreen; '>
-->

<!--
<div style='position:relative;width:100%;height:40%; margin-top:0px;margin-bottom:0px;background-color:light grey; '>
-->
";

/*

if($level>1)
{
echo
"<div style='position:relative;width:30%;height:10%;'> 
     <a href='http:/budget/home.php'>
	<img width='100%' height='100%' src='nrid_logo.jpg' alt='mamajo.net' style='border:0;margin-top:5px;' /></a>
</div>";
}
else
{
echo
"<div style='position:relative;width:30%;height:10%;'> 
     <a href='http:/budget/mymoneycounts.php'>
	<img width='100%' height='100%' src='nrid_logo.jpg' alt='mamajo.net' style='border:0;margin-top:5px;' /></a>
</div>";
}

*/




//$original_date = '20110408';
//echo date('m-d-y', strtotime($original_date));
//echo "<br />";
//echo "<table>";
//echo "<tr><th>Location</th></tr>";
//echo "<tr>";


echo "
<script language='javascript' type='text/javascript'>
      window.onload = function() {
      document.getElementById('input1').focus();
}

function validateForm()
{
var x=document.forms['form1']['input1'].value;
if (x==null || x=='')
  {
  alert('Please enter Location');
  return false;
  }
}

</script>
";

/*
echo "<form method='post' action='missions.php?folder=community' name='form1' onsubmit='return validateForm()'>";
echo "<td><input name='location' type='text' placeholder='kela,jord,etc.' value='$location' id='input1' autocomplete='off'></td>";
echo "<td><input type='submit' name='submit' value='search'></td>";
echo "<td><input type='submit' name='submit' value='add'></td>";
echo "</form>";
*/

//echo "<td>";
//echo "</tr>";
//echo "</table>";
//echo "<br />";
/*
echo "<table border=1>";
//echo "<tr><th>Alerts</th><th>Count</th></tr>";
echo "<tr bgcolor='lightgreen'><td>Closed</td><td>$closed</td></tr>";
echo "<tr bgcolor='lightpink'><td>Open</td><td>$open</td></tr>";
echo "</table><br />";
*/
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

if($level=='5')
{
echo "<table>";
echo "<tr>";
//echo "<th><font color='brown'>Comment</font></th>";
echo "</tr>";



echo "<script language='javascript' type='text/javascript'>
      window.onload = function() {
      document.getElementById('input2').focus();
}

function validateForm()
{
var x=document.forms['form2']['input1'].value;
var y=document.forms['form2']['input2'].value;
if (x==null || x=='')
  {
  alert('Please enter Location');
  return false;
  }
 if (y==null || y=='')
  {
  alert('Please enter Mission Name');
  return false;
  } 
  
  
}


</script>";

echo "<br />";
//echo "<td></td>";
echo "<form method='post' action='mission_add.php' name='form2' onsubmit='return validateForm()' >";
//echo "<td><input type='text' name= 'alert_location' placeholder='kela,jord,etc'></input></td>";  
echo "<td><input name='location' type='text' placeholder='Location Code' value='$location' id='input1' autocomplete='off'></td><td><textarea name= 'alert_note' rows='1' cols='30' placeholder='Mission Name' id='input2'></textarea></td>";            
      
	  echo "<td><input type=submit name=submit value=Add_Mission></td>";
	  //echo "<input type='hidden' name='location' value='$location'>";	   
	// echo "<input type='hidden' name='project_name' value='$project_name'>";	   
	// echo "<input type='hidden' name='project_note' value='$project_note'>";	   
	 //echo "<input type='hidden' name='weblink' value='$weblink'>";	   
	// echo "<input type='hidden' name='note_group' value='$note_group'>";	   
	// echo "<input type='hidden' name='folder' value='$folder'>";	   
	// echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";	   
	 echo "</form>";
echo "</tr>";
      
	 
echo "</table>";
}


echo "<br />";
echo "<table border=1>";
//echo "<br />";
echo "<tr>";
//echo "<th><font color='brown'>Location</font></th>";
if($level > '1')
{
echo "<th><font color='brown'>Location</font></th>";
}
echo "<th><font color='brown'>Mission</font></th>";
//echo "<th colspan='2'><font color='brown'>Status Complete</font></th>";
echo "<th><font color='brown'>Status</font></th>";
//echo "<th><font color='brown'>Status</font></th>";
echo "</tr>";

//echo "<table border=1>";

//echo "<tr><td><font color='brown'>WebPages:</font><font color='red'> $num4 </font></td></tr>";


while ($row4=mysql_fetch_array($result4)){

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
if($level > '1')
{
echo "<td>$location</td>";
}


echo "<td>";

if($mission_location=='')
{
echo "<a href='missions.php?comment=y&add_comment=y&mission_id=$mission_id&location=$location'>$mission_name</a>";
}
else
{
echo "<a href='$mission_location'>$mission_name</a>";
}

echo "</td>"; 




//echo "<td>$complete of $total</td>";
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
 }
 
if($comment=='y') 
//{echo "<font color='brown' size='5'>Oops:Comments feature is under Construction. Sorry for inconvenience<br /><br />Click the BACK button on your Browser to return to previous Page</font><br />";exit;}
 {

if($show_order==''){$order2="order by comment_id desc";}
if($show_order=='newest'){$order2="order by comment_id desc";}
if($show_order=='oldest'){$order2="order by comment_id asc";}




$query4a="select mission_name from missions where mission_id='$mission_id' ";

//echo $query4a;echo "<br />";		 
$result4a = mysql_query($query4a) or die ("Couldn't execute query 4a.  $query4a");
$num4a=mysql_num_rows($result4a);


$query4b="select * from missions2 where 1 and mission_id='$mission_id' $order2 ";

//echo "$query4b";		 
$result4b = mysql_query($query4b) or die ("Couldn't execute query 4b.  $query4b");
$num4b=mysql_num_rows($result4b);
//echo "query4b=$query4b";//exit;



$row4a=mysql_fetch_array($result4a);
extract($row4a);
/*
echo "<table>";
echo "<tr>";
echo "<td><font color=brown class='cartRow'><a href='missions.php?folder=community'>Missions</a></font></td>";

echo "</tr>";
echo "</table>";
*/



echo "<br />";


echo "<table>";
echo "<tr>";
echo "<td><font color=brown class='cartRow'>$mission_name</font></td>";

echo "</tr>";
echo "</table>";
echo "<br />";

/*
if($add_comment=='')
{
echo "<table><tr>";
echo "<td><a href='project1_menu.php?comment=y&add_comment=y&project_note_id=$project_note_id&folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group'>Add</a></td>";
echo "</tr></table>"; 
}

*/

if($add_comment=='y')
{


echo "<table>";
echo "<tr>";
//echo "<th><font color='brown'>Comment</font></th>";
echo "</tr>";

//echo "<td></td>";

echo "<script language='javascript' type='text/javascript'>
      window.onload = function() {
      document.getElementById('input3').focus();
}

function validateForm()
{
var x=document.forms['form3']['input3'].value;
if (x==null || x=='')
  {
  alert('Please enter Comment');
  return false;
  }
}

</script>


";

echo "<form method='post' action='mission_task_add.php' name='form3' onsubmit='return validateForm()'  >";
//echo "line540";
echo "<td><textarea name= 'comment_note' rows='4' cols='50' placeholder='Type Task here' id='input3' ></textarea></td>";            
      
	  if($folder=='personal'){echo "<td><input type=submit name=submit value=Add_Note></td>";}
	  if($folder=='community'){echo "<td><input type=submit name=submit value=Add_Task></td>";}
	  echo "<input type='hidden' name='project_category' value='$project_category'>";	   
	 echo "<input type='hidden' name='project_name' value='$project_name'>";	   
	 echo "<input type='hidden' name='project_note' value='$project_note'>";	   
	 //echo "<input type='hidden' name='weblink' value='$weblink'>";	   
	 echo "<input type='hidden' name='note_group' value='$note_group'>";	   
	 echo "<input type='hidden' name='folder' value='$folder'>";	   
	 echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";	   
	 echo "</form>";
echo "</tr>";
      
	 
echo "</table>";
}
//echo "<br />";


if($show_order==''){$shade_newest="class=cartRow";}
if($show_order=='newest'){$shade_newest="class=cartRow";}
if($show_order=='oldest'){$shade_oldest="class=cartRow";}

//echo "shade_oldest=$shade_oldest";
echo "<table><tr>";

echo "<td><a href='missions.php?comment=y&add_comment=y&mission_id=$mission_id&show_order=newest'><font size='3' $shade_newest>Newest on top</font></a></td>";

echo "<td><a href='missions.php?comment=y&add_comment=y&mission_id=$mission_id&show_order=oldest'><font size='3' $shade_oldest>Newest on bottom</font></a></td>";

echo "</tr></table>"; 

echo "<br />";
if($message=='1'){echo "<font color='red' size='5'><b>Update Successful</b></font>";$message=="";}

echo "<table>";
/*
echo "<tr>
<td align='center'><font color='brown'>Date</font></td>
<td align='center'><font color='brown'>Title</font></td>
<td align='center'><font color='brown'>Comment</font></td>
<td align='center'><font color='brown'>Status</font></td>
<td align='center'><font color='brown'>ID</font></td>
</tr>";
*/
/*
echo "<tr>
<td align='center'><font color='brown'>Date</font></td>
<td align='center'><font color='brown'>Task</font></td>
<td align='center'><font color='brown'>Status</font></td>
<td align='center'><font color='brown'>ID</font></td>
</tr>";
*/


echo "<tr>
<td align='center'><font color='brown'>Task</font></td>
<td align='center'><font color='brown'>Status</font></td>
<td align='center'><font color='brown'>ID</font></td>
</tr>";


echo  "<form method='post' autocomplete='off' action='mission_task_update.php'>";
while ($row4b=mysql_fetch_array($result4b)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4b);
$countid=number_format($countid,0);
$rank=$rank+1;

if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
$user=substr($user,0,-2);
//if($status=='fi'){$color='light green';}else{$color='light pink';}
if($status=="fi"){$bgc="lightgreen";} else {$bgc="lightpink";}

echo "<tr bgcolor='$bgc'>"; 
//echo "<tr$t>"; 
//echo "<td>$rank</td>";
 
 //echo "<td><font color='brown'>$user</font></td>";
 //echo "<td>$system_entry_date</font></td>"; 
 //echo "<td><font color='blue'>$comment_title</font></td>"; 
 echo "<td><textarea name='comment_note[]' cols='50' rows='4'>$comment_note</textarea></td> ";
//echo "<td>$comment_note</td>"; 
echo "<td><font color=$color><input type='text' size='1' name='status[]' value='$status'></font></td>";
echo "<td><input type='text' size='1' name='comment_id[]' value='$comment_id' readonly='readonly'</td>";
echo "<td>$color</td>";


//echo "<td>$status</td>"; 

	          
echo "</tr>";

}
echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";
echo "<input type='hidden' name='num4b' value='$num4b'>";
echo   "</form>";
 echo "</table>";
 echo "</body>";
echo "</html>";
 }
 ?>
 