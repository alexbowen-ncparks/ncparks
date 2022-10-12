<?php

session_start();


if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
extract($_REQUEST);

//echo $concession_location;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

echo "<pre>";print_r($_SESSION);"</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database


$query4="select orms_deposit_id,controllers_deposit_id,bank_deposit_date,cashier
         from crs_tdrr_division_deposits
         where id='$id'	 ; ";

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
		  
$row4=mysqli_fetch_array($result4);

extract($row4);

$query4a="select sum(amount) as 'total_check_amount'
         from crs_tdrr_division_deposits_checklist
         where orms_deposit_id='$orms_deposit_id'	 ; ";

$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");
		  
$row4a=mysqli_fetch_array($result4a);

extract($row4a);

$query11="select checknum,payor,amount,description from crs_tdrr_division_deposits_checklist
          where orms_deposit_id='$orms_deposit_id' ";
//echo "query11=$query11";//exit;
$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);	
 echo "<html>";
echo "<head>
<title>MoneyTracker</title>";

//include ("test_style.php");
include ("test_style.php");
echo "<style>";
echo "#table1{
width:800px;	
	}";
echo "</style>";
echo "</head>";

include("../../../budget/menu1314_tony.html");

$query1="SELECT park as 'parkcode' from crs_tdrr_division_deposits
         where id='$id' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);


$query11e="select center_desc from center where parkcode='parkcode'   ";	

//echo "query1d=$query1d<br />";//exit;		  

$result11e = mysqli_query($connection, $query11e) or die ("Couldn't execute query 11e.  $query11e");
		  
$row11e=mysqli_fetch_array($result11e);

extract($row11e);



$center_location = str_replace("_", " ", $center_desc);
//echo "center location=$center_location";
 
 
 echo "<div class='mc_header'>";
echo "<table><tr><th><img height='50' width='50' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'></img></th><th><font color='blue'>MoneyCounts-$center_location</font></th></tr></table>";
echo "</div>";
 
echo "<br /><br /><br />";
 echo "<table>";
 //echo "<tr><td>ORMS ID $orms_deposit_id</td></tr>";
 echo "<tr bgcolor='cornsilk'><td>Bank Deposit# $controllers_deposit_id</td></tr>";
 echo "<tr bgcolor='lightcyan'><td>Bank Deposit Date $bank_deposit_date</td></tr>"; 
 //echo "<tr><td>Cashier $cashier</td></tr>";
 echo "</table>";
 echo "<br />";
 echo "<br />";
 
 echo "<div id='table1'>";
 echo "<table border=1 id='table1'>";
echo "<tr><th colspan='5'>DENR Daily Receipt Check Log</th></tr>";
echo "<tr>"; 
//echo "<th align=left><font color=brown>ORMS Deposit ID</font></th>";
//echo "<th align=left><font color=brown>Controllers Deposit ID</font></th>";       
echo "<th align=left><font color=brown>CheckNum</font></th>";
echo "<th align=left><font color=brown>Payor Name</font></th>";
echo "<th align=left><font color=brown>Payor Bank</font></th>";
echo "<th align=left><font color=brown>Amount</font></th>";
echo "<th align=left><font color=brown>Description</font></th>";
//echo "<th align=left><font color=brown>Bank<br />Deposit<br />Date</font></th>";
//echo "<th align=left><font color=brown>Cashier</font></th>";
	   
     
      
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row11=mysqli_fetch_array($result11)){
 
 extract($row11);
 $table_bg2='cornsilk';
 if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
 echo "<tr$t>";
 
 //echo "<td><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' '>Update</a></td>";		   
//echo "<td>$orms_deposit_id</td>";		   
echo "<td>$checknum</td>";                      
//echo "<td>$checknum</td>";                      
echo "<td>$payor</td>";                      
echo "<td>$payor_bank</td>";                      
 echo "<td>$amount</td>";                         
echo "<td>$description</td>";    
              
//echo "<td>$bank_deposit_date</td>";                      
//echo "<td>$cashier</td>";                      
    
       
              
           
echo "</tr>";




}
 echo "<tr><td></td><td></td><td></td><td><td>Detail Total Debits</td></tr>";
 echo "<tr><td></td><td></td><td></td><td>$total_check_amount</td><td>Detail Total Credits</tr>";
  echo "</table>";
 echo "</div>";
 echo "</body></html>";
 
 
 
 
?>