<?php
extract($_REQUEST);
session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}

include("../../include/connect.php");
$database="mamajone_cookiejar";
$table="projects";
$table2="project_notes";
$table3="project_notes_count";
$table4="members";

////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");



$query6="truncate table project_notes_count";
 mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");
 
$query6a="insert into project_notes_count(user,project_category,project_name,note_count) 
select user,project_category,project_name,count(project_note_id) 
from project_notes where 1 group by user,project_category,project_name";

mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a.  $query6a");
 
$query7="update projects
set projects.notes=''
where 1";

mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");




$query7a="update projects,project_notes_count 
set projects.notes=project_notes_count.note_count 
where projects.user_id=project_notes_count.user 
and projects.project_category=project_notes_count.project_category 
and projects.project_name=project_notes_count.project_name";

mysqli_query($connection, $query7a) or die ("Couldn't execute query 7a.  $query7a");

$query9="select * from $table4 where 1 and username='$myusername' ";

$result9=mysqli_query($connection, $query9) or die ("Couldn't execute query 9. $query9");


$row=mysqli_fetch_array($result9);

extract($row);

$level=$projects;



$query="SELECT user_id,project_category,project_name,created,share_provider,notes,project_id
FROM $table
WHERE 1 and user_id='$myusername'
and project_status = 'open'
and project_type='private'
ORDER BY project_category,project_name ";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
$num=mysqli_num_rows($result);


$query2="SELECT project_id
from $table
WHERE 1 and user_id='$myusername'
and project_status='open'
and project_type='private'
";

$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$num2=mysqli_num_rows($result2);

$query8="SELECT project_id
from $table
WHERE 1 and (user_id='$myusername' or shared_users like '%$myusername%')
and project_type='share'
";

$result8=mysqli_query($connection, $query8) or die ("Couldn't execute query 8. $query8");

$num8=mysqli_num_rows($result8);



$query4="SELECT project_id
from $table
WHERE 1 and user_id='$myusername'
and project_status='archive'
and project_type='private'
";

$result4=mysqli_query($connection, $query4) or die ("Couldn't execute query 4. $query4");

$num4=mysqli_num_rows($result4);

$query5="SELECT project_id
from $table
WHERE 1 and user_id='$myusername'
";

$result5=mysqli_query($connection, $query5) or die ("Couldn't execute query 5. $query5");

$num5=mysqli_num_rows($result5);

$query10="SELECT *
from projects_customformat
WHERE 1 and user_id='$myusername'
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;



//echo "n=$num";
//exit;

// frees the connection to MySQL
 ////mysql_close();

if($rep==""){ 
echo "<html>";

echo "<head>

<title>Welcome</title>
<style type='text/css'>

body { background-color: $body_bg; }
table { background-color: $body_bg; font-color: blue; font-size: 10;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}


//h1 { background-color: white; font-color: red; }
.main {
width:200px;
border:1px solid black;
}

.month {
background-color:black;
font:bold 12px verdana;
color:white;
}

.daysofweek {
background-color:gray;
font:bold 12px verdana;
color:white;
}

.days {
font-size: 12px;
font-family:verdana;
color:green;
background-color: lightyellow;
padding: 2px;
}

.days #today{
font-weight: bold;
color: red;
}



</style>
<script type='text/javascript' src='basiccalendar.js'>

/***********************************************
* Basic Calendar-By Brian Gosselin at http://scriptasylum.com/bgaudiodr/
* Script featured on Dynamic Drive (http://www.dynamicdrive.com)
* This notice must stay intact for use
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

</script> 
</head>";


//echo "<H1 ALIGN=left > <font color='red' bgcolor='white'>Projects-$myusername </font></H1>";
//echo "<H1 ALIGN=left><font color=red>$myusername Projects</font></H1>";
//echo "<H1 ALIGN=left><font color=brown><i>ProjectManager: $myusername </i></font></H1>";
echo "<H1 ALIGN=left><font color=brown><i>Notebooks-$myusername</i></font></H1>";
echo "<table border=1>";

echo "<table border=2 cellspacing=5>";
echo "<tr>";
//echo "<td><font size=4><b><A href='home_page_custom.php'>Customize</b></A></font></td>";
//echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
//&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";



//echo $level;exit;

if(($level=='5')){ 
  	   echo "<td>";
	   echo "<font size=4><b><A href='welcome_admin.php'>Admin</b></A></font>";
	   echo "</td>";
	  // echo "<font size=4><b><A href='abstract1.php'>Abstract</b></A></font>";
	   
	   
	   
	   }
	   


echo "<td><font size=4><b><A href='project_add.php'>Create Notebook</A></b></font></td>";
echo "<td><font size=4><b><A href='project_status_reports_archive.php'>View Archived ($num4) </b></A></font></td>";
echo "<td><font size=4><b><A href='project_share_add.php'>View Shared ($num8)</A></b></font></td>";
echo "<td><font size=4><b><A href='home_page_custom.php'>Customize</b></A></font></td>";

?>
<td>
<script>
function redirect(index)
{
	switch(index)
	{
		case 1:
		document.location='/games/welcome.php';
		break;
		case 2:
		document.location='/budget/welcome.php';
		break;
		case 3:
		document.location='/projects/welcome.php';
		break;
		case 4:
		document.location='/applocator/welcome.php';
		break;
		
		
	}
}
</script>
<body>

<p><font color=brown>MyApps</font></p>
<form >
 <p><select size="1" name="D1" style="width: 100; height: 23" onchange="redirect(this.selectedIndex)">
  <option>-- Select --</option>
  <option>Games</option>
  <option>Money</option>
  <option>Notebooks</option>
  <option>New Apps Locator</option>
  </select></p>
</form>

</body>
</td>
</tr></table>
<br />

<form>
<select onChange="updatecalendar(this.options)">
<script type="text/javascript">

var themonths=['January','February','March','April','May','June',
'July','August','September','October','November','December']

var todaydate=new Date()
var curmonth=todaydate.getMonth()+1 //get current month (1-12)
var curyear=todaydate.getFullYear() //get current year

function updatecalendar(theselection){
var themonth=parseInt(theselection[theselection.selectedIndex].value)+1
var calendarstr=buildCal(themonth, curyear, "main", "month", "daysofweek", "days", 0)
if (document.getElementById)
document.getElementById("calendarspace").innerHTML=calendarstr
}

document.write('<option value="'+(curmonth-1)+'" selected="yes">Current Month</option>')
for (i=0; i<12; i++) //display option for 12 months of the year
document.write('<option value="'+i+'">'+themonths[i]+' '+curyear+'</option>')


</script>
</select>

<div id="calendarspace">
<script>
//write out current month's calendar to start
document.write(buildCal(curmonth, curyear, "main", "month", "daysofweek", "days", 0))
</script>
</div>

</form>
<?php
//echo "</td>";
//echo "</tr>";
//echo "</table>";

echo "<H2 ALIGN=left><font color=green><i>Private Notebooks (Active)</i>-$num2 </font></H2>";


if(($level=='5')){
echo "<a href='welcome.php?&rep=excel'>Excel Export</a>";
}
//echo "<h2 ALIGN=center>";
//echo "<table border='1' cellspacing='10'>";

//echo "<tr>";
//echo "<td>";
//echo "<font size=4><b>Current</b>$num2 </font>";
//echo "</td>";
//echo "<td>";

//echo "<font size=4><b>Archived </b><A href=project_status_reports_archive.php>$num4 </A></font>";
//echo "</td>";
//echo "<td>";
//echo "<font color=red size=5><b>Active $num</b></font>";
//echo "</td>";

//echo "</tr>";
//echo "</table>";
//echo "</h2>";

//echo "<br /> <br />";

}
if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=welcome.xls');
}

 echo "<table border=1>";
 
 
echo 

"<tr> 
       <th align=left><font color=brown>category</font></th>
       <th align=left><font color=brown>topic</font></th>
	   <th><font color=brown>records</font></th>
	   <th><font color=brown>open</font></th>
	   <th><font color=brown>rename</font></th>
	   <th><font color=brown>archive</font></th>
	   <th><font color=brown>share</font></th>
       <th><font color=brown>delete</font></th>
              
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);

if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>

       <td>$project_category</td>
	   <td>$project_name</td>
	   <td align=center>$notes</td>	   
	   <td><a href='search_notes.php?&project_category=$project_category&project_name=$project_name&user_id=$user_id'>open</a></td>
	   <td><a href='rename_project.php?&project_category=$project_category&project_name=$project_name'>rename</a></td>
	   <td><a href='archive_project.php?&project_id=$project_id'>archive</a></td>	   
	   <td><a href='copy_project.php?&project_id=$project_id&project_category=$project_category&project_name=$project_name&notes=$notes'>share</a></td>	   
	   <td><a href='delete_project_verify.php?&project_category=$project_category&project_name=$project_name'>delete</a></td>
	   
	   
      
	   
	      
	   
</tr>";




}

 echo "</table></body></html>";
 ?>




