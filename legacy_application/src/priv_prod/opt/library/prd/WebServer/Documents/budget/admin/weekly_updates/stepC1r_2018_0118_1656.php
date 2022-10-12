<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters

echo "<html>";
echo "<head>";
echo "<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>";
	


echo "</head>";
if($submit='ADD'){echo "Line 31: query to update COA";}
//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";

echo "<br /><br />";


$query3="select account,account_description 
         from exp_rev_dncr_temp_part2_dpr
		 where valid_account='' and valid_account_dpr='n'
         order by account limit 1 ";

echo "<br />Query3=$query3<br />";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysql_query($query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysql_num_rows($result3);
$row3=mysql_fetch_array($result3);
extract($row3);//brings back max (end_date) as $end_date
$account_first4=substr($account,0,4);




$query4="select ncasnum,description,park_acct_desc,acct_cat,cash_type,track_rcc,series,valid_cdcs,valid_osc,valid_div,valid_ci,valid_1280,budget_group,ncasnum2
from coa where ncasnum like '$account_first4%'  ";

echo "<br />Query4=$query4<br />";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result4 = mysql_query($query4) or die ("Couldn't execute query 4.  $query4");

//mysql_close();

echo "<table align='center'>";
echo "<tr><th><font color='red'>XTND Download includes Accounts which are are not located in MoneyCounts. Please ADD Account Below. Thanks</font></th></tr>";
echo "</table>";
echo "<br />";
echo "<table border=1>";
 
echo "<tr>"; 
echo "<th>Account</th>";      
echo "<th>Account Description per XTND</th>";      
echo "<th>Account Description<br >per MoneyCounts</th>";      
echo "<th>Account<br />Category</th>";      
echo "<th>Cash Type</th>";      
echo "<th>Track RCC</th>";      
echo "<th>Series</th>";      
echo "<th>Valid CDCS</th>";      
echo "<th>Valid OSC</th>";      
echo "<th>Valid Div</th>";      
echo "<th>Valid CI</th>";      
echo "<th>Valid 1280</th>";      
echo "<th>Budget Group</th>";      
echo "<th>Account2</th>";      
 
       
     
echo "</tr>";

echo "<tr>";

echo "<td>$account</td>";
echo "<td>$account_description</td>";


echo "<form>";
echo "<td><input type='text' name='park_acct_descF' size='45'></td>";
echo "<td><input type='text' name='acct_catF' size='2'></td>";
echo "<td><input type='text' name='cash_typeF' size='8'></td>";
echo "<td><input type='text' name='track_rccF' size='1'></td>";
echo "<td><input type='text' name='seriesF' size='5'></td>";
echo "<td><input type='text' name='valid_cdcsF' size='1'></td>";
echo "<td><input type='text' name='valid_oscF' size='1'></td>";
echo "<td><input type='text' name='valid_divF' size='1'></td>";
echo "<td><input type='text' name='valid_ciF' size='1'></td>";
echo "<td><input type='text' name='valid_1280F' size='1'></td>";
echo "<td><input type='text' name='budget_groupF' size='22'></td>";
echo "<td><input type='text' name='ncasnum2F' size='10'></td>";
echo "<td><input type='submit' name='submit' value='ADD' ></td>";
echo "</tr>";
echo "</form>";


// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
while ($row4=mysql_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);
//echo $status;

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}

//echo $status;


echo "<tr$t>";	
echo "<td>$ncasnum</td>";      
echo "<td>$description</td>";      
echo "<td>$park_acct_desc</td>";      
echo "<td>$acct_cat</td>";      
echo "<td>$cash_type</td>";      
echo "<td>$track_rcc</td>";      
echo "<td>$series</td>";      
echo "<td>$valid_cdcs</td>";      
echo "<td>$valid_osc</td>";      
echo "<td>$valid_div</td>";      
echo "<td>$valid_ci</td>";      
echo "<td>$valid_1280</td>";      
echo "<td>$budget_group</td>";      
echo "<td>$ncasnum2</td>";      
  
echo "</tr>";



}
/*
echo "<form>";
echo "<tr>";
echo "<td><input type='text' name='ncasnumF' value='$account'></td>";
echo "<td><input type='text' name='descriptionF' value='$account_description'></td>";
echo "<td><input type='text' name='park_acct_descF'></td>";
echo "<td><input type='text' name='acct_catF'></td>";
echo "<td><input type='text' name='cash_typeF'></td>";
echo "<td><input type='text' name='track_rccF'></td>";
echo "<td><input type='text' name='seriesF'></td>";
echo "<td><input type='text' name='valid_cdcsF'></td>";
echo "<td><input type='text' name='valid_oscF'></td>";
echo "<td><input type='text' name='valid_divF'></td>";
echo "<td><input type='text' name='valid_ciF'></td>";
echo "<td><input type='text' name='valid_1280F'></td>";
echo "<td><input type='text' name='budget_groupF'></td>";
echo "<td><input type='text' name='ncasnum2F'></td>";
echo "<td><input type='submit' name='Update'></td>";
echo "</tr>";
echo "</form>";
*/

echo "</table>";



echo "</body></html>";

?>