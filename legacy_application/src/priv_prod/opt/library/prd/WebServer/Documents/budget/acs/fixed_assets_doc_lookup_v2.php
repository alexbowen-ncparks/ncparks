<?php
//if($level=="5" and $tempid !="Dodd3454"){echo "<pre>";print_r($_REQUEST);echo "</pre>";}//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}


//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$tempID=$_SESSION['budget']['tempID'];
//$posTitle=$_SESSION['budget']['position'];
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
*/
/*
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
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
include ("test_style_1314.php");
include("../../budget/menu1314.php");





echo "<html>";
echo "<head>";
/*
echo "<style>
body { background-color: #FFF8DC; }
table { background-color: #FFF8DC; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
</style>";
*/
?>


<style>
.fixed_assets {
  table-layout: fixed;
  width: 120%;
  
}




table td.wrapping {
  width: 15%;
  white-space: pre-wrap;
  
}


</style>


<?php






echo "</head>";

echo "<H1 ALIGN=LEFT > <font color=brown><i>Equipment Invoices-Lookup</font></i></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/menu.php?forum=blank> Budget-Home </A></font></H2>";
echo "<br />";
//if($level=="1"){$location=$pcode;}
if($level < '3' and $location==''){$location=$pcode;}


echo "<table>";
echo "<tr>";

//echo "<font size=5>"; 
echo "<th>Location</th><th>Center</th><th>Account</th>";
//echo "<th>CalYear</th>";
echo "<th>FiscalYear</th></tr>";
echo "<tr>";
echo "<form method='post' action='fixed_assets_doc_lookup_v2.php'>";
echo "<td><input name='location' type='text' value='$location'></td>";
echo "<td><input name='center' type='text' value='$center'></td>";
echo "<td><input name='account' type='text' value='$account' ></td>";
//echo "<td><input name='calyear' type='text' value='$calyear' ></td>";
echo "<td><input name='fiscalyear' type='text' value='$fiscalyear' ></td>";
echo "<td><input type='submit' name='submit' value='search'></td>";
echo "</form>";
echo "<td>";
echo "<form method='post' action='fixed_assets_doc_lookup_v2.php'>";
echo "<input type='hidden' name='center'  value=''>";
echo "<input type='hidden' name='location'  value=''>";
echo "<input type='hidden' name='account'  value=''>";
echo "<input type='hidden' name='calyear'  value='' >";
echo "<input type='submit' name='submit' value='reset'>";
echo "</td>"; 	  
echo "</tr>";
echo "</table>";

$header_var_location="&location=$location";
$header_var_center="&center=$center";
$header_var_account="&account=$account";
$header_var_calyear="&calyear=$calyear";
if($fiscalyear != '')
{
include("fixed_assets_doc_lookup_v2_header1.php");
}
/*
echo
"<form method='post' action='fixed_assets_doc_lookup_v2.php'>";
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
//$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
//$invoices_total=mysqli_num_rows($result1);


//echo "<H1 ALIGN=LEFT > <font color=brown>$admin_num</font></H1>";
//echo "<H2 ALIGN=LEFT > <font color=brown><i>Invoices for report date: $report_date must be Uploaded for Fixed Asset Reporting(PDF Format Only)</font></i></H2>";


/*

$query2="select id from pcard_unreconciled where admin_num='$admin_num' 
and report_date='$report_date'
and (ncasnum like '5345%' or ncasnum like '5346%' or ncasnum like '5347%')
and document_location != '' ";
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$invoices_uploaded=mysqli_num_rows($result2);
*/
if($submit==""){exit;}
if($submit=="reset"){exit;}

$fad="fixed_assets_doc_lookup_v2";

$fad_fields13="source,source_id,document_location,location,center,vendor_name,amount,ncasnum,trans_date,report_date,xtnd_start,xtnd_end,id";

$pcu="pcard_unreconciled";
		  
$pcu_fields13=" 'pcard',id,document_location,admin_num,center,vendor_name,amount,ncasnum,transdate_new,report_date,'','','' ";

$cvip="cid_vendor_invoice_payments";

$cvip_fields13dr=" 'cdcs',id,document_location,parkcode,ncas_center,vendor_name,sum(ncas_invoice_amount),
                  ncas_account,concat(mid(datesql,1,4),'-',mid(datesql,5,2),'-',mid(datesql,7,2)),'','','','' ";
				  
$cvip_fields13cr=" 'cdcs',id,document_location,parkcode,ncas_center,vendor_name,-sum(ncas_invoice_amount),
                  ncas_account,concat(mid(datesql,1,4),'-',mid(datesql,5,2),'-',mid(datesql,7,2)),'','','','' ";		  
				  
//comment 204 thru 290  5/14/15

/*
				  
$query2="DROP TABLE  `fixed_assets_doc_lookup_v2` " ;				  
				  
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");				  
				  

$query3="CREATE TABLE `fixed_assets_doc_lookup_v2` (
`location` varchar( 15 ) NOT NULL default '',
`source` varchar( 15 ) NOT NULL default '',
`source_id` varchar( 15 ) NOT NULL default '',
`vendor_name` varchar( 100 ) NOT NULL default '',
`amount` decimal( 12, 2 ) NOT NULL default '0.00',
`ncasnum` varchar( 15 ) NOT NULL default '',
`trans_date` varchar( 15 ) NOT NULL default '0000-00-00',
`document_location` varchar( 75 ) NOT NULL default '',
`center` varchar( 15 ) NOT NULL default '',
`calyear` varchar( 4 ) NOT NULL default '',
`report_date` date NOT NULL default '0000-00-00',
`xtnd_start` date NOT NULL default '0000-00-00',
`xtnd_end` date NOT NULL default '0000-00-00',
`item_purchased` varchar( 100 ) NOT NULL default '',
`fas_num` varchar( 20 ) NOT NULL default '',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` )
) ENGINE = MyISAM ;
";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$query3a="insert into $fad($fad_fields13)
          select $pcu_fields13 
		  from $pcu
		  where 1 and (ncasnum like '5345%' or ncasnum like '5346%' or ncasnum like '5347%')
		  and transdate_new >= '20090101' ";
          
$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query 3a.  $query3a");

$query3b="insert into $fad($fad_fields13)
          select $cvip_fields13dr 
		  from $cvip
		  where 1 and (ncas_account like '5345%' or ncas_account like '5346%' or ncas_account like '5347%')
		  and ncas_credit='' and dateSQL >= '20090101' group by id ";
          
$result3b = mysqli_query($connection, $query3b) or die ("Couldn't execute query 3b.  $query3b");

$query3c="insert into $fad($fad_fields13)
          select $cvip_fields13cr 
		  from $cvip
		  where 1 and (ncas_account like '5345%' or ncas_account like '5346%' or ncas_account like '5347%')
		  and ncas_credit ='x' and dateSQL >= '20090101' group by id ";
          
$result3c = mysqli_query($connection, $query3c) or die ("Couldn't execute query 3c.  $query3c");

$query3d="update $fad set calyear=mid(trans_date,1,4) where 1";
             
$result3d = mysqli_query($connection, $query3d) or die ("Couldn't execute query 3d.  $query3d");

$query3e="update $fad,pcard_report_dates 
          set fixed_assets_doc_lookup_v2.xtnd_start=pcard_report_dates.xtnd_start,
              fixed_assets_doc_lookup_v2.xtnd_end=pcard_report_dates.xtnd_end
          where fixed_assets_doc_lookup_v2.report_date=pcard_report_dates.report_date";
             
$result3e = mysqli_query($connection, $query3e) or die ("Couldn't execute query 3e.  $query3e");


$query3f="update $fad,pcard_unreconciled 
          SET fixed_assets_doc_lookup_v2.item_purchased = pcard_unreconciled.item_purchased, 
              fixed_assets_doc_lookup_v2.fas_num = pcard_unreconciled.fas_num 
		  WHERE fixed_assets_doc_lookup_v2.source = 'pcard' 
		  AND fixed_assets_doc_lookup_v2.source_id = pcard_unreconciled.id ";


$result3f = mysqli_query($connection, $query3f) or die ("Couldn't execute query 3f.  $query3f");



$query3f1="update $fad,cid_vendor_invoice_payments 
          SET fixed_assets_doc_lookup_v2.fas_num = cid_vendor_invoice_payments.fas_num 
          WHERE fixed_assets_doc_lookup_v2.source = 'cdcs' 
		  AND fixed_assets_doc_lookup_v2.source_id = cid_vendor_invoice_payments.id ";


$result3f1 = mysqli_query($connection, $query3f1) or die ("Couldn't execute query 3f1.  $query3f1");


*/

$query3f2="update fixed_assets_doc_lookup_v2,pcard_unreconciled
           set fixed_assets_doc_lookup_v2.system_entry_date=pcard_unreconciled.xtnd_rundate_new
		   where fixed_assets_doc_lookup_v2.source='pcard'
		   and fixed_assets_doc_lookup_v2.source_id=pcard_unreconciled.id";


$result3f2 = mysqli_query($connection, $query3f2) or die ("Couldn't execute query 3f2.  $query3f2");


$query3f3="update fixed_assets_doc_lookup_v2,cid_vendor_invoice_payments
           set fixed_assets_doc_lookup_v2.system_entry_date=cid_vendor_invoice_payments.system_entry_date
		   where fixed_assets_doc_lookup_v2.source='cdcs'
		   and fixed_assets_doc_lookup_v2.source_id=cid_vendor_invoice_payments.id";


$result3f3 = mysqli_query($connection, $query3f3) or die ("Couldn't execute query 3f3.  $query3f3");


$query3f4="update fixed_assets_doc_lookup_v2
           set calyear=mid(system_entry_date,1,4)
		   where 1 ";


$result3f4 = mysqli_query($connection, $query3f4) or die ("Couldn't execute query 3f4.  $query3f4");



$query3f5="update fixed_assets_doc_lookup_v2
           set calmonth=mid(system_entry_date,6,2)
		   where 1 ";


$result3f5 = mysqli_query($connection, $query3f5) or die ("Couldn't execute query 3f5.  $query3f5");


$query3f6="update fixed_assets_doc_lookup_v2
           set calday=mid(system_entry_date,9,2)
		   where 1 ";


$result3f6 = mysqli_query($connection, $query3f6) or die ("Couldn't execute query 3f6.  $query3f6");


$query3f7="update fixed_assets_doc_lookup_v2
set fiscalyear='1415'
where system_entry_date >= '20140701'
and system_entry_date <= '20150630' ";


$result3f7 = mysqli_query($connection, $query3f7) or die ("Couldn't execute query 3f7.  $query3f7");



/*

$query3b = "SHOW columns FROM $fad";
$result3b = mysqli_query($connection, $query3b);
$num=mysqli_num_rows($result3b);
echo "<H1><font color='blue'>Table=fixed_assets_doc_lookup_v2</font></H1>";
echo "<H1><font color='blue'>Fields=$num</font></H1>";
while($col=mysqli_fetch_array($result3b)){
$table_fields_array[]=$col[0];
}

echo "<table border=1>";
 
echo "<tr>"; 
    
 echo " <th><font color=blue>Field</font></th>";
  echo "</tr>";


for ($n=0;$n<$num;$n++){
echo "<form method='post' action='none'>";
//echo "<font size=10>"; 
if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}	
echo "<tr$t>";	      
	  	   
echo  "<td>$table_fields_array[$n]</td>";
	      

echo "<input type='hidden' name='tabname' value='none'>";
//echo "<input type='hidden' name='dbname' value='$dbname'>";
//echo  "<td><input type='submit' name='submit2' value='expand_tony'>";
echo   "</form>";
echo "</td>";
echo "</tr>";

}	 
echo "</table>";
*/
/*

$query3c="select $fields_dest from fixed_assets_doc_lookup_v2 where 1";

$result3c = mysqli_query($connection, $query3c) or die ("Couldn't execute query 3c.  $query3c");

$record_count=mysqli_num_rows($result3c);


*/

if($location != ""){$where1="and location = '$location' ";}
//if($level=="5" and $tempID !="Dodd3454"){echo "where1=$where1<br />";}

if($center != ""){$where2="and center = '$center' ";}
//if($level=="5" and $tempID !="Dodd3454"){echo "where2=$where2<br />";}

if($account != ''){$where3="and ncasnum = '$account' ";}
//if($level=="5" and $tempID !="Dodd3454"){echo "where3=$where3<br />";}

if($calyear != ''){$where4="and calyear = '$calyear' ";}
//if($level=="5" and $tempID !="Dodd3454"){echo "where4=$where4<br />";}

if($fiscalyear != ''){$where5="and fiscalyear = '$fiscalyear' ";}
//if($level=="5" and $tempID !="Dodd3454"){echo "where4=$where4<br />";}

if($calmonth != ''){$where6="and calmonth = '$calmonth' ";}
//if($level=="5" and $tempID !="Dodd3454"){echo "where4=$where4<br />";}





/*
if($fiscalyear == '0910'){$where5="and trans_date >= '2009-07-01' and trans_date <= '2010-06-30' ";}
if($fiscalyear == '1011'){$where5="and trans_date >= '2010-07-01' and trans_date <= '2011-06-30' ";}
if($fiscalyear == '1112'){$where5="and trans_date >= '2011-07-01' and trans_date <= '2012-06-30' ";}
if($fiscalyear == '1213'){$where5="and trans_date >= '2012-07-01' and trans_date <= '2013-06-30' ";}
if($fiscalyear == '1314'){$where5="and trans_date >= '2013-07-01' and trans_date <= '2014-06-30' ";}
if($fiscalyear == '1415'){$where5="and trans_date >= '2014-07-01' and trans_date <= '2015-06-30' ";}
if($fiscalyear == '1516'){$where5="and trans_date >= '2015-07-01' and trans_date <= '2016-06-30' ";}
if($fiscalyear == '1617'){$where5="and trans_date >= '2016-07-01' and trans_date <= '2017-06-30' ";}
if($fiscalyear == '1718'){$where5="and trans_date >= '2017-07-01' and trans_date <= '2018-06-30' ";}
if($fiscalyear == '1819'){$where5="and trans_date >= '2018-07-01' and trans_date <= '2019-06-30' ";}
if($fiscalyear == '1920'){$where5="and trans_date >= '2019-07-01' and trans_date <= '2020-06-30' ";}
if($fiscalyear == '2021'){$where5="and trans_date >= '2020-07-01' and trans_date <= '2021-06-30' ";}
if($fiscalyear == '2122'){$where5="and trans_date >= '2021-07-01' and trans_date <= '2022-06-30' ";}
if($fiscalyear == '2223'){$where5="and trans_date >= '2022-07-01' and trans_date <= '2023-06-30' ";}
if($fiscalyear == '2324'){$where5="and trans_date >= '2023-07-01' and trans_date <= '2024-06-30' ";}

*/


if(!isset($where1)){$where1="";}
if(!isset($where2)){$where2="";}
if(!isset($where3)){$where3="";}
if(!isset($where4)){$where4="";}
if(!isset($where5)){$where5="";}
if(!isset($where6)){$where6="";}

echo "fiscalyear=$fiscalyear<br />";

$query3g="select location,center,vendor_name,amount,ncasnum,item_purchased,fas_num,trans_date,system_entry_date,fiscalyear,document_location,source,source_id,report_date,xtnd_start,xtnd_end,id
          from $fad
		  where 1 $where1 $where2 $where3 $where4 $where5 $where6
		  order by system_entry_date desc";

echo "query3g=$query3g<br />"; 
		  
$result3g = mysqli_query($connection, $query3g) or die ("Couldn't execute query 3g.  $query3g");		  
		  
$record_count=mysqli_num_rows($result3g);

$query3h="select count(document_location) as 'doc_yes'
          from $fad
		  where 1 $where1 $where2 $where3 $where4 $where5 $where6
		  and document_location != ''
		  ";
		  
//echo "query3h=$query3h<br />";		  
		  
		  
$result3h = mysqli_query($connection, $query3h) or die ("Couldn't execute query 3h.  $query3h");
		  
$row3h=mysqli_fetch_array($result3h);

extract($row3h);
/*
if($level=="5" and $tempID !="Dodd3454"){
echo "doc_yes=$doc_yes<br />";}
*/
$query3i="select count(document_location) as 'doc_no'
          from $fad
		  where 1 $where1 $where2 $where3 $where4 $where5 $where6
		  and document_location = ''
		  ";
		  
//echo "query3i=$query3i<br />";		  
		  
		  
$result3i = mysqli_query($connection, $query3i) or die ("Couldn't execute query 3i.  $query3i");
		  
$row3i=mysqli_fetch_array($result3i);

extract($row3i);
/*
if($level=="5" and $tempID !="Dodd3454"){
echo "doc_no=$doc_no<br />";}
*/	

		  
//if($level=="5" and $tempID !="Dodd3454"){echo "Query3g=$query3g";}		  

echo "<h2><font color='red'>Equipment Invoice Payments-$record_count</font></h2>";	


echo "<table border=1><tr><th>Documents</th><th>Count</th></tr>
              <tr bgcolor='lightgreen'><td>yes</td><td>$doc_yes</td></tr>
              <tr bgcolor='lightpink'><td>no</td><td>$doc_no</td></tr>
	   </table><br />";


   
echo "<table  class='fixed_assets' border=1>";
 
echo "<tr>"; 

 

 
  echo " <td><font color=blue>location</font></td>"; 
 echo " <td><font color=blue>center</font></td>"; 
 echo " <td class='wrapping'><font color=blue>vendor_name</font></td>";
 echo " <td><font color=blue>amount</font></td>";
 echo " <td><font color=blue>account</font></td>";
 echo " <td class='wrapping'><font color=blue>item_purchased</font></td>";
 echo " <td><font color=blue>fas#</font></td>";
  echo " <td><font color=blue>trans_date</font></td>";
  echo " <td><font color=blue>enter_date</font></td>";
echo " <td><font color=blue>fiscal<br />year</font></td>";
 echo " <td><font color=blue>invoice<br />document</font></td>";
 echo " <td><font color=blue>source</font></td>";
 echo " <td><font color=blue>source_id</font></td>";
 //echo " <td><font color=blue>id</font></td>";
  echo "</tr>";
//echo  "<form method='post' autocomplete='off' action='stepH9b_update_all.php'>";

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if(@$status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if(@$status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row3g=mysqli_fetch_array($result3g)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3g);

if($document_location != ""){$document="yes";} else {$document="";}
if($document_location != ""){$bgc="lightgreen";} else {$bgc="lightpink";}


//echo "document_location=$document_location";
//echo "<br />";
//echo "document=$document";


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
   
//echo "<form method=post action=stepG5_update.php>";	
 echo "<tr bgcolor='$bgc'>";  
echo  "<td>$location</td>";
echo  "<td>$center</td>";
echo  "<td class='wrapping'>$vendor_name</td>";

if($amount < "0"){echo  "<td><font color='red'>$amount</font></td>";}
else{echo "<td>$amount</td>";}

echo  "<td>$ncasnum</td>";
echo  "<td class='wrapping'>$item_purchased</td>";
echo  "<td>$fas_num</td>";
echo  "<td>$trans_date</td>";
echo  "<td>$system_entry_date</td>";
echo  "<td>$fiscalyear</td>";

if($document=="yes"){
echo "<td><a href='$document_location' target='_blank'>View</a></td>";}

if($document!="yes"){
echo "<td><a href='fixed_assets_document_add.php?source=$source&source_id=$source_id$header_var_location$header_var_center$header_var_account$header_var_calyear' target='_blank'>Upload</a></td>";}


if($source=="cdcs"){
echo  "<td><a href='acs.php?id=$source_id&m=invoices' target='_blank'>$source</a></td>";}

if($source=="pcard"){
echo  "<td><a href='pcard_recon.php?report_date=$report_date&xtnd_start=$xtnd_start&xtnd_end=$xtnd_end&admin_num=$location&submit=Find' target='_blank'>$source</a></td>";}


//if($document!="yes")
//{echo "<td>$source</td>";}



echo  "<td>$source_id</td>";


//echo  "<td>$id</td>";

//echo  "<td><a href='pcard_fixed_assets_document_add.php?id=$id&load_doc=y&report_date=$report_date&admin_num=$admin_num'>Upload Invoice</a></td>";
  
echo "</tr>";
//$document='';
}
echo "</table>";
/*



$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query 3a.  $query3a");
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
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$invoices_remaining=mysqli_num_rows($result4);
//echo $num3;exit;
//////mysql_close();
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
//while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row4=mysqli_fetch_array($result4)){

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

























