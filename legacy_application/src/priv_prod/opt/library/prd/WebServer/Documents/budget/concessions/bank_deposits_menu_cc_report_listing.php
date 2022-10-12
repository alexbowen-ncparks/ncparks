<?php

/*   
$query11="SELECT depositid_cc,sum(amount) as 'amount',f_year
            from crs_tdrr_cc_all
			WHERE 1
			group by depositid_cc
			order by id desc ";
*/			
			
/*			
$query11="SELECT depositid_cc,sum(amount) as 'amount',f_year,depositid_cc_last_deposit as 'deposit_date',start_date,end_date,depositid_cc_postdate as 'post_date'
            from crs_tdrr_cc_all
			WHERE 1 and f_year='$fyear'
			group by depositid_cc
			order by id desc ";			
*/			



if($delrec=='y')
{
echo "<br /><font color='brown' size='6'>write query to archive Invalid record</font><br />";	

$query10a="select depositid_cc as 'depositid_cc_old',f_year as 'f_year_old'
           from crs_tdrr_cc_all_deposits
           where id='$del_id' ";		   

$result10a = mysqli_query($connection, $query10a) or die ("Couldn't execute query 10a.  $query10a ");
echo "<br />query10a=$query10a<br />";	
$row10a=mysqli_fetch_array($result10a);

extract($row10a);

$depositid_cc_new=$depositid_cc_old.'_delid'.$del_id;

echo "<br />depositid_cc_old=$depositid_cc_old<br />";
echo "<br />f_year_old=$f_year_old<br />";
echo "<br />depositid_cc_new=$depositid_cc_new<br />";

$query10b="update crs_tdrr_cc_all_deposits set valid_record='n',depositid_cc='$depositid_cc_new' where id='$del_id' ";

echo "<br />query10b=$query10b<br />";		   

$result10b = mysqli_query($connection, $query10b) or die ("Couldn't execute query 10b.  $query10b ");

$query10c="update crs_tdrr_cc_all set depositid_cc='$depositid_cc_new',valid_record='n' where depositid_cc='$depositid_cc_old' and f_year='$f_year_old' ";	

echo "<br />query10c=$query10c<br />";	   

$result10c = mysqli_query($connection, $query10c) or die ("Couldn't execute query 10c.  $query10c ");


}






$query11="SELECT depositid_cc,amount_total as 'amount',revenue_adjust,revenue_adjust_count,tax_adjust,tax_adjust_count,f_year,depositid_cc_entry_date as 'deposit_date',start_date,end_date,depositid_cc_postdate as 'post_date',id
            from crs_tdrr_cc_all_deposits
			WHERE 1 and f_year='$fyear' and valid_record='y'
			group by depositid_cc
			order by depositid_cc_entry_date desc,depositid_cc desc ";	


/*
$query11="SELECT depositid_cc,sum(amount) as 'amount',f_year
            from crs_tdrr_cc_all
			WHERE 1 
			group by depositid_cc
			order by id desc ";
	
*/


	
 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		

echo "<br />Query11=$query11<br />";
//$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

//$row11=mysqli_fetch_array($result11);

//extract($row11);
echo "<br />";
echo "<table align='center' cellpadding='10'><tr><td><font color='red'>Deposits: $num11</font></td><td></td><th><a href='bank_deposits_menu_cc_test.php?step=$step&fyear=$fyear&edit_mode=y'>&nbsp;&nbsp;EditMode</a></th>";
if($edit_mode=='y')
{
echo "<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='crj_cc_adjustment_accounts.php' target='_blank'>Park Accounts 2 Adjust</a></th>";
}
echo "</tr></table>";
echo "<table align='center' cellpadding='10' border=1>";

echo "<tr>";
if($edit_mode=='y')
{	
echo "<th></th>";
}
echo "<th align=left><font color=brown>DepositID#</font></th>
       <th align=left><font color=brown>Total<br />Amount</font></th>";

//Dodd, Bass Standard   //Rumble if edit_mode=y
if($beacnum=='60032781' or $beacnum=='60032793' or $edit_mode=='y')
{
	
//echo "<th align=left><font color=brown>Revenue Adj</font></th>";
echo "<th align=left><font color=brown>Tax Adj</font></th>";
echo "<th align=left><font color=brown>f_year</font></th>";
echo "<th align=left><font color=brown>CRJDate</font></th>";
echo "<th align=left><font color=brown>StartDate</font></th>";
 echo "<th align=left><font color=brown>EndDate</font></th>";
//echo "<th align=left><font color=brown>PostDate</font></th>";
}       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);
$amount2=number_format($amount,2);
$revenue_adjust2=number_format($revenue_adjust,2);
$tax_adjust2=number_format($tax_adjust,2);
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo "<tr$t>";
if($edit_mode=='y')
{
if($id!=$idS)
{
echo "<td><a href='bank_deposits_menu_cc_test.php?step=$step&fyear=$fyear&edit_mode=y&idS=$id'><img height='15' width='15' src='/budget/infotrack/icon_photos/mission_icon_photos_263.png' alt='red trash can' title='delete'></img></a></td>";
}
if($id==$idS)
{
echo "<td><font class='cartRow'><font color='red'>Delete Record?</font><br /><br /><table align='center' cellpadding='10'><tr$t><th><a href='bank_deposits_menu_cc_test.php?step=$step&fyear=$fyear&edit_mode=y&delrec=y&del_id=$id'>Yes</a></th><th><a href='bank_deposits_menu_cc_test.php?step=$step&fyear=$fyear&edit_mode=y'>No</a></th></tr></table></font></td>";

}
}
	
echo "<td><a href='bank_deposits_menu_cc_reports.php?depositid_cc=$depositid_cc'>$depositid_cc</a></td>  
		    <td>$amount2</td>";
//Dodd, Bass   //Rumble if edit_mode=y
if($beacnum=='60032781' or $beacnum=='60032793' or $edit_mode=='y')
{	
//echo "<td>$revenue_adjust2 ($revenue_adjust_count)</td>";			
echo "<td>$tax_adjust2 ($tax_adjust_count)</td>";			
echo "<td>$f_year</td><td>$deposit_date</td><td>$start_date</td><td>$end_date</td><td><a href='bank_deposits_menu_cc_test.php?step=1daily&fyear=$fyear&amount=$amount&depositid_cc=$depositid_cc'>DailyTotals</a></td>";
}		                      
    
       
              
           
echo "</tr>";




}

 echo "</table>";
 
//echo "Query11=$query11"; 
 
 
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";
echo "</html>";


?>



















	














