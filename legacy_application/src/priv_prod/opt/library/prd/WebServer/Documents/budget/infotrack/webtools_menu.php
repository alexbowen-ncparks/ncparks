<?php

session_start();
$myusername=$_SESSION['myusername'];
$active_file=$_SERVER['SCRIPT_NAME'];
//echo "<br />";
//echo $active_file;
//echo "<br />";
if(!isset($myusername)){
header("location:index.php");
}
extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);echo "<pre>";//exit;
//echo "<pre>";print_r($_SESSION);echo "<pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

include("../../include/connect.php");

////mysql_connect($host,$username,$password);
$database="mamajone_cookiejar";
$table="projects_menu";
$table2="projects_filegroup";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
@mysql_select_db($database) or die( "Unable to select database");

include("../../include/activity.php");//exit;

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from projects_customformat
WHERE 1 and user_id='$myusername'
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;
echo "body_bg:$body_bg";
echo "<br />";
echo "table_bg:$table_bg";
echo "<br />";
echo "table_bg2:$table_bg2";


$query11="SELECT filegroup
from projects_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
echo "<br />";
//echo $filegroup;

echo "<html>";
echo "<head>
<title>Sites</title>";

include ("css/test_style.php");
/*
<style type='text/css'>
body { background-color: $body_bg; }
table { background-color: $body_bg; font-color: blue; font-size: 10;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
</style>
*/
echo "</head>";
/*
 if($category_selected !='y') {
echo "<H1 ALIGN=left><font color=brown><i>$myusername-WebGroups</i></font></H1>";}
else {echo "<H1 ALIGN=left><font color=brown><i>$myusername-WebSites</i></font></H1>";}
*/
include("widget1.php");//exit;
//echo "<table>";
//echo "<tr>";
//echo "<td><a href='webtools_menu.php?&webgroups_selected=y'>Site Library</a></td>";
//echo "</tr>";
//echo "</table>";

//if($favorite_site_selected !='y' and $webgroups_selected !='y'){exit;}

//if($favorite_site_selected =='y')

//{

$query3="SELECT menu_display,web_address
FROM $table
WHERE 1 and username='$myusername'
and menu_name='webtools'
and menu_type='private'
ORDER BY username,category,topic ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);


echo "<table border=1>";
 

echo 

"<tr> 
       
       <th align=left><font color=brown>Favorite Sites</font></th><th><A href='webtools_add.php'>ADD</A></th>
              
              
</tr>";
echo "</table>";

echo "<table border=1>";




while ($row3=mysqli_fetch_array($result3)){


extract($row3);

if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>

       
           <td><a href='$web_address' target='_blank'>$menu_display</a></td>     
            
           
</tr>";

}

//echo "<td><a href='webtools_menu.php?&webgroups_selected=y'>Site Library</a></td>";


echo "</table>";
//echo "<h3><A href='webtools_add.php'>ADD</A></h3>";
echo "</html>";

/*


if($webgroups_selected =='y'){echo "webgroups selected";exit;}
echo "</html>";


{
echo "<br />";

$query3="SELECT menu_display,web_address
FROM $table
WHERE 1 and username='$myusername'
and menu_name='webtools'
and menu_type='private'
and favorite='y'
ORDER BY username,category,topic ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);

//echo "<html>";

//echo "<h3 ALIGN=left><font color=green>$category websites:$num5</font></h3>";

echo "<table border=1>";
 

echo 

"<tr> 
       
       <th align=left><font color=brown>Favorite Sites</font></th>
              
              
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);

if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>

       
           <td><a href='$web_address' target='_blank'>$menu_display</a></td>     
            
           
</tr>";

}
echo "</table>";
exit;

}

/*
//echo "<tr><a href='webtools_menu.php?&view_all=y'>view all</a></tr>";

 



	
$query4="SELECT distinct category
FROM $table
WHERE 1 and username='$myusername'
and menu_name='webtools'
and menu_type='private'
ORDER BY category ";

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);

echo "<br />";
//echo "<h2 ALIGN=left><font color=green>WebGroups:$num4</font></h2>";

//
echo "<table border=1>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<th align=left><font color=brown>WebGroups</font></th>"; 

while ($row=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);

if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           <td><a href='webtools_menu.php?&category=$category&category_selected=y'>$category</a></td> 
	          
</tr>";

}

 echo "</table>";
 echo "<h3><A href='webtools_add.php'>ADD</A></h3>";
 exit;}


if($category_selected =='y')
{
$query5="SELECT *
FROM $table
WHERE 1 and username='$myusername'
and category='$category'
and menu_name='webtools'
and menu_type='private'
ORDER BY username,category,topic ";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);

//echo "<html>";

echo "<h3 ALIGN=left><font color=green>$category websites:$num5</font></h3>";

echo "<table border=1>";
 

echo 

"<tr> 
       
       <th align=left><font color=brown>website</font></th>
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

if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t>

       
           <td><a href='$web_address' target='_blank'>$topic</a></td>
		   <td><a href='rename_webtool.php?&category=$category&topic=$topic&id=$id'>rename</a></td>
		   <td><a href='copy_webtool.php?&id=$id&category=$category&topic=$topic&id=$id'>share</a></td> 
		   <td><a href='delete_webtool_verify.php?&category=$category&topic=$topic&id=$id'>delete</a></td>
		   
           
           
      
           
              
           
</tr>";




}

 echo "</table>";
 
 echo "<h3><A href='webtools_add.php'>ADD</A></h3>";
echo " </body></html>";
 


}
else {exit;}
exit;
}

*/

?>

























