<?php
/* *** INCLUDE file inventory ***
include("/opt/library/prd/WebServer/include/iConnect.inc")
include ("test_style_overshort.php")
include("../../../budget/menu1314_tony.html")
*/

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
$ctdd_id=$id;
//echo "ctdd_id=$ctdd_id<br />";
//echo $concession_location;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
// echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database


$query4="select orms_deposit_id,controllers_deposit_id,bank_deposit_date,cashier,park_complete,f_year as 'fiscal_year'
         from crs_tdrr_division_deposits
         where id='$id'	 ; ";

		 
//echo "Line 36: query4=$query4<br />";
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
		  
$row4=mysqli_fetch_array($result4);

extract($row4);
$bank_deposit_date2=date('m-d-y', strtotime($bank_deposit_date));
$query4a="select sum(amount) as 'total_check_amount'
         from crs_tdrr_division_deposits_checklist
         where orms_deposit_id='$orms_deposit_id'	 ; ";

$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");
		  
$row4a=mysqli_fetch_array($result4a);

extract($row4a);

$query11="select checknum,payor,payor_bank,amount,description from crs_tdrr_division_deposits_checklist
          where orms_deposit_id='$orms_deposit_id' order by id ";
//echo "query11=$query11";//exit;
$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);	
 echo "<html>";
echo "<head>
<title>MoneyTracker</title>";

//include ("test_style.php");
include ("test_style_overshort.php");
echo "<style>";
echo "#table1{
width:800px;
	margin-left:auto; 
    margin-right:auto;
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


$query11e="select center_desc from center where parkcode='$parkcode'   ";	

//echo "query1d=$query1d<br />";//exit;		  

$result11e = mysqli_query($connection, $query11e) or die ("Couldn't execute query 11e.  $query11e");
		  
$row11e=mysqli_fetch_array($result11e);

extract($row11e);

$query2="select center_desc,center from center where parkcode='$parkcode'   ";	

//echo "query1d=$query1d<br />";//exit;		  

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysqli_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);

//$center_location = str_replace("_", " ", $center_desc);
//echo "center location=$center_location";
 
 /*
 echo "<div class='mc_header'>";
echo "<table><tr><th><img height='50' width='50' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'></img></th><th><font color='blue'>MoneyCounts-$center_location</font></th></tr></table>";
echo "</div>";
 */
 echo "<br /><br />";
 echo "<table align='center'><tr><td>
<a href='/budget/menu1314.php'>
<img height='50' width='50' src='/budget/infotrack/icon_photos/home1.png' alt='picture of home' title='Home'></img>	<br /><font color='brown'>Home</font>
</a></td><td><img height='25' width='25' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'><font color='blue'><b>$center_location $center</b></font></img><br /><font color='brown' size='5'><b>DNCR Daily Receipt Check Log</b></font></td></tr></table>";
 
 //echo "<br /><br />Line 120: park_complete=$park_complete<br /><br />";
echo "<br /><br /><br />";
 echo "<table align='center'>";
 //echo "<tr><td>ORMS ID $orms_deposit_id</td></tr>";
 echo "<tr bgcolor='lightcyan'><td><font color='red' size='5'>Bank Deposit $controllers_deposit_id</font></td></tr>";
 echo "<tr bgcolor='lightcyan'><td>Bank Deposit Date $bank_deposit_date2</td></tr>"; 
 //echo "<tr><td>Cashier $cashier</td></tr>";
 echo "</table>";
 echo "<br />";
 echo "<br />";
 
/* 2022-02-24: CCOOPER - updating access for A Boggus, C Williams, and R Gooding to match Dodd and Rumble - adding the "Edit Check Listing" functionality */
       // 6/1/15: LAWA Seasonal employee Paula Wagner,  Budget Officer Tammy Dodd,  Accountant Tony Bass
 if($tempid=='Wagner9210' or 
    $beacnum=='60032781' or 
    $beacnum=='60032793' or 
    $beacnum=='60036015' or
    $beacnum=='60033242' or 
    $beacnum=='65032827' or
    $beacnum=='60032997' or 
    $park_complete!='y')
   {
     echo "<table align='center'><tr><td><a href='check_listing.php?id=$id&edit=y'>Edit Check Listing</a></td></tr></table>";
   }
 /* 2022-02-24: End CCOOPER */

 if($edit!='y')
 {
 echo "<div id='table1'>";
 echo "<table border=1 id='table1'>";
//echo "<tr><th colspan='5'>DENR Daily Receipt Check Log</th></tr>";
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
 
$payor=htmlspecialchars_decode($payor); 
$payor_bank=htmlspecialchars_decode($payor_bank); 
$description=htmlspecialchars_decode($description); 
 
 
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
 }
if($edit=='y')
 {
 $system_entry_date=date("Ymd");
 $query12="insert into crs_tdrr_division_deposits_checklist SET";
 for($j=0;$j<10;$j++){
$query13=$query12;
//$comment_note2=addslashes($comment_note[$j]);
	$query13.=" orms_deposit_id='$orms_deposit_id', ";
	$query13.=" controllers_deposit_id='$controllers_deposit_id', ";
	$query13.=" bank_deposit_date='$bank_deposit_date', ";
	$query13.=" system_entry_date='$system_entry_date', ";
	$query13.=" f_year='$fiscal_year', ";
	$query13.=" cashier='$cashier' ";
//	$query2.=" status='$status[$j]'";
//	$query2.=" where comment_id='$comment_id[$j]'";
		

$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query 13. $query13");
}	
 
 $query14="select checknum,payor,payor_bank,amount,description,id as 'checklist_id' from crs_tdrr_division_deposits_checklist
          where orms_deposit_id='$orms_deposit_id' order by id ";
//echo "query11=$query11";//exit;
$result14 = mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14 ");
 $num14=mysqli_num_rows($result14);	
 echo "<div>";
// echo "<form>";
 echo "<table border=1 id='table1'>";
//echo "<tr><th colspan='5'>DENR Daily Receipt Check Log</th></tr>";
echo "<tr>"; 
//echo "<th align=left><font color=brown>ORMS Deposit ID</font></th>";
//echo "<th align=left><font color=brown>Controllers Deposit ID</font></th>";  
     
echo "<th align=left><font color=brown>CheckNum</font></th>";
echo "<th align=left><font color=brown>Payor Name</font></th>";
echo "<th align=left><font color=brown>Payor Bank</font></th>";
echo "<th align=left><font color=brown>Amount</font></th>";
echo "<th align=left><font color=brown>Description</font></th>";
echo "<th align=left><font color=brown>ID</font></th>";
//echo "<th align=left><font color=brown>Bank<br />Deposit<br />Date</font></th>";
//echo "<th align=left><font color=brown>Cashier</font></th>";
	   
     
      
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo  "<form method='post' autocomplete='off' action='check_listing_update.php'>";

while ($row14=mysqli_fetch_array($result14)){
 
 extract($row14);
 
$payor=htmlspecialchars_decode($payor); 
$payor_bank=htmlspecialchars_decode($payor_bank); 
$description=htmlspecialchars_decode($description); 
 
 $table_bg2='cornsilk';
 if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
 echo "<tr$t>";
 
 //echo "<td><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' '>Update</a></td>";		   
//echo "<td>$orms_deposit_id</td>";	
   
echo "<td><input type='text' name='checknum[]' value='$checknum'></td>";                      
echo "<td><input type='text' name='payor[]' value='$payor'></td>";                      
echo "<td><input type='text' name='payor_bank[]' value='$payor_bank'></td>";                      
echo "<td><input type='text' name='amount[]' value='$amount'></td>";                      
echo "<td><input type='text' name='description[]' value='$description'></td>";  
 echo "<td><input type='text' name='checklist_id[]' value='$checklist_id' readonly='readonly'></td>"; 	                   
//echo "<td>$checknum</td>";                      
  
              
//echo "<td>$bank_deposit_date</td>";                      
//echo "<td>$cashier</td>";                      
    
       
              
           
echo "</tr>";




}
/*
echo "<tr><td></td><td></td><td></td><td><td></td></tr>";
echo "<tr><td></td><td></td><td></td><td><td></td></tr>";
echo "<tr><td></td><td></td><td></td><td><td></td></tr>";
echo "<tr><td></td><td></td><td></td><td><td></td></tr>";
echo "<tr><td></td><td></td><td></td><td><td></td></tr>";
echo "<tr><td></td><td></td><td></td><td><td></td></tr>";
echo "<tr><td></td><td></td><td></td><td><td></td></tr>";
echo "<tr><td></td><td></td><td></td><td><td></td></tr>";
echo "<tr><td></td><td></td><td></td><td><td></td></tr>";
echo "<tr><td></td><td></td><td></td><td><td></td></tr>";
*/
echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
//echo "<input type='hidden' name='project_note_id' value='$project_note_id'>";
echo "<input type='hidden' name='num14' value='$num14'>";
echo "<input type='hidden' name='ctdd_id' value='$ctdd_id'>";
 //echo "<tr><td></td><td></td><td></td><td><td>Detail Total Debits</td></tr>";
 //echo "<tr><td></td><td></td><td></td><td>$total_check_amount</td><td>Detail Total Credits</tr>";
  echo "</table>";
 echo "</div>";
 echo "</form>";
 //echo "<pre>";print_r($checknum);"</pre>";//exit;
 }
 echo "</body></html>";
 
 
 
 
?>