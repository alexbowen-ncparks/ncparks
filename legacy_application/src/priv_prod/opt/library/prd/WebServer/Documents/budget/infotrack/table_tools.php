<?php
extract($_REQUEST);
session_start();
$myusername=$_SESSION['myusername'];
$level=$_SESSION['level'];

if(!isset($myusername)){
header("location:index.php");
}


//echo "<pre>";print_r($_SERVER);echo "<pre>";//exit;
//print_r($_SESSION);echo "</pre>";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo $level;exit;
if($level != '5'){echo "Unauthorized access";exit;}

include("../../include/connect.php");
$dbname="mamajone_cookiejar";


////mysql_connect($host,$username,$password);
@mysql_select_db($dbname) or die( "Unable to select database");

echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>
	


</head>";

//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name</font></i></H1>";
echo "<H3 ALIGN=LEFT > <font color=blue>$step_name</font></H3>";
echo "<H2 ALIGN=center><b><A href=/budget/admin/table_tools/main.php?project_category=fms&project_name=table_tools>Table Tools-HOME </A></font></H2>";


echo "<br />";



$sql = "SHOW TABLES FROM $dbname";
$result = mysqli_query($connection, $sql);
$num=mysqli_num_rows($result);
echo "<H1><font color='blue'>records=$num</font></H1>";
while($col=mysqli_fetch_array($result)){
$tables[]=$col[0];
}
//echo "<pre>";print_r($tables);"</pre>";exit;

if($tabdel != ""){echo "<H2><font color='red'>Table $tabdel has been deleted</font></H2>";}
echo "<table border=1>";
 
echo "<tr>"; 
    
 echo " <th><font color=blue>Table</font></th>";
 echo " <th><font color=blue>Action</font></th>";
 echo "</tr>";


for ($n=0;$n<$num;$n++){
echo "<form method='post' action='table_delete_verify.php'>";
//echo "<font size=10>"; 
if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}	
echo "<tr$t>";	      
	  	   
echo  "<td>$tables[$n]</td>";
	      

echo "<input type='hidden' name='tabname' value='$tables[$n]'>";
echo "<input type='hidden' name='dbname' value='$dbname'>";
echo  "<td><input type='submit' name='submit2' value='DELETE'>";
echo   "</form>";
echo "</td>";
echo "</tr>";

}	 
echo "</table>";
	

echo "</html>";
	

?>






 




















