<?php
extract($_REQUEST);
session_start();
$myusername=$_SESSION['myusername'];

if(!isset($myusername)){
header("location:index.php");
}
extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);echo "<pre>";//exit;
//print_r($_SESSION);echo "</pre>";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

include("../../include/connect.php");
////mysql_connect($host,$username,$password);
$database="mamajone_cookiejar";
$table="projects_menu";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
@mysql_select_db($database) or die( "Unable to select database");

include("../../include/activity.php");//exit;

$query="SELECT *
FROM $table
WHERE 1 and username='$myusername'
and menu_name='webtools'
and menu_type='private'
ORDER BY username,category,topic ";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result = mysqli_query($connection, $query) or die ("Couldn't execute query 1.  $query");

//The number of rows returned from the MySQL query.
$num=mysqli_num_rows($result);

echo "<html>";

echo "<head>

<title>Sites</title>
<style type='text/css'>

body { background-color: $body_bg; }
table { background-color: $body_bg; font-color: blue; font-size: 10;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>

</head>";



echo "<H1 ALIGN=left><font color=brown><i>Private Webtools-$num</i></font></H1>";
echo "<h3><A href='webtools_add.php'>ADD WebTool </A></h3>";
echo "<table border=1>";
 

echo 

"<tr> 
       <th align=left><font color=brown>category</font></th>
       <th align=left><font color=brown>topic</font></th>
       <th><font color=brown>rename</font></th>
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

       <td>$category</td>
           <td>$topic</td>
           <td><a href='rename_webtool.php?&category=$category&topic=$topic'>rename</a></td>
		   <td><a href='copy_webtool.php?&id=$id&category=$category&topic=$topic'>share</a></td> 
		   <td><a href='delete_webtool_verify.php?&category=$category&topic=$topic'>delete</a></td>
           
           
      
           
              
           
</tr>";




}

 echo "</table></body></html>";
 ?>














