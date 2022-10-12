<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
if($level=="5" and $tempID !="Dodd3454")
{echo "<pre>";print_r($_SESSION);"</pre>";}//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
//if($beacnum != '60032793' and $beacnum != '60033162' and $beacnum != '60032781' and $beacnum != '60033202')
//{echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}

if($level=='5' and $tempID !='Dodd3454')
{
echo "beacon_number:$beacnum";
echo "<br />";
echo "concession_location:$concession_location";
echo "<br />";
echo "concession_center:$concession_center";
echo "<br />";
}


$table="concessions_reports";

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


if($level=="5" and $tempID !="Dodd3454")

{
echo "body_bg:$body_bg";
echo "<br />";
echo "table_bg:$table_bg";
echo "<br />";
echo "table_bg2:$table_bg2";
}


$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>
<title>Concessions</title>";

//include ("test_style.php");
include ("test_style.php");

echo "</head>";

include ("widget1.php");

//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";


$query5="SELECT *
FROM $table
WHERE 1 
ORDER BY project_group,project_category,project_note ";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);

echo "<H2 ALIGN=center><font size=4><b><A href=/budget/menu.php?forum=blank> Budget-Home </A></font></H2>";

echo "<table border=5 cellspacing=5>";
echo "<tr>
<th><font color='brown'>Files:$num5</font></th>
<th><A href='administrator_menu.php?&add_your_own=y'>Add your own</A></th></tr>";	 	  
echo "</table>";
echo "<br />";
//echo "<h2 ALIGN=left><font color=brown>Files:$num5</font></h2>";

if($add_your_own =='y'){

echo
"<form method=post autocomplete='off' action=concessions_files_add.php>";



echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr><th><font color='brown'>Group</font></th><th><font color='brown'>Category</font></th><th><font color='brown'>File_Name</font></th><th><font color='brown'>File_Name_Display</font></th><th><font color='brown'>Report_Level</font></th><th><font color='brown'>Display</font></th><th><font color='brown'>Action</font></th></tr>";
	   echo "<tr bgcolor='$table_bg2'>
	         <td><input name='project_group' type='text' size='30' id='project_group'  ></td>
             <td><input name='project_category' type='text' size='30' id='project_category'></td>
			 <td><input name='weblink' type='text' size='30' id='weblink'></td>
	         <td><input name='project_note' type='text' size='30' id='project_note'></td>			 
			 <td><input name='report_level' type='text' size='30' id='report_level'></td>
	         <td><input name='display' type='text' size='15' id='display' ></td>             
             <td><input type=submit name=submit value=add_file></td>
			  </tr>";
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
	  echo "</table>";
	 // echo "<input type='hidden' name='project_category' value='$project_category'>";	
	 echo "</form>";
	 
	     
}


echo "<table border=1>";

echo 

"<tr>
       <th align=left><font color=brown>ID</font></th>
       
       <th align=left><font color=brown>Group</font></th>
       <th align=left><font color=brown>Category</font></th>
       <th align=left><font color=brown>File_Name</font></th>
       
       <th align=left><font color=brown>File_Name_Display</font></th>
       <th align=left><font color=brown>Report Level</font></th>
       <th align=left><font color=brown>Display</font></th>
                    
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
if($editrec==''){


while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>
           <td><a href='administrator_menu.php?editrec=$project_note_id'>$project_note_id</a></td>
           
           <td>$project_group</td>
           <td>$project_category</td>
		   <td>$weblink</td>
		   <td><a href='$weblink' target='_blank'>$project_note</a></td>
           
		   <td>$report_level</td>		   
		   <td>$display</td>
           
           
                 
           
</tr>";

}
}

if($editrec !=''){

$query6="SELECT *
FROM $table
WHERE 1 and project_note_id='$editrec'
ORDER BY project_group,project_category,project_note ";

$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");
$num6=mysqli_num_rows($result6);

echo "<form method='post' action='concessions_files_edit.php'>";
while ($row=mysqli_fetch_array($result6)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>
       
           <td><input type='text' readonly='readonly' name='project_note_id' value=$project_note_id></td>
		   
           <td><input type='text' name='project_group' value=$project_group></td>
           <td><input type='text' name='project_category' value=$project_category></td>
		   <td><textarea name='weblink' rows='2' cols='20'>$weblink</textarea></td>
           <td><textarea name='project_note' rows='2' cols='20'>$project_note</textarea></td>
           <td><input type='text' name='report_level' value=$report_level></td>
		   <td><input type='text' name='display' value=$display></td>
		   <td><input type='submit' name='submit' value='update'></td>
           	             
                 
           
</tr>";

}
echo "</form>";
echo "</table>";
echo "<br />";
echo "<table border=1>";
echo "<tr>
       <th align=left><font color=brown>ID</font></th>
       
       <th align=left><font color=brown>Group</font></th>
       <th align=left><font color=brown>Category</font></th>
       <th align=left><font color=brown>File_Name</font></th>
       
       <th align=left><font color=brown>File_Name_Display</font></th>
       <th align=left><font color=brown>Report Level</font></th>
       <th align=left><font color=brown>Display</font></th>
                    
</tr>";


while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>
           <td><a href='administrator_menu.php?editrec=$project_note_id'>$project_note_id</a></td>
           
           <td>$project_group</td>
           <td>$project_category</td>
		   <td>$weblink</td>
		   <td><a href='$weblink' target='_blank'>$project_note</a></td>
           
		   <td>$report_level</td>		   
		   <td>$display</td>
           
           
                 
           
</tr>";

}
echo "</table>";
}





 
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 

//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
echo "</html>";

?>



















	














