<?php

if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

//if($tempID=='Turner2317' and $concession_location=='MEMI'){$posTitle='park superintendent';}
//echo "$tempID=$posTitle=$concession_location";
if($posTitle=='park superintendent'){$pasu_role='y';} else {$pasu_role='n';}

echo "pasu_role=$pasu_role<br />";
//echo "hello cash_imprest_count2_report.php<br />";
$query1a="select count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	

//echo "query1a=$query1a<br /><br />";		  

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);
echo "Line 60: cashier_count=$cashier_count<br />";


$query1b="select count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempid' ";	

//echo "query1b=$query1b<br /><br />";		  

$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);
//echo "manager_count=$manager_count<br />";

/*
if($pasu_comment != '')
{
$pasu_comment=addslashes($pasu_comment);
$pasu_comment_query="update cash_imprest_count_detail set manager_comment='$pasu_comment',manager_comment_name='$tempID',manager_comment_date='$system_entry_date' where id='$comment_id' ";

$result_pasu_comment_query=mysqli_query($connection, $pasu_comment_query) or die ("Couldn't execute query pasu comment query. $pasu_comment_query");

}
*/
/*
if($fs_comment != '')
{
$fs_comment=addslashes($fs_comment);
$fs_comment_query="update cash_imprest_count_detail set fs_comment='$fs_comment',fs_comment_name='$tempID',fs_comment_date='$system_entry_date' where id='$comment_id' ";

$result_fs_comment_query=mysqli_query($connection, $fs_comment_query) or die ("Couldn't execute query fs comment query. $fs_comment_query");
}
*/


if($beacnum=='60032997')
{
$query11="SELECT * from pcard_users
WHERE 1
and act_id='p' 
and manager != ''
order by admin ";	
}
else
{
$query11="SELECT * from pcard_users
WHERE 1
and admin='$concession_location'
and act_id='p' ";
}
echo "query11=$query11<br /><br />";

 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		
//echo "query11=$query11<br />";

/*
$start_date2=date('m-d-y', strtotime($start_date));
$end_date2=date('m-d-y', strtotime($end_date));

$start_date_dow=date('l',strtotime($start_date));
$end_date_dow=date('l',strtotime($end_date));
*/
//echo "<table><tr><th align='center' colspan='2'><font size='5' color='brown' ><b>Score<br /> $score</b></font></th></tr></table><br />";
echo "<table border='1'>";
echo "<br />student_score=$student_score<br />";
echo 

"<tr>"; 
//if($cashier_count=='1' or $beacnum=='60032997')
if($cashier_count=='1')
       {
       echo "<th></th>";
	   }
       echo "<th align=left><font color=brown>Admin <br />Request#</font></th>
	   <th align=left><font color=brown>Cashier<br />Requestor</font></th>
       <th align=left><font color=brown>Employee Info</font></th>       
       
	   <th align=left><font color=brown>Employee<br />Training Score</font></th>
	   <th align=left><font color=brown>PASU<br />Approver</font></th>
	   
	   <th align=left><font color=brown>BUOF<br />Approver</font></th>
	   <th align=left><font color=brown>Completed<br />DNCR Form</font></th>
	   
	   ";
	   
	   //echo "<th align=left><font color=brown>BUOF<br />Verify</font></th>";
	  // echo "<th align=left><font color=brown>Score</font></th>";
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
$student_id=substr($student_id,0,-2);
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
$student_test_date=date('m-d-y', strtotime($student_test_date));
$manager_date2=date('m-d-y', strtotime($manager_date));
$manager_comment_date2=date('m-d-y', strtotime($manager_comment_date));
$fs_comment_date2=date('m-d-y', strtotime($fs_comment_date));
$fs_approver_date2=date('m-d-y', strtotime($fs_approver_date));

//if($level>'0'){echo "<td><a href=\"score_hide.php?sid=$sid&pid=$pid\" onClick='return confirmLink()'>Remove</a></td>";}

//$dow=date("1",$timestamp);
//$deposit_date=date('m-d-y', strtotime($deposit_date));
//$deposit_id2 = substr($deposit_id, 0, 8);
//$deposit_idL8 = substr($deposit_id, -8, 8);
//if($deposit_idL8=="GiftCard"){$GC='y';}else{$GC='n';}
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($record_complete == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}
echo "<tr$t>";
if($cashier_count=='1' and $student_score != '100.00')
{
echo "<td bgcolor='lightgreen'><a href=\"pcard_request_delete_rec.php?id=$id\" onClick='return confirmLink()'><img height='25' width='25' src='/budget/infotrack/icon_photos/mission_icon_photos_218.png' alt='picture of trash can' title='Delete Record'></img></a></td>";
}
if($cashier_count=='1' and $student_score == '100.00')
{
echo "<td bgcolor='lightgreen'></td>";
}


echo "<td bgcolor='lightgreen'>$admin$id</td>"; 

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
		   //echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		   echo "<td bgcolor='lightgreen'>";
		   
		   
		   // $cashier_count==1 gets the magnify glass to edit
		   if($cashier_count==1)
		   {
		   echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><a href=''><img height='25' width='25' src='/budget/infotrack/icon_photos/magnify.png' alt='picture of magnify glass' title='Edit Record'></img></a>";
		   }
		   echo "<br />$cashier3<br />$cashier_date2<br />$cashier_date_dow<br /></td>";	
	       }
 
echo "<td bgcolor='lightgreen'>$first_name $middle_initial $last_name $suffix<br />Emp# $employee_number<br />Pos# $position_number<br />Title: $job_title<br />Phone# $phone_number</td>";
//echo "<td bgcolor='lightgreen'>hello</td>";
		    //echo "<td>$deposit_date2<br />$deposit_date_dow</td>";
		    //echo "<td>$bank_deposit_date2<br /></td>";
			
			// changed on 09/15/14
			/*
			if($cashier=='')
			{
		   echo "<td bgcolor='lightpink'><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' >Cashier<br />Update</a></td>";
		   }
		   */
		   
		  
		   /*
		   echo "<td>$controllers_deposit_id<br /><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' '>Update</a></td>";
		   */
		  
		   
		    //echo "<td>$last_name Training</td>";
if($student_score != '100.00')
{			
		    echo "<td bgcolor='lightpink'>";
            echo "Quiz not completed by Employee";			
			echo "</td>";		
}

if($student_score == '100.00')
{			
		    echo "<td bgcolor='lightgreen'>";		
			echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		   echo "<br />$student_id<br />$student_score<br />$student_test_date<br /></td>";	
			echo "</td>";		
}







			
			//echo "<td>PASU</td>";
		   //Manager Count has 3 possible outcomes 
	
		   if($manager=='' and $pasu_role == 'y' and $student_score=='100.00')//(manager_count == 1)
			{		   
		   echo "<td bgcolor='lightpink'><a href='pcard_manager_approval.php?id=$id' >Update</a></td>";
		   } 
		   
		   if($manager=='' and $pasu_role == 'y' and $student_score!='100.00')//(manager_count == 1)
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
		   //echo "<a href='cash_count_cashier.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear'><img height='25' width='25' src='/budget/infotrack/icon_photos/magnify.png' alt='picture of green check mark'></img></a>";
		   }
		  
		  echo "<br />$manager3<br />$manager_date2<br />$manager_date_dow</td>";
	       }
		
		  
echo "<td>BUOF</td>";		   
echo "<td><a href='$document_location' target='_blank'>VIEW</a></td>";		   
		 
		  


echo "</tr>";

}

 echo "</table>";
 



?>



















	














