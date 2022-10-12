<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters

$query1="SELECT highlight_color from infotrack_customformat
         where user_id='$tempid' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysql_fetch_array($result1);
extract($row1);
//echo "highlight_color=$highlight_color";exit;
//brings back max (end_date) as $end_date
//echo "username=$username";

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//$project_category=$_REQUEST['project_category'];
//$project_name=$_REQUEST['project_name'];

//echo $project_category;
//echo $project_name;




//$table1="weekly_updates";
//$table2="project_notes2";

//mysql_connect($host,$username,$password);
//@mysql_select_db($database) or die( "Unable to select database");

include("../../../budget/menu1314.php");
echo "<html>";

echo "<head>";
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
	ajaxRequest.open("GET", "ajax-example2_update.php", true);
	ajaxRequest.send(null); 
}

//-->
</script>
<?php
echo "</head>";

//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
if(!isset($step)){$step="";}
//echo "<H2 ALIGN=LEFT > <font color=brown><i>$project_name-StepGroup $step_group-$step</font></i></H2>";
echo "<br />";
echo "<table align='center'><tr><th><i>$project_name-StepGroup $step_group-$step</i></th></tr></table>";
/*
echo "<H2 ALIGN=center><font size=4><b><A href=\"/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates\"> Return Weekly Updates-HOME </A></font></H2>";
*/
echo "<br />";
echo
"<form align='center'>";
//echo "<font size=5>"; 
echo "fiscal_year:<input name='fiscal_year' type='text' value='$fiscal_year' readonly='readonly'>";
echo "<br />";
echo "start_date:&nbsp;<input name='start_date' type='text' value='$start_date' readonly='readonly'>";
echo "<br />";
echo "end_date:&nbsp;&nbsp;&nbsp;<input name='end_date' type='text' value='$end_date' readonly='readonly'>";
//echo "today_date:<input name='today_date'";  echo "type='text'"; echo "value= date('Y-m-d')"; echo "readonly='readonly'>";
echo "</form>";
echo "<br />";
?>
<form name="myForm" align='center'>
<!--<input type="button" onclick="ajaxFunction()" value="Query MySQL" />-->
<input type="button" onclick="ajaxFunction()" value="Change highlight_color" />
</form>
<div id="ajaxDiv" align='center'>Your result will display here</div>
<?php
echo "<br />";
echo "<table align='center'>";
echo "<tr>";
echo "<td>
	   <form method='post' action='add_step.php'>
	   <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value=\"$project_category\">	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='submit' name='submit' value='Add_Step'>
	   </form>
       </td>";
echo "</tr>";
echo "</table>";	   
echo "<br />";	   

$query3="SELECT *, from_unixtime(time_complete) as 'time_complete2'
        FROM project_steps_detail where 1 and project_category='$project_category'
        and project_name='$project_name' and step_group='$step_group' order by step_num asc";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysql_query($query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysql_num_rows($result3);
mysql_close();
echo "<table align='center'><tr><td><font color='red'><b>Counter: $num3</b></font></td><td>";

include("../../infotrack/scoring/scoreG5.php");
include("../../infotrack/charts/bright_idea_chart.php");
echo "</td></tr></table>";
echo "<table border=1 align='center'>";
 
echo 

"<tr> 
       
       <th>StepNum</th>
       <th>StepName</th>
       <th>Role</th>
       <th>Link</th>
       <th><font color=red>Action</font></th>";
    //  echo " <th<font color=red>TimeStart</font></th>
     //  <th<font color=red>TimeEnd</font></th>
     //  <th<font color=red>TimeElapsed</font></th>
    echo "<th><font color=red>Record</font></th>";
    echo "<th><font color=red>Edit</font></th>";
    echo "<th><font color=red>Delete Record</font></th>";
    echo "<th><font color=red>Duplicate Record</font></th>";
                 
       
 

echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
while ($row3=mysql_fetch_array($result3))
	{	
	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	$rank=@$rank+1;
	extract($row3);
	//$rank=$rank+1;
	
	
	//echo $status;
	$rand = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
    $color = "#".$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
	//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
	if($status=='complete'){$t=" bgcolor='$highlight_color'";}else{$t=" bgcolor='#B4CDCD'";}
	if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
	//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
	
	//echo $status;
	
	echo 
		
	"<tr$t>";	
	
		   
		   
		//echo "<td>$rank</td>";   
		echo "<td align='center'>$step_num</td>
		   <td>$step_name</td>
		   <td>$role</td>
		   <td>$link</td>
		   <td>
		   <form method='post' action='step$step_group$step_num.php'>
		   <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
		   <input type='hidden' name='project_category' value='$project_category'>	   
		   <input type='hidden' name='project_name' value='$project_name'>	   
		   <input type='hidden' name='start_date' value='$start_date'>	   
		   <input type='hidden' name='end_date' value='$end_date'>	   
		   <input type='hidden' name='step_group' value='$step_group'>	   
		   <input type='hidden' name='step_num' value='$step_num'>	   
		   <input type='hidden' name='step' value='$step'>	   
		   <input type='hidden' name='step_name' value='$step_name'>	   
		   <input type='hidden' name='link' value='$link'>	   
		   <input type='submit' name='submit1' value='Execute'>
		   </form>
		   </td>";
		   
		echo "<td>
				  <form method='post' action='status_change.php'>
				  <input type='hidden' name='status' value='$status'>
				  <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
				  <input type='hidden' name='project_category' value='$project_category'>	   
				  <input type='hidden' name='project_name' value='$project_name'>	   
				  <input type='hidden' name='start_date' value='$start_date'>	   
				  <input type='hidden' name='end_date' value='$end_date'>	   
				  <input type='hidden' name='step_group' value='$step_group'>	   
				  <input type='hidden' name='step_num' value='$step_num'>	   
				  <input type='hidden' name='step' value='$step'>	   
				  <input type='hidden' name='step_name' value='$step_name'> 
				  <input type='submit' name='submit2' value='change_status'>
				  </form></td>
				  <td>
				  <form method='post' action='edit_record.php'>
				  <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
				  <input type='hidden' name='project_category' value='$project_category'>	   
				  <input type='hidden' name='project_name' value='$project_name'>	   
				  <input type='hidden' name='start_date' value='$start_date'>	   
				  <input type='hidden' name='end_date' value='$end_date'>	   
				  <input type='hidden' name='step_group' value='$step_group'>	   
				  <input type='hidden' name='step_num' value='$step_num'>	   
				  <input type='hidden' name='step' value='$step'>	   
				  <input type='hidden' name='step_name' value='$step_name'> 
				  <input type='hidden' name='cid' value='$cid'> 
				  <input type='submit' name='submit2' value='Edit'>
				  </form></td>
		
		   <td>
		   <form method='post' action='edit_record_delete_verify.php'>
		   <input type='hidden' name='cid' value='$cid'>
		   <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
		   <input type='hidden' name='project_category' value='$project_category'>	   
		   <input type='hidden' name='project_name' value='$project_name'>	   
		   <input type='hidden' name='start_date' value='$start_date'>	   
		   <input type='hidden' name='end_date' value='$end_date'>	   
		   <input type='hidden' name='step_group' value='$step_group'>	   
		   <input type='hidden' name='step' value='$step'>  
		   <input type='submit' name='submit' value='DeleteRecord-$cid'>
		   </form></td>
		   <td>
		   <form method='post' action='edit_record_duplicate.php'>
		   <input type='hidden' name='cid' value='$cid'>
		   <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
		   <input type='hidden' name='project_category' value='$project_category'>	   
		   <input type='hidden' name='project_name' value='$project_name'>	   
		   <input type='hidden' name='start_date' value='$start_date'>	   
		   <input type='hidden' name='end_date' value='$end_date'>	   
		   <input type='hidden' name='step_group' value='$step_group'>	   
		   <input type='hidden' name='step' value='$step'>  
		   <input type='hidden' name='link' value='$link'>  
		   <input type='hidden' name='weblink' value='$weblink'>  
		   <input type='hidden' name='status' value='$status'>  
		   <input type='submit' name='submit' value='DuplicateRecord-$cid'>
		   </form>	
		  
				  </td>";
				  
						 
	echo "</tr>";
	
	
	
	}

echo "</table></body></html>";

?>

























