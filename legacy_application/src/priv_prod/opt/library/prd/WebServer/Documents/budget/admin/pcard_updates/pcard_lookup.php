<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
/*
if($loc_change=='y')
{
if($location=='1656'){$new_location='1669'; $new_company='4614'; $new_center=''; $new_projnum='';}	
if($location=='1669'){$new_location='1656'; $new_company='4601'; $new_center=''; $new_projnum=''; }

$query="update pcard_unreconciled set location='$new_location',company='$new_company',center='$new_center',projnum='$new_projnum' where id='$id' ";
//echo "Line 23: query=$query";	
	
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");		
	
}	

*/
/*
if($submit=='update')
{

$query="update pcard_unreconciled set company='$company',center='$center',projnum='$projnum' where id='$id' ";
echo "Line 35: query=$query";	//exit;
	
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
$submit='Find';
echo "amount=$amount<br />";
echo "submit=$submit<br />";

}

*/





echo "<html>";
/*
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: #FFF8DC; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
</style>
</head>";
*/

//echo "<body bgcolor=>";
include ("../../../budget/menu1415_v3.php");


if($submit=='update')
{

$query="update pcard_unreconciled set location='$location',company='$company',center='$center',projnum='$projnum',admin_num='$admin_num',last_name='$last_name',first_name='$first_name',
        cardholder=concat('$last_name',', ','$first_name') where id='$id' ";
echo "Line 35: query=$query";
//exit;
	
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
$message='yes';
$submit='Find';
//echo "amount=$amount<br />";
//echo "submit=$submit<br />";

}







//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
//echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-Day5</font></i></H1>";
//echo "<H1 ALIGN=center > <font color=brown><i>$project_name</font></i></H1>";
echo "<br /><br />";
echo "<table align=center><tr><th><img height='75' width='125' src='credit_card2.jpg' alt='picture of credit card'></img><br />PCARD Lookup</th></tr></table>";
echo "<br /><br />";
/*
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/pcard_updates/stepL3e.php?project_category=fms&project_name=pcard_updates&step_group=L&step_num=3e&reset=yes> RESET REPORT WEEK </A></font></H2>";
*/
//echo "<br />";
echo "<table align='center'>";
echo "<tr>";

echo "<td>";
echo "<table align='center' border='1'> ";
echo "<tr><th><font color='blue'>Reconcilements</font></th></tr>";
echo
"<form align=center>";
echo "<font size=5>"; 
echo "<form action='pcard_lookup.php'>";
echo "<font size=5>"; 
echo "<tr><td>Cardholder(Last Name)<br /><input name='cardholder' type='text' autocomplete='off'></td></tr>";
echo "<tr><td>Card#(Last 4)<br /><input name='pcard_num' type='text'  autocomplete='off'></td></tr>";
echo "<tr><td>Vendor<br /><input name='vendor_name' type='text'  autocomplete='off'></td></tr>";
echo "<tr><td>Amount<br /><input name='amount' type='text'  autocomplete='off'></td></tr>";
echo "<tr><td><input type='submit' name='submit' value='Find'></td></tr>";
echo "<br />";
echo "</form>";
echo "</table>";
echo "</td>";


echo "<td>";
echo "<table align='center' border='1'> ";
echo "<tr><th><font color='red'>XTND Downloads</font></th></tr>";
echo
"<form align=center>";
echo "<font size=5>"; 
//echo "XTND_day:<input name='fiscal_year' type='text' value='$xtnd_day' readonly='readonly'>";

//echo "<br />";
echo
"<form action='pcard_lookup.php'>";
echo "<font size=5>"; 
//echo "fiscal_year:<input name='fiscal_year' type='text' value='$fiscal_year' readonly='readonly'>";


/*
echo "<tr><td>Cardholder(Last Name)<br /><input name='cardholder' type='text' value='$cardholder' autocomplete='off'></td></tr>";
echo "<tr><td>Card#(Last 4)<br /><input name='pcard_num' type='text' value='$pcard_num' autocomplete='off'></td></tr>";
echo "<tr><td>Vendor<br /><input name='vendor_name' type='text' value='$vendor_name' autocomplete='off'></td></tr>";
echo "<tr><td>Amount<br /><input name='amount' type='text' value='$amount' autocomplete='off'></td></tr>";
echo "<tr><td><input type='submit' value='Find'></td></tr>";
*/

echo "<tr><td>Cardholder(Last Name)<br /><input name='cardholder' type='text' autocomplete='off'></td></tr>";
echo "<tr><td>Card#(Last 4)<br /><input name='pcard_num' type='text'  autocomplete='off'></td></tr>";
echo "<tr><td>Vendor<br /><input name='vendor_name' type='text'  autocomplete='off'></td></tr>";
echo "<tr><td>Amount<br /><input name='amount' type='text'  autocomplete='off'></td></tr>";
echo "<tr><td><input type='submit' name='submit' value='Find2'></td></tr>";
echo "<br />";
//echo "start_date:<input name='start_date' type='text' value='$start_date' readonly='readonly'>";
//echo "<br />";
//echo "end_date:<input name='end_date' type='text' value='$end_date' readonly='readonly'>";
//echo "today_date:<input name='today_date'";  echo "type='text'"; echo "value= date('Y-m-d')"; echo "readonly='readonly'>";
echo "</form>";
echo "</table>";
echo "</td>";
echo "</tr>";
echo "</table>";




echo "<br /><br />";


if($submit=='Add')
{
/*
$query1="update pcard_unreconciled_xtnd_temp2_perm,pcard_users
         set pcard_unreconciled_xtnd_temp2_perm.location=pcard_users.location, 
		     pcard_unreconciled_xtnd_temp2_perm.admin_num=pcard_users.admin, 
		     pcard_unreconciled_xtnd_temp2_perm.last_name=pcard_users.last_name, 
		     pcard_unreconciled_xtnd_temp2_perm.first_name=pcard_users.first_name,
		     pcard_unreconciled_xtnd_temp2_perm.center=pcard_users.center,
			 pcard_unreconciled_xtnd_temp2_perm.dpr='y'
             where pcard_unreconciled_xtnd_temp2_perm.id='$insert_id'
             and pcard_unreconciled_xtnd_temp2_perm.card_number2=pcard_users.card_number
             and pcard_unreconciled_xtnd_temp2_perm.cardholder like concat('%',pcard_users.last_name,'%')	 ";


echo "<br />query1=$query1<br />";	

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


$query11="update pcard_unreconciled_xtnd_temp2_perm
         set primary_account_holder=concat(last_name,',',first_name)
         where id='$insert_id' ";


echo "<br />query11=$query11<br />";	

$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");




	
$query1a="SELECT admin_num as 'insert_admin_num' from pcard_unreconciled_xtnd_temp2_perm
          where id='$insert_id' ";

echo "<br />query1a=$query1a<br />";			  
	
$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");

$row1a=mysqli_fetch_array($result1a);
extract($row1a);//brings back max (end_date) as $end_date
	
$query1b="SELECT max(report_date) as 'insert_report_date'
          from pcard_report_dates_compliance
          WHERE 1
          and (admin_num='$insert_admin_num' )
         ";		
	
echo "<br />query1b=$query1b<br />";		
	
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");	

$row1b=mysqli_fetch_array($result1b);
extract($row1b);//brings back max (end_date) as $end_date



	
$query1c="insert into pcard_unreconciled(location,admin_num,post_date,trans_date,amount,vendor_name,trans_id,pcard_num,xtnd_rundate,transdate_new,cardholder,transid_new,postdate_new,xtnd_rundate_new,center,company,last_name,first_name,report_date)
select location,admin_num,date_posted,date_purchased,amount,merchant_name,trans_id,card_number2,
xtnd_rundate,date_purchased_new,primary_account_holder,trans_id,date_posted_new,'$insert_report_date',center,company,last_name,first_name,'$insert_report_date'
from pcard_unreconciled_xtnd_temp2_perm
where id='$insert_id' ; ";

echo "<br />query1c=$query1c<br />";  exit;

//$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");
*/


/////echo "<br />submit=$submit<br />insert_id=$insert_id<br />cardholderE=$cardholderE<br />card_numberE=$card_numberE";
/*
$query6="update pcard_unreconciled_xtnd_temp2_perm,pcard_users
         set pcard_unreconciled_xtnd_temp2_perm.location=pcard_users.location, 
		     pcard_unreconciled_xtnd_temp2_perm.admin_num=pcard_users.admin, 
		     pcard_unreconciled_xtnd_temp2_perm.last_name=pcard_users.last_name, 
		     pcard_unreconciled_xtnd_temp2_perm.first_name=pcard_users.first_name,
		     pcard_unreconciled_xtnd_temp2_perm.center=pcard_users.center,
		     pcard_unreconciled_xtnd_temp2_perm.xtnd_report_date='$end_date',
		     pcard_unreconciled_xtnd_temp2_perm.report_date='$end_date',			 
		     pcard_unreconciled_xtnd_temp2_perm.division='DPR_MANUAL',
		     pcard_unreconciled_xtnd_temp2_perm.backdate='y',			 
			 pcard_unreconciled_xtnd_temp2_perm.dpr='y'
             where pcard_unreconciled_xtnd_temp2_perm.card_number2=pcard_users.card_number
             and pcard_unreconciled_xtnd_temp2_perm.cardholder like concat('%',pcard_users.last_name,'%')
             and pcard_unreconciled_xtnd_temp2_perm.dpr='n'	
             and pcard_unreconciled_xtnd_temp2_perm.id='$insert_id'			 ";
			 */
			 
// Necessary to make sure the Record Inserted is tagged with the correct Report Date (specifically, the most recent Active record in TABLE=pcard_report_dates)			 
$query5="select report_date as 'active_report_date',xtnd_start as 'active_start_date',xtnd_end as 'active_end_date' from pcard_report_dates where active='y' order by id desc limit 1"; 
			 
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");	

$row5=mysqli_fetch_array($result5);
extract($row5);
/////echo "<br />active_report_date=$active_report_date<br />";
			 
			 
$query6a="update pcard_unreconciled_xtnd_temp2_perm as t1,pcard_users as t2
         set t1.location=t2.location, 
		     t1.admin_num=t2.admin, 
		     t1.last_name=t2.last_name, 
		     t1.first_name=t2.first_name,
		     t1.center=t2.center,
		     t1.xtnd_report_date='$active_report_date',
		     t1.report_date='$active_report_date',			 
		     t1.division='DPR_MANUAL',
		     t1.backdate='y',			 
			 t1.dpr='y'
             where t1.card_number2=t2.card_number
             and t1.cardholder like concat('%',t2.last_name,'%')
             and t1.dpr='n'	
             and t1.id = '$insert_id'	 ";		 
			 
			 
			 
			 
/////echo "<br />query6a=$query6a<br />";			 


$result6a = mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a.  $query6a");

//echo "<br />OK Line 256<br />";

/////echo "<br /><font color='green' size='6'><b>SUCCESS1</b>: pcard_unreconciled_xtnd_temp2_perm TABLE updated for missing record if CARD# and Cardholder Name match to TABLE=pcard_users<br /></font>"; //exit;


$query6b="select dpr as 'dpr_valid',cardholder as 'cardholder_xtnd',card_number2 as 'cardnum_xtnd',admin_num as 'admin_num_edit',report_date as 'report_date_edit' from pcard_unreconciled_xtnd_temp2_perm  where id='$insert_id' ";

$result6b = mysqli_query($connection, $query6b) or die ("Couldn't execute query 6b.  $query6b");
echo "<br />query6b=$query6b<br />";
$row6b=mysqli_fetch_array($result6b);
extract($row6b);

/////echo "<br />dpr_valid=$dpr_valid<br />";
/////echo "<br />cardholder_xntd=$cardholder_xtnd<br />";
/////echo "<br />cardnum_xtnd=$cardnum_xtnd<br />";

//exit;

if($dpr_valid=='n')
{

$photo_location="/budget/infotrack/icon_photos/mission_icon_photos_228.ico";
$photo_location2="<img src='$photo_location' height='100' width='100'>";	
	
echo "<table align='center'><tr><td>$photo_location2</td><th>Oops! Unable to ADD transaction to the weekly PCARD Reconcilement.<br />Cardholder <font color='red'>$cardholder_xtnd (CardNum $cardnum_xtnd)</font> was not found in TABLE=pcard_users.<br />Verify Cardholder here>> <a href='/budget/acs/editPcardHolders.php?m=pcard&menu=VCard'>VIEW Cardholders in TABLE=pcard_users</a>  </th></tr></table>"; 
//echo "<table align='center'><tr><td><font size='7'><a href='/budget/cash_sales/page2_form.php?step=1&edit=y'>Return to Form</a></font></td></tr></table>";
//echo "<br />Line 312<br />";
exit;
}


if($dpr_valid=='y')
{
$query7="update pcard_unreconciled_xtnd_temp2_perm
        set primary_account_holder=concat(last_name,',',first_name)
        where id='$insert_id' ";


$result7 = mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");

//echo "<br />query7=$query7<br />"; //exit;


$query7a="update pcard_unreconciled_xtnd_temp2_perm
          set admin_num='eadi'
		  where admin_num='core' 
		  and id='$insert_id' "; 
		  
$result7a = mysqli_query($connection, $query7a) or die ("Couldn't execute query 7a.  $query7a");

//echo "<br />query7a=$query7a<br />"; //exit;



$query7b="update pcard_unreconciled_xtnd_temp2_perm
          set admin_num='sodi'
		  where admin_num='pire'
          and id='$insert_id' "; 
		 

$result7b = mysqli_query($connection, $query7b) or die ("Couldn't execute query 7b.  $query7b");

//echo "<br />query7b=$query7b<br />"; //exit;


$query7c="update pcard_unreconciled_xtnd_temp2_perm
          set admin_num='wedi'
		  where admin_num='more' 
		  and id='$insert_id' "; 	  
		   

$result7c = mysqli_query($connection, $query7c) or die ("Couldn't execute query 7c.  $query7c");

//echo "<br />query7c=$query7c<br />"; 


$query7c1="update pcard_unreconciled_xtnd_temp2_perm
          set company='4601'
		  where location='1656' 
		  and id='$insert_id' "; 	  
		   

$result7c1 = mysqli_query($connection, $query7c1) or die ("Couldn't execute query 7c1.  $query7c1");

//echo "<br />query7c1=$query7c1<br />"; 







$query7d="insert into pcard_unreconciled(location,admin_num,post_date,trans_date,amount,vendor_name,trans_id,pcard_num,cardholder_xtnd,xtnd_rundate,transdate_new,cardholder,transid_new,postdate_new,xtnd_rundate_new,center,company,last_name,first_name,report_date)
select location,admin_num,date_posted,date_purchased,amount,merchant_name,trans_id,card_number2,cardholder,
xtnd_rundate,date_purchased_new,primary_account_holder,trans_id,date_posted_new,'$report_date_edit',center,company,last_name,first_name,'$report_date_edit'
from pcard_unreconciled_xtnd_temp2_perm
where id='$insert_id' ; ";


$result7d = mysqli_query($connection, $query7d) or die ("Couldn't execute query 7d.  $query7d");

/////echo "<br />query7d=$query7d<br />";  //exit;

$query7e="update pcard_unreconciled,pcard_users
set pcard_unreconciled.employee_tempid=pcard_users.employee_tempid
where pcard_unreconciled.cardholder_xtnd=pcard_users.cardholder_xtnd
and pcard_unreconciled.pcard_num=pcard_users.card_number
and pcard_unreconciled.report_date='$report_date_edit' "; 

$result7e = mysqli_query($connection, $query7e) or die ("Couldn't execute query 7e.  $query7e");

/////echo "<br />query7e=$query7e<br />";  //exit;


$query7f="select record_count as 'record_count_edit' from pcard_report_dates_compliance where report_date='$report_date_edit' and admin_num='$admin_num_edit' "; 

$result7f = mysqli_query($connection, $query7f) or die ("Couldn't execute query 7f.  $query7f");
$row7f=mysqli_fetch_array($result7f);
extract($row7f);

/////echo "<br />query7f=$query7f<br />";

/////echo "<br />record_count_edit=$record_count_edit<br />";
$record_count_edit2=$record_count_edit+1;
/////echo "<br />record_count_edit2=$record_count_edit2<br />";  //exit;



$query7g="update pcard_report_dates_compliance set record_count='$record_count_edit2' where report_date='$report_date_edit' and admin_num='$admin_num_edit' "; 

$result7g = mysqli_query($connection, $query7g) or die ("Couldn't execute query 7g.  $query7g");

/////echo "<br />query7g=$query7g<br />";  //exit;



//exit;




$array = array("/budget/infotrack/icon_photos/mission_icon_success_1.png", "/budget/infotrack/icon_photos/mission_icon_success_5.png", "/budget/infotrack/icon_photos/mission_icon_success_8.png", "/budget/infotrack/icon_photos/mission_icon_success_10.png");
	$k=array_rand($array);
	$photo_location=$array[$k];
	$photo_location2="<img src='$photo_location' height='100' width='100'>";
echo "<table align='center'><tr><td>$photo_location2</td><th>PCARD transaction added to PCARD Reconcilement for Report Date $report_date_edit Thanks!<br /> <a href='/budget/acs/pcard_recon.php?report_date=$active_report_date&xtnd_start=$active_start_date&xtnd_end=$active_end_date&admin_num=$admin_num_edit&cardholder=&report_type=&submit=Find'>View $admin_num_edit Reconcilement</a></th></tr></table>";
//echo "<table align='center'><tr><td><font size='7'><a href=''>TEXT</a></font></td></tr></table>";




exit;

}	
}

if($submit==''){exit;}
if($submit=='Find')
{
	
if($cardholder!=''){$where2=" and cardholder like '%$cardholder%' ";}
if($vendor_name!=''){$where2=" and vendor_name like '%$vendor_name%' ";}
if($amount!=''){$where2=" and amount='$amount' ";}
if($pcard_num!=''){$where2=" and pcard_num='$pcard_num' ";}
if($id!=''){$where2=" and id='$id' ";}
	
	
	
$query3="SELECT * FROM pcard_unreconciled
         where 1 $where2 and transdate_new >= '20160701'
		 order by transdate_new desc ";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
echo "Line 217: query3=$query3<br />";
if($message=='yes')
{
echo "<table align='center'><tr><th><font color='green'><b>Update Successful</b></font></th></tr></table>";
}

////mysql_close();
//echo "<br /><br />";

echo "<table align='center'><tr><th><font color='blue'>Reconcilements ($num3 Records)</font></th></tr></table>";

echo "<table border=1 align='center'>";
 
echo 

"<tr>      
       <th><font color='purple'>Cardholder(XTND)</font></th>
       <th>Cardholder(MC)</th>       
       <th>Cardholder<br />last name(MC)</th>       
       <th>Cardholder<br />first name(MC)</th>       
       <th>Card#</th>
       <th>Admin#</th>
       <th>Trans Date</th>
       <th>Report Date</th>
       <th>Vendor</th>
	   
       <th>Amount</th>   
	   <th>Location</th>
       <th>Company</th>               
       <th>Center</th>               
       <th>Proj#</th>               
       <th>ID</th>               
       
 

</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
//echo $status;

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
//if($status=='complete'){$t=" bgcolor='lightgreen'";}else{$t=" bgcolor='lightpink'";}
//if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}

//echo $status;


echo "<form action='pcard_lookup.php' autocomplete='off'>";
echo 
	
"<tr$t>	      
       
	   <td><font color='purple'>$cardholder_xtnd</font></td>
	   <td>$cardholder</td>	   
	   	 <td><input type='text' name='last_name' size='10' value='$last_name'></td>  
	   	 <td><input type='text' name='first_name' size='10' value='$first_name'></td>  
	     <td>$pcard_num</td>";
//	   echo "<td>$admin_num</td>";
	   echo "<td><input type='text' name='admin_num' size='7' value='$admin_num'></td>";
	   //echo "<td>$location<br /><a href='pcard_lookup.php?pcard_num=$pcard_num&amount=$amount&location=$location&loc_change=y&id=$id&submit=Find'>Change</a></td>";
	  // echo "<td>$location</td>";
	   echo "<td>$transdate_new</td>
	   <td>$report_date</td>";
	   echo "<td>$vendor_name";
	   if($document_location != ''){echo "<br /><a href='/budget/acs/$document_location' target='_blank'>Invoice</a>";}
	   echo "</td>";
	   echo "<td>$amount</td>";
	   
	   /*
	   if($location==1669)
	   {
	   echo "<td><font color='blue'>$projnum</font></td>";
	   }
	   if($location!=1669)
	   {
	   echo "<td>$projnum</td>";
	   }
	  */   
	   echo "<td><input type='text' name='location' size='7' value='$location'></td>";
	   echo "<td><input type='text' name='company' size='7' value='$company'></td>";
	   echo "<td><input type='text' name='center' size='7' value='$center'</td>";
	   echo "<td><input type='text' name='projnum' size='7' value='$projnum'</td>";
	   echo "<td>$id <br /><input type='submit' name='submit' value='update'></td>";
	   echo "<input type='hidden' name='pcard_num' value='$pcard_num'>";
	   echo "<input type='hidden' name='amount' value='$amount'>";
	   echo "<input type='hidden' name='id' value='$id'>";
	   echo "</form>";
	      
echo "</tr>";



}

echo "</table>";
}

if($submit=='Find2')
{
	
if($cardholder!=''){$where2=" and cardholder like '%$cardholder%' ";}
if($vendor_name!=''){$where2=" and vendor like '%$vendor_name%' ";}
if($amount!=''){$where2=" and amount='$amount' ";}
if($pcard_num!=''){$where2=" and card_number2='$pcard_num' ";}
	
	
	
$query3="SELECT * FROM pcard_unreconciled_xtnd_temp2_perm
         where 1 $where2 and date_purchased_new >= '20160701'
		 order by date_purchased_new desc ";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
echo "query3=$query3<br />";

////mysql_close();
//echo "<br /><br />";

echo "<table align='center'><tr><th><font color='red'>XTND Downloads ($num3 Records)</font></th></tr></table>";

echo "<table border=1 align='center'>";
 
echo 

"<tr>      
       
       <th>Cardholder</th>
       <th>Card#</th>
       <th>Admin#</th>
       <th>Report Date</th>
       <th>Vendor</th>
       <th>Amount</th>               
       <th>Trans Date</th>               
       <th>DPR</th>               
       <th>ID</th>               
       
 

</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
//echo $status;

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
//if($status=='complete'){$t=" bgcolor='lightgreen'";}else{$t=" bgcolor='lightpink'";}
//if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}

//echo $status;



echo 
	
"<tr$t>	      
       
	   
	   <td>$cardholder</td>
	   <td>$card_number2</td>
	   <td>$admin_num</td>
	   <td>$report_date</td>
	   <td>$vendor</td>
	   <td>$amount</td>
	   <td>$date_purchased_new</td>
	   <td>$dpr</td>
	   <td>$id</td>";
	   if($dpr=='n')
	   {
	   echo "<td>";
	   echo "<form action='pcard_lookup.php'>";
	   echo "<input type='submit' name='submit' value='Add'>";
	   echo "<input type='hidden' name='insert_id' value='$id'>";
	  // echo "<input type='hidden' name='cardholderE' value='$cardholder'>";
	   echo "<input type='hidden' name='card_numberE' value='$card_number2'>";
	   echo "</form>";
	   echo "</td>";
	   }
	      
echo "</tr>";



}

echo "</table>";
}


echo "</body>";
echo "</html>";

?>