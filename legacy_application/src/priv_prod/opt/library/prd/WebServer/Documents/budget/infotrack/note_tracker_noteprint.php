<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);



//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
*/
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//$keyword_list=variable name for original value(s) brought back to Form from table
//$keyword_list2=variable name for "changed" value(s) passed back to this php file for Update
//$keyword_list3=array created from "changed" values in Variable $keyword_list2
$keyword_list3=explode(",", $keyword_list2);
//print_r ($keyword_list3);
$keyword_list3_count=count($keyword_list3);

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters

if($keyword_update=='y')
{
//echo "query to update TABLE=infotrack_projects_community_com_search<br />";
//echo "keyword_list3_count=$keyword_list3_count<br />";

$query6="delete from infotrack_projects_community_com_search where comment_id='$comment_id' ";
//echo "query6=$query6<br />";//exit;	

$result6=mysqli_query($connection, $query6) or die ("Couldn't execute query 6. $query6");

$query7="insert into infotrack_projects_community_com_search SET";

for($j=0;$j<$keyword_list3_count;$j++){
$query7a=$query7;
	$query7a.=" search_keyword='$keyword_list3[$j]',";	
	$query7a.=" comment_id='$comment_id'";	

//echo "query7a=$query7a<br />";//exit;	

$result7a=mysqli_query($connection, $query7a) or die ("Couldn't execute query 7a. $query7a");
}

//echo "Query2 successful<br />";//exit;
$keyword_update='';
}
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");

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
$table="infotrack_projects_community_com";

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
//echo $filegroup;

/*
echo "<html>";
echo "<head>
<title>Concessions</title>";
*/
//include ("test_style.php");
//include ("test_style.php");

//echo "</head>";
//include ("test_style_headlines.php");
//include("../../budget/menus2.php");
include("../../budget/menu1314.php");
//include ("widget1.php");
//include ("widget1_concessionaire_fees.php");

//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";

$today=date("Y-m-d");

//$comment_id='359';
$query1="SELECT user,system_entry_date,original_entry_date,days_elapsed,alert,message_read,programmer_note from infotrack_projects_community_com
         where comment_id='$comment_id'";
		 
//echo "query1=$query1<br />";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date
$user=substr($user,0,-2);


$query2="SELECT search_keyword as 'keyword_list' from infotrack_projects_community_com_search
         where comment_id='$comment_id'";
		 
//echo "query1=$query1<br />";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");
//9-27-14
//$values=array();
while ($row2=mysqli_fetch_array($result2))
	{
	$choices2[]=$row2['keyword_list'];
	}	

$choices2a = implode(",",$choices2);//exit;

//echo "keyword_list=$choices2a";



/*
Commented out on 6/24/14
if($alert != 'y' and $today >= $system_entry_date)
{
$system_entry_date2=date('m-d-y', strtotime($system_entry_date));
$message="Message Date ".$system_entry_date2;
}
else
{
$message='';
}


if($original_entry_date=='0000-00-00' or $original_entry_date > $today)
{
$alert_message='';
}
else
{
$original_entry_date2=date('m-d-y', strtotime($original_entry_date));
$alert_message="Date ".$original_entry_date2;
}

if($alert=='y' and $original_entry_date <= $today)
{
$days_old_message=$days_elapsed." days old";
}
else
{
$days_old_message='';
}
*/
//echo "user=$user";//exit;


$query5="SELECT comment_note
FROM infotrack_projects_community_com
WHERE comment_id='$comment_id'
";

//echo "query5=$query5<br />";


$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);



//echo "<table border=5 cellspacing=5>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

//echo "<th align=left><A href='articles_community_edit.php'>Download from Community</A></th><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th>";
//echo "<tr><th align=left><A href='articles_community_edit.php'>Community</A></th></tr>";
//echo "<tr><th><A href='document_add.php?&project_category=$project_category&add_your_own=y'>Add your own</A></th></tr>";	

 	  
//echo "</table>";
//echo "<h2 ALIGN=left><font color=brown>Documents:$num5</font></h2>";



/*
comment out on 6/24/14
echo "<table><tr><th>$user<br />Message ID $comment_id<br />$message $alert_message<br />$days_old_message</th></tr></table>";
*/
$message=date('m-d-y', strtotime($system_entry_date));
/*
echo "<table><tr><th>$user<br />$message<br />Message ID $comment_id</th></tr></table>";
*/


echo "<table border=1 align='center'>";
//echo "<tr><th>Headlines History</th></tr>";
echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left>";
 if($message_read=='n'){echo "<img height='40' width='60' src='/budget/infotrack/icon_photos/under_review1.png' alt='picture of home'></img>&nbsp;&nbsp;&nbsp;";}
 if($message_read=='y'){echo "<img height='40' width='40' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of home'></img>&nbsp;&nbsp;&nbsp;";} 
 //echo "Message ID $comment_id&nbsp;&nbsp;&nbsp;($user&nbsp;&nbsp; $message)</font></th>";
 echo "Message from $user on  $message&nbsp;&nbsp; (ID $comment_id)</font>";
 
 if($level==5){echo "<br /><form name='keyword_list_update' action='note_tracker_noteprint.php'>Keyword List&nbsp;&nbsp;<input name='keyword_list2' type='text' size='50' value='$choices2a'><input type='submit' name='submit' value='Update'><input type='hidden' name='comment_id' value='$comment_id'><input type='hidden' name='keyword_update' value='y'></form>";}
 echo "</th>";
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);
$comment_note=str_replace('  ','&nbsp;&nbsp;',$comment_note);
$comment_note=nl2br($comment_note);

/*
$cy_amount=number_format($cy_amount,2);
$py1_amount=number_format($py1_amount,2);
$py2_amount=number_format($py2_amount,2);
$py3_amount=number_format($py3_amount,2);
$py4_amount=number_format($py4_amount,2);
$py5_amount=number_format($py5_amount,2);
$py6_amount=number_format($py6_amount,2);
$py7_amount=number_format($py7_amount,2);
$py8_amount=number_format($py8_amount,2);
$py9_amount=number_format($py9_amount,2);
*/

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($message_read=="y"){$bgc="#C2EFBC";} else {$bgc="lightsalmon";}
echo 

"<tr bgcolor=$bgc align='left'>";

       //echo "<td>$category</td>";
     echo "<td>$comment_note</td>";		   
                  
          // echo "<td><a href='vendor_fees_drilldown1.php?vendor_name=$vendor&f_year=$f_year&park=$park&ncas_center=$center' target='_blank'>transactions</a></td>";
                    
      
           
              
           
echo "</tr>";




}



 echo "</table>";
 echo "<br />";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
//if($level==5){include("slide_toggle_messages1.php");}
 //echo "hello world<br />";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>



















	














