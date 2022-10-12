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
$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");
//echo "start_date=$start_date";
//echo "<br />"; 
//echo "end_date=$end_date";//exit;
//echo "<br />"; 
//echo "today_date=$today_date";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
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
</style>
</head>";


echo "<H2 ALIGN=LEFT><font color=red>SECTION 1(partf_payments) Record to be Updated-$center</font></H2>";
$query1="select *
from partf_payments
where xtid='$xtid' ;";

$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");
$num1=mysql_num_rows($result1);


echo "<table border=1>";
 
echo "<tr>"; 
    
 
 echo " <th><font color=brown>Vendor</font></th>";
 echo " <th><font color=brown>Invoice</font></th>";
 echo " <th><font color=brown>Amount</font></th>"; 
 echo " <th><font color=brown>PostDate</font></th>";
 //echo " <th><font color=brown>ContractNum</font></th>";
 //echo " <th><font color=brown>ContractAmt</font></th>";
 echo " <th><font color=brown>ProjNum</font></th>";
 //echo " <th><font color=blue>Recon</font></th>";
 echo " <th><font color=brown>Xtid</font></th>";           
// echo " <th><font color=blue>Action</font></th>";          
      
       
 

echo "</tr>";
//echo  "<form method='post' autocomplete='off' action='stepG8d_update2'>";

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysql_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row1=mysql_fetch_array($result1)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row1);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr$t>";	      
//echo "<form method=post action=stepG5_update.php>";	   
//echo  "<td>$center</td>";
//echo  "<td>$park</td>";
//echo  "<td>$account</td>";
echo  "<td>$vendorname</td>";
echo  "<td>$invoice</td>";
echo  "<td>$amount</td>";
echo  "<td>$datenew</td>";
echo "<form method='post' action='stepJ9_match'>"; 
echo  "<td><input type='text' name='proj_num' size='3' ></td>";
//echo  "<td><input type='text' name='contract_num' size='3'></td>";
//echo  "<td><input type='text' name='contract_amount' size='3'></td>";
echo  "<td><input type='text' name='xtid' readonly='readonly' size='3' value='$xtid'></td>";

echo "<input type='hidden' name='project_category' value='$project_category'>
           <input type='hidden' name='project_name' value='$project_name'>
           <input type='hidden' name='fiscal_year' value='$fiscal_year'>
           <input type='hidden' name='start_date' value='$start_date'>
           <input type='hidden' name='end_date' value='$end_date'>
           <input type='hidden' name='step_group' value='$step_group'>
           <input type='hidden' name='step' value='$step'>
           <input type='hidden' name='step_num' value='$step_num'>";
echo "<td><input type='submit' name='submit' value='MATCH'></td>";		   
		   
echo "</form>";

/*
echo  "<td><form method='post' action='stepJ9_nomatch'>
           <input type='hidden' name='xtid' value='$xtid'>
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
 */
   
	      
echo "</tr>";

}	

echo "</table>";

echo "<br /><br />"; 
echo "<table>";
echo "<tr>";
echo "<td><form method=post='post' action='stepJ9_update.php'>

     <input type='hidden' name='center' value='$center'>
     <input type='hidden' name='account' value='$account'>
     <input type='hidden' name='amount' value='$amount'>
     <input type='hidden' name='xtid' value='$xtid'>
	 <input type='hidden' name='project_category' value='$project_category'>
     <input type='hidden' name='project_name' value='$project_name'>
     <input type='hidden' name='fiscal_year' value='$fiscal_year'>
     <input type='hidden' name='start_date' value='$start_date'>
     <input type='hidden' name='end_date' value='$end_date'>
     <input type='hidden' name='step_group' value='$step_group'>
     <input type='hidden' name='step' value='$step'>
     <input type='hidden' name='step_num' value='$step_num'>	 
     <input type='submit' name='submit' value='caa_match'>
     <input type='submit' name='submit' value='ca_match'>
     <input type='submit' name='submit' value='center_match'></form></td>";	 
	 
	 
echo "</tr>";	
echo "</table>";
if($submit==""){exit;}


if($submit=="caa_match"){



$query2="select ncas_center,ncas_account,vendor_name,ncas_invoice_number,ncas_invoice_amount,
         system_entry_date,project_number,id
		 from cid_vendor_invoice_payments
		 where ncas_center='$center' and ncas_account='$account' and ncas_invoice_amount='$amount' 
		 order by system_entry_date desc		 
";

echo $query2;//exit;
$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");
$num2=mysql_num_rows($result2);


echo "<H2 ALIGN=LEFT><font color=blue>SECTION 2-CAA Possible Matches-$num2</font></H2>";

//echo "<H3><font color='red'>Record Count: $num1</font></H3>";
//mysql_close();

echo "<table border=1>";
 
echo "<tr>"; 

  
 //echo " <th><font color=brown>Center</font></th>";
 //echo " <th><font color=brown>Park</font></th>";
 //echo " <th><font color=brown>Account</font></th>";
 echo " <th><font color=brown>Vendor</font></th>";
 echo " <th><font color=brown>Invoice</font></th>"; 
 echo " <th><font color=brown>Amount</font></th>"; 
 echo " <th><font color=brown>transaction date</font></th>"; 
 echo " <th><font color=brown>project_number</font></th>";
 echo " <th><font color=brown>ID</font></th>";
 //echo " <th><font color=brown>Match</font></th>";
 
           
// echo " <th><font color=blue>Action</font></th>";           
       
 

echo "</tr>";
//echo  "<form method='post' autocomplete='off' action='stepG8d_update'>";

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
//if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysql_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row2=mysql_fetch_array($result2)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row2);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr$t>";
//echo "<form method=post action=stepH8e_update2.php>";		      

   
//echo  "<td>$center</td>";
//echo  "<td>$park</td>";
//echo  "<td>$account</td>";
echo  "<td>$vendor_name</td>";
echo  "<td>$ncas_invoice_number</td>";
echo  "<td>$ncas_invoice_amount</td>";
echo  "<td>$system_entry_date</td>";	
echo  "<td>$project_number</td>";
echo  "<td>$id</td>";

//if($transid_verified == "y"){$ck="checked";}else {$ck="";}
//echo  "<td><input type='checkbox' size='5' name='Match[$cvip_id]' value='y' $ck></td>";

echo "</tr>";

}
//echo "<tr><td colspan='8' align='right'><input type='submit' name='submit' value='match_update'></form></td></tr>";
echo "</table>";
}


if($submit=="ca_match")
{



$query2="select ncas_center,ncas_account,vendor_name,ncas_invoice_number,ncas_invoice_amount,
         system_entry_date,project_number,id
		 from cid_vendor_invoice_payments
		 where ncas_center='$center' and ncas_account='$account' 
		 order by system_entry_date desc         
";

echo $query2;//exit;
$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");
$num2=mysql_num_rows($result2);


echo "<H2 ALIGN=LEFT><font color=blue>SECTION 2-CAA Possible Matches-$num2</font></H2>";

//echo "<H3><font color='red'>Record Count: $num1</font></H3>";
//mysql_close();

echo "<table border=1>";
 
echo "<tr>"; 

  
 //echo " <th><font color=brown>Center</font></th>";
 //echo " <th><font color=brown>Park</font></th>";
 //echo " <th><font color=brown>Account</font></th>";
 echo " <th><font color=brown>Vendor</font></th>";
 echo " <th><font color=brown>Invoice</font></th>"; 
 echo " <th><font color=brown>Amount</font></th>"; 
 echo " <th><font color=brown>transaction date</font></th>"; 
 echo " <th><font color=brown>project_number</font></th>";
 echo " <th><font color=brown>ID</font></th>";
 //echo " <th><font color=brown>Match</font></th>";
 
           
// echo " <th><font color=blue>Action</font></th>";           
       
 

echo "</tr>";
//echo  "<form method='post' autocomplete='off' action='stepG8d_update'>";

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
//if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysql_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row2=mysql_fetch_array($result2)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row2);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr$t>";
//echo "<form method=post action=stepH8e_update2.php>";		      

   
//echo  "<td>$center</td>";
//echo  "<td>$park</td>";
//echo  "<td>$account</td>";
echo  "<td>$vendor_name</td>";
echo  "<td>$ncas_invoice_number</td>";
echo  "<td>$ncas_invoice_amount</td>";
echo  "<td>$system_entry_date</td>";	
echo  "<td>$project_number</td>";
echo  "<td>$id</td>";

//if($transid_verified == "y"){$ck="checked";}else {$ck="";}
//echo  "<td><input type='checkbox' size='5' name='Match[$cvip_id]' value='y' $ck></td>";

echo "</tr>";

}
//echo "<tr><td colspan='8' align='right'><input type='submit' name='submit' value='match_update'></form></td></tr>";
echo "</table>";
}

if($submit=="center_match")
{



$query2="select ncas_center,ncas_account,vendor_name,ncas_invoice_number,ncas_invoice_amount,
         system_entry_date,project_number,id
		 from cid_vendor_invoice_payments
		 where ncas_center='$center'  
		 order by system_entry_date desc         
";

//echo $query2;//exit;
$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");
$num2=mysql_num_rows($result2);


echo "<H2 ALIGN=LEFT><font color=blue>SECTION 2-CAA Possible Matches-$num2</font></H2>";
echo "<table border=1><tr><td>Count Total</td><td id='output'></td></tr></table>";
//echo "<H3><font color='red'>Record Count: $num1</font></H3>";
//mysql_close();

echo "<table border=1>";
 
echo "<tr>"; 

  
 //echo " <th><font color=brown>Center</font></th>";
 //echo " <th><font color=brown>Park</font></th>";
 //echo " <th><font color=brown>Account</font></th>";
 echo " <th><font color=brown>Vendor</font></th>";
 echo " <th><font color=brown>Invoice</font></th>"; 
 echo " <th><font color=brown>Amount</font></th>"; 
 echo " <th><font color=brown>Count</font></th>"; 
 echo " <th><font color=brown>transaction date</font></th>"; 
 echo " <th><font color=brown>project_number</font></th>";
 echo " <th><font color=brown>ID</font></th>";
 //echo " <th><font color=brown>Match</font></th>";
 
           
// echo " <th><font color=blue>Action</font></th>";           
       
 

echo "</tr>";
//echo  "<form method='post' autocomplete='off' action='stepG8d_update'>";

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
//if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysql_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row2=mysql_fetch_array($result2)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row2);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr$t>";
//echo "<form method=post action=stepH8e_update2.php>";		      

   
//echo  "<td>$center</td>";
//echo  "<td>$park</td>";
//echo  "<td>$account</td>";
echo  "<td>$vendor_name</td>";
echo  "<td>$ncas_invoice_number</td>";
echo  "<td>$ncas_invoice_amount</td>";
echo  "<td><input type='checkbox' size='5' name='count' value='y' rel='$ncas_invoice_amount' $ck></td>";  
echo  "<td>$system_entry_date</td>";	
echo  "<td>$project_number</td>";
echo  "<td>$id</td>";

//if($transid_verified == "y"){$ck="checked";}else {$ck="";}
//echo  "<td><input type='checkbox' size='5' name='Match[$cvip_id]' value='y' $ck></td>";

echo "</tr>";

}
//echo "<tr><td colspan='8' align='right'><input type='submit' name='submit' value='match_update'></form></td></tr>";
echo "</table>";
}


echo "</html>";


?>

























