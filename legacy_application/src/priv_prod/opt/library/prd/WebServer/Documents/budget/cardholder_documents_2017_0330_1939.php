<?php
//if($level=="5" and $tempid !="Dodd3454"){echo "<pre>";print_r($_REQUEST);echo "</pre>";}//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
//header("location: https://10.35.152.9/login_form.php?db=budget");
}



//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
$level=$_SESSION['budget']['level'];
$tempID=$_SESSION['budget']['tempID'];
$posTitle=$_SESSION['budget']['position'];
$beacon_num=$_SESSION['budget']['beacon_num'];
$pcode=$_SESSION['budget']['select'];
$centerSess=$_SESSION['budget']['centerSess'];
//echo $tempid;
extract($_REQUEST);
/*
if($level=="5" and $tempID !="Dodd3454"){echo "<pre>";print_r($_REQUEST);echo "</pre>";}//exit;
if($level=="5" and $tempID !="Dodd3454"){echo "<pre>";print_r($_SESSION);echo "</pre>";}//exit;
if($level=="5" and $tempID !="Dodd3454"){echo "level=$level<br />";}//exit;
if($level=="5" and $tempID !="Dodd3454"){echo "tempID=$tempID<br />";}//exit;
if($level=="5" and $tempID !="Dodd3454"){echo "posTitle=$posTitle<br />";}//exit;
if($level=="5" and $tempID !="Dodd3454"){echo "beacon_num=$beacon_num<br />";}//exit;
if($level=="5" and $tempID !="Dodd3454"){echo "pcode=$pcode<br />";}//exit;
if($level=="5" and $tempID !="Dodd3454"){echo "centerSess=$centerSess<br />";}//exit;


if($level=="5" and $tempid !="Dodd3454")
{
{$email_message="<tr><td colspan='4' align='center'>Equipment Budget <a href='popupex.html' onclick=\"return popitup('explain_search.php?subject=equipment')\">Terminology</a></td><td colspan='4'> Email Tony Bass with any problems you encounter. Email comments to <a href='mailto:tony.p.bass@ncmail.net?subject=Comments to Administrator-Equipment Budget Tool'>Administrator</a></td></tr>";}
{$email_message2="<tr><td colspan='4' align='center'>Equipment Budget <a href='popupex.html' onclick=\"return popitup('explain_search.php?subject=equipment')\">Terminology</a></td><td colspan='4'> Email Tony Bass with any problems you encounter. Email comments to <a href='mailto:tony.p.bass@ncmail.net?subject=Comments to Administrator-Equipment Budget Tool'>Administrator</a></td></tr>";}
{echo $email_message;}
{echo $email_message2;}
}
*/



//$report_date="2011-01-21";
//$admin_num="foma";
//$report_date=str_replace("-","",$report_date);
//if($level=="5" and $tempid !="Dodd3454"){echo "<pre>";print_r($_REQUEST);"</pre>";}//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
if($submit=='submit_posnum' and $position_number != '')
{
$query1="update pcard_users set position_number='$position_number',affirmation_abundance='$affirmation_abundance' where id='$id' ";
echo "query1=$query1";	
$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");		
}
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: #FFF8DC; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
</style>

</head>";

echo "<H1 ALIGN=LEFT > <font color=brown><i>Cardholder Documents</font></i></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/menu.php?forum=blank> Budget-Home </A></font></H2>";
echo "<br />";
//if($level=="1"){$location=$pcode;}
if($level < '2' and $admin==''){$admin=$pcode;}


echo "<table>";
echo "<tr>";

//echo "<font size=5>"; 
echo "<th>Admin Code</th></tr>";
echo "<tr>";
echo "<form method='post' action='cardholder_documents.php'>";
if($level==1)
{
echo "<td><input name='admin' type='text' value='$admin' readonly='readonly'></td>";
}
else
{
echo "<td><input name='admin' type='text' value='$admin'></td>";
}
echo "<td><input type='submit' name='submit' value='search'></td>";
echo "</form>";
echo "</tr>";
echo "</table>";

$header_var_admin="$admin";
//$header_var_center="&center=$center";
//$header_var_account="&account=$account";
//$header_var_calyear="&calyear=$calyear";


/*
echo
"<form method='post' action='cardholder_documents.php'>";
echo "<td>";
echo "<input type='hidden' name='time_period_start'  value=''>";
echo "<input type='hidden' name='time_period_end'  value=''>";
echo "<input type='hidden' name='account'  value='' >";
echo "<input type='hidden' name='location'  value='' >";
echo "<input type='submit' name='submit' value='reset'>";
echo "</td>" 
echo "</form>";
echo "</tr>";
echo "</table>";
*/

/*
if($load_doc==''){


$query1="select id from pcard_unreconciled where admin_num='$admin_num' 
and report_date='$report_date'
and (ncasnum like '5345%' or ncasnum like '5346%' or ncasnum like '5347%')
and amount >= '500'
";

*/
//$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");
//$invoices_total=mysql_num_rows($result1);


//echo "<H1 ALIGN=LEFT > <font color=brown>$admin_num</font></H1>";
//echo "<H2 ALIGN=LEFT > <font color=brown><i>Invoices for report date: $report_date must be Uploaded for Fixed Asset Reporting(PDF Format Only)</font></i></H2>";


/*

$query2="select id from pcard_unreconciled where admin_num='$admin_num' 
and report_date='$report_date'
and (ncasnum like '5345%' or ncasnum like '5346%' or ncasnum like '5347%')
and document_location != '' ";
$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");
$invoices_uploaded=mysql_num_rows($result2);
*/
if($submit==""){exit;}
//if($submit=="reset"){exit;}

if($admin != ""){$where1=" and admin = '$admin' ";}
if($level==1)
{
$query3g="select 
admin,last_name,first_name,job_title,location,act_id,card_number,comments,justification,document_location,id
from pcard_users where 1 and act_id='y' $where1
order by admin,last_name,first_name,location";
}	


if($level==2 and $pcode=='EADI'){$dist_where=" and dist='east' and fund='1280' and actcenteryn='y' ";}

if($level==2 and $pcode=='NODI'){$dist_where=" and dist='north' and fund='1280' and actcenteryn='y' and center.parkcode != 'mtst' and center.parkcode != 'harp' ";}

if($level==2 and $pcode=='SODI'){$dist_where=" and dist='south' and fund='1280' and actcenteryn='y' and center.parkcode != 'boca' ";}

if($level==2 and $pcode=='WEDI'){$dist_where=" and dist='west' and fund='1280' and actcenteryn='y' ";}

if($level==2){$dist_join=" left join center on pcard_users.admin=center.parkcode ";}

if($level==2)

{
$query3g="select 
admin,last_name,first_name,job_title,location,act_id,card_number,comments,justification,document_location,id
from pcard_users
$dist_join
where 1 and act_id='y' $dist_where  $where1
order by admin,last_name,first_name,location";
//echo "query3g=$query3g";
}
if($level>2)
{
$query3g="select 
admin,last_name,first_name,position_number,job_title,affirmation_abundance,location,act_id,card_number,comments,justification,document_location,id
from pcard_users 
where 1 and act_id='y' $where1
order by admin,last_name,first_name,location";
echo "query3g=$query3g";
}		  
$result3g = mysql_query($query3g) or die ("Couldn't execute query 3g.  $query3g");		  
		  
$record_count=mysql_num_rows($result3g);

/*
$query3h="select count(document_location) as 'doc_yes'
          from pcard_users
		  where 1 and act_id='y' $where1
		  and document_location != ''
		  ";  
	  
		  
		  
$result3h = mysql_query($query3h) or die ("Couldn't execute query 3h.  $query3h");
		  
$row3h=mysql_fetch_array($result3h);

extract($row3h);
*/

/*
if($level=="5" and $tempID !="Dodd3454"){
echo "doc_yes=$doc_yes<br />";}
*/
/*
$query3i="select count(document_location) as 'doc_no'
          from pcard_users
		  where 1 and act_id='y' $where1 
		  and document_location = ''
		  ";
		  
	  
		  
		  
$result3i = mysql_query($query3i) or die ("Couldn't execute query 3i.  $query3i");
		  
$row3i=mysql_fetch_array($result3i);

extract($row3i);
*/

$query_1656_yes="select count(location) as 'yes_1656'
          from pcard_users
		  $dist_join
		  where 1 and act_id='y' $dist_where $where1 
		  and location='1656'
		  and document_location != ''
		  
		  ";		  
		  
$result_query1656_yes = mysql_query($query_1656_yes) or die ("Couldn't execute query 1656 yes.  $query_1656_yes");
		  
$row_1656_yes=mysql_fetch_array($result_query1656_yes);

extract($row_1656_yes);



$query_1669_yes="select count(location) as 'yes_1669'
          from pcard_users
		  $dist_join
		  where 1 and act_id='y' $dist_where $where1 
		  and location='1669'
		  and document_location != ''
		  
		  ";		  
		  
$result_query1669_yes = mysql_query($query_1669_yes) or die ("Couldn't execute query 1669 yes.  $query_1669_yes");
		  
$row_1669_yes=mysql_fetch_array($result_query1669_yes);

extract($row_1669_yes);



$query_1656_no="select count(location) as 'no_1656'
          from pcard_users
		  $dist_join
		  where 1 and act_id='y' $dist_where $where1 
		  and location='1656'
		  and document_location = ''
		  
		  ";		  
		  
$result_query1656_no = mysql_query($query_1656_no) or die ("Couldn't execute query 1656 no.  $query_1656_no");
		  
$row_1656_no=mysql_fetch_array($result_query1656_no);

extract($row_1656_no);



$query_1669_no="select count(location) as 'no_1669'
          from pcard_users
		  $dist_join
		  where 1 and act_id='y' $dist_where $where1 
		  and location='1669'
		  and document_location = ''
		  
		  ";		  
		  
$result_query1669_no = mysql_query($query_1669_no) or die ("Couldn't execute query 1669 no.  $query_1669_no");
		  
$row_1669_no=mysql_fetch_array($result_query1669_no);

extract($row_1669_no);


//echo "yes_1656=$yes_1656<br />";
//echo "yes_1669=$yes_1669<br />";
$total_cardholders=$yes_1656+$yes_1669+$no_1656+$no_1669;
//echo "total_cardholders=$total_cardholders<br />";

//echo "<h2><font color='red'>Cardholders-$total_cardholders</font></h2>";	







/*
echo "<table border=1>
<tr><th>CardType</th><th>Count</th></tr>
<tr><th>1656</th><th>$yes_1656</th></tr>
<tr><th>1669</th><th>$yes_1669</th></tr>
             
	   </table><br />";
*/

/*
if($level=="5" and $tempID !="Dodd3454"){
echo "doc_no=$doc_no<br />";}
*/	

		  
//if($level=="5" and $tempID !="Dodd3454"){echo "Query3g=$query3g";}	


//echo "<h2><font color='red'>Cardholder Documents-$record_count</font></h2>";	
$total_1656=$yes_1656+$no_1656;
$total_1669=$yes_1669+$no_1669;

$total_yes=$yes_1656+$yes_1669;
$total_no=$no_1656+$no_1669;
echo "<br />";
/*
echo "<table border='1'>
<tr bgcolor='lightcyan'><th>1656<br />$total_1656</th><th>1669<br />$total_1669</th><th>total<br />$total_cardholders</th></tr>
 </table><br />";
 */
 /*
 echo "<table border='1'>
<tr><th><font color=blue>Reg Card</font></th><th><font color=blue>CI Card</font></th><th><font color=blue>total</font></th></tr>
<tr bgcolor='lightgreen'><td align='center'>$total_1656</td><td align='center'>$total_1669</td><td align='center'>$total_cardholders</td></tr>
 </table><br />";
 
 */
 
 /*
 echo "<table><tr><th><font color=brown>Cards</font></th><th><font color=blue>Reg $total_1656</font></th><th><font color=blue>CI $total_1669</font></th><th><font color=blue>total    $total_cardholders</font></th></tr></table>";
*/

 

//echo "<table><tr><th><font color=brown>Documents</font></th></tr></table>";
/*
echo "<table border='1'><tr><th><font color=blue>Documents</font></th><th><font color=blue>Reg</font></th><th><font color=blue>CI</font></th><th><font color=blue>Total</font></th></tr>
              <tr bgcolor='lightgreen'><td align='center'>yes</td><td align='center'>$yes_1656</td><td align='center'>$yes_1669</td><td align='center'>$total_yes</td></tr>
              <tr bgcolor='lightpink'><td align='center'>no</td><td align='center'>$no_1656</td><td align='center'>$no_1669</td><td align='center'>$total_no</td></tr>
              
	   </table><br />";
*/
/*
echo "<table><tr><th></th><th><font color=blue>Reg<br />$total_1656</font></th><th><font color=blue>CI<br />$total_1669</font></th><th><font color=blue>Total<br />$total_cardholders</font></th></tr>
              <tr bgcolor='lightgreen'><td>yes</td><td align='center'>$yes_1656</td><td align='center'>$yes_1669</td><td align='center'>$total_yes</td></tr>
              <tr bgcolor='lightpink'><td>no</td><td align='center'>$no_1656</td><td align='center'>$no_1669</td><td align='center'>$total_no</td></tr>
              
	   </table><br />";
*/	   
	   
echo "<table><tr><th></th><th><font color=blue>Reg</font></th><th><font color=blue>CI</th><th><font color=blue>Total</th></tr>
              <tr bgcolor='lightgreen'><td>yes</td><td align='center'>$yes_1656</td><td align='center'>$yes_1669</td><td align='center'>$total_yes</td></tr>
              <tr bgcolor='lightpink'><td>no</td><td align='center'>$no_1656</td><td align='center'>$no_1669</td><td align='center'>$total_no</td></tr>
			  <tr><th><font color='blue'>total</font></th><th><font color='blue'>$total_1656</font></th><th><font color='blue'>$total_1669</font></th><th><font color='blue'>$total_cardholders</font></th></tr>

              
	   </table><br />";









	   
   
echo "<table border=1>";
 
echo "<tr>"; 

  
  echo " <th><font color=blue>Admin</font></th>"; 
 echo " <th><font color=blue>Last Name</font></th>"; 
 echo " <th><font color=blue>First Name</font></th>";
 echo " <th><font color=blue>Position#</font></th>";
 echo " <th><font color=blue>Job Title</font></th>";
 echo " <th><font color=blue>CardType</font></th>";
 echo " <th><font color=blue>Active</font></th>";
 echo " <th><font color=blue>Card Number</font></th>";
 //echo " <th><font color=blue>Comments</font></th>";
 echo " <th><font color=blue>Justification</font></th>";
  echo " <th><font color=blue>Document</font></th>";
  echo " <th><font color=blue>ID</font></th>";
  echo "</tr>";
//echo  "<form method='post' autocomplete='off' action='stepH9b_update_all.php'>";

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysql_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row3g=mysql_fetch_array($result3g)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3g);

if($document_location != ""){$document="yes";} else {$document="";}
if($document_location != ""){$bgc="lightgreen";} else {$bgc="lightpink";}
if($position_number != ""){$bgc="lightgreen";} else {$bgc="lightpink";}




if($location=='1656'){$location="reg";}
if($location=='1669'){$location="ci";}

//echo "document_location=$document_location";
//echo "<br />";
//echo "document=$document";


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
   
//echo "<form method=post action=stepG5_update.php>";	
 echo "<tr bgcolor='$bgc'>";  
echo  "<td align='center'>$admin</td>";
echo  "<td align='center'>$last_name</td>";
echo  "<td align='center'>$first_name</td>";
echo  "<td align='center'>$position_number</td>";
echo  "<td align='center'>$job_title</td>";
echo  "<td align='center'>$location</td>";
echo  "<td align='center'>$act_id</td>";
echo  "<td align='center'>$card_number</td>";
//echo  "<td>$comments</td>";
echo  "<td align='center'>$justification</td>";

if($level>='4')
{

if($document=="yes"){
echo "<td align='center'><a href='$document_location' target='_blank'>View</a><br /><a href='cardholder_document_add.php?source_id=$id&header_var_admin=$header_var_admin' target='_blank'>Reload</a></td>";}

if($document!="yes"){
echo "<td align='center'><a href='cardholder_document_add.php?source_id=$id&header_var_admin=$header_var_admin' target='_blank'>Upload</a></td>";}

}
else
{

if($document=="yes"){
echo "<td align='center'><a href='$document_location' target='_blank'>View</a></td>";}

}




//if($document!="yes")
//{echo "<td>$source</td>";}

echo  "<td align='center'><a href='editPcardHolders.php?card_number=$card_number&submit_acs=Find' target='_blank'>$id</a></td>";
echo "<td>";
echo "<form method='post' action='cardholder_documents.php'>";
echo "<input type='text' name='position_number' value='$position_number'><br />";
echo "<textarea rows='4' cols='50' name='affirmation_abundance'>$affirmation_abundance</textarea>";
echo "<input type='hidden' name='id' value='$id'>";
echo "<input type='submit' name='submit' value='submit_posnum'>";
echo "</form>";
echo "</td>";


//echo  "<td><a href='pcard_fixed_assets_document_add.php?id=$id&load_doc=y&report_date=$report_date&admin_num=$admin_num'>Upload Invoice</a></td>";
  
echo "</tr>";
//$document='';
}
echo "</table>";
/*



$result3a = mysql_query($query3a) or die ("Couldn't execute query 3a.  $query3a");
$query3b="select 
id,sourcevendor_name,amount,ncasnum
from pcard_unreconciled
where admin_num='$admin_num'
and report_date='$report_date'
and (ncasnum like '5345%' or ncasnum like '5346%' or ncasnum like '5347%')
and document_location = ''
order by vendor_name,amount,ncasnum"


$query4="
select 
id,sourcevendor_name,amount,ncasnum
from pcard_unreconciled
where admin_num='$admin_num'
and report_date='$report_date'
and (ncasnum like '5345%' or ncasnum like '5346%' or ncasnum like '5347%')
and document_location = ''
order by vendor_name,amount,ncasnum
";
$result4 = mysql_query($query4) or die ("Couldn't execute query 4.  $query4");
$invoices_remaining=mysql_num_rows($result4);
//echo $num3;exit;
//mysql_close();
echo "<table border=1>";
echo "<tr><th><font color='blue'>Total Invoices Uploaded</font></th>";
//echo "<th><font color='blue'>Remaining</font></th></tr>";
echo "<td><font color='red'>$invoices_uploaded</font></td></tr></table>";
echo "<br />";
//echo "$invoices_remaining</td>";
//echo "</table>";
if($invoices_remaining=="0")
{echo "<h2><font color='red'>All Invoices have been Uploaded-Thanks!</font></td>
       <h2><a href='pcard_recon.php?report_date=$report_date&admin_num=$admin_num'>Return to PCARD Reconcilement</a></h2>";}

//echo "<br />";

if($invoices_remaining!="0"){

echo "<h2><font color='red'>Remaining Invoices to Upload: $invoices_remaining</font></h2>";	   
echo "<table border=1>";
 
echo "<tr>"; 

 echo " <th><font color=blue>ID</font></th>";  
 echo " <th><font color=blue>VendorName</font></th>";
 echo " <th><font color=blue>Amount</font></th>";
 echo " <th><font color=blue>Account</font></th>";
 echo " <th><font color=blue>Action</font></th>";
  echo "</tr>";
//echo  "<form method='post' autocomplete='off' action='stepH9b_update_all.php'>";

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysql_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row4=mysql_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
   
//echo "<form method=post action=stepG5_update.php>";	
 echo "<tr bgcolor='#B4CDCD'>";  
echo  "<td>$id</td>";
echo  "<td>$vendor_name</td>";
echo  "<td>$amount</td>";
echo  "<td>$ncasnum</td>";
echo  "<td><a href='pcard_fixed_assets_document_add.php?id=$id&load_doc=y&report_date=$report_date&admin_num=$admin_num'>Upload Invoice</a></td>";
  
echo "</tr>";

}
}
}
else{
echo "<h1>ADD Document</h1>";
echo "<form enctype='multipart/form-data' method='post' action='pcard_fixed_assets_document_add2.php'>";
echo "<input type='hidden' name='MAX_FILE_SIZE' value='20000000'>";
echo "<input type='file' id='document' name='document'>";
echo "<input type='hidden' name='id' value='$id'>";
echo "<input type='hidden' name='report_date' value='$report_date'>";
echo "<input type='hidden' name='admin_num' value='$admin_num'>";

echo "<br /> <br />";
echo "<input type='submit' value='add_document' name='submit'>";
echo "</form>";
echo "</body>";

}
*/
echo "</html>";
?>

























