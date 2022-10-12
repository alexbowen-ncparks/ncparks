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
$ctdd_id=$id;
//echo "ctdd_id=$ctdd_id<br />";
//echo $concession_location;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

/*
$query1="select count(id) as 'manager_count'
         from cash_handling_roles
         where role='manager' and tempid='$tempid'	 ; ";

		 
//echo "query1=$query1<br />";
		 
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
		  
$row1=mysqli_fetch_array($result1);

extract($row1);

//echo "manager_count=$manager_count<br />";


if($manager_overshort_comment != '')
{
$manager_overshort_comment2=htmlspecialchars_decode($manager_overshort_comment);

$query3="update crs_tdrr_division_deposits
         set manager_overshort_comment='$manager_overshort_comment2'
         where id='$id'	 ; ";

		 
//echo "query3=$query3<br />";
		 
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
//echo "Line 59 exit<br />"; exit;

}

*/





/*

if($fs_approver_overshort_comment != '')
{
$query3="update crs_tdrr_division_deposits
         set fs_approver_overshort_comment='$fs_approver_overshort_comment'
         where id='$id'	 ; ";

		 
//echo "query3=$query3<br />";
		 
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");


}

*/


$query3="select controllers_deposit_id,bank_deposit_date
         from crs_tdrr_division_deposits
         where id='$id'	 ; ";

		 
//echo "query3=$query3<br />";
		 
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$row3=mysqli_fetch_array($result3);		  

extract($row3);
$bank_deposit_date2=date('m-d-y', strtotime($bank_deposit_date));
 
//echo "<br />controllers_deposit_id=$controllers_deposit_id<br />";
//echo "<br />bank_deposit_date=$bank_deposit_date<br />";




$query4="select crj_elapsed_override_approver,crj_elapsed_override_comments,controllers_deposit_id,bank_deposit_date
         from crs_tdrr_division_deposits
         where id='$id'	 ; ";

		 
//echo "query4=$query4<br />";
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
		  
//$row4=mysqli_fetch_array($result4);

//extract($row4);

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
 echo "<table align='center'><tr><td><img height='25' width='25' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'><font color='blue'><b>$center_location $center</b></font></img><br /><font color='brown' size='5'><b>CRJ Exception Override</b></font></td></tr></table>";
 
 
echo "<br /><br /><br />";
 echo "<table align='center'>";
 //echo "<tr><td>ORMS ID $orms_deposit_id</td></tr>";
 echo "<tr bgcolor='lightcyan'><td><font color='red' size='5'>Bank Deposit $controllers_deposit_id</font></td></tr>";
 echo "<tr bgcolor='lightcyan'><td>Bank Deposit Date $bank_deposit_date2</td></tr>"; 
 //echo "<tr><td>Cashier $cashier</td></tr>";
 echo "</table>";
 echo "<br />";
 echo "<br />";
 // 6/1/15: LAWA Seasonal employee Paula Wagner,  Budget Officer Tammy Dodd,  Accountant Tony Bass
 /*
 if($tempid=='Wagner9210' or $beacnum=='60032781' or $beacnum=='60032793')
 {
 echo "<table align='center'><tr><td><a href='check_listing.php?id=$id&edit=y'>Edit Check Listing</a></td></tr></table>";
 }
 */

 
 
 
 
 echo "<table border=1  align='center' id='table1'>";
//echo "<tr><th colspan='5'>DENR Daily Receipt Check Log</th></tr>";
echo "<tr>"; 
//echo "<th align=left><font color=brown>ORMS Deposit ID</font></th>";
//echo "<th align=left><font color=brown>Controllers Deposit ID</font></th>";       
echo "<th align=left><font color=brown>Budget Office</font></th>";


//echo "<th align=left><font color=brown>Bank<br />Deposit<br />Date</font></th>";
//echo "<th align=left><font color=brown>Cashier</font></th>";
	   
 
      
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row4=mysqli_fetch_array($result4)){
 
 extract($row4);

 echo "<tr><td><font color='purple'>Approved By:$crj_elapsed_override_approver</font><br /><font color='brown'>Exception Removed: $crj_elapsed_override_comments</font></td></tr>";
 
 }
echo "</table>";
 echo "</body></html>";
 
 
 
 
?>