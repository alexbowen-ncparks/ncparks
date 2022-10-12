<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
//Enable North District OA Cara Hadfield to approved cash receipt journals for N. District
//$beacnum 60033148=cara hadfield position

//if($concession_center== '12802953'){$concession_center='12802751' ;}
//echo "concession_center=$concession_center";exit;
//echo "concession_location=$concession_location";exit;
//echo "concession_location=$concession_location";
//echo "concession_center=$concession_center";
extract($_REQUEST);
if($beacnum=='60033087'){echo "hello world<br /><br />";}
//echo $concession_location;

//echo "cooper(25) - concession_location=".$concession_location;
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");


//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}
/*
if($level=='5' and $tempID !='Dodd3454')
{

echo "beacon_number:$beacnum";
echo "<br />";
echo "concession_location:$concession_location";
echo "<br />";
echo "concession_center:$concession_center";
echo "<br />";
}
*/
$table="bank_deposits_menu";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
//echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>
<title>MoneyTracker</title>";

//include ("test_style.php");
//include ("test_style_deposit_form.php");
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

include("../../../budget/menu1314.php");
include("1418.html");
//include("menu1314_cash_receipts.php");
//include ("park_deposits_report_menu_v3.php");
//include ("widget2.php");

//include("widget1.php");
//6003-3148 = nodi oa (VACANT)
//6003-3199 = nodi acting oa (cara hadfield)
//6003-3104 = nodi disu (dave cook)
//6003-3093 = sodi oa (val mitchener)
//6003-3019 = sodi disu (jay greenwood)
//6003-2892 = eadi oa (sherry quinn)
//6003-2912 = eadi disu (vacant)
//6003-2931 = wedi oa (julie bunn)
//6003-2913 = wedi disu (sean mcelhone)
//6003-2920 = chop oa (denise williams)
//6003-3018 = chop (adrian oneal)









//Denise Williams (CHOP OA), 

//if($beacnum=='60033148' or $beacnum=='60033199' or $beacnum=='60033104' or $beacnum=='60033093' or $beacnum=='60033019' or $beacnum=='60032892' or $beacnum=='60032912' or $beacnum=='60032931' or $beacnum=='60032913' or $beacnum=='60032920' or $beacnum=='60033018')

//Changed on 5/13/20
//Denise Williams (CHOP OA),Val Mitchener (SODI OA),Jay Greenwood (SODI Sup),Sherry Quinn (EADI OA),John Fullwood (EADI Sup),Annette Hall (WEDI OA),Sean McElhone (WEDI Sup),Kristen Woodruff (NODI Sup)
if($beacnum=='60033148' or $beacnum=='60033093' or $beacnum=='60033019' or $beacnum=='60032892' or $beacnum=='60032912' or $beacnum=='60032931' or $beacnum=='60032913' or $beacnum=='60032920' or $beacnum=='65030652')
{
$query1="SELECT park,center from crs_tdrr_division_deposits
         where orms_deposit_id='$deposit_id' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);

$concession_location=$park;
$concession_center=$center;

//echo "query1=$query1";

}
//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";


$query1="SELECT park FROM crs_tdrr_division_deposits where orms_deposit_id='$deposit_id'";
echo "query1=$query1<br />";//exit;
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$row1=mysqli_fetch_array($result1);
extract($row1);

$park4checks=strtoupper($park);
//echo "park4checks=$park4checks<br />";//exit;

/*
$query2="SELECT max(controllers_deposit_id) as 'controllers_max' FROM crs_tdrr_division_deposits where park='$park'";
*/

$query2="select controllers_deposit_id  FROM crs_tdrr_division_deposits
         where orms_deposit_id='$deposit_id'";

//echo "query2=$query2<br />";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$row2=mysqli_fetch_array($result2);
extract($row2);


//$controllers_next=$controllers_max+1;



//echo "controllers_next=$controllers_next<br />";

$query3="SELECT sum(amount) as 'cash_total' FROM crs_tdrr_division_history_parks
         where deposit_id='$deposit_id'
         and payment_type='cash'
         and ncas_account != '000437995'		 ";
//echo "query3=$query3<br />";//exit;
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$row3=mysqli_fetch_array($result3);
extract($row3);
if($cash_total==''){$cash_total='0';}
//echo "cash_total=$cash_total<br />";


$query4="SELECT sum(amount) as 'check_total' FROM crs_tdrr_division_history_parks
         where deposit_id='$deposit_id'
		 and payment_type='per chq' ";
//echo "query4=$query4<br />";//exit;
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$row4=mysqli_fetch_array($result4);
extract($row4);
if($check_total==''){$check_total='0';}
//echo "check_total=$check_total<br />";

$query5="SELECT sum(amount) as 'money_order_total' FROM crs_tdrr_division_history_parks
         where deposit_id='$deposit_id'
		 and (payment_type='mon ord' or payment_type='cert chq' or payment_type='trav chk') ";
//echo "query5=$query5<br />";//exit;
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$row5=mysqli_fetch_array($result5);
extract($row5);
if($money_order_total==''){$money_order_total='0';}
//echo "money_order_total=$money_order_total<br />";


$query6="SELECT sum(amount) as 'over_short_total' FROM crs_tdrr_division_history_parks
         where deposit_id='$deposit_id'
		 and ncas_account='000437995'
         ";
//echo "query6=$query6<br />";//exit;
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");
$row6=mysqli_fetch_array($result6);
extract($row6);
if($over_short_total==''){$over_short_total='0';}
//echo "over_short_total=$over_short_total<br />";
/*
echo "cash_total=$cash_total<br />";
echo "check_total=$check_total<br />";
echo "money_order_total=$money_order_total<br />";
echo "over_short_total=$over_short_total<br />";
*/
$bank_deposit_total=$cash_total+$check_total+$money_order_total+$over_short_total;
//if($deposit_id=='240925509'){$bank_deposit_total='181.32';}
//if($deposit_id=='262889737'){echo "<table border='1'><tr><td>$cash_total</td><td>$check_total</td><td>$money_order_total</td><td>$over_short_total</td></tr></table>";}
$bank_deposit_total=number_format($bank_deposit_total,2);

$query12="SELECT crs_tdrr_division_history_parks.center,center.parkcode,taxcenter,ncas_account,account_name,sum(amount) as 'amount'  from crs_tdrr_division_history_parks
 left join center on crs_tdrr_division_history_parks.center=center.center
 WHERE 1 and deposit_id='$deposit_id'
 and deposit_transaction='y'
 group by center,ncas_account
 order by center,ncas_account";
 
//echo "query12=$query12<br />";
			
 $result12 = mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12 ");
 $num12=mysqli_num_rows($result12);
 
 /*
 $query_ck="SELECT count(payment_type) as 'ck_count'
            from crs_tdrr_division_history_parks
            where deposit_id='$deposit_id'
            and	payment_type='per chq' ";

$result_ck = mysqli_query($connection, $query_ck) or die ("Couldn't execute query ck.  $query_ck");

$row_ck=mysqli_fetch_array($result_ck);
extract($row_ck);//brings back number of records paid by check
 
 if($ck_count > 0){$check='yes';} else {$check='no';}
 
 */


$query_ck="SELECT checks from crs_tdrr_division_deposits
           where orms_deposit_id='$deposit_id' ";

$result_ck = mysqli_query($connection, $query_ck) or die ("Couldn't execute query ck.  $query_ck");

$row_ck=mysqli_fetch_array($result_ck);
extract($row_ck);//brings back number of records paid by check
 
 if($checks=='y'){$check='yes';} else {$check='no';}

 
 $query12b="SELECT min(transdate_new) as 'mindate_footer',max(transdate_new) as 'maxdate_footer'
 from crs_tdrr_division_history_parks
 WHERE 1 and deposit_id='$deposit_id'
 and deposit_transaction='y'
 ";
 
$result12b = mysqli_query($connection, $query12b) or die ("Couldn't execute query 12b.  $query12b");

$row12b=mysqli_fetch_array($result12b);
extract($row12b);//brings back number of records paid by check
//echo "check count=$ck_count";
$mindate_footer2=date('m-d-y', strtotime($mindate_footer));
$maxdate_footer2=date('m-d-y', strtotime($maxdate_footer));


$revenue_collection_period=$mindate_footer2." thru ".$maxdate_footer2;

//echo "<table><tr><th>Bank Deposit</th></tr></table>";
//echo "<H1 ALIGN=CENTER > <font color='red'>Duplicate project_note_id=$project_note_id</font></H1>";

//echo "<br/>";


//echo "<form name='form1' method='post' action='edit_record_duplicate_insert.php'>";

echo "<font color=blue size=5>";



//echo  "user:<input name='user' type='text' id=user value=\"$user\">";
//echo "<br />system_entry_date:<input name='system_entry_date' type='text' id=system_entry_date value=\"$system_entry_date\">";
//echo "<br />Category:<input name='project_category' type='text' id=project_category size=50 value=\"$project_category\">";
//echo "<br />Topic:<input name='project_name' type='text' id=project_name size=50 value=\"$project_name\">";

$query1a="select first_name as 'cashier_first',nick_name as 'cashier_nick',last_name as 'cashier_last',count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	 
		  
//echo "<br />query1a=$query1a<br />";		  

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);
//echo "<br />cashier_count=$cashier_count<br />";


if($cashier_nick){$cashier_first=$cashier_nick;}			  
		  
//echo "Line 321 query1a=$query1a<br />";//exit;
//echo "cashier_count=$cashier_count<br />";//exit;
//echo "cashier_first=$cashier_first<br />";//exit;
//echo "cashier_last=$cashier_last<br />";//exit;

/*
if($cashier_count==1)
{

echo "cashier access ok<br />";//exit;
}
else
{
echo "no cashier access<br />";//exit;
}
*/


$query1b="select first_name as 'manager_first',nick_name as 'manager_nick',last_name as 'manager_last',count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempid' ";	 

//if($beacnum=='60033018')

//{echo "line 345 query1b=$query1b<br />";}		  
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);

if($manager_nick){$manager_first=$manager_nick;}	



$query1c="select first_name as 'fs_approver_first',nick_name as 'fs_approver_nick',last_name as 'fs_approver_last',count(id) as 'fs_approver_count'
          from cash_handling_roles
		  where park='admi' and role='fs_approver' and tempid='$tempid' ";	 

$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");
		  
$row1c=mysqli_fetch_array($result1c);

extract($row1c);

if($fs_approver_count==1)
{
/*
echo "<table border='1'><tr><th>fs_approver_first</th><th>fs_approver_nick</th><th>fs_approver_last</th><th>fs_approver_count</th></tr>
<tr>
<td>$fs_approver_first</td>
<td>$fs_approver_nick</td>
<td>$fs_approver_last</td>
<td>$fs_approver_count</td>
</tr>
</table>
";
*/
$query1b="select park as 'park_fs_approver'
          from crs_tdrr_division_deposits
		  where orms_deposit_id='$deposit_id' ";	

//echo "query1d=$query1d<br />";//exit;		  

$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);


}
		  
		  
//echo "query1b=$query1b<br />";//exit;
//echo "manager_count=$manager_count<br />";//exit;
//echo "manager_first=$manager_first<br />";//exit;
//echo "manager_last=$manager_last<br />";//exit;

/*
if($manager_count==1){

echo "manager access ok<br />";//exit;
}
else
{
echo "no manager access<br />";//exit;
}
*/

//$cashier='Christy Maready';
//$manager='Doug Lequire';


//if($cashier_count==1)
//{
//echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='crs_deposits_cashier_deposit_update.php'>";


//echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   //echo "<tr><th><font color='blue'>Field</font></th><th>Value</th></tr>";
	 //  echo "<tr>";
	   //echo "<th>ORMS<br /><font color='blue'>$deposit_id</th>";
	  // echo "<th>Deposit<br /> <font color='blue'>$controllers_next</font></th>";
	   //echo "<th>Amount<br /> <font color='blue'>$bank_deposit_total</font></th>";
	   //echo "<th>Period<br /> <font color='blue'>$revenue_collection_period</font></th>";
	   //echo "<th>Checks<br /> <font color='blue'>$check</font></th>";
	   
	   /*
	   echo "<th>ORMS ID <font color='blue'>$deposit_id</font><br />Deposit # <font color='blue'>$controllers_next</th>";
	   */
	   //echo "<th>ORMS ID <font color='blue'><br />$deposit_id</font></th>"; 
	   
	   
	   
	   
	 //  echo "<th>bank deposit date<br /><input name='bank_deposit_date' type='text' id='datepicker' size='15'></th>";	   
	   //echo "<th>deposit amount<br /><input name='bank_deposit_ type='text'</th>";	   
	 //  echo "<th>Deposit Slip<input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'><br /><font color='blue'>Amount must equal $bank_deposit_total</font></th>";	   
	   //echo "<th>Cashier<br /> <font color='blue'>$cashier</font></th>";
	   //echo "<th>Manager<br /> <font color='blue'>$manager</font></th>";
	//   echo "</tr>";
	   //echo "<tr><th></th></tr>";
	   /*
	   echo "<tr><td><font color='blue'>Cash Total</font></td><td><input type='text' readonly='readonly' name='cash_total' value='$cash_total'></td></tr>";
	   echo "<tr><td><font color='blue'>Check Total</font></td><td><input type='text' readonly='readonly' name='check_total' value='$check_total' ></td></tr>";
	   echo "<tr><td><font color='blue'>Money Order Total</font></td><td><input type='text' readonly='readonly' name='money_order_total' value='$money_order_total'></td></tr>";
	   echo "<tr><td><font color='blue'>Over/Short Total</font></td><td><input type='text' readonly='readonly' name='over_short_total' value='$over_short_total'></td></tr>";
	   echo "<tr><td><font color='blue'>Bank Deposit Total</td></font><td><input type='text' readonly='readonly' name='step' value='$bank_deposit_total'></td></tr>";
	   echo "<tr><td><font color='red'>step_num</td></font><td><input type='text' name='step_num' value='$step_num'></td></tr>";
	   //echo "<tr><td><font color='blue'>step_name</td></font><td><input type='text' name='step_name' value='$step_name'></td></tr>";
	   echo "<tr><td><font color='red'>step_name</td></font><td><textarea name='step_name' cols='30' rows='5'>$step_name</textarea></td></tr>";
	   echo "<tr><td><font color='blue'>link</td></font><td><input type='text' name='link' value='$link' ></td></tr>";
	   echo "<tr><td><font color='blue'>weblink</font></td><td><input type='text' name='weblink' value='$weblink'></td></tr>";
	   echo "<tr><td><font color='blue'>status</font></td><td><input type='text' name='status' value='$status'></td></tr>";
	   */
	 //  	   echo "</table>";
//}	



if($manager_count==1)
{
//echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='crs_deposits_cashier_deposit_update.php'>";


echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   //echo "<tr><th><font color='blue'>Field</font></th><th>Value</th></tr>";
	   echo "<tr>";
	   //echo "<th>ORMS<br /><font color='blue'>$deposit_id</th>";
	  // echo "<th>Deposit<br /> <font color='blue'>$controllers_next</font></th>";
	   //echo "<th>Amount<br /> <font color='blue'>$bank_deposit_total</font></th>";
	   //echo "<th>Period<br /> <font color='blue'>$revenue_collection_period</font></th>";
	   //echo "<th>Checks<br /> <font color='blue'>$check</font></th>";
	   
	   /*
	   echo "<th>ORMS ID <font color='blue'>$deposit_id</font><br />Deposit # <font color='blue'>$controllers_next</th>";
	   */
	   //echo "<th>ORMS ID <font color='blue'><br />$deposit_id</font></th>"; 
	   //echo "<th>Revenue Collection Period<font color='blue'><br />$revenue_collection_period</font></th>"; 

/*	   
	   $query1e="select bank_deposit_date from crs_tdrr_division_deposits
	             where orms_deposit_id='$deposit_id'     ";	

  

$result1e = mysqli_query($connection, $query1e) or die ("Couldn't execute query 1e.  $query1e");
		  
$row1e=mysqli_fetch_array($result1e);

extract($row1e);
$bank_deposit_date2=date('m-d-y', strtotime($bank_deposit_date));	
*/   
	   
	   //echo "<th>bank deposit date<br /><font color='blue'>$bank_deposit_date</font></th>";	   
	   //echo "<th>deposit amount<br /><input name='bank_deposit_ type='text'</th>";
	   
	   /*
	   echo "<th>Deposit Slip<input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'><br /><font color='blue'>Amount must equal $bank_deposit_total</font></th>";	
	   */
	   //echo "<th>Revenue Collection Period<br /><font color='blue'>$revenue_collection_period</font></th>";  
	   

	   
	   //echo "<th>Cashier<br /> <font color='blue'>$cashier</font></th>";
	   //echo "<th>Manager<br /> <font color='blue'>$manager</font></th>";
	   echo "</tr>";
	   //echo "<tr><th></th></tr>";
	   /*
	   echo "<tr><td><font color='blue'>Cash Total</font></td><td><input type='text' readonly='readonly' name='cash_total' value='$cash_total'></td></tr>";
	   echo "<tr><td><font color='blue'>Check Total</font></td><td><input type='text' readonly='readonly' name='check_total' value='$check_total' ></td></tr>";
	   echo "<tr><td><font color='blue'>Money Order Total</font></td><td><input type='text' readonly='readonly' name='money_order_total' value='$money_order_total'></td></tr>";
	   echo "<tr><td><font color='blue'>Over/Short Total</font></td><td><input type='text' readonly='readonly' name='over_short_total' value='$over_short_total'></td></tr>";
	   echo "<tr><td><font color='blue'>Bank Deposit Total</td></font><td><input type='text' readonly='readonly' name='step' value='$bank_deposit_total'></td></tr>";
	   echo "<tr><td><font color='red'>step_num</td></font><td><input type='text' name='step_num' value='$step_num'></td></tr>";
	   //echo "<tr><td><font color='blue'>step_name</td></font><td><input type='text' name='step_name' value='$step_name'></td></tr>";
	   echo "<tr><td><font color='red'>step_name</td></font><td><textarea name='step_name' cols='30' rows='5'>$step_name</textarea></td></tr>";
	   echo "<tr><td><font color='blue'>link</td></font><td><input type='text' name='link' value='$link' ></td></tr>";
	   echo "<tr><td><font color='blue'>weblink</font></td><td><input type='text' name='weblink' value='$weblink'></td></tr>";
	   echo "<tr><td><font color='blue'>status</font></td><td><input type='text' name='status' value='$status'></td></tr>";
	   */
	   	   echo "</table>";
}		   
//echo "</form>";
//echo "<br /> <br />";
//echo "<input type='submit' name='submit' value='ADD New Record'>";

//echo "</form>";
/*
if($check=='yes'){$yes_selected=' selected';}else{$no_selected=' selected';}
echo "<table>";
echo "<tr$t><form>";
echo "<td colspan='2'><font color='red'>Checks:</font><select name='checks_included'>
  <option value=''></option>
  <option value='yes' $yes_selected>YES</option>
  <option value='no' $no_selected>NO</option>
  </select></td>";
  
 echo "<td colspan='3'><font color='red'>Revenue Collection Period:</font><br /><input type='text' name='collection_period' value='$revenue_collection_period' size='45'><br /><br /></td>        
</tr>";
echo "</form>";
echo "</table>";
*/




 /*
 
 $query13="SELECT sum(amount) as 'total_amount' 
            from crs_tdrr_division_history_parks
			WHERE 1
			and deposit_id='$deposit_id'
			and deposit_transaction='y'
			 ";
			
 $result13 = mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13 ");
 $num13=mysqli_num_rows($result13);
 
 
$query14="SELECT sum(amount) as 'total_debits' 
            from crs_tdrr_division_history_parks
			WHERE 1
			and deposit_id='$deposit_id'
			and amount < '0'
            and deposit_transaction='y' ";
			
 $result14 = mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14 ");
 $num14=mysqli_num_rows($result14);
 $row14=mysqli_fetch_array($result14);
 extract($row14);
 $total_debits=number_format($total_debits,2);
 
 $query15="SELECT sum(amount) as 'total_credits' 
            from crs_tdrr_division_history_parks
			WHERE 1
			and deposit_id='$deposit_id'
			and amount >= '0' 
			and deposit_transaction='y' ";
			
 $result15 = mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15 ");
 $num15=mysqli_num_rows($result15);
 $row15=mysqli_fetch_array($result15);
 extract($row15);
 $total_credits=number_format($total_credits,2); 
 
 */
 if($fs_approver_count==1)
 {
 $query11e="select center_desc from center where parkcode='$park_fs_approver' and fund='1280'   ";	
 }
 else
 {
 $query11e="select center_desc from center where parkcode='$concession_location' and fund='1280'   ";	 
 }
 
 
 
 
//echo "query11e=$query11e<br />";//exit;		  

$result11e = mysqli_query($connection, $query11e) or die ("Couldn't execute query 11e.  $query11e");
		  
$row11e=mysqli_fetch_array($result11e);

extract($row11e);

/*echo "cooper(628) - center_desc=".$center_desc;
echo "<br>";
echo "cooper(630) - center_location=".$center_location;
*/
$center_location = str_replace("_", " ", $center_desc);
//echo "center location=$center_location";
/*echo "cooper(633) - center_desc=".$center_desc;
echo "<br>";
echo "cooper(635) - center_location=".$center_location;
*/

 if($center_location=='administration'){$center_location='Financial Services Group' ;}
 
 echo "<div class='mc_header'>";
echo "<table><tr><th><img height='50' width='50' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'></img></th><th><font color='blue'>MoneyCounts-$center_location</font></th></tr></table>";
echo "</div>";
 
 
 
 
 
 
 
 
 
 
//$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

//$row11=mysqli_fetch_array($result11);

//extract($row11);
echo "<br />";
//echo "<div id='body'>";
/*
echo "<div class='column1of4'>";
echo "<table><tr><th>Deposit</th><td><font color='blue'>  $controllers_next</font></td></tr></table>"; 
*/
echo "<div class='column1of4'>";
//echo "<table><tr><th>Deposit<br /><font color='blue'>$controllers_next</font></th></tr></table>"; 



echo "<table border=1>";

//echo "<tr>"; 
//echo "<th>Line#</th>";
//echo "<th>Park</th>";
//echo "<th>Company</th>";
//echo "<th>Account</th>";
//echo "<th>Center</th>";

//echo "<th>Debit/Credit</th>";
//echo "<th>Line Description</th>";
//echo "<th>Amount</th>";
//echo "<th>Acct Rule</th>";             
//echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
//$var_total_credit="";
//$var_total_debit="";

$query6a="SELECT sum(amount) as 'bank_deposit_total' FROM crs_tdrr_division_history_parks where deposit_id='$deposit_id'  ";
//echo "query6a=$query6a<br />";//exit;
$result6a = mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a.  $query6a");
$row6a=mysqli_fetch_array($result6a);
extract($row6a);
$bank_deposit_total=number_format($bank_deposit_total,2);


echo "<tr><th colspan='2'>CRS Deposit $deposit_id</th></tr>";
while ($row12=mysqli_fetch_array($result12))
	{

	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	extract($row12);
	if($ncas_account=='435900001'){$account_name='CRS Transaction Fees';}
	if($ncas_account=='000211940'){$center=$taxcenter;}
	if($ncas_account=='000211940'){$account_name='sales tax';}
	/*
	if($amount < '0')
		{
		$var_total_debit+=$amount;
		$sign="debit";
		}
		else
		{
		$var_total_credit+=$amount;
		$sign="credit";
		}
		*/
	$amount=number_format($amount,2);
	if($ncas_account=='000218110'){$center="2235";}
	if($ncas_account=='435900001'){$center="12802751";}
	if($ncas_account=='000200000'){$ncas_account="";}
	if($ncas_account=='000300000'){$ncas_account="";}
	if($center=='2235'){$company='1602';} else {$company='1601';}

	//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
	//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
	$t=" bgcolor='lightcyan'";
	//if($sign=="debit"){$sto="<strong>(";$stc=")</strong>";}else{$sto="";$stc="";}
	if($ncas_account=='000437995' and ($amount <= -10.00 or $amount >= 10.00)){$redfont="<font color='red' ";}
	if($amount != '0.00')
		{
		@$rank=$rank+1;

		echo "<tr$t>"; 
		//echo "<td>$rank</td>";
		//echo "<td>$parkcode</td>";			
		//echo "<td>$company</td>";
		//echo "<td>$ncas_account</td>";
		//echo "<td>$center</td>";
		
		//echo "<td>$sto $sign $stc</td>";
		echo "<td><font $redfont>$account_name</font></td>";
		echo "<td><font $redfont>$amount</font></td>";
		if($ncas_account=='000437995' and ($amount <= -10.00 or $amount >= 10.00) and $cashier_count==1)
		{
		echo "<td><font color='red'>Over/Short exceeds $10. Enter Cashier Comment below. Thanks</font></td>";
		}
				
		if($ncas_account=='000437995' and ($amount <= -10.00 or $amount >= 10.00) and $manager_count==1)
		{
		echo "<td><font color='red'>Over/Short exceeds $10. Enter Manager Comment below. Thanks</font></td>";
		}
		
		
		
		
		
		/*
		if($ncas_account=='000437995' and ($amount <= -10.00 or $amount >= 10.00) and $fs_approver_count==1)
		{
		echo "<td>BUOF Comment Required</td>";
		}
		*/
		
		
		
		
		
		//echo "<td></td>";	   
		echo "</tr>";


		}
	$redfont="";	
	}
//echo "<tr><td><font color='blue'>ORMS ID $deposit_id</font><br /><font color='red'>";
//if($deposit_id=='251901298'){$bank_deposit_total='3556.75';}
echo "<tr bgcolor='cornsilk'><td><font color='blue'>Deposit Amount</font><br /><font color='red'>";

//if($controllers_deposit_id)
//{echo "Deposit# $controllers_deposit_id";}
echo"</td><td><font color='blue'>$bank_deposit_total</td></font></tr>";	
echo "</table>";

$depid_parkcode = substr($deposit_id, 0, 4);
if($level > 3 and $depid_parkcode=='ADMI')
{
//echo "depid_parkcode=$depid_parkcode"; 
$query1ca="select cashier from crs_tdrr_division_deposits
          where park='$concession_location' and orms_deposit_id='$deposit_id' ";
		  
		  
//echo "query1c=$query1c<br />";//exit;		  
		  
		  
$result1ca = mysqli_query($connection, $query1ca) or die ("Couldn't execute query 1ca.  $query1ca");
		  
$row1ca=mysqli_fetch_array($result1ca);

extract($row1ca);		  
		  

$query1da="select 
          cash_handling_roles.first_name as 'cashier_fname',
		  cash_handling_roles.nick_name as 'cashier_nname',
		  cash_handling_roles.last_name as 'cashier_lname'
		  from cash_handling_roles
		  left join crs_tdrr_division_deposits on cash_handling_roles.park=crs_tdrr_division_deposits.park
		  where crs_tdrr_division_deposits.orms_deposit_id='$deposit_id' 
		  and crs_tdrr_division_deposits.cashier=cash_handling_roles.tempid ";	

//echo "query1d=$query1d<br />";//exit;		  

$result1da = mysqli_query($connection, $query1da) or die ("Couldn't execute query 1da.  $query1da");
		  
$row1da=mysqli_fetch_array($result1da);

extract($row1da);
if($cashier_nname){$cashier_fname=$cashier_nname;}	


$query1ea="select 
          cash_handling_roles.first_name as 'manager_fname',
		  cash_handling_roles.nick_name as 'manager_nname',
		  cash_handling_roles.last_name as 'manager_lname'
		  from cash_handling_roles
		  left join crs_tdrr_division_deposits on cash_handling_roles.park=crs_tdrr_division_deposits.park
		  where crs_tdrr_division_deposits.orms_deposit_id='$deposit_id' 
		  and crs_tdrr_division_deposits.manager=cash_handling_roles.tempid ";	

//echo "query1e=$query1e<br />";//exit;		  

$result1ea = mysqli_query($connection, $query1ea) or die ("Couldn't execute query 1ea.  $query1ea");
		  
$row1ea=mysqli_fetch_array($result1ea);

extract($row1ea);
if($manager_nname){$manager_fname=$manager_nname;}

echo "<form method='post' autocomplete='off' action='crs_deposits_fs_approver_deposit_update.php'>";


echo "<table>";
echo "<tr><th>Cashier: $cashier_fname $cashier_lname</th><td><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td></tr>";

/*
echo "<tr><th>Manager: $manager_fname $manager_lname</th><td><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td></tr>";
*/

echo "<tr><th>Manager/FS Approver: $fs_approver_first $fs_approver_last</th><td>Approved:<input type='checkbox' name='fs_approver_approved' value='y'></td>";
//echo "<input type='hidden' name='checks' value='$check'>";
echo "<input type='hidden' name='orms_deposit_id' value='$deposit_id'>";
echo "<input type='hidden' name='depid_parkcode' value='$depid_parkcode'>";
//echo "<input type='hidden' name='controllers_next' value='$controllers_next'>";
echo "<td><input type='submit' name='submit' value='Submit'></td></tr>";
echo "</table>";
echo "</form>";
//echo "<br />check=$check"; 
exit;
}
echo "</div>";




if($cashier_count==1)
{
echo "<div class='cashier_deposit'>";
echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='crs_deposits_cashier_deposit_update.php'>";

/*

$query_rcf="select count(id) as 'rcf_count',sum(amount) as 'rcf_amount' from crs_tdrr_division_history_parks where deposit_id='$deposit_id' and ncas_account='000437994'   ";	 
  
//echo "query_rcf=$query_rcf<br />";//exit;		  

$result_rcf = mysqli_query($connection, $query_rcf) or die ("Couldn't execute query query_rcf.  $query_rcf");
		  
$row_rcf=mysqli_fetch_array($result_rcf);

extract($row_rcf);

if($rcf_count > 0){$rcf='y';}

*/





//echo "rcf_count=$rcf_count<br />";
//echo "rcf_amount=$rcf_amount<br />";


/*
if($rcf=='y')
{

echo "<table><tr><th colspan='2'>Allocate $rcf_amount reimbursement for RC</th></tr>";
echo "<tr><td align='center'>Account</td><td align='center'>Amount</td></tr>";
echo "<tr>";
echo "<td><input name='rc_account[]' type='text' size='15' value=''></td>";
echo "<td><input name='rc_amount[]' type='text' size='10' value=''></td>";
echo "</tr>";


echo "<tr>";
echo "<td><input name='rc_account[]' type='text' size='15' value=''></td>";
echo "<td><input name='rc_amount[]' type='text' size='10' value=''></td>";
echo "</tr>";


echo "<tr>";
echo "<td><input name='rc_account[]' type='text' size='15' value=''></td>";
echo "<td><input name='rc_amount[]' type='text' size='10' value=''></td>";
echo "</tr>";


echo "</table>";
echo "<br />";
}
*/


$query12_a="select sum(amount) as 'over_short_amount' from crs_tdrr_division_history_parks
            where deposit_id='$deposit_id'
            and ncas_account='000437995' ";
		 
//echo "query12_a=$query12_a<br />";		 

$result12_a = mysqli_query($connection, $query12_a) or die ("Couldn't execute query 12_a.  $query12_a");

$row12_a=mysqli_fetch_array($result12_a);
extract($row12_a);
if($over_short_amount==''){$over_short_amount='0';}
//echo "over_short_amount=$over_short_amount<br />";


if($over_short_amount <= -10.00 or $over_short_amount >= 10.00)
{

echo "<table border=1>";
echo "<tr>";
echo "<td>";


echo "<textarea rows='11' cols='35' name='cashier_overshort_comment' placeholder='Enter Cashier Justification for Over/Short Amount'>$cashier_over_short_comment</textarea>";



echo "</td>";
echo "</tr>";
echo "</table>";
echo "<br />";
}

echo "<table border=1>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   //echo "<tr><th><font color='blue'>Field</font></th><th>Value</th></tr>";
	   echo "<tr>";
	   //echo "<th>ORMS<br /><font color='blue'>$deposit_id</th>";
	  // echo "<th>Deposit<br /> <font color='blue'>$controllers_next</font></th>";
	   //echo "<th>Amount<br /> <font color='blue'>$bank_deposit_total</font></th>";
	   //echo "<th>Period<br /> <font color='blue'>$revenue_collection_period</font></th>";
	   //echo "<th>Checks<br /> <font color='blue'>$check</font></th>";
	   
	   /*
	   echo "<th>ORMS ID <font color='blue'>$deposit_id</font><br />Deposit # <font color='blue'>$controllers_next</th>";
	   */
	   //echo "<th>ORMS ID <font color='blue'><br />$deposit_id</font></th>"; 
	   
	   
	   
	   
	   echo "<th>bank deposit date<br /><input name='bank_deposit_date' type='text' id='datepicker' size='15'></th>";	   
	   //echo "<th>deposit amount<br /><input name='bank_deposit_ type='text'</th>";	   
	   echo "<th>"; echo "Stamped Deposit Slip (processed by Bank)<br /><input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'><br /><font color='blue'>Amount must equal $bank_deposit_total</font></th>";	   
	   //echo "<th>Cashier<br /> <font color='blue'>$cashier</font></th>";
	   //echo "<th>Manager<br /> <font color='blue'>$manager</font></th>";
	   echo "</tr>";
	   //echo "<tr><th></th></tr>";
	   /*
	   echo "<tr><td><font color='blue'>Cash Total</font></td><td><input type='text' readonly='readonly' name='cash_total' value='$cash_total'></td></tr>";
	   echo "<tr><td><font color='blue'>Check Total</font></td><td><input type='text' readonly='readonly' name='check_total' value='$check_total' ></td></tr>";
	   echo "<tr><td><font color='blue'>Money Order Total</font></td><td><input type='text' readonly='readonly' name='money_order_total' value='$money_order_total'></td></tr>";
	   echo "<tr><td><font color='blue'>Over/Short Total</font></td><td><input type='text' readonly='readonly' name='over_short_total' value='$over_short_total'></td></tr>";
	   echo "<tr><td><font color='blue'>Bank Deposit Total</td></font><td><input type='text' readonly='readonly' name='step' value='$bank_deposit_total'></td></tr>";
	   echo "<tr><td><font color='red'>step_num</td></font><td><input type='text' name='step_num' value='$step_num'></td></tr>";
	   //echo "<tr><td><font color='blue'>step_name</td></font><td><input type='text' name='step_name' value='$step_name'></td></tr>";
	   echo "<tr><td><font color='red'>step_name</td></font><td><textarea name='step_name' cols='30' rows='5'>$step_name</textarea></td></tr>";
	   echo "<tr><td><font color='blue'>link</td></font><td><input type='text' name='link' value='$link' ></td></tr>";
	   echo "<tr><td><font color='blue'>weblink</font></td><td><input type='text' name='weblink' value='$weblink'></td></tr>";
	   echo "<tr><td><font color='blue'>status</font></td><td><input type='text' name='status' value='$status'></td></tr>";
	   */
	   	   echo "</table>";

}
echo "</div>";
//5/13/20 Added lines below to determine whether Park completing Form is on the CRS System. $crs_status=y for CRS Parks. $crs_status=n for Non-CRS Parks.  Currently, crs parks=34, non-crs parks=6
$query_crs_status="select crs as 'crs_status' from center_taxes where parkcode='$park4checks' ";
		 
//echo "query_crs_status=$query_crs_status<br />";		 

$result_crs_status = mysqli_query($connection, $query_crs_status) or die ("Couldn't execute query_crs_status.  $query_crs_status");

$row_crs_status=mysqli_fetch_array($result_crs_status);
extract($row_crs_status);

//echo "<br /> Line 1004: crs_status=$crs_status<br />";

//Change made on 5/13/20
//if($park4checks == 'CACR' or $park4checks == 'DISW' or $park4checks == 'FOMA' or $park4checks == 'HARI' or $park4checks == 'JORI' or $park4checks == 'MOJE' or $park4checks == 'SILA' or $park4checks == 'MARI' ){$crs_park='no';}
//ONLY CRS Parks are required to enter Check Info on this Form.  Check info for Non-CRS parks has already been entered into MoneyCounts at the time this form is completed
if($crs_status=='n' or $crs_status=='N'){$crs_park='no';}


if($crs_park != 'no')
{
if($check=='yes' and $cashier_count==1)
{
echo "<div class='column2of4'>";
echo "<table border='1'>";
echo "<tr>";
echo "<th>Check#</th><th>Payor</th><th>Payor<br />Bank</th><th>Amount</th><th>Description</th>";
echo "</tr>";
echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";
echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";
echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";
echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";

echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";

echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";

echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";

echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";


echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";

echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";

echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";

echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";

echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";

echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";

echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";


echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";

echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";


echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";


echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";


echo "<tr>";
echo "<td><input name='checknum[]' type='text' size='10' value=''></td>";
echo "<td><input name='payor[]' type='text' size='25' value=''></td>";
echo "<td><input name='payor_bank[]' type='text' size='25' value=''></td>";
echo "<td><input name='ck_amount[]' type='text' size='9' value=''></td>";
echo "<td><input name='description[]' type='text' size='25' value=''></td>";
echo "</tr>";

/*
if($tempid=='wagner9210')
{
include("checklisting_total_lines_eighty.php");

}
*/
echo "</table>";
echo "</div>";	
}
}
if($manager_count==1 or $fs_approver_count==1)
{



$query1f="select document_location from crs_tdrr_division_deposits
	             where orms_deposit_id='$deposit_id'     ";	

//echo "query1f=$query1f<br />";//exit;		  

$result1f = mysqli_query($connection, $query1f) or die ("Couldn't execute query 1f.  $query1f");
		  
$row1f=mysqli_fetch_array($result1f);

extract($row1f);

$query12_b="select cashier,cashier_overshort_comment,manager,manager_overshort_comment,fs_approver,fs_approver_overshort_comment,accountant_comment_name,
accountant_comment   from crs_tdrr_division_deposits where orms_deposit_id='$deposit_id'  ";
		 
//echo "query12_b=$query12_b<br />";		 

$result12_b = mysqli_query($connection, $query12_b) or die ("Couldn't execute query 12_b.  $query12_b");

$row12_b=mysqli_fetch_array($result12_b);
extract($row12_b);

$cashier2=substr($cashier,0,-2);
$manager2=substr($manager,0,-2);
$accountant_comment_name2=substr($accountant_comment_name,0,-2);







//if($over_short_amount==''){$over_short_amount='0';}
//echo "over_short_amount=$over_short_amount<br />";





echo "<div class='column2of4'>";


if($cashier_overshort_comment != '')
{

echo "<table width='600' border=1>";
echo "<tr>";
echo "<td width='300'>";
echo "<font color='red'>Cashier Comment</font><font color='green'>&nbsp;&nbsp;($cashier2)</font><br /><br />$cashier_overshort_comment";
echo "</td>";

echo "<td width='300'>";
echo "<font color='red'>Manager Comment</font><font color='green'>&nbsp;&nbsp;($manager2)</font><br /><br />$manager_overshort_comment";
echo "</td>";

if($accountant_comment != '')
{
echo "<td width='300'>";
echo "<font color='red'>Accountant Comment</font><font color='green'>&nbsp;&nbsp;($accountant_comment_name2)</font><br /><br />$accountant_comment";
echo "</td>";
}
echo "</tr>";
echo "</table>";

echo "<br />";
}



 $query1e="select bank_deposit_date from crs_tdrr_division_deposits
	             where orms_deposit_id='$deposit_id'     ";	

//echo "query1e=$query1e<br />";//exit;		  

$result1e = mysqli_query($connection, $query1e) or die ("Couldn't execute query 1e.  $query1e");
		  
$row1e=mysqli_fetch_array($result1e);

extract($row1e);
$bank_deposit_date2=date('m-d-y', strtotime($bank_deposit_date));	




echo "<table>";
 echo "<tr><th>CRS Deposit $deposit_id</th></tr><th><font color='red' size='5'>Deposit# $controllers_deposit_id on $bank_deposit_date2</font><br /><font color='red'>Collected $revenue_collection_period</font><br /><br /><font color='blue' size='6'>*****Deposit Slip Amount must equal $bank_deposit_total*****</font></th>";  
echo "<tr><td>";
 echo "<img height='500' width='700' src='$document_location'></img>";
 echo "</td>";
 echo "</tr>";
 echo "</table>";
 echo "</div>";
 }



//echo "</div>";
echo "<br />";


//$grand_total=$var_total_credit+$var_total_debit;

//$var_total_credit=number_format($var_total_credit,2);
//$var_total_debit=number_format($var_total_debit,2);
//$grand_total=number_format($grand_total,2);



//while ($row13=mysqli_fetch_array($result13)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row13);
//2 lines below commented out on 2/8/14 TBASS
//$total_amount=number_format($total_amount,2);
//if($total_amount < '0'){$sign="debit";} else {$sign="credit";}
//if($amount < '0'){$sign="credit";} else {$sign="debit";}
//@$rank=$rank+1;
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}}
/*
echo "<tr$t><form> 
            <td colspan='2'>Checks:<select name='checks_included'>
  <option value=''></option>
  <option value='yes'>YES</option>
  <option value='no'>NO</option>
  </select></td><td colspan='3'>Revenue Collection Period:<br /><input type='text' name='collection_period' value='' size='45'><br /><br /></td>
		    <td></td>
		    <td></td>
		    <td></td>          
</tr>";
*/
/*
if($check=='yes'){$yes_selected=' selected';}else{$no_selected=' selected';}
echo "<table>";
echo "<tr$t><form>";
echo "<td colspan='2'><font color='red'>Checks:</font><select name='checks_included'>
  <option value=''></option>
  <option value='yes' $yes_selected>YES</option>
  <option value='no' $no_selected>NO</option>
  </select></td>";
  
 echo "<td colspan='3'><font color='red'>Revenue Collection Period:</font><br /><input type='text' name='collection_period' value='$revenue_collection_period' size='45'><br /><br /></td>        
</tr>";
echo "</form>";
echo "</table>";
*/


//$var_total_credit=number_format($var_total_credit,2);
//$var_total_debit=number_format($var_total_debit,2);

//echo "<br />";
//echo "<br />";
echo "<div id='row2_col_1'; style='clear:both';'float:left';>"; 
//echo "<br /><br />";
//echo "<form>";
if($cashier_count==1)
{
echo "<table>";
echo "<tr><th>Cashier: $cashier_first $cashier_last</th><td>Approved:<input type='checkbox' name='cashier_approved' value='y' >";
echo "<input type='hidden' name='checks' value='$check'>
<input type='hidden' name='orms_deposit_id' value='$deposit_id'>
<input type='hidden' name='rcf_amount' value='$rcf_amount'>
<input type='hidden' name='rcf' value='$rcf'>
<input type='hidden' name='crs_park' value='$crs_park'>
<input type='hidden' name='controllers_next' value='$controllers_next'>";
echo "<input type='submit' name='submit' value='Submit'></tr>";
//echo "<tr><th>Manager: $manager</th><td>Approved:<input type='checkbox' name='manager_approved' value='y'>
echo "</form>";
echo "</div>";
}

if($manager_count==1)
{

$query1c="select cashier from crs_tdrr_division_deposits
          where park='$concession_location' and orms_deposit_id='$deposit_id' ";
		  
		  
//echo "query1c=$query1c<br />";//exit;		  
		  
		  
$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");
		  
$row1c=mysqli_fetch_array($result1c);

extract($row1c);		  
		  
if($cashier)

{  


$query1d="select 
          cash_handling_roles.first_name as 'cashier_first',
		  cash_handling_roles.nick_name as 'cashier_nick',
		  cash_handling_roles.last_name as 'cashier_last'
		  from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$cashier' ";	

//echo "query1d=$query1d<br />";//exit;		  

$result1d = mysqli_query($connection, $query1d) or die ("Couldn't execute query 1d.  $query1d");
		  
$row1d=mysqli_fetch_array($result1d);

extract($row1d);
if($cashier_nick){$cashier_first=$cashier_nick;}	

$query1d="select 
          cash_handling_roles.first_name as 'cashier_first',
		  cash_handling_roles.nick_name as 'cashier_nick',
		  cash_handling_roles.last_name as 'cashier_last'
		  from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$cashier' ";	

//echo "query1d=$query1d<br />";//exit;		  

$result1d = mysqli_query($connection, $query1d) or die ("Couldn't execute query 1d.  $query1d");
		  
$row1d=mysqli_fetch_array($result1d);

extract($row1d);




echo "<form method='post' autocomplete='off' action='crs_deposits_manager_deposit_update.php'>";
// 1/4/2016: Comments required for all PASU's if Over/short is more than $10
//if($beacnum=='60033087')
{

$query12_a="select sum(amount) as 'over_short_amount' from crs_tdrr_division_history_parks
            where deposit_id='$deposit_id'
            and ncas_account='000437995' ";
		 
//echo "query12_a=$query12_a<br />";		 

$result12_a = mysqli_query($connection, $query12_a) or die ("Couldn't execute query 12_a.  $query12_a");

$row12_a=mysqli_fetch_array($result12_a);
extract($row12_a);
if($over_short_amount==''){$over_short_amount='0';}
//echo "over_short_amount=$over_short_amount<br />";


if($over_short_amount <= -10.00 or $over_short_amount >= 10.00)
{



echo "<table border=1 >";
echo "<tr>";
echo "<td>";


echo "<textarea rows='10' cols='55' name='manager_overshort_comment' placeholder='Enter Manager Justification for Over/Short Amount'>$cashier_over_short_comment</textarea>";



echo "</td>";
echo "</tr>";
echo "</table>";
echo "<input type='hidden' name='manager_comment_required' value='y'>";
echo "<br /><br />";
}
}
echo "<table>";
echo "<tr><th>Cashier: $cashier_first $cashier_last</th><td><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td></tr>";




echo "<tr><th>Manager: $manager_first $manager_last</th><td>Approved:<input type='checkbox' name='manager_approved' value='y'>";
//echo "<input type='hidden' name='checks' value='$check'>";
echo "<input type='hidden' name='orms_deposit_id' value='$deposit_id'>";
//echo "<input type='hidden' name='controllers_next' value='$controllers_next'>";
echo "<input type='submit' name='submit' value='Submit'></tr>";
echo "</table>";
echo "</form>";
echo "</div>";
}
}

//echo "fs_approver_count=$fs_approver_count<br />";
if($fs_approver_count==1)
{



$concession_location=$park_fs_approver;


$query1c="select cashier from crs_tdrr_division_deposits
          where park='$concession_location' and orms_deposit_id='$deposit_id' ";
		  
		  
//echo "query1c=$query1c<br />";//exit;		  
		  
		  
$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");
		  
$row1c=mysqli_fetch_array($result1c);

extract($row1c);		  
		  

$query1d="select 
          cash_handling_roles.first_name as 'cashier_first',
		  cash_handling_roles.nick_name as 'cashier_nick',
		  cash_handling_roles.last_name as 'cashier_last'
		  from cash_handling_roles
		  left join crs_tdrr_division_deposits on cash_handling_roles.park=crs_tdrr_division_deposits.park
		  where crs_tdrr_division_deposits.orms_deposit_id='$deposit_id' 
		  and crs_tdrr_division_deposits.cashier=cash_handling_roles.tempid ";	

//echo "query1d=$query1d<br />";//exit;		  

$result1d = mysqli_query($connection, $query1d) or die ("Couldn't execute query 1d.  $query1d");
		  
$row1d=mysqli_fetch_array($result1d);

extract($row1d);
if($cashier_nick){$cashier_first=$cashier_nick;}	


$query1e="select 
          cash_handling_roles.first_name as 'manager_first',
		  cash_handling_roles.nick_name as 'manager_nick',
		  cash_handling_roles.last_name as 'manager_last'
		  from cash_handling_roles
		  left join crs_tdrr_division_deposits on cash_handling_roles.park=crs_tdrr_division_deposits.park
		  where crs_tdrr_division_deposits.orms_deposit_id='$deposit_id' 
		  and crs_tdrr_division_deposits.manager=cash_handling_roles.tempid ";	

//echo "query1e=$query1e<br />";//exit;		  

$result1e = mysqli_query($connection, $query1e) or die ("Couldn't execute query 1e.  $query1e");
		  
$row1e=mysqli_fetch_array($result1e);

extract($row1e);
if($cashier_nick){$cashier_first=$cashier_nick;}



echo "<form method='post' autocomplete='off' action='crs_deposits_fs_approver_deposit_update.php'>";


echo "<table>";
echo "<tr><th>Cashier: $cashier_first $cashier_last</th><td><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td></tr>";

echo "<tr><th>Manager: $manager_first $manager_last</th><td><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td></tr>";


echo "<tr><th>FS Approver: $fs_approver_first $fs_approver_last</th><td>Approved:<input type='checkbox' name='fs_approver_approved' value='y'></td>";
//echo "<input type='hidden' name='checks' value='$check'>";
echo "<input type='hidden' name='orms_deposit_id' value='$deposit_id'>";
//echo "<input type='hidden' name='controllers_next' value='$controllers_next'>";
echo "<td><input type='submit' name='submit' value='Submit'></td></tr>";
echo "</table>";
echo "</form>";
echo "</div>";

}


/*
echo "<tr><td colspan='2'><font color='red'>Prepared by:</font><br /><br />Approved by:<br /><br />Entered by</td><td colspan='3'><input type='text' name='entered_by' value='$crj_prepared_by' size='20'><font color='red'>Phone#</font><input type='text' name='entered_by' value='$phone' size='15'><br /><br /><input type='text' name='approved_by' value='$approved_by' size='20'>Date:<input type='text' name='approved_date' value='$deposit_date_new_header2' size='15'><br /><br /><input type='text' name='entered_by' value='' size='20' readonly='readonly'>Date:______________</td></form>";
*/

/*
echo "<tr><td colspan='2'><font color='red'>Cashier</font><br /><br />Manager</td><td colspan='3'><input type='text' name='entered_by' value='$crj_prepared_by' size='20'><br /><br /><input type='text' name='approved_by' value='' size='20'></td></tr></form>"; 
*/

//$query1="SELECT max(controllers_deposit_id) as 'controllers_max' FROM crs_tdrr_division_deposits where concession_location='$concession_location'";
//echo "query1=$query1";//exit;
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
//$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

//The number of rows returned from the MySQL query.
//$num1=mysqli_num_rows($result1);

// frees the connection to MySQL


////mysql_close();

//$row1=mysqli_fetch_array($result1);
// extract($row1);

 
//echo "<html>";
//echo "<head>";
//echo "<title>Add Record</title>";
//echo "</head>";
//echo "<body bgcolor='#FFF8DC'>";
//echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name</i> </font></H1>";
//echo "<H1 ALIGN=LEFT > <font color='red'><i>Add Record</i></font></H1>";



//echo "</font>";

//echo "</form>";



echo "</body>";
echo "</html>";



?>