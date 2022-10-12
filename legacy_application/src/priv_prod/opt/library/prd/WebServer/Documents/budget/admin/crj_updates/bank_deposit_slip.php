<?php
/*    *** INCLUDE file inventory  ***
include("/opt/library/prd/WebServer/include/iConnect.inc")
include("../../../budget/menu1314_tony.html")
include("1418.html")
*/
session_start();


if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

extract($_REQUEST);
$concession_location=$_SESSION['budget']['select'];
$tempid=$_SESSION['budget']['tempID'];
$level=$_SESSION['budget']['level'];
$beacnum=$_SESSION['budget']['beacon_num'];
//echo $concession_location;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$query12a="SELECT orms_deposit_id,controllers_deposit_id,bank_deposit_date,orms_start_date,orms_end_date,document_location,document_location_old,document_reload
 from crs_tdrr_division_deposits
 WHERE 1 and id='$id'
  ";
//echo "query12a=$query12a<br />"; 

$result12a = mysqli_query($connection, $query12a) or die ("Couldn't execute query 12a.  $query12a");

$row12a=mysqli_fetch_array($result12a);
extract($row12a);//brings back number of records paid by check

$bank_deposit_date2=date('m-d-y', strtotime($bank_deposit_date));
//echo "bank_deposit_date2=$bank_deposit_date2";

$query12b="SELECT min(transdate_new) as 'mindate_footer',max(transdate_new) as 'maxdate_footer'
 from crs_tdrr_division_history_parks
 WHERE 1 and deposit_id='$orms_deposit_id'
 and deposit_transaction='y'
 ";
 
$result12b = mysqli_query($connection, $query12b) or die ("Couldn't execute query 12b.  $query12b");

$row12b=mysqli_fetch_array($result12b);
extract($row12b);//brings back number of records paid by check
//echo "check count=$ck_count";
$mindate_footer2=date('m-d-y', strtotime($mindate_footer));
$maxdate_footer2=date('m-d-y', strtotime($maxdate_footer));


$revenue_collection_period=$mindate_footer2." thru ".$maxdate_footer2;


$query6="SELECT sum(amount) as 'bank_deposit_total' FROM crs_tdrr_division_history_parks
         where deposit_id='$orms_deposit_id'
		 ";
//echo "query6=$query6<br />";//exit;
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");
$row6=mysqli_fetch_array($result6);
extract($row6);

/*

$query1a="select first_name as 'cashier_first',nick_name as 'cashier_nick',last_name as 'cashier_last',count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	 
		  
*/		  


$query1a="select count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	
		  
//echo "query1a=$query1a<br />";
$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);

$query1b="select fs_approver
          from crs_tdrr_division_deposits
		  where orms_deposit_id='$orms_deposit_id' ";	
		  
//echo "query1b=$query1b<br />";
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);









//echo "cashier_count=$cashier_count";

echo "<html>";
echo "<head>
<title>MoneyTracker</title>";

//include ("test_style.php");
//include ("test_style.php");

echo "<style>";
echo "#table1{
width:800px;	
	}";
echo "</style>";

echo "<link rel=\"stylesheet\" href=\"/js/jquery_1.10.3/jquery-ui.css\" />
<script src=\"/js/jquery_1.10.3/jquery-1.9.1.js\"></script>
<script src=\"/js/jquery_1.10.3/jquery-ui.js\"></script>
<link rel=\"stylesheet\" href=\"/resources/demos/style.css\" />";
//echo "<link rel=\"stylesheet\" href=\"test_style_1657.css\" />";
echo "<link rel='stylesheet' type='text/css' href='1533d.css' />";

echo "
<script>
$(function() {
$( \"#datepicker\" ).datepicker({dateFormat: 'yy-mm-dd'});
});
</script>";




echo "</head>";
include("../../../budget/menu1314_tony.html");
include("1418.html");
echo "<body>";
 echo "<table>
 <tr bgcolor='cornsilk'><th>CRS Deposit $orms_deposit_id</th></tr><th><font color='red' size='5'>Deposit# $controllers_deposit_id on $bank_deposit_date2</font><br /><font color='red'>Collected $revenue_collection_period</font><br /><br /><font color='blue' size='6'>*****Deposit Slip Amount must equal $bank_deposit_total*****</font>";
 if($level > 3)
 {
 echo "<table align='center'><tr><td>Deposit Slip Match<br />";
      if($document_reload=='y'){echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of red X mark'></img>";}
 echo "</td><td>";
 echo "<form method='post' action='status_change_deposit_slip.php'>
				  <input type='hidden' name='id' value='$id'>
				   <input type='submit' name='submit2' value='YES'>
				   <input type='submit' name='submit2' value='NO'>
				  </form>";
				  echo "</td>
				  </tr></table>";
				  }

/* 2022-02-25: CCOOPER - adding access for A Boggus (242), C Williams (827), and R Goodson (256)
*/				  
// 60036015 Budget office (heide rumble), 60032781 Budget office (tammy dodd), 60032793 Budget office (Tony Bass)				  
 if(($cashier_count==1 and $fs_approver=='') or 
    ($beacnum=='60036015' or 
     $beacnum=='60032781' or 
     $beacnum=='60032793' or
     $beacnum=='60033242' or
     $beacnum=='65032827' or
     $beacnum=='60032997'))
/* 2022-02-25: End CCOOPER */
{
echo "<br />";
//echo "<div class='cashier_deposit'>";
//action='crs_deposits_cashier_deposit_update.php'
echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='bank_deposit_slip_update.php'>
Deposit Slip<input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'>
<input type='hidden' name='orms_deposit_id' value='$orms_deposit_id'>
<input type='hidden' name='id' value='$id'>
<input type='submit' name='submit' value='Submit'></form>";
}
 echo "</th> ";
 echo "</tr>";
 /* 2022-02-25: CCOOPER - adding access for A Boggus (242), C Williams (827), and R Goodson (256)
  and incl from above - 60036015 Budget office (heide rumble), 60032781 Budget office (tammy dodd), 60032793 Budget office (Tony Bass)
*/                    
 if(($cashier_count==1 and $fs_approver=='') or 
    ($beacnum=='60036015' or 
     $beacnum=='60032781' or 
     $beacnum=='60032793' or
     $beacnum=='60033242' or
     $beacnum=='65032827' or
     $beacnum=='60032997'))
  /* 2022-02-25: End CCOOPER   */
 {
echo "<tr>";
  echo "<form method='post' autocomplete='off' action='bank_deposit_slip_update2.php'>";
  echo "<th align='center'>bank deposit date<br /><input name='bank_deposit_date' type='text' id='datepicker' size='15' value='$bank_deposit_date'><input type='submit' name='submit3' value='Submit'>
       </th>";
//echo "<th align='center'><input type='submit' name='submit3' value='Submit'></th>";
  echo "<input type='hidden' name='id' value='$id'>";
  echo "</form>";
echo "</tr>";	 
 }
 
 
 echo "<tr>";
 echo "<td>";
 echo "<img height='1000' width='1000' src='$document_location'></img>";
 echo "</td>";
 echo "</tr>";
 echo "</table>";
 echo "</body>";
 echo "</html>";
 
?>