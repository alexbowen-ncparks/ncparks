<?php

//if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$system_entry_date=date("Ymd");
$system_entry_date2=date('m-d-y', strtotime($system_entry_date));
$system_entry_date_dow=date('l',strtotime($system_entry_date));
//if($tempID=='McGrath9695'){echo "hello $posTitle Nora Coffey";} else {echo "hello world";}


//if($tempID=='Robinson8024' and $concession_location=='STMO'){$posTitle='park superintendent';}
if($tempID=='Church9564' and $concession_location=='LANO'){$posTitle='park superintendent';}
//if($tempID=='Crider2443' and $concession_location=='GOCR'){$posTitle='park superintendent';}
if($tempID=='Rogers2949' and $concession_location=='PETT'){$posTitle='park superintendent';}
if($tempID=='Newsome1830' and $concession_location=='MEMO'){$posTitle='park superintendent';}
if($tempID=='Kendrick3113' and $concession_location=='HABE'){$posTitle='park superintendent';}
if($tempID=='Murr7025' and $concession_location=='MOMO'){$posTitle='park superintendent';}


//echo "$tempID=$posTitle=$concession_location";
if($posTitle=='park superintendent'){$pasu_role='y';} else {$pasu_role='n';}
/*
if($posTitle=='park superintendent'){echo "<font color='brown'><b>hello park superintendent</b></font>";}
*/

if($posTitle=='park superintendent'){$pasu_role='y';}
$menu='pci';

extract($_REQUEST);
if($beacnum=='60032793')
{
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
}
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

//if(@$f_year==""){include("../~f_year.php");}
//echo "f_year=$f_year";


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
//echo "concession_location=$concession_location<br />";
//echo "park=$park<br />";
if($park != ''){$concession_location=$park;}
$query1b="select count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempID' ";	 

$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);
//echo "query1b=$query1b<br />";
//echo "manager_count=$manager_count<br />";

if($manager_count==1){$pasu_role='y';}


include ("../../budget/menu1415_v1.php");
echo "<br />";


if($park!=''){$parkcode=$park;}
if($park==''){$parkcode=$concession_location;}


//include ("concessions_main_menu.php");
include ("concessions_pci_menu.php");

//include("concessions1_instructions.php");
include("concessions_pci_instructions.php");

echo "<br />";
/*
echo "<table align='center'><tr><td><font color='red' size='6'>PCI Compliance Under Construction (Target Date:  June 1, 2017)</td></tr></table><br />";
*/
//echo "<br />";
//include ("concessions1_fyear.php");
include ("concessions_pci_fyear.php");
echo "<br />";

//Rescore by Budget Office. Update TABLE=concessions_pci_compliance
if($submit=='Update_Score')
{
//echo "<br />tempid=$tempid<br />";
//echo "<br />tempID=$tempID<br />";
//echo "<br />system_entry_date=$system_entry_date<br />";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;	
if($new_score=='' or $rescore_comments==''){echo "<table align='center'><tr><th><font size='5' color='red'>Oops! Form not complete.</font><br /> Hit back key on browser. Thanks</th></tr></table>"; exit;}
$query0="update concessions_pci_compliance set score='$new_score',rescore_comments='$rescore_comments',rescore_tempid='$tempID',rescore_date='$system_entry_date' where id='$idS' ";	
//echo "<br />query0=$query0<br />";
$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");	

}

if($park!=''){$concession_location=$park;}
$query1="SELECT sum(score) as 'score_total'
from concessions_pci_compliance
WHERE 1
and park='$concession_location'
and fyear='$fyear'
and valid='y'
";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);


$query2="SELECT count(id) as 'score_records'
from concessions_pci_compliance
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

//Rescore by Budget Office. Update TABLE=mission_scores
if($submit=='Update_Score')
{
//echo "<br />tempid=$tempid<br />";
//echo "<br />tempID=$tempID<br />";
//echo "<br />system_entry_date=$system_entry_date<br />";
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;	
$query0a="update mission_scores set percomp='$score' where gid='16' and fyear='$fyear' and playstation='$park' ";	
//echo "<br />query0a=$query0a<br />";
$result0a = mysqli_query($connection, $query0a) or die ("Couldn't execute query 0a.  $query0a");	

}







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
//echo "manager_count=$manager_count<br />";


if($pasu_comment != '')
{
$pasu_comment=addslashes($pasu_comment);
$pasu_comment_query="update concessions_pci_compliance set manager_comment='$pasu_comment',manager_comment_name='$tempID',manager_comment_date='$system_entry_date' where id='$comment_id' ";

$result_pasu_comment_query=mysqli_query($connection, $pasu_comment_query) or die ("Couldn't execute query pasu comment query. $pasu_comment_query");


//echo "comment_update_query=$comment_update_query<br />";
}


if($fs_comment != '')
{
$fs_comment=addslashes($fs_comment);
$fs_comment_query="update concessions_pci_compliance set fs_comment='$fs_comment',fs_comment_name='$tempID',fs_comment_date='$system_entry_date' where id='$comment_id' ";

$result_fs_comment_query=mysqli_query($connection, $fs_comment_query) or die ("Couldn't execute query fs comment query. $fs_comment_query");


//echo "comment_update_query=$comment_update_query<br />";
}




$query11="SELECT id,rescore_comments,rescore_tempid,rescore_date,park,center,fyear,cash_month,cash_month_number,cash_month_calyear,cashier,cashier_amount,cashier_date,manager,manager_date,score,valid,id,(sum(reimbursement_gallons*reimbursement_rate)+sum(reimbursement_gallons*.12)) as 'refund_total' 
from concessions_pci_compliance
WHERE 1
and park='$parkcode'
and fyear='$fyear'
and valid='y'
group by id
order by cash_month_number desc ";

//echo "query11=$query11<br />";

 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		
//echo "query11=$query11<br />";

/*
$start_date2=date('m-d-y', strtotime($start_date));
$end_date2=date('m-d-y', strtotime($end_date));

$start_date_dow=date('l',strtotime($start_date));
$end_date_dow=date('l',strtotime($end_date));
*/
echo "<table align='center'><tr><th align='center' colspan='2'><font size='5' color='brown' ><b>Score: &nbsp;&nbsp; $score</b></font></th></tr></table><br />";
if($beacnum=='60032781' or $beacnum=='60032793'){echo "<table align='center'><tr><td><a href='concessions_pci_report.php?fyear=$fyear&park=$park&bo_edit=yes'>EDIT Score (Budget only)</a></td></tr></table>";}

echo "<table align='center'>";

echo 

"<tr> 
       <th align=left><font color=brown>Park</font></th>
       <th align=left><font color=brown>Center</font></th>       
       <th align=left><font color=brown>Month</font></th>
       <th align=left><font color=brown>Cashier</font></th>
	   <th align=left><font color=brown>Manager</font></th>";
	   /*
	   echo "<th align=left><font color=brown>Park<br />Match</font></th>
	   <th align=left><font color=brown>Authorized<br />Match</font></th>
	   <th align=left><font color=brown>BUOF<br />Comments</font></th>";
	   */
	   //echo "<th align=left><font color=brown>BUOF<br />Verify</font></th>";
	   echo "<th align=left><font color=brown>Score</font></th>";
	   echo "<th align=left><font color=brown>Document</font></th>";
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
$refund_total=number_format($refund_total,2);
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

"<tr$t>
		   	<td bgcolor='lightgreen'>$parkcode</td>  
		    <td bgcolor='lightgreen'>$center</td>
		    <td bgcolor='lightgreen'>$cash_month</td>";
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
		   echo "<td bgcolor='lightpink'><a href='concessions_pci_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear' >Cashier<br />Update</a></td>";
		   }  
		   //if 1)TABLE concessions_pci_compliance.cashier is blank and 2)tempid is not a Cashier in cash_handling_roles.role
		   if($cashier=='' and $cashier_count != 1)
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }
		   if($cashier != '')
		   {
		   echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		   
		   // $cashier_count==1 gets the magnify glass to edit
		   if($cashier_count==1)
		   {
		   echo "<a href='concessions_pci_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&cash_month_number=$cash_month_number&step=3'><img height='25' width='25' src='/budget/infotrack/icon_photos/magnify.png' alt='picture of green check mark'></img></a>";
		   }
		   echo "<br />$cashier3<br />$cashier_date2<br />$cashier_date_dow</td>";	
	       }
		   /*
		   echo "<td>$controllers_deposit_id<br /><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' '>Update</a></td>";
		   */
		  
		   
		      
		   //Manager Count has 3 possible outcomes 
		   if($manager=='' and $pasu_role == 'y' and $cashier != '')//(manager_count == 1)
			{		   
		   echo "<td bgcolor='lightpink'><a href='concessions_pci_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&step=4' >Manager<br />Update</a></td>";
		   } 
		   
		   if($manager=='' and $pasu_role == 'y' and $cashier == '')//(manager_count == 1)
			
		    {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }
		   
		   
		   
		   if($manager=='' and $pasu_role == 'n')
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }

		  		   
		   
		   
		   if($manager != '')
		   {
		  echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		  
		  if($manager_count==1)
		   {
		   echo "<a href='concessions_pci_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&step=4'><img height='25' width='25' src='/budget/infotrack/icon_photos/magnify.png' alt='picture of green check mark'></img></a>";
		   }
		  
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
	      if($score=='0')
		  {
           echo "<td bgcolor='lightpink'>$score</td>";
		   }
		   else
		   {
		    echo "<td bgcolor='lightgreen'>$score</td>";	

		   }
		   
		   
		   
		    if($cashier == '' and $manager == '')
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   }
		   
		   
		   
		    if($cashier != '' and $manager == '')
		   {
		   echo "<td bgcolor='lightpink'><a href='pci_documents/concessions_pci_compliance_$id.pdf' target='_blank'>View</a></td>";
		   }
		   
		   
		     if($cashier != '' and $manager != '')
		   {
		   echo "<td bgcolor='lightgreen'><a href='pci_documents/concessions_pci_compliance_$id.pdf' target='_blank'>View</a>";
		   
		   if($rescore_tempid != '' and $view_comments != 'y'){echo "<br /><br /><a href='concessions_pci_report.php?fyear=$fyear&park=$park&view_comments=y'>Budget Comments</a>";}
		  
		  if($rescore_tempid != '' and $view_comments=='y')
		  {$rescore_tempid2=substr($rescore_tempid,0,-2);echo "<br /><br /><table><tr><td>$rescore_tempid2<br />$rescore_comments<br />$rescore_date</td></tr></table>";}
		   
		   
		   echo "</td>";
		   }
		  
		  
		  
		  
		  
		  
		  
		  // budget officer (dodd)  accounting specialist (bass)
		 if(($beacnum=='60032781' or $beacnum=='60032793') and ($bo_edit=='yes'))
		 {
		 echo "<td bgcolor=>";
		 echo "<table><tr>";
		 echo "<td>";
		 echo "<form action='concessions_pci_report.php' method='post'>NEW Score<input type='text' name='new_score' value='$new_score' size='3'><br /><br />BO Comments:<textarea rows='4' cols='20' name='rescore_comments'>$rescore_comments</textarea><input type='hidden' name='idS' value='$id'><input type='hidden' name='fyear' value='$fyear'><input type='hidden' name='park' value='$park'><br /><br /><input type='submit' name='submit' value='Update_Score'></form>";
		 echo "</td>";
		 echo "</tr></table>";
		 echo "</td>";	 
			 
		 }
		 
		   
		 
		 
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
 



?>



















	














