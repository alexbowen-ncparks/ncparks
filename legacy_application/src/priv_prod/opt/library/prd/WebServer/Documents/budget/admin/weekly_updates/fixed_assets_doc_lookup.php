<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);

//$report_date="2011-01-21";
//$admin_num="foma";
//$report_date=str_replace("-","",$report_date);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

include("../../../include/connectBUDGET.inc");// database connection parameters
include("../../../include/activity.php");// database connection parameters
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

echo "<H1 ALIGN=LEFT > <font color=brown><i>Equipment Invoices-Lookup</font></i></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/menu.php?forum=blank> Return HOME </A></font></H2>";
echo "<br />";

echo "<table>";
echo "<tr>";
echo
"<form method='post' action='fixed_assets_doc_lookup.php'>";
//echo "<font size=5>"; 
echo "<td>Location</td><td>Account</td><td>CalYear</td></tr>";
echo "<tr>";
echo "<td><input name='location' type='text' value='$location'></td>";
echo "<td><input name='account' type='text' value='$account' ></td>";
echo "<td><input type='submit' name='submit' value='search'></td>";
echo "</form>";

echo
"<form method='post' action='fixed_assets_doc_lookup.php'>";
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

$fad="fixed_assets_doc_lookup";

$fad_fields10="source,source_id,document_location,location,center,vendor_name,amount,ncasnum,trans_date,id";

$pcu="pcard_unreconciled";
		  
$pcu_fields10=" 'pcard',id,document_location,admin_num,center,vendor_name,amount,ncasnum,transdate_new,'' ";

$cvip="cid_vendor_invoice_payments";

$cvip_fields10dr=" 'cdcs',id,document_location,parkcode,ncas_center,vendor_name,sum(ncas_invoice_amount),
                  ncas_account,concat(mid(datesql,1,4),'-',mid(datesql,5,2),'-',mid(datesql,7,2)),'' ";
				  
$cvip_fields10cr=" 'cdcs',id,document_location,parkcode,ncas_center,vendor_name,-sum(ncas_invoice_amount),
                  ncas_account,concat(mid(datesql,1,4),'-',mid(datesql,5,2),'-',mid(datesql,7,2)),'' ";		  
				  


$query3="truncate table $fad";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$query3a="insert into $fad($fad_fields10)
          select $pcu_fields10 
		  from $pcu
		  where 1 and (ncasnum like '5345%' or ncasnum like '5346%' or ncasnum like '5347%')";
          
$result3a = mysqli_query($connection, $query3a) or die ("Couldn't execute query 3a.  $query3a");

$query3b="insert into $fad($fad_fields10)
          select $cvip_fields10dr 
		  from $cvip
		  where 1 and (ncas_account like '5345%' or ncas_account like '5346%' or ncas_account like '5347%')
		  and ncas_credit='' group by id ";
          
$result3b = mysqli_query($connection, $query3b) or die ("Couldn't execute query 3b.  $query3b");

$query3c="insert into $fad($fad_fields10)
          select $cvip_fields10cr 
		  from $cvip
		  where 1 and (ncas_account like '5345%' or ncas_account like '5346%' or ncas_account like '5347%')
		  and ncas_credit ='x' group by id ";
          
$result3c = mysqli_query($connection, $query3c) or die ("Couldn't execute query 3c.  $query3c");

/*

$query3b = "SHOW columns FROM $fad";
$result3b = mysqli_query($connection, $query3b);
$num=mysqli_num_rows($result3b);
echo "<H1><font color='blue'>Table=fixed_assets_doc_lookup</font></H1>";
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

$query3c="select $fields_dest from fixed_assets_doc_lookup where 1";

$result3c = mysqli_query($connection, $query3c) or die ("Couldn't execute query 3c.  $query3c");

$record_count=mysqli_num_rows($result3c);
*/

if($time_period_start != ""){$where1="and trans_date >= '$time_period_start' ";}
if($level=="5"){echo "where1=$where1<br />";}

if($time_period_end != ""){$where2="and trans_date <= '$time_period_end' ";}
if($level=="5"){echo "where2=$where2<br />";}

if($account != ''){$where3="and ncasnum = '$account' ";}
if($level=="5"){echo "where3=$where3<br />";}

if($location != ""){$where4="and location = '$location' ";}
if($level=="5"){echo "where4=$where4<br />";}




$query3c="select source,source_id,document_location,location,center,vendor_name,amount,ncasnum,trans_date,id
          from $fad
		  where 1 $where1 $where2 $where3 $where4
		  order by trans_date desc";
		  
$result3c = mysqli_query($connection, $query3c) or die ("Couldn't execute query 3c.  $query3c");		  
		  
$record_count=mysqli_num_rows($result3c);		  
		  
echo "Query3c=$query3c";		  

echo "<h2><font color='red'>Fixed Asset Invoice Payments-$record_count</font></h2>";	   
echo "<table border=1>";
 
echo "<tr>"; 

  
 echo " <th><font color=blue>source</font></th>";
 echo " <th><font color=blue>source_id</font></th>";
 echo " <th><font color=blue>document_location</font></th>";
 echo " <th><font color=blue>location</font></th>"; 
 echo " <th><font color=blue>center</font></th>"; 
 echo " <th><font color=blue>vendor_name</font></th>";
 echo " <th><font color=blue>amount</font></th>";
 echo " <th><font color=blue>ncasnum</font></th>";
 echo " <th><font color=blue>trans_date</font></th>";
 echo " <th><font color=blue>id</font></th>";
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
while ($row3c=mysqli_fetch_array($result3c)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3c);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
   
//echo "<form method=post action=stepG5_update.php>";	
 echo "<tr bgcolor='#B4CDCD'>";  
echo  "<td>$source</td>";
echo  "<td>$source_id</td>";
//echo  "<td>$document_location</td>";
echo "<td><a href='$document_location' target='_blank'>$document_location</a></td>";
echo  "<td>$location</td>";
echo  "<td>$center</td>";
echo  "<td>$vendor_name</td>";

if($amount < "0"){echo  "<td><font color='red'>$amount</font></td>";}
else{echo "<td>$amount</td>";}

echo  "<td>$ncasnum</td>";
echo  "<td>$trans_date</td>";
echo  "<td>$id</td>";

//echo  "<td><a href='pcard_fixed_assets_document_add.php?id=$id&load_doc=y&report_date=$report_date&admin_num=$admin_num'>Upload Invoice</a></td>";
  
echo "</tr>";

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
?>

























