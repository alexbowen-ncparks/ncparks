<?php


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters

mysql_select_db($database, $connection); // database 



	// Retrieve data from Query String
//$comment_note2 = $_GET['comment_note2'];
$project_category = $_GET['project_category'];
$project_name = $_GET['project_name'];
$note_group = $_GET['note_group'];
$project_note_id = $_GET['project_note_id'];

	// Escape User Input to help prevent SQL Injection
//$age = mysql_real_escape_string($age);
//$sex = mysql_real_escape_string($sex);
//$wpm = mysql_real_escape_string($wpm);
	//build query
//$query = "";

/*
$query = "select user,project_note,comment_note,weblink,note_group,project_note_id from infotrack_projects where 1 
         and user='$myusername' 
		 and project_category='$project_category'
		 and project_name='$project_name'
		 and note_group='$note_group'
		 and comment_id='$project_note_id'
		 $order2";
*/		 
		 
$query = "select user,project_note,comment_note,weblink,note_group,project_note_id as 'project_note_id2' from infotrack_projects_community4 where 1 and project_category='$project_category' and project_name='$project_name' and note_group='$note_group' and comment_id='$project_note_id' order by project_note_id desc ";		 
//echo "query=$query<br />";		 
		 
		 
		 
		 
		 
/*		 
		 
if(is_numeric($age))
	$query .= " AND ae_age <= $age";
if(is_numeric($wpm))
	$query .= " AND ae_wpm <= $wpm";
	
	*/
	//Execute query
$qry_result = mysql_query($query) or die(mysql_error());

	//Build Result String
$display_string = "<table>";
/*
$display_string .= "<tr>";
$display_string .= "<th>Name</th>";
$display_string .= "<th>Age</th>";
$display_string .= "<th>Sex</th>";
$display_string .= "<th>WPM</th>";
$display_string .= "</tr>";
*/
	// Insert a new row in the table for each person returned
while($row = mysql_fetch_array($qry_result)){

$comment_note=str_replace('  ','&nbsp;&nbsp;',$row[comment_note]);
$comment_note=nl2br($comment_note);
$comment_note=str_replace('  ','&nbsp;&nbsp;',$row[comment_note]);
if($table_bg2==''){$table_bg2='cornsilk';}
    if($color==''){$bgc=" bgcolor='$table_bg2' ";$color=1;}else{$bgc='';$color='';}


	$display_string .= "<tr$bgc>";
	$display_string .= "<td><font color='brown'>$row[user]</font></td>";
//	$display_string .= "<td><font color='brown'>$row[project_note_id2]</font></td>";	
	$display_string .= "<td>$comment_note</td>";
	$display_string .= "</tr>";
	
}
//echo "Query: " . $query . "<br />";
$display_string .= "</table>";
echo $display_string;
?>