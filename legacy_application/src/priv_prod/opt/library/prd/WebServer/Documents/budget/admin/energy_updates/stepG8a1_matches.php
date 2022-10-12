<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
//echo "hello";exit;


echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
</style>

</head>";


//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";

echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-StepGroup $step_group-$step</font></i></H1>";
echo "<H3 ALIGN=LEFT > <font color=blue>StepName-$step_name</font></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates> Return Weekly Updates-HOME </A></font></H2>";
echo "<H2 ALIGN=center>"; 

echo "</H3>";

echo "<br />";



$query3="select 
center,account,trans_amount,xtnd_date,id as 'id1646'
from pcard_utility_xtnd_1646_ws
where center='$center' and account='$account' and trans_amount='$trans_amount'
and posted='n'
order by center,account,trans_amount,xtnd_date
";
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
//echo $num3;exit;
//////mysql_close();
echo "<H3><font color=red>Record Count=$num3</font></H3>";
echo "<table border=1>";
 
echo "<tr>"; 
    
 //echo " <th><font color=blue>Company</font></th>";
 echo " <th><font color=blue>Center</font></th>";
 echo " <th><font color=blue>Account</font></th>";
 echo " <th><font color=blue>Trans Amount</font></th>";
 echo " <th><font color=blue>Trans Date</font></th>";
 //echo " <th><font color=blue>Sign</font></th>";
 //echo " <th><font color=blue>Account_Description</font></th>";
  echo " <th><font color=blue>ID1646</font></th>"; 
           
  
echo "</tr>";

echo  "<form method='post' autocomplete='off' action='stepG8a1_update_all.php'>";

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
//if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
if($sign=="credit"){$amount="-".$amount;}
//if($sign=="credit"){$oft="<font color='red'>";} else {$oft="<font color='black'>";}


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr$t>";	      
//echo "<form method=post action=stepG5_update.php>";
echo  "<td>$center</td>";	
echo  "<td>$account</td>"; 
echo  "<td>$trans_amount</td>"; 
echo  "<td>$xtnd_date</td>";
//echo  "<td>$sign</td>";
echo  "<td>$id1646</td>";
echo "</tr>"; 
}
echo "</table>";
	

echo "</html>";



?>

























