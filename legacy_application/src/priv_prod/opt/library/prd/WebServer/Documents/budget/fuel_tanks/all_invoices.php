<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}


$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
extract($_REQUEST);

$scid=$id;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//$project_category='ITS';
//$project_name='wex_bill';
//$step_group='B';


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
echo "<html>";
echo "<head>";
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


$query1="SELECT highlight_color from infotrack_customformat
         where user_id='$tempid' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);


//include("../../budget/menu1314.php");

include ("../../budget/menu1415_v1.php");

//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";
echo "<br />";


if($park!=''){$parkcode=$park;}
if($park==''){$parkcode=$concession_location;}
$query2="select center_desc,center from center where parkcode='$parkcode'   ";	

//echo "query2=$query2<br />";//exit;		  

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysqli_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);



/*
echo "<table align='center'>";
echo "<tr>";




echo "</tr>";
echo "</table>";




//echo "<html>";

echo "<head>";

echo "</head>";
*/

if($report_type=='form'){$report_form="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($report_type=='reports'){$report_reports="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

echo "<style>
td {
    padding: 10px;
}

th {
    padding: 10px;
}



</style>";


/*
echo "<br /><table align='center' border='1' align='left'><tr><th><font color='brown'>Service Contract<br />Invoices</font></th><th><a href='payment_form.php?fyear=$fyear&report_type=form&id=$id'>Payment Form</a><br />$report_form</th><th><a href='payment_history.php?fyear=$fyear&report_type=reports&id=$id'>Payment History</a><br />$report_reports </th></tr></table>";
*/


echo "<br /><table border='1' align='center'><tr><th><a href='/budget/service_contracts/service_contracts.php'><img height='75' width='75' src='dumpster1.jpg' alt='picture of fuel tank'></img></a><font color='brown'><b>Park Service Contract</font></th><th><a href='payment_form.php?fyear=$fyear&report_type=form&id=$id'>Pay Invoice</a><br />$report_form</th><th><a href='all_invoices.php?fyear=$fyear&report_type=reports&id=$id'>DNCR Forms</a><br />$report_reports </th></tr></table>";
echo "<br />";

//if($park!=''){$concession_location=$park;}
$concession_location='momo';
$parkcode='momo';
$query1="SELECT sum(score) as 'score_total'
from fuel_tank_usage
WHERE 1
and park='$concession_location'
and fyear='$fyear'
and valid='y'
";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);


$query2="SELECT count(id) as 'score_records'
from fuel_tank_usage
WHERE 1
and park='$concession_location'
and fyear='$fyear'
and valid='y'
";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$row2=mysqli_fetch_array($result2);
extract($row2);



$score=$score_total/$score_records;

$score=round($score);









//echo "hello cash_imprest_count2_report.php<br />";
$query1a="select count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	 

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);
//if($tempid=='McGrath9695'){echo "cashier_count=$cashier_count<br />";}


$query1b="select count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempid' ";	 

$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);
echo "cashier_count=$cashier_count<br />";
echo "manager_count=$manager_count<br />";


if($pasu_comment != '')
{
$pasu_comment=addslashes($pasu_comment);
$pasu_comment_query="update fuel_tank_usage set manager_comment='$pasu_comment',manager_comment_name='$tempID',manager_comment_date='$system_entry_date' where id='$comment_id' ";

$result_pasu_comment_query=mysqli_query($connection, $pasu_comment_query) or die ("Couldn't execute query pasu comment query. $pasu_comment_query");


//echo "comment_update_query=$comment_update_query<br />";
}


if($fs_comment != '')
{
$fs_comment=addslashes($fs_comment);
$fs_comment_query="update fuel_tank_usage set fs_comment='$fs_comment',fs_comment_name='$tempID',fs_comment_date='$system_entry_date' where id='$comment_id' ";

$result_fs_comment_query=mysqli_query($connection, $fs_comment_query) or die ("Couldn't execute query fs comment query. $fs_comment_query");


//echo "comment_update_query=$comment_update_query<br />";
}



/*
$query11="SELECT park,center,fyear,cash_month,cash_month_number,cash_month_calyear,cashier,cashier_amount,cashier_date,manager,manager_date,score,valid,id,(sum(reimbursement_gallons*reimbursement_rate)+sum(reimbursement_gallons*.12)) as 'refund_total' 
from fuel_tank_usage
WHERE 1
and park='$parkcode'
and fyear='$fyear'
and valid='y'
group by id
order by cash_month_number desc ";
*/

//echo "query11=$query11<br />";


$query11="SELECT park,center,invoice_num,invoice_date,service_period,cashier,cashier_date,manager,manager_date,sum(invoice_amount) as 'current_amount',sum(previous_amount_paid) as 'previous_amount',sum(line_num_beg_bal-previous_amount_paid) as 'avail_before_invoice' 
from service_contracts_invoices
WHERE 1
and scid='$scid'
group by id
order by invoice_date desc ";



 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		
echo "query11=$query11<br />";

/*
$start_date2=date('m-d-y', strtotime($start_date));
$end_date2=date('m-d-y', strtotime($end_date));

$start_date_dow=date('l',strtotime($start_date));
$end_date_dow=date('l',strtotime($end_date));
*/

echo "<table align='center'><tr><th align='center' colspan='2'><font size='5' color='brown' ><b>Score: &nbsp;&nbsp; $score</b></font></th></tr></table><br />";
echo "<table align='center'>";

echo 

"<tr>"; 
       echo "<th align=left><font color=brown>Park</font></th>";
       //echo "<th align=left><font color=brown>Center</font></th>";  
	 echo "<th align=left><font color=brown>Available<br />before<br />Invoice</font></th>";
	 /*
     echo "<th align=left><font color=brown>Invoice Amount<br />Invoice#<br />Invoice Date<br />Service Period</font></th>";
*/	

       echo "<th align=left><font color=brown>Invoice</font></th>";
	 echo "<th align=left><font color=brown>Available<br />After<br />Invoice</font></th>";
	   
	  
	   
	   
	   
	   //echo "<th align=left><font color=brown>Current Amount</font></th>";
	   //echo "<th align=left><font color=brown>Total Paid</font></th>";
	   echo "<th align=left><font color=brown>Cashier</font></th>
	   <th align=left><font color=brown>PASU</font></th>";
	   /*
	   echo "<th align=left><font color=brown>Park<br />Match</font></th>
	   <th align=left><font color=brown>Authorized<br />Match</font></th>
	   <th align=left><font color=brown>BUOF<br />Comments</font></th>";
	   */
	   //echo "<th align=left><font color=brown>BUOF<br />Verify</font></th>";
	   echo "<th align=left><font color=brown>DNCR Form</font></th>";
	//echo "<th align=left><font color=brown>Cash<br />Receipts<br />Journal</font></th>";
	   
       
      
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);
//$park_oob=$cashier_amount-$manager_amount;
$cashier3=substr($cashier,0,-2);
$manager3=substr($manager,0,-2);
$avail_before_invoice2=number_format($avail_before_invoice,2);
$avail_after_invoice=$avail_before_invoice-$current_amount;
$avail_after_invoice2=number_format($avail_after_invoice,2);
$total_amount=$previous_amount+$current_amount;
$previous_amount=number_format($previous_amount,2);
$current_amount=number_format($current_amount,2);
$total_amount=number_format($total_amount,2);
//$manager_comment_name3=substr($manager_comment_name,0,-2);
//$fs_comment_name3=substr($fs_comment_name,0,-2);
//$fs_approver3=substr($fs_approver,0,-2);
//$manager_comment_date_dow=date('l',strtotime($manager_comment_date));
/*
if($deposit_date == '0000-00-00')
{
$deposit_date2='';
}
else
{
$deposit_date2=date('m-d-y', strtotime($deposit_date));
}
//$deposit_date=date('m-d-y', strtotime($deposit_date));
//$deposit_date=date('m-d-y', strtotime($deposit_date));



if($deposit_date=='0000-00-00')
{$deposit_date_dow='';}
else
{$deposit_date_dow=date('l',strtotime($deposit_date));}
*/
if($cashier_date=='0000-00-00')
{$cashier_date_dow='';}
else
{$cashier_date_dow=date('l',strtotime($cashier_date));}


if($manager_date=='0000-00-00')
{$manager_date_dow='';}
else
{$manager_date_dow=date('l',strtotime($manager_date));}

/*
if($fs_approver_date=='0000-00-00')
{$fs_approver_date_dow='';}
else
{$fs_approver_date_dow=date('l',strtotime($fs_approver_date));}

*/

$cashier_date2=date('m-d-y', strtotime($cashier_date));
$manager_date2=date('m-d-y', strtotime($manager_date));
$invoice_date2=date('m-d-y', strtotime($invoice_date));
//$manager_comment_date2=date('m-d-y', strtotime($manager_comment_date));
//$fs_comment_date2=date('m-d-y', strtotime($fs_comment_date));
//$fs_approver_date2=date('m-d-y', strtotime($fs_approver_date));

/*
echo "cashier=$cashier<br />";
echo "cashier_count=$cashier_count<br />";
echo "manager=$manager<br />";
echo "manager_count=$manager_count<br />";
*/



//$dow=date("1",$timestamp);
//$deposit_date=date('m-d-y', strtotime($deposit_date));
//$deposit_id2 = substr($deposit_id, 0, 8);
//$deposit_idL8 = substr($deposit_id, -8, 8);
//if($deposit_idL8=="GiftCard"){$GC='y';}else{$GC='n';}
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($record_complete == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}
echo 

"<tr$t>";
		   echo "<td bgcolor='lightgreen'>$parkcode<br />$center</td>";  
		   //echo "<td bgcolor='lightgreen'>$center</td>";
		   echo "<td bgcolor='lightgreen'>$avail_before_invoice2</td>";
		   //echo "<td bgcolor='lightgreen'>$service_period<br />$invoice_num<br />$invoice_date2<br />$current_amount</td>";
		   echo "<td bgcolor='lightgreen'><font color='brown'>Amount: $current_amount</font><br />Number: $invoice_num<br />Date: $invoice_date2<br /><font color='brown'>Period: $service_period</font></td>";
			echo "<td bgcolor='lightgreen'>$avail_after_invoice2</td>";
			//echo "<td bgcolor='lightgreen'>$current_amount</td>";
			//echo "<td bgcolor='lightgreen'>$total_amount</td>";
			
		    //echo "<td>$deposit_date2<br />$deposit_date_dow</td>";
		    //echo "<td>$bank_deposit_date2<br /></td>";
			
			// changed on 09/15/14
		/*
			if($cashier=='')
			{
		   echo "<td bgcolor='lightpink'><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' >Cashier<br />Update</a></td>";
		   }
		 */ 
		   
		   //Cashier Count has 3 possible outcomes 
		   if($cashier=='' and $cashier_count==1)
			{
		   echo "<td bgcolor='lightpink'><a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear' >Cashier<br />Update</a></td>";
		   }  
		   //if 1)TABLE fuel_tank_usage.cashier is blank and 2)tempid is not a Cashier in cash_handling_roles.role
		   if($cashier=='' and $cashier_count != 1)
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }
		   if($cashier != '')
		   {
		   /*
		   echo "<td bgcolor='lightgreen'>Park Refund=$refund_total<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		   */
		   
		   echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		   
		   // $cashier_count==1 gets the magnify glass to edit
		   /*
		   if($cashier_count==1)
		   {
		   
		   echo "<a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&cash_month_number=$cash_month_number&step=3'><img height='25' width='25' src='/budget/infotrack/icon_photos/magnify.png' alt='picture of green check mark'></img></a>";
		   }
		   */
		   echo "<br />$cashier3<br />$cashier_date2<br />$cashier_date_dow</td>";	
	       }
		   /*
		   echo "<td>$controllers_deposit_id<br /><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' '>Update</a></td>";
		   */
		  
		   
		      
		   //Manager Count has 3 possible outcomes 
		   if($manager=='' and $manager_count==1)//(manager_count == 1)
			{		   
		   echo "<td bgcolor='lightpink'><a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&step=4' >PASU<br />Update</a></td>";
		   } 
		   
		   if($manager=='' and $manager_count != 1)
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }

		  		   
		   
		   
		   if($manager != '')
		   {
		  echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		  
		 
		  
		  echo "<br />$manager3<br />$manager_date2<br />$manager_date_dow</td>";
	       }
		   
		   /*
		   if($player_match=='n' and $cashier != '' and $manager != '')
		   {
		   echo "<td bgcolor='lightpink'>Park Counts <br />do not match<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of green check mark'></img></td>";
		   
		   }
		
		   if($player_match=='n' and ($cashier == '' or $manager == ''))
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }

	
		   if($player_match=='y')
		   {
		   echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td>";
		   
		   }
		   
		 
		    if($authorized_match=='n' and $cashier != '' and $manager != '' and $player_match=='y' and $fs_override=='n')
		   {
		    echo "<td bgcolor='lightpink'>Authorized Cash=$authorized_amount<br />Park Count does not match<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of green check mark'></img><br />";
			if($manager_comment != ''){echo "$manager_comment_name3 Comment on $manager_comment_date2<br />";}
			echo "<form action='cash_imprest_count2.php' name='pasu_form'><textarea rows='11' cols='35' name='pasu_comment' placeholder='Enter Manager  Justification for Cash Count discrepancy. Then click PASU_Update'>$manager_comment</textarea><br /><input type='hidden' name='parkcode' value='$park'><input type='hidden' name='comment_id' value='$id'>";
			
		   if($manager_count==1)
		   {
		   echo "<br /><input type=submit name=submit value=PASU_Update>";
		   }
			echo "</form>";
			echo "</td>";
		   
		   } 
		   
		   elseif($authorized_match=='n' and $cashier != '' and $manager != '' and $player_match=='y' and $fs_override=='y')
		   {
		    echo "<td bgcolor='lightgreen'>Authorized Cash=$authorized_amount<br />Park Count does not match<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of green check mark'></img><br />";
			if($manager_comment != ''){echo "$manager_comment_name3 Comment on $manager_comment_date2<br />";}
			echo "<form action='cash_imprest_count2.php' name='pasu_form'><textarea rows='11' cols='35' name='pasu_comment' placeholder='Enter Manager  Justification for Cash Count discrepancy. Then click PASU_Update'>$manager_comment</textarea><br /><input type='hidden' name='parkcode' value='$park'><input type='hidden' name='comment_id' value='$id'>";
			
		   if($manager_count==1)
		   {
		   echo "<br /><input type=submit name=submit value=PASU_Update>";
		   }
			echo "</form>";
			echo "</td>";
		   
		   } 	   
		   
		   
		   
		   elseif($authorized_match=='n' and $cashier != '' and $manager != '' and $player_match=='n')
		   {
		   echo "<td bgcolor='lightpink'></td>";			   
		   }	
		   
		  elseif($authorized_match=='n' and ($cashier == '' or $manager == ''))
		   {
		   echo "<td bgcolor='lightpink'></td>";		   
		   }	 

		   elseif($authorized_match=='y' )
		   {
		   echo "<td bgcolor='lightgreen'>Authorized Cash=$authorized_amount<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></td>";
		   
		   }
		   /*
		   echo "<td>";
		   
		   if($cashier_amount !='0.00' and $manager_amount != '0.00' and $authorized_match=='n' and $manager_comment=='')
		   {echo "<form action='cash_imprest_count2.php'><textarea rows='7' cols='20' name='pasu_comment' placeholder='Enter Manager  Justification for Cash Count discrepancy. Then click PASU_Update'>$manager_comment</textarea><br /><input type='hidden' name='parkcode' value='$park'><input type='hidden' name='comment_id' value='$id'>";
		   if($manager_count==1)
		   {
		   echo "<input type=submit name=submit value=PASU_Update></form>";
		   }
		   }
		   
		   if($cashier_amount !='0.00' and $manager_amount != '0.00' and $authorized_match=='n' and $manager_comment!='')
		   {echo "Authorized Amount=$authorized_amount<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$manager_comment_name3";echo "<br />$manager_comment_date2<br />$manager_comment_date_dow<br /><br />$manager_comment";}	  

			
		   echo "</td>"; 
		   */
		   
      /*
		   if($fs_approver=='')
			{		   
		   echo "<td bgcolor='lightpink'><a href='cash_count_cashier'>Update</a></td>";	
            }
			else
			{		   
		   echo "<td bgcolor='lightgreen'>$fs_approver_date<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$fs_approver3<br />$fs_approver_date2<br />$fs_approver_date_dow</td>";
		   }
      */   
	  
	  	     
	  
	  /*
	  
	  
	    if($authorized_match=='n' and $cashier != '' and $manager != '' and $player_match=='y' and $fs_override=='n')
		   {
		    echo "<td bgcolor='lightpink'>Authorized Cash=$authorized_amount<br />Park Count does not match<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of green check mark'></img><br />";
			if($fs_comment != ''){echo "$fs_comment_name3 Comment on $fs_comment_date2<br />";}
			echo "<form action='cash_imprest_count2.php' name='buof_form'><textarea rows='11' cols='35' name='fs_comment' placeholder='Enter BUOF Comment. Then click BUOF_Update'>$fs_comment</textarea><br /><input type='hidden' name='park' value='$park'><input type='hidden' name='comment_id' value='$id'>";
			
			
		  if($beacnum=='60032793' or $beacnum=='60036015' or $beacnum=='60032781')
		   {
		   echo "<br /><input type=submit name=submit value=BUOF_Update>";
		   }
			echo "</form>";
			echo "</td>";
		   
		   } 
		   
		   elseif($authorized_match=='n' and $cashier != '' and $manager != '' and $player_match=='y' and $fs_override=='y')
		   {
		    echo "<td bgcolor='lightgreen'>Authorized Cash=$authorized_amount<br />Park Count does not match<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of green check mark'></img><br />";
			if($fs_comment != ''){echo "$fs_comment_name3 Comment on $fs_comment_date2<br />";}
			echo "<form action='cash_imprest_count2.php' name='buof_form'><textarea rows='11' cols='35' name='fs_comment' placeholder='Enter BUOF Comment. Then click BUOF_Update'>$fs_comment</textarea><br /><input type='hidden' name='park' value='$park'><input type='hidden' name='comment_id' value='$id'>";
			
			
		  if($beacnum=='60032793' or $beacnum=='60036015' or $beacnum=='60032781')
		   {
		   echo "<br /><input type=submit name=submit value=BUOF_Update>";
		   }
			echo "</form>";
			echo "</td>";
		   
		   } 
		   
		   
	       else
		   {
		   echo "<td bgcolor='lightgreen'></td>";
	       }
	  */
	  
	  /*
	      if($score=='0')
		  {
           echo "<td bgcolor='lightpink'>$score</td>";
		   }
		   else
		   {
		    echo "<td bgcolor='lightgreen'>$score</td>";		   
		   }
		   
		   */
		   
		  echo "<td><a href='page2_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&step=4'>View</a></td>";
           // changed on 09/15/14
		  /* 
           if($fs_approver=='')
			{		   		   
		   echo "<td bgcolor='lightpink'>$controllers_deposit_id<br /><a href='crs_deposits_crj_reports_final.php?deposit_id=$deposit_id&GC=$GC' target='_blank'>View</a></td>";
		   }
		   else
		   {		   		   
		   echo "<td bgcolor='lightgreen'>$controllers_deposit_id<br /><a href='crs_deposits_crj_reports_final.php?deposit_id=$deposit_id&GC=$GC' target='_blank'>View</a></td>";
		   }
          
             */ 
		 
			  
			  
			  
			  
			  
			  
           
echo "</tr>";




}

 echo "</table>";






echo "</body></html>";

?>

























