<?php
//echo "hello world";exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

//$file = "articles_menu.php";
//$lines = count(file($file));


//$table="infotrack_projects";
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
$position=$_SESSION['budget']['beacon_num'];


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


echo"
<html>
<head>
<title>MC Procedures</title>";

//include("../../budget/menu1314_procedures.php");
include("../../budget/menu1314.php");

if($menu=='1')
{


if($level=='5')
{
//$query4="select * from surveys where 1 order by procedure_name asc";
$query4="select surveys.procedure_name,surveys.procedure_document,surveys.pid,
surveys.status, count(surveys_comments.cid) as 'procedure_count'
from surveys
left join surveys_comments on surveys.pid=surveys_comments.pid
where 1 order by surveys.procedure_name asc";
}
else
{
//$query4="select * from surveys where 1 and status='show' order by procedure_name asc";
$query4="select surveys.procedure_name,surveys.procedure_document,surveys.pid,
surveys.status, count(surveys_comments.cid) as 'procedure_count'
from surveys
left join surveys_comments on surveys.pid=surveys_comments.pid
where 1 order by surveys.procedure_name asc";
}
//echo $query4;exit;		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);

echo "</head>";



echo "<br />";
/*
echo "<table><tr><td><font color=brown class='cartRow'>MoneyCounts-Surveys</font></td></tr></table>";
*/

echo "<table><tr><th>
 <a href='/budget/infotrack/surveys.php?folder=community&menu=1'>
 <img height='50' width='50' src='/budget/infotrack/icon_photos/gems1.jpg' alt='picture of gemstones'></img></a></th><th>Community Support Gems</th></tr></table>";




if($level=='5')
{
echo "<table>";
echo "<tr>";
//echo "<th><font color='brown'>Comment</font></th>";
//echo "</tr>";



echo "<script language='javascript' type='text/javascript'>
      window.onload = function() {
      document.getElementById('input2').focus();
}

function validateForm()
{
var y=document.forms['form2']['input2'].value;
 if (y==null || y=='')
  {
  alert('Please enter Procedure Name');
  return false;
  } 
  
  
}


</script>";

echo "<br />";
//echo "<td></td>";
echo "<form method='post' action='alert_add.php' name='form2' onsubmit='return validateForm()' >";
//echo "<td><input type='text' name= 'alert_location' placeholder='kela,jord,etc'></input></td>";  
echo "<td><textarea name= 'alert_note' rows='1' cols='30' placeholder='Survey Name' id='input2'></textarea></td>";            
      
	  echo "<td><input type=submit name=submit value=Add_Survey></td>";
	     
	 echo "</form>";
echo "</tr>";
      
	 
echo "</table>";
}

echo "<br />";
echo "<table border=1>";

echo "<tr>";

//echo "<th><font color='brown'>Procedure</font></th>";

echo "</tr>";


while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);

//$procedure_name=nl2br($procedure_name);
//$procedure_name=replace('','&nbsp;','$procedure_name');
//$countid=number_format($countid,0);
//$rank=$rank+1;
//$rank2="(".$rank.")";
//$percomp=round($percomp);
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
//if($percomp=="100.00"){$bgc="lightgreen";} else {$bgc="lightpink";}

if($procedure_count==1){$comment_message="$procedure_count nugget";}
if($procedure_count!=1){$comment_message="$procedure_count nuggets";}

if($status=='ip'){$bgc="lightpink";} 
if($status=='fi'){$bgc="lightgreen";} 

echo 

"<tr bgcolor='$bgc'>"; 

/*
if($file=='y'){echo "<td><a href='$procedure_document'>$procedure_name</a></td>";}
else
*/

//for($j=0;$j<$ck_count;$j++){}

/*
echo "<td><a href='surveys.php?comment=y&add_comment=y&folder=community&pid=$pid'>$procedure_name</a></td><th>$procedure_count<br />
 <img height='25' width='25' src='/budget/infotrack/icon_photos/gems2.jpg' alt='picture of gemstones'></img></th>"; 
 */
 
 
 echo "<td><a href='surveys.php?comment=y&add_comment=y&folder=community&pid=$pid'>$procedure_name</a></td>";
 
 
 for($j=0;$j<$procedure_count;$j++)
 {
 echo "<th>
 <img height='25' width='25' src='/budget/infotrack/icon_photos/gems2.jpg' alt='picture of gemstones'></img></th>"; 
 }
 

          
echo "</tr>";

}

 echo "</table>";
 echo "</body>";
 echo "</html>";
 }
 
if($comment=='y') 

 {

if($show_order==''){$order2=" order by cid asc";}
if($show_order=='newest'){$order2=" order by cid desc";}
if($show_order=='oldest'){$order2=" order by cid asc";}




$query4a="select procedure_name,procedure_document from surveys where pid='$pid' ";

//echo $query4a;echo "<br />";		 
$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");
$num4a=mysqli_num_rows($result4a);


$query4b="select * from surveys_comments where 1 and pid='$pid' $order2 ";

//echo "$query4b";		 
$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");
$num4b=mysqli_num_rows($result4b);
//echo "query4b=$query4b";//exit;



$row4a=mysqli_fetch_array($result4a);
extract($row4a);
$procedure_document=str_replace('  ','&nbsp;&nbsp;',$procedure_document);
$procedure_document=nl2br($procedure_document);

echo "<table>";
echo "<tr>";
echo "<th>
 <a href='/budget/infotrack/surveys.php?folder=community&menu=1'>
 <img height='50' width='50' src='/budget/infotrack/icon_photos/gems1.jpg' alt='picture of gemstone pebbles'></img></a></th><th>Community Support Gems</th>";

echo "</tr>";
echo "</table>";
echo "<br />";
?>
<script language="javascript" type="text/javascript">
<!-- 
//Browser Support Code
function ajaxFunction(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
		var ajaxDisplay = document.getElementById("ajaxDiv");
			ajaxDisplay.innerHTML = ajaxRequest.responseText;	
		}
	}
	//var age = document.getElementById("age").value;
	//var wpm = document.getElementById("wpm").value;
	//var sex = document.getElementById("sex").value;
	//var queryString = "?age=" + age + "&wpm=" + wpm + "&sex=" + sex;
	//ajaxRequest.open("GET", "ajax-example2_update.php" + queryString, true);
	//ajaxRequest.open("GET", "ajax-example2_change_color.php", true);
	ajaxRequest.open("GET", "bright_idea_steps2_v2.php", true);
	ajaxRequest.send(null); 
}

//-->
</script>
<?php
/*
if($position=='60032793')
{
echo "<form name='myForm'>
<input type='button' onclick='ajaxFunction()' value='Show Bright Idea' />
</form>
<div id='ajaxDiv'></div>";
}
*/
echo "<table>";
echo "<tr>";
//echo "<td><font color=brown class='cartRow'>$procedure_name</font></td>";
if($level=='5')
{
echo "
<td><font color=brown class='cartRow'>(pid $pid)</font></td>
<td><a href='surveys.php?comment=y&add_comment=y&folder=community&pid=$pid&editP=y'>Edit</a></font></td>";
/*
if($pid=='12'){
echo "pid=$pid";
include("/budget/infotrack/bright_idea_steps2_v2.php?cid=295");
//{echo "hello pid 12";}
}
*/
}


echo "</tr>";
echo "</table>";

if($editP=='')
{

$query4b1="select count(surveys_comments.cid) as 'procedure_count2'
from surveys_comments
where pid='$pid'
";
$result4b1 = mysqli_query($connection, $query4b1) or die ("Couldn't execute query 4b1.  $query4b1");

$row4b1=mysqli_fetch_array($result4b1);
extract($row4b1);//brings back max (start_date) as $start_date

echo "<table>";
echo "<tr>";
echo "<td>$procedure_document</td>";
//echo "<td>test</td>";

for($j=0;$j<$procedure_count2;$j++)
 {
 echo "<th>
 <img height='25' width='25' src='/budget/infotrack/icon_photos/gems2.jpg' alt='picture of gemstones'></img></th>"; 
 }




echo "</tr>";

echo "</table>";
}

if($editP=='y')
{

$query4c="select procedure_name,procedure_document from surveys where pid='$pid' ";

//echo $query4a;echo "<br />";		 
$result4c = mysqli_query($connection, $query4c) or die ("Couldn't execute query 4c.  $query4c");
$num4c=mysqli_num_rows($result4c);
$row4c=mysqli_fetch_array($result4c);
extract($row4c);





echo "<form method='post' action='procedures_edit.php'>";
//echo "<td><input type='text' name= 'alert_location' placeholder='kela,jord,etc'></input></td>";  
echo "<td><textarea name= 'procedure_document' rows='100' cols='120' >$procedure_document</textarea></td>";            
      
	  echo "<td><input type='submit' name='submit' value='Update_Procedure'></td>";
	  
     echo "<input type='hidden' name='pid' value='$pid'>";	   
	 echo "</form>";
echo "</tr>";
      
	 
echo "</table>";
}



echo "<br />";
if($comment=='y'){$shade_comment="class=cartRow";}
if($game=='y'){$shade_game="class=cartRow";}

/*
echo "<table border='1'><td><a href='surveys.php?comment=y&add_comment=y&folder=community&pid=$pid><font color='brown' $shade_comment>Comments</font></a></td>";

//echo "<td><font color='brown' $shade_game>Game</font></td>":

echo "</table>";
*/


//echo "<br />";
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
  alert('Gem is missing');
  return false;
  }
}

</script>


";

echo "<form method='post' action='surveys_add_comment.php' name='form3' onsubmit='return validateForm()'  >";
echo "<td><textarea name= 'comment_note' rows='6' cols='50' placeholder='Type Gem here' id='input3' ></textarea></td>";            
      
	  
	  if($folder=='community'){echo "<td><input type=submit name=submit value=Add_Gem></td>";}
	  echo "<input type='hidden' name='pid' value='$pid'>";	   
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

echo "<td><a href='surveys.php?comment=y&add_comment=y&folder=community&pid=$pid&show_order=newest'><font size='3' $shade_newest>Newest on top</font></a></td>";
echo "<td><a href='surveys.php?comment=y&add_comment=y&folder=community&pid=$pid&show_order=oldest'><font size='3' $shade_oldest>Newest on bottom</font></a></td>";

echo "</tr></table>"; 

echo "<br />";
if($message=='1'){echo "<font color='red' size='5'><b>Update Successful</b></font>";$message=="";}

echo "<table>";
/*
4-5-14
echo "<tr>
<td><font color='brown'>Location</font></td>
<td align='center'><font color='brown'>User</font></td>
<td align='center'><font color='brown'>Date</font></td>
<td align='center'><font color='brown'>Comment</font></td>
<td><font color='brown'>Status</font></td>
<td><font color='brown'>ID</font></td>

</tr>";
*/
echo  "<form method='post' autocomplete='off' action='comment_update_procedures.php'>";
while ($row4b=mysqli_fetch_array($result4b)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4b);
$countid=number_format($countid,0);
$rank=$rank+1;

if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
$user2=substr($user,0,-2);
//echo "tempID=$tempID <br />";
//echo "user=$user <br />";
//echo "user2=$user2 <br />";
//if($status=='fi'){$color='light green';}else{$color='light pink';}
if($status=="fi"){$bgc="lightgreen";} else {$bgc="lightpink";}

echo "<tr bgcolor='$bgc'>"; 
//echo "<tr$t>"; 
//echo "<td>$rank</td>";
 echo "<td><font color='brown'>$park<br />$user2<br />$system_entry_date</td>";
// echo "<td><font color='brown'>$user2</font></td>";
 //echo "<td>$system_entry_date</font></td>"; 
 if($tempID==$user)
 {
 echo "<td><textarea name='comment_note[]' cols='70' rows='8'>$comment_note</textarea></td> ";
 }
 else
 {
 echo "<td><textarea name='comment_note[]' cols='70' rows='8' readonly='readonly'>$comment_note</textarea></td> ";
 }
  
 
//echo "<td>$comment_note</td>"; 
if($tempID==$user)
{
echo "<td><font color=$color><input type='text' size='1' name='status[]' value='$status'></font></td>";
}
else
{
echo "<td><font color=$color><input type='text' size='1' name='status[]' value='$status' readonly='readonly'></font></td>";
}


echo "<td><input type='text' size='1' name='cid[]' value='$cid' readonly='readonly'</td>";
echo "<td>$color</td>";


//echo "<td>$status</td>"; 

	          
echo "</tr>";

}
/*
echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
*/
echo "<input type='hidden' name='pid' value='$pid'>";
echo "<input type='hidden' name='num4b' value='$num4b'>";
echo   "</form>";
 echo "</table>";
 echo "</body>";
echo "</html>";
 }
 ?>
 