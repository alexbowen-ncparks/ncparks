<?php
//if($level=="5" and $tempid !="Dodd3454"){echo "<pre>";print_r($_REQUEST);echo "</pre>";}//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
$level=$_SESSION['budget']['level'];
$tempID=$_SESSION['budget']['tempID'];
$posTitle=$_SESSION['budget']['position'];
$beacon_num=$_SESSION['budget']['beacon_num'];
$pcode=$_SESSION['budget']['select'];
$centerSess=$_SESSION['budget']['centerSess'];
//echo $tempid;
extract($_REQUEST);
$menu_fa='fa2';
$source_table='fixed_assets';
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
mysqli_select_db($connection,$database); // database
include("../../../include/activity_new.php");// database connection parameters
include("../../budget/~f_year.php");


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
$( \"#datepicker2\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker3\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker4\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker5\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker6\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker7\" ).datepicker({dateFormat: 'yy-mm-dd'});
});
</script>";


echo "<script language='JavaScript'>

function confirmLink()
{
 bConfirm=confirm('WARNING!!! Are you sure you want to delete this Record?')
 return (bConfirm);
}


";
echo "</script>";



echo "</head>";


//include("1418.html");
echo "<style>";
//echo "input[type='text'] {width: 200px;}";

echo "</style>";

//echo "<br />";

include ("../../budget/menu1415_v1_new.php");
echo "<br />";
include("fixed_assets_menu.php");
echo "<br />";




echo "<H1 ALIGN=center > <font color=brown><i>FAS Invoice Lookup</font></i></H1>";
//echo "<H2 ALIGN=center><font size=4><b><A href=/budget/menu.php?forum=blank> Budget-Home </A></font></H2>";
echo "<br />";
//if($level=="1"){$location=$pcode;}
if($level < '3' and $location==''){$location=$pcode;}


echo "<table align='center'>";
echo "<tr>";

//echo "<font size=5>"; 
echo "<th>Location</th><th>Center</th><th>Account</th><th>CalYear</th><th>FiscalYear</th></tr>";
echo "<tr>";
echo "<form method='post' action='fixed_assets_doc_lookup.php'>";
echo "<td><input name='location' type='text' value='$location'></td>";
echo "<td><input name='center' type='text' value='$center'></td>";
echo "<td><input name='account' type='text' value='$account' ></td>";
echo "<td><input name='calyear' type='text' value='$calyear' ></td>";
echo "<td><input name='fiscalyear' type='text' value='$fiscalyear' ></td>";
echo "<td><input type='submit' name='submit' value='search'></td>";
echo "</form>";
echo "<td>";
echo "<form method='post' action='fixed_assets_doc_lookup.php'>";
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



if($submit==""){exit;}
if($submit=="reset"){exit;}

$fad="fixed_assets_doc_lookup";

$fad_fields13="source,source_id,document_location,location,center,vendor_name,amount,ncasnum,trans_date,report_date,xtnd_start,xtnd_end,id";

$pcu="pcard_unreconciled";
		  
$pcu_fields13=" 'pcard',id,document_location,admin_num,center,vendor_name,amount,ncasnum,transdate_new,report_date,'','','' ";

$cvip="cid_vendor_invoice_payments";

$cvip_fields13dr=" 'cdcs',id,document_location,parkcode,ncas_center,vendor_name,sum(ncas_invoice_amount),
                  ncas_account,concat(mid(datesql,1,4),'-',mid(datesql,5,2),'-',mid(datesql,7,2)),'','','','' ";
				  
$cvip_fields13cr=" 'cdcs',id,document_location,parkcode,ncas_center,vendor_name,-sum(ncas_invoice_amount),
                  ncas_account,concat(mid(datesql,1,4),'-',mid(datesql,5,2),'-',mid(datesql,7,2)),'','','','' ";		  
				  

/*
$query3="CREATE  temporary TABLE `fixed_assets_doc_lookup` (
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
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
PRIMARY KEY ( `id` )
) ENGINE = MyISAM ;
";

$result3=mysqli_query($connection,$query3) or die ("Couldn't execute query 3. $query3");
*/


$query3="truncate table fixed_assets_doc_lookup";

$result3=mysqli_query($connection,$query3) or die ("Couldn't execute query 3. $query3");
















$query3a="insert into $fad($fad_fields13)
          select $pcu_fields13 
		  from $pcu
		  where 1 and (ncasnum like '5345%' or ncasnum like '5346%' or ncasnum like '5347%')
		  and transdate_new >= '20090101' ";
          
$result3a=mysqli_query($connection,$query3a) or die ("Couldn't execute query 3a. $query3a");

$query3b="insert into $fad($fad_fields13)
          select $cvip_fields13dr 
		  from $cvip
		  where 1 and (ncas_account like '5345%' or ncas_account like '5346%' or ncas_account like '5347%')
		  and ncas_credit='' and dateSQL >= '20090101' group by id ";
          
$result3b=mysqli_query($connection,$query3b) or die ("Couldn't execute query 3b. $query3b");

$query3c="insert into $fad($fad_fields13)
          select $cvip_fields13cr 
		  from $cvip
		  where 1 and (ncas_account like '5345%' or ncas_account like '5346%' or ncas_account like '5347%')
		  and ncas_credit ='x' and dateSQL >= '20090101' group by id ";
          
$result3c=mysqli_query($connection,$query3c) or die ("Couldn't execute query 3c. $query3c");

$query3d="update $fad set calyear=mid(trans_date,1,4) where 1";
             
$result3d=mysqli_query($connection,$query3d) or die ("Couldn't execute query 3d. $query3d");

$query3e="update $fad,pcard_report_dates 
          set fixed_assets_doc_lookup.xtnd_start=pcard_report_dates.xtnd_start,
              fixed_assets_doc_lookup.xtnd_end=pcard_report_dates.xtnd_end
          where fixed_assets_doc_lookup.report_date=pcard_report_dates.report_date";
             
$result3e=mysqli_query($connection,$query3e) or die ("Couldn't execute query 3e. $query3e");


$query3f="update $fad,pcard_unreconciled 
          SET fixed_assets_doc_lookup.item_purchased = pcard_unreconciled.item_purchased 
		  WHERE fixed_assets_doc_lookup.source = 'pcard' 
		  AND fixed_assets_doc_lookup.source_id = pcard_unreconciled.id ";


$result3f=mysqli_query($connection,$query3f) or die ("Couldn't execute query 3f. $query3f");



if($location != ""){$where1="and location = '$location' ";}
//if($level=="5" and $tempID !="Dodd3454"){echo "where1=$where1<br />";}

if($center != ""){$where2="and center = '$center' ";}
//if($level=="5" and $tempID !="Dodd3454"){echo "where2=$where2<br />";}

if($account != ''){$where3="and ncasnum = '$account' ";}
//if($level=="5" and $tempID !="Dodd3454"){echo "where3=$where3<br />";}

if($calyear != ''){$where4="and calyear = '$calyear' ";}
//if($level=="5" and $tempID !="Dodd3454"){echo "where4=$where4<br />";}
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

if(!isset($where1)){$where1="";}
if(!isset($where2)){$where2="";}
if(!isset($where3)){$where3="";}
if(!isset($where4)){$where4="";}
if(!isset($where5)){$where5="";}

echo "fiscalyear=$fiscalyear<br />";

$query3g="select location,center,vendor_name,amount,ncasnum,item_purchased,trans_date,calyear,document_location,source,source_id,report_date,xtnd_start,xtnd_end,id
          from $fad
		  where 1 $where1 $where2 $where3 $where4 $where5
		  order by trans_date desc";

echo "query3g=$query3g";
//echo "<br />"; 
//exit;
		  
$result3g=mysqli_query($connection,$query3g) or die ("Couldn't execute query 3g. $query3g"); 
		  
$record_count=mysqli_num_rows($result3g);

$query3h="select count(document_location) as 'doc_yes'
          from $fad
		  where 1 $where1 $where2 $where3 $where4 $where5
		  and document_location != ''
		  ";
		  
//echo "query3h=$query3h<br />";		  
		  
		  
$result3h=mysqli_query($connection,$query3h) or die ("Couldn't execute query 3h. $query3h");
		  
$row3h=mysqli_fetch_array($result3h);

extract($row3h);
/*
if($level=="5" and $tempID !="Dodd3454"){
echo "doc_yes=$doc_yes<br />";}
*/
$query3i="select count(document_location) as 'doc_no'
          from $fad
		  where 1 $where1 $where2 $where3 $where4 $where5
		  and document_location = ''
		  ";
		  
//echo "query3i=$query3i<br />";		  
		  
		  
$result3i=mysqli_query($connection,$query3i) or die ("Couldn't execute query 3i. $query3i");
		  
$row3i=mysqli_fetch_array($result3i);

extract($row3i);
/*
if($level=="5" and $tempID !="Dodd3454"){
echo "doc_no=$doc_no<br />";}
*/	
//$doc_no=1;
		  
//if($level=="5" and $tempID !="Dodd3454"){echo "Query3g=$query3g";}		  

//echo "<h2><font color='red'>Equipment Invoice Payments-$record_count</font></h2>";	


echo "<table align='center'>";
//echo "<tr><th>Documents</th><th>Count</th></tr>";
echo "<tr><th>Documents</th></tr>";
echo "<tr bgcolor='lightgreen'><td>yes-$doc_yes</td><</tr>";
if($doc_no > 0)
{
echo "<tr bgcolor='lightpink'><td>no-$doc_no</td><</tr>";
}
echo "</table>";
echo "<br />";


   
//echo "<table  class='fixed_assets' border=1>";
echo "<table  align='center' >";
 
echo "<tr>"; 

 

 
  echo " <td><font color=blue>location</font></td>"; 
 echo " <td><font color=blue>center</font></td>"; 
 echo " <td class='wrapping'><font color=blue>vendor_name</font></td>";
 echo " <td><font color=blue>amount</font></td>";
 echo " <td><font color=blue>account</font></td>";
 echo " <td class='wrapping'><font color=blue>item_purchased</font></td>";
 echo " <td><font color=blue>trans_date</font></td>";
 echo " <td><font color=blue>calyear</font></td>";
 echo " <td><font color=blue>invoice</font></td>";
 echo " <td><font color=blue>source</font></td>";
 
 //echo " <td><font color=blue>fas form</font></td>";
 
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
echo  "<td>$trans_date</td>";
echo  "<td>$calyear</td>";

if($document=="yes"){
echo "<td><a href='$document_location' target='_blank'>View</a></td>";}

if($document!="yes"){
echo "<td><a href='fixed_assets_document_add.php?source=$source&source_id=$source_id$header_var_location$header_var_center$header_var_account$header_var_calyear' target='_blank'>Upload</a></td>";}




if($source=="cdcs"){
echo  "<td><a href='acs.php?id=$source_id&m=invoices' target='_blank'>$source</a></td>";}

if($source=="pcard"){
echo  "<td><a href='pcard_recon.php?report_date=$report_date&xtnd_start=$xtnd_start&xtnd_end=$xtnd_end&admin_num=$location&submit=Find' target='_blank'>$source</a></td>";}







//echo "<td>fas form</td>";



//if($document!="yes")
//{echo "<td>$source</td>";}



echo  "<td>$source_id</td>";


//echo  "<td>$id</td>";

//echo  "<td><a href='pcard_fixed_assets_document_add.php?id=$id&load_doc=y&report_date=$report_date&admin_num=$admin_num'>Upload Invoice</a></td>";
  
echo "</tr>";
//$document='';
}
echo "</table>";

echo "</html>";
?>

























