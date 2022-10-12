<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

include("../../../../include/connectBUDGET.inc");// database connection parameters
include("../../../../include/activity.php");// database connection parameters
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

//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>Budget Totals for Fiscal Year:$fiscal_year</font></i></H1>";

/*

echo "<br />";
$query3="select 
center.company,
pcard_extract_worksheet.acct,
coa.park_acct_desc as 'account_description',
pcard_extract_worksheet.center,
pcard_extract_worksheet.calendar_acctdate,
pcard_extract_worksheet.amount,
pcard_extract_worksheet.sign,
pcard_extract_worksheet.pcard_trans_id,
pcard_extract_worksheet.transid_verified,
pcard_extract_worksheet.denr_paid,
pcard_extract_worksheet.id
from pcard_extract_worksheet
left join center on pcard_extract_worksheet.center=center.center
left join coa on pcard_extract_worksheet.acct=coa.ncasnum
where pcard_trans_id=''
and denr_paid != 'y'
order by pcard_extract_worksheet.center,
pcard_extract_worksheet.amount,
pcard_extract_worksheet.sign;
";
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
//echo $num3;exit;
//////mysql_close();
echo "<H3><font color=red>Record Count=$num3</font></H3>";
echo "<table border=1>";
 
echo "<tr>"; 
    
 echo " <th><font color=blue>Company</font></th>";
 echo " <th><font color=blue>Account</font></th>";
 echo " <th><font color=blue>Account_Description</font></th>";
 echo " <th><font color=blue>Center</font></th>";
 echo " <th><font color=blue>PostDate</font></th>";
 echo " <th><font color=blue>Amount</font></th>";
 echo " <th><font color=blue>Sign</font></th>";
 echo " <th><font color=blue>Pcard_transid</font></th>";
 //echo " <th><font color=blue>Transid verified</font></th>";
 echo " <th><font color=blue>DENR Paid</font></th>";
 echo " <th><font color=blue>Id</font></th>";           
//echo " <th><font color=blue>Complete</font></th>";           
//echo " <th><font color=blue>Complete2</font></th>";           
// echo " <th><font color=blue>Action</font></th>";           
  
echo "</tr>";
echo  "<form method='post' autocomplete='off' action='stepG8a_update_all.php'>";

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
echo  "<td>$company</td>";
echo  "<td>$acct</td>";
echo  "<td>$account_description</td>";
echo  "<td>$center</td>";
echo  "<td>$calendar_acctdate</td>";
echo  "<td>$amount</td>";
echo  "<td>$sign</td>";
echo  "<td><input type='text' size='10'  name='pcard_trans_id[]' value='$pcard_trans_id'</td>";
//echo  "<td><input type='text' size='10' name='transid_verified[]' value='$transid_verified'</td>";
echo  "<td>$denr_paid</td>";
echo  "<td><input type='text' size='3' readonly='readonly' name='id[]' value='$id'</td>";
  
echo "</tr>";

}

echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='hidden' name='step_name' value='$step_name'>
	   <input type='hidden' name='num3' value='$num3'>";
echo   "</form>";	 
echo "</table>";
	

echo "</html>";

*/

?>

























