<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

include("../../../../include/connectBUDGET.inc");// database connection parameters


echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>
	


</head>";

//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-StepGroup $step_group-$step</font></i></H1>";
echo "<H3 ALIGN=LEFT > <font color=blue>StepName-$step_name</font></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates> Return Weekly Updates-HOME </A></font></H2>";
echo "<H2 ALIGN=center>"; 
//echo  "<form method='post' action='stepG5_update_all.php'>";
//echo "<input type='submit' name='submit2' value='UpdateAllRecords'>";
//echo   "</form>";
echo "</H3>";

/*<font color=blue>StepName-$step_name</font></H1>";
echo "<br />";
echo
"<form>";
echo "<font size=5>"; 
echo "fiscal_year:<input name='fiscal_year' type='text' value='$fiscal_year' readonly='readonly'>";
echo "<br />";
echo "start_date:<input name='start_date' type='text' value='$start_date' readonly='readonly'>";
echo "<br />";
echo "end_date:<input name='end_date' type='text' value='$end_date' readonly='readonly'>";
//echo "today_date:<input name='today_date'";  echo "type='text'"; echo "value= date('Y-m-d')"; echo "readonly='readonly'>";
echo "</form>";
*/
echo "<br />";


$query3="select 
center.company,
pcard_extract_worksheet.acct,
pcard_extract_worksheet.center,
pcard_extract_worksheet.calendar_acctdate,
pcard_extract_worksheet.amount,
pcard_extract_worksheet.sign,
pcard_extract_worksheet.pcard_trans_id,
pcard_extract_worksheet.transid_verified,
pcard_extract_worksheet.id
from pcard_extract_worksheet
left join center on pcard_extract_worksheet.center=center.center
where correction='m'
and denr_paid != 'y'
order by pcard_extract_worksheet.center,
pcard_extract_worksheet.amount,
pcard_extract_worksheet.sign;
";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
//echo $num3;exit;
//////mysql_close();

echo "<table border=1>";
 
echo "<tr>"; 
    
 echo " <th><font color=blue>Company</font></th>";
 echo " <th><font color=blue>Account</font></th>";
 echo " <th><font color=blue>Center</font></th>";
 echo " <th><font color=blue>PostDate</font></th>";
 echo " <th><font color=blue>Amount</font></th>";
 echo " <th><font color=blue>Sign</font></th>";
 echo " <th><font color=blue>Pcard_transid</font></th>";
 echo " <th><font color=blue>Transid_verified</font></th>";
 echo " <th><font color=blue>Id</font></th>";           
// echo " <th><font color=blue>Action</font></th>";           
       
 

echo "</tr>";
echo  "<form method='post' action='stepG5_update_all.php'>";
//exit;
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$row3=mysqli_fetch_array($result3);
//extract($row3);$companyarray[]=$company;$acctarray[]=$acct;$centerarray[]=$center;
//$calendar_acctdatearray[]=$calendar_acctdate;$amountarray[]=$amount;$signarray[]=$sign;
//$pcard_trans_idarray[]=$pcard_trans_id;$transid_verifiedarray[]=$transid_verified;
//$idarray[]=$id;}
// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);$idarray[]=$id;$pcard_trans_idarray[]=$pcard_trans_id;$transid_verifiedarray[]=$transid_verified;
//extract($row3);

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
echo "<tr$t>";	      
//echo "<form method=post action=stepG5_update.php>";	   
echo  "<td><input type='text' size='10 name='company[]' value='$company'</td>";
echo  "<td><input type='text' size='10' name='acct[]' value='$acct'</td>";
echo  "<td><input type='text' size='10' name='center[]' value='$center'</td>";
echo  "<td><input type='text' size='10' name='calendar_acctdate[]' value='$calendar_acctdate'</td>";
echo  "<td><input type='text' size='10' name='amount[]' value='$amount'</td>";
echo  "<td><input type='text' size='10' name='sign[]' value='$sign'</td>";
echo  "<td><input type='text' size='10' name='pcard_trans_id[]' value='$pcard_trans_id'</td>";
echo  "<td><input type='text' size='10' name='transid_verified[]' value='$transid_verified'</td>";
echo  "<td><input type='text' size='10' name='id[]' value='$id'</td>";
   
	      
echo "</tr>";

}

echo "<tr><td colspan='1' align='right'><input type='submit' name='submit2' value='UpdateAllRecords'></td></tr>";
echo   "</form>";	 
echo "</table>";
	

echo "</html>";

?>

























