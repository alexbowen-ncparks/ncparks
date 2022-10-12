<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
echo "<html>";
echo "<head>

<script type=\"text/javascript\" src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.js\"></script>";

echo "<script type='text/javascript'>
$(document).ready(function() {
$('input[type=checkbox]').change(function(){
  recalculate();
});
function recalculate(){
    var sum = 0;
    $('input[type=checkbox]:checked').each(function(){
      sum += parseInt($(this).attr('rel'));
    });
  //  alert(sum);
$('#output').html(sum);
}
}); 
</script>";



echo "<style>
body { background-color: #FFF8DC; }
table { background-color: #FFF8DC; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
.normal {background-color:#B4CDCD;}
.normal2 {background-color:yellow;}
.highlight {background-color:#ff0000;} 
</style>

<script type=\"text/javascript\"> function onRow(rowID)
{var row=document.getElementById(rowID);
var curr=row.className;
if(curr.indexOf(\"normal\")>=0)row.className=\"highlight\";else row.className=\"normal\";
 } 
</script>



</head>";


//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
if(!isset($step)){$step="";}
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-StepGroup $step_group-$step</font></i></H1>";
//echo "<H3 ALIGN=LEFT > <font color=blue>StepName-$step_name</font></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates> Return Weekly Updates-HOME </A></font></H2>";
echo "<H2 ALIGN=center>"; 
//echo  "<form method='post' action='stepG5_update_all.php'>";
//echo "<input type='submit' name='submit2' value='UpdateAllRecords'>";
//echo   "</form>";
echo "</H3>";

/*<font color=blue>StepName-$step_name</font></H1>";
echo "<br />";
echo
"<form>";
echo "<font size=5>"; 
echo "fiscal_year:<input name='fiscal_year' type='text' value='$fiscal_year' readonly='readonly'>";
echo "<br />";
echo "start_date:<input name='start_date' type='text' value='$start_date' readonly='readonly'>";
echo "<br />";
echo "end_date:<input name='end_date' type='text' value='$end_date' readonly='readonly'>";
//echo "today_date:<input name='today_date'";  echo "type='text'"; echo "value= date('Y-m-d')"; echo "readonly='readonly'>";
echo "</form>";
*/
echo "<br />";

/*
$query3="select 
center,park,account,vendor,invoice,amount,cvip_id,postdate,recon,ncasnum,id
from ere_unmatched
where 1 and cvip_id=''
and id <= '1800' ;";
*/

$query2="update ere_unmatched,center
         set ere_unmatched.park=center.parkcode
		 where ere_unmatched.center=center.new_center ";


$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");





$query3="select 
center,park,account,vendor,invoice,amount,cvip_id,postdate,recon,ncasnum,id
from ere_unmatched
where 1 and cvip_id=''
 ;";

echo "<br />Query3=$query3<br />";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
echo "<font color='red' size='5'>Record Count: $num3</font>";//exit;
//////mysql_close();
echo "<table border=1><tr><td>Match Total</td><td id='output'></td></tr></table>";
echo "<table border=1>";
 
echo "<tr>"; 
    
 echo " <th><font color=blue>Center</font></th>";
 echo " <th><font color=blue>Park</font></th>";
 echo " <th><font color=blue>Account</font></th>";
 echo " <th><font color=blue>Vendor</font></th>";
 echo " <th><font color=blue>Invoice</font></th>";
 echo " <th><font color=blue>Amount</font></th>";
 echo " <th><font color=blue>Match</font></th>";
 //echo " <th><font color=blue>CVIP id</font></th>";
 echo " <th><font color=blue>PostDate</font></th>";
 //echo " <th><font color=blue>Recon</font></th>";
 echo " <th><font color=blue>Id</font></th>";           
// echo " <th><font color=blue>Action</font></th>";           
       
 

echo "</tr>";
echo  "<form method='post' autocomplete='off' action='stepH8e_update6.php'>";
//exit;
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$row3=mysqli_fetch_array($result3);
//extract($row3);$companyarray[]=$company;$acctarray[]=$acct;$centerarray[]=$center;
//$calendar_acctdatearray[]=$calendar_acctdate;$amountarray[]=$amount;$signarray[]=$sign;
//$pcard_trans_idarray[]=$pcard_trans_id;$transid_verifiedarray[]=$transid_verified;
//$idarray[]=$id;}
// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);$idarray[]=$id;$pcard_trans_idarray[]=$pcard_trans_id;$transid_verifiedarray[]=$transid_verified;
//extract($row3);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if(@$status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if(@$status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
//echo "<tr$t>";	

echo "<tr class=\"normal\" id=\"row$id\" onclick=\"onRow(this.id)\">";

      
//echo "<form method=post action=stepG5_update.php>";	   
echo  "<td>$center</td>";
echo  "<td>$park</td>";
echo  "<td>$account</td>";
echo  "<td>$vendor</td>";
echo  "<td>$invoice</td>";
//echo  "<td><a href='stepH8e_update?center=$center&ncasnum=$ncasnum&amount=$amount' target='_blank'>$amount</a></td>";

echo  "<td><a href='stepH8e_update.php?center=$center&ncasnum=$ncasnum&amount=$amount&project_category=$project_category&project_name=$project_name&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&step_group=$step_group&step=$step&step_num=$step_num&center=$center&park=$park&submit=center_match' >$amount</a></td>";

//echo  "<td><input type='checkbox' size='5' name='checkmark[$id]'  rel='$amount' $ck>$ck</td>";    
echo  "<td><input type='checkbox' size='5' name='checkmark[$id]'  rel='$amount' value='nm'></td>";    
//echo  "<td><input type='text' size='5' name='cvip_id[]' value='$cvip_id'</td>";
echo  "<td>$postdate</td>";
echo  "<td>$id</td>";
//echo  "<td><input type='text' size='5' readonly='readonly' name='recon[]' value='$recon'</td>";
//echo  "<td><input type='text' name='id6' value='$id'>$id</td>";
//echo "<input type='hidden' name='id6[]' value='$id'>";
   
	      
echo "</tr>";

}

/*echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='hidden' name='step_name' value='$step_name'>
	   <input type='hidden' name='num3' value='$num3'>";
*/	 
 echo "<input type='submit' name='submit4' value='Update'>"; 
echo   "</form>";
 
echo "</table>";

echo  "<form method='post' autocomplete='off' action='stepH8e_mark_complete.php'>";
//echo "<tr><td colspan='8' align='right'><input type='submit' name='submit3' value='Update'></td></tr>";
echo "<input type='submit' name='submit3' value='Mark_Step_Complete'>";

if(!isset($step_name)){$step_name="";}
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='hidden' name='step_name' value='$step_name'>
	   <input type='hidden' name='num3' value='$num3'>";

echo "</form>";
	

echo "</html>";

?>

























