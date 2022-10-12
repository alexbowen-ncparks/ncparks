<?php

if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

if($score_change=='y')
{
//echo "<br />tempid=$tempid<br />";
if($new_score=='' or $score_change_comments==''){echo "<table align='left'><tr><td><font size='5' color='brown' class='cartRow'>Data Missing from Form.</font></td></tr><tr><td><font size='5' color='brown' class='cartRow'> <u>NEW Score</u> and <u>Score Change Comments</u> required on Form</font></td></tr><tr><td><font size='5' color='brown' class='cartRow'>Hit Back Key on Browser to Return to Form. Thanks!</font></td></tr></table>"; exit;}
$score_change_name=substr($tempid,0,-2);
$score_change_date=date("Ymd");
$query0="update cash_imprest_count_detail set score='$new_score',score_change_name='$score_change_name',score_change_date='$score_change_date', score_change_comments='$score_change_comments' where id='$score_change_id' ";
//echo "query0=$query0<br /><br />";
//echo "<br />fyear=$fyear<br />";
$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");	


$query0A="SELECT sum(score) as 'score_total',count(id) as 'scorable_records'
from cash_imprest_count_detail
WHERE 1
and park='$park'
and fyear='$fyear'
and valid='y'
";
//echo "query0A=$query0A<br /><br />";
$result0A = mysqli_query($connection, $query0A) or die ("Couldn't execute query 0A.  $query0A");
$row0A=mysqli_fetch_array($result0A);
extract($row0A);

// New "Cummulative Score" for Park after "Single Month" Score changed
//echo "<br />score_total=$score_total<br />";
//echo "<br />scorable_records=$scorable_records<br />";
$score_cummulative=$score_total/$scorable_records;

$score_cummulative=round($score_cummulative);

//echo "<br />score_cummulative=$score_cummulative<br />";

// TABLE=mission_games is the definitive TABLE of "Scorable Tasks" on the Wheelhouse.  mission_games.gid=10 represents the "Cash Imprest Count" Tasks.  ONLY mission_games.active=Y show up on the Wheelhouse
// TABLE=mission_scores keeps a cummulative score for each Park for each "Scorable Task" by Fiscal Year.  To view "cummulative scores" for "Cash Imprest Count" (gid=10) for Fiscal Year 2122 RUN following Query:
// SELECT * FROM `mission_scores` WHERE `gid` = 10 AND `fyear` LIKE '2122' ORDER BY `gid` ASC

$gid='10'; 
// Once the Park receives a NEW Score for a Single Month (12 scores in a Year), the "Cummulative Score" must be Re-Calculated and PASSED to TABLE=mission_scores as follows:

$query0B="update mission_scores set percomp='$score_cummulative' where gid='$gid' and playstation='$park' and fyear='$fyear' ";
//echo "query0B=$query0B<br /><br />";
$result0B = mysqli_query($connection, $query0B) or die ("Couldn't execute query 0B.  $query0B");
//echo "<br />Line 43"; //exit;

}




if($park!=''){$concession_location=$park;}
$query1="SELECT sum(score) as 'score_total'
from cash_imprest_count_detail
WHERE 1
and park='$concession_location'
and fyear='$fyear'
and valid='y'
";
//echo "query1=$query1<br /><br />";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);


$query2="SELECT count(id) as 'score_records'
from cash_imprest_count_detail
WHERE 1
and park='$concession_location'
and fyear='$fyear'
and valid='y'
";

//echo "query2=$query2<br /><br />";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$row2=mysqli_fetch_array($result2);
extract($row2);



$score=$score_total/$score_records;

$score=round($score);


//echo "hello cash_imprest_count2_report.php<br />";
$query1a="select count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	

//echo "query1a=$query1a<br /><br />";		  

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);
//echo "Line 60: cashier_count=$cashier_count<br />";


$query1b="select count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempid' ";	

//echo "query1b=$query1b<br /><br />";		  

$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);
//echo "manager_count=$manager_count<br />";
if($manager_count==1){$pasu_role='y';}

if($pasu_comment != '')
{
$pasu_comment=addslashes($pasu_comment);
$pasu_comment_query="update cash_imprest_count_detail set manager_comment='$pasu_comment',manager_comment_name='$tempID',manager_comment_date='$system_entry_date' where id='$comment_id' ";

$result_pasu_comment_query=mysqli_query($connection, $pasu_comment_query) or die ("Couldn't execute query pasu comment query. $pasu_comment_query");


//echo "comment_update_query=$comment_update_query<br />";
}


if($fs_comment != '')
{
$fs_comment=addslashes($fs_comment);
$fs_comment_query="update cash_imprest_count_detail set fs_comment='$fs_comment',fs_comment_name='$tempID',fs_comment_date='$system_entry_date' where id='$comment_id' ";

$result_fs_comment_query=mysqli_query($connection, $fs_comment_query) or die ("Couldn't execute query fs comment query. $fs_comment_query");


//echo "comment_update_query=$comment_update_query<br />";
}




$query11="SELECT park,center,fyear,cash_month,cash_month_number,cash_month_calyear,cashier,cashier_amount,cashier_date,manager,manager_amount,manager_date,manager_comment,manager_comment_name,manager_comment_date,player_match,score,authorized_match,authorized_amount,valid,fs_comment,fs_comment_name,fs_comment_date,fs_override,score_change_comments,id
from cash_imprest_count_detail
WHERE 1
and park='$parkcode'
and fyear='$fyear'
and valid='y'
order by cash_month_number desc ";

if($beacnum=='60032793')
{
//echo "query11=$query11<br /><br />";
}

 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		
//echo "query11=$query11<br />";

/*
$start_date2=date('m-d-y', strtotime($start_date));
$end_date2=date('m-d-y', strtotime($end_date));

$start_date_dow=date('l',strtotime($start_date));
$end_date_dow=date('l',strtotime($end_date));
*/
echo "<table><tr><th align='center' colspan='2'><font size='5' color='brown' ><b>Score<br /> $score</b></font></th></tr></table><br />";
echo "<table>";

echo 

"<tr> 
       <th align=left><font color=brown>Park</font></th>
       <th align=left><font color=brown>Center</font></th>       
       <th align=left><font color=brown>Month</font></th>
       <th align=left><font color=brown>Cashier<br />Count</font></th>
	   <th align=left><font color=brown>PASU<br />Count</font></th>
	   <th align=left><font color=brown>Park<br />Match</font></th>
	   <th align=left><font color=brown>Authorized<br />Match</font></th>
	   <th align=left><font color=brown>BUOF<br />Comments</font></th>";
	   //echo "<th align=left><font color=brown>BUOF<br />Verify</font></th>";
	   echo "<th align=left><font color=brown>Score</font></th>";
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
$manager_comment_name3=substr($manager_comment_name,0,-2);
$fs_comment_name3=substr($fs_comment_name,0,-2);
$fs_approver3=substr($fs_approver,0,-2);
$manager_comment_date_dow=date('l',strtotime($manager_comment_date));
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


if($fs_approver_date=='0000-00-00')
{$fs_approver_date_dow='';}
else
{$fs_approver_date_dow=date('l',strtotime($fs_approver_date));}



$cashier_date2=date('m-d-y', strtotime($cashier_date));
$manager_date2=date('m-d-y', strtotime($manager_date));
$manager_comment_date2=date('m-d-y', strtotime($manager_comment_date));
$fs_comment_date2=date('m-d-y', strtotime($fs_comment_date));
$fs_approver_date2=date('m-d-y', strtotime($fs_approver_date));



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
		   echo "<td bgcolor='lightpink'><a href='cash_count_cashier.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear' >Update</a></td>";
		   }  
		   //if 1)TABLE cash_imprest_count_detail.cashier is blank and 2)tempid is not a Cashier in cash_handling_roles.role
		   if($cashier=='' and $cashier_count != 1)
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }
		   if($cashier != '')
		   {
		   echo "<td bgcolor='lightgreen'>Total Count=$cashier_amount<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		   
		   // $cashier_count==1 gets the magnify glass to edit
		   if($cashier_count==1)
		   {
		   echo "<a href='cash_count_cashier.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear&cash_month_number=$cash_month_number'><img height='25' width='25' src='/budget/infotrack/icon_photos/magnify.png' alt='picture of green check mark'></img></a>";
		   }
		   echo "<br />$cashier3<br />$cashier_date2<br />$cashier_date_dow</td>";	
	       }
		   /*
		   echo "<td>$controllers_deposit_id<br /><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' '>Update</a></td>";
		   */
		  
		   
		      
		   //Manager Count has 3 possible outcomes 
		   if($manager=='' and $pasu_role == 'y')//(manager_count == 1)
			{		   
		   echo "<td bgcolor='lightpink'><a href='cash_count_cashier.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear' >Update</a></td>";
		   } 
		   
		   if($manager=='' and $pasu_role == 'n')
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }

		  		   
		   
		   
		   if($manager != '')
		   {
		  echo "<td bgcolor='lightgreen'>Total Count=$manager_amount<br /><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		  
		  if($manager_count==1)
		   {
		   echo "<a href='cash_count_cashier.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear'><img height='25' width='25' src='/budget/infotrack/icon_photos/magnify.png' alt='picture of green check mark'></img></a>";
		   }
		  
		  echo "<br />$manager3<br />$manager_date2<br />$manager_date_dow</td>";
	       }
		   
		   
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
	  
	      if($score=='0')
		  {
           echo "<td bgcolor='lightpink'>$score</td>";
		   }
		   else
		   {
		    echo "<td bgcolor='lightgreen'>$score</td>";		   
		   }
		   
		   // Accounting Specialist (Bass),  Budget Officer (Dodd)
		   if($beacnum=='60032793' or $beacnum=='60032781')
		   {
			  if($score_edit==''){echo "<td><a href='cash_imprest_count2.php?fyear=$fyear&park=$park&score_edit=y'>Edit</td>";}
			  if($score_edit=='y')
			  {
			  echo "<td>";
			  echo "<form action='cash_imprest_count2.php' method='post'><table><tr><td>SCORE CHANGE</td></tr><tr><td><input type='text' name='new_score' placeholder='New Score' size='6' value='$new_score'></td></tr><tr><td><textarea name='score_change_comments' rows='4' cols='50' placeholder='Score Change Comments'>$score_change_comments</textarea></td>";
		  
		 
				  echo "<tr><td>";
				   echo "<input type='hidden' name='score_change_id' value='$id'>";
				   echo "<input type='hidden' name='score_change' value='y'>";
				   echo "<input type='hidden' name='fyear' value='$fyear'>";
				   echo "<input type='hidden' name='park' value='$park'>";
				   echo "<br /><input type='submit' name='submit'>";
				   echo "</form>";
				   echo "</td></tr>";
				   echo "</td>";
	   
	   
			  }
	   
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