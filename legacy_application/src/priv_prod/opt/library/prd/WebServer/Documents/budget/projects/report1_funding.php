<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}



$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";  exit;



$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
//include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
//include("../../budget/~f_year.php");

/*
$query0="select center_description as 'appropriated_center_description',amount as 'appropriated_funding'
         from appropriated_revenues_non1280
         where center='$center'	 ";
		 
//echo "<br />query0=$query0<br />";	//exit;	 
		 
$result0=mysqli_query($connection, $query0) or die ("Couldn't execute query0.  $query0");


$row0=mysqli_fetch_array($result0);
extract($row0);


//echo "<br />appropriated_funding=$appropriated_funding<br />";
//echo "<br />appropriated_center_description=$appropriated_center_description<br />";

$appropriated_funding2=number_format($appropriated_funding,2);
*/




$query1="select sum(total_budget) as 'funds_in_budget',sum(total_actual) as 'funds_in_actual'
         from bd725_dpr_accounts_by_center
		 where center='$center'
		 and cash_type='receipt'  ";
		 
//echo "<br />query1=$query1<br />";	//exit;	 
		 
$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query1.  $query1");


$row1=mysqli_fetch_array($result1);
extract($row1);

//echo "<br />funds_in_budget=$funds_in_budget<br />";
//echo "<br />funds_in_actual=$funds_in_actual<br />";



$query2="select sum(total_budget) as 'funds_out_budget',sum(total_actual) as 'funds_out_actual'
         from bd725_dpr_accounts_by_center
		 where center='$center'
		 and cash_type='disburse' ";
		 
//echo "<br />query2=$query2<br />";	//exit;	 
		 
$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query2.  $query2");


$row2=mysqli_fetch_array($result2);
extract($row2);

//echo "<br />funds_out_budget=$funds_out_budget<br />";
//echo "<br />funds_out_actual=$funds_out_actual<br />";

$net_funds_budget=$funds_in_budget-$funds_out_budget;
$net_funds_actual=$funds_in_actual-$funds_out_actual;

if($net_funds_budget-$net_funds_actual>=0){$net_funds_budget_display='y';}else{$net_funds_budget_display='n';}

echo "<br />net_funds_budget_display=$net_funds_budget_display<br />";
//echo "<br />net_funds_budget=$net_funds_budget<br />";
//echo "<br />net_funds_actual=$net_funds_actual<br />";


$net_funds_budget2=number_format($net_funds_budget,2);
$net_funds_actual2=number_format($net_funds_actual,2);


$query3="select center_description,fyear_last
         from bd725_dpr_accounts_by_center
		 where center='$center'	 ";
		 
//echo "<br />query3=$query3<br />";	//exit;	 
		 
$result3=mysqli_query($connection, $query3) or die ("Couldn't execute query3.  $query3");


$row3=mysqli_fetch_array($result3);
extract($row3);

//echo "<br />fyear_last=$fyear_last<br />";
//echo "<br />center_description=$center_description<br />";


if($center_description=='' and $appropriated_funding > 0.00){$center_description=$appropriated_center_description;}





$query5="select account,account_description,cash_type,naspd_funding_type,total_budget,total_actual
         from bd725_dpr_accounts_by_center
		 where center='$center'
		 group by cash_type,account
		 order by cash_type desc,account asc ";
		 
//echo "<br />query5=$query5<br />";		 
		 
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);


echo "<html>";
echo "<table border='1' cellspacing='5' align='center'>";
echo "<tr><th colspan='6'><b>CENTER <font color='green'>$center ($center_description)</b></font> FUNDING </th></tr>";
echo "<tr><th>Account</th><th>Account Description</th><th>Cash Type</th><th>Funding Type</th><th>Total Budget</th><th>Total Actual</th></tr>";
while ($row5=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row5);
$total_budget=number_format($total_budget,2);
$total_actual=number_format($total_actual,2);

if($cash_type=='receipt'){$table_bg2='lightgreen';}
if($cash_type=='disburse'){$table_bg2='lightpink';}

$t=" bgcolor='$table_bg2' ";


echo 

"<tr$t>"; 
               
           
        // echo "<td><a href='reports_one_budget_group_summary_by_center.php?budget_group=$budget_group'>$budget_group</a></td>"; 
		 echo "<td>$account</td> 
           <td>$account_description</td> 	
           <td>$cash_type</td> 	
           <td>$naspd_funding_type</td> 	
           <td>$total_budget</td> 	            
           <td>$total_actual</td> 	            
			  
</tr>";

}
//echo "<tr bgcolor='lightgreen'><td>NONE</td><td>NONE</td><td>receipt</td><td>appropriated</td><td>$appropriated_funding2</td><td>0.00</td></tr>";
echo "<tr><td colspan='4' align='right'>Total Funding</td><td>$net_funds_budget2</td><td>$net_funds_actual2</td></tr>";

echo "</table>";
echo "</html>";


?>