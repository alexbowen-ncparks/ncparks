<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}



$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters


//include("../../../budget/menu1314.php");

//$start_date2=str_replace("-","",$start_date);
//$end_date2=str_replace("-","",$end_date);
if($dpr_update != 'y')
{
	
include("../../../budget/menu1314.php");	
//echo "<br />cardholder3=$cardholder3";
//echo "<br />card_number3=$card_number3";
echo "<html>";
echo "<head>";


echo "</head>";

//echo "<body bgcolor=>";
//include("../../../budget/menu1314.php");
//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<br /><br />";
echo "<table align='center'><tr><th><i>DNCR Cards with Division=Blank</i></th></tr></table>";
//echo "<H1 ALIGN=LEFT > <font color=brown><i>XTND Report Date: $xtnd_report_date</font></i></H1>";
//echo "<H2 ALIGN=center><font size=4><b><A href=/budget/menu.php?forum=blank> Return HOME </A></font></H2>";

echo "<br />";

$query1="update pcard_unreconciled_xtnd_temp2,pcard_unreconciled_xtnd_temp2_perm_unique
set pcard_unreconciled_xtnd_temp2.division=pcard_unreconciled_xtnd_temp2_perm_unique.division,
pcard_unreconciled_xtnd_temp2.dpr=pcard_unreconciled_xtnd_temp2_perm_unique.dpr
where
pcard_unreconciled_xtnd_temp2.card_number2=pcard_unreconciled_xtnd_temp2_perm_unique.card_number2
and pcard_unreconciled_xtnd_temp2.cardholder=pcard_unreconciled_xtnd_temp2_perm_unique.cardholder
and pcard_unreconciled_xtnd_temp2.division='' ";

mysql_query($query1) or die ("Couldn't execute query 1.  $query1");


if($card_number3!='')
{	
if($emp=='y')
{
$query2e="update pcard_unreconciled_xtnd_temp2
          set division2='DPR_MANUAL'
		  where cardholder='$cardholder3' and card_number2='$card_number3' ";
}


if($emp=='n')
{
$query2e="update pcard_unreconciled_xtnd_temp2
          set division2='OTHER'
		  where cardholder='$cardholder3' and card_number2='$card_number3' ";
}


		  
//echo "<br />query2e=$query2e<br />";		  
mysql_query($query2e) or die ("Couldn't execute query 2e.  $query2e");



}


$query5="SELECT xtnd_report_date,cardholder,card_number2,division2,count(id) as 'records' FROM pcard_unreconciled_xtnd_temp2 where division='' 
         group by xtnd_report_date,cardholder,card_number2 order by xtnd_report_date,cardholder,card_number2 ";


//echo "<br />Query5=$query5<br /><br />";;
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result5 = mysql_query($query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysql_num_rows($result5);
//echo "num5=$num5";
mysql_close();

if($num5==0){echo "<table align='center'><tr><td>NO Cardholders Missing</td></tr></table>"; exit;}
echo "<table align='center' border='1'>";
 
echo 

"<tr>";        
 //echo "<th>xtnd_report_date</th>";
 echo "<th>cardholder</th>
       <th>card_number2</th>
       <th>records</th>
       <th colspan='2'>DPR Employee</th>
 </tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
while ($row5=mysql_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row5);
//echo $status;
//if($cardholder2==$cardholder){$cardholder2="\"";}else {$cardholder2=$cardholder;}
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
//if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}

$table_bg2="cornsilk";

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}
//echo $status;

echo 
	
"<tr$t>	
<td>$cardholder</td>
<td>$card_number2</td>
<td>$records</td>";
if($division2=='')
{
echo "<td><a href='stepL3e2c1a.php?cardholder3=$cardholder&card_number3=$card_number2&emp=y'>YES</a></td>"; 
echo "<td><a href='stepL3e2c1a.php?cardholder3=$cardholder&card_number3=$card_number2&emp=n'>NO</a></td>"; 
}  
	
if($division2=='DPR_MANUAL')
{
echo "<td><a href='stepL3e2c1a.php?cardholder3=$cardholder&card_number3=$card_number2'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></a></td>"; 
}  

if($division2=='OTHER')
{
echo "<td><a href='stepL3e2c1a.php?cardholder3=$cardholder&card_number3=$card_number2'><img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of green check mark'></img></a></td>"; 
}  


	
echo "</tr>";

//$cardholder2=$cardholder;

}

echo "</table>";
echo "<br /><br />";
echo "<table align='center'>";
echo "<tr><th><font color='red'>WARNING! ONLY Click Submit when \"DPR Employee Status\" of each Cardholder has been MARKED with Checkmark or Xmark</font></th></tr>";
echo "</table>";
echo "<br /><br />";
//echo "<table align='center'>";
echo "<form action='stepL3e2c1a.php' align='center'><input type='submit' name='submit' value='Submit'><input type='hidden' name='dpr_update' value='y'></form>";
//echo "</table>";

echo "</body></html>";
}

if($dpr_update=='y')
{



$query22="update pcard_unreconciled_xtnd_temp2
          set division=division2
          where division=''		  ";
		  
		  
//echo "<br />Query22: $query22<br />"; exit;			  
			 
mysql_query($query22) or die ("Couldn't execute query 22.  $query22");


$query22a="update pcard_unreconciled_xtnd_temp2
          set dpr='y'
          where division='DPR_MANUAL'		  ";
		  
		  
//echo "<br />Query22: $query22<br />"; exit;			  
			 
mysql_query($query22a) or die ("Couldn't execute query 22a.  $query22a");





	
$query23a="update budget.project_substeps_detail set status='complete' where project_category='FMS'
         and project_name='pcard_updates' and step_group='L' and step_num='3e' and substep_num='2c1a' ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");


{header("location: stepL3e.php?project_category=fms&project_name=pcard_updates&step_group=L&step_num=3e ");}



}



?>

























