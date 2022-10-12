<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){
header("location: https://10.35.152.9/login_form.php?db=budget");
}
//echo "hello world";exit;
if($concession_location== 'ADM'){$concession_location="admi";}
//echo "hello world";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

extract($_REQUEST);
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

/*
$comment="y";
$add_comment="y";
$folder="community";
$category_selected="y";
$name_selected="y";
$project_note_id="692";
$location="admi";
*/
//echo "project_note_id=$project_note_id";exit;
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database 
if($comment=='')
{



if($level<'3'){$location=$pcode;} 


if($location != ""){$where2=" and location = '$location' ";}
if(!isset($where2)){$where2="";}

$query4="select * from infotrack_projects_community where 1 $where2 order by project_note_id asc";

//echo $query4;exit;		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);
//echo "query4=$query4";exit;


		  

echo "<form method='post' action='alert_add.php' name='form2' onsubmit='return validateForm()' >";
//echo "<td><input type='text' name= 'alert_location' placeholder='kela,jord,etc'></input></td>";  
echo "<td><input name='location' type='text' placeholder='Location Code' value='$location' id='input1' autocomplete='off'></td><td><textarea name= 'alert_note' rows='1' cols='30' placeholder='Project Name' id='input2'></textarea></td>";            
      
	  echo "<td><input type=submit name=submit value=Add_Project></td>";
		   
	 echo "</form>";
echo "</tr>";
      
	 
echo "</table>";


echo "<br />";
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

echo "<td>$location</td><td><a href='note_tracker.php?comment=y&add_comment=y&folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group&project_note_id=$project_note_id&location=$location'>$project_note</a></td>"; 
echo "<td>$complete of $total</td>";
          
echo "</tr>";

}

 echo "</table>";
 echo "</body>";
 echo "</html>";
 }
 
if($comment=='y') 
//{echo "<font color='brown' size='5'>Oops:Comments feature is under Construction. Sorry for inconvenience<br /><br />Click the BACK button on your Browser to return to previous Page</font><br />";exit;}
 {

if($show_order==''){$order2="order by comment_id asc";}
if($show_order=='newest'){$order2="order by comment_id desc";}
if($show_order=='oldest'){$order2="order by comment_id asc";}


if($folder=='community')
{

$query4a="select project_note from infotrack_projects_community where project_note_id='$project_note_id' ";


//echo $query4a;echo "<br />";		 
$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");
$num4a=mysqli_num_rows($result4a);

if($level<'5')
{
$query4b="select * from infotrack_projects_community_com where 1 and park='$concession_location'  and project_note='$project_note' $order2 ";
}
else
{
//$query4b="select * from infotrack_projects_community_com where 1 and project_note_id='$project_note_id' $order2 ";

$query4b="select * from infotrack_projects_community_com where 1 and project_note='$project_note' $order2 ";



}

//echo "$query4b";		 
$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");
$num4b=mysqli_num_rows($result4b);
//echo "query4b=$query4b";//exit;


}
$row4a=mysqli_fetch_array($result4a);
extract($row4a);


echo "<table>";
echo "<tr>";
echo "<td><font color=brown class='cartRow'><a href='project1_menu_web.php?folder=community'>$project_note</a></font></td>";

echo "</tr>";
echo "</table>";
echo "<br />";


if($add_comment=='')
{
echo "<table><tr>";
echo "<td><a href='project1_menu.php?comment=y&add_comment=y&project_note_id=$project_note_id&folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group'>Add</a></td>";
echo "</tr></table>"; 
}

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

echo "<form method='post' action='/budget/infotrack/comment_add.php' name='form3' onsubmit='return validateForm()'  >";
if($level>'3')
{
echo "<td><input name='location' type='text'  value='$concession_location' autocomplete='off'></td>";
}

echo "<td><textarea name= 'comment_note' rows='6' cols='50' placeholder='Type Comment here' id='input3' ></textarea></td>";            
      
	  if($folder=='personal'){echo "<td><input type=submit name=submit value=Add_Note></td>";}
	  if($folder=='community'){echo "<td><input type=submit name=submit value=Add_Comment></td>";}
	  //echo "<input type='hidden' name='project_category' value='$project_category'>";	   
	 //echo "<input type='hidden' name='project_name' value='$project_name'>";	   
	 echo "<input type='hidden' name='project_note' value='$project_note'>";	   
	 //echo "<input type='hidden' name='weblink' value='$weblink'>";	   
	 echo "<input type='hidden' name='note_group' value='$note_group'>";	   
	 echo "<input type='hidden' name='folder' value='$folder'>";	   
	 echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";	   
	 echo "<input type='hidden' name='tempID' value='$tempID'>";	   
	 echo "<input type='hidden' name='concession_location' value='$concession_location'>";	   
	 echo "</form>";
echo "</tr>";
      
	 
echo "</table>";
}
//echo "<br />";


if($show_order==''){$shade_oldest="class=cartRow";}
if($show_order=='newest'){$shade_newest="class=cartRow";}
if($show_order=='oldest'){$shade_oldest="class=cartRow";}

//echo "shade_oldest=$shade_oldest";
echo "<table><tr>";
echo "<td><a href='/budget/games/multiple_choice/notes.php?comment=y&add_comment=y&project_note_id=$project_note_id&folder=$folder&category_selected=y&name_selected=y&show_order=newest'><font size='3' $shade_newest>Newest on top</font></a></td>";
echo "<td><a href='/budget/games/multiple_choice/notes.php?comment=y&add_comment=y&project_note_id=$project_note_id&folder=$folder&category_selected=y&name_selected=y&show_order=oldest'><font size='3' $shade_oldest>Newest on bottom</font></a></td>";

echo "</tr></table>"; 

echo "<br />";
if($message=='1'){echo "<font color='red' size='5'><b>Update Successful</b></font>";$message=="";}

echo "<table>";

echo "<tr>
<td><font color='brown'>Park</font></td>
<td><font color='brown'>User</font></td>
<td><font color='brown'>Date</font></td>
<td><font color='brown'>Comment</font></td>
<td><font color='brown'>Status</font></td>
<td><font color='brown'>ID</font></td>

</tr>";

echo  "<form method='post' autocomplete='off' action='/budget/infotrack/alert_comment_update.php'>";
while ($row4b=mysqli_fetch_array($result4b)){

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
 echo "<td><font color='brown'>$park</font></td>";
 echo "<td><font color='brown'>$user</font></td>";
 echo "<td>$system_entry_date</font></td>"; 
 echo "<td><textarea name='comment_note[]' cols='50' rows='6'>$comment_note</textarea></td> ";
//echo "<td>$comment_note</td>"; 
echo "<td><font color=$color><input type='text' size='1' name='status[]' value='$status'></font></td>";
//echo "<td><font color=$color><input type='text' size='1' name='show2park[]' value='$show2park'></font></td>";
echo "<td><input type='text' size='1' name='comment_id[]' value='$comment_id' readonly='readonly'</td>";
//echo "<td>$color</td>";


//echo "<td>$status</td>"; 

	          
echo "</tr>";

}
if($level=='5')
{
echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
}
echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";
echo "<input type='hidden' name='num4b' value='$num4b'>";
echo "<input type='hidden' name='project_note' value='$project_note'>";
echo   "</form>";
 echo "</table>";
 echo "</body>";
echo "</html>";
 }
 ?>
 