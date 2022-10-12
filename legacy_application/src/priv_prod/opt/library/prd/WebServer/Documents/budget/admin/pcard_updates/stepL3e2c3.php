<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}



$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters


include("../../../budget/menu1314.php");

echo "<html>";
echo "<head>";
/*
echo "<style>
body { background-color: #FFF8DC; }
table { background-color: #FFF8DC; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
</style>";
*/
echo "</head>";

//echo "<body bgcolor=>";
//include("../../../budget/menu1314.php");
//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<br /><br />";
echo "<table align='center'><tr><th><i>DPR Card# Duplicates per TABLE=pcard_users</i></th></tr></table>";
//echo "<H1 ALIGN=LEFT > <font color=brown><i>XTND Report Date: $xtnd_report_date</font></i></H1>";
//echo "<H2 ALIGN=center><font size=4><b><A href=/budget/menu.php?forum=blank> Return HOME </A></font></H2>";

echo "<br />";
/*
echo
"<form>";
echo "<font size=5>"; 
echo "fiscal_year:<input name='fiscal_year' type='text' value='$fiscal_year' readonly='readonly'>";
echo "<br />";
echo "start_date:&nbsp<input name='start_date' type='text' value='$start_date' readonly='readonly'>";
echo "<br />";
echo "end_date:&nbsp&nbsp&nbsp<input name='end_date' type='text' value='$end_date' readonly='readonly'>";
//echo "today_date:<input name='today_date'";  echo "type='text'"; echo "value= date('Y-m-d')"; echo "readonly='readonly'>";
echo "</form>";
*/

$query23a="update budget.project_substeps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' and substep_num='$substep_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");



$query5="truncate table pcard_users_count";

mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$query6="insert into pcard_users_count(card_number,records)
         select card_number,count(card_number) as 'records' from pcard_users
		 where 1 and card_number != '' group by card_number";

mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");


$query7="select card_number,records from pcard_users_count where records > 1";
$result7 = mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");
$num7=mysqli_num_rows($result7);


// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
//$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
//$num5=mysqli_num_rows($result5);
//echo "num5=$num5";
////mysql_close();

if($num7==0){echo "<table align='center'><tr><td>NO Duplicate Card Numbers in TABLE=pcard_users</td></tr></table>"; exit;}
echo "<table align='center' border='1'>";
 
echo 

"<tr>        
       <th>card_number</th>
       <th>records</th>
       
 </tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row7=mysqli_fetch_array($result7)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row7);
//echo $status;

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}

//echo $status;

echo 
	
"<tr$t>	
<td>$card_number</td>
<td>$records</td>

   
	      
</tr>";



}

echo "</table>";
echo "<br /><br />";
echo "<table align='center'>";
echo "<tr><td>NOTE1: Card Number 3090 should have 2 records</td></tr>";
echo "<tr><td>NOTE2: Card Number 5896 should have 2 records</td></tr>";
echo "<tr><th colspan='2'><font color='red'>If any other Cards are showing above, please CONTACT Tony P Bass</font></th></tr>";
echo "</table>";
echo "</body></html>";

?>

























