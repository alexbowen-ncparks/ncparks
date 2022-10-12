<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];



extract($_REQUEST);

//echo "$report_date<br />";exit;


//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
//echo "f_year=$f_year<br />";
if($fyear==''){$fyear=$f_year;}
if($scope==''){$scope='park';}
//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}
/*
if($level=='5' and $tempID !='Dodd3454')
{

echo "beacon_number:$beacnum";
echo "<br />";
echo "concession_location:$concession_location";
echo "<br />";
echo "concession_center:$concession_center";
echo "<br />";
}
*/
$table="rbh_multiyear_concession_fees3";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";
//echo "query10=$query10<br />";
$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

//echo "body_bg:$body_bg";
//echo "<br />";
//echo "table_bg:$table_bg";
//echo "<br />";
//echo "table_bg2:$table_bg2";

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

//echo "query11=$query11<br />";
$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
//echo "<br />";
//echo $filegroup;

/*
echo "<html>";
echo "<head>
<title>Concessions</title>";
*/
//include ("test_style.php");
//include ("test_style.php");

//echo "</head>";

//include("../../../budget/menus2.php");
//include("menu1314_cash_receipts.php");
//include("../../../budget/menu1314.php");
include ("../../budget/menu1415_v1.php");


if($scope=='park'){$where_scope=" and scope='park' ";}

$query6="select sum(disburse_amt) as 'total_exp',sum(receipt_amt) as 'total_rec',SUM( receipt_amt ) AS  'receipts', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent_total'
from report_budget_history_inc_stmt_by_fyear
where 1
and f_year='$fyear'
$where_scope";

		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	

$row6=mysqli_fetch_array($result6);
extract($row6);

$total_exp=number_format($total_exp,2);
$total_rec=number_format($total_rec,2);


if($level>2)

{

$query5="SELECT parkcode, center,center_description,f_year, SUM( disburse_amt ) AS  'expenditures', SUM( receipt_amt ) AS  'receipts', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent'
FROM report_budget_history_inc_stmt_by_fyear
WHERE f_year =  '$fyear'
$where_scope
GROUP BY center
ORDER BY parkcode";

}



//echo "query5=$query5";
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);



if($level>2)
{
$query6="select sum(disburse_amt) as 'total_exp',sum(receipt_amt) as 'total_rec',SUM( receipt_amt ) AS  'receipts', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent_total'
from report_budget_history_inc_stmt_by_fyear
where 1
and f_year='$fyear'
$where_scope";

		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	
}		 


echo "<br /><br />";

if($scope=='park'){$check_park="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>$num5";}

if($scope=='all'){$check_all="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>$num5";}


echo "<table border='1'><tr><th>Park Revenue and Expenditures by Fiscal Year</th><th><a href='park_inc_stmts_by_fyear.php?fyear=$fyear&scope=park'>Park<br />Centers</a><br />$check_park</th><th><a href='park_inc_stmts_by_fyear.php?fyear=$fyear&scope=all'>All<br />Centers</a> <br />$check_all</th></tr></table>";
//echo "<br />";

include ("inc_stmt_by_fyear_head1.php");
//echo "<br />";
//include ("inc_stmt_by_fyear_head2.php");
//include ("park_posted_deposits_widget1_v2.php");






echo "<table border=1>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Center Name</font></th>
       <th align=left><font color=brown>Center</font></th>
	   <th align=left><font color=brown>Fyear</font></th>
       <th align=left><font color=brown>Expenditures</font></th>
       <th align=left><font color=brown>Receipts</font></th>
       <th align=left><font color=brown>Receipt%</font></th>  ";
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);
$expenditures=number_format($expenditures,2);
$receipts=number_format($receipts,2);






//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

       //echo "<td>$category</td>";
	   
 	   
	   
    //echo "<td><a href='park_posted_deposits_drilldown1_v2.php?f_year=$f_year&park=$park&center=$center'>$park</a></td>";
     echo "<td>$center_description ($parkcode)</td>";
     echo "<td>$center</td>		   
           <td>$f_year</td>		   
           <td>$expenditures</td>		   
           <td>$receipts</td>		   
           <td>$receipt_percent</td>		   
                       
           
</tr>";




}
/*
if($level>1)
{
while ($row6=mysqli_fetch_array($result6)){



// The extract function automatically creates individual variables from the array $row

//These individual variables are the names of the fields queried from MySQL

extract($row6);

$total_exp=number_format($total_exp,2);
$total_rec=number_format($total_rec,2);

*/



if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 



"<tr$t> 

               

           	

           <td></td> 	
           <td></td> 	

           <td></td> 	
           

           <td>$total_exp</td> 
           <td>$total_rec</td> 
           <td>$receipt_percent_total</td> 
          

          
           
           

           		  

</tr>";



}
}

 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>


 


























	














