<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../../include/activity.php");// database connection parameters



$project_category='fms';
$project_name='weekly_updates';
$step_group='J';
$step_num='9w1';

$query0="select back_date_yn,fiscal_year,start_date,end_date
         from project_steps_mode
		 where project_category='$project_category' and project_name='$project_name' "; 



$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);





/*
echo "<html>";
echo "<head>";
echo "<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>";
	


echo "</head>";
*/
if($submit=='ADD')
{
	
	
$system_entry_date=date("Ymd");	
	
	
//echo "Line 31: query to update COA";
$query1="update coa
         set ncasnum='$ncasnumF',
		     park_acct_desc='$park_acct_descF',
			 acct_cat='$acct_catF',
			 cash_type='$cash_typeF',
			 track_rcc='$track_rccF',
			 series='$seriesF',
			 valid_cdcs='$valid_cdcsF',
			 valid_osc='$valid_oscF',
			 valid_div='$valid_divF',
			 valid_ci='$valid_ciF',
			 valid_1280='$valid_1280F',
			 budget_group='$budget_groupF',
			 ncasnum2='$ncasnum2F',
             account_verified='y',
             verified_by='$tempid',
             verified_date='$system_entry_date'	
             where coaid='$coaidF'			 ";


//echo "<br />query1=$query1<br />";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");


if($acct_catF=='rev' or $acct_catF=='REV'){$acct_cat2F='fun';} else {$acct_cat2F=$acct_catF;}

$query1a="update bd725_dpr_accounts
         set account_description='$park_acct_descF',
			 acct_cat='$acct_cat2F',
			 naspd_funding_type='$ci_funding_typeF',
             account_verified='y',
             verified_by='$tempid',
             verified_date='$system_entry_date'	
             where account='$ncasnumF'			 ";


//echo "<br />query1a=$query1a<br />";

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");





$query2="update exp_rev_dncr_temp_part2_dpr
         set valid_account_dpr='y'
		 where account='$ncasnumF' ";
		 
//echo "<br />query2=$query2<br />";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");





}
//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";

//echo "<br /><br />";

//5/1/20
/*
$query3="select account,account_description 
         from exp_rev_dncr_temp_part2_dpr
		 where valid_account='' and valid_account_dpr='n'
         order by account limit 1 ";
		 
*/

//5/1/20

/*
$query3="select account,account_description 
         from exp_rev_dncr_temp_part2_dpr
		 where valid_account_dpr='n'
         order by account limit 1 ";
		 
*/


$query3="select ncasnum as 'account',park_acct_desc,acct_cat,cash_type,track_rcc,series,valid_cdcs,valid_osc,valid_div,valid_ci,valid_1280,budget_group,ncasnum2,coaid 
         from coa
		 where account_verified='n'
         order by account limit 1 ";





		 

//echo "<br />Query3=$query3<br />";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
$row3=mysqli_fetch_array($result3);
//$missing_accounts=$row3;
$missing_accounts=$num3;
extract($row3);//brings back max (end_date) as $end_date
$account_first4=substr($account,0,4);

//echo "<br />Line88: missing accounts=$missing_accounts<br />";

if($missing_accounts != 0)
{
$query4="select ncasnum,description,park_acct_desc,acct_cat,cash_type,track_rcc,series,valid_cdcs,valid_osc,valid_div,valid_ci,valid_1280,budget_group,ncasnum2,coaid
from coa where ncasnum like '$account_first4%'  ";

//echo "<br />Query4=$query4<br />";

// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

//////mysql_close();


echo "<html>";
echo "<head>";
echo "<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>";
	


echo "</head>";

echo "<table align='center'>";
echo "<tr><th><font color='red'>XTND Download includes Accounts which are are not located in MoneyCounts. Please ADD Account Below. Thanks</font></th></tr>";
echo "</table>";
echo "<br />";
echo "<table border=1>";
 
echo "<tr>"; 
echo "<th>Account</th>";      
//echo "<th>Account Description per XTND</th>";      
echo "<th>Account Description<br >per MoneyCounts</th>";      
echo "<th>Account<br />Category</th>";      
echo "<th>Cash Type</th>";      
echo "<th>Track RCC</th>";      
echo "<th>Series</th>";      
echo "<th>Valid CDCS</th>";      
echo "<th>Valid OSC</th>";      
echo "<th>Valid Div</th>";      
echo "<th>Valid CI</th>";      
echo "<th>CI Funding Type</th>";      
echo "<th>Valid 1280</th>";      
echo "<th>Budget Group</th>";      
echo "<th>Account2</th>";      
 
       
     
echo "</tr>";
echo "<form>";
echo "<tr>";

//echo "<td>$account</td>";
//echo "<td>$account_description</td>";
echo "<td><input type='text' name='ncasnumF' size='10' value='$account' readonly='readonly'></td>";
//echo "<td><input type='text' name='descriptionF' size='45' value='$account_description' readonly='readonly'></td>";

//echo "<form>";
echo "<td><input type='text' name='park_acct_descF' value='$park_acct_desc' size='45'></td>";
echo "<td><input type='text' name='acct_catF' size='2' value='$acct_cat'></td>";
echo "<td><input type='text' name='cash_typeF' size='8' value='$cash_type'></td>";
echo "<td><input type='text' name='track_rccF' size='1' value='$track_rcc'></td>";
echo "<td><input type='text' name='seriesF' size='5' value='$series'></td>";
echo "<td><input type='text' name='valid_cdcsF' size='1' value='$valid_cdcs'></td>";
echo "<td><input type='text' name='valid_oscF' size='1' value='$valid_osc'></td>";
echo "<td><input type='text' name='valid_divF' size='1' value='$valid_div'></td>";
echo "<td><input type='text' name='valid_ciF' size='1' value='$valid_ci'></td>";
echo "<td><input type='text' name='ci_funding_typeF' size='8' ></td>";
echo "<td><input type='text' name='valid_1280F' size='1' value='$valid_1280'></td>";
echo "<td><input type='text' name='budget_groupF' size='22' value='$budget_group'></td>";
echo "<td><input type='text' name='ncasnum2F' size='10' value='$ncasnum2'></td>";
echo "<td><input type='submit' name='submit' value='ADD' ></td>";
echo "</tr>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>";
echo "<input type='hidden' name='coaidF' value='$coaid'>";
echo "</form>";



while ($row4=mysqli_fetch_array($result4)){


extract($row4);

if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	



echo "<tr$t>";	
echo "<td>$ncasnum</td>";      
//echo "<td>$description</td>";      
echo "<td>$park_acct_desc</td>";      
echo "<td>$acct_cat</td>";      
echo "<td>$cash_type</td>";      
echo "<td>$track_rcc</td>";      
echo "<td>$series</td>";      
echo "<td>$valid_cdcs</td>";      
echo "<td>$valid_osc</td>";      
echo "<td>$valid_div</td>";      
echo "<td>$valid_ci</td>";      
echo "<td></td>";      
echo "<td>$valid_1280</td>";      
echo "<td>$budget_group</td>";      
echo "<td>$ncasnum2</td>";      
  
echo "</tr>";



}


echo "</table>";



echo "</body></html>";
}

if($missing_accounts == 0)
{
$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}

}



?>