<?php

session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters


////mysql_connect($host,$username,$password);
@mysql_select_db($database) or die( "Unable to select database");
//echo "welcome to account_listing.php";
$table="report_budget_history_multiyear";
$query1="SELECT body_bgcolor
from format_custom
WHERE 1 and user_id='tony'
";

$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$row1=mysqli_fetch_array($result1);

extract($row1);

$body_bg=$body_bgcolor;
echo "<html>";
echo "<head>
<title>accounts</title>";

//include ("css/test_style.php");



echo "
<style type='text/css'>
body { background-color: $body_bg; }
table { background-color: $body_bg; font-color: blue; font-size: 10;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
</style>";


echo "</head>";


echo "<br />";



if($account_selected !='y') 
 
{

$query2="select distinct account,account_description,budget_group from $table where 1 
         and cash_type='receipt' order by account";
echo $query2;//exit;		 
$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
$num2=mysqli_num_rows($result2);

echo "<H1 ALIGN=left><font color=brown><i>Account Totals by Park</i></font></H1>";

echo "<H2 ALIGN=left><font color=brown><i>Receipt Accounts-$num2</i></font></H2>";
echo "<table border=1>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<th align=left><font color=brown>Account</font></th>"; 
echo "<th align=left><font color=brown>Description</font></th>"; 
echo "<th align=left><font color=brown>Budget Group</font></th>"; 

while ($row2=mysqli_fetch_array($result2)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row2);

if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           <td><a href='reports_account_totals_by_park.php?&account=$account&account_description=$account_description
		       &account_selected=y'>$account</a></td> 	
           <td>$account_description</td> 
           <td>$budget_group</td> 
	          
		  
		  
			  
			  
</tr>";

}
 exit;
} 

 if($account_selected =='y')
{
//echo "account_selected=y";
//echo "<br />";
//echo "account=$account";

$query3="select parkcode,
         sum(cy_amount) as 'cy_amount',
         sum(py1_amount) as 'py1_amount',
		 sum(py2_amount) as 'py2_amount',
		 sum(py3_amount) as 'py3_amount',
		 sum(py4_amount) as 'py4_amount',
		 sum(py5_amount) as 'py5_amount',
		 sum(py6_amount) as 'py6_amount',
		 sum(py7_amount) as 'py7_amount',
		 sum(py8_amount) as 'py8_amount',
		 sum(py9_amount) as 'py9_amount',		 
		 sum(py10_amount) as 'py10_amount'		 
         from $table where 1 
         and account='$account' group by parkcode order by parkcode";
	echo "$query3";//exit;	 
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);

$query4="select 
         sum(cy_amount) as 'cy_amount',
         sum(py1_amount) as 'py1_amount',
		 sum(py2_amount) as 'py2_amount',
		 sum(py3_amount) as 'py3_amount',
		 sum(py4_amount) as 'py4_amount',
		 sum(py5_amount) as 'py5_amount',
		 sum(py6_amount) as 'py6_amount',
		 sum(py7_amount) as 'py7_amount',
		 sum(py8_amount) as 'py8_amount',
		 sum(py9_amount) as 'py9_amount',		 
		 sum(py10_amount) as 'py10_amount'		 
         from $table where 1 
         and account='$account' group by account";
	echo "$query4";//exit;	 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);





echo "<H1 ALIGN=left><font color=brown><i>Account Totals by Park</i></font></H1>";
echo "<H2 ALIGN=left><font color=brown><i>$account-$account_description</i></font></H2>";
echo "<table border=1>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<th align=left><font color=brown>Park</font></th>"; 
echo "<th align=left><font color=brown>CY</font></th>"; 
echo "<th align=left><font color=brown>PY1</font></th>"; 
echo "<th align=left><font color=brown>PY2</font></th>"; 
echo "<th align=left><font color=brown>PY3</font></th>"; 
echo "<th align=left><font color=brown>PY4</font></th>"; 
echo "<th align=left><font color=brown>PY5</font></th>"; 
echo "<th align=left><font color=brown>PY6</font></th>"; 
echo "<th align=left><font color=brown>PY7</font></th>"; 
echo "<th align=left><font color=brown>PY8</font></th>"; 
echo "<th align=left><font color=brown>PY9</font></th>"; 
echo "<th align=left><font color=brown>PY10</font></th>"; 



while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);

if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           <td>$parkcode</td> 	
           <td>$cy_amount</td> 
           <td>$py1_amount</td> 
           <td>$py2_amount</td> 
           <td>$py3_amount</td> 
           <td>$py4_amount</td> 
           <td>$py5_amount</td> 
           <td>$py6_amount</td> 
           <td>$py7_amount</td> 
           <td>$py8_amount</td> 
           <td>$py9_amount</td> 
           <td>$py10_amount</td> 
                
		  
		  
			  
			  
</tr>";

}

while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);

if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           <td>Total</td> 	
           <td>$cy_amount</td> 
           <td>$py1_amount</td> 
           <td>$py2_amount</td> 
           <td>$py3_amount</td> 
           <td>$py4_amount</td> 
           <td>$py5_amount</td> 
           <td>$py6_amount</td> 
           <td>$py7_amount</td> 
           <td>$py8_amount</td> 
           <td>$py9_amount</td> 
           <td>$py10_amount</td> 
                
		  
		  
			  
			  
</tr>";

}
 exit;
} 




 echo "</table></html>";
 
 
 

?>





















	














