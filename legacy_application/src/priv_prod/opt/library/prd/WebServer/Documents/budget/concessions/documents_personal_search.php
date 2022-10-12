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
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");


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
$table="concessions_documents";

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
$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
echo "<br />";

//include("../../budget/menu1314.php");
include ("../../budget/menu1415_v1.php");
include ("widget1_concessionaire_documents.php");
include ("widget3_concessionaire_documents.php");
//echo $filegroup;

/*
echo "<html>";
echo "<head>
<title>Concessionaire Documents</title>";
*/
//include ("test_style.php");
//include ("test_style.php");

//echo "</head>";
//include("../../budget/menus2.php");

//include ("widget1.php");

//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";

//if($category3 == ''){$category3 = 'all';}

if($category3 == 'all')
{
$query5="SELECT *
FROM $table
WHERE 1 
order by project_category,project_name,project_note ";
}

if($category3 != 'all')
{
$query5="SELECT *
FROM $table
WHERE 1 and category2='$category3'
order by project_category,project_name,project_note ";
}


//echo "query5=$query5<br />";




$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);



echo "<table border=5 cellspacing=5>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

//echo "<th align=left><A href='articles_community_edit.php'>Download from Community</A></th><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th>";
//echo "<tr><th align=left><A href='articles_community_edit.php'>Community</A></th></tr>";
if(!isset($project_category)){$project_category="";}
if($beacnum=='60033162')  //concessions manager Tara Gallagher
{
echo "<tr><th><A href='documents_personal_search.php?&project_category=$project_category&add_your_own=y'>Add your own</A></th></tr>";	
}

 	  
echo "</table>";
echo "<h2 ALIGN=left><font color=brown>Documents:$num5</font></h2>";
if(@$add_your_own=='y' and $beacnum=='60033162'){
echo "<form  method='post' action='document_add.php'>";
echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr><th><font color='brown'>Group</font></th><th><font color='brown'>Category</font></th><th><font color='brown'>Vendor</font></th><th><font color='brown'>Description</font></th><th><font color='brown'>Expiration Date</br>yyyymmdd format</br> example: 20110726</font></th><th>Target Date<br />Purchase & Services</th><th>Target Date<br />Bidding</th></tr>";
	   echo "<tr bgcolor='$table_bg2'>
	         <td><input name='category2' type='text' size='30' id='category2' autocomplete='off'></td>
	         <td><input name='project_category' type='text' size='30' id='project_category' value='$project_category' autocomplete='off' ></td>
             <td><input name='project_name' type='text' size='30' id='project_name' autocomplete='off'></td> 
			 <td><textarea name= 'project_note' rows='2' cols='20' ></textarea></td>
			 <td><input name='expiration_date' type='text' size='30' id='expiration_date' autocomplete='off'></td>             			 
			 <td><input name='target_date_pas' type='text' size='30' id='target_date_pas' autocomplete='off'></td>             			 
			 <td><input name='target_date_bid' type='text' size='30' id='target_date_bid' autocomplete='off'></td>             			 
             <td><input type=submit name=record_insert submit value=add></td>
			  </tr>";
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
	  echo "</table>";
	  echo "<br />";
}

if(@$edit_record=='')
{
echo "<table border=1>";

echo 

"<tr> 
       <th align=left><font color=brown>group</font></th>
       <th align=left><font color=brown>category</font></th>
       <th align=left><font color=brown>Vendor</font></th>
       <th align=left><font color=brown>description</font></th>
       <th align=left><font color=brown>expiration_date</font></th>
       <th align=left><font color=brown>target_date<br />Purchase & Services</font></th>
       <th align=left><font color=brown>target_date<br />Bidding</font></th>";
	   
	   
	   if($beacnum=='60033162')
	   {
	   echo "<th><font color=brown>delete</font></th><th><font color=brown>edit</font></th>";
        }      
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if(@$c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>
           <td>$category2</td>
           <td>$project_category</td>
           <td>$project_name</td>
		   <td><a href='$weblink' target='_blank'>$project_note</a></td>
		   <td>$expiration_date</td>
		   <td>$target_date_pas</td>
		   <td>$target_date_bid</td>  ";
		   
		   if($beacnum=='60033162')
		   {
		   echo "<td><a href='delete_document_verify.php?&project_note_id=$project_note_id' target='_blank'>delete</a></td>
           <td><a href='documents_personal_search.php?&edit_record=y&project_note_id=$project_note_id'>edit</a>";
		   if($project_note_id==$eid)
		   {
		   echo "<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		   }
		   echo "</td>   "; 
           }		   
           
           
      
           
              
           
echo "</tr>";




}

 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 }
 
 if(@$edit_record=='y')
{
$one_record="SELECT *
FROM $table
WHERE 1 
and project_note_id='$project_note_id' ";


$result_one_record=mysqli_query($connection, $one_record) or die ("Couldn't execute query one_record. $one_record");

$row_one_record=mysqli_fetch_array($result_one_record);

extract($row_one_record);


echo "<form  method='post' action='edit_record_concessions_documents.php'>";
echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr><th><font color='brown'>Group</font></th><th><font color='brown'>Category</font></th><th><font color='brown'>Vendor</font></th><th><font color='brown'>Description</font></th><th><font color='brown'>Expiration Date</br>yyyymmdd format</br> example: 20110726</font></th><th>Target Date<br />Purchase & Services</th><th>Target Date<br />Bidding</th></tr>";
	   echo "<tr bgcolor='$table_bg2'>
	         <td><input name='category3' type='text' size='30' id='category3' value='$category3' ></td>
	         <td><input name='project_category' type='text' size='30' id='project_category' value='$project_category' ></td>
             <td><input name='project_name' type='text' size='30' id='project_name' value='$project_name'></td> 
			 <td><textarea name= 'project_note' rows='2' cols='20' >$project_note</textarea></td>
			 <td><input name='expiration_date' type='text' size='30' id='expiration_date' value='$expiration_date'></td> 
			 <td><input name='target_date_pas' type='text' size='30' id='target_date_pas' value='$target_date_pas'></td> 
			 <td><input name='target_date_bid' type='text' size='30' id='target_date_bid' value='$target_date_bid'></td> 			 
             <td><input type=submit name=submit  value=update_record></td>
			  </tr>";
		echo "</table>";	  
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
	  echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";
	  echo "</form>";
	  
}
 
 
 
 
 
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
echo "</html>";

?>



















	














