<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
//$account='434410001';


extract($_REQUEST);


//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//if($level == "5"){echo "<pre>";print_r($_SESSION);"</pre>";}//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}

if($level == "5"){
echo "beacon_number:$beacnum";
echo "<br />";
echo "concession_location:$concession_location";
echo "<br />";
echo "concession_center:$concession_center";
echo "<br />";
}

$query9="select cash_type,gmp from report_budget_history_multiyear
		  where budget_group='$budget_group'
		  ";
		  
//echo "query3h=$query3h<br />";		  
		  
		  
$result9 = mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");
		  
$row9=mysqli_fetch_array($result9);

extract($row9);


$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

if($level == "5"){
echo "body_bg:$body_bg";
echo "<br />";
echo "table_bg:$table_bg";
echo "<br />";
echo "table_bg2:$table_bg2";
}

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
//echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>
<title>Concessions</title>";

//include ("test_style.php");
include ("test_style.php");

echo "</head>";

include ("widget1.php");

//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

echo "<br />";

$table="report_budget_history_multiyear";
 
//echo "account_selected=y";
//echo "<br />";
//echo "account=$account";

$query3="select account,account_description,
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
		 and budget_group='$budget_group'
		 and parkcode='$parkcode'
         group by budget_group,parkcode,account order by account";
		 
		 
		 
if($level == "5"){		 
	echo "$query3";
echo "<br />";	
echo "<br />";	
	
	
	//exit;	
}
	
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
		 and budget_group='$budget_group'
		 and parkcode='$parkcode'
		 ";
		 
if($level == "5"){		 
	echo "$query4";//exit;	
}
	
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);



//echo "<H1 ALIGN=left><font color=brown><i>$account-$account_description</i></font></H1>";

echo "<H1 ALIGN=left><font color=brown><i>Budget Group: $budget_group</i></font></H1>";
echo "<table>";
echo "<tr><td><font color=brown>Cash Type: $cash_type</font></td></tr>";
echo "<tr><td><font color=brown>GMP: $gmp</font></td></tr>";
echo "<tr><td><font color=brown>ParkCode: $parkcode</font></td></tr>";
echo "<tr><td><font color=brown>Accounts-$num3</font></td></tr>";
echo "</table><br />";


echo "<table border=1>";

//$row=mysqli_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<th align=left><font color=brown>Account</font></th>"; 
echo "<th align=left><font color=brown>Account_Description</font></th>"; 
//echo "<th align=left><font color=brown>Account Description</font></th>"; 
//echo "<th align=left><font color=brown>Budget Group</font></th>"; 
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
echo "</tr>";


while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
           <td>$account</td> 	
           <td>$account_description</td> 	 
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

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           <td></td> 	
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

 


 echo "</table></html>";
 
 
 

?>





















	














