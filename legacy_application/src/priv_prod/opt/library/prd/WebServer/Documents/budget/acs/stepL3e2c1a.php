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

$start_date2=str_replace("-","",$start_date);
$end_date2=str_replace("-","",$end_date);
echo "<br />cardholder3=$cardholder3";
echo "<br />card_number3=$card_number3";
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
/*
echo "<script language='JavaScript'>

function confirmLink()
{
 bConfirm=confirm('Are you sure this a DPR Employee($cardholder3)?')
 return (bConfirm);
}




";
echo "</script>";
*/

echo "</head>";

//echo "<body bgcolor=>";
//include("../../../budget/menu1314.php");
//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<br /><br />";
echo "<table align='center'><tr><th><i>DNCR Cards with Division=Blank</i></th></tr></table>";
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


if($card_number3!='')
{	
$query2e="update pcard_unreconciled_xtnd_temp2
          set division2='DPR'
		  where cardholder='$cardholder3' and card_number2='$card_number3' ";
		  
echo "<br />query2e=$query2e<br />";		  
mysqli_query($connection, $query2e) or die ("Couldn't execute query 2e.  $query2e");



}



if($card_number3=='')
{	
$query2e="update pcard_unreconciled_xtnd_temp2
          set xtnd_report_date='$end_date2'
		  where 1 ";
		  
		  
mysqli_query($connection, $query2e) or die ("Couldn't execute query 2e.  $query2e");

$query1="update pcard_unreconciled_xtnd_temp2
         set card_number2=substring(card_number,-4)
         where 1		 ";
		  
		  
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query0="update pcard_unreconciled_xtnd_temp2
         set dpr='y' where (division='park' or division='canc' or division='capi') ";
		  
echo "<br />query0=$query0<br />";	
mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");





}




$query5="SELECT xtnd_report_date,cardholder,card_number2,division2,count(id) as 'records' FROM pcard_unreconciled_xtnd_temp2 where division='' 
         group by xtnd_report_date,cardholder,card_number2 order by xtnd_report_date,cardholder,card_number2 ";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);
//echo "num5=$num5";
////mysql_close();

if($num5==0){echo "<table align='center'><tr><td>NO Cardholders Missing</td></tr></table>"; exit;}
echo "<table align='center' border='1'>";
 
echo 

"<tr>        
       <th>xtnd_report_date</th>
       <th>cardholder</th>
       <th>card_number2</th>
       <th>records</th>
       <th>DPR</th>
 </tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row5=mysqli_fetch_array($result5)){

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
<td>$xtnd_report_date</td>
<td>$cardholder</td>
<td>$card_number2</td>
<td>$records</td>";
if($division2!='DPR')
{
echo "<td><a href='stepL3e2c1a.php?cardholder3=$cardholder&card_number3=$card_number2' >DPR=yes</a></td>"; 
}  
	
if($division2=='DPR')
{
echo "<td><a href='stepL3e2c1a.php?cardholder3=$cardholder&card_number3=$card_number2'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></a></td>"; 
}  

	
echo "</tr>";

//$cardholder2=$cardholder;

}

echo "</table></body></html>";

?>

























