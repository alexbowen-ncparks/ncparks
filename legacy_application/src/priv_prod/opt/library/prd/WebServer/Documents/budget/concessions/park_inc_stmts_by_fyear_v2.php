<?php
/*
check for where if($scope=...){}; if($scope=...){}; if($report_type=...){}....
this is where the menu banners get picked up when initially being brought to the page
*/
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


$database="budget";
$db="budget";
/*
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
*/

include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
mysqli_select_db($connection,$database); // database
include("../../../include/activity_new.php");// database connection parameters
include("../../budget/~f_year.php");


//echo "<pre>";print_r($_SESSION);"</pre>"; // exit;
//echo "scope = $scope<br />";
//echo "report_type = $report_type";




//echo "f_year=$f_year<br />";
if($fyear==''){$fyear=$f_year;}
if($scope==''){$scope='park';}
if($report_type==''){$report_type='all';}

$table="rbh_multiyear_concession_fees3";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";
//echo "query10=$query10<br />";
$result10=mysqli_query($connection,$query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;


$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

//echo "query11=$query11<br />";
$result11=mysqli_query($connection,$query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);

//include ("../../budget/menu1415_v1.php");
include ("../../budget/menu1415_v1_new.php");





if($report_type=='all')
{
if($scope=='park'){$where_scope=" and scope='park' ";}



$query5="SELECT parkcode, center,center_description,f_year, SUM( disburse_amt ) AS  'expenditures', SUM( receipt_amt ) AS  'receipts', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *100
), 0
) AS  'receipt_percent',sum(camping_cabin) as 'camping_cabin',sum(concessions) as 'concessions',sum(other) as 'other'
FROM report_budget_history_inc_stmt_by_fyear_net
WHERE f_year =  '$fyear'
$where_scope
GROUP BY center
ORDER BY receipt_percent desc";
 


//echo "query5=$query5";
$result5 = mysqli_query($connection,$query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);
$median_record=round($num5/2,0);
//echo "median_record=$median_record<br />";



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





//////////include ("inc_stmt_by_fyear_head1.php");
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

/* 2-10-2022: JCarter & CCooper - added bypass below for Elizabeth Sterchele (60032846) to give her access to view ALL parks receipts and expenditures in MC concessions
*/
if ($level == 1 AND $beacnum <> '60032846')
// 2-10-2022: END JCarter & CCooper
{
   $query5a="select dist as 'districtS' from center where parkcode='$concession_location' and center like '1280%' ";
   // echo "<br />Line 374: query5a=$query5a<br />";
   $result5a=mysqli_query($connection,$query5a) or die ("Couldn't execute query 5a. $query5a");

   $row5a=mysqli_fetch_array($result5a);

   extract($row5a);

      $district_where=" and district='$districtS' ";
}

// Region Managers:  Fullwood, Greenwood, Mcelhone
if($beacnum=='60032912'){$district_where=" and district='east' ";}
if($beacnum=='60033019'){$district_where=" and district='south' ";}
if($beacnum=='60032913'){$district_where=" and district='west' ";}
if($beacnum=='65030652'){$district_where=" and district='north' ";}


$query5 = "SELECT parkcode,
                  center,
                  center_description,
                  f_year,
                  total_markup2 AS 'target_markup',
                  SUM( disburse_amt ) AS  'expenditures',
                  SUM( receipt_amt ) AS  'receipts',sum(disburse_target) as 'disburse_target',sum(receipt_target) as 'receipt_target', ROUND( (
(
SUM( receipt_amt ) / SUM( disburse_amt ) ) *10000
), 0
) AS  'receipt_percent'
FROM report_budget_history_inc_stmt_by_fyear_pfr
WHERE f_year =  '$fyear'
$where_scope
$district_where
GROUP BY center
order by parkcode asc";



////echo "<font color='brown'>query5=$query5<br /><br />Query 5 from PHP: <br /><b>park_inc_stmts_by_fyear_v2.php (Line: 381)</b></font>";   

// echo "In File: " . __FILE__ . "<br />On Line: " . __LINE__ . "<br />Print query5:<br />$query5";

$result5 = mysqli_query($connection,$query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);
$median_record=round($num5/2,0);
//echo "median_record=$median_record<br />";



echo "<br /><br />";
/*
   20220210-JGC: check marks on banners for reports being desplayed when initially landing on this script
*/
if($scope=='park'){$check_park="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>$num5";}

if($scope=='all'){$check_all="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>$num5";}

if($report_type=='all'){$report_all="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($report_type=='pfr'){$report_pfr="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

if($report_type=='receipt_detail'){$report_receipt_detail="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
/*
John Carter 2022-02-09 added 'or' clause to 'if' statement for HARI

Superintendent of HARI has become the Div Revenue Manager
- access needs to be given to see ALL parks and ALL centers
*/

if($level > 2 
   OR ($beacnum == '60032846'
      )
   )
{
echo "<table border='1' align='center'><tr><th>Park Receipts and Expenditures by Fiscal Year<br /></th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&report_type=$report_type&scope=park'>Park<br />Centers</a><br />$check_park</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&report_type=$report_type&scope=all'>All<br />Centers</a> <br />$check_all</th></tr></table>";
}

if($level < 3 and $beacnum <> '60032846')
{
echo "<table border='1' align='center'><tr><th>Park Receipts and Expenditures by Fiscal Year<br /></th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&report_type=$report_type&scope=park'>Park<br />Centers</a><br />$check_park</th></tr></table>";
}



if($level > 2
   OR ($beacnum == '60032846'
      )
   )
{
echo "<br /><table border='1' align='center'><tr><th>Report Type</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&scope=$scope&report_type=all'>ALL</a><br />$report_all</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&scope=$scope&report_type=pfr'>Retail</a> <br />$report_pfr</th>";
}


if($level < 3 and $beacnum <> '60032846')
{
echo "<br /><table border='1' align='center'><tr><th>Report Type</th><th><a href='park_inc_stmts_by_fyear_v2.php?fyear=$fyear&scope=$scope&report_type=pfr'>Retail</a> <br />$report_pfr</th>";
}


echo "</tr></table>";


if($report_type=='pfr'){echo "<table align='center'><tr><th><img height='200' width='200' src='/budget/infotrack/icon_photos/mission_icon_photos_265.jpg' alt='cabe marina store'></img></th></tr></table>";}

if($report_type=='pfr'){include("../../budget/infotrack/slide_toggle_procedures_module2_pid79.php");}



include ("inc_stmt_by_fyear_head1_v2.php");

// accounting specialist (bass)  budget officer (dodd) concessions manager (gallagher)
if($beacnum=='60032793' or $beacnum=='60032781' or $beacnum=='60033162')
{


$query_update_info="select update_by,last_update from report_budget_history_inc_stmt_by_fyear_pfr where f_year='$fyear' order by last_update desc limit 1";

//echo "query_update_info=$query_update_info<br />";
//echo "scope = $scope<br />";
//echo "report_type = $report_type";
$result_update_info=mysqli_query($connection,$query_update_info) or die ("Couldn't execute query update_info. $query_update_info");

$row_update_info=mysqli_fetch_array($result_update_info);

extract($row_update_info);

$update_by=substr($update_by,0,-2);

//echo "<br />last_update=$last_update<br />";
//echo "<br />update_by=$update_by<br />";

if($update_by=='')
{

if($fyear==$cy)
{
echo "<br />";

if($tent_update=='y')
{
// verification that tentative budget has been established     
$check_tent_img="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
echo "<table align='center'><tr><th><br /><font class='cartRow'>Target Budgets</font> <br /> $check_tent_img  Last Update: $update_by ($last_update)</th></tr></table>";
}
else
{
// tentative budget has NOT been established
echo "<table align='center'><tr><td><a href='pfr_set_tentative_budget.php?fyear=$fyear&scope=$scope&report_type=$report_type'><font class='cartRow'>SET Tentative Budget</font></a></td></tr></table>";    
}

echo "<br />";
}
}

if($update_by != '')
{
echo "<table align='center'><tr><td><font class='cartRow'>Purchase4Resale Budgets</font></td><td><a href='park_inc_stmts_by_fyear_v2.php?scope=$scope&report_type=$report_type&fyear=$fyear&edit_mode=y'>Edit</a></td></tr></table>";  



}      

}




echo "<table border=1 align='center'>";

echo 

"<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>Center Name</font></th>";
  echo "<th align=left><font color=brown>Center</font></th>";
  echo "<th align=left><font color=brown>Fyear</font></th>";
  echo "<th align=left><font color=brown>(A)<br />Target Receipts</font></th>";
  echo "<th align=left><font color=brown>(B)<br />Target Expenses</font></th>";
  echo "<th align=left><font color=brown><br />(C)<br />Target Profit<br />(a-b)</font></th>";
   //echo "<th align=left><font color=brown>Target Markup<br />Multiple<br />(D)</font></th>";
  echo "<th align=left><font color=brown>(D)<br />Actual Receipts</font></th>";
  echo "<th align=left><font color=brown>(E)<br />Actual Expenses</font></th>";
  echo "<th align=left><font color=brown><br />(F)<br />Earned Profit<br />(d-e)</font></th>";
  echo "<th align=left><font color=brown><br />(G)<br />Earned Profit<br />% Progress<br />( F divided by C )</font></th>";
  echo "<th align=left><font color=brown>(H)<br />Target Markup</font></th>";
  //echo "<th align=left><font color=brown><br />(G)<br />Unearned Profit<br />(c-f)</font></th>";
  //echo "<th align=left><font color=brown>Profit<br />Progress%(I)</font></th>";
  
         
          
          
          
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";


while ($row=mysqli_fetch_array($result5)){


extract($row);

if($fyear >= '1819' and $receipts >= $receipt_target)
{
$flag1="<img height='25' width='25' src='/budget/infotrack/icon_photos/mission_icon_photos_254.png'></img>";    //park meets or exceeds budget for PFR (Green Flag)
       
       
}


if($fyear >= '1819' and $receipts < $receipt_target)
{
$flag1="<img height='25' width='25' src='/budget/infotrack/icon_photos/mission_icon_photos_255.png'></img>";    //park meets or exceeds budget for PFR (Red Flag)
       
       
}




/*
else
{

$flag1="<img height='25' width='25' src='/budget/infotrack/icon_photos/mission_icon_photos_255.png'></img>";    //park meets or exceeds budget for PFR (Red Flag)



}      

*/

$receipts_perc_progress=number_format($receipts/$receipt_target*100,0);
$receipts_perc_progress=$receipts_perc_progress.'%';

$profit_target=$receipt_target-$disburse_target;
$profit_actual=$receipts-$expenditures;
$profit_remaining=$profit_target-$profit_actual;
$profit_remaining2=number_format($profit_remaining,2);
$earned_profit_progress=round(($profit_actual/$profit_target)*100);
//if($earned_profit_progress < 0){$earned_profit_progress=0;}
$earned_profit_progress2=$earned_profit_progress.'%';

$profit_progress_percent=$profit_actual/$profit_target;
$profit_progress_percent2=number_format($profit_progress_percent*100,0);

$profit_target2=number_format($profit_target,2);


$profit_actual2=number_format($profit_actual,2);

$expenditures=number_format($expenditures,2);
$receipts=number_format($receipts,2);

$disburse_target=number_format($disburse_target,2);
$receipt_target=number_format($receipt_target,2);
$receipt_percent=number_format($receipt_percent/10000,2);


if($center=='1680513'){$receipt_percent_target=154;} else {$receipt_percent_target=200;}
$receipt_percent_target=number_format($receipt_percent_target/100,2);


/*
if($receipt_percent >= $receipt_percent_target)
{
$flag2="<img height='25' width='25' src='/budget/infotrack/icon_photos/mission_icon_photos_254.png'></img>";    //park meets or exceeds budget for PFR (Green Flag)
       
       
}
*/

if($fyear >= '1819' and $receipt_percent >= $receipt_percent_target)
{
$flag2="<img height='25' width='25' src='/budget/infotrack/icon_photos/mission_icon_photos_254.png'></img>";    //park meets or exceeds budget for PFR (Green Flag)
       
       
}


if($fyear >= '1819' and $receipt_percent < $receipt_percent_target)
{
$flag2="<img height='25' width='25' src='/budget/infotrack/icon_photos/mission_icon_photos_255.png'></img>";    //park meets or exceeds budget for PFR (Red Flag)
       
       
}



if($f_year < '1819')
{$receipt_target='not_available';$disburse_target='not_available';$profit_target2='not_available'; $profit_remaining2='not_available'; $earned_profit_progress2='not_available';}

if($f_year < '1819')
{$receipt_total2='not_available';$disburse_total2='not_available';$profit_target_total2='not_available';$profit_remaining_total2='not_available';$profit_progress_total_percent3='not_available';}



$rank=@$rank+1;
if($rank==$median_record){$median_receipt=$receipt_percent;}
$var_total_receipt+=$receipt_percent;


//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t>";

       //echo "<td>$category</td>";
          
 if($level==1 and $concession_location==$parkcode)
{

$park_check=" <img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";      
}
else
       
{
$park_check='';             
              
              
}

          
    //echo "<td><a href='park_posted_deposits_drilldown1_v2.php?f_year=$f_year&park=$park&center=$center'>$park</a></td>";
//     echo "<td>$rank</td>";      

if($edit_mode=='')
{
     echo "<td>$center_description (<a href='pfr_drilldown.php?fyearS=$f_year&centerS=$center&report_type=pfr&parkcodeS=$parkcode' target='_blank'>$parkcode</a>)</td>"; 
        echo "<td>$center</td>               
               <td>$f_year</td>
               <td>$receipt_target</td>
               <td>$disburse_target</td>
               <td>$profit_target2</td>
               ";
         // echo "<td>$receipt_percent_target</td>"; 
         echo "<td>$receipts</td>
               <td>$expenditures</td>
               <td>$profit_actual2</td>
               <td>$earned_profit_progress2</td>
               <td>$target_markup</td>
               ";
}                            

if($edit_mode=='y')
{
        echo "<form action='pfr_target_budget_update.php'>";
     echo "<td>$center_description (<a href='pfr_drilldown.php?fyearS=$f_year&centerS=$center&report_type=pfr&parkcodeS=$parkcode' target='_blank'>$parkcode</a>)</td>"; 
        echo "<td>$center</td>               
           <td>$f_year</td>";




echo " <td><input type='text' name='receipt_target' value='$receipt_target'></td>";
echo "<td>$disburse_target</td>";  
echo "<td>$profit_target2</td>";   
//echo "<td>$receipt_percent_target</td>";       
   
echo " <td>$receipts</td>";
echo "<td>$expenditures</td>";     
echo "<td>$profit_actual2</td>";                         
echo "<td>$earned_profit_progress2</td>";
echo " <td><input type='text' name='target_markup' value='$target_markup'></td>";
echo "<td>";
echo "<input type='hidden' name='center' value='$center'>";
echo "<input type='hidden' name='parkcode' value='$parkcode'>";
echo "<input type='hidden' name='fyear' value='$f_year'>";
echo "<input type='submit' name='submit' value='Update'>";
echo "</td>";
echo "</form>";
}                   
                      
           
echo "</tr>";




}

$var_park_average=$var_total_receipt/$num5;
$var_park_average2=number_format($var_park_average,0);

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 



"<tr$t> 

               

              
          
           <td>Totals</td>  
           <td></td>        

           <td></td>        
           
          <td>$receipt_total2</td>
         <td>$disburse_total2</td> 
          <td>$profit_target_total2</td>
          <td>$total_receipts2</td>
                <td>$total_expenses2</td>
                <td>$profit_actual_total2</td>
                <td>$profit_progress_total_percent3</td>";
               //echo "<td>$profit_remaining_total2</td>";
                       
                
// echo "<td>$receipt_percent_total (Division)<br />$var_park_average2 (Park Avg)<br />$median_receipt (Park Med)</td>"; 
          

          
           
           

                       

echo "</tr>";



//}
//}

 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 }
 
 
 if($report_type=='receipt_detail')
{
if($scope=='park'){$where_scope=" and scope='park' ";}



//if($level>1)

{


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
$result5 = mysqli_query($connection,$query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);
$median_record=round($num5/2,0);
//echo "median_record=$median_record<br />";


if($level>1 or ($beacnum == '60032846'))
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

               
$result6 = mysqli_query($connection,$query6) or die ("Couldn't execute query 6.  $query6");

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

//echo "<pre>";print_r($_SESSION);"</pre>";  exit;

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
           <td>$total_receipts</td>"; 
                 
                 
//  echo "<td>$receipt_percent_total (Division)<br />$var_park_average2 (Park Avg)<br />$median_receipt (Park Med)</td>"; 
          

          
           
           

                       

echo "</tr>";



//}
//}

 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 }
 
 
 
 echo "</body></html>";


 






?>