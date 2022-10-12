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
//$ctdd_id=$id;
//echo "ctdd_id=$ctdd_id<br />";
//echo $concession_location;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database


$query11="select id,park,center,fyear as 'fiscal_year',cash_month,cash_month_number,cash_month_calyear,tag_num,vehicle_num,vehicle_location,driver_name,gallons,
 usage_date,cashier,cashier_date
 from fuel_tank_usage_detail
 where park='$parkcode' and cash_month='$cash_month' and fyear='$fyear' and cash_month_calyear='$cash_month_calyear'	 ; ";

		 
echo "query11=$query11<br />"; exit;


$result11 = mysql_query($query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysql_num_rows($result11);	
 echo "<html>";
echo "<head>
<title>MoneyTracker</title>";


include ("test_style.php");
echo "<style>";
echo "#table1{
width:800px;
	margin-left:auto; 
    margin-right:auto;
	}";
echo "</style>";
echo "</head>";

include("../../budget/menu1314_tony.html");

/*

$query1="SELECT park as 'parkcode' from crs_tdrr_division_deposits
         where id='$id' ";
		 
 

$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysql_fetch_array($result1);
extract($row1);


$query11e="select center_desc from center where parkcode='$parkcode'   ";	

  

$result11e = mysql_query($query11e) or die ("Couldn't execute query 11e.  $query11e");
		  
$row11e=mysql_fetch_array($result11e);

extract($row11e);

$query2="select center_desc,center from center where parkcode='$parkcode'   ";	

	  

$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysql_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);


 echo "<br /><br />";
 echo "<table align='center'><tr><td><img height='25' width='25' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'><font color='blue'><b>$center_location $center</b></font></img><br /><font color='brown' size='5'><b>DENR Daily Receipt Check Log</b></font></td></tr></table>";
 
 
echo "<br /><br /><br />";
 echo "<table align='center'>";
 //echo "<tr><td>ORMS ID $orms_deposit_id</td></tr>";
 echo "<tr bgcolor='lightcyan'><td><font color='red' size='5'>Bank Deposit $controllers_deposit_id</font></td></tr>";
 echo "<tr bgcolor='lightcyan'><td>Bank Deposit Date $bank_deposit_date2</td></tr>"; 
 //echo "<tr><td>Cashier $cashier</td></tr>";
 echo "</table>";
 
 */
 echo "<br />";
 echo "<br />";
 // 6/1/15: LAWA Seasonal employee Paula Wagner,  Budget Officer Tammy Dodd,  Accountant Tony Bass
 if($tempid=='wagner9210' or $beacnum=='60032781' or $beacnum=='60032793')
 {
 echo "<table align='center'><tr><td><a href=''>Edit Check Listing</a></td></tr></table>";
 }
 if($edit!='y')
 {
 echo "<div id='table1'>";
 echo "<table border=1 id='table1'>";
//echo "<tr><th colspan='5'>DENR Daily Receipt Check Log</th></tr>";
echo "<tr>"; 
echo "<th align=left><font color=brown>CheckNum</font></th>";
echo "<th align=left><font color=brown>Payor Name</font></th>";
echo "<th align=left><font color=brown>Payor Bank</font></th>";
echo "<th align=left><font color=brown>Amount</font></th>";
echo "<th align=left><font color=brown>Description</font></th>";
//echo "<th align=left><font color=brown>Bank<br />Deposit<br />Date</font></th>";
//echo "<th align=left><font color=brown>Cashier</font></th>";
	   
     
      
       
              
echo "</tr>";

//$row=mysql_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
//$c=1;
while ($row11=mysql_fetch_array($result11)){
 
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
		

$result13=mysql_query($query13) or die ("Couldn't execute query 13. $query13");
}	
 
 $query14="select checknum,payor,payor_bank,amount,description,id as 'checklist_id' from crs_tdrr_division_deposits_checklist
          where orms_deposit_id='$orms_deposit_id' order by id ";
//echo "query11=$query11";//exit;
$result14 = mysql_query($query14) or die ("Couldn't execute query 14.  $query14 ");
 $num14=mysql_num_rows($result14);	
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

//$row=mysql_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
//$c=1;
echo  "<form method='post' autocomplete='off' action='check_listing_update.php'>";

while ($row14=mysql_fetch_array($result14)){
 
 extract($row14);
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
 
 */
 
 
?>