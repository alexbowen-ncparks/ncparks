<?php

session_start();

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
if($level=='5' and $tempID !='Dodd3454')

{echo "<pre>";print_r($_SESSION);"</pre>";}//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

include("../../../include/connectBUDGET.inc");// database connection parameters
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

//echo "f_year=$f_year";


//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}



if($level=='5' and $tempID !='Dodd3454')
{
echo "beacon_number:$beacnum";
echo "<br />";
echo "concession_location:$concession_location";
echo "<br />";
echo "concession_center:$concession_center";
echo "<br />";
}



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

if($level=='5' and $tempID !='Dodd3454')
{
echo "body_bg:$body_bg";
echo "<br />";
echo "table_bg:$table_bg";
echo "<br />";
echo "table_bg2:$table_bg2";
}

$query11="SELECT filegroup,report_name
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>
<title>Concessions</title>";

//include ("test_style.php");
include ("test_style.php");

echo "</head>";

include ("widget1.php");
echo "<br />";

include ("report_header2.php");


//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

if($period== 'fyear'){$table="report_budget_history_multiyear";}
if($period== 'cyear'){$table="report_budget_history_multiyear_calyear2";}


 
//echo "account_selected=y";
//echo "<br />";
//echo "account=$account";




include("report_header1.php");
//if($fyearhist=='10yr'){include "/ten_yr_history.php";}

if($section != 'all'){$where_section= " and section='$section' ";}

if($accounts != 'all' and $accounts != 'gmp')
{$where_accounts= " and cash_type='$accounts' ";}

if($accounts != 'all' and $accounts == 'gmp')
{$where_accounts= " and gmp='y' ";}

if($district != 'all' and $district != ''){$where_district= " and district='$district' ";}








if($history=='10yr' and $report=='cent'){include("center_ten_yr_history.php");}
if($history=='5yr' and $report=='cent'){include("center_five_yr_history.php");}
if($history=='3yr' and $report=='cent'){include("center_three_yr_history.php");}
if($history=='1yr' and $report=='cent'){include("center_one_yr_history.php");}
//exit;
//include "/ten_yr_history.php";

/*
$query3="select cash_type,budget_group,gmp,
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
         from $table $where1 
		 group by budget_group order by cash_type desc, budget_group asc ";
		 
if($level=='5' and $tempID !='Dodd3454')

{		 
	echo "$query3";//exit;	
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
         from $table $where1 
		 ";
		 
if($level=='5' and $tempID !='Dodd3454')

{		 
	echo "$query4";//exit;	
}
	
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);


//echo "<H1 ALIGN=left><font color=brown><i>$account-$account_description</i></font></H1>";
echo "<table border='1'>";

if($scope=="all"){$shade_all="class=cartRow2";}
if($scope=="receipt"){$shade_receipt="class=cartRow2";}
if($scope=="disburse"){$shade_disburse="class=cartRow2";}
if($scope=="gmp"){$shade_gmp="class=cartRow2";}


echo "<tr>";
echo "<td><font color=brown class=cartRow>Division Budget Groups:  </font></td>
      <td><a href='reports_all_budget_group_summary_by_division.php?scope=all&fyearhist=$fyearhist'><font  $shade_all>ALL</font></a></td>
      <td><a href='reports_all_budget_group_summary_by_division.php?scope=receipt&fyearhist=$fyearhist'><font  $shade_receipt>Receipt</font></a></td>
      <td><a href='reports_all_budget_group_summary_by_division.php?scope=disburse&fyearhist=$fyearhist'><font  $shade_disburse>Disburse</font></a></td>
      <td><a href='reports_all_budget_group_summary_by_division.php?scope=gmp&fyearhist=$fyearhist'><font  $shade_gmp>GMP</font></a></td>
      	  
</tr></table><br />";

//$class2="class=cartRow2";

echo "<table border='1'>";


echo "<tr>";
echo "<td><font color=brown class=cartRow>Fiscal Year history:</font></td>
      <td><a href='reports_all_budget_group_summary_by_division.php?fyearhist=10yr&scope=$scope'><font  $shade_10yr>10yr</font></a></td>
      <td><a href='reports_all_budget_group_summary_by_division.php?fyearhist=5yr&scope=$scope'><font  $shade_5yr>5yr</font></a></td>
      <td><a href='reports_all_budget_group_summary_by_division.php?fyearhist=3yr&scope=$scope'><font  $shade_3yr>3yr</font></a></td>
      <td><a href='reports_all_budget_group_summary_by_division.php?fyearhist=1yr&scope=$scope'><font  $shade_1yr>1yr</font></a></td>
     
      
      	  
</tr></table><br />";


echo "<table border=1>";

//$row=mysqli_fetch_array($result);

echo "<tr>";
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
echo "<th align=left><font color=brown>Budget Group</font></th>"; 
echo "<th align=left><font color=brown>Cash Type</font></th>"; 
echo "<th align=left><font color=brown>GMP</font></th>"; 
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
$cy_amount=number_format($cy_amount,2);
$py1_amount=number_format($py1_amount,2);
$py2_amount=number_format($py2_amount,2);
$py3_amount=number_format($py3_amount,2);
$py4_amount=number_format($py4_amount,2);
$py5_amount=number_format($py5_amount,2);
$py6_amount=number_format($py6_amount,2);
$py7_amount=number_format($py7_amount,2);
$py8_amount=number_format($py8_amount,2);
$py9_amount=number_format($py9_amount,2);
$py10_amount=number_format($py10_amount,2);


if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           
           <td><a href='reports_one_budget_group_summary_by_center.php?budget_group=$budget_group'>$budget_group</a></td> 
		   <td>$cash_type</td> 
           <td>$gmp</td> 	
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
$cy_amount=number_format($cy_amount,2);
$py1_amount=number_format($py1_amount,2);
$py2_amount=number_format($py2_amount,2);
$py3_amount=number_format($py3_amount,2);
$py4_amount=number_format($py4_amount,2);
$py5_amount=number_format($py5_amount,2);
$py6_amount=number_format($py6_amount,2);
$py7_amount=number_format($py7_amount,2);
$py8_amount=number_format($py8_amount,2);
$py9_amount=number_format($py9_amount,2);
$py10_amount=number_format($py10_amount,2);


if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 

"<tr$t> 
               
           	
           <td></td> 	
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
 */
 
 //echo "hello world";

?>





















	














