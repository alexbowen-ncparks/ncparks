<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";//exit;
//echo "<br />"; 
//echo "today_date=$today_date";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

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


//echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-StepGroup $step_group-$step</font></i></H1>";
//echo "<H3 ALIGN=LEFT > <font color=blue>StepName-$step_name</font></H1>";
//echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates> Return Weekly Updates-HOME </A></font></H2>";
//echo "<H3 ALIGN=LEFT > <font color=brown>Section 1: Record in PCEW with pcard_trans_id Value which shows up multiple times in Table=PCU</font></H3>";

//echo "<H3 ALIGN=LEFT > <font color=blue>Review possible matches below & enter Correct pcu_id. Thanks</font></H1>";

echo "<H2 ALIGN=LEFT><font color=red>SECTION 1(ere_unmatched) Record to be Updated-$park-$center-$ncasnum</font></H2>";
/*
$query1="select 
center,park,account,vendor,invoice,amount,cvip_id,postdate,recon,id
from ere_unmatched
where center='$center' and amount='$amount' and ncasnum='$ncasnum' and cvip_id='';";
*/
/*
$query1="select 
center,park,account,vendor,invoice,amount,cvip_id,postdate,recon,id
from ere_unmatched
where center='$center' and cvip_id='';";
*/





//$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
//$num1=mysqli_num_rows($result1);
//echo "<H3><font color='red'>Record Count: $num1</font></H3>";
//////mysql_close();

//echo "<table border=1>";
 
//echo "<tr>"; 
    
/*
 echo " <th><font color=brown>Vendor</font></th>";
 echo " <th><font color=brown>Invoice</font></th>";
 echo " <th><font color=brown>Amount</font></th>"; 
 echo " <th><font color=brown>PostDate</font></th>";
 echo " <th><font color=brown>CVIP id</font></th>";

 echo " <th><font color=brown>Id</font></th>";           
        
 */     
       
 /*

echo "</tr>";

if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	

while ($row1=mysqli_fetch_array($result1)){


extract($row1);



echo "<tr$t>";	      

echo  "<td>$vendor</td>";
echo  "<td>$invoice</td>";
echo  "<td>$amount</td>";
echo  "<td>$postdate</td>";
echo "<form method='post' action='stepH8e_match'>"; 
echo  "<td><input type='text' name='cvip_id' size='3'></td>";
echo  "<td><input type='text' name='id' readonly='readonly' size='3' value='$id'></td>";
echo  "<input type='hidden' name='project_category' value='$project_category'>
           <input type='hidden' name='project_name' value='$project_name'>
           <input type='hidden' name='fiscal_year' value='$fiscal_year'>
           <input type='hidden' name='start_date' value='$start_date'>
           <input type='hidden' name='end_date' value='$end_date'>
           <input type='hidden' name='step_group' value='$step_group'>
           <input type='hidden' name='step' value='$step'>		   
           <input type='hidden' name='step_num' value='$step_num'>";
echo "<td><input type='submit' name='submit' value='MATCH'></td>";
echo "</form>";

echo  "<td><form method='post' action='stepH8e_nomatch'>
           <input type='hidden' name='id' value='$id'>
           <input type='hidden' name='project_category' value='$project_category'>
           <input type='hidden' name='project_name' value='$project_name'>
           <input type='hidden' name='fiscal_year' value='$fiscal_year'>
           <input type='hidden' name='start_date' value='$start_date'>
           <input type='hidden' name='end_date' value='$end_date'>
           <input type='hidden' name='step_group' value='$step_group'>
           <input type='hidden' name='step' value='$step'>
           <input type='hidden' name='step_num' value='$step_num'>
           <input type='submit' name='submit' value='NO MATCH'>
		   </form>
		   </td>";
	   
 echo  "<td>";
 echo "</tr>";
}
 echo "</table>";
 */
 /* echo "<div id='school'>
    <p><input type='checkbox' rel='15'>Book</p>
    <p><input type='checkbox' rel='15'>Bag</p>
    <p><input type='checkbox' rel='15'>Notebook</p>
</div>

<span id='output'></span>";
*/








 
 $query1a="select 
center as centerO,park,ncasnum as ncasnumO,vendor,invoice,amount as amountO,cvip_id,postdate,recon,id
from ere_unmatched
where center='$center' and amount='$amount' and ncasnum='$ncasnum' and cvip_id='';";

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
$num1a=mysqli_num_rows($result1a);

 echo "<table border=1>";
 echo "<tr>";
 //echo " <th><font color=brown>Id</font></th>"; 
 echo " <th><font color=brown>Vendor</font></th>";
 echo " <th><font color=brown>Invoice</font></th>";
 echo " <th><font color=brown>Amount</font></th>"; 
 echo " <th><font color=brown>PostDate</font></th>";
 echo " <th><font color=brown>CVIP id</font></th>";
 //echo " <th><font color=blue>Recon</font></th>";
 echo " <th><font color=brown>Id</font></th>";  
 
 
 
 
 
 
 
echo "</tr>";
 while ($row1a=mysqli_fetch_array($result1a)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row1a);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr class=\"normal\" id=\"row$id\" onclick=\"onRow(this.id)\">";
 echo "<form method='post' action='stepH8e_nomatch2.php'>";	 
echo  "<td>$vendor</td>";
echo  "<td>$invoice</td>";
echo  "<td>$amountO</td>";
echo  "<td>$postdate</td>";
echo  "<td>$cvip_id</td>"; 
echo  "<td>$id</td>";

 
 echo "<td><input type='checkbox' size='5' name='Match[$id]' value='nm'  $ck></td>";	      
echo "</tr>";
}
echo "<tr><td colspan='8' align='right'><input type='submit' name='submit' value='no_match_checked'></form></td></tr>";

echo "</table>";
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
	   <input type='hidden' name='num1' value='$num1'>";
echo   "</form>";
*/	


echo "<br /><br />"; 
//echo "<table border='1'>";

//echo "<tr>

//td><font color='red'>LOOKUP</font></td>

//<td>";
/*
echo "<td><form method=post='post' action='stepH8e_update.php'>

     <input type='hidden' name='center' value='$center'>
     <input type='hidden' name='ncasnum' value='$ncasnum'>
     <input type='hidden' name='amount' value='$amount'>
	 <input type='hidden' name='project_category' value='$project_category'>
     <input type='hidden' name='project_name' value='$project_name'>
     <input type='hidden' name='fiscal_year' value='$fiscal_year'>
     <input type='hidden' name='start_date' value='$start_date'>
     <input type='hidden' name='end_date' value='$end_date'>
     <input type='hidden' name='step_group' value='$step_group'>
     <input type='hidden' name='step' value='$step'>
     <input type='hidden' name='step_num' value='$step_num'>	 
     <input type='hidden' name='park' value='$park'>	 
     <input type='submit' name='submit' value='caa_match'>
     <input type='submit' name='submit' value='ca_match'>
	 <input type='submit' name='submit' value='center_match'>
     </form></td>";
	 
*/	 
	 	 
	// echo "</td>";

    //<td><form method=post='post' action='stepH8e_update.php'>

    // <input type='hidden' name='center' value='$center'>
    // <input type='hidden' name='ncasnum' value='$ncasnum'>
    // <input type='hidden' name='amount' value='$amount'>
    // <input type='submit' name='submit' value='center_match'></form></td>

//echo "</tr>";	
//echo "</table>";

if($submit==""){exit;}



if($submit=="center_match"){


$query3="select 
center,park,account,budget_group,vendor,invoice,amount,cvip_id,system_entry_date as 'sed',ncas_invoice_date,ncasnum,post2ncas,id 
from cvip_unmatched
where center='$center' 
order by vendor,sed,amount
";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
echo "<br />Line 311: query3=$query3<br />";

//echo "<H3><font color='red'>Record Count: $num1</font></H3>";
//////mysql_close();





echo "<H2 ALIGN=LEFT><font color=blue>SECTION 2-Center Possible Matches-$num3</font></H2>";


echo "<table border=1><tr><td>Match Total</td><td id='output'></td></tr></table>";


echo "<table border=1>";
 
echo "<tr>"; 
    
 //echo " <th><font color=brown>Center</font></th>";
 //echo " <th><font color=brown>Park</font></th>";
 //echo " <th><font color=brown>Account</font></th>";
 echo " <th><font color=brown>Vendor</font></th>";
 echo " <th><font color=brown>Invoice</font></th>"; 
 echo " <th><font color=brown>Amount</font></th>";
 echo " <th><font color=brown>Account</font></th>";
 echo " <th><font color=brown>Budget Group</font></th>";
 echo " <th><font color=brown>sed</font></th>";
 echo " <th><font color=brown>ncas invoice date</font></th>";
 echo " <th><font color=brown>cvip_id</font></th>";
 echo " <th><font color=brown>ID</font></th>";
 echo " <th><font color=brown>post</font></th>";
 echo " <th><font color=brown>Match</font></th>";
           

echo "</tr>";

while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
if($post2ncas=='y'){$t=" bgcolor='yellow'";}
if($post2ncas!='y'){$t=" bgcolor='#B4CDCD' ";}

//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<form method=post action=stepH8e_update2.php>";
if($post2ncas=='n')
{
echo "<tr class=\"normal\" id=\"row$id\" onclick=\"onRow(this.id)\">";
}
else
{
echo "<tr class=\"normal2\" id=\"row$id\" onclick=\"onRow(this.id)\">";
}	      
	   
//echo  "<td>$center</td>";
//echo  "<td>$park</td>";
//echo  "<td>$account</td>";
echo  "<td>$vendor</td>";
echo  "<td>$invoice</td>";
echo  "<td>$amount</td>";
//echo  "<td>$ncasnum</td>";
echo  "<td>$account</td>";
echo  "<td>$budget_group</td>";
echo  "<td>$sed</td>";
echo  "<td>$ncas_invoice_date</td>";
echo  "<td>$cvip_id</td>";
echo  "<td>$id</td>";
echo  "<td>$post2ncas</td>";

//if($transid_verified == "y"){$ck="checked";}else {$ck="";}
echo  "<td><input type='checkbox' size='5' name='Match[$cvip_id]' value='y' rel='$amount' $ck></td>";      
echo "</tr>";

}

echo "<tr><td colspan='8' align='right'><input type='submit' name='submit' value='match_update'></td></tr>";
echo "<input type='hidden' name='centerO' value='$centerO'>	";
echo "<input type='hidden' name='ncasnumO' value='$ncasnumO'>	";
echo "<input type='hidden' name='amountO' value='$amountO'>	";
echo "</form>";
echo "</table>";
}

echo "</html>";


?>

























