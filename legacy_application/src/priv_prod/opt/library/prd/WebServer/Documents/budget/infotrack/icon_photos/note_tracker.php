<?php

session_start();

//echo "<pre>";print_r($_SESSION);"</pre>";exit;

if(!$_SESSION["budget"]["tempID"]){
header("location: /login_form.php?db=budget");
}
//echo "hello world";exit;
if($concession_location== 'ADM'){$concession_location="admi";}
//echo "hello world";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters

extract($_REQUEST);
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
/*
if($beacnum=='60032793')
{
echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
}
*/
//echo "pcode=$pcode";
//echo "tempID=$tempID";
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
if($comment_read_id != '')
{
$todays_date=date("Y-m-d");
$query1="update infotrack_projects_community_com
         set message_read='y',message_read_date='$todays_date',message_reader='$tempID',status='fi' where comment_id='$comment_read_id' ";
		 
//echo "query1=$query1<br />";exit;		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);
}

if($comment=='')
{



if($level<'3'){$location=$pcode;} 


if($location != ""){$where2=" and location = '$location' ";}
if(!isset($where2)){$where2="";}

$query4="select * from infotrack_projects_community where 1 $where2 order by project_note_id asc";

//echo $query4;//exit;		 
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

if($show_order==''){$order2="order by system_entry_date desc, comment_id desc";}
if($show_order=='newest'){$order2="order by system_entry_date desc, comment_id desc";}
if($show_order=='oldest'){$order2="order by system_entry_date asc, comment_id asc";}


if($folder=='community')
{

$query4a="select project_note from infotrack_projects_community where project_note_id='$project_note_id' ";


//echo $query4a;echo "<br />";		 
$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");
$num4a=mysqli_num_rows($result4a);
/*
if($level<'5')
{
$query4b="select * from infotrack_projects_community_com where 1 and (park='$concession_location' or park='dpr') and project_note='$project_note' $order2 ";
}
else
{

$query4b="select * from infotrack_projects_community_com where 1 and project_note='$project_note' $order2 ";

}
*/

$today=date("Y-m-d");

$query4aa="update infotrack_projects_community_com set system_entry_date='$today'
           where alert='y' and status='ip' and original_entry_date < '$today' ";
		   
//echo "query4aa=$query4aa";

$result4aa = mysqli_query($connection, $query4aa) or die ("Couldn't execute query 4aa.  $query4aa");


$query4ab="update infotrack_projects_community_com set days_elapsed=datediff(system_entry_date,original_entry_date)
where alert='y' and status='ip'  ";

$result4ab = mysqli_query($connection, $query4ab) or die ("Couldn't execute query 4ab.  $query4ab");



if($level==2 and $concession_location=='NODI'){$dist_where=" and (dist='north' and fund='1280' and actcenteryn='y' and center.parkcode != 'mtst' and center.parkcode != 'harp' and infotrack_projects_community_com.alert='y' and park != 'nodi') or (park='nodi' and fund='1280' and actcenteryn='y') or (park='dpr') ";}

if($level==2 and $concession_location=='EADI'){$dist_where=" and (dist='east' and fund='1280' and actcenteryn='y' and infotrack_projects_community_com.alert='y' and park != 'eadi') or (park='eadi' and fund='1280' and actcenteryn='y') or (park='dpr')
 ";}

if($level==2 and $concession_location=='SODI'){$dist_where=" and (dist='south' and fund='1280' and actcenteryn='y' and center.parkcode != 'boca' and infotrack_projects_community_com.alert='y' and park != 'sodi') or (park='sodi' and fund='1280' and actcenteryn='y') or (park='dpr') ";}

if($level==2 and $concession_location=='WEDI'){$dist_where=" and (dist='west' and fund='1280' and actcenteryn='y' and infotrack_projects_community_com.alert='y' and park != 'wedi') or (park='wedi' and fund='1280' and actcenteryn='y') or (park='dpr') ";}


if($level==2){$dist_join=" left join center on infotrack_projects_community_com.park=center.parkcode ";}


if($level==2)
{
$query4b="select * from infotrack_projects_community_com
$dist_join
 where 1 and system_entry_date <= '$today'
 $dist_where
 $order2 ";
//echo "query4b=$query4b";
}








if($level=='1')
{
$query4b="select * from infotrack_projects_community_com where 1 and system_entry_date <= '$today' and (park='$concession_location' or park='dpr')  $order2 ";
$query4b_under_review="select count(comment_id) as 'under_review' from infotrack_projects_community_com where 1 and system_entry_date <= '$today' and (park='$concession_location' or park='dpr') and message_read='n' ";
$result4b_under_review = mysqli_query($connection, $query4b_under_review) or die ("Couldn't execute query 4b under review.  $query4n_under_review");

$row4b_under_review=mysqli_fetch_array($result4b_under_review);
extract($row4b_under_review);
}


if($level=='3')
{
$query4b="select * from infotrack_projects_community_com where 1 and system_entry_date <= '$today' and (park='$concession_location' or park='dpr')  $order2 ";
//echo "query4b=$query4b";
}


if($level>='4')
{
//echo "park_chosen=$park_chosen<br />";
//echo "player_chosen=$player_chosen<br />";
if($park_chosen != ''){$park_search=" and (park='$park_chosen' or park='dpr') ";
//echo "park_search=$park_search<br />";
$query4b="select * from infotrack_projects_community_com where 1 and system_entry_date <= '$today' $park_search  $order2 ";}
//echo "query4b=$query4b";
if($player_chosen != ''){$player_search=" and (user='$player_chosen') ";
//echo "player_search=$player_search<br />";
$query4b="select * from infotrack_projects_community_com where 1 and system_entry_date <= '$today' $player_search  $order2 ";}
if($park_chosen=='' and $player_chosen=='')
{
$query4b="select * from infotrack_projects_community_com where 1 and system_entry_date <= '$today' $order2 ";}

$query4b_under_review="select count(comment_id) as 'under_review' from infotrack_projects_community_com where 1 and system_entry_date <= '$today' and message_read='n' ";
$result4b_under_review = mysqli_query($connection, $query4b_under_review) or die ("Couldn't execute query 4b under review.  $query4n_under_review");

$row4b_under_review=mysqli_fetch_array($result4b_under_review);
extract($row4b_under_review);



}



//echo "$query4b";		 
$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");
$num4b=mysqli_num_rows($result4b);
//echo "num4b=$num4b";
//echo "query4b=$query4b";//exit;


}
$row4a=mysqli_fetch_array($result4a);
extract($row4a);


echo "<table>";
echo "<tr>";
if($project_note=='games')
{
echo "<td><font color=brown class='cartRow'>Game Notes</font></td>";
//echo "<td><b><A HREF=\"mailto:database.support@ncparks.gov?subject=$project_note  Application&cc=tammy.dodd@ncparks.gov\">Email Budget Office</A></td>";
}
//if($project_note=='cash_receipts')
//{echo "<td><font color=brown class='cartRow'>Cash Receipt Notes</font></td>";
//echo "<td><b><A HREF=\"mailto:database.support@ncparks.gov?subject=$project_note  Application&cc=tammy.dodd@ncparks.gov&body=test\">Email Budget Office</A></td>";
//}

if($project_note=='user_activity')
{
echo "<td><font color=brown class='cartRow'>User Activity Notes</font></td>";
//echo "<td><b><A HREF=\"mailto:database.support@ncparks.gov?subject=$project_note  Application&cc=tammy.dodd@ncparks.gov&body=test\">Email Budget Office</A></td>";
}

if($project_note=='park_budgets')
{
echo "<td><font color=brown class='cartRow'>Park Budget Notes</font></td>";
//echo "<td><b><A HREF=\"mailto:database.support@ncparks.gov?subject=$project_note  Application&cc=tammy.dodd@ncparks.gov&body=test\">Email Budget Office</A></td>";
}

if($project_note=='note_tracker')
{
/*
$query2="select ncas_end_date
from budget_ncas_date
where 1";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$row2=mysqli_fetch_array($result2);
extract($row2);
*/




//echo "ncas_end_date=$ncas_end_date";
//echo "<th>NCAS Update "; 
//echo date("F j, Y", strtotime($ncas_end_date));
//echo "</th><td><font color=brown class='cartRow'>Notes</font></td>";
//include ("infotrack_header.php");
//include ("infotrack_menu.php");

}


//echo "<td><b><A HREF=\"mailto:database.support@ncparks.gov?subject=$project_note  Application&cc=tammy.dodd@ncparks.gov&body=test\">Email Budget Office</A></td>";








echo "</tr>";
echo "</table>";
echo "<br />";


if($add_comment=='')
{
echo "<table><tr>";
echo "<td><a href='project1_menu.php?comment=y&add_comment=y&project_note_id=$project_note_id&folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group'>Add</a></td>";
echo "</tr></table>"; 
}
//echo "<table align='center'><tr><th><font color='brown'>Messages</font></th></tr></table>";
if($email=='y')
{

/*
$query33="select infotrack_projects_community_com.park as 'email_park',comment_note as 'email_body',crj_centers.email as 'email_to'
from infotrack_projects_community_com
left join crj_centers on infotrack_projects_community_com.park=crj_centers.parkcode
where 1 and comment_id='$comment_id' ";


$result33 = mysqli_query($connection, $query33) or die ("Couldn't execute query 33.  $query33");
$row33=mysqli_fetch_array($result33);
extract($row33);
*/

echo "<table align='center'>";
echo "<tr>";
echo "<th><font color='red'>Message received. Thanks</font></th>";
echo "</tr>";
//if($project_note=='games')
//{
//echo "<td><font color=brown class='cartRow'>Game Notes</font></td>";
//echo "<tr><td><b><A HREF=\"mailto:database.support@ncparks.gov?subject=$project_note  Application&cc=tammy.dodd@ncparks.gov&body=$email_body\">Click to Email</A></td></tr>";
/*
$email_body_encode=rawurlencode($email_body);
if($level>'3' and $email_park=='dpr'){$email_to="denr.dpr-all@lists.ncmail.net";}


if($level>'3')
{
echo "<tr><td>$email_body</td><td><b><A HREF=\"mailto:$email_to?subject=$project_note  &cc=tammy.dodd@ncparks.gov&body=$email_body_encode\">Click to Email</A></td></tr>";
}
if($level<'3')
{
echo "<tr><td>$email_body</td><td><b><A HREF=\"mailto:database.support@ncparks.gov?subject=$project_note  &cc=tammy.dodd@ncparks.gov&body=$email_body_encode\">Click to Email</A></td></tr>";
}
echo "</tr>";
*/


echo "</table>";

}
/*
if($email=='y'){echo "Email here";}
*/






//if($add_comment=='y' and $email!='y')
if($add_comment=='y')
{
{


echo "<table align='center'>";
//echo "<tr>";
//echo "<th><font color='brown'>Comment</font></th>";
//echo "</tr>";

//echo "<td></td>";

echo "<script language='javascript' type='text/javascript'>
      window.onload = function() {
      document.getElementById('input3').focus();
}

function validateForm()
{
var x=document.forms['form3']['input3'].value;
var y=document.forms['form3']['input4'].value;
if (x==null || x=='')
  {
  alert('Please enter Comment');
  return false;
  }
 if (y==null || y=='')
  {
  alert('Please enter ParkCode');
  return false;
  } 
  
  
  
}


</script>


";
echo "<tr>";
//echo "<table>";
if($level < 4)
{
echo "<th align='center'><font size='5' color='brown'><b>Messages</b></font><img height='40' width='40' src='/budget/infotrack/icon_photos/message_green1.png' alt='picture of green check mark'></img></font></th>";
}
//echo "</table>";
echo "<form method='post' action='/budget/infotrack/comment_add.php' name='form3' onsubmit='return validateForm()'  >";
if($level>'3')
{
//echo "<td><input name='location' type='text'  value='$concession_location' autocomplete='off'></td>";

echo "<td align='center'><font size='5' color='brown'><b>Messages</b></font><img height='40' width='40' src='/budget/infotrack/icon_photos/message_green1.png' alt='picture of green check mark'></img></font><br /><input name='location' type='text' placeholder='ParkCode receiving message' id='input4'> </td>";



}

echo "<td><textarea name= 'comment_note' rows='4' cols='80' placeholder='Type Message here' id='input3' ></textarea></td>";            
      
	  if($folder=='personal'){echo "<td><input type=submit name=submit value=Add_Note></td>";}
	  if($folder=='community'){echo "<td><input type=submit name=submit value=Add_Message>";
	  if($beacnum=='60032793')
	  {
	  echo "Alert:<input type='checkbox' name='alert_note' value='y'>";
	  }
	  echo "</td>";}
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
if($level=='5')
{
echo "<br />";
include("autocomplete_simple4_module.php"); 
include("autocomplete_simple6_module.php"); 
}
echo "<br />";
//echo "<br />";
//echo "query4b=$query4b<br />";

/*
1/18/2004
echo "<br /><table align='center'><tr><td><font  color=red>Messages: $num4b  </font></td></tr></table>";
*/


//echo "show_order=$show_order";
if($show_order==''){$shade_newest="class=cartRow";}
if($show_order=='newest'){$shade_newest="class=cartRow";}
if($show_order=='oldest'){$shade_oldest="class=cartRow";}

//echo "shade_oldest=$shade_oldest";
echo "<table align='center' border='1'>";
echo"<tr>";
echo "<td><a href='/budget/infotrack/notes.php?comment=y&add_comment=y&project_note=$project_note&folder=community&category_selected=y&name_selected=y&show_order=newest'><font size='3' $shade_newest>Newest on top</font></a></td>";
echo "<td><a href='/budget/infotrack/notes.php?comment=y&add_comment=y&project_note=$project_note&folder=community&category_selected=y&name_selected=y&show_order=oldest'><font size='3' $shade_oldest>Newest on bottom</font></a></td>";

echo "</tr></table>"; 

//echo "<br />";
//if($message=='1'){echo "<font color='red' size='5'><b>Update Successful</b></font>";$message=="";}
//echo "<br />num4b=$num4b";
if($num4b==0){echo "<br /><table><tr><td><font  color=red>No Messages</font></td></tr></table>";}
if($num4b!=0)
{
//echo "<h2 ALIGN=left><font color=brown class=cartRow>Records: $num5</font></h2>";
//09-24-14
if($level > 0)
{
if($num4b==1)
{echo "<br /><table align='center'><tr><td><font  color=brown>Messages: $num4b</font></td></tr></table>";}

if($num4b>1)
{echo "<br /><table align='center' >


<tr><th colspan='5' align='center'>Search messages</th></tr>
<tr><td><a href=''><img height='20' width='20' src='/budget/infotrack/icon_photos/under_review1.png' alt='picture of home'></img></a></td>
<th>or</th>
<td><form name=search_under_review><input type='text' name='search_term'></form></td></tr>
</table><br /><br />
<table align='center'>
<tr><td><font  color=brown>Messages displayed: $num4b  </font></td></tr></table>";}
}
echo "<br />";
echo "<table align='center'>";

echo "<tr>";
if($level > 1)
{
echo "<td><font color='brown'>Park</font></td>";
}
echo "<td align='center'><font color='brown'>Player</font></td>";
//echo "<td align='center'><font color='brown'>Message Date</font></td>";
echo "<td align='center'><font color='brown'>Message</font><br /><font color='red'>Click Magnify glass under Message ID to view Full Size message</font></td>";
//echo "<td><font color='brown'>Status</font></td>";
echo "<td><font color='brown'>ID</font></td>

</tr>";

echo  "<form method='post' autocomplete='off' action='/budget/infotrack/alert_comment_update.php'>";
while ($row4b=mysqli_fetch_array($result4b)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4b);
//echo "system_entry_date=$system_entry_date<br />";
$today=date("Y-m-d");
//echo "today is $today<br >";
//if($system_entry_date==$today){$bgc="lightpink";} else {$bgc="lightgreen";}
if($status=='ip' and $alert=='y'){$bgc="lightpink";} else {$bgc="lightgreen";}
//echo "status=$status<br />alert=$alert";
//exit;
$system_entry_date_original=$system_entry_date;
$system_entry_date=date('m-d-y', strtotime($system_entry_date));
$original_entry_date=date('m-d-y', strtotime($original_entry_date));
$countid=number_format($countid,0);
$rank=$rank+1;

if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
$user=substr($user,0,-2);
//if($status=='fi'){$color='light green';}else{$color='light pink';}
//if($status=="fi"){$bgc="lightgreen";} else {$bgc="lightpink";}

//$bgc="lightgreen";

echo "<tr bgcolor='$bgc'>"; 
//echo "<tr$t>"; 
//echo "<td>$rank</td>";
if($level > 1)
{
 echo "<td><font color='brown'>$park</font></td>";
 }
 //echo "<td align='center'><font color='brown'>$user</font></td>";
 echo "<td align='center'><font color='brown'>$user<br />$system_entry_date</font></td>";
 /*
 if($system_entry_date_original==$today)
 {
 echo "<td align='center'><font color='brown'>$system_entry_date</font></td>"; 
 }
 else
 {
 echo "<td align='center'><font color='brown'>$system_entry_date</font></td>"; 
 }
 */
 
 
 
 echo "<td><textarea name='comment_note[]' cols='70' rows='9'>$comment_note</textarea>
 <br />";
 
 if($alert=='y' and $message_read=='n' and $level < '2')
 {
 
 $tempID2=substr($tempID,0,-2);
 echo "<table border='1' cellpadding='10'><tr bgcolor='lightpink'><td><font color='red'>Message verification requested from $tempID2?</font> </td><td><a href='/budget/infotrack/notes.php?project_note=note_tracker&comment_read_id=$comment_id'>Yes</a></td></tr></table>";}
 
 if($alert=='y' and $message_read=='y')
 {
 $message_reader2=substr($message_reader,0,-2);
 $message_read_date2=date('m-d-y', strtotime($message_read_date));
 echo "<table border='1' cellpadding='10'><tr bgcolor='lightgreen'><td>$message_reader2 verified message on $message_read_date2 Thanks<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td></tr></table>";}
 
 echo "</td> ";
//echo "<td>$comment_note</td>"; 
//<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>

if($level==5)
{
echo "<td><font color=$color><input type='hidden' size='1' name='status[]' value='$status'></font></td>";
}


//echo "<td><font color=$color><input type='text' size='1' name='show2park[]' value='$show2park'></font></td>";
echo "<td><input type='text' size='1' name='comment_id[]' value='$comment_id' readonly='readonly'><br /><a href='note_tracker_noteprint.php?comment_id=$comment_id'><img height='20' width='20' src='/budget/infotrack/icon_photos/magnify.png' alt='picture of home'></img></a><br />";
if($level=='5'){echo "<a href='message_read.php?comment_id=$comment_id&message_read=$message_read&park_chosen=$park_chosen&player_chosen=$player_chosen'>$message_read</a>";}
if($message_read=='y'){echo "<img height='40' width='40' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of home'></img>";}
if($message_read=='n'){echo "<img height='40' width='40' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of home'></img>";}

/*
if($weblink != '' and $alert=='y')
{
echo "<br />
<a href='$weblink'>
<img height='35' width='35' src='/budget/infotrack/icon_photos/green_paint_1.png' alt='picture of green paint' title='paint'></img>	</a><br />message date<br /> $original_entry_date<br />$days_elapsed days old";
}

if($weblink == '' and $alert=='y')
{
echo "<br />
message date<br /> $original_entry_date<br />$days_elapsed days old";
}

*/


echo "</td>";
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
 }
 }
 echo "</body>";
echo "</html>";
 }
 ?>
 