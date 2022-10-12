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
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$query0="select park_acct_desc as 'account_description'
         from coa where ncasnum='$account' ";

$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);//brings back max (end_date) as $end_date


echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: #FFF8DC; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
</style>
</head>";


echo "<H2 ALIGN=LEFT><font color=red>SECTION 1(partf_payments) Record to be Updated-$center</font></H2>";
$query1="select vendorname,invoice,amount,datenew,contract_num,contract_amt,record_complete,xtid
from partf_payments
where xtid='$xtid' ";

echo $query1;//exit;

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$num1=mysqli_num_rows($result1);


echo "<table border=1>";
 
echo "<tr>"; 
    
 
 echo " <th><font color=brown>Vendor</font></th>";
 echo " <th><font color=brown>Invoice</font></th>";
 echo " <th><font color=brown>Amount</font></th>"; 
 echo " <th><font color=brown>Account</font></th>"; 
 echo " <th><font color=brown>Description</font></th>"; 
 echo " <th><font color=brown>PostDate</font></th>";
 //echo " <th><font color=brown>ContractNum</font></th>";
 //echo " <th><font color=brown>ContractAmt</font></th>";
 echo " <th><font color=brown>ContractNum</font></th>";
 echo " <th><font color=brown>ContractAmt</font></th>";
 echo " <th><font color=brown>RC</font></th>";
 //echo " <th><font color=blue>Recon</font></th>";
 echo " <th><font color=brown>Xtid</font></th>";           
// echo " <th><font color=blue>Action</font></th>";          
      
       
 

echo "</tr>";
//echo  "<form method='post' autocomplete='off' action='stepG8d_update2'>";

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row1=mysqli_fetch_array($result1)){

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
echo  "<td>$account</td>";
echo  "<td>$account_description</td>";
echo  "<td>$datenew</td>";


echo "<form method='post' action='stepJ91_match.php'>"; 

//echo  "<td><input type='text' name='contract_num' size='3'></td>";
//echo  "<td><input type='text' name='contract_amount' size='3'></td>";
echo  "<td><input type='text' name='contract_num'  size='3' value='$contract_num'></td>";
echo  "<td><input type='text' name='contract_amt' size='10' value='$contract_amt'></td>";
echo  "<td><input type='text' name='xtid' readonly='readonly' size='3' value='$record_complete'></td>";
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
echo  "<td><form method='post' action='stepJ91_nomatch'>
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
echo "<td><form method=post='post' action='stepJ91_update.php'>

     <input type='hidden' name='center' value='$center'>
     <input type='hidden' name='account' value='$account'>
     <input type='hidden' name='amount' value='$amount'>
     <input type='hidden' name='proj_num' value='$proj_num'>
     <input type='hidden' name='xtid' value='$xtid'>
	 <input type='hidden' name='project_category' value='$project_category'>
     <input type='hidden' name='project_name' value='$project_name'>
     <input type='hidden' name='fiscal_year' value='$fiscal_year'>
     <input type='hidden' name='start_date' value='$start_date'>
     <input type='hidden' name='end_date' value='$end_date'>
     <input type='hidden' name='step_group' value='$step_group'>
     <input type='hidden' name='step' value='$step'>
     <input type='hidden' name='step_num' value='$step_num'>	 
     <input type='submit' name='submit' value='contract_info_lookup'>
	 </form></td>";
	 
echo "</tr>";	
echo "</table>";
if($submit==""){exit;}


if($submit=="contract_info_lookup"){

$query1="SELECT new_center from center
         where center='$center' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);






$query2="select * from cid_contract_vitals where (ncas_center_encumbered='$center' or ncas_center_encumbered='$new_center') and dpr_project_number='$proj_num'         
";

echo $query2;//exit;
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$num2=mysqli_num_rows($result2);


echo "<H2 ALIGN=LEFT><font color=blue>SECTION 2-Contract Info Possible Matches-$num2</font></H2>";

//echo "<H3><font color='red'>Record Count: $num1</font></H3>";
//////mysql_close();

echo "<table border=1>";
 
echo "<tr>"; 

  
 //echo " <th><font color=brown>Center</font></th>";
 //echo " <th><font color=brown>Park</font></th>";
 //echo " <th><font color=brown>Account</font></th>";
 //echo " <th><font color=brown>center</font></th>";
 echo " <th><font color=brown>vendor</font></th>"; 
 echo " <th><font color=brown>contract_number</font></th>"; 
 echo " <th><font color=brown>id</font></th>"; 
 
 
           
// echo " <th><font color=blue>Action</font></th>";           
       
 

echo "</tr>";
//echo  "<form method='post' autocomplete='off' action='stepG8d_update'>";

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
//if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row2=mysqli_fetch_array($result2)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row2);

//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr$t>";
//echo "<form method=post action=stepJ91_update2.php>";		      

   
//echo  "<td>$center</td>";
//echo  "<td>$park</td>";
//echo  "<td>$account</td>";
//echo  "<td>$NCAS_center_encumbered</td>";
echo  "<td>$DPR_contractor_name</td>";
echo  "<td>$DPR_contract_number</td>";
echo  "<td>$id</td>";

echo "</tr>";

}

echo "</table>";
}


echo "</html>";


?>

























