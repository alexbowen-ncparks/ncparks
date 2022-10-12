<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$tempid_pcard=$tempid;
//echo $tempid;
extract($_REQUEST);

//$report_date="2011-01-21";
//$admin_num="foma";
//$report_date=str_replace("-","",$report_date);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
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

if($load_doc==''){

if($tempid_pcard!='Dillard6097')
{	
$query1="select id from pcard_unreconciled where admin_num='$admin_num' 
and report_date='$report_date'
and (ncasnum like '5345%' or ncasnum like '5346%' or ncasnum like '5347%')
";
}

/*
if($tempid_pcard=='Dillard6097')
{	
$query1="select id from pcard_unreconciled where admin_num='$admin_num' 
and report_date='$report_date'
";
}
*/

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
$invoices_total=mysqli_num_rows($result1);


echo "<H1 ALIGN=LEFT > <font color=brown>$admin_num</font></H1>";
echo "<H2 ALIGN=LEFT > <font color=brown><i>$invoices_total Invoice(s) for report date: $report_date must be Uploaded for Fixed Asset Reporting(PDF Format)</font></i></H2>";



//if($tempid_pcard!='Dillard6097')
{
$query2="select id from pcard_unreconciled where admin_num='$admin_num' 
and report_date='$report_date'
and (ncasnum like '5345%' or ncasnum like '5346%' or ncasnum like '5347%')
and document_location != '' ";
}

/*
if($tempid_pcard=='Dillard6097')
{
$query2="select id from pcard_unreconciled where admin_num='$admin_num' 
and report_date='$report_date'
and document_location != '' ";
}
*/

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$invoices_uploaded=mysqli_num_rows($result2);

//if($tempid_pcard!='Dillard6097')
{	
$query3="
select 
id,vendor_name,amount,ncasnum
from pcard_unreconciled
where admin_num='$admin_num'
and report_date='$report_date'
and (ncasnum like '5345%' or ncasnum like '5346%' or ncasnum like '5347%')
and document_location = ''
order by vendor_name,amount,ncasnum
";
}

/*
if($tempid_pcard=='Dillard6097')
{	
$query3="
select 
id,vendor_name,amount,ncasnum
from pcard_unreconciled
where admin_num='$admin_num'
and report_date='$report_date'
and document_location = ''
order by vendor_name,amount,ncasnum
";
}
*/




$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$invoices_remaining=mysqli_num_rows($result3);
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
while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);


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
echo "<input type='hidden' name='load_one' value='$load_one'>";
echo "<input type='hidden' name='xtnd_start' value='$xtnd_start'>";
echo "<input type='hidden' name='xtnd_end' value='$xtnd_end'>";

echo "<br /> <br />";
echo "<input type='submit' value='add_document' name='submit'>";
echo "</form>";
echo "</body>";

}

?>