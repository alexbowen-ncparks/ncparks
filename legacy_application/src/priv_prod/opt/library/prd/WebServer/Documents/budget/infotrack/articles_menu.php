<?php

session_start();


$file = "articles_menu.php";
$lines = count(file($file));


$table="project_articles";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$active_file=$_SERVER['SCRIPT_NAME'];
$active_file_request=$_SERVER['REQUEST_URI'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$infotrack_location=$_SESSION['budget']['select'];
$infotrack_center=$_SESSION['budget']['centerSess'];




//echo "<pre>";print_r($_SERVER);"</pre>";

//echo "active_file=$active_file<br />";
//echo "active_file_request=$active_file_request<br />";


extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
if($level=='5' and $tempID !='Dodd3454')

//{echo "<pre>";print_r($_SESSION);"</pre>";}//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;


include("../../../include/connectBUDGET.inc");// database connection parameters
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

//echo "f_year=$f_year";


//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}


/*
if($level=='5' and $tempID !='Dodd3454')
{
echo "beacon_number:$beacnum";
echo "<br />";
echo "infotrack_location:$infotrack_location";
echo "<br />";
echo "infotrack__center:$infotrack_center";
echo "<br />";
}
*/
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
$query11="SELECT filegroup,report_name
from infotrack_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>
<title>InfoTrack</title>";

include ("test_style.php");


echo "</head>";
include("report_header1.php");
include("report_header2.php");
include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";

$query4="select distinct project_category from $table where 1 
         and user='$tempID' 
         order by project_category";
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);

//echo "<html>";

 if($category_selected !='y') 
 
{
//echo "<h2 ALIGN=left><font color=green>WebGroups:$num4</font></h2>";

//
echo "<table border=3 cellspacing=3>";

//$row=mysqli_fetch_array($result);

echo "<form method=post action=articles_personal_search.php>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

//echo "<th align=left><A href='articles_community_edit.php'>Download from Community</A></th><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th>";
echo "<tr bgcolor='yellow'><th align=left><A href='articles_menu.php'>Personal</A></th>
      <td><input name='search_term' type='text' size='30' id='search_term'></td>
      <td><input type='submit' name='article_search' value='Search'></td></tr>";
echo "<tr><th align=left><A href='articles_menu_community.php'>Community</A></th></tr>";
//echo "<tr><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th></tr>";	
echo "</form>";
 	  
echo "</table>";
echo "<br />";
echo "<br />";


echo "<table border=1>";

echo "<form method=post autocomplete='off' action=article_category_add.php>";


       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr><th>
	         <td><input name='project_category' type='text' size='30' id='project_category'></td>
          	 <td><input type='submit' name='submit' value='Add Category'>			 
			  </tr>";
      // echo "<tr><th>Weblink</th><td><textarea name= 'weblink' rows='1' cols='40'></textarea></td></tr>";
	  // echo "<tr><td colspan='4' align='center'><input type='submit' value='UPDATE'></td></tr>";
	  
	  echo "</form>";
	  echo "</table>";
	 // echo "<input type='hidden' name='project_category' value='$project_category'>";	
	 

echo "</table>";



echo "<table border=1>";

while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);

if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           <td><a href='articles_menu.php?&project_category=$project_category&category_selected=y'>$project_category</a></td> 
	          
</tr>";

}

 echo "</table>";
/* 
echo"<font color='brown' size='5'>";
echo"<b>";
echo "$file=$lines lines<br /";
echo"</b>";
echo"</font>";
//{$menuArray0['Info_Tracker']="/budget/infotrack/articles_menu.php";}
//echo "<table border='1'><tr>";
//echo "<tr><th>Name</th><th>Value</th><tr>";

$variablesB=array(
array(
"name"=>"active_file",
"value"=>$active_file
),
array(
"name"=>"active_file_request",
"value"=>$active_file_request
),
array(
"name"=>"level",
"value"=>$level
)
);
echo "<table>";

echo "<tr><td>";echo $variablesB[0]["value"];echo "</td></tr>";
echo "<tr><td>";echo $variablesB[1]["value"];echo "</td></tr>";
echo "<tr><td>";echo $variablesB[2]["value"];echo "</td></tr>";
echo "</table>";
echo "<pre>variablesB ";print_r($variablesB);"</pre>";


$movies = array(
  array(
    "title" => "Rear Window",
    "director" => "Alfred Hitchcock",
    "year" => 1954
  ),
  array(
    "title" => "Full Metal Jacket",
    "director" => "Stanley Kubrick",
    "year" => 1987
  ),
  array(
    "title" => "Mean Streets",
    "director" => "Martin Scorsese",
    "year" => 1973
  )
);

echo "The title of the first movie:<br />";
echo $movies[0]["title"] . "<br /><br />";

echo "The director of the third movie:<br />";
echo $movies[2]["director"] . "<br /><br />";

echo "The nested array contained in the first element:<br />";
print_r( $movies[0] );
echo "<br /><br />";


$variablesA=array(
"0"=>array("name"=>'',"value"=>''),
"1"=>array("active_file"=>$active_file),
"2"=>array("active_file_request"=>$active_file_request)

);

foreach($variablesA as $key=>$value){

echo "<tr>";

"<td>$value</td>";
echo "</tr>";
}
*/
//$variablesA=array(array("active_file_request"=>$active_file_request));

/*
$variablesA["active_file_request"]=$active_file_request;
$variablesA["level"]=$level;
$variablesA["posTitle"]=$posTitle;
$variablesA["tempID"]=$tempID;
$variablesA["beacnum"]=$beacnum;
$variablesA["infotrack_location"]=$infotrack_location;
$variablesA["infotrack_center"]=$infotrack_center;
$variablesA["body_bg"]=$body_bg;
$variablesA["table_bg"]=$table_bg;
$variablesA["table_bg2"]=$table_bg2;
$variablesA["table"]=$table;
$variablesA["category_selected"]=$category_selected;

$variable_count=count($variablesA);
echo "variable_count=$variable_count";
for ($i = 1; $i <= $variables_count; $i++) {$ARRAY[]=$variablesA[$i];}
*/
//echo "<pre>";print_r($variablesA);"</pre>";


exit;
}





echo "</body></html>";
 


if($category_selected =='y')
{




$query5="SELECT *
FROM $table
WHERE 1 and user='$tempID'
and project_category='$project_category'
ORDER BY user,project_category,project_name ";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);



echo "<table border=5 cellspacing=5>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

//echo "<th align=left><A href='articles_community_edit.php'>Download from Community</A></th><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th>";
//echo "<tr><th align=left><A href='articles_community_edit.php'>Community</A></th></tr>";
echo "<tr><th><A href='article_add.php?&project_category=$project_category&add_your_own=y'>Add your own</A></th></tr>";	

 	  
echo "</table>";
echo "<h2 ALIGN=left><font color=brown>$project_category articles:$num5</font></h2>";

echo "<table border=1>";

echo 

"<tr> 
       
       <th align=left><font color=brown>group</font></th>
       <th align=left><font color=brown>description</font></th>
       <th align=left><font color=brown>date_saved</font></th>
       <th align=left><font color=brown>id</font></th>
       <th><font color=brown>rename</font></th>
	   <th><font color=brown>share</font></th>	   
       <th><font color=brown>delete</font></th>
              
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>

       
           <td>$project_name</td>
		   <td><a href='$weblink' target='_blank'>$project_note</a></td>
           <td>$system_entry_date</td>
           <td>$project_note_id</td>
		   <td><a href='rename_article.php?&project_note_id=$project_note_id' target='_blank'>rename</a></td>
		   <td><a href='copy_article.php?&project_note_id=$project_note_id&project_category=$project_category' target='_blank'>share</a></td> 
		   <td><a href='delete_article_verify.php?&project_note_id=$project_note_id' target='_blank'>delete</a></td>
           
           
      
           
              
           
</tr>";




}

 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 
 
 echo "</body></html>";



}
else {exit;}

?>



















	














