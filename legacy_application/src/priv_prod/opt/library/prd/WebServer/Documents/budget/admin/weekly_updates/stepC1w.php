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
include("../../../../include/activity.php");// database connection parameters

if($submit=='mark_complete')
{

$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");


//{header("location: step_group.php?project_category=fms&project_name=weekly_updates&step_group=C");}
{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}
}

if($submit=='')
{

$query4="SELECT fund,SUM( debit - credit ) as 'amount'
         FROM `exp_rev_dncr_temp_part2_dpr`
		 WHERE 1 AND valid_dpr_center = 'y' AND valid_account_dpr = 'y'
         and fund != '1680'
		 and fund != '1685'
		 and fund != '2235'
		 and fund != '2802'
		 and fund != '2803'
		 group by fund;";

echo "<br />Query4=$query4<br />";

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
echo "<body>";
echo "<table align='center'>";
echo "<tr><th><font color='red'>CI Funds (Net Expenditures-Current Fiscal Year)</th></font></th></tr>";
echo "</table>";
echo "<br />";
echo "<table border='1' align='center'>";
 
echo "<tr>"; 
echo "<th>Fund</th>";      
echo "<th>Amount</th>";      

     
echo "</tr>";



while ($row4=mysqli_fetch_array($result4)){


extract($row4);

if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	



echo "<tr$t>";	
echo "<td>$fund</td>";      
echo "<td>$amount</td>";      

  
echo "</tr>";


}

echo "<tr>";
echo "<td>";

echo "<form method='post' action='stepC1w.php'>"; 
echo "<input type='hidden' name='project_category' value='$project_category'>";
echo "<input type='hidden' name='project_name' value='$project_name'>";
echo "<input type='hidden' name='step_group' value='$step_group'>";
echo "<input type='hidden' name='step_num' value='$step_num'>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>";
echo "<input type='hidden' name='start_date' value='$start_date'>";
echo "<input type='hidden' name='end_date' value='$end_date'>";
echo "<input type='submit' name='submit' value='mark_complete'>";




echo "</td>";
echo "</tr>";





echo "</table>";



echo "</body>";
echo "</html>";
}

?>