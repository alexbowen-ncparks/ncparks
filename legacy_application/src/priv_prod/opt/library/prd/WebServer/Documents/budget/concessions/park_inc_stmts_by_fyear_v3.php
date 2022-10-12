<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
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
if($report_type==''){$report_type='all';}
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
//include ("../../budget/menu1415_v1.php");

if($report_type=='all')
{
if($scope=='park'){$where_scope=" and scope='park' ";}



if($level>1)

{
/*
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
*/

$query5="SELECT parkcode, center,center_description,f_year, SUM( disburse_amt ) AS  'expenditures', SUM( receipt_amt ) AS  'receipts', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent',sum(camping_cabin) as 'camping_cabin',sum(concessions) as 'concessions',sum(other) as 'other',id
FROM report_budget_history_inc_stmt_by_fyear_net
WHERE f_year =  '$fyear'
$where_scope
GROUP BY center
ORDER BY receipt_percent desc";


}



//echo "query5=$query5";
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);
$median_record=round($num5/2,0);
//echo "median_record=$median_record<br />";

/*
$query_mean1="select (sum(receipt_amt)/sum(disburse_amt)*100) as 'receipt_percent_total_calc' FROM report_budget_history_inc_stmt_by_fyear
WHERE f_year =  '$fyear' $where_scope ";
echo "query_mean1=$query_mean1<br />";
$result_mean1 = mysqli_query($connection, $query_mean1) or die ("Couldn't execute query_mean1.  $query_mean1");
$row_mean1=mysqli_fetch_array($result1_mean1);
extract($row_mean1);
echo "receipt_percent_total_calc=$receipt_percent_total_calc<br />";
*/


	 


if($level>1)
{
$query6="select sum(disburse_amt) as 'total_exp',sum(receipt_amt) as 'total_rec',SUM( receipt_amt ) AS  'receipts', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent_total'
from report_budget_history_inc_stmt_by_fyear_net
where 1
and f_year='$fyear'
$where_scope";

		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	
}		 

echo "<html>";
?>
<head>
<script>
function showUser(str) {
  if (str=="") {
    document.getElementById("txtHint").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","getuser.php?q="+str,true);
  xmlhttp.send();
}
</script>
</head>

<?php

echo "<br /><br />";

if($scope=='park'){$check_park="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>$num5";}

if($scope=='all'){$check_all="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>$num5";}

if($report_type=='all'){$report_all="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($report_type=='pfr'){$report_pfr="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($report_type=='receipt_detail'){$report_receipt_detail="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

echo "<table border='1' align='center'><tr><th>Park Receipts and Expenditures by Fiscal Year<br /></th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&report_type=$report_type&scope=park'>Park<br />Centers</a><br />$check_park</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&report_type=$report_type&scope=all'>All<br />Centers</a> <br />$check_all</th></tr></table>";
//echo "<br />";

echo "<br /><table border='1' align='center'><tr><th>Report Type</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&scope=$scope&report_type=all'>ALL</a><br />$report_all</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&scope=$scope&report_type=pfr'>Retail</a> <br />$report_pfr</th>";
/*
echo "<th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&scope=$scope&report_type=receipt_detail'>Receipts</a> <br />$report_receipt_detail</th>";
*/
echo "</tr></table>";





//include ("inc_stmt_by_fyear_head1.php");
include ("inc_stmt_by_fyear_head1_net.php");


echo "<table border=1 align='center'>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Rank</font></th>
        <th align=left><font color=brown>Center Name</font></th>
       <th align=left><font color=brown>Center</font></th>
	   <th align=left><font color=brown>Fyear</font></th>
       <th align=left><font color=brown>Expenditures<br />(ex pfr exp)</font></th>
       <th align=left><font color=brown>Receipts <br />(net of pfr exp)</font></th>
       <th align=left><font color=brown>Receipt%</font></th> 
       <th align=left><font color=brown>Camping/Cabins</font></th>
       <th align=left><font color=brown>3rd Party <br />Concessions</font></th>
       <th align=left><font color=brown>Other</font></th>



	   ";
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";


while ($row=mysqli_fetch_array($result5)){


extract($row);
$expenditures=number_format($expenditures,2);
$receipts=number_format($receipts,2);
$camping_cabin=number_format($camping_cabin,2);
$concessions=number_format($concessions,2);
$other=number_format($other,2);


$rank=@$rank+1;
if($rank==$median_record){$median_receipt=$receipt_percent;}
$var_total_receipt+=$receipt_percent;



//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

       //echo "<td>$category</td>";
	   
 	   
	   
    //echo "<td><a href='park_posted_deposits_drilldown1_v2.php?f_year=$f_year&park=$park&center=$center'>$park</a></td>";
	echo "<td>$rank</td>";
     echo "<td>$center_description ($parkcode)</td>";
     echo "<td>$center</td>		   
           <td>$f_year</td>		   
           <td>$expenditures</td>		   
           <td>$receipts</td>		   
           <td align='center'>$receipt_percent</td>	
           <td>$camping_cabin</td>			   
           <td>$concessions</td>			   
           <td>$other</td>			   
           <td>$id
		   <form>
<select name='users' onchange='showUser(this.value)'>
<option value=''>Select a person:</option>
<option value='1'>Peter Griffin</option>
<option value='2'>Lois Griffin</option>
<option value='3'>Joseph Swanson</option>
<option value='4'>Glenn Quagmire</option>
</select>
</form>
<br>
<div id='txtHint'><b>Person info will be listed here.</b></div>
		   
		   
		   
		   
		   </td>			   
                       
           
</tr>";




}

$var_park_average=$var_total_receipt/$num5;
$var_park_average2=number_format($var_park_average,0);


if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 



"<tr$t> 

               

           	

           <td></td> 	
           <td>Totals</td> 	
           <td></td> 	

           <td></td> 	
           

         <td>$total_expenses</td> 
           <td>$total_receipts</td> 
           <td>$receipt_percent_total (Division)<br />$var_park_average2 (Park Avg)<br />$median_receipt (Park Med)</td> 
          

          
           
           

           		  

</tr>";



//}
//}

 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 }
 
 
 if($report_type=='pfr')
{
if($scope=='park'){$where_scope=" and scope='park' ";}



if($level>1)

{
/*
$query5="SELECT parkcode, center,center_description,f_year, SUM( disburse_amt ) AS  'expenditures', SUM( receipt_amt ) AS  'receipts', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent'
FROM report_budget_history_inc_stmt_by_fyear_pfr
WHERE f_year =  '$fyear'
$where_scope
GROUP BY center
ORDER BY parkcode";
*/

$query5="SELECT parkcode, center,center_description,f_year, SUM( disburse_amt ) AS  'expenditures', SUM( receipt_amt ) AS  'receipts', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent'
FROM report_budget_history_inc_stmt_by_fyear_pfr
WHERE f_year =  '$fyear'
$where_scope
GROUP BY center
ORDER BY receipt_percent desc";
}



//echo "query5=$query5";
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);
$median_record=round($num5/2,0);
//echo "median_record=$median_record<br />";


if($level>1)
{
$query6="select sum(disburse_amt) as 'total_exp',sum(receipt_amt) as 'total_rec',SUM( receipt_amt ) AS  'receipts', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent_total'
from report_budget_history_inc_stmt_by_fyear_pfr
where 1
and f_year='$fyear'
$where_scope";

		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	
}		 


echo "<br /><br />";

if($scope=='park'){$check_park="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>$num5";}

if($scope=='all'){$check_all="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>$num5";}

if($report_type=='all'){$report_all="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($report_type=='pfr'){$report_pfr="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($report_type=='receipt_detail'){$report_receipt_detail="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

echo "<table border='1' align='center'><tr><th>Park Receipts and Expenditures by Fiscal Year<br /><h3><font color='red'>UNDER Construction (Jan 12, 2015)</font></h3></th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&report_type=$report_type&scope=park'>Park<br />Centers</a><br />$check_park</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&report_type=$report_type&scope=all'>All<br />Centers</a> <br />$check_all</th></tr></table>";
//echo "<br />";
/*
echo "<br /><table border='1' align='center'><tr><th>Report Type</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&scope=$scope&report_type=all'>ALL</a><br />$report_all</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&scope=$scope&report_type=pfr'>PFR</a> <br />$report_pfr</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&scope=$scope&report_type=receipt_detail'>Receipts</a> <br />$report_receipt_detail</th></tr></table>";
*/


echo "<br /><table border='1' align='center'><tr><th>Report Type</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&scope=$scope&report_type=all'>ALL</a><br />$report_all</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&scope=$scope&report_type=pfr'>Retail</a> <br />$report_pfr</th>";
/*
echo "<th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&scope=$scope&report_type=receipt_detail'>Receipts</a> <br />$report_receipt_detail</th>";
*/
echo "</tr></table>";















//include ("inc_stmt_by_fyear_head1_pfr.php");
include ("inc_stmt_by_fyear_head1_v2.php");

echo "<table border=1 align='center'>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Rank</font></th>
        <th align=left><font color=brown>Center Name</font></th>
       <th align=left><font color=brown>Center</font></th>
	   <th align=left><font color=brown>Fyear</font></th>
       <th align=left><font color=brown>Expenditures</font></th>
       <th align=left><font color=brown>Receipts</font></th>
       <th align=left><font color=brown>Receipt%</font></th>  ";
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";


while ($row=mysqli_fetch_array($result5)){


extract($row);
$expenditures=number_format($expenditures,2);
$receipts=number_format($receipts,2);



$rank=@$rank+1;
if($rank==$median_record){$median_receipt=$receipt_percent;}
$var_total_receipt+=$receipt_percent;


//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

       //echo "<td>$category</td>";
	   
 	   
	   
    //echo "<td><a href='park_posted_deposits_drilldown1_v2.php?f_year=$f_year&park=$park&center=$center'>$park</a></td>";
	echo "<td>$rank</td>";	
     echo "<td>$center_description ($parkcode)</td>";
     echo "<td>$center</td>		   
           <td>$f_year</td>		   
           <td>$expenditures</td>		   
           <td>$receipts</td>		   
           <td>$receipt_percent</td>		   
                       
           
</tr>";




}

$var_park_average=$var_total_receipt/$num5;
$var_park_average2=number_format($var_park_average,0);

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 



"<tr$t> 

               

           	
           <td></td> 	
           <td>Totals</td> 	
           <td></td> 	

           <td></td> 	
           

         <td>$total_expenses</td> 
           <td>$total_receipts</td> 
           <td>$receipt_percent_total (Division)<br />$var_park_average2 (Park Avg)<br />$median_receipt (Park Med)</td> 
          

          
           
           

           		  

</tr>";



//}
//}

 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 }
 
 
 if($report_type=='receipt_detail')
{
if($scope=='park'){$where_scope=" and scope='park' ";}



if($level>1)

{
/*
$query5="SELECT parkcode, center,center_description,f_year, SUM( disburse_amt ) AS  'expenditures', SUM( receipt_amt ) AS  'receipts', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent'
FROM report_budget_history_inc_stmt_by_fyear_pfr
WHERE f_year =  '$fyear'
$where_scope
GROUP BY center
ORDER BY parkcode";
*/

$query5="SELECT parkcode, center,center_description,f_year, SUM( disburse_amt ) AS  'expenditures', SUM( receipt_amt ) AS  'receipts', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent'
FROM report_budget_history_inc_stmt_by_fyear_pfr
WHERE f_year =  '$fyear'
$where_scope
GROUP BY center
ORDER BY receipt_percent desc";
}



//echo "query5=$query5";
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);
$median_record=round($num5/2,0);
//echo "median_record=$median_record<br />";


if($level>1)
{
$query6="select sum(disburse_amt) as 'total_exp',sum(receipt_amt) as 'total_rec',SUM( receipt_amt ) AS  'receipts', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent_total'
from report_budget_history_inc_stmt_by_fyear_pfr
where 1
and f_year='$fyear'
$where_scope";

		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	
}		 


echo "<br /><br />";

if($scope=='park'){$check_park="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>$num5";}

if($scope=='all'){$check_all="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>$num5";}

if($report_type=='all'){$report_all="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($report_type=='pfr'){$report_pfr="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($report_type=='receipt_detail'){$report_receipt_detail="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

echo "<table border='1' align='center'><tr><th>Park Receipts and Expenditures by Fiscal Year<br /><h3><font color='red'>UNDER Construction (Jan 12, 2015)</font></h3></th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&report_type=$report_type&scope=park'>Park<br />Centers</a><br />$check_park</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&report_type=$report_type&scope=all'>All<br />Centers</a> <br />$check_all</th></tr></table>";
//echo "<br />";

echo "<br /><table border='1' align='center'><tr><th>Report Type</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&scope=$scope&report_type=all'>ALL</a><br />$report_all</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&scope=$scope&report_type=pfr'>PFR</a> <br />$report_pfr</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&scope=$scope&report_type=receipt_detail'>Receipts</a> <br />$report_receipt_detail</th></tr></table>";

//include ("inc_stmt_by_fyear_head1_pfr.php");
include ("inc_stmt_by_fyear_head1_receipts_v2.php");

echo "<table border=1 align='center'>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Rank</font></th>
        <th align=left><font color=brown>Center Name</font></th>
       <th align=left><font color=brown>Center</font></th>
	   <th align=left><font color=brown>Fyear</font></th>
       <th align=left><font color=brown>Expenditures</font></th>
       <th align=left><font color=brown>Receipts</font></th>
       <th align=left><font color=brown>Receipt%</font></th>  ";
       	   
	   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";


while ($row=mysqli_fetch_array($result5)){


extract($row);
$expenditures=number_format($expenditures,2);
$receipts=number_format($receipts,2);



$rank=@$rank+1;
if($rank==$median_record){$median_receipt=$receipt_percent;}
$var_total_receipt+=$receipt_percent;


//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

       //echo "<td>$category</td>";
	   
 	   
	   
    //echo "<td><a href='park_posted_deposits_drilldown1_v2.php?f_year=$f_year&park=$park&center=$center'>$park</a></td>";
	echo "<td>$rank</td>";	
     echo "<td>$center_description ($parkcode)</td>";
     echo "<td>$center</td>		   
           <td>$f_year</td>		   
           <td>$expenditures</td>		   
           <td>$receipts</td>		   
           <td>$receipt_percent</td>		   
                       
           
</tr>";




}

$var_park_average=$var_total_receipt/$num5;
$var_park_average2=number_format($var_park_average,0);

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 



"<tr$t> 

               

           	
           <td></td> 	
           <td>Totals</td> 	
           <td></td> 	

           <td></td> 	
           

         <td>$total_expenses</td> 
           <td>$total_receipts</td> 
           <td>$receipt_percent_total (Division)<br />$var_park_average2 (Park Avg)<br />$median_receipt (Park Med)</td> 
          

          
           
           

           		  

</tr>";



//}
//}

 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 }
 
 
 
 echo "</body></html>";


 






?>


 


























	














