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
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters



if($status != 'complete')
{
	
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
echo "<table align='center'><tr><th><i>Cardholders(per XTND) missing in TABLE=pcard_users</i></th></tr></table>";
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

/*
$query23a="update budget.project_substeps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' and substep_num='$substep_num' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");
*/


$query5="SELECT xtnd_report_date,cardholder,card_number2,id FROM pcard_unreconciled_xtnd_temp2 where dpr='y' and pcard_users_match != 'y' ";
echo "<br />query5=$query5<br />";


// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result5 = mysql_query($query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysql_num_rows($result5);
//echo "num5=$num5";
mysql_close();

if($num5==0){echo "<table align='center'><tr><td>NO Cardholders Missing</td><td><a href='stepL3e2c2.php?status=complete'>Mark Complete</a></td></tr></table>"; exit;}
echo "<table align='center' border='1'>";
 
echo 

"<tr>        
       <th>xtnd_report_date</th>
       <th>cardholder</th>
       <th>card_number2</th>
       <th>id</th>
 </tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
while ($row5=mysql_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row5);
//echo $status;

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
//if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}

//echo $status;

echo 
	
"<tr$t>	
<td>$xtnd_report_date</td>
<td>$cardholder</td>
<td>$card_number2</td>
<td>$id</td>
   
	      
</tr>";



}

echo "</table></body></html>";
}

if($status=='complete')
{

/*

$query22="update pcard_unreconciled_xtnd_temp2
          set division=division2
          where division=''		  ";
		  
		  
  
			 
mysql_query($query22) or die ("Couldn't execute query 22.  $query22");


$query22a="update pcard_unreconciled_xtnd_temp2
          set dpr='y'
          where division='DPR_MANUAL'		  ";
		  
		  
	  
			 
mysql_query($query22a) or die ("Couldn't execute query 22a.  $query22a");

*/



	
$query23a="update budget.project_substeps_detail set status='complete' where project_category='FMS'
         and project_name='pcard_updates' and step_group='L' and step_num='3e' and substep_num='2c2' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");


//{header("location: stepL3e.php?project_category=fms&project_name=pcard_updates&step_group=L&step_num=3e ");}
//echo "<table align='center'><tr><td>Update Successful</td><td><a href='stepL3e.php?project_category=fms&project_name=pcard_updates&step_group=L&step_num=3e'>Return to PCARD Update</a></td></tr></table>";


{header("location: stepL3e.php?project_category=fms&project_name=pcard_updates&step_group=L&step_num=3e ");}

}









?>

























